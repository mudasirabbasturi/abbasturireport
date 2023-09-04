<!-- Action Save Modal Start -->
<div class="modal fade" id="goIn" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <form action="{{ route('action.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-12">
                            <p class="mb-4"><b>Choose Task:</b></p>
                            <div class="fancy-checkbox">
                                <label>
                                    <input type="checkbox" name="step[]" value="Marking">
                                    <span>Marking</span>
                                </label>
                            </div>
                            <div class="fancy-checkbox">
                                <label>
                                    <input type="checkbox" name="step[]" value="Excel_Sheet">
                                    <span>Excel sheet</span>
                                </label>
                            </div>
                            <div class="fancy-checkbox">
                                <label>
                                    <input type="checkbox" name="step[]" value="Pricing">
                                    <span>Pricing</span>
                                </label>
                            </div>
                            <div class="fancy-checkbox">
                                <label>
                                    <input type="checkbox" name="step[]" value="Quality_Assurance">
                                    <span>Quality Assurance</span>
                                </label>
                            </div>
                        </div>
                        <input type="hidden" name="project_id" value="" id="project_id">
                        <input type="hidden" name="user_id" value="" id="user_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-sm btn-warning" value="Join">
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Action Save Modal End -->
<div class="modal fade" id="addMoreAction" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <form action="" method="POST" id="actionUpdateForm">
                @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-12">
                            <p class="mb-4"><b>Choose More Task:</b></p>
                            <div id="updateChceckboxes"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-sm btn-warning" value="Update.">
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Percent Modal Start -->
<div class="modal fade" id="percent" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="ml-2 mr-2 mt-2" id="per_header_container">
            </div>
            <div class="modal-header">
                
            </div>
            <form action="" method="POST" id="percent-form">
                @csrf
                @method('PUT')
                <div class="modal-body" id="per_container">
                </div>
                <div class="modal-footer">
                    <button type="submit" id="percentSubmit" class="btn btn-dark btn-sm"><small>Submit Percent.</small></button>
                    <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal"><small>Close</small></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Percent Modal End -->

<!-- projSuccessMdl Modal Start -->
<div class="modal fade" id="projSuccessMdl" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="ml-2 mr-2 mt-2" id="per_header_container">
            </div>
            <div class="modal-header">
                <h6><small>Please Click Checkbox and submit.if the project is Takeoff on progress or Completed.</small></h6>
            </div>
            <form action="" method="POST" id="proCompletForm">
                @csrf
                <div class="modal-body">
                    <div class="fancy-checkbox">
                        <label>
                            <input type="checkbox" name="step[]" value="Pricing On Progress">
                            <span>Pricing on progress</span>
                        </label>
                    </div>
                    <div class="fancy-checkbox">
                        <label>
                            <input type="checkbox" name="step[]" value="completed">
                            <span>COMPLETED</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="percentSubmit" class="btn btn-sm btn-dark">Submit.</button>
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- projSuccessMdl Modal End -->

<!-- Request Employee To Join The Project -->

<div class="modal fade" id="requestEmployeeToJoin" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <form action="{{ route("employee.notify.store") }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-2">
                            <p class="mb-2"><b>Title:</b></p>
                            <input type="text" 
                                   class="form-control" 
                                   placeholder="Enter Notification Title"
                                   name="title">
                        </div>
                        <div class="col-12 mb-2">
                            <p class="mb-2"><b>Message:</b></p>
                            <textarea name="message" rows="5" class="form-control" placeholder="Enter Notification Message"></textarea>
                        </div>
                        <div class="col-12 mb-2">
                            <input type="hidden" name="notification_from" value="{{ Auth::user()->id }}">
                            <p class="mb-2"><b>Select Employee:</b></p>
                            <select class="custom-select" name="notification_to" required>
                                <option value="" selected>Select Employee:</option>
                                @foreach($AllUsers as $user)
                                   @if($user->id !== Auth::id() && $user->type !== 'admin')
                                     <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                     @endif
                                @endforeach
                            </select>
                            <input type="hidden" name="url" value="" id="proUrl">
                        </div>
                        <div class="col-md-6">
                            <input type="submit" value="Submit" class="btn btn-sm btn-dark">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<script>
    const proUrlELe = document.getElementById('proUrl')
    const btnGetUrlEle = document.getElementsByClassName('btnGetUrl')
          for(let i = 0; i < btnGetUrlEle.length; i++ ) {
            const btnClicked = btnGetUrlEle[i]
            btnClicked.addEventListener('click', function() {
                proUrlELe.value = this.dataset.url
            })
          }
</script>