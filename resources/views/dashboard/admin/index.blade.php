@extends('dashboard.admin.master')
@section('title', 'Report | Projects')
@include('dashboard.admin.css')

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
                        <a href="javascript:void(0);" onclick="goBack()">Back</a>
                    </li>
                    <li class="breadcrumb-item active">Projects</li>
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
                {{-- @include('dashboard.admin.table')
                @foreach($projects as $project)
                @if ($project->project_status != 'deliver')
                @include('dashboard.admin.row')
                @endif
                @endforeach
                </tbody>
                </table> --}}

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#pending"  style="color: #e37300;">
                            Pending
                            <sup style="color: #e37300;">
                                <b>{{ $ProjectPendingCount }}</b>
                            </sup>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" data-toggle="tab" href="#takeOfOnProgress">
                            TakeOff On Progress
                            <sup class="text-primary">
                                <b>{{ $ProjectTakeOfOnProgressCount }}</b>
                            </sup>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-info" data-toggle="tab" href="#pricingOnProgress">
                            Pricing On Progress
                            <sup class="text-info">
                                <b>{{ $ProjectPricingOnProgressCount }}</b>
                            </sup>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-success" data-toggle="tab" href="#completed">
                            Completed
                            <sup class="text-success">
                                <b>{{ $ProjectCompletedCount }}</b>
                            </sup>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" data-toggle="tab" href="#hold">
                            Hold
                            <sup class="text-danger">
                                <b>{{ $ProjectHoldCount }}</b>
                            </sup>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" data-toggle="tab" href="#revision">
                            Revision
                            <sup class="text-danger">
                                <b>{{ $ProjectRevisionCount }}</b>
                            </sup>
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="tab-content pt-2">
                    <div class="tab-pane show active" id="pending">
                        <table id="pendingTable" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>Project Address</th>
                                    <th>Project Title</th>
                                    <th>Main Scope</th>
                                    <th class="due_date_time_indicator">Due Date</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Project Address</th>
                                    <th>Project Title</th>
                                    <th>Main Scope</th>
                                    <th class="due_date_time_indicator">Due Date</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($projects as $project)
                                @if ($project->project_status == 'pending')
                                @include('dashboard.admin.home_row')
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="takeOfOnProgress">
                        <table id="takeOfOnProgressTable" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>Project Address</th>
                                    <th>Project Title</th>
                                    <th>Main Scope</th>
                                    <th class="due_date_time_indicator">Due Date</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Project Address</th>
                                    <th>Project Title</th>
                                    <th>Main Scope</th>
                                    <th class="due_date_time_indicator">Due Date</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($projects as $project)
                                @if ($project->project_status == 'Takeoff On Progress')
                                @include('dashboard.admin.home_row')
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="pricingOnProgress">
                        <table id="pricingOnProgressTable" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>Project Address</th>
                                    <th>Project Title</th>
                                    <th>Main Scope</th>
                                    <th class="due_date_time_indicator">Due Date</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Project Address</th>
                                    <th>Project Title</th>
                                    <th>Main Scope</th>
                                    <th class="due_date_time_indicator">Due Date</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($projects as $project)
                                @if ($project->project_status == 'Pricing On Progress')
                                @include('dashboard.admin.home_row')
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="completed">
                        <table id="completedTable" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>Project Address</th>
                                    <th>Project Title</th>
                                    <th>Main Scope</th>
                                    <th class="due_date_time_indicator">Due Date</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Project Address</th>
                                    <th>Project Title</th>
                                    <th>Main Scope</th>
                                    <th class="due_date_time_indicator">Due Date</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($projects as $project)
                                @if ($project->project_status == 'completed')
                                @include('dashboard.admin.home_row')
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="hold">
                        <table id="holdTable" class="table table-striped table-bordered" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>Project Address</th>
                                    <th>Project Title</th>
                                    <th>Main Scope</th>
                                    <th class="due_date_time_indicator">Due Date</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Project Address</th>
                                    <th>Project Title</th>
                                    <th>Main Scope</th>
                                    <th class="due_date_time_indicator">Due Date</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($projects as $project)
                                @if ($project->project_status == 'hold')
                                @include('dashboard.admin.home_row')
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="revision">
                        <table id="revisionTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Project Address</th>
                                    <th>Project Title</th>
                                    <th>Main Scope</th>
                                    <th class="due_date_time_indicator">Due Date</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Project Address</th>
                                    <th>Project Title</th>
                                    <th>Main Scope</th>
                                    <th class="due_date_time_indicator">Due Date</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($projects as $project)
                                @if ($project->project_status == 'revision')
                                @include('dashboard.admin.home_row')
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Modals Section -->
@include("dashboard.admin.modal")
<!-- End Of Modals Section -->
@endsection
@section('scripts')
@include("dashboard.admin.script")
<script>
    $('.nav-tabs a').click(function() {
    DataTable.tables({ visible: true, api: true }).columns.adjust();
    // setTimeout(function() {
    //     DataTable.tables({ visible: true, api: true }).columns.adjust();
    // }, 50);
});

 
var newTable = new DataTable('table.table')

    function TimeIndicators() {
        $('.time_indicator').each(function () {
            var dueDateStr = $(this).data('due-date');
            var dueDate = new Date(dueDateStr);
            setInterval(function () {
                var now = new Date();
                var diffMs = dueDate - now;
                if (diffMs < 0) {
                    $(this).find('.days').text("00");
                    $(this).find('.hours').text("00");
                    $(this).find('.minutes').text("00");
                    $(this).find('.seconds').text("00");
                    $(this).addClass("text-danger");
                    return;
                }
                var diffDays = Math.floor(diffMs / 86400000);
                var diffHrs = Math.floor((diffMs % 86400000) / 3600000);
                var diffMins = Math.floor(((diffMs % 86400000) % 3600000) / 60000);
                var diffSecs = Math.floor((((diffMs % 86400000) % 3600000) % 60000) / 1000);
                $(this).find('.days').text(diffDays.toString().padStart(2, '0'));
                $(this).find('.hours').text(diffHrs.toString().padStart(2, '0'));
                $(this).find('.minutes').text(diffMins.toString().padStart(2, '0'));
                $(this).find('.seconds').text(diffSecs.toString().padStart(2, '0'));
            }.bind(this), 1000);
        });
    }
    TimeIndicators() 


    var pendingTable = $('#pendingTable').DataTable()
    pendingTable.on('draw.dt', function () {
        TimeIndicators() 
    });
    var takeOfOnProgressTable = $('#takeOfOnProgressTable').DataTable()
    takeOfOnProgressTable.on('draw.dt', function () {
        TimeIndicators() 
    });
    var pricingOnProgressTable = $('#pricingOnProgressTable').DataTable()
    pricingOnProgressTable.on('draw.dt', function () {
        TimeIndicators() 
    });

    var completedTables = $('#completedTable').DataTable()
    completedTables.on('draw.dt', function () {
        TimeIndicators() 
    });

    var holdTables = $('#holdTable').DataTable()
    holdTables.on('draw.dt', function () {
        TimeIndicators() 
    });
    var revisionTables = $('#revisionTable').DataTable()
    revisionTables.on('draw.dt', function () {
        TimeIndicators() 
    });
   
 
</script>
@endsection