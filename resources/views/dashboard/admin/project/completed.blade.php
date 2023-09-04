@extends('dashboard.admin.master')
@section('title', 'Report | Completed')
@include('dashboard.admin.css')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">                        
                <h2>
                    <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    Dashboard
                </h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/admin">
                            <i class="icon-home"></i>
                        </a>
                    </li> 
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"  onclick="goBack()">Back</a>
                    </li>                           
                    <li class="breadcrumb-item active">Completed</li>
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
                @include('dashboard.admin.table')
                    @foreach($projects as $project)
                        @if ($project->project_status == 'completed')
                            @include('dashboard.admin.row')
                        @endif
                    @endforeach
                    </tbody>
                </table>
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
@endsection