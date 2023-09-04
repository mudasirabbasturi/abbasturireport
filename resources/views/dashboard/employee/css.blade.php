<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<!-- MAIN CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
<style>
        .table tbody tr td,
        .table tbody th td {
            white-space: unset !important;
        }

        #project_table .btn {
            display: inline-block;
            margin-bottom: 2px !important;
        }

        .table-responsive {
            padding-bottom: 10px;
        }

        .table-responsive::-webkit-scrollbar {
            height: 8px; /* Set the height of the scrollbar */
        }

        .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1; /* Set the background color of the scrollbar track */
        }

        .table-responsive::-webkit-scrollbar-thumb {
        background: #49C5B6; /* Set the color of the scrollbar thumb */
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #2F9588; /* Set the color of the scrollbar thumb on hover */
        }

        .table tbody tr td {
            padding: 3px 7px;
        }

        .time_indicator_table thead tr th,
        .time_indicator_table tbody tr td {
            padding: 2px 4px;
        }
        .table {
            background: #ecebeb;
        }

        .currentprogress {
            position: absolute;
            top: 100%;
            left: 0;
        }

        .sabtn {
        padding: 0 5px !important;
    }

</style>