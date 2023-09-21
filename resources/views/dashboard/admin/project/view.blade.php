@extends('dashboard.admin.master')
@section('title', 'Project | View')

@section('styles')

<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">

<!-- MAIN CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">
<style>
    .ck-editor__editable[role="textbox"] {
        /* editing area */
        min-height: 150px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid pb-5">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i
                            class="fa fa-arrow-left"></i></a>Project</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);" onclick="goBack()">Back</a>
                    </li>
                    <li class="breadcrumb-item active">Details</li>
                </ul>
            </div>
            <div class="col-lg-7 col-md-4 col-sm-12">
                @if(Session::get('errorMsg'))
                <span class="text-danger">{{ Session::get('errorMsg') }}</span>
                @endif
                @if(Session::get('successMsg'))
                <span class="text-success">{{ Session::get('successMsg') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-6 p-2">
            <div class="border formDataSubmit">
                <div class="row m-0 p-0">
                    {{-- data-toggle="modal" data-target="#status_action" data-id="{{ $project->id }}" --}}
                    <button class="btn btn-block mt-1 mb-1
                                        @if ($project->project_status == 'pending')
                                            btn-outline-warning
                                        @elseif ($project->project_status == 'Takeoff On Progress')
                                            btn-outline-primary
                                        @elseif ($project->project_status == 'Pricing On Progress')
                                            btn-outline-primary
                                        @elseif ($project->project_status == 'completed')
                                            btn-outline-info
                                        @elseif ($project->project_status == 'deliver')
                                            btn-outline-success
                                        @elseif ($project->project_status == 'hold')
                                            btn-outline-danger
                                        @elseif ($project->project_status == 'revision')
                                            btn-outline-danger
                                        @endif" style="text-transform:capitalize;">

                        (Status:){{$project->project_status}}

                    </button>
                    <div class="col-12 mb-2 pt-2 pb-2 bg-warning">
                        <h6 class="text-dark mb-0">
                            Please Update or Creat Missing Record.
                        </h6>
                    </div>
                </div>
                <form action="{{ route('project.update', $project->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row p-2">
                        <div class="col-12"></div>
                        <div class="col-12 mb-2">
                            <p class="mb-2"><b>Project Title:</b></p>
                            <input type="text" class="form-control" placeholder="Enter project title."
                                value="{{ $project->project_title }}" name="project_title">
                        </div>
                        <div class="col-12 mb-2">
                            <p class="mb-2"><b>Project Address:</b></p>
                            <input type="text" class="form-control" placeholder="Enter project address."
                                name="project_address" value="{{ $project->project_address }}">
                        </div>
                        <div class="col-12 mb-2">
                            <select name="project_status" class="form-control mb-2">
                                <option value="">Current ({{ $project->project_status }})</option>

                            @php
                            
                               $statuses = [
                                            "Pending", 
                                            "Takeoff On progress", 
                                            "Pricing On Progress", 
                                            "Revision",
                                            "Hold", 
                                            "Completed", 
                                            "Deliver"];

                             @endphp
                                @foreach ($statuses as $status)
                                    @if ($status != $project->project_status)
                                    <option value="">{{ $status }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-2">
                            <p class="mb-2"><b>Client Name & Notes:</b></p>
                            @if ($project->project_client_name)
                            <input type="text" class="form-control mb-2" value="{{ $project->project_client_name }}"
                                readonly>
                            <textarea name="project_client_notes" id="project_client_notes">
                                        {{ $project->project_client_notes }}
                                </textarea>
                            @else
                            <input type="text" class="form-control mb-2" value="None Please Select Any if having notes."
                                readonly>
                            <select name="project_client_id" id="project_client_id" class="form-control mb-2"
                                onchange="clientsFunction(this)">
                                <option value="">Default (none)</option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->client_id }}">{{ $client->client_name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="project_client_name" id="project_client_name">
                            <div id="clientNotes" style="display:none;">
                                <p class="mb-2"><b>Client Attach Notes:</b></p>
                                <textarea name="project_client_notes" id="project_client_notes">
                                    </textarea>
                            </div>
                            @endif
                        </div>
                        <div class="col-12 mb-2">
                            <p class="mb-2"><b>Project Main Scope:</b></p>
                            <textarea name="project_main_scope" id="editor_mainScopes">
                                            {{ $project->project_main_scope }}
                                </textarea>
                        </div>

                        <div class="col-md-6 mb-2">
                            <p class="mb-2"><b>Project Template:</b></p>
                            <input type="text" class="form-control" placeholder="Enter project template in number."
                                name="project_template" value="{{ $project->project_template }}">
                        </div>
                        <div class="col-md-6 mb-2">
                            <p class="mb-2"><b>Project Pricing:</b></p>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="project_pricing" value="yes" {{
                                        $project->project_pricing == 'yes' ? 'checked' : '' }}>Yes
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="project_pricing" value="no" {{
                                        $project->project_pricing == 'no' ? 'checked' : '' }}>No
                                </label>
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <p class="mb-2"><b>Project Link(officeSide):</b></p>
                            <input type="url" class="form-control"
                                placeholder="Enter Project Url eg. http://127.0.0.1:8000/admin/project/create"
                                name="project_onside_link" value="{{ $project->project_onside_link }}">
                        </div>
                        <div class="col-12 mb-2">
                            <p class="mb-2"><b>Project Due Date:</b></p>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" name="project_due_date"
                                    value="{{$project->project_due_date}}">
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <p class="mb-2"><b>Attach Notes(officeSide):</b></p>
                            <textarea name="project_notes_onside" id="editor_attachNotes">
                                            {{ $project->project_notes_onside }}
                                </textarea>
                        </div>
                        <div class="col-md-4 mb-2">
                            <p class="mb-2"><b>Project Budget:</b></p>
                            <div class="input-group">
                                <input type="number" class="form-control" value="{{ $project->project_budget }}" min="0"
                                    id="amount_budget" name="project_budget">

                                <div class="input-group-append">
                                    <select class="custom-select" id="currency">
                                        <option value="$">$</option>
                                        <option value="RS" selected>RS</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <p class="mb-2"><b>Any deduction in %:</b></p>
                            <input type="number" class="form-control" name="project_deduction" id="deduction"
                                value="{{ $project->project_deduction }}" placeholder="Enter Percent in number if have"
                                min="0">
                        </div>
                        <div class="col-md-4 mb-2">
                            <p class="mb-2"><b>Total:</b></p>
                            <input type="text" class="form-control" value="{{ $project->project_total_price }}"
                                name="project_total_price" id="total_price" readonly>
                        </div>
                        <div class="col-12 mb-2">
                            <input type="submit" value="Add Or Update Project" class="btn btn-sm btn-dark">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6 p-2">
            <div class="border border-bottom-0 mb-3" id="dataToWordDoc">
                <div class="row m-0 p-0">
                    <div class="col-12">
                        <ul class="list-unstyled team-info">
                            @if ($project->actions->count() > 0)
                            @foreach ($project->actions as $action)
                            <li>
                                <a href="javascript:void(0);" class="report" data-toggle="modal" data-target="#report"
                                    data-aid="{{ $action->id }}" data-uid="{{ $action->user_id}}">
                                    <img src="{{ asset('images/users/'.$action->user->profile_picture) }}"
                                        alt="{{ $action->user->full_name }}">
                                </a>
                            </li>
                            @endforeach
                            @else
                            <li>None Involved</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-12 mb-2 pt-2 pb-2 bg-warning">
                        <h6 class="text-dark mb-0">From Office Side.</h6>
                    </div>
                    <div class="row m-0 pl-1">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                                    <b>Project Title: </b>
                                    {{ $project->project_title }}
                                </div>
                                <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                                    <b>Project Address: </b>
                                    {{ $project->project_address }}
                                </div>
                                @if ($project->project_client_name)
                                <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                                    <b>Client Name: </b>
                                    {{ $project->project_client_name }}
                                </div>
                                <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                                    <b>Client Notes: </b>
                                    {!! $project->project_client_notes !!}
                                </div>
                                @else
                                <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                                    <b>Client Notes:</b> None
                                </div>
                                @endif
                                <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                                    <b>Project Main Scope: </b>
                                    {!! $project->project_main_scope !!}
                                </div>
                                <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                                    <b>Project Template: </b>
                                    {{ $project->project_template }}
                                </div>
                                <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                                    <b>Project Link(officeSide): </b>
                                    @if(isset($project->project_onside_link))
                                    <a href="{{ $project->project_onside_link }}" target="_blank">
                                        Click the link.
                                    </a>
                                    @else
                                    None
                                    @endif
                                </div>
                                <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                                    <b>Project Due Date: </b>
                                    {{ $project->project_due_date }}
                                </div>
                                <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                                    <b>Project Pricing: </b>
                                    {{ $project->project_pricing }}
                                </div>
                                <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                                    <b>Attach Notes(officeSide): </b>
                                    {!! $project->project_notes_onside !!}
                                </div>
                                <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                                    <b>Project Total Price: </b>
                                    {{ $project->project_total_price }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-2 pt-2 pb-2 bg-warning">
                        <h6 class="text-dark mb-0">From Employee Side.</h6>
                    </div>
                    <div class="row m-0 pl-1">
                        <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                            <b>Project area in square feet: </b>
                            {{ $project->project_area }}
                        </div>
                        <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                            <b>Commercial Or Residential: </b>
                            {{ $project->project_commercial_residential }}
                        </div>
                        <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                            <b>Project Line Items Pricing: </b>
                            {{ $project->project_line_items_pricing }}
                        </div>
                        <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                            <b>Floor Number: </b>
                            {{ $project->project_floor_number }}
                        </div>
                        <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                            <b>Project Scope Details: </b>
                            {!! $project->project_scope_details !!}
                        </div>
                        <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                            <b>Attach Notes(employeeSide): </b>
                            {!! $project->project_notes_offside !!}
                        </div>
                        <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                            <b>Project Steps: </b>
                            {{ $project->project_steps }}
                        </div>
                        <div class="col-12 border border-warning pl-2 pt-1 pb-1 mb-2">
                            <b>Project Link(employeeSide): </b>
                            @if(isset($project->project_ofside_link))
                            <a href="{{ $project->project_ofside_link }}" target="_blank">
                                Click the link.
                            </a>
                            @else
                            None
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <div class="row border border-top-0 m-0 p-0">
                <div class="col-12">
                    <input type="button" id="btn-export" onclick="exportHTML();" value="Download."
                        class="btn btn-sm btn-dark mb-2">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modals Section -->
@include("dashboard.admin.modal")
<!-- End Of Modals Section -->
@endsection
@section('scripts')
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
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
    const editor = ClassicEditor
        .create(document.querySelector('#project_client_notes'))
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
    function exportHTML(){
       var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
       var footer = "</body></html>";
       var sourceHTML = header+document.getElementById("dataToWordDoc").innerHTML+footer;
       var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
       var fileDownload = document.createElement("a");
       document.body.appendChild(fileDownload);
       fileDownload.href = source;
       fileDownload.download = 'document.doc';
       fileDownload.click();
       document.body.removeChild(fileDownload);
    }

    function clientsFunction(e) {
        const id = e.value;
        if (e.value === "") {
            $("#clientNotes").fadeOut("slow");
            $("#project_client_name").val("");
            editor.then(newEditor => {
                        newEditor.setData("");
                    }).catch(error => {
                        console.error(error);
            });

        } else {
            $("#clientNotes").hide().fadeIn("slow");
            const url = "{{ route('clients.data', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    const clientNotes = response.client_notes;
                    const clientName = response.client_name;
                    $("#project_client_name").val(clientName);
                    editor.then(newEditor => {
                        newEditor.setData(clientNotes);
                    }).catch(error => {
                        console.error(error);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    }

    var projRprEle = document.getElementsByClassName("report")
    for (i = 0; i < projRprEle.length; i++) {
        btnClicked = projRprEle[i]
        btnClicked.addEventListener('click', EmployeeReport)
    }
    function EmployeeReport() {
        actionId = this.dataset.aid
        var url = "{{ route('report.show', ['id' => ':id']) }}".replace(':id', actionId)

        var imageSrc = this.querySelector('img').getAttribute('src');
        var userName = this.querySelector('img').getAttribute('alt');

        // set the image source and user name in the modal

        document.getElementById('user_task_image').setAttribute('src', imageSrc);
        document.getElementById('userName').textContent = userName;

        const xhttp = new XMLHttpRequest()
        xhttp.onload = function () {
            var response = JSON.parse(this.responseText);
            var data = response.data
            var perc = response.percent
            var percetGroups = '';
            for (var key in perc) {
                percetGroups += '<div class="progress mb-1" style="background: #dee2e6;">';
                percetGroups += '<div class="progress-bar bg-success text-dark" style="width:' + perc[key] + '%">' + key + ': ' + perc[key] + ' %</div>';
                percetGroups += '</div>';
            }
            document.getElementById('user_task_report').innerHTML = percetGroups;
            //document.getElementById('user_task_image').setAttribute('src', imageSrc);
        }
        xhttp.open("GET", url);
        xhttp.send();
    }
</script>
@endsection