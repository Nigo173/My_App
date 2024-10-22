<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Crypt;
use App\Models\LogModel;
use App\Models\AdminsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Exception;

class AdminsController extends Controller
{
    private $a_Permissions = '';

    public function index()
    {
        $permissions = $this->get_Permissions();
        return view('admins', ['permissions' => $permissions]);
    }

    public function list(Request $request, string $action = 'admins_list', $msg = null)
    {
        try
        {
            $AdminsModel = new AdminsModel();

            if($request->isMethod('post') && isset($request->Id) && $request->Id != '' && $msg == null) // Id
            {
                $admins = $AdminsModel->where('a_Id', $request->Id)->get()->first();
                $admins = $this->add_Permissions($admins, 'update');

                return view('admins_list', ['action' => $action, 'data' => $admins]);
            }
            else if($request->isMethod('get') && isset($request->search) && $request->search != '' && $msg == null) // Like
            {
                $admins = $AdminsModel->where('a_Id', 'like', '%'.$request->search.'%')
                ->orWhere('a_Name', 'like', '%'.$request->search.'%')
                ->limit(100)->reorder('updated_at', 'desc')->get();
                return view('admins_list', ['action' => 'admins_list', 'admin' => $admins]);
            }
            // ALL
            $admins = $AdminsModel->limit(100)->reorder('updated_at', 'desc')->get();
            $admins = $this->add_Permissions($admins, 'all');

            return view('admins_list', ['action' => $action, 'admin' => $admins, 'msg' => $msg]);
        }
        catch(Exception $e)
        {
            return view('admins_list', ['msg' => '搜尋異常錯誤']);
        }
    }

    public function create(Request $request)
    {
        $request->except(['msg']);
        $msg = '';

        if($request->isMethod('post'))
        {
            try
            {
                $hashedpassword = md5($request->password);
                $new_Permissions = $this->concat_Permissions($request->admins_Permissions, $request->member_Permissions);

                $data = AdminsModel::create([
                    'a_Id'=>$request->account,
                    'a_PassWord'=>$hashedpassword,
                    'a_Name'=>$request->name,
                    'a_Mac'=>$request->mac,
                    'a_Permissions'=>$new_Permissions,
                    'a_Level'=>$request->level,
                    'a_State'=>$request->state,
                ]);

                if($data->save())
                {
                    $msg = "新增成功";
                    $this->create_Log($request, $msg);
                    return response()->json(['action'=>'list','msg'=>$msg]);
                    // return $this->list($request, 'admins_list', $msg);
                }
                else
                {
                    $msg = "新增失敗";
                    $this->create_Log($request, $msg);
                    return response()->json(['action'=>'create','msg'=>$msg]);
                    // return view('admins_list', ['action' => 'admins_create', 'msg' => $msg]);
                }
            }
            catch(Exception $e)
            {
                return view('error');
            }
        }
        return view('admins_list', ['action' => 'admins_create', 'Id' => $this->get_random_Id()]);
    }

    private function get_random_Id(): string
    {
        $data = new AdminsModel();
        $random_Id = $this->random_str();

        for($i = 0; $i < 1000; $i++)
        {
            if(!$data->where('a_Id', $random_Id)->exists())
            {
                break;
            }

            $random_Id = random_str();
        }

        return $random_Id;
    }

