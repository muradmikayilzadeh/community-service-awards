<?php

namespace App\Http\Controllers;

use App\User;
use App\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function show($id){
        $user = User::find($id);
        $user_services = UserService::where("user_id",$id)->get();
        $today_services = UserService::where([["user_id",$id],["date", "=", date('Y-m-d')]])->get(); 
        $yesterday_services = UserService::where([["user_id",$id],["date", "=", date('Y-m-d',strtotime("-1 days"))]])->get();
        $week_services = UserService::where([["user_id",$id],["date", ">", date('Y-m-d',strtotime("-7 days"))]])->get();
        $month_services = UserService::where([["user_id",$id],["date", ">", date('Y-m-d',strtotime("-30 days"))]])->get();

        return view("admin.user.show",compact("user","user_services","today_services","yesterday_services","week_services","month_services"));
    }

    public function print($id){
        $user = User::find($id);
        $user_services = UserService::where("user_id",$id)->get();
        $today_services = UserService::where([["user_id",$id],["date", "=", date('Y-m-d')]])->get(); 
        $yesterday_services = UserService::where([["user_id",$id],["date", "=", date('Y-m-d',strtotime("-1 days"))]])->get();
        $week_services = UserService::where([["user_id",$id],["date", ">", date('Y-m-d',strtotime("-7 days"))]])->get();
        $month_services = UserService::where([["user_id",$id],["date", ">", date('Y-m-d',strtotime("-30 days"))]])->get();

        return view("admin.user.print",compact("user","user_services","today_services","yesterday_services","week_services","month_services"));
    }

    public function destroy(Request $request){
        $user = User::find($request->id);
        $user_services = UserService::where("user_id",$request->id)->get();
        foreach($user_services as $service){
            $service->delete();
        }

        $user->delete();
        return back()->with("userDeleted","User Deleted Successfully");
    }
}
