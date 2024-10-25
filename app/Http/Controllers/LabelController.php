<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogModel;
use App\Models\LabelModel;
use App\Models\TradeModel;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Exception;

class LabelController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $LabelModel = new LabelModel();

            if(isset($request->search) && $request->search != '' && $request->isMethod('get'))
            {
                $label = $LabelModel->Where('l_TitleOne', $request->search)->get();
                return view('label', ['label' => $label]);
            }
            else if(isset($request->Id) && $request->Id != '' && $request->isMethod('post'))
            {
                $label = $LabelModel->Where('id', $request->Id)->get()->first();

                if(isset($label->id))
                {
                    return view('label', ['data' => $label, 'action' => 'label_update']);
                }

                return view('label', ['msg' => '搜尋無此標籤']);
            }
            else if(isset($request->create))
            {
                $id = $this->get_random_Id();

                return view('label', ['action' => 'label_create', 'lId' => $id]);
            }
            // ALL
            $label = $LabelModel->limit(8)->reorder('updated_at', 'desc')->get();
            return view('label', ['label' => $label]);
        }
        catch(Exception $e)
        {
            return view('label', ['msg' => '搜尋異常錯誤']);
        }
    }

    private function random_str(): string
    {
        $array = ['A','B','C','D','E','F','G','H'];
        $randomItems = Arr::random($array).Arr::random($array).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9);
        return $randomItems;
    }

    private function get_random_Id(): string
    {
        $data = new LabelModel();
        $random_Id = $this->random_str();

        for($i = 0; $i < 500; $i++)
        {
            if(!$data->where('l_Id', $random_Id)->exists())
            {
                break;
            }

            $random_Id = random_str();
        }

        return $random_Id;
    }

    public function create(Request $request)
    {
        $request->except(['msg']);
        $msg = "建立標籤成功";
        $LabelModel = new LabelModel();

        if(isset($request->title) && $request->title != '' && $request->isMethod('post'))
        {
            try
            {
                $count = $LabelModel->where('id', '>', 0)->get();

                if($count->count() > 8)
                {
                    $msg = "標籤數量異常";
                    $label = $LabelModel->limit(8)->reorder('updated_at', 'desc')->get();
                    return response()->json(['action'=>'label','msg'=>$msg]);
                }

                //隨機編號
                $lId = $this->get_random_Id();

                $data = $LabelModel->create([
                    'l_Id'=>$lId,
                    'l_Title'=>$request->title,
                    'l_TitleOne'=>$request->titleOne,
                    'l_TitleTwo'=>$request->titleTwo,
                    'l_TitleThree'=>$request->titleThree,
                    'l_TitleFour'=>$request->titleFour
                ]);

                if($data->save())
                {
                    $msg = "建立標籤成功";
                }
                else
                {
                    $msg = "建立標籤失敗";
                }
                $this->create_Log($request, $msg);

                return response()->json(['action'=>'label','msg'=>$msg]);
            }
            catch(Exception $e)
            {
                return view('error');
            }
        }
        // ALL
        $label = $LabelModel->limit(8)->reorder('updated_at', 'desc')->get();
        return view('label', ['label' => $label, 'msg' => $msg]);
    }

    public function update(Request $request)
    {
        $request->except(['msg']);
        $msg = '';
        $LabelModel = new LabelModel();

        if(isset($request->Id) && $request->Id != '' && $request->isMethod('post'))
        {
            try
            {
                $data = $LabelModel->where('id', $request->Id)->update([
                    'l_Title'=>$request->title,
                    'l_TitleOne'=>$request->titleOne,
                    'l_TitleTwo'=>$request->titleTwo,
                    'l_TitleThree'=>$request->titleThree,
                    'l_TitleFour'=>$request->titleFour
                ]);

                $msg = '編輯標籤成功';

                if(!$data)
                {
                    $msg = "編輯標籤失敗";
                }

                $this->create_Log($request, $msg);
            }
            catch(Exception $e)
            {
                return view('error');
            }
            return response()->json(['action'=>'label','msg'=>$msg]);
        }
        // ALL
        $label = $LabelModel->limit(8)->reorder('updated_at', 'desc')->get();
        return view('label', ['label' => $label, 'msg' => $msg]);
    }

    private function create_Log(Request $request, string $note)
    {
        $mac = '';
        $url = '';

        try
        {
            $note = session('Account').'執行 => '.$note;
            $mac = strtok(exec('getmac'), ' ');
            $url = $request->getRequestUri();
        }
        catch(Exception $e){}
        
        $data = 'MAC: '.$mac.' URL: '.$url.' NOTE: '.$note;
        LogModel::create(['log' => $data]);
    }
}
