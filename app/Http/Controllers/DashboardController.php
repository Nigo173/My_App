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
            $alldata = null;

            if($request->isMethod('get') && (isset($request->selectShift) && $request->selectShift != '') ||
            (isset($request->selectMonth) && $request->selectMonth != '') || (isset($request->selectYear) && $request->selectYear != '') || (isset($request->cardId) && $request->cardId != '')) // Like
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

                $trade = $TradeModel->select('trade.*','label.l_Title','label.l_TitleOne','label.l_TitleTwo','label.l_TitleThree','label.l_Current',
                                    DB::raw("(SELECT trades.id ".
                                            "FROM trade trades ".
                                            "LEFT JOIN label labels ON labels.l_Id = trades.t_lId ".
                                            "WHERE IFNULL(labels.l_Current,'') IN ('day','shift') ".
                                            "and trades.t_Print = 1 ".
                                            "and trades.id = trade.id ".
                                            "and DATE_FORMAT(trades.created_at, '%Y%m%d%H') > ".
                                            "DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 DAY), '%Y%m%d%H') ".
                                            "ORDER BY trades.created_at DESC) AS 'resetId'"))
                                    ->leftJoin('label', 'label.l_Id', '=', 'trade.t_lId');

                if($request->cardId != '')
                {
                    $trade = $trade->Where('trade.t_mCardId', $request->cardId);
                }

                if($request->selectShift != '')
                {
                    $trade = $trade->whereBetween(DB::raw('DATE_FORMAT(trade.created_at, "%H%i")'), [$from, $to]);
                }

                if($request->selectYear != '')
                {
                    $trade = $trade->whereYear('trade.created_at', ((int)$request->selectYear) + 1911);
                }

                if($request->selectMonth != '')
                {
                    $trade = $trade->whereMonth('trade.created_at', $request->selectMonth);
                }

                if($request->selectMonth != '' && $request->selectYear != '' && $request->selectDay != '')
                {
                    $trade = $trade->whereDay('trade.created_at', $request->selectDay);
                }
            }

            if($trade != null)
            {
                $alldata = $trade->get();
                $trade = $trade->reorder('trade.created_at', 'desc')->paginate(25)->withQueryString();
            }
            else
            {
                $trade = $TradeModel->select('trade.*','label.l_Title','label.l_TitleOne','label.l_TitleTwo','label.l_TitleThree','label.l_Current',
                DB::raw("(SELECT trades.id ".
                        "FROM trade trades ".
                        "LEFT JOIN label labels ON labels.l_Id = trades.t_lId ".
                        "WHERE IFNULL(labels.l_Current,'') IN ('day','shift') ".
                        "and trades.t_Print = 1 ".
                        "and trades.id = trade.id ".
                        "and DATE_FORMAT(trades.created_at, '%Y%m%d%H') > ".
                        "DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 DAY), '%Y%m%d%H') ".
                        "ORDER BY trades.created_at DESC) AS 'resetId'"))
                ->leftJoin('label', 'label.l_Id', '=', 'trade.t_lId')
                ->limit(25)->reorder('trade.created_at', 'desc')->cursorPaginate(25);
            }

            return view('dashboard', ['trade'=>$trade,'alldata'=>$alldata]);
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

