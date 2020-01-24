<?php

namespace App\Http\Controllers;

use App\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new = new UserService;
        $new->user_id = Auth::user()->id;
        $new->service_id = $request->service_id;
        $new->description = $request->description;
        $new->date = $request->date;
        $new->duration = $request->duration;
        $new->save();
        return back()->with("success","New Community Service Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserService  $userService
     * @return \Illuminate\Http\Response
     */
    public function show(UserService $userService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserService  $userService
     * @return \Illuminate\Http\Response
     */
    public function edit(UserService $userService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserService  $userService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserService $userService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserService  $userService
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $service = UserService::find($request->id);
        $user->total_hours = $user->total_hours - $service->duration;
        $user->save();
        $service->delete();
        return redirect("/home")->with("deleted","Your Service Successfully Deleted");
    }
}
