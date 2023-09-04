@extends('dashboard.admin.master')
@section('title', 'Employee')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                            class="fa fa-arrow-left"></i></a> Employee</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item">Employee</li>
                    <li class="breadcrumb-item active">Employee Detail</li>
                </ul>
            </div>
        </div>
    </div>
<style>
    hr {
    margin-top: .2rem;
    margin-bottom: .2rem;
}
p {
    margin-bottom: .5rem;
}
</style>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Employee Profile</h2>
                    @if(Session::get('errorMsg'))
                         <span class="text-danger">{{ Session::get('errorMsg') }}</span>
                        @endif
                        @if(Session::get('successMsg'))
                         <span class="text-success">{{ Session::get('successMsg') }}</span>
                        @endif
                </div>
                @foreach($users as $user)
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <ul class="nav nav-tabs-new">
                                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#basicDetails">Basic Details</a></li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#fullDetails">
                                       <sup><small><b>Update.</b></small></sup>
                                        Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#updateCredential">
                                        <sup><small><b>Update.</b></small></sup>
                                         Credentials.
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#updateFile">
                                        <sup><small><b>Update.</b></small></sup>
                                         Files.
                                    </a>
                                </li>
                            </ul><br><hr>
                            <div class="tab-content padding-0">
                                <div class="tab-pane active show" id="basicDetails">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="profile-image">
                                                        <img src="{{ asset('images/users/' . $user->profile_picture )}}" 
                                                            class="rounded-circle img-fluid" alt="{{ $user->full_name }}" >
                                                        <p class="p-1">
                                                            <sup><small><b>Full Name:</b></small></sup>
                                                            {{ $user->full_name }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-7">
                                                    <small class="text-muted">User Name: </small>
                                                    <p>{{ $user->email }}</p>
                                                    <small class="text-muted">Email address: </small>
                                                    <p>{{ $user->email }}</p>
                                                    <small class="text-muted">Mobile: </small>
                                                    <p>{{ $user->phone_number }}</p>
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <small class="text-muted"><b>Documents: </b></small>
                                                    <p>
                                                        <a href="{{ asset('images/users/' . $user->document )}}" target="__blanck">
                                                            {{ $user->document }}
                                                        </p>
                                                    </a>
                                                    <small class="text-muted"><b>Id Card: </b></small>
                                                    <p>
                                                        <a href="{{ asset('images/users/' . $user->id_card )}}" target="__blanck">
                                                            {{ $user->document }}
                                                        </p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <small class="text-muted">Address: </small>
                                                <p>{{ $user->permanent_address }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="fullDetails">
                                    <form action="{{ route('update.details', $user->id) }}" method="post">
                                        @csrf
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Full Name:</label>                                             
                                                    <input type="text" 
                                                           class="form-control" 
                                                           value="{{ $user->full_name }}"
                                                           name="full_name">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Father Name:</label>                                             
                                                    <input type="text" 
                                                           class="form-control" 
                                                           value="{{ $user->father_name }}"
                                                           name="father_name">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Phone:</label>                                             
                                                    <input type="text" 
                                                           class="form-control" 
                                                           value="{{ $user->phone_number }}"
                                                           name="phone_number">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Reference Phone:</label>                                             
                                                    <input type="text" 
                                                           class="form-control" 
                                                           value="{{ $user->reference_number }}"
                                                           name="reference_number">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Country:</label>                                             
                                                    <input type="text" 
                                                           class="form-control" 
                                                           value="{{ $user->country }}"
                                                           name="country">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">State:</label>                                             
                                                    <input type="text" 
                                                           class="form-control" 
                                                           value="{{ $user->state }}"
                                                           name="state">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">City:</label>                                             
                                                    <input type="text" 
                                                           class="form-control" 
                                                           value="{{ $user->city }}"
                                                           name="city">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Permanent Address:</label>                                             
                                                    <input type="text" 
                                                           class="form-control" 
                                                           value="{{ $user->permanent_address }}"
                                                           name="permanent_address">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Current Address:</label>                                             
                                                    <input type="text" 
                                                           class="form-control" 
                                                           value="{{ $user->current_address }}"
                                                           name="current_address">
                                                </div>
                                            </div>
                                            <div class="col-12 mt-1">
                                                <input type="submit" class="btn btn-sm btn-dark" value="Update.">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="updateCredential">
                                     <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <form action="{{ route('update.credentials', $user->id)}}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="">UserName:</label>                                             
                                                    <input type="text" class="form-control" value="{{ $user->email }}" name="email"><hr>
                                                    <input type="password" class="form-control" value="" name="password" placeholder="Enter your new password."><hr>
                                                    <input type="submit" class="btn btn-sm btn-dark" value="Update.">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="updateFile">
                                     <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <form action="{{ route('update.files', $user->id)}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <p class="mb-2"><b>ID Card:</b></p>
                                                <div class="custom-file mb-1">
                                                    <input type="file" class="custom-file-input" id="id_card" name="id_card">
                                                    <label class="custom-file-label" for="id_card">{{ $user->id_card }}</label>
                                                </div>
                                                <p class="mb-2"><b>Documents:</b></p>
                                                <div class="custom-file mb-1">
                                                    <input type="file" class="custom-file-input" id="document" name="document">
                                                    <label class="custom-file-label" for="document">{{ $user->document }}</label>
                                                </div>
                                                <p class="mb-2"><b>Profile Picture:</b></p>
                                                <div class="custom-file mb-1">
                                                    <input type="file" class="custom-file-input" id="picture" name="profile_picture">
                                                    <label class="custom-file-label" for="picture">{{ $user->profile_picture }}</label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-sm btn-dark" value="Update.">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script>

    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

</script>
@endsection