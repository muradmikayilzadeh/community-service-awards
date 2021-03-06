@extends('layouts.app')
<style>
    @media print { 
        #add_community_service,.btn, table td:last-child{ 
            display: none !important; 
        } 
    } 
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
    @if(Auth::user()->is_admin==0)
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">System Message</div>
                <div class="card-body">
                    <h1>Action is not permitted!</h1>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12">
            <div class="card">
                    <div class="card-header">Community Service Information</div>
                    <div class="card-body">
                        <h2>{{$service->name}}</h2>
                        <p><b>Description: </b>{{$service->description}}</p>
                        <a href="{{url("/home")}}" class="btn btn-success">Back</a>
                        <button onclick="window.print();" class="btn btn-info">Print full report</button>
                    </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Community Services</div>
                <div class="card-body">
                    @if(Session::has("deleted"))
                        <div class="col-md-12 alert alert-success">Service Deleted Successfully</div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Service Name</td>
                                <td>Description</td>
                                <td>Duration</td>
                                <td>Date</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user_services as $service)
                                <tr>
                                    <td>{{$service->id}}</td>
                                    <td>{{$service->getUserName->name}}</td>
                                    <td>{{$service->description}}</td>
                                    <td>{{$service->duration}} hours</td>
                                    <td>{{$service->date}}</td>
                                    <td>
                                        <form action="{{url("delete-community-service-user")}}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{$service->id}}" name="id">
                                            <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif()
    </div>
</div>
@endsection