<?php

namespace App\Http\Controllers;
use App\Models\TradeModel;
use App\Models\MemberModel;
use App\Models\AdminsModel;
use App\Models\DashboardModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $msg = '';
            $TradeModel = new TradeModel();

            if($request->isMethod('get') && isset($request->search) && $request->search != '') // Like
            {
                $trade = $TradeModel->where('t_mCardId', 'like', '%'.$request->search.'%')
                ->orWhere('t_mName', 'like', '%'.$request->search.'%')
                ->limit(100)->reorder('updated_at', 'desc')->get();
                return view('dashboard', ['trade' => $trade]);
            }
            // ALL
            $trade = $TradeModel->limit(100)->reorder('updated_at', 'desc')->get();
            return view('dashboard', ['trade' => $trade, 'msg' => $msg]);
        }
        catch(DecryptException $e)
        {
            return view('dashboard', ['msg' => '搜尋異常錯誤']);
        }
    }
}
