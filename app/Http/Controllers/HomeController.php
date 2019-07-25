<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $burgers = DB::table('menuitems')->where(['categoryid'=>'1'])->get();
        $bevs = DB::table('menuitems')->where(['categoryid'=>'2'])->get();
        $cmeals = DB::table('menuitems')->where(['categoryid'=>'3'])->get();
        return view('home')->with(['burgers'=>$burgers, 'bevs'=>$bevs, 'cmeals'=>$cmeals]);
    }
}
