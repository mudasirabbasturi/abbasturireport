@extends('dashboard.employee.master')
@section('title', 'Employee | Calendar')
@section('styles')
@include('dashboard.employee.css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
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
                    <li class="breadcrumb-item"><a href="/admin"><i class="icon-home"></i></a></li> 
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"  onclick="goBack()">Back</a>
                    </li>                           
                    <li class="breadcrumb-item active">Calendar</li>
                </ul>
            </div>
            <div class="col-lg-7 col-md-4 col-sm-12">
                
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-12">
            <div class="body mb-5">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>    
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>

<script>


function goBack() {window.history.back();}
$(document).ready(function () {

   $.ajaxSetup({
       headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });

    var calendar = $('#calendar').fullCalendar({
        editable: false, // Disable editing
        events: "{{ route('employee.calender') }}",
        displayEventTime: false
    });
     
})
   
</script>
@endsection