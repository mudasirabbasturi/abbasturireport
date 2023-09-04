@extends('dashboard.employee.master')
@section('title', 'employee')

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
            .infohover:hover {
                color: #fff;
                background-color: #ffffff;
                border-color: #000000;
            }
</style>
@endsection

@section('content')
    <div class="container-fluid pb-5">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Project</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/employee"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"  onclick="goBack()">Back</a>
                        </li>
                        <li class="breadcrumb-item active">Details</li>
                    </ul>
                </div>
                <div class="col-lg-7 col-md-4 col-sm-12">
                    @include('dashboard.employee.message')
                </div>
            </div>
        </div>
        <div class="row clearfix">
        <div class="col-md-6 p-2">
                <div class="border formDataSubmit">
                    <div class="row m-0 p-0">
                        @foreach($projects as $project)
                            @if(!in_array($project->project_status, ['deliver', 'completed']))
                            <button class="btn btn-block mt-1 mb-1 btn-outline-info infohover">
                               @if ($project->actions->where('user_id', Auth::user()->id)->isNotEmpty())
                                    <span class="btnGoUpd"
                                        data-toggle="modal"
                                        data-target="#addMoreAction"
                                        data-id="{{ $project->actions->where('user_id', Auth::user()->id)->first()->id }}">
                                        <a href="javascript:void(0);" 
                                            class="text-success"
                                            title=""
                                            data-toggle="popover" 
                                            data-trigger="hover" title="" 
                                            data-content="You are Already Membered.Get Involved in more if have." 
                                            data-original-title="More Task if have."
                                            style="font-size: 18px">
                            
                                            <i class="fa fa-unlock-alt" aria-hidden="true">
                                                <sup style="font-size: 11px;">
                                                    <i class="fa fa-key" aria-hidden="true"></i>
                                                </sup>
                                            </i>
                            
                                        </a>
                                    </span>
                                
                                @else 
                                    <span data-toggle="modal" 
                                            data-target="#goIn"
                                            class="text-info btn-goIn"
                                            data-projectid="{{ $project->id }}"
                                            data-userid="{{ Auth::user()->id }}"
                                            style="cursor: pointer">
                        
                                        <a href="javascript:void(0);" 
                                            title=""
                                            data-toggle="popover" 
                                            data-trigger="hover" title="" 
                                            data-content="Click The Lock Icon And Get Involved In Project." 
                                            data-original-title="Get Involved."
                                            style="font-size: 18px">
                                            <i class="fa fa-lock">
                                                <sup style="font-size: 11px;"><i class="fa fa-key" aria-hidden="true"></i></sup>
                                            </i>           
                                        </a>
                        
                                    </span>
                                @endif
                            </button>
                            @else
                            @endif
                        <button 
                            data-toggle="modal"
                            data-target="#projSuccessMdl" 
                            data-projectid="{{ $project->project_id }}"
                            class="btn btn-block mt-1 mb-1 completeAction
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
                                @endif"
                          style="text-transform:capitalize;">

                    (Status:){{$project->project_status}}

                  </button>
                        @endforeach
                        <div class="col-12 mb-2 pt-2 pb-2 bg-warning">
                           <h6 class="text-dark mb-0">Please Update or Creat Missing Record.</h6>
                        </div>
                    </div>
                    @foreach($projects as $project)
                        <form action="{{ route('projectUpdate.store', $project->id) }}" method="POST">
                            @csrf
                            <div class="row p-2">
                                <div class="col-12"></div>
                                <div class="col-12 mb-2">
                                    <p class="mb-2"><b>Project area in square feet:</b></p>
                                    <input type="text" 
                                        class="form-control" 
                                        value="{{ $project->project_area }}" 
                                        name="project_area">
                                </div>
                                <div class="col-12 mb-2">
                                    <p class="mb-2"><b>Commercial Or Residential:</b></p>
                                    @if($project->project_commercial_residential == NULL)
                                    <select class="form-control" name="project_commercial_residential">
                                        <option value="" disabled selected>Choose...</option>
                                        <option value="Commercial">Commercial</option>
                                        <option value="Residential">Residential</option>
                                    </select>
                                    @else
                                    <input type="text" 
                                        class="form-control" 
                                        value="{{ $project->project_commercial_residential }}"
                                        name="project_commercial_residential">
                                    @endif
                                </div>
                                <div class="col-12 mb-2">
                                    <p class="mb-2"><b>Project Line Items Pricing:</b></p>
                                    <input type="text" class="form-control" 
                                        value="{{ $project->project_line_items_pricing }}"
                                        name="project_line_items_pricing">
                                </div>
                                <div class="col-12 mb-2">
                                    <p class="mb-2"><b>Floor Number:</b></p>
                                    <input type="text" 
                                        class="form-control"
                                        value="{{ $project->project_floor_number }}"
                                        name="project_floor_number">
                                </div>
                                <div class="col-12 mb-2">
                                    <p class="mb-2"><b>Project Scope Details:</b></p>
                                    <textarea name="project_scope_details"
                                              id="editor_mainScopes">
                                              {{ $project->project_scope_details }}
                                    </textarea>
                                    <div class="summernote"></div>
                                </div>
                                <div class="col-12 mb-2">
                                    <p class="mb-2"><b>Attach Note(employeeSide):</b></p>
                                    <textarea name="project_notes_offside"
                                              id="editor_attachNotes">
                                              {{ $project->project_notes_offside }}
                                    </textarea>
                                </div>
                                <div class="col-12 mb-2">
                                    <p class="mb-2"><b>Project Steps:</b></p>
                                    <input type="text" 
                                        class="form-control" 
                                        placeholder="excel,pricing,quality assurance"
                                        value="{{ $project->project_steps }}" 
                                        name="project_steps">
                                </div>
                                <div class="col-12 mb-2">
                                    <p class="mb-2"><b>Project Link:</b></p>
                                    <input type="url" 
                                        class="form-control" 
                                        placeholder="Submit Project Final Link."
                                        value="{{ $project->project_ofside_link }}" 
                                        name="project_ofside_link">
                                </div>
                                <div class="col-12 mb-2">
                                    <input type="submit" 
                                        value="Add Or Update Project" 
                                        class="btn btn-sm btn-dark">
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6 p-2">
                <div class="border border-bottom-0 mb-3" id="dataToWordDoc">
                    @foreach($projects as $project)
                    <div class="row m-0 p-0">
                        <div class="col-12 mb-2 pt-2 pb-2 bg-warning">
                            <h6 class="text-dark mb-0">From Office Side.</h6>
                        </div>
                        <div class="row m-0 pl-1">
                            <div class="col-12">
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Project Title: </b>
                                    {{ $project->project_title }}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Project Address: </b>
                                    {{ $project->project_address }}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Client Id: </b>
                                    {{ $project->project_client_id }}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Project Main Scope: </b>
                                    {!! $project->project_main_scope !!}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Project Template: </b>
                                    {{ $project->project_template }}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Project Link(officeSide): </b>
                                    @if(isset($project->project_onside_link))
                                        <a href="{{ $project->project_onside_link }}" target="_blank">
                                            Click the link.
                                        </a>
                                    @else
                                        None
                                    @endif
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Project Due Date: </b>
                                    {{ $project->project_due_date }}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Project Pricing: </b>
                                    {{ $project->project_pricing }}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Attact Notes(officeSide): </b>
                                    {!! $project->project_notes_onside !!}
                                </p>
                            </div>
                        </div>

                        <div class="col-12 mb-2 pt-2 pb-2 bg-warning">
                            <h6 class="text-dark mb-0">From Employee Side.</h6>
                        </div>
                        <div class="row m-0 pl-1">
                            <div class="col-12">
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Project area in square feet: </b>
                                    {{ $project->project_area }}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Commercial Or Residential: </b>
                                    {{ $project->project_commercial_residential }}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Project Line Items Pricing: </b>
                                    {{ $project->project_line_items_pricing }}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Floor Number: </b>
                                    {{ $project->project_floor_number }}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Project Steps: </b>
                                    {{ $project->project_steps }}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Project Scope Details:</b>
                                    {!! $project->project_scope_details !!}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Attach Notes(EmployeeSide): </b>
                                    {!! $project->project_notes_offside !!}
                                </p>
                                <p class="border border-bottom border-warning border-top-0 border-left-0 border-right-0 pb-1">
                                    <b>Project Link(officeSide): </b>
                                    @if(isset($project->project_ofside_link))
                                        <a href="{{ $project->project_ofside_link }}" target="_blank">
                                            Click the link.
                                        </a>
                                    @else
                                        None
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row border border-top-0 m-0 p-0">
                    <div class="col-12">
                        <input type="button" 
                               id="btn-export" 
                               onclick="exportHTML();"
                               value="Download." 
                               class="btn btn-sm btn-dark mb-2">
                    </div>
                </div>
            </div>
        </div>
        @include('dashboard.employee.modal')
    </div>
