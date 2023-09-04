@extends('dashboard.admin.master')
@section('title', 'Report | Chart')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css') }}">
<!-- MAIN CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
@endsection
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
                        <li class="breadcrumb-item active">Chart</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Project Visualization.</h2>
                    </div>
                    <div class="body">
                        <canvas id="bar-chart" class="ct-chart"></canvas>
                    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    function goBack() {window.history.back();}
    var projects = @json($projects);
    var labels = [];
    var data = [];
    projects.forEach(function(project) {
        var year = new Date(project.year, 0); // create a new date object for the year
        var month = new Date(year.getFullYear(), project.month - 1); // create a new date object for the month in the year
        labels.push(month.toLocaleString('default', { month: 'short' }) + ' ' + year.getFullYear()); // add the month and year to the labels array
        data.push(project.count);
    });

    var chartData = {
        labels: labels,
        datasets: [{
            label: 'Number of Projects',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            data: data,
        }]
    };

    var ctx = document.getElementById('bar-chart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        precision: 0
                    }
                }]
            }
        }
    });

    function monthName(monthNumber) {
        var d = new Date();
        d.setMonth(monthNumber - 1);
        return d.toLocaleString('default', { month: 'short' });
    }

    
</script>
@endsection