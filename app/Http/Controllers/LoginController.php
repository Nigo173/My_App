<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Middleware\AuthMiddleware;
use App\Models\AdminsModel;
use App\Models\LogModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Exception;

// use App\Http\Middleware\LogMiddleware;

class LoginController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(LogMiddleware::class);
    // }

    public function index(Request $request)
    {
        if($request->session()->has('Account'))
        {
            $request->session()->flush();
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $msg = '登入成功';

        try
        {
            $admins = new AdminsModel();
            $hashedpassword = md5($request->password);
            $data = $admins->where('a_Id', $request->account)->where('a_PassWord', $hashedpassword)->get()->first();

            if(isset($data->a_Id))
            {
                $request->session()->put('Account', $data->a_Id);
                $request->session()->put('Name', $data->a_Name);
                $request->session()->put('Mac', $data->a_Mac);
                $request->session()->put('Permissions', $data->a_Permissions);
                $request->session()->put('Level', $data->a_Level);

                if($data->a_State == '0')
                {
                    $msg = '帳號停權';
                    return view('login', ['err' => $msg]);
                }

                //$mac = strtok(exec('getmac'), ' ');
               // $data = AdminsModel::where('a_Id', $request->account)->update([
                    //'a_Mac' => ' '
               // ]);
            }
            else
            {
                $msg = '登入失敗';
            }
            
            $this->create_Log($request, $msg);
            return response()->json(['action'=>'login','msg'=>$msg]);
        }
        catch(Exception $e)
        {
            return view('error');
        }

        return response()->json(['action'=>'dashboard','msg'=>'登入成功']);
    }

    public function logout(Request $request)
    {
        $this->delete_Log();
        $msg = '登出';
        $this->create_Log($request, $msg);
        $request->session()->flush();
        return redirect()->route('login');
    }

    private function create_Log(Request $request, string $note)
    {
        $mac = '';
        $url = '';
        
        try
        {
            $note = session('Account').' '.session('Name').' '.$note;
            //$mac = strtok(exec('getmac'), ' ');
            $url = $request->getRequestUri();
        }
        catch(Exception $e){}

        $data = 'MAC: '.$mac.' URL: '.$url.' NOTE: '.$note;
        LogModel::create(['log' => $data]);
    }

    private function delete_Log()
    {
        try
        {
            LogModel::where('created_at', '<',DB::raw('DATE_SUB(NOW(), INTERVAL 14 DAY)'))->delete();
        }
        catch(Exception $e){}
    }
}
