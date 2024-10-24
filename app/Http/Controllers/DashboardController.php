<?php

namespace App\Http\Controllers;
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
            $msg = '';
            $TradeModel = new TradeModel();
            $trade = null;

            if($request->isMethod('get') && (isset($request->selectShift) && $request->selectShift != '') || (isset($request->selectMonth) && $request->selectMonth != '')) // Like
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

                if($request->selectShift != '' && $request->selectMonth == '')
                {
                    $trade = $TradeModel->whereBetween(DB::raw('DATE_FORMAT(created_at, "%H%i")'), [$from, $to])
                    ->reorder('created_at', 'desc')->get();
                }
                else if($request->selectYear != '' && $request->selectMonth == '' && $request->selectShift == '')
                {
                    $trade = $TradeModel->whereMonth('created_at', '=', $request->selectMonth)
                    ->reorder('created_at', 'desc')->get();
                }
                else if($request->selectMonth != '' && $request->selectShift == '')
                {
                    $trade = $TradeModel->whereMonth('created_at', '=', $request->selectMonth)
                    ->reorder('created_at', 'desc')->get();
                }
                else if($request->selectMonth != '' && $request->selectShift != '')
                {
                    $trade = $TradeModel->whereBetween(DB::raw('DATE_FORMAT(created_at, "%H%i")'), [$from, $to])
                    ->whereMonth('created_at', '=', $request->selectMonth)
                    ->reorder('created_at', 'desc')->get();
                }
                else if($request->selectYear != '' && $request->selectMonth != '' && $request->selectShift != '')
                {
                    $trade = $TradeModel->whereBetween(DB::raw('DATE_FORMAT(created_at, "%H%i")'), [$from, $to])
                    ->whereYear('created_at', '=', ((int)$request->selectYear) + 1911)
                    ->whereMonth('created_at', '=', $request->selectMonth)
                    ->reorder('created_at', 'desc')->get();
                }
                return view('dashboard', ['trade' => $trade, 'selectShift' => $request->selectShift , 'selectMonth' => $request->selectMonth,'selectYear' => $request->selectYear]);
            }
            // ALL
            $trade = $TradeModel->limit(100)->reorder('updated_at', 'desc')->get();
            return view('dashboard', ['trade' => $trade, 'msg' => $msg]);
        }
        catch(Exception $e)
        {
            return view('error');
        }
    }

    // private function get_max_min_year()
    // {
    //     $year = DB::select("SELECT DATE_FORMAT(MAX(created_at), '%Y') - 1909 AS MAXDAY, DATE_FORMAT(MAX(created_at), '%Y') -1911 AS MINDAY FROM trade");
    //     return $year;
    // }
}

