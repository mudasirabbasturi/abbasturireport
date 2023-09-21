@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css') }}" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<!-- MAIN CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
        .table tbody tr td,
        .table tbody th td {
            white-space: unset !important;
        }
        
        #project_table .btn {
            display: inline-block;
            margin-bottom: 2px !important;
        }
        .indicator {
            width: 100%;
        }

        .indicator thead tr th {
            padding: 0px 3px;
            margin: 0px;
        }
        .indicator tbody tr td {
            padding: 0px 3px;
            margin: 0px;
            border: 0px;
        } 

        .table-responsive {
            padding-bottom: 10px;
        }

        .table-responsive::-webkit-scrollbar {
            height: 8px; 
        }

        .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1; 
        }

        .table-responsive::-webkit-scrollbar-thumb {
        background: #49C5B6; 
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #2F9588; 
        }


    .ck-editor__editable[role="textbox"] {
                /* editing area */
                min-height: 150px;
        }
    
    .main_scope {
        min-width: 200px !important;
    }

        
</style>
@endsection