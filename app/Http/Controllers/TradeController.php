<?php

namespace App\Http\Controllers;
use App\Models\LogModel;
use App\Models\TradeModel;
use App\Models\MemberModel;
use App\Models\AdminsModel;
use App\Models\LabelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Exception;

class TradeController extends Controller
{
    public function index(Request $request)
    {
        return view('trade');
    }

    public function list(Request $request)
    {
        try
        {
            if(isset($request->search) && $request->search != '')
            {
                $m_Id = ($request->Id != "" ? " AND m_Id LIKE '".$request->Id."%'" : "");
                $m_CardId = ($request->cardId != "" ? " AND m_CardId LIKE '".$request->cardId."%'" : "");
                $m_Name = ($request->name != '' ? " AND m_Name LIKE '". $request->name ."%'" : "");
                $m_Birthday = ($request->birthday != "" ? " AND m_Birthday LIKE '".$request->birthday."%'" : "");
                $m_Phone = ($request->phone != "" ? " AND m_Phone LIKE '".$request->phone."%'" : "");

                $member = DB::select("SELECT * FROM member WHERE 1=1".$m_Id.$m_CardId.$m_Name.$m_Birthday.$m_Phone." LIMIT 10");

                return view('trade', ['member' => $member]);
            }
            else if(isset($request->searchMember) && $request->searchMember != '')
            {
                // 最近消費紀錄
                $memberlabel = TradeModel::select('t_Print AS t_Count','t_mId','t_lTitle','created_at')
                ->where('t_mCardId', $request->searchMember)
                ->limit(5)->reorder('created_at', 'desc')->get();

                // 篩選客戶交易選項
                $currentlabel = DB::select("SELECT trade.*,".
                "(CASE WHEN IFNULL(label.l_Current,'') = 'day' THEN ".
                "   CASE WHEN trade.t_Print = 1 THEN ".
                "       CASE WHEN trade.created_at < CONCAT(DATE_FORMAT(NOW(), '%Y-%m-%d'),' 08:00:00') AND DATE_FORMAT(NOW(), '%H%i') > 0800 THEN  ".
                "           0 ".
                "       ELSE ".
                "           CASE WHEN DATE_FORMAT(NOW(), '%H') < 8 THEN ".
                "               DATE_FORMAT(TIMEDIFF(NOW(), CONCAT(DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 DAY), '%Y-%m-%d'),' 08:00:00')), '%H.%i') ".
                "           ELSE ".
                "               DATE_FORMAT(TIMEDIFF(NOW(), CONCAT(DATE_FORMAT(trade.created_at, '%Y-%m-%d'),' 08:00:00')), '%H.%i') ".
                "           END ".
                "       END ".
                "   ELSE ".
                "       0 ".
                "   END ".
                "WHEN IFNULL(label.l_Current,'') = 'shift' THEN ".
                "   CASE WHEN DATE_FORMAT(trade.created_at, '%H') >= 8 AND DATE_FORMAT(trade.created_at, '%H') < 16 THEN ".
                "       CASE WHEN DATE_FORMAT(NOW(), '%H') >= 8 AND DATE_FORMAT(NOW(), '%H') < 16 AND DATE_FORMAT(NOW(), '%Y%m%d') = DATE_FORMAT(trade.created_at, '%Y%m%d') THEN ".
                "           CASE WHEN trade.t_Print = 1 THEN ".
                "            IF(DATE_FORMAT(TIMEDIFF(NOW(), CONCAT(DATE_FORMAT(NOW(), '%Y-%m-%d'),' 08:00:00')), '%H%i') > 0800,0, ".
                "               DATE_FORMAT(DATE_ADD(TIMEDIFF(NOW(), CONCAT(DATE_FORMAT(NOW(), '%Y-%m-%d'),' 08:00:00')), INTERVAL 1 MINUTE), '%H.%i')) ".
                "       ELSE 0 END ".
                "    ELSE 0 END ".
                "   WHEN DATE_FORMAT(trade.created_at, '%H') >= 16 AND DATE_FORMAT(trade.created_at, '%H') < 24 THEN ".
                "       CASE WHEN DATE_FORMAT(NOW(), '%H') >= 16 AND DATE_FORMAT(NOW(), '%H') < 24 AND DATE_FORMAT(NOW(), '%Y%m%d') = DATE_FORMAT(trade.created_at, '%Y%m%d') THEN ".
                "           CASE WHEN trade.t_Print = 1 THEN ".
                "               IF(DATE_FORMAT(TIMEDIFF(NOW(), CONCAT(DATE_FORMAT(NOW(), '%Y-%m-%d'),' 16:00:00')), '%H%i') > 0800,0, ".
                "                   DATE_FORMAT(DATE_ADD(TIMEDIFF(NOW(), CONCAT(DATE_FORMAT(NOW(), '%Y-%m-%d'),' 16:00:00')), INTERVAL 1 MINUTE), '%H.%i')) ".
                "           ELSE 0 END ".
                "       ELSE 0 END ".
                "   WHEN DATE_FORMAT(trade.created_at, '%H') >= 0 AND DATE_FORMAT(trade.created_at, '%H') < 8 THEN ".
                "       CASE WHEN DATE_FORMAT(NOW(), '%H') >= 0 AND DATE_FORMAT(NOW(), '%H') < 8 AND DATE_FORMAT(NOW(), '%Y%m%d') = DATE_FORMAT(trade.created_at, '%Y%m%d') THEN ".
                "           CASE WHEN trade.t_Print = 1 THEN ".
                "               IF(DATE_FORMAT(TIMEDIFF(NOW(), CONCAT(DATE_FORMAT(NOW(), '%Y-%m-%d'),' 00:00:00')), '%H%i') > 0800,0, ".
                "                   DATE_FORMAT(DATE_ADD(TIMEDIFF(NOW(), CONCAT(DATE_FORMAT(NOW(), '%Y-%m-%d'),' 00:00:00')), INTERVAL 1 MINUTE), '%H.%i')) ".
                "           ELSE 0 END ".
                "       ELSE 0 END ".
                "   END ".
                "END) AS 'countdownTime' ".
                "FROM trade trade ".
                "LEFT JOIN label label ON label.l_Id = trade.t_lId ".
                "WHERE trade.t_mCardId = '".$request->searchMember."' ".
                "and IFNULL(label.l_Current,'') IN ('day','shift')  ".
                "and DATE_FORMAT(trade.created_at, '%Y%m%d%H') > CONCAT(DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 DAY), '%Y%m%d%H'),' 08:00:00') ".
                "ORDER BY created_at DESC");

                // 搜尋會員
                $data = MemberModel::Where('m_CardId', $request->searchMember)->get()->first();
                // 標籤按鈕判斷是否停用
                $label = LabelModel::Where('l_Current', '<>', '')->limit(8)->get();
                return view('trade', ['data' => $data,'label' => $label,'memberlabel' => $memberlabel,'currentlabel' => $currentlabel]);
            }
        }
        catch(Exception $e)
        {
            return view('error');
        }
        return view('trade');
    }

    public function create(Request $request)
    {
        $request->except(['msg']);
        $msg = '';

        if($request->isMethod('post'))
        {
            try
            {
                $img = '';

                if($request->mImg != '')
                {
                    // $img = $this->get_Image($request->mImg);
                    // if(strlen($img) < 10)
                    // {
                    //     $msg = "圖片大於2MB、請壓縮圖片";
                    //     return response()->json(['action' => 'list','msg' => $msg]);
                    // }

                    $tId = date('Ymdhis', time()).$request->Id;
                    $tNo = date('Ymd', time()).$request->Id.' '.date('h:i', time());
                    // return response()->json(['action' => $request->birthday. '='.$request->phone]);
                    // return response()->json(['action' => 'list','msg' => 'birthday ='.$request->birthday.' , t_No: '.$tNo.' , '
                    // .$request->lTitle.' , t_lId:'.$request->lId.' , t_lTitle: '.$request->lTitle.' , t_mId = '.$request->Id. ' , t_mCardId:'.$request->cardId. ', name'.$request->name]);

                    $data = TradeModel::create([
                        't_Id'=>$tId,
                        't_No'=>$tNo,
                        't_Print'=>1,
                        't_aId'=>$request->session()->get('Account'),
                        't_aName'=>$request->session()->get('Name'),
                        't_lId'=>$request->lId,
                        't_lTitle'=>$request->lTitle,
                        't_mId'=>$request->Id,
                        't_mCardId'=>$request->cardId,
                        't_mName'=>$request->name,
                        't_mBirthday'=>$request->birthday,
                        't_mPhone'=>$request->phone,
                        't_mImg'=>$request->mImg
                    ]);

                    $msg = "交易成功";
                    $tId = '';

                    if($data->save())
                    {
                        $tId = $data->id;

                        // 更新會員備註
                        $member = MemberModel::where('m_Id', $request->Id)->update([
                            'm_Remark'=>$request->remark
                        ]);

                        if(isset($member->m_Remark))
                        {
                            $msg .= ' 會員備註:'.$request->remark;
                        }
                    }
                    else
                    {
                        $msg = "交易失敗";
                    }

                    $this->create_Log($request, $msg);

                    // 帶入資料 trade
                    $trade = '';

                    if($tId != '')
                    {
                        $trade = TradeModel::where('id', $tId)->get()->first();
                        $trade = json_encode($trade);
                    }

                    // 帶入資料 label
                    $label = '';

                    if($request->lId != '')
                    {
                        $label = LabelModel::where('l_Id', $request->lId)->get()->first();
                        $label = json_encode($label);
                    }

                    return response()->json(['action' => 'list','msg' => $msg,'trade' => $trade,'label' => $label]);
                }
                return response()->json(['action' => 'list','msg' => '圖片異常']);
            }
            catch(Exception $e)
            {
                return view('error');
            }
        }
        return view('trade');
    }

    private function get_Image(string $encode_Img): string
    {
        // $type = pathinfo($img, PATHINFO_EXTENSION);
        // $encode_Img = base64_encode(file_get_contents($img));
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
        $mac = '';
        $url = '';

        try
        {
            $note = session('Account').'執行 => (會員帳號:'.$request->Id.' 會員姓名: '.$request->name.')'.$note;
            //$mac = strtok(exec('getmac'), ' ');
            $url = $request->getRequestUri();
        }
        catch(Exception $e){}

        $data = 'MAC: '.$mac.' URL: '.$url.' NOTE: '.$note;
        LogModel::create(['log' => $data]);
    }
}
