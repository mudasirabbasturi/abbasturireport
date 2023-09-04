@extends('dashboard.admin.master')
@section('title', 'Employee | Paysallary')
@include('dashboard.admin.css')
<style>
    #salaryCreate hr{
        margin-top: .5rem !important;
        margin-bottom: .5rem !important;
    }
</style>
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
                    <li class="breadcrumb-item active">Pay Salary.</li>
                </ul>
            </div>
            <div class="col-lg-7 col-md-4 col-sm-12">
                @include('dashboard.admin.message')
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-9">
            <div class="body border p-2" id="salaryCreate">
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6"><p class="mb-2"><b>Select Employee:</b></p></div>
                        <div class="col-6"><p class="mb-2"><b>Net Salary:</b></p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-6">
                            <select class="custom-select" name="notification_to" required>
                                <option selected disabled>None</option>
                                @foreach ($users as $user)
                                  <option value="{{ $user->full_name }}">{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-6"><p class="mb-2"><b>Earnings:</b></p></div>
                        <div class="col-6"><p class="mb-2"><b>Deductions:</b></p></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2">Basic</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                        <div class="col-6">
                            <p class="mb-2">TDS</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2">DA(40%)</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                        <div class="col-6">
                            <p class="mb-2">ESI</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2">HRA(15%)</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                        <div class="col-6">
                            <p class="mb-2">PF</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2">Conveyance</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                        <div class="col-6">
                            <p class="mb-2">Leave</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2">Allowance</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                        <div class="col-6">
                            <p class="mb-2">Prof. Tax</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2">Medical Allowance</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                        <div class="col-6">
                            <p class="mb-2">Labour Welfare</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2">Other</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                        <div class="col-6">
                            <p class="mb-2">Other</p>
                            <input type="number" 
                                   class="form-control" 
                                   placeholder="Enter Amount In number"
                                   name="title">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@include("dashboard.admin.payroll.script")
@endsection