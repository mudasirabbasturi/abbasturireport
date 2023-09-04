<tr>
    <td>
        <button  class="btn btn-sm pt-0 pb-0
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
            @endif">
    <small 
           style="text-transform: capitalize;" 
           class="status_actions">

            @if($project->project_status != 'Takeoff On Progress' && $project->project_status != 'Pricing On Progress')
                Project On {{ $project->project_status }}
            @else
            {{ $project->project_status }}
            @endif
    </small>
</button>
    </td>
    <td>
        <small>
            <b>
                <a href="{{ route('projectShow.show', $project->id) }}"
                    class="projectAddress"
                    data-toggle="popover" 
                    data-trigger="hover"
                    title="" 
                    data-content="{{ $project->project_address }}" 
                    data-original-title="Project Address"
                    style="display: inline-block;line-height: 14px;">
                    @if ($project->project_address)
                        {{ $project->project_address }}
                    @else 
                      Please Add Address if have.
                    @endif
                </a>
            </b>
        </small>
        @if ($project->actions->count() > 0)
            @foreach ($project->actions as $action)
            <p style="width: 0px;overflow: hidden;height:0px;padding: 0;margin: 0;">
                {{ $action->user->full_name }}
            </p>
            @endforeach
        @endif
    </td>
    <td>
        <small>
            <b>
                <a href="{{ route('projectShow.show', $project->id) }}"
                    data-toggle="popover" 
                    data-trigger="hover" title="" 
                    data-content="{{ $project->project_title }}" 
                    data-original-title="Project Title"
                    style="display: inline-block;line-height: 14px;">
                    {{ $project->project_title }}
                </a>
            </b>
        </small>
    </td>
    
    <td>
        <small>
            <b  style="display: inline-block;line-height: 14px;">
                {{ date('Y-m-d h:i:s A', strtotime($project->project_due_date)) }}
            </b>
        </small>
    </td>
    <td class="main_scope" style="line-height: 14px;">
        {!! $project->project_main_scope !!}</td>
    <td>
        <table class="time_indicator_table">
            <thead>
                <tr class="">
                    <th><small>DAYS</small></th>
                    <th><small>HRS</small></th>
                    <th><small>MIN</small></th>
                    <th><small>SEC</small></th>
                </tr>
            </thead>
            <tbody>
                <tr class="time_indicator" data-due-date="{{ $project->project_due_date }}">
                    <td class="days"></td>
                    <td class="hours"></td>
                    <td class="minutes"></td>
                    <td class="seconds"></td>
                </tr>
            </tbody>
        </table>
    </td>
    <td>
        <a 
            href="{{ route('projectShow.show', $project->id) }}" 
            class="btn btn-sm btn-outline-info sabtn"
            data-toggle="popover" 
            data-trigger="hover" title="" 
            data-content="Click The Edit Icon To Perform Action." 
            data-original-title="View | Edit Project.">
            <i class="fa fa-edit"></i>
        </a>
        <span data-toggle="modal"
              data-target="#requestEmployeeToJoin">
                <a href="javascript:void(0);" 
                    class="btn btn-sm btn-outline-info sabtn"
                    data-toggle="popover" 
                    data-trigger="hover" title="" 
                    data-content="Click The Icon To Request Any Employee To Join The Project." 
                    data-original-title="Request Employee.">
                    <i class="fa fa-code-fork" aria-hidden="true"></i>
                </a>
        </span>

        @if($project->actions->count() > 0)
            @foreach($project->actions as $action)
                @if($action->user->id == Auth::user()->id)

                <span class="percentAction" data-toggle="modal"
                      data-target="#percent"
                      data-aid="{{ $action->id }}"
                      data-pid="{{ $action->project_id }}"
                      data-uid="{{ $action->user_id }}">

                    <a href="javascript:void(0);" 
                       class="btn btn-sm btn-outline-info sabtn" 
                       title=""
                       data-toggle="popover" 
                       data-trigger="hover" title="" 
                       data-content="Click The Percent Icon And Add Your Progress Percentage." 
                       data-original-title="Work Progress percentage.">
                      <i class="fa fa-percent" aria-hidden="true"></i>
                    </a>
                      
                </span>
                <span class="completeAction" data-toggle="modal"
                      data-toggle="modal"
                      data-target="#projSuccessMdl" 
                      data-projectid="{{ $action->project_id }}">

                    <a href="javascript:void(0);" 
                       class="btn btn-sm btn-outline-info sabtn"
                       title=""
                       data-toggle="popover" 
                       data-trigger="hover" title="" 
                       data-content="Please Click Checkbox and submit.if the project is Takeoff On Progress Or Completed." 
                       data-original-title="Completed or Takeoff On Progress"
                       style="font-size: 18px">
                      <i class="fa fa-check-square-o" aria-hidden="true"></i>
                   </a>

                </span>

                    <a href="javascript:void(0);" 
                       data-toggle="popover" 
                       data-trigger="hover" title="" 
                       data-content="Please Click On Trash Icon, To Remove Yourself From Project." 
                       data-original-title="Remove Yourself"
                       class="btn btn-sm btn-outline-info sabtn"
                       onclick="confirmDelete({{ $action->id }})"
                       style="font-size: 18px">
                    <i class="icon-trash" aria-hidden="true"></i>
                    </a>

                    <form id="delete-form-{{ $action->id }}" 
                            action="{{ route('action.destroy', ['action' => $action->id]) }}" 
                            method="POST" 
                            style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <script>
                        function confirmDelete(id) {
                            if (confirm('Are You Sure, Do You Want To Remove Yourself From This Project?')) {
                                document.getElementById('delete-form-'+id).submit();
                            }
                        }
                    </script>
                @endif
            @endforeach
        @endif
        @if ($project->actions->where('user_id', Auth::user()->id)->isNotEmpty())

          <span class="btnGoUpd"
                data-toggle="modal"
                data-target="#addMoreAction"
                data-id="{{ $project->actions->where('user_id', Auth::user()->id)->first()->id }}">

            <a href="javascript:void(0);" 
                class="btn btn-sm btn-outline-info sabtn"
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
                  class="btn-goIn"
                  data-projectid="{{ $project->id }}"
                  data-userid="{{ Auth::user()->id }}"
                  style="cursor: pointer">

                <a href="javascript:void(0);" 
                   title=""
                   class="btn btn-sm btn-outline-info sabtn"
                   data-toggle="popover" 
                   data-trigger="hover" title="" 
                   data-content="Click The Lock Icon And Get Involved In Project." 
                   data-original-title="Get Involved.">
                   <i class="fa fa-lock">
                      <sup style="font-size: 11px;"><i class="fa fa-key" aria-hidden="true"></i></sup>
                   </i>           
                </a>

            </span>
        @endif
    </td>
</tr>