<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Middleware\AuthMiddleware;
use App\Models\AdminsModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
// use Illuminate\Support\Facades\Session;

// use App\Models\LoginModel;
// use Illuminate\Support\Facades\Auth;
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
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return view('login');
    }

    public function login(Request $request)
    {
        // Validate
        // $fields = $request->validate([
        //     'account' => ['required', 'min:5', 'max:10'],
        //     'password' => ['required', 'min:3', 'max:20']
        // ]);
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
                    return view('login', ['err' => '帳號停權']);
                }

                $mac = trim(substr(shell_exec('getmac'), 159, 20));
                $data = AdminsModel::where('a_Id', $request->account)->update([
                    'a_Mac' => $mac,
                ]);

                if(!$data)
                {
                    return view('login', ['err' => '更新失敗']);
                }
            }
            else
            {
                return view('login', ['err' => '登入失敗']);
            }
        }
        catch(DecryptException $e)
        {
            return view('error');
        }
        
        return redirect()->route('dashboard');

        // print_r($request->all());
        // AdminsModel::create(['a_Id' => 'C12345','a_PassWord' => '123', 'a_Name' => 'Nikki']);

        // $data = $request->session()->all();
        // $data = $request->session()->only(['username', 'email']);
        // $data = $request->session()->except(['username', 'email']);

        // session(['key' => 'value']);

        // Load Value

        // $user =  User::create(['a_Id'=>$request->account,'email'=>'12yu32','password'=>'11223']);
        // $data = LoginModel::create(['a_Id'=>'A12345','email'=>'A12345@yahoo.com.tw','a_PassWord'=>'12345']);
        // dd($request->account);

        // Auth::login($user);
        // if(Auth::attempt($fields, ['Nigo'=>'ok']))
        // {
        //     return redirect()->intended('Home');
        // }
        // return redirect()->route('Home');
        // return back()->withErrors([ // 針對error 自定義
        //     'failed'=>'輸入錯誤...'
        // ]);
    }

    public function logout(Request $request)
    {
        // Session::flush();
        // Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // dd('sss');
        return redirect()->route('login');
    }
}
