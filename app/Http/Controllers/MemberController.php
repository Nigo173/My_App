<?php

namespace App\Http\Controllers;

// use Illuminate\Http\UploadedFile;
// use Illuminate\Support\Facades\Storage;
// use Symfony\Component\HttpFoundation\File\File;
use App\Models\MemberModel;
use App\Models\AdminsModel;
use App\Models\LogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Exception;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $permissions = $this->get_Permissions();
        return view('member', ['permissions' => $permissions]);
    }

    private function random_str(): string
    {
        $array = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $randomItems = Arr::random($array).Arr::random($array).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9);
        return $randomItems;
    }

    private function get_random_Id(): string
    {
        $data = new MemberModel();
        $random_Id = $this->random_str();

        for($i = 0; $i < 1000; $i++)
        {
            if(!$data->where('m_Id', $random_Id)->exists())
            {
                break;
            }

            $random_Id = random_str();
        }

        return $random_Id;
    }

    public function list(Request $request, string $action = 'member_list', $msg = null)
    {
        try
        {
            $MemberModel = new MemberModel();

            if($request->isMethod('post') && isset($request->Id) && $request->Id != '' && $msg == null) // Id
            {
                $member = $MemberModel->where('m_Id', $request->Id)->get()->first();
                return view('member_list', ['action' => $action, 'data' => $member]);
            }
            else if($request->isMethod('get') && isset($request->search) && $request->search != '' && $msg == null) // Like
            {
                $member = $MemberModel->where('m_CardId', 'like', '%'.$request->search.'%')
                ->orWhere('m_Name', 'like', '%'.$request->search.'%')
                ->limit(100)->reorder('updated_at', 'desc')->get();
                return view('member_list', ['action' => 'member_list', 'member' => $member]);
            }
            // ALL
            $member = $MemberModel->limit(50)->reorder('updated_at', 'desc')->get();
            return view('member_list', ['action' => $action, 'member' => $member, 'msg' => $msg]);
        }
        catch(Exception $e)
        {
            return view('member_list', ['msg' => '搜尋異常錯誤']);
        }
    }

    public function create(Request $request)
    {
        $request->except(['msg']);
        $msg = '';

        // 會員編號
        $count = MemberModel::max('m_Id') + 1;
        $Id = sprintf('%06d', $count);

        if($request->isMethod('post'))
        {
            try
            {
                $img = '';

                if($request->file('img') != null)
                {
                    // $image_size = $_FILES["inputfilename"]["size"];
                    // /*Not From Form*/
                    // $img_size = getimagesize("imagepath");

                    // $img_size = getimagesizefromstring(file_get_contents($request->file('img')->path()));
                    // dd($img_size);
                    // $encode_Img = base64_encode(file_get_contents($request->file('img')->path()));

                    // $size_in_bytes = (int) (strlen(rtrim($encode_Img, '=')) * 3 / 4);
                    // $size_in_kb    = $size_in_bytes / 1024;
                    // $size_in_mb    = round(($size_in_kb / 1024),1);

                    // if($size_in_mb > 2)
                    // {
                    //     return view('member_list', ['action' => 'member_create', 'msg' => '圖片大於2MB、請壓縮圖片']);
                    // }

                    // $img = "data:image/png;base64,". $encode_Img;

                    $img = $this->get_Image($request->file('img')->path());

                    if(strlen($img) < 10)
                    {
                        $msg = "圖片大於2MB、請壓縮圖片";

                        // return view('member_list', ['action' => 'member_create', 'msg' => '圖片大於2MB、請壓縮圖片']);
                        return response()->json(['action'=>'list','msg'=>$msg]);
                    }
                }

                // $q->select('m_CardId')->where('m_CardId', $request->cardId)->get();
                // MemberModel::select('m_CardId')->where('m_CardId', $request->cardId)->get()->toArray()

                $data = MemberModel::where('m_CardId', $request->cardId)->get()->first();
                // $data = MemberModel::whereIn('m_CardId', MemberModel::select('m_CardId')->where('m_CardId', $request->cardId)->get()->toArray())->get();

                if(isset($data->m_CardId))
                {
                    $msg = "身分證號已存在";
                    // return redirect()->back()->withInput();
                    // return redirect()->route('member_list?msg=身分證號已存在', ['action' => 'member_create', 'msg' => $msg])->withInput();
                    // return view('member_list', ['action' => 'member_create', 'msg' => $msg]);
                    return response()->json(['action'=>'list','msg'=>$msg]);
                }

                // 會員編號
                // $id = $this->get_random_Id();

                $data = MemberModel::create([
                    'm_Id'=>$Id,
                    'm_CardId'=>$request->cardId,
                    'm_Name'=>$request->name,
                    'm_Birthday'=>$request->birthday,
                    'm_Address'=>$request->address,
                    'm_Email'=>$request->email,
                    'm_Phone'=>$request->phone,
                    'm_Img'=>$img,
                    'm_Remark'=>$request->remark
                ]);

                if($data->save())
                {
                    $msg = "新增成功";
                    $this->create_Log($request, $msg);
                    // return $this->list($request, 'member_list', $msg);
                    return response()->json(['action'=>'list','msg'=>$msg]);
                }
                else
                {
                    $msg = "新增失敗";
                    $this->create_Log($request, $msg);
                    // return view('member_list', ['action' => 'member_create', 'msg' => $msg]);
                    return response()->json(['action'=>'create','msg'=>$msg]);
                }
            }
            catch(Exception $e)
            {
                return view('error');
            }
        }
        return view('member_list', ['action' => 'member_create', 'Id' => $Id]);
    }

    public function update(Request $request)
    {
        $request->except(['msg']);
        $msg = '';

        if(isset($request->Id) && $request->Id != '' && isset($request->update))
        {
            try
            {
                $img = $request->oldImg;

                if($request->file('img') != null)
                {
                    $img = $this->get_Image($request->file('img')->path());

                    if(strlen($img) < 10)
                    {
                        return view('member_list', ['action' => 'member_update', 'msg' => '圖片大於2MB、請壓縮圖片']);
                    }
                }

                $data = MemberModel::where('m_Id', $request->Id)->update([
                    'm_CardId'=>$request->cardId,
                    'm_Name'=>$request->name,
                    'm_Birthday'=>$request->birthday,
                    'm_Address'=>$request->address,
                    'm_Email'=>$request->email,
                    'm_Phone'=>$request->phone,
                    'm_Img'=>$img,
                    'm_Remark'=>$request->remark
                ]);

                $msg = "編輯成功";

                if(!$data)
                {
                    $msg = "編輯失敗";
                }
                $this->create_Log($request, $msg);
            }
            catch(Exception $e)
            {
                return view('error');
            }
            return response()->json(['action'=>'update','msg'=>$msg]);
        }
        return $this->list($request, 'member_update', $msg);
    }

    public function delete(Request $request)
    {
        $request->except(['msg']);
        $msg = '';

        if(isset($request->Id) && $request->Id != '' && isset($request->delete))
        {
            try
            {
                $data = MemberModel::where('m_Id', $request->Id)->delete();
                $msg = "刪除失敗";

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
        return $this->list($request, 'member_delete', $msg);
    }

    private function get_Permissions(): string
    {
        $admin = new AdminsModel();
        $data = $admin->where('a_Id', session('Account'))->get()->first();

        if(isset($data->a_Permissions))
        {
            $arr = explode(',', $data->a_Permissions);
            $permissions = '';

            foreach($arr as $data)
            {
                $data = explode('_', $data);

                if(count($data) > 0)
                {
                    if($data[0] == 'member')
                    {
                        $permissions = $data[1];
                        break;
                    }
                }
            }
            return $permissions;
        }
        return redirect()->route('login');
    }

    private function get_Image(string $img): string
    {
        $encode_Img = base64_encode(file_get_contents($img));

        $size_in_bytes = (int) (strlen(rtrim($encode_Img, '=')) * 3 / 4);
        $size_in_kb    = $size_in_bytes / 1024;
        $size_in_mb    = round(($size_in_kb / 1024),1);

        if($size_in_mb > 2)
        {
            return ''.$size_in_mb;
        }

        return "data:image/png;base64,". $encode_Img;
    }

    private function create_Log(Request $request, string $note)
    {
        $note = session('Account').'執行 => (會員帳號:'.$request->Id.' 會員姓名: '.$request->name.')'.$note;
        $mac = strtok(exec('getmac'), ' ');
        $url = $request->getRequestUri();
        $data = 'MAC: '.$mac.' URL: '.$url.' NOTE: '.$note;
        LogModel::create(['log' => $data]);
    }
}
