@extends('dashboard.admin.master')
@section('title', 'update client')
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
                    <li class="breadcrumb-item">Client</li>
                    <li class="breadcrumb-item active">Update Client</li>
                </ul>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <!-- <h2> Add Project</h2> -->
                    </div>

                    <form action="{{ route('admin.client.update', $client->client_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @if(Session::get('errorMsg'))
                         <span class="text-danger">{{ Session::get('errorMsg') }}</span>
                        @endif
                        @if(Session::get('successMsg'))
                         <span class="text-success">{{ Session::get('successMsg') }}</span>
                        @endif
                        <div class="body border">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2"><b>Client Name:</b></p>
                                    <input type="text" 
                                           class="form-control" 
                                           placeholder="Update Client Name." 
                                           name="client_name"
                                           value="{{ $client->client_name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-2"><b>Client Notes:</b></p>
                                    <textarea name="client_notes"
                                              id="client_notes">
                                              {{ $client->client_notes }}
                                    </textarea>
                                </div>
                                <div class="col-12">
                                    <input type="submit" value="Update Client" class="btn btn-sm btn-dark">
                                </div>
                            </div>
                        </div>
                    </form>
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
        .create( document.querySelector( '#client_notes' ) )
        .catch( error => {
            console.error( error );
    } );

</script>
@endsection