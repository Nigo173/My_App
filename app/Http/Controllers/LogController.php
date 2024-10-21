<?php

namespace App\Http\Controllers;
use App\Models\LogModel;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // if($request->isMethod('post') && isset($request->search) && $request->search != '')
        // {
        //     try
        //     {
        //         $log = new LogModel();
        //         $data = $log->where('log', 'like', '%'.$request->search.'%')->limit(100)->reorder('updated_at', 'desc')->get();
        //         return view('log', ['log' => $data]);
        //     }
        //     catch(DecryptException $e)
        //     {
        //         return view('error');
        //     }
        // }

        // $log = LogModel::limit(50)->reorder('updated_at', 'desc')->get();
        // return view('log', ['log' => $log]);
        try
        {
            $LogModel = new LogModel();

            if($request->isMethod('get') && isset($request->search) && $request->search != '') // Like
            {
                $log = $LogModel->where('log', 'like', '%'.$request->search.'%')
                ->limit(100)->reorder('updated_at', 'desc')->get();
                return view('log', ['log' => $log]);
            }

            // ALL
            $log = $LogModel->limit(100)->reorder('updated_at', 'desc')->get();
            return view('log', ['log' => $log]);
        }
        catch(DecryptException $e)
        {
            return view('log', ['msg' => '搜尋異常錯誤']);
        }
    }

    public function delete(Request $request)
    {
        $request->except(['msg']);
        $msg = '';

        if(isset($request->Id) && $request->Id != '' && isset($request->delete))
        {
            try
            {
                $data = LogModel::where('id', $request->Id)->delete();

                $msg = "刪除成功";

                if(!$data)
                {
                    $msg = "刪除失敗";
                }
                unset($_POST);
            }
            catch(DecryptException $e)
            {
                return view('error');
            }
        }
        $log = LogModel::limit(50)->reorder('updated_at', 'desc')->get();
        return view('log', ['log' => $log,'msg' => $msg]);
    }
}
