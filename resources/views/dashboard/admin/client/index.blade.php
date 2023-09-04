@extends('dashboard.admin.master')
@section('title', 'Report | Clents')
@include('dashboard.admin.css')
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
                    <li class="breadcrumb-item active">Clients</li>
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
                <table class="table c_list" id="project_table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Client Name.</th>
                            <th>Client Notes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Client Name.</th>
                            <th>Client Notes</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->client_name }}</td>
                            <td class="client_notes">{!! $client->client_notes !!}</td>
                            <td>
                                <a href="{{ route('admin.client.edit', $client->client_id )}}" class="btn btn-info" title="Edit Detail.">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $client->client_id  }})">
                                    <i class="icon-trash"></i>
                                </a>
                                <form id="delete-form-{{ $client->client_id }}" action="{{ route('admin.client.destroy', $client->client_id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <script>
                                    function confirmDelete(id) {
                                        if (confirm('Are You Sure You Want To Delete This Client?')) {
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

@endsection
@section('scripts')
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>

$(document).ready(function () {
        var table = $('#project_table').DataTable({
            order: [[1, 'desc']],
    });
    
});
    
function goBack() {
    window.history.back();
}

    // Get all elements with class 'main_scope'
    const ClentsNotesEles = document.getElementsByClassName('client_notes');

    // Loop through each element and update its text content
    for (let i = 0; i < ClentsNotesEles.length; i++) {
        const ele = ClentsNotesEles[i];
        const text = ele.textContent;

        if (text.length > 80) {
            ele.style.cursor = "zoom-in"
            ele.textContent = text.substr(0, 80) + '...';

            ele.addEventListener('click', function () {
                if (ele.textContent === text) {
                    ele.textContent = text.substr(0, 80) + '...';
                } else {
                    ele.textContent = text;
                }
            });
        }
    }
</script>
@endsection