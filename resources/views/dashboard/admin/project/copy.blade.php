@extends('dashboard.admin.master')
@section('title', 'add employee')
@section('styles')

<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>

    hr {
        margin: 8px 0 !important;
    }

    .ck-editor__editable[role="textbox"] {
                /* editing area */
                min-height: 150px;
        }

</style>

@endsection

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                        <i class="fa fa-arrow-left"></i></a>Project</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"  onclick="goBack()">Back</a>
                    </li>
                    <li class="breadcrumb-item">Project</li>
                    <li class="breadcrumb-item active">Add Project</li>
                </ul>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <!-- <h2> Add Project</h2> -->
                    </div>
@foreach ($projects as $project)
                    <form action="{{ route('project.store') }}" method="POST">
                        @csrf
                        @if(Session::get('errorMsg'))
                        <span class="text-danger">{{ Session::get('errorMsg') }}</span>
                        @endif
                        @if(Session::get('successMsg'))
                        <span class="text-success">{{ Session::get('successMsg') }}</span>
                        @endif
                        <div class="body border">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2"><b>Project Title:</b></p>
                                    <input type="text" 
                                        class="form-control" 
                                        placeholder="Enter project title." 
                                        name="project_title"
                                        value="{{ $project->project_title }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2"><b>Project Address:</b></p>
                                    <input type="text" class="form-control" 
                                        placeholder="Enter project address." 
                                        name="project_address"
                                        value="{{ $project->project_address }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2"><b>Project Main Scope:</b></p>
                                    <textarea name="project_main_scope" id="editor_mainScopes">{!! $project->project_main_scope !!}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2"><b>Attach Notes:</b></p>
                                    <textarea name="project_notes_onside" id="editor_attachNotes">{!! $project->project_notes_onside !!}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2"><b>Client Id::</b></p>
                                    <input type="text" class="form-control" 
                                        placeholder="Enter Client Id." 
                                        name="project_client_id"
                                        value="{{ $project->project_client_id }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2"><b>Project Template:</b></p>
                                    <input type="text" 
                                        class="form-control" 
                                        placeholder="Enter project template in number." 
                                        name="project_template"
                                        value="{{ $project->project_template }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2"><b>Project Link:</b></p>
                                    <input type="url" 
                                        class="form-control" 
                                        placeholder="Enter Project Url eg. http://127.0.0.1:8000/admin/project/create" 
                                        name="project_onside_link"
                                        value="{{ $project->project_onside_link }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2"><b>Project Due Date:</b></p>
                                    <div class="input-group">
                                        <input type="datetime-local" 
                                            class="form-control" 
                                            name="project_due_date" 
                                            placeholder="03/10/2023">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2"><b>Project Pricing:</b></p>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" 
                                                class="form-check-input"
                                                name="project_pricing" 
                                                value="yes">Yes
                                        </label>
                                        </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" 
                                                class="form-check-input" 
                                                name="project_pricing" 
                                                value="no" checked>No
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <input type="submit" value="Add Project" class="btn btn-sm btn-dark">
                                </div>
                            </div>
                        </div>
                    </form>
@endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
<script>
    
    function goBack() {
        window.history.back();
    }

    ClassicEditor
        .create( document.querySelector( '#editor_mainScopes' ) )
        .catch( error => {
            console.error( error );
    } );

    ClassicEditor
        .create(document.querySelector('#editor_attachNotes'))
        .catch(error => {
            console.error(error);
    });
    
    var amtBudgetEle = document.getElementById('amount_budget');
    var deductionEle = document.getElementById('deduction');
    var totalPricetEle = document.getElementById('total_price');
    var currencyEle = document.getElementById('currency');

    var amount = amtBudgetEle.value;
    var deduction = deductionEle.value;
    var currency = currencyEle.value;

    amtBudgetEle.addEventListener('keyup', function() {
        amount = parseFloat(this.value);
        if(isNaN(amount) || !this.value) {
            totalPricetEle.value = '';
        } else {
            var totalPrice = amount - (amount * deduction / 100);
            totalPricetEle.value = currency + totalPrice;
        }
    });

    currencyEle.addEventListener('change', function(){
        currency = this.value;
        if(isNaN(amount)) {
            totalPricetEle.value = '';
        } else {
            var totalPrice = amount - (amount * deduction / 100);
            totalPricetEle.value = currency + totalPrice;
        }
    });

    deductionEle.addEventListener('keyup', function(){
        deduction = this.value;
        if(isNaN(amount)) {
            totalPricetEle.value = '';
        } else {
            var totalPrice = amount;
            if (deduction) {
                totalPrice -= amount * deduction / 100;
            }
            totalPricetEle.value = currency + totalPrice;
        }
    });

</script>
@endsection