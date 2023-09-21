<style>
    @media (min-width: 576px) {
     #addProjectModalWidth {
        max-width: 70%;
      }
      #StatusProjectModalWidth {
        max-width: 60%;
      }
    }
    #addProjectModalWidth {
        max-width: 70%;
     }
     #StatusProjectModalWidth {
        max-width: 60%;
     }
</style>
<!-- Add Project Modal Start -->
<div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document" id="addProjectModalWidth">
        <div class="modal-content">
            <div class="modal-header m-0 pt-0 pb-0 pr-0" style="background: #11A7BB;align-items: center;">
                <h6 class="text-white m-0 p-0">Add Your Project.</h6>
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal"><small><b>Close</b></small></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('project.store') }}" method="POST">
                    @csrf
                    <div class="body border">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p class="mb-2"><b>Project Title:</b></p>
                                <input type="text" 
                                       class="form-control" 
                                       placeholder="Enter project title." 
                                       name="project_title">
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="mb-2"><b>Project Address:</b></p>
                                <input type="text" class="form-control" 
                                       placeholder="Enter project address." 
                                       name="project_address">
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="mb-2"><b>Project Main Scope:</b></p>
                                <textarea name="project_main_scope"
                                          id="editor_mainScopes">
                                </textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="mb-2"><b>Attach Notes:</b></p>
                                <textarea name="project_notes_onside"
                                          id="editor_attachNotes">
                                          
                                </textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="mb-2"><b>Client Name:</b></p>
                                <select name="project_client_id" id="project_client_id" class="form-control mb-2" onchange="clientsFunction(this)">
                                    <option value="">Default (none)</option>
                                    @foreach ($clients as $client)
                                       <option value="{{ $client->client_id }}">{{ $client->client_name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="project_client_name" id="project_client_name">
                                <div id="clientNotes" style="display:none;">
                                    <p class="mb-2"><b>Client Attach Notes:</b></p>
                                    <textarea name="project_client_notes"
                                              id="project_client_notes">
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="mb-2"><b>Project Template:</b></p>
                                <input type="text" 
                                       class="form-control" 
                                       placeholder="Enter project template in number." 
                                       name="project_template">
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="mb-2"><b>Project Link:</b></p>
                                <input type="url" 
                                       class="form-control" 
                                       placeholder="Enter Project Url eg. http://127.0.0.1:8000/admin/project/create" 
                                       name="project_onside_link">
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><b>Select User:</b></p>
                                <select class="form-control show-tick ms select2" multiple data-placeholder="Notify Users." id="selectUser" name="selected_users[]">
                                    
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"> {{ $user->full_name }} </option>
                                    @endforeach

                                </select>
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
                                <div class="border p-2">
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
                            </div>

                            <div class="col-12">
                                <input type="submit" value="Add Project" class="btn btn-sm btn-dark">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer m-0 pt-0 pb-0 pr-0" style="background: #11A7BB;">
            <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal"><small><b>Close</b></small></button>
            </div>
        </div>
    </div>
</div>
<!-- Add Projectt Modal End -->

<!-- View Project Modal Start -->
<div class="modal fade" id="ViewProjectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" id="ViewProjectModalWidth">
        <div class="modal-content"></div>
    </div>
</div>
<!-- View Project Modal End -->

<!-- UserReport Modal Start -->
<div class="modal fade" id="report" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <ul class="list-unstyled team-info">
                <li>
                    <img src="" alt="" id="user_task_image" style="width: 70px;">
                    <span id="userName"></span>
                </li>
            </ul>
            <div class="ml-2 mr-2 mt-2" id="user_task_report">
            </div>
            <div class="modal-header">
            </div>
            <div class="modal-body" id="modal_body">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal"><small><b>Close</b></small></button>
            </div>
        </div>
    </div>
</div>
<!-- UserReport Modal End -->

<!-- Checkbox Modal Start -->
<div class="modal fade" id="status_action" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" id="StatusProjectModalWidth">
        <form action="" method="post" id="status_action_form">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row" style="width: 100%;">
                        <div class="col-8">Change The Project Status.</div>
                        <div class="col-4">
                            <small>Notify Users( if need ).</small>
                            <select class="form-control show-tick ms select2" multiple data-placeholder="Notify Users." id="selectUserStatus" name="selected_users[]">
                                    
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"> {{ $user->full_name }} </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="checkbox_wrapper">
                    <div class="fancy-checkbox">
                        <label>
                            <input type="checkbox" name="step[]" value="pending">
                            <span>Pending</span>
                        </label>
                    </div>
                    <div class="fancy-checkbox">
                        <label>
                            <input type="checkbox" name="step[]" value="Takeoff On Progress">
                            <span>Takeoff on progress</span>
                        </label>
                    </div>
                    <div class="fancy-checkbox">
                        <label>
                            <input type="checkbox" name="step[]" value="Pricing On Progress">
                            <span>Pricing On Progress</span>
                        </label>
                    </div>
                    <div class="fancy-checkbox">
                        <label>
                            <input type="checkbox" name="step[]" value="revision">
                            <span>Revision</span>
                        </label>
                    </div>
                    <div class="fancy-checkbox">
                        <label>
                            <input type="checkbox" name="step[]" value="hold">
                            <span>Hold</span>
                        </label>
                    </div>
                    <div class="fancy-checkbox">
                        <label>
                            <input type="checkbox" name="step[]" value="completed">
                            <span>Completed</span>
                        </label>
                    </div>
                    <div class="fancy-checkbox">
                        <label>
                            <input type="checkbox" name="step[]" value="deliver">
                            <span>Deliver</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-warning"><small><b>UpdateStatus</b></small></button>
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal"><small><b>Close</b></small></button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Checkbox Modal End -->