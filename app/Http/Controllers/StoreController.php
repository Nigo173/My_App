<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminsModel;

class StoreController extends Controller
{
    public function index()
    {
        return view('store', ['admin' => $this->get_admin()]);
    }


    private function get_admin()
    {
        $admins = new AdminsModel();
        $admin = $admins->where('a_Id', session('a_Id'))->get()->first();
        return $admin;
    }
}