@endsection
@section('scripts')
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>    
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/pages/ui/dialogs.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
<script>
    function goBack() {window.history.back();}

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


        // Action Scripts 
        var btnGoInEle = document.getElementsByClassName('btn-goIn')
    for (i = 0; i < btnGoInEle.length; i++) {
        var btnClicked = btnGoInEle[i];
        btnClicked.addEventListener('click', function () {
            var prjIdEle = document.getElementById('project_id')
            var UsrIdEle = document.getElementById('user_id');
            var pid = this.dataset.projectid
            var uid = this.dataset.userid
            prjIdEle.value = pid
            UsrIdEle.value = uid
        })
    }
    var btnGoUpdEle = document.getElementsByClassName('btnGoUpd')
    for (i = 0; i < btnGoUpdEle.length; i++) {
        var btnClicked = btnGoUpdEle[i];
        btnClicked.addEventListener('click', function () {
            var actionId = this.dataset.id
            var url = "{{route('action.show', ['action' => ':id'])}}".replace(':id', actionId)
            const actionUpdatexhttp = new XMLHttpRequest()
            actionUpdatexhttp.onload = function () {
                var response = JSON.parse(this.responseText);
                var checkboxes = '';
                if (response.hasOwnProperty('message')) {
                    checkboxes = '<p>' + response['message'] + '</p>';
                } else {
                    for (var key in response) {
                        checkboxes += '<div class="fancy-checkbox">';
                        checkboxes += '<label>';
                        checkboxes += '<input type="checkbox" name="' + key + '" value="' + response[key] + '">';
                        checkboxes += '<span>' + response[key] + '</span>';
                        checkboxes += '</label>';
                        checkboxes += '</div>';
                    }
                }
                document.getElementById('updateChceckboxes').innerHTML = checkboxes;
            }
            actionUpdatexhttp.open("GET", url);
            actionUpdatexhttp.send();

            var updateFormEle = document.getElementById('actionUpdateForm')
            updateFormEle.action = "{{route('action.showUpdate', ['id' => ':id'])}}".replace(':id', actionId)
        })
    }

    

</script>
@endsection