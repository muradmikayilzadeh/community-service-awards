@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">

        @if(Auth::user()->is_admin == 0)

        <div class="col-md-12">
            <div class="card">
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

                    <a href="{{url("/user-print")}}" class="btn btn-success">Print report</a>
                </div>
            </div>

            <div class="card" id="add_community_service">
               <div class="card-header">Add Community Service</div>
               <div class="card-body"> 
                @if(Session::has("success"))
                    <div class="col-md-12 alert alert-success">New Community Service Added Successfully</div>
                @endif
                <form method="POST" action="{{ url('add-community-service-user') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="service" class="col-md-4 col-form-label text-md-right">{{ __('Service') }}</label>

                        <div class="col-md-6">
                            
                            <select name="service_id" id="service" class="form form-control">
                                @foreach($services as $service)
                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                @endforeach
                            </select>

                            @error('service')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                        <div class="col-md-6">
                            <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus></textarea>
                            
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                        <div class="col-md-6">
                            <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" autofocus>

                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="duration" class="col-md-4 col-form-label text-md-right">{{ __('Duration') }}</label>

                        <div class="col-md-6">
                            <input id="duration" type="number" step="0.01" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') }}" required autocomplete="duration" autofocus>

                            @error('duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </div>
                </form>
                </div>
                </div>

                <div class="tab">
                    <button class="tablinks active" onclick="openTab(event, 'All')">All</button>
                    <button class="tablinks" onclick="openTab(event, 'Today')">Today</button>
                    <button class="tablinks" onclick="openTab(event, 'Yesterday')">Yesterday</button>
                    <button class="tablinks" onclick="openTab(event, 'L_Week')">Last Week</button>
                    <button class="tablinks" onclick="openTab(event, 'L_Month')">Last Month</button>
                </div>
                  
                <div id="All" class="tabcontent" style="display: block">
                    <h3>All</h3>
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
                                            <form action="{{url("delete-community-service-user")}}" onsubmit="return confirm('Are you sure?')" method="POST">
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
                  
                <div id="Today" class="tabcontent">
                    <h3>Today</h3>
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
                  
                <div id="Yesterday" class="tabcontent">
                    <h3>Yesterday</h3>
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
    
                <div id="L_Week" class="tabcontent">
                    <h3>Last week</h3>
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
    
                <div id="L_Month" class="tabcontent">
                    <h3>Last Month</h3>
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
        

        @else
        {{-- -------------------------------------====================--------------------------------- --}}

        {{-- -------------------------------------Admin dashboard part--------------------------------- --}}
        
        {{-- -------------------------------------====================--------------------------------- --}}

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2>{{Auth::user()->name}}</h2>
                    <p><b>Email: </b>{{Auth::user()->email}}</p>
                </div>

            </div>

            <div class="card">
                <div class="card-header">Add community service</div>
                <div class="card-body"> 
                    @if(Session::has("success"))
                        <div class="col-md-12 alert alert-success">New Community Service Added Successfully</div>
                    @endif
                    <form method="POST" action="{{ url('add-community-service') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus></textarea>
                                
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="card">
                <div class="card-header">Students</div>
                <div class="card-body">
                    @if(Session::has("userDeleted"))
                        <div class="col-md-12 alert alert-success">User Deleted Successfully</div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Grade</td>
                                <td>Total Hours</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->grade}}</td>
                                    <td>{{$user->getTotalHours->sum("duration")}} hours</td>
                                    <td>
                                        <a href="{{url("user-info",$user->id)}}" style="display:inline-block" class="btn btn-xs btn-info">Show</a>
                                        <form action="{{url("user-delete")}}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline-block">
                                            @csrf
                                            <input type="hidden" value="{{$user->id}}" name="id">
                                            <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="card">
                <div class="card-header">Community Services</div>
                <div class="card-body">
                    @if(Session::has("serviceDeleted"))
                        <div class="col-md-12 alert alert-success">Service Deleted Successfully</div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Name</td>
                                <td>Description</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>{{$service->id}}</td>
                                    <td>{{$service->name}}</td>
                                    <td>{{$service->description}}</td>
                                    <td>
                                        <a href="{{url("service-info",$service->id)}}" style="display:inline-block" class="btn btn-xs btn-info">Show</a>
                                        <a href="{{url("service-edit",$service->id)}}" style="display:inline-block" class="btn btn-xs btn-success">Edit</a>
                                        <form action="{{url("delete-community-service")}}" onsubmit="return confirm('Are you sure?')" method="POST" style="display:inline-block">
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

        @endif
    </div>
</div>
@endsection