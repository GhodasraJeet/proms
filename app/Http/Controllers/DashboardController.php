<?php

namespace App\Http\Controllers;

use Laravolt\Avatar\Avatar;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
        // Avatar::create('Susilo Bambang Yudhoyono')->save('sample.jpg', 100);
        // $user_image=(new \Laravolt\Avatar\Avatar)->create('GJ')->setBackground('#001122')->save('sample.jpg',100);
        // dd($user_image);
        return view('dashboard');
    }
}
