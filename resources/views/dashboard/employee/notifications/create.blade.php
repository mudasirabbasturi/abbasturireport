@extends('dashboard.employee.master')
@section('title', 'Notification | Create')
@include('dashboard.employee.css')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">                        
                <h2>
                    <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                        <i class="fa fa-arrow-left"></i>
                    </a>Dashboard
                </h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/employee"><i class="icon-home"></i></a></li> 
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"  onclick="goBack()">Back</a>
                    </li>                           
                    <li class="breadcrumb-item active">Add Notification.</li>
                </ul>
            </div>
            <div class="col-lg-7 col-md-4 col-sm-12">
                @include('dashboard.admin.message')
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-6">
            <div class="body border p-2">
                <form action="{{ route("employee.notification.store") }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-2">
                            <p class="mb-2"><b>Title:</b></p>
                            <input type="text" 
                                   class="form-control" 
                                   placeholder="Enter Notification Title"
                                   name="title">
                        </div>
                        <div class="col-12 mb-2">
                            <p class="mb-2"><b>Message:</b></p>
                            <textarea name="message" rows="5" class="form-control" placeholder="Enter Notification Message"></textarea>
                        </div>
                        <div class="col-12 mb-2">
                            <input type="hidden" name="notification_from" value="{{ Auth::user()->id }}">
                            <p class="mb-2"><b>Select User: (To All Leave As Default)</b></p>
                            <select class="custom-select" name="notification_to">
                                <option value="" selected>To All</option>
                                @foreach ($users as $user)
                                  <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-2">
                            <p class="mb-2"><b>Url:</b></p>
                            <input type="url" 
                                   name="url" 
                                   class="form-control"
                                   placeholder="Enter Project or something else url if have.">
                        </div>
                        <div class="col-md-6">
                            <input type="submit" value="Submit" class="btn btn-sm btn-dark">
                        </div>
                    </div>
                </form>
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
    function goBack() {
        window.history.back();
    }
</script>
@endsection