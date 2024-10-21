<?php

namespace App\Http\Controllers;
use App\Models\LogModel;
use App\Models\TradeModel;
use App\Models\MemberModel;
use App\Models\AdminsModel;
use App\Models\LabelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class TradeController extends Controller
{
    public function index(Request $request)
    {
        if(isset($request->cardId) && $request->isMethod('get'))
        {
            try
            {
                $member = MemberModel::Where('m_CardId', $request->cardId)->get()->first();

                if(isset($member->m_CardId))
                {
                    //  SELECT COUNT(*), t_lTitle  FROM (SELECT t_lTitle FROM `trade` WHERE t_mCardId= 'C333333333' LIMIT 5) AS a

                    DB::enableQueryLog();

                    $memberlabel = TradeModel::select(TradeModel::raw('count(*) AS t_Count ,t_mCardId'),'t_lTitle')
                    ->where('t_mCardId', $request->cardId)->groupBy('t_mCardId','t_lTitle')
                    ->limit(5)->reorder('updated_at', 'desc')->get();

                    // $SubQuery = TradeModel::orderBy('created_at', 'desc')->where('t_mCardId', 'C333333333');

                    // ->orderBy('updated_at', 'desc')->skip(3)->take(3);

                    // $memberlabel = DB::table(DB::raw("({$SubQuery->toSql()}) as sub where 1=1"))->select(
                    // array(
                    //     DB::raw('COUNT(`created_at`) as `date`'),
                    //     't_mCardId'
                    // )
                    // )
                    // ->mergeBindings($SubQuery->getQuery())->get();

                    // dd($memberlabel); // Sh

                    // dd(DB::getQueryLog()); // Sh

                    $label = LabelModel::limit(8)->reorder('updated_at', 'desc')->get();
                    return view('trade', ['member' => $member, 'label' => $label, 'memberlabel' => $memberlabel]);
                }

                return view('trade', ['msg' => '搜尋無此人']);
            }
            catch(Exception $e)
            {
                return view('trade', ['msg' => '搜尋異常錯誤']);
            }
        }
        return view('trade');
    }

    public function create(Request $request)
    {
        $request->except(['msg']);

        if($request->isMethod('post'))
        {
            try
            {
                $tId = date('Ymdhis', time()).$request->Id;

                $data = TradeModel::create([
                    't_Id'=>$tId,
                    't_aId'=>$request->session()->get('Account'),
                    't_aName'=>$request->session()->get('Name'),
                    't_lId'=>$request->lId,
                    't_lTitle'=>$request->lTitle,
                    't_mId'=>$request->Id,
                    't_mCardId'=>$request->cardId,
                    't_mName'=>$request->name,
                    't_mImg'=>$request->mImg,
                ]);

                $msg = "交易成功";
                $tId = '';

                if($data->save())
                {
                    $tId = $data->id;
                    $this->create_Log($request, $msg);
                }
                else
                {
                    $msg = "交易失敗";
                    $this->create_Log($request, $msg);
                }

                $trade = '';

                if($tId != '')
                {
                    $trade = TradeModel::where('id', $tId)->get()->first();
                }

                return view('trade', ['msg' => $msg, 'trade' => $trade]);
            }
            catch(Exception $e)
            {
                return view('error');
            }
        }
        return view('trade');
    }

    // private function printer($id)
    // {
    //     // $label = $LabelModel->Where('l_TitleOne', $request->search)->get();
    //     $trade = TradeModel::where('id', $id)->get()->first();

    //     return view('label_print', ['trade' => $trade]);
    //     // return redirect()->route('label_print', ['trade' => $trade]);
    // }

    private function create_Log(Request $request, string $note)
    {
        $note = session('Account').'執行 => (會員帳號:'.$request->Id.' 會員姓名: '.$request->name.')'.$note;
        $mac = strtok(exec('getmac'), ' ');
        $url = $request->getRequestUri();
        $data = 'MAC: '.$mac.' URL: '.$url.' NOTE: '.$note;
        LogModel::create(['log' => $data]);
    }
}
