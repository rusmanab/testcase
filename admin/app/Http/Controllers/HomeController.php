<?php

namespace App\Http\Controllers;

use App\DriverAntrian;
use App\Member;
use App\Order;
use App\SaldoDriver;
use App\SaldoTopup;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('pages.home.index');
    }
}
