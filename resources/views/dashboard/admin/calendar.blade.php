@extends('dashboard.admin.master')
@section('title', 'admin')

@section('styles')

<link rel="stylesheet" href="{{ asset('assets/vendor/fullcalendar/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
<!-- MAIN CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
<style>
    .fc .fc-popover {
        top: 50px !important;
    }
</style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Dashboard</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"  onclick="goBack()">Back</a>
                        </li>                            
                        <li class="breadcrumb-item active">Calendar</li>
                    </ul>
                </div>
                <div class="col-lg-2 text-right m-1">
                    <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addevent">
                        Add New Event
                    </a>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="body">
                        @if(Session::get('errorMsg'))
                            <span class="text-danger">{{ Session::get('errorMsg') }}</span>
                        @endif
                        @if(Session::get('successMsg'))
                            <span class="text-success">{{ Session::get('successMsg') }}</span>
                        @endif
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Default Size -->
<div class="modal fade" id="addevent" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="defaultModalLabel">Add Event</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="datetime-local" class="form-control" name="event_date" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" name="event_title" placeholder="Event Title" required>
                        </div>
                    </div>      
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                    <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Default Size -->
<div class="modal fade" id="updateEvent" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="" method="post" id="formUpdate">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="defaultModalLabel">Update Event</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="datetime-local" class="form-control" id="eventModalDate" name="event_date" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" id="eventModalTitle" name="event_title" placeholder="Event Title" required>
                        </div>
                    </div>      
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>    
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/fullcalendarscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/vendor/fullcalendar/fullcalendar.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script>
function goBack() {window.history.back();}
"use strict";

var events = @json($events);
var currentDate = moment().format('YYYY-MM-DD');
$('#calendar').fullCalendar({
    
    // other options...
    // eventRender: function(event, element) {
    //     element.find('.fc-title').append('<br/>').append(event.description);
    // },

    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
    },

    defaultDate: currentDate,
    editable: true,
    droppable: true, // this allows things to be dropped onto the calendar
    drop: function() {
        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
            // if so, remove the element from the "Draggable Events" list
            $(this).remove();
        }
    },
    eventLimit: true, // allow "more" link when too many events
    events: events.map(function(event) {
        return {
            title: event.event_title,
            start: event.event_date,
            event_id: event.id,
            className: 'bg-info'
        };
    }),

    // other options...
    eventClick: function(calEvent, jsEvent, view) {
        // show the modal dialog
        $('#updateEvent').modal('show');

        // format the start date to YYYY-MM-DDTHH:mm:ss format
        var start = moment(calEvent.start).format('YYYY-MM-DDTHH:mm:ss');

        //$('#eventModalDate').val(start);
        var start = new Date(calEvent.start);

        document.getElementById('eventModalDate').value = start.toISOString().slice(0, 16);
        $('#eventModalTitle').val(calEvent.title);
        // set the form's action URL to the update route for this event
        var eventId = calEvent.event_id
        var url = "{{ route('calendar.update', ['id' => ':id']) }}".replace(':id', eventId)
        $('#formUpdate').attr('action', url);
    }
    
});

</script>
@endsection