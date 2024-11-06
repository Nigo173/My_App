<?php

namespace App\Http\Controllers;
use App\Models\LogModel;
use App\Models\TradeModel;
use App\Models\MemberModel;
use App\Models\AdminsModel;
use App\Models\DashboardModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $TradeModel = new TradeModel();
            $trade = null;

            if($request->isMethod('get') && (isset($request->selectShift) && $request->selectShift != '') ||
            (isset($request->selectMonth) && $request->selectMonth != '') || (isset($request->selectYear) && $request->selectYear != '')) // Like
            {
                $from = '0000';
                $to = '0800';

                if($request->selectShift == '早班')
                {
                    $from = '0800';
                    $to = '1600';
                }
                else if($request->selectShift == '中班')
                {
                    $from = '1600';
                    $to = '2400';
                }

                if($request->selectShift != '' && $request->selectMonth == '' && $request->selectYear == '' && $request->selectDay == '')
                {
                    $trade = $TradeModel->select('trade.*','label.l_Title','label.l_TitleOne','label.l_TitleTwo','label.l_TitleThree','label.l_Current')
                    ->leftJoin('label', 'label.l_Id', '=', 'trade.t_lId')
                    ->whereBetween(DB::raw('DATE_FORMAT(trade.created_at, "%H%i")'), [$from, $to]);
                }
                else if($request->selectShift == '' && $request->selectMonth != '' && $request->selectYear == '' && $request->selectDay == '')
                {
                    $trade = $TradeModel->select('trade.*','label.l_Title','label.l_TitleOne','label.l_TitleTwo','label.l_TitleThree','label.l_Current')
                    ->leftJoin('label', 'label.l_Id', '=', 'trade.t_lId')
                    ->whereMonth('trade.created_at', $request->selectMonth);
                }
                else if($request->selectShift == '' && $request->selectMonth == '' && $request->selectYear != '' && $request->selectDay == '')
                {
                    $trade = $TradeModel->select('trade.*','label.l_Title','label.l_TitleOne','label.l_TitleTwo','label.l_TitleThree','label.l_Current')
                    ->leftJoin('label', 'label.l_Id', '=', 'trade.t_lId')
                    ->whereYear('trade.created_at', ((int)$request->selectYear) + 1911);
                }
                else if($request->selectShift != '' && $request->selectMonth == '' && $request->selectYear != '' && $request->selectDay == '')
                {
                    $trade = $TradeModel->select('trade.*','label.l_Title','label.l_TitleOne','label.l_TitleTwo','label.l_TitleThree','label.l_Current')
                    ->leftJoin('label', 'label.l_Id', '=', 'trade.t_lId')
                    ->whereBetween(DB::raw('DATE_FORMAT(trade.created_at, "%H%i")'), [$from, $to])
                    ->whereYear('trade.created_at', ((int)$request->selectYear) + 1911);
                }
                else if($request->selectShift != '' && $request->selectMonth != '' && $request->selectYear != '' && $request->selectDay == '')
                {
                    $trade = $TradeModel->select('trade.*','label.l_Title','label.l_TitleOne','label.l_TitleTwo','label.l_TitleThree','label.l_Current')
                    ->leftJoin('label', 'label.l_Id', '=', 'trade.t_lId')
                    ->whereBetween(DB::raw('DATE_FORMAT(trade.created_at, "%H%i")'), [$from, $to])
                    ->whereMonth('trade.created_at', $request->selectMonth)
                    ->whereYear('trade.created_at', ((int)$request->selectYear) + 1911);
                }
                else if($request->selectShift == '' && $request->selectMonth != '' && $request->selectYear != '' && $request->selectDay == '')
                {
                    $trade = $TradeModel->select('trade.*','label.l_Title','label.l_TitleOne','label.l_TitleTwo','label.l_TitleThree','label.l_Current')
                    ->leftJoin('label', 'label.l_Id', '=', 'trade.t_lId')
                    ->whereMonth('trade.created_at', $request->selectMonth)
                    ->whereYear('trade.created_at', ((int)$request->selectYear) + 1911);
                }
                else if($request->selectShift == '' && $request->selectMonth != '' && $request->selectYear != '' && $request->selectDay != '')
                {
                    $trade = $TradeModel->select('trade.*','label.l_Title','label.l_TitleOne','label.l_TitleTwo','label.l_TitleThree','label.l_Current')
                    ->leftJoin('label', 'label.l_Id', '=', 'trade.t_lId')
                    ->whereDay('trade.created_at', $request->selectDay)
                    ->whereMonth('trade.created_at', $request->selectMonth)
                    ->whereYear('trade.created_at', ((int)$request->selectYear) + 1911);
                }
                else if($request->selectShift != '' && $request->selectMonth != '' && $request->selectYear != '' && $request->selectDay != '')
                {
                    $trade = $TradeModel->select('trade.*','label.l_Title','label.l_TitleOne','label.l_TitleTwo','label.l_TitleThree','label.l_Current')
                    ->leftJoin('label', 'label.l_Id', '=', 'trade.t_lId')
                    ->whereBetween(DB::raw('DATE_FORMAT(trade.created_at, "%H%i")'), [$from, $to])
                    ->whereDay('trade.created_at', $request->selectDay)
                    ->whereMonth('trade.created_at', $request->selectMonth)
                    ->whereYear('trade.created_at', ((int)$request->selectYear) + 1911);
                }
            }
        
            if($trade != null)
            {
                if($request->cardId != '')
                {
                    $trade = $trade->Where('trade.t_mCardId', $request->cardId);
                }
                $trade = $trade->limit(1000)->reorder('trade.created_at', 'desc')->get();
            }
            else
            {
                $trade = $TradeModel->select('trade.*','label.l_Title','label.l_TitleOne','label.l_TitleTwo','label.l_TitleThree','label.l_Current')
                ->leftJoin('label', 'label.l_Id', '=', 'trade.t_lId')
                ->limit(25)->reorder('trade.created_at', 'desc')->get();
            }

            return view('dashboard', ['trade'=>$trade]);
        }
        catch(Exception $e)
        {
            return view('error');
        }

    }

    public function update(Request $request)
    {
        if(session('Level') == '2')
        {
            $request->except(['msg']);
            $msg = '編輯失敗';

            if(isset($request->tId) && $request->tId != '')
            {
                try
                {  
                    $data = TradeModel::where('t_Id', $request->tId)->update([
                        't_Print'=>0
                    ]);
    
                    if($data)
                    {
                        $msg = '編輯成功';
                    }

                    $this->create_Log($request, $msg);
                }
                catch(Exception $e)
                {
                    return view('error');
                }
            }
            return response()->json(['action'=>'dashboard','msg'=>$msg]);
        }
        return redirect()->route('logout');
    }

    private function create_Log(Request $request, string $note)
    {
        $mac = '';
        $url = '';

        try
        {
            $note = session('Account').'執行 => (交易編號:'.$request->tId.') '.$note;
            //$mac = strtok(exec('getmac'), ' ');
            $url = $request->getRequestUri();
        }
        catch(Exception $e){}

        $data = 'MAC: '.$mac.' URL: '.$url.' NOTE: '.$note;
        LogModel::create(['log' => $data]);
    }
}

