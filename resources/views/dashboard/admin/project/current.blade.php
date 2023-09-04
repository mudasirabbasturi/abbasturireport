@extends('dashboard.admin.master')
@section('title', 'Report | Hold')
@include('dashboard.admin.css')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Dashboard</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin"><i class="icon-home"></i></a></li> 
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"  onclick="goBack()">Back</a>
                        </li>                           
                        <li class="breadcrumb-item active">Hold</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-12">
                <div class="body table-responsive mb-5">
                    @include('dashboard.admin.table')
                        @foreach($projects as $project)
                            @include('dashboard.admin.row')
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