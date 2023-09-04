<tr>
    <td>
        <span data-toggle="popover" 
              data-trigger="hover" title="" 
              data-content="Click The Status Button To Change The Project Status." 
              data-original-title="Project Status.">
                <button data-toggle="modal" data-target="#status_action" data-id="{{ $project->id }}"
                    title=""
                    class="btn btn-sm pt-0 pb-0 status_actions
                    
                        @if($project->project_status == 'pending') btn-outline-warning
                        @elseif ($project->project_status == 'Takeoff On Progress') btn-outline-primary
                        @elseif ($project->project_status == 'Pricing On Progress') btn-outline-info
                        @elseif ($project->project_status == 'completed') btn-outline-info
                        @elseif ($project->project_status == 'deliver') btn-outline-success
                        @elseif ($project->project_status == 'hold') btn-outline-danger
                        @elseif ($project->project_status == 'revision') btn-outline-danger
                        @endif">
                <small style="text-transform: capitalize;" class="status_actions">

                        @if($project->project_status != 'Takeoff On Progress' && $project->project_status != 'Pricing On Progress')
                            Project On {{ $project->project_status }}
                        @else {{ $project->project_status }}
                        @endif
                </small>
            </button>
        </span>
    </td>
    <td>
        <small>
            <b>
                <a href="{{ route('project.show', $project->id) }}" 
                   title=""
                   title=""
                   data-toggle="popover" 
                   data-trigger="hover" title="" 
                   data-content="{{ $project->project_address }}" 
                   data-original-title="Project Address."
                   class="projectAddress">
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
        <a href="{{ route('project.show', $project->id) }}" 
            title=""
            data-toggle="popover" 
            data-trigger="hover" title="" 
            data-content="{{ $project->project_title }}" 
            data-original-title="Project Title."
            class="project_title"
            style="font-size: 12px">
            {{ $project->project_title }}
        </a>
    </td>
    <td>
        <small>
                {{ date('Y-m-d h:i:s A', strtotime($project->project_due_date)) }}
        </small>
    </td>
    <td class="main_scope">{!! $project->project_main_scope !!}</td>
    <td>
        <table class="indicator">
            <thead>
                <tr>
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
    </td>
    <td>
        <a href="{{ route('project.show', $project->id) }}" 
            class="btn btn-sm btn-outline-info"
            data-toggle="popover" 
            data-trigger="hover" title="" 
            data-content="Click The Edit Icon And Update, Download Or View The Project." 
            data-original-title="View | Update | Download.">
            <i class="fa fa-edit"></i>
        </a>
        {{-- <a href="javascript:void(0);" class="btn btn-outline-info btn-sm status_actions" data-toggle="modal"
            data-target="#status_action" data-id="{{ $project->id }}">
            <i class="icon-check"></i>
        </a> --}}
        <a href="{{ route('project.copy', $project->id) }}" 
           class="btn btn-sm btn-outline-info text-warning"
           title="Copy Project."
           data-toggle="popover" 
           data-trigger="hover" title="" 
           data-content="Click The Copy Icon And Create A New Record From An Existing Data." 
           data-original-title="Copy Project."
           data-url="">
           <i class="fa fa-copy"></i>
        </a>
        <a href="#" 
           class="btn btn-sm btn-outline-info text-danger"
           onclick="confirmDelete({{ $project->id }})"
           title=""
           data-toggle="popover" 
           data-trigger="hover" title="" 
           data-content="Click The Trash Icon To Delete The Project." 
           data-original-title="Delet Project.">
            <i class="icon-trash"></i>
        </a>
        <form id="delete-form-{{ $project->id }}" action="{{ route('project.destroy', ['project' => $project->id]) }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        <script>
            function confirmDelete(id) {
                if (confirm('Are you sure you want to delete this project?')) {
                    document.getElementById('delete-form-' + id).submit();
                }
            }
        </script>
    </td>
</tr>