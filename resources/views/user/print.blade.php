@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content">


        {{-- Printing customization --}}
        <div class="col-md-12">
            <h1>Print page</h1>
            <div id="print_custom" class="card">
                <div class="card-header">Printing customization</div>
                <div class="card-body">

                    <input type="checkbox" id="personal_info" onclick="customize('personal_info_card')" checked>
                    <label for="personal_info">Personal Information</label>

                    <br>

                    <input type="checkbox" id="all_info" onclick="customize('all_info_card')" checked>
                    <label for="all">All Community Services</label>

                    <br>

                    <input type="checkbox" id="today_info" onclick="customize('today_info_card')" checked>
                    <label for="today">Today Community Services</label>

                    <br>

                    <input type="checkbox" id="last_week_info" onclick="customize('last_week_info_card')" checked>
                    <label for="last_week">Last Week Community Services</label>

                    <br>

                    <input type="checkbox" id="last_month_info" onclick="customize('last_month_info_card')" checked>
                    <label for="last_month">Last Month Community Services</label>

                    <br>

                    <button onclick="window.print();" class="btn btn-success">Print full report</button>
                    <a href="{{url('/home')}}" class="btn btn-danger">Go back</a>
                </div>
            </div>

            <div class="card" id="personal_info_card" style="display:block">
                <div class="card-header">Personal Information</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2>{{Auth::user()->name}}</h2>
                    <p><b>Email: </b>{{Auth::user()->email}}</p>
                    <p><b>Grade: </b>{{Auth::user()->grade}}</p>
                    <p><b>Number: </b>#{{Auth::user()->id}}</p>
                    <p><b>Total Hours: </b>{{Auth::user()->getTotalHours->sum("duration")}} hours</p>

                    <button onclick="window.print();" class="btn btn-success">Print full report</button>
                </div>
            </div>

            <div class="card" id="all_info_card">
                <div class="card-header">All Community Services</div>
                <div class="card-body">
                    @if(Session::has("deleted"))
                        <div class="col-md-12 alert alert-success">Service Deleted Successfully</div>
                    @endif
                    @if(count($user_services) == 0)
                        <h3 class="text-center">No Data Found</h3>
                    @else
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
                                    <td>{{$service->getServiceName->name}}</td>
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
                    @endif
                </div>
            </div>

            <div class="card" id="today_info_card" style="display:block">
                <div class="card-header">Today Community Services</div>
                <div class="card-body">
                    @if(Session::has("deleted"))
                        <div class="col-md-12 alert alert-success">Service Deleted Successfully</div>
                    @endif
                    @if(count($today_services) == 0)
                        <h3 class="text-center">No Data Found</h3>
                    @else
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
                            @foreach($today_services as $service)
                                <tr>
                                    <td>{{$service->id}}</td>
                                    <td>{{$service->getServiceName->name}}</td>
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
                    @endif
                </div>
            </div>

            <div class="card" id="yesterday_info_card" style="display:block">
                <div class="card-header">Yesterday Community Services</div>
                <div class="card-body">
                    @if(Session::has("deleted"))
                        <div class="col-md-12 alert alert-success">Service Deleted Successfully</div>
                    @endif
                    @if(count($yesterday_services) == 0)
                        <h3 class="text-center">No Data Found</h3>
                    @else
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
                            @foreach($yesterday_services as $service)
                                <tr>
                                    <td>{{$service->id}}</td>
                                    <td>{{$service->getServiceName->name}}</td>
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
                    @endif
                </div>
            </div>

            <div class="card" id="last_week_info_card" style="display:block">
                <div class="card-header">Last Week Community Services</div>
                <div class="card-body">
                    @if(Session::has("deleted"))
                        <div class="col-md-12 alert alert-success">Service Deleted Successfully</div>
                    @endif
                    @if(count($week_services) == 0)
                        <h3 class="text-center">No Data Found</h3>
                    @else
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
                            @foreach($week_services as $service)
                                <tr>
                                    <td>{{$service->id}}</td>
                                    <td>{{$service->getServiceName->name}}</td>
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
                    @endif
                </div>
            </div>

            <div class="card" id="last_month_info_card" style="display:block">
                <div class="card-header">Last Month Community Services</div>
                <div class="card-body">
                    @if(Session::has("deleted"))
                        <div class="col-md-12 alert alert-success">Service Deleted Successfully</div>
                    @endif
                    @if(count($month_services) == 0)
                        <h3 class="text-center">No Data Found</h3>
                    @else
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
                            @foreach($month_services as $service)
                                <tr>
                                    <td>{{$service->id}}</td>
                                    <td>{{$service->getServiceName->name}}</td>
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
                    @endif
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
