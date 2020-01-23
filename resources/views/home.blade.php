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

                    <button onclick="window.print();" class="btn btn-success">Print full report</button>
                </div>
            </div>
            <br>
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
            <br>
            <div class="card">
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
            <br>
            <div class="card">
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
            <br>
            <div class="card">
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
            <br>
            <div class="card">
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
            <br>
            <div class="card">
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
        

        @else

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

            <br>

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

            <br>
            
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
                                    <td>{{$user->total_hours}} hours</td>
                                    <td>
                                        <a href="{{url("user-info",$user->id)}}" style="display:inline-block" class="btn btn-xs btn-info">Show</a>
                                        <form action="{{url("user-delete")}}" method="POST" style="display:inline-block">
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

            <br>

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
                                        <form action="{{url("delete-community-service")}}" method="POST" style="display:inline-block">
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
