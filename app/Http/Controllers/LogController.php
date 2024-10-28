<?php

namespace App\Http\Controllers;
use App\Models\LogModel;
use Illuminate\Http\Request;
use Exception;

class LogController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $LogModel = new LogModel();

            if($request->isMethod('get') && isset($request->search) && $request->search != '') // Like
            {
                $log = $LogModel->where('log', 'like', '%'.$request->search.'%')
                ->limit(25)->reorder('updated_at', 'desc')->get();
                return view('log', ['log' => $log]);
            }

            // ALL
            $log = $LogModel->limit(25)->reorder('updated_at', 'desc')->get();
            return view('log', ['log' => $log]);
        }
        catch(Exception $e)
        {
            return view('error');
        }
    }
}
