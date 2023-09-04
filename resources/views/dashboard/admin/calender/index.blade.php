@extends('dashboard.admin.master')
@section('title', 'Report | Projects')
@include('dashboard.admin.css')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
   
   var SITEURL = "{{ url('/') }}";
     
   $.ajaxSetup({
       headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
     
   var calendar = $('#calendar').fullCalendar({
                       editable: true,
                    // events: SITEURL + "/admin/calender",
                       events: "{{ route('admin.calender') }}",
                       displayEventTime: false,
                       editable: true,
                       eventRender: function (event, element, view) {
                           if (event.allDay === 'true') {
                                   event.allDay = true;
                           } else {
                                   event.allDay = false;
                           }
                       },
                       selectable: true,
                       selectHelper: true,
                       select: function (start, end, allDay) {
                           var title = prompt('Event Title:');
                           if (title) {
                               var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                               var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                               $.ajax({
                                   //url: SITEURL + "/fullcalenderAjax",
                                   url: "{{ route('admin.calender.add') }}",
                                   data: {
                                       title: title,
                                       start: start,
                                       end: end,
                                       type: 'add'
                                   },
                                   type: "POST",
                                   success: function (data) {
                                       displayMessage("Event Created Successfully");
     
                                       calendar.fullCalendar('renderEvent',
                                           {
                                               id: data.id,
                                               title: title,
                                               start: start,
                                               end: end,
                                               allDay: allDay
                                           },true);
     
                                       calendar.fullCalendar('unselect');
                                   }
                               });
                           }
                       },
                       eventDrop: function (event, delta) {
                           var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                           var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
     
                           $.ajax({
                               //url: SITEURL + '/fullcalenderAjax',
                               url: "{{ route('admin.calender.add') }}",
                               data: {
                                   title: event.title,
                                   start: start,
                                   end: end,
                                   id: event.id,
                                   type: 'update'
                               },
                               type: "POST",
                               success: function (response) {
                                   displayMessage("Event Updated Successfully");
                               }
                           });
                       },
                       eventClick: function (event) {
                           var deleteMsg = confirm("Do you really want to delete?");
                           if (deleteMsg) {
                               $.ajax({
                                   type: "POST",
                                   //url: SITEURL + '/fullcalenderAjax',
                                   url: "{{ route('admin.calender.add') }}",
                                   data: {
                                           id: event.id,
                                           type: 'delete'
                                   },
                                   success: function (response) {
                                       calendar.fullCalendar('removeEvents', event.id);
                                       displayMessage("Event Deleted Successfully");
                                   }
                               });
                           }
                       }
    
                   });
    
   });
    
   function displayMessage(message) {
       toastr.success(message, 'Event');
   } 
</script>
@endsection