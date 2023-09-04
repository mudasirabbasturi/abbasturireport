@extends('dashboard.admin.master')
@section('title', 'Report | Deliver')
@include('dashboard.admin.css')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                        <i class="fa fa-arrow-left"></i></a>Dashboard</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);" onclick="goBack()">Back</a>
                    </li>
                    <li class="breadcrumb-item active">Project Filter.</li>
                </ul>
            </div>
        </div>
        <hr>
        <form action="{{ route('project.FilterData') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="startDate">Date From:</label>
                        <input type="date" name="startDate" class="form-control" value="{{ $startDate ?? '2023-04-25' }}" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="endDate">Date To:</label>
                        <input type="date" name="endDate" class="form-control" value="{{ $endDate ?? '' }}" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="status">Select Status</label>
                        <select class="form-control" name="status">
                            <option value="Default All.">Default All.</option>
                            <option value="Pending" @if(isset($status) && $status === 'Pending') selected @endif>Pending</option>
                            <option value="Takeoff On Progress" @if(isset($status) && $status === 'Takeoff On Progress') selected @endif>Takeoff on progress</option>
                            <option value="Pricing On Progress" @if(isset($status) && $status === 'Pricing On Progress') selected @endif>Pricing On Progress</option>
                            <option value="Revision" @if(isset($status) && $status === 'Revision') selected @endif>Revision</option>
                            <option value="Hold" @if(isset($status) && $status === 'Hold') selected @endif>Hold</option>
                            <option value="Completed" @if(isset($status) && $status === 'Completed') selected @endif>Completed</option>
                            <option value="Deliver" @if(isset($status) && $status === 'Deliver') selected @endif>Deliver</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="userId">Select User</label>
                        <select class="form-control" name="userid">
                            <option value="Default None.">Default None.</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if(isset($userId) && $userId == $user->id) selected @endif>{{ $user->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="userId">Search Data</label>
                        <button type="submit" class="btn btn-sm btn-outline-success btn-block">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <hr>
    <div class="row clearfix">
        <div class="col-12 mb-5">
            <table class="table" id="project_table" style="width:100%">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Title</th>
                        <th>Project_Address</th>
                        <th>Dute_Date</th>
                        <th>Main_Scope</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Status</th>
                        <th>Title</th>
                        <th>Project_Address</th>
                        <th>Dute_Date</th>
                        <th>Main_Scope</th>
                    </tr>
                </tfoot>
                <tbody id="">
                    @if(isset($filteredProjects))
                        @foreach ($filteredProjects as $filteredProject)
                            <tr>
                                <td>{{ $filteredProject->project_status }}</td>
                                <td class="main_scope">{{ $filteredProject->project_title }}</td>
                                <td class="main_scope">{{ $filteredProject->project_address }}</td>
                                <td>{{ $filteredProject->project_due_date }}</td>
                                <td class="main_scope">{!! $filteredProject->project_main_scope !!}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modals Section -->
@include("dashboard.admin.modal")
<!-- End Of Modals Section -->
@endsection
@section('scripts')
@include("dashboard.admin.script")
@endsection