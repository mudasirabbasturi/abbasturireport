<tr>
    <td>
        <a href="{{ route('project.show', $project->id) }}" class="projectAddress"
            title="{{$project->project_address}}">
            @if ($project->project_address)
            {{ $project->project_address }}
            @else
            Address of project none.
            @endif
        </a>
        @if ($project->actions->count() > 0)
        @foreach ($project->actions as $action)
        <p style="width: 0px;overflow: hidden;height:0px;padding: 0;margin: 0;">
            {{ $action->user->full_name }}
        </p>
        @endforeach
        @endif

    </td>

    <td>
        <a href="{{ route('project.show', $project->id) }}" class="project_title" title="{{ $project->project_title }}">
            {{ $project->project_title }}
        </a>
    </td>
    <td class="main_scope">
        @if ($project->project_address)
        {!! $project->project_main_scope !!}
        @else
        MainScope of project none.
        @endif

    </td>
    {{-- <td>
        <small>
            {{ \Carbon\Carbon::parse($project->project_due_date)->format('jS F Y') }}
        </small>
    </td> --}}
    <td style="min-width: 120px;max-width: 120px;">
        <small style="border-bottom: 1px solid #e68200;border-top: 1px solid #e68200;display: inline-block;width: 100%;">
            {{ \Carbon\Carbon::parse($project->project_due_date)->format('jS F Y') }}
        </small>
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
        <a href="{{ route('project.show', $project->id) }}" class="btn btn-sm btn-outline-info m-1"
            title="View | Update | Download.">
            <i class="fa fa-edit"></i> View/Update
        </a>
        {{-- <a href="{{ route('project.copy', $project->id) }}" class="btn btn-sm btn-outline-info text-warning"
            title="Copy Project.">
            <i class="fa fa-copy"></i>
        </a> --}}
        <a href="#" class="btn btn-sm btn-outline-info text-danger m-1" 
                    onclick="confirmDelete({{ $project->id }})"
            title="Delet The Project.">
            <i class="icon-trash"></i> Delete
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
        <button data-toggle="modal" 
                data-target="#status_action" 
                data-id="{{ $project->id }}" 
                title="" 
                class="btn btn-sm pt-0 pb-0 m-1 status_actions
            
                @if($project->project_status == 'pending') btn-outline-warning
                @elseif ($project->project_status == 'Takeoff On Progress') btn-outline-primary
                @elseif ($project->project_status == 'Pricing On Progress') btn-outline-info
                @elseif ($project->project_status == 'completed') btn-outline-info
                @elseif ($project->project_status == 'deliver') btn-outline-success
                @elseif ($project->project_status == 'hold') btn-outline-danger
                @elseif ($project->project_status == 'revision') btn-outline-danger
                @endif">
            <small style="text-transform: capitalize;" class="status_actions">
                <i class="fa fa-spinner" aria-hidden="true"></i>
                @if($project->project_status != 'Takeoff On Progress' && $project->project_status != 'Pricing On
                Progress')
                Project On {{ $project->project_status }}
                @else {{ $project->project_status }}
                @endif
            </small>
        </button>
    </td>
</tr>