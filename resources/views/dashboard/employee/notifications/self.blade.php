@extends('dashboard.employee.master')
@section('title', 'Report | Notifications')
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
                    <li class="breadcrumb-item"><a href="/admin"><i class="icon-home"></i></a></li> 
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"  onclick="goBack()">Back</a>
                    </li>                           
                    <li class="breadcrumb-item active">Notifications.</li>
                </ul>
            </div>
            <div class="col-lg-7 col-md-4 col-sm-12">
                @include('dashboard.admin.message')
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-12">
            <div class="body table-responsive mb-5">
                <table class="table" id="project_table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Url</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Url</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($notifications as $notification)
                            <tr>
                                <td>
                                    {{ date('Y-m-d h:i:s A', strtotime($notification->created_at)) }}
                                </td>
                                <td class="notifictionTitle">{{ $notification->title }}</td>
                                <td class="notifictionMessage">{{ $notification->message }}</td>
                                <td>
                                    @if ($notification->url)
                                     <a href="{{ $notification->url }}"
                                        class="btn btn-sm btn-outline-success">
                                         Link Url.
                                     </a>
                                     @else 
                                     None
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $status = null;
                                        foreach ($notification->userNotification as $userNotification) {
                                            if ($userNotification->user_id === Auth::user()->id) {
                                                $status = $userNotification->status;
                                                break;
                                            }
                                        }
                                    @endphp
                                    @if ($status === 0)
                                        <a href="javascript:void(0);" 
                                            title=""
                                            onclick="confirmRead({{ $notification->id }})"
                                            data-toggle="popover" 
                                            data-trigger="hover" 
                                            title="" 
                                            data-content="Click The CheckBox Icon To Mark As Read The Project." 
                                            data-original-title="Mark As Read."
                                            style="font-size: 18px">
                                            <i class="fa fa-check-square-o"></i>           
                                        </a>
                                        <form id="markread-form-{{ $notification->id }}" action="{{ route('employee.notification.update', $notification->id) }}"
                                            method="POST" style="display: none;">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" value="1" name="status">
                                        </form>
                                        <script>
                                            function confirmRead(id) {
                                                if (confirm('Are you sure you want to mark as read Notification?')) {
                                                    document.getElementById('markread-form-' + id).submit();
                                                }
                                            }
                                        </script>
                                    @else
                                        <a href="javascript:void(0);" 
                                            title=""
                                            data-toggle="popover" 
                                            data-trigger="hover" 
                                            title="" 
                                            data-content="It is already marked as read." 
                                            data-original-title="Already Read."
                                            style="font-size: 18px">
                                            <i class="fa fa-check text-success"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@include("dashboard.employee.notifications.script")
@endsection