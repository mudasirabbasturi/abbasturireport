@extends('dashboard.admin.master')
@section('title', 'Report | Notifications')
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
                
                <button style="margin-bottom: 10px" class="btn btn-primary delete_all" data-url="{{ route('admin.notificatons.DestroyAll') }}">Delete All Selected</button>
                
                <table class="table" id="project_table" style="width:100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="master"></th>
                            {{-- <th>No</th> --}}
                            <th>Date</th>
                            {{-- <th>Notifier Name</th> --}}
                            <th>Title</th>
                            <th>Message</th>
                            <th>Url</th>
                            <th>Actions</th>
                        </tr>

                    </thead>
                    <tfoot>
                        <tr>
                            <th>CC_BX.</th>
                            {{-- <th>No</th> --}}
                            <th>Date</th>
                            {{-- <th>Notifier Name</th> --}}
                            <th>Title</th>
                            <th>Message</th>
                            <th>Url</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if($notifications->count())
                            @foreach ($notifications as $key => $notification)
                                <tr id="tr_{{$notification->id}}">
                                    <td>
                                        <input type="checkbox" class="sub_chk" data-id="{{$notification->id}}">
                                    </td>
                                    {{-- <td>{{ ++$key }}</td> --}}
                                    <td>
                                        {{ date('Y-m-d', strtotime($notification->created_at)) }}
                                    </td>
                                    {{-- <td>
                                    </td> --}}
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
                                        {{-- <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger">
                                            <i class="icon-trash"></i>
                                        </a> --}}
                                        <a href="{{ route('admin.notification.destroy',$notification->id) }}" class="btn btn-outline-danger btn-sm"
                                            data-tr="tr_{{$notification->id}}"
                                            data-toggle="confirmation"
                                            data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-remove"
                                            data-btn-ok-class="btn btn-sm btn-danger"
                                            data-btn-cancel-label="Cancel"
                                            data-btn-cancel-icon="fa fa-chevron-circle-left"
                                            data-btn-cancel-class="btn btn-sm btn-default"
                                            data-title="Are you sure you want to delete ?"
                                            data-placement="left" data-singleton="true">
                                            <i class="icon-trash"></i>
                                         </a>
                                         @if ($notification->userNotification->where('status', 0)->where('user_id', Auth::user()->id)->isNotEmpty())
                                         <a href="javascript:void(0);" 
                                             title=""
                                             onclick="confirmRead({{ $notification->id }})"
                                             data-toggle="popover" 
                                             data-trigger="hover" title="" 
                                             data-content="Click The CheckBox Icon To Mark As Read The Project." 
                                             data-original-title="Mark As Read."
                                             style="font-size: 18px">
                                             <i class="fa  fa-check-square-o"></i>           
                                         </a>
                                         <form id="markread-form-{{ $notification->id }}" action="{{ route('admin.notification.update', $notification->id) }}"
                                             method="POST" style="display: none;">
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
                                             data-trigger="hover" title="" 
                                             data-content="It is already marked as read." 
                                             data-original-title="Already Read."
                                             style="font-size: 18px">
                                             <i class="fa fa-check text-success"></i>
                                         </a>
                                     @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@include("dashboard.admin.notifications.script")
<script type="text/javascript">
    $(document).ready(function () {


        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);  
         } else {  
            $(".sub_chk").prop('checked',false);  
         }  
        });


        $('.delete_all').on('click', function(e) {


            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  


            if(allVals.length <=0)  
            {  
                alert("Please select row.");  
            }  else {  


                var check = confirm("Are you sure you want to delete this row?");  
                if(check == true){  


                    var join_selected_values = allVals.join(","); 


                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {  
                                    $(this).parents("tr").remove();
                                });
                                alert(data['success']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }  
            }  
        });


        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });


        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();


            $.ajax({
                url: ele.href,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });


            return false;
        });
    });
</script>
@endsection