    private function random_str(): string
    {
        $array = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $randomItems = Arr::random($array).Arr::random($array).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9);
        return $randomItems;
    }

    public function update(Request $request)
    {
        $request->except(['msg']);
        $msg = '';

        if(isset($request->Id) && $request->Id != '' && isset($request->update))
        {
            try
            {
                $new_Permissions = $this->concat_Permissions($request->admins_Permissions, $request->member_Permissions);
                $data = false;

                if(strlen($request->password) > 2)
                {
                    $hashedpassword = md5($request->password);

                    $data = AdminsModel::where('a_Id', $request->Id)->update([
                        'a_PassWord'=>$hashedpassword,
                        'a_Name'=>$request->name,
                        'a_Mac'=>$request->mac,
                        'a_Permissions'=>$new_Permissions,
                        'a_Level'=>$request->level,
                        'a_State'=>$request->state,
                    ]);
                }
                else
                {
                    $data = AdminsModel::where('a_Id', $request->Id)->update([
                        'a_Name'=>$request->name,
                        'a_Mac'=>$request->mac,
                        'a_Permissions'=>$new_Permissions,
                        'a_Level'=>$request->level,
                        'a_State'=>$request->state,
                    ]);
                }

                $msg = "編輯失敗";

                if($data)
                {
                    $msg = "編輯成功";
                    $request->session()->put('id', $request->Id);
                }

                $this->create_Log($request, $msg);

                if(session('Account') == $request->Id)
                {
                    $request->session()->put('Name', $request->name);
                }
            }
            catch(Exception $e)
            {
                return view('error');
            }
            return response()->json(['action'=>'update','msg'=>$msg]);
        }
        return $this->list($request, 'admins_update', $msg);
    }

    public function delete(Request $request)
    {
        $request->except(['msg']);
        $msg = '';

        if(isset($request->Id) && $request->Id != '' && isset($request->delete))
        {
            try
            {
                $data = AdminsModel::where('a_Id', $request->Id)->delete();
                $msg = " 刪除失敗";

                if($data)
                {
                    $msg = "刪除成功";
                    $request->session()->put('id', $request->Id);
                }

                $this->create_Log($request, $msg);
            }
            catch(Exception $e)
            {
                return view('error');
            }
            return response()->json(['action'=>'delete','msg'=>$msg]);
        }
        return $this->list($request, 'admins_delete', $msg);
    }

    private function get_Permissions(): string
    {
        $admin = new AdminsModel();
        $data = $admin->where('a_Id', session('Account'))->get()->first();

        if(isset($data->a_Permissions))
        {
            $permissions_Array = explode(',', $data->a_Permissions);
            $permissions = '';

            foreach($permissions_Array as $data)
            {
                $data = explode('_', $data);

                if(count($data) > 0)
                {
                    if($data[0] == 'admins')
                    {
                        $permissions = $data[1];
                        break;
                    }
                }
            }
            return $permissions;
        }
        return view('login');
    }

    private function concat_Permissions($admins_Permissions, $member_Permissions): string
    {
        $new_Permissions_Array = array();

        if($member_Permissions != null)
        {
            $member_Permissions = implode('', $member_Permissions);
            $new_Permissions_Array = Arr::prepend($new_Permissions_Array, 'member_'.$member_Permissions);
        }

        if($admins_Permissions != null)
        {
            $admins_Permissions = implode('', $admins_Permissions);
            $new_Permissions_Array = Arr::prepend($new_Permissions_Array, 'admins_'.$admins_Permissions);
        }

        return implode(',', $new_Permissions_Array);
    }

    private function add_Permissions($admin, $page)
    {
        if($page == 'all')
        {
            $title = ['c' => '新增', 'r' => '查詢', 'u' => '編輯','d' => '刪除'];

            foreach($admin as $indexs => $data)
            {
                $permissions_Array = explode(',', $data->a_Permissions);

                foreach($permissions_Array as $index => $val)
                {
                    $data_Key = explode('_', $val);

                    if(strlen($data_Key[0]) > 0)
                    {
                        if($data_Key[0] == 'admins')
                        {
                            $data_Val = str_split($data_Key[1]);
                            $data->admins_Permissions = '系統管理:';

                            foreach($title as $k => $v)
                            {
                                foreach($data_Val as $kk)
                                {
                                    if($k == $kk)
                                    {
                                        $data->admins_Permissions .= $v.'、';
                                    }
                                }
                            }
                            $data->admins_Permissions = mb_substr($data->admins_Permissions, 0, -1, 'utf8');
                        }

                        if($data_Key[0] == 'member')
                        {
                            $data_Val = str_split($data_Key[1]);
                            $data->member_Permissions = '會員管理:';

                            foreach($title as $k => $v)
                            {
                                foreach($data_Val as $kk)
                                {
                                    if($k == $kk)
                                    {
                                        $data->member_Permissions .= $v.'、';
                                    }
                                }
                            }
                            $data->member_Permissions = mb_substr($data->member_Permissions, 0, -1, 'utf8');
                        }
                    }
                }

                $permissions_Array = explode(',', session('Permissions'));

                foreach($permissions_Array as $index => $val)
                {
                    $data_Key = explode('_', $val);
                    $data_Val = str_split($data_Key[1]);

                    if($data_Key[0] == 'admins')
                    {
                        $data->session_Admins_Permissions = $val;
                    }

                    if($data_Key[0] == 'member')
                    {
                        $data->session_Member_Permissions = $val;
                    }
                }
            }
        }
        else
        {
            $permissions_Array = explode(',', $admin->a_Permissions);

            foreach($permissions_Array as $index => $val)
            {
                $data_Key = explode('_', $val);

                if(strlen($data_Key[0]) > 0)
                {
                    if($data_Key[0] == 'admins')
                    {
                        $admin->admins_Permissions = $permissions_Array[$index];
                    }

                    if($data_Key[0] == 'member')
                    {
                        $admin->member_Permissions = $permissions_Array[$index];
                    }
                }
            }
        }
        return $admin;
    }

    private function create_Log(Request $request, string $note)
    {
        $note = session('Account').'執行 => (會員帳號:'.$request->Id.' 會員姓名: '.$request->name.')'.$note;
        // $mac = strtok(exec('getmac'), ' ');
        // $url = $request->getRequestUri();
        $mac = '';
        $url = '';
        $data = 'MAC: '.$mac.' URL: '.$url.' NOTE: '.$note;
        LogModel::create(['log' => $data]);
    }
}
