@extends('dashboard.admin.master')
@section('title', 'add employee')
@section('styles')

<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    hr {
        margin: 8px 0 !important;
    }
</style>

@endsection

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                        <i class="fa fa-arrow-left"></i></a>Employee</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item">Employee</li>
                    <li class="breadcrumb-item active">Add Employee</li>
                </ul>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <!-- <h2> Add Project</h2> -->
                    </div>

                    <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(Session::get('errorMessage'))
                         <span class="text-danger">{{ Session::get('errorMessage') }}</span>
                        @endif
                        <div class="body border">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><b>Full Name:</b></p>
                                    <input type="text" 
                                           class="form-control" 
                                           placeholder="Enter Full Name"
                                           name="full_name" required>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><b>Father Full Name:</b></p>
                                    <input type="text" 
                                           class="form-control" 
                                           placeholder="Enter Father Full Name"
                                           name="father_name">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><b>Phone Number:</b></p>
                                    <input type="tel" class="form-control" name="phone_number" placeholder="123-45-678">
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><b>Reference Number:</b></p>
                                    <input type="tel" class="form-control" placeholder="123-45-678" name="reference_number">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><b>Email:</b></p>

                                    <input type="email" class="form-control" placeholder="Enter Email" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><b>Password:</b></p>
                                    <input type="password" class="form-control" placeholder="123456" name="password" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><b>Country:</b></p>
                                    <select class="custom-select" name="country">
                                        <option value="Pakistan" selected>Pakistan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><b>State:</b></p>
                                    <select class="custom-select" name="state">
                                        <option value="Punjab" selected>Punjab</option>
                                        <option value="Sindh">Sindh</option>
                                        <option value="Khyber Pakhtunkhwa">Khyber Pakhtunkhwa</option>
                                        <option value="Balochistan">Balochistan</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><b>City:</b></p>
                                    <input type="text" class="form-control" placeholder="Enter City" name="city">
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><b>Perminant Address:</b></p>
                                    <input type="text" 
                                           class="form-control" 
                                           placeholder="Enter Perminant Address"
                                           name="permanent_address">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><b>Current Address:</b></p>
                                    <input type="text" 
                                           class="form-control" 
                                           placeholder="Enter Current Address If Have"
                                           name="current_address">
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><b>ID Card:</b></p>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="id_card" name="id_card">
                                        <label class="custom-file-label" for="id_card">Choose Id Card</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><b>Document If Have:</b></p>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="document" name="document">
                                        <label class="custom-file-label" for="document">Choose Document</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><b>Picture:</b></p>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="picture" name="profile_picture">
                                        <label class="custom-file-label" for="picture">Choose Picture</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><b>Joining Date:</b></p>
                                    <input type="date" 
                                           class="form-control"
                                           name="joining_date">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="submit" value="Submit" class="btn btn-sm btn-dark">
                                </div>
                            </div>
                        </div>
                    </form>
                    @if (session('successMsg'))
                    <div class="alert alert-success">
                        {{ session('successMsg') }}
                    </div>
                    @endif
                    @if (session('errorMsg'))
                    <div class="alert alert-danger">
                        {{ session('errorMsg') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

<script>

    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

</script>

@endsection