<?php

namespace App\Http\Controllers;

use App\User;
use App\CommunityService;
use App\UserService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommunityServiceController extends Controller
{

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);
    }

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
        $new = new CommunityService;
        $new->name = $request->name;
        $new->description = $request->description;
        $new->save();
        return back()->with("success","New Community Service Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CommunityService  $communityService
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = CommunityService::find($id);
        $user_services = UserService::where("service_id",$id)->get();
        return view("admin.service.show",compact("service","user_services"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CommunityService  $communityService
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = CommunityService::find($id);
        return view("admin.service.edit",compact("service"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CommunityService  $communityService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommunityService $communityService)
    {
        $service = CommunityService::find($request->id);
        $service->name = $request->name;
        $service->description = $request->description;
        $service->save();
        return back()->with("success","Community Service Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CommunityService  $communityService
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){
        $service = CommunityService::find($request->id);
        $user_services = UserService::where("service_id",$request->id)->get();
        foreach($user_services as $user_service){
            $user_service->delete();
        }

        $service->delete();
        return redirect("/home")->with("serviceDeleted","Service Deleted Successfully");
    }
}
