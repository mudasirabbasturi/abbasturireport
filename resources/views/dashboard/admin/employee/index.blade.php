@extends('dashboard.admin.master')
@section('title', 'Employee')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
@endsection

@section('content')
<div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Employee</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Employee</li>
                        <li class="breadcrumb-item active">Employee List</li>
                    </ul>
                </div>            
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Employee List</h2>
                    </div>
                    @if(Session::get('successMsg'))
                     <span class="text-success">
                        {{ Session::get('successMsg') }}
                     </span>
                    @endif
                    <div class="body table-responsive">
                        <table class="table table-hover m-b-0 c_list" id="employee-table">
                            <thead>
                                <tr>
                                    <th>Name</th>   
                                    <th>Email</th>                                 
                                    <th>Phone</th>                                  
                                    <th>Country</th>                                  
                                    <th>State</th>                                  
                                    <th>City</th>   
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>   
                                    <th>Email</th>                                 
                                    <th>Phone</th>                                  
                                    <th>Country</th>                                  
                                    <th>State</th>                                  
                                    <th>City</th>   
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
    
                                    <td>
                                        <img src="{{ asset('images/users/' . $user->profile_picture) }}" 
                                             class="rounded-circle avatar" alt="{{ $user->full_name }}">
                                        <p class="c_name">{{ $user->full_name }}</p>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number }}</td>                                   
                                    <td>{{ $user->country }}</td>
                                    <td>{{ $user->state }}</td>
                                    <td>{{ $user->city }}</td>
                                    <td>
                                       <a href="{{ route('employee.show', $user->id) }}" class="btn btn-info" title="View Full Detail.">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $user->id }})">
                                            <i class="icon-trash"></i>
                                        </a>
                                        <form id="delete-form-{{ $user->id }}" action="{{ route('employee.destroy', $user) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <script>
                                            function confirmDelete(id) {
                                                if (confirm('Are you sure you want to delete this category?')) {
                                                    document.getElementById('delete-form-'+id).submit();
                                                }
                                            }
                                        </script>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>

        $(document).ready(function () {
            $('#employee-table').DataTable();
        });

    </script>
@endsection