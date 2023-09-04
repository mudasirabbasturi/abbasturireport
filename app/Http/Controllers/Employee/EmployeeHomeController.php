<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Admin\Project;
use App\Models\Employee\Action;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Auth;

class EmployeeHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.employee.index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.employee.check');
    }

    public function employeeProjectIndex()
    {
        // $projectsData = [];

        // DB::table('projects')
        //     ->select(
        //         'projects.id',
        //         'projects.project_title',
        //         'projects.project_address',
        //         'projects.project_main_scope',
        //         'projects.project_due_date',
        //         'projects.project_status',
        //         'actions.project_marking',
        //         'users.full_name',
        //         'users.profile_picture',
        //     )
        //     ->leftJoin('actions', 'projects.id', '=', 'actions.project_id')
        //     ->leftJoin('users', 'actions.user_id', '=', 'users.id')
        //     ->orderBy('projects.id')
        //     ->chunk(20, function ($query) use (&$projectsData) {
        //         $currentProjectID = null;
        //         $usernames = [];
                
        //         foreach ($query as $value) {
        //             if ($currentProjectID !== $value->id) {
        //                 if ($currentProjectID !== null) {
        //                     $projectsData[] = [
        //                         'id' => $currentProjectID,
        //                         'status' => $currentProjectStatus,
        //                         'address' => $currentProjectAddress,
        //                         'title' => $currentProjectTitle,
        //                         'due_date' => $currentProjectDueDate,
        //                         'main_scope' => $currentProjectMainScope,
        //                         'usernames' => implode(', ', $usernames),
        //                         'pic' => $currentProjectPicture,
        //                     ];
        //                 }
        //                 $currentProjectID = $value->id;
        //                 $currentProjectStatus = $value->project_status;
        //                 $currentProjectAddress = $value->project_address;
        //                 $currentProjectTitle = $value->project_title;
        //                 $currentProjectDueDate = $value->project_due_date;
        //                 $currentProjectMainScope = $value->project_main_scope;
        //                 $usernames = [];
        //                 $currentProjectPicture = $value->profile_picture;
        //             }
        //             if (!in_array($value->full_name, $usernames)) {
        //                 $usernames[] = $value->full_name;
        //             }
        //         }
        //         if ($currentProjectID !== null) {
        //             $projectsData[] = [
        //                 'id' => $currentProjectID,
        //                 'status' => $currentProjectStatus,
        //                 'address' => $currentProjectAddress,
        //                 'title' => $currentProjectTitle,
        //                 'due_date' => $currentProjectDueDate,
        //                 'main_scope' => $currentProjectMainScope,
        //                 'usernames' => implode(', ', $usernames),
        //                 'pic' => $currentProjectPicture,
        //             ];
        //         }
        //     });

      // return view('dashboard.employee.project.index', ['projectsData' => $projectsData]);
        $projects = Project::with('actions.user')->get();
        return view('dashboard.employee.project.index', ['projects' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    public function projectShow($project) {
        // $projects = Project::where('id', $project)->get();
        $projects = Project::with('actions.user')
                    ->where('id', $project)
                    ->get();
        return view('dashboard.employee.project.project_show', ['projects'=> $projects]);
    }

    public function projectUpdate(Request $request, $id) {
        $data = Project::find($id);
        $upateRecord = $data->update($request->all());
        if($upateRecord) {
            return redirect()->back()->with('successMsg', 'Project updated successfully');
        }
        else {
            return redirect()->back()->with('errorMsg', 'Something gone wrong please try again.');
        }
    }

    public function Pending() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.employee.project.pending', ['projects' => $projects]);
    }

    public function CurrentProgress() {
        $projects = Project::with('actions.user')
        ->whereNotIn('project_status', ['deliver', 'completed', 'pending'])
        ->get();
        return view('dashboard.employee.project.current', ['projects' => $projects]);
    }

    public function takeOfOnprogress() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.employee.project.progress', ['projects' => $projects]);
    }

    public function pricingOnprogress() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.employee.project.pricingprogress', ['projects' => $projects]);
    }

    public function Completed() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.employee.project.completed', ['projects' => $projects]);
    }

    public function Deliver() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.employee.project.deliver', ['projects' => $projects]);
    }

    public function Hold() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.employee.project.hold', ['projects' => $projects]);
    }

    public function Revision() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.employee.project.revision', ['projects' => $projects]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //   curl -i -X POST `
        //   https://graph.facebook.com/v16.0/101137042983460/messages `
        //   -H 'Authorization: Bearer EAADn6uctuq8BAK7ZCqEHhZB6jrosJigNVdeyTmUEZBGxZA8ip0AIrZAm6d95eO9USki087svFdPkDJaJ1bE0Y46UZCOo1RlTZADzxzqCfQW6rD2ayUZBqfnH2vFvAurA2TWAKaLu79lfpeaJn1P6TH4DxLO3hSZCWgpBisTWJL76rvrgbtcqAWL03vvcQIyLpfboPuvqAyRXbFAZDZD' `
        //   -H 'Content-Type: application/json' `
        //   -d '{ \"messaging_product\": \"whatsapp\", \"to\": \"923055798010\", \"type\": \"template\", \"template\": { \"name\": \"hello_world\", \"language\": { \"code\": \"en_US\" } } }'
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }

    // User Self Activity All Controller 

    public function selfProjectIndex() {

        $userId = Auth::user()->id;
        $query = Project::query();
        $projects = $query->get();
        $projects = $projects->filter(function ($project) use ($userId) {
                return $project->actions->contains('user_id', $userId);
            });

        return view("dashboard.employee.selfproject.index", ['projects' => $projects,]);

    }

    public function selfProjectPending() {
        $userId = Auth::user()->id;
        $query = Project::query();
        $projects = $query->get();
        $projects = $projects->filter(function ($project) use ($userId) {
                return $project->actions->contains('user_id', $userId);
            });

        return view("dashboard.employee.selfproject.selfpending", ['projects' => $projects,]);
    }

    public function selfProjectTakeOfOnProgress() {
        $userId = Auth::user()->id;
        $query = Project::query();
        $projects = $query->get();
        $projects = $projects->filter(function ($project) use ($userId) {
                return $project->actions->contains('user_id', $userId);
            });
        return view("dashboard.employee.selfproject.selftakeofonprogress", ['projects' => $projects,]);
    }

    public function selfProjectPricingOnProgress() {
        $userId = Auth::user()->id;
        $query = Project::query();
        $projects = $query->get();
        $projects = $projects->filter(function ($project) use ($userId) {
                return $project->actions->contains('user_id', $userId);
            });
        return view("dashboard.employee.selfproject.selfpricingonprogress", ['projects' => $projects,]);
    }


    public function selfProjectHold() {
        $userId = Auth::user()->id;
        $query = Project::query();
        $projects = $query->get();
        $projects = $projects->filter(function ($project) use ($userId) {
                return $project->actions->contains('user_id', $userId);
            });
        return view("dashboard.employee.selfproject.selfhold", ['projects' => $projects,]);
    }

    public function selfProjectRevision() {
        $userId = Auth::user()->id;
        $query = Project::query();
        $projects = $query->get();
        $projects = $projects->filter(function ($project) use ($userId) {
                return $project->actions->contains('user_id', $userId);
            });
        return view("dashboard.employee.selfproject.selfrevision", ['projects' => $projects,]);
    }

    public function selfProjectCompleted() {
        $userId = Auth::user()->id;
        $query = Project::query();
        $projects = $query->get();
        $projects = $projects->filter(function ($project) use ($userId) {
                return $project->actions->contains('user_id', $userId);
            });
        return view("dashboard.employee.selfproject.selfcompleted", ['projects' => $projects,]);
    }

    public function selfProjectDeliver() {
        $userId = Auth::user()->id;
        $query = Project::query();
        $projects = $query->get();
        $projects = $projects->filter(function ($project) use ($userId) {
                return $project->actions->contains('user_id', $userId);
            });
        return view("dashboard.employee.selfproject.selfdeliver", ['projects' => $projects,]);
    }

}