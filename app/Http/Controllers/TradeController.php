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
                //  DB::enableQueryLog();
                // $memberlabel = DB::select("SELECT COUNT(*), t_lTitle FROM (SELECT t_lTitle FROM trade WHERE t_mId = '".$request->searchMember."' LIMIT 1,5) AS a");
                // $memberlabel = TradeModel::select(TradeModel::raw('count(*) AS t_Count ,t_mId'),'t_lTitle')
                // ->where('t_mId', $request->searchMember)->groupBy('t_mId','t_lTitle')
                // ->limit(2)->reorder('created_at', 'desc')->get();

                $memberlabel = TradeModel::select('t_Print AS t_Count','t_mId','t_lTitle')
                ->where('t_mId', $request->searchMember)
                ->limit(5)->reorder('created_at', 'desc')->get();

                // 篩選客戶交易選項
                $currentlabel = DB::select("SELECT * FROM trade WHERE t_mId = '".$request->searchMember."' AND DATE_FORMAT(created_at, '%Y%m%d%H') ".
                                "BETWEEN IF(DATE_FORMAT(NOW(), '%H%i') < 2000, ".
                                "CONCAT(DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 DAY), '%Y%m%d'),'20'), CONCAT(DATE_FORMAT(NOW(), '%Y%m%d'),'20')) AND ".
                                "IF(DATE_FORMAT(NOW(), '%H%i') > 2000, ".
                                "CONCAT(DATE_FORMAT(DATE_ADD(NOW(), INTERVAL +1 DAY), '%Y%m%d'),'20'), CONCAT(DATE_FORMAT(NOW(), '%Y%m%d'),'20'))");

                // $currentlabel = DB::select("SELECT * FROM trade WHERE t_mId = '".$request->searchMember."' AND DATE_FORMAT(created_at, '%Y%m%d%H') ".
                //                 "BETWEEN IF(DATE_FORMAT(NOW(), '%H%i') < 2000, ".
                //                 "CONCAT(DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 DAY), '%Y%m%d'),'20'), CONCAT(DATE_FORMAT(NOW(), '%Y%m%d'),'20')) AND ".
                //                 "IF(DATE_FORMAT(NOW(), '%H%i') > 2000, ".
                //                 "CONCAT(DATE_FORMAT(DATE_ADD(NOW(), INTERVAL +1 DAY), '%Y%m%d'),'20'), CONCAT(DATE_FORMAT(NOW(), '%Y%m%d'),'20'))");



                                // $currentlabel = DB::select("SELECT * FROM trade WHERE t_mId = '".$request->searchMember."' AND DATE_FORMAT(created_at, '%Y%m%d%H%i') ".
                                // "BETWEEN IF(DATE_FORMAT(NOW(), '%H%i') < 2000, ".
                                // "CONCAT(DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 DAY), '%Y%m%d'),'2000'), CONCAT(DATE_FORMAT(NOW(), '%Y%m%d'),'2000')) AND ".
                                // "IF(DATE_FORMAT(NOW(), '%H%i') > 2000, ".
                                // "CONCAT(DATE_FORMAT(DATE_ADD(NOW(), INTERVAL +1 DAY), '%Y%m%d'),'2000'), CONCAT(DATE_FORMAT(NOW(), '%Y%m%d'),'2000'))");





                //  dd(DB::getQueryLog()); // Sh
                $data = MemberModel::Where('m_Id', $request->searchMember)->get()->first();
                $label = LabelModel::limit(8)->get();
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
                    // return view('trade', ['msg' => $msg, 'trade' => $trade]);
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
