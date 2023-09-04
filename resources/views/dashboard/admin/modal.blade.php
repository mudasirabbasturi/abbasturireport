
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
    <div class="modal-dialog" role="document">
        <form action="" method="post" id="status_action_form">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Change The Project Status.</h6>
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