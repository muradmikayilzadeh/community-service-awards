<?php

namespace App\Http\Controllers;

use App\User;
use App\CommunityService;
use App\UserService;
use Illuminate\Http\Request;
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
        $users = User::where("is_admin",0)->get();
        $services = CommunityService::all();
        $user_services = UserService::where("user_id",Auth::user()->id)->get();
        $today_services = UserService::where([["user_id",Auth::user()->id],["date", "=", date('Y-m-d')]])->get(); 
        $yesterday_services = UserService::where([["user_id",Auth::user()->id],["date", "=", date('Y-m-d',strtotime("-1 days"))]])->get();
        $week_services = UserService::where([["user_id",Auth::user()->id],["date", ">", date('Y-m-d',strtotime("-7 days"))]])->get();
        $month_services = UserService::where([["user_id",Auth::user()->id],["date", ">", date('Y-m-d',strtotime("-30 days"))]])->get();
        return view("home",compact("services","users","user_services","today_services","yesterday_services","week_services","month_services"));
    }

    public function print()
    {
        $users = User::where("is_admin",0)->get();
        $services = CommunityService::all();
        $user_services = UserService::where("user_id",Auth::user()->id)->get();
        $today_services = UserService::where([["user_id",Auth::user()->id],["date", "=", date('Y-m-d')]])->get(); 
        $yesterday_services = UserService::where([["user_id",Auth::user()->id],["date", "=", date('Y-m-d',strtotime("-1 days"))]])->get();
        $week_services = UserService::where([["user_id",Auth::user()->id],["date", ">", date('Y-m-d',strtotime("-7 days"))]])->get();
        $month_services = UserService::where([["user_id",Auth::user()->id],["date", ">", date('Y-m-d',strtotime("-30 days"))]])->get();
        return view("user.print",compact("services","users","user_services","today_services","yesterday_services","week_services","month_services"));
    }
}
