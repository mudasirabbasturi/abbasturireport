<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Project;
use App\Models\Employee\Action;
use App\Models\User;
use App\Models\NotificationLog;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;


// use Vonage\Client\Credentials\Basic;
// use Vonage\Client;
// use Vonage\SMS\Message\SMS;

use Illuminate\Support\Facades\Queue;
use App\Jobs\SendProjectNotifications;


class ProjectController extends Controller {
    /**
     * Display a listing of the resource.
    */
    public function index() {
        $projects = Project::with('actions.user')->latest('created_at')->get();
        return view('dashboard.admin.project.index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $clients = DB::table('clients')->get();
        return view('dashboard.admin.project.create', ['clients' => $clients]);
    }

    public function clients(Request $request, $id) {
        if ($request->ajax()) {
            $data = DB::table('clients')->where('client_id', $id)->first();
            return response()->json($data);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $date = $request->input('project_due_date');
        $data = $request->all();
        $data = Project::create($data);
        if ($data) {
            $subject = 'New Project Created';
            $message = 'A new project has been created.';
            $title = $data->project_title;
            $address = $data->project_address;
            $url = '';
            $url = '/type/project/' . $data->id;
            // SendProjectNotificationsJob::dispatch($subject, $message, $title, $address, $url)
            // ->onQueue('notifications');
            
            // $notitle = $data->project_title;
            // $userId = Auth::user()->id;

            $notification = new NotificationLog();
            $notification->notification_from = Auth::user()->id;
            $notification->title = $title;
            $notification->message = $message;
            $notification->url = $url;
            $notification->save();
    
            // Retrieve the ID of the newly created notification
            $notificationId = $notification->id;
    
            // Get the list of users who should receive the notification
            $users = User::all();
    
            // Create user notifications for each user
            foreach ($users as $user) {
                $userNotification = new UserNotification();
                $userNotification->user_id = $user->id;
                $userNotification->notification_id = $notificationId;
                $userNotification->status = 0; // Set the status as unread
                $userNotification->save();
            }

            return redirect()->route('admin.index')->with('successMsg', 'Project Created Successfully');
        } 

        else {
            return redirect()->back()->with('errorMsg', 'Something went wrong.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        $project = Project::findOrFail($id);
        $clients = DB::table('clients')->get();
        return view('dashboard.admin.project.view', ['project'=> $project, 'clients' => $clients]);
    }

    public function report($id) {
        $action = Action::find($id);
        $data = [];
        $percent = [];
        if ($action) {
            if ($action->project_marking !== null) {
                $percent['Marking'] = $action->marking_percent;
                if($action->marking_percent !== 100) {
                    $data['marking'] = $action->project_marking;
                }
            }
            if ($action->project_excel !== null) {
                $percent['Excel'] = $action->excel_percent;
                if($action->excel_percent !== 100) {
                    $data['excel'] = $action->project_excel;
                }
            }
            if ($action->project_pricing !== null) {
                $percent['Pricing'] = $action->pricing_percent;
                if($action->pricing_percent !== 100) {
                    $data['pricing'] = $action->project_pricing;
                }
            }
            if ($action->project_quality_assurance !== null) {
                $percent['Quality Assurance'] = $action->assurance_percent;
                if($action->assurance_percent !== 100) {
                    $data['assurance'] = $action->project_quality_assurance;
                }
            }
        }
        return response()->json(['data' =>$data, 'percent' => $percent]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project){
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Project $project) {
        $upateRecord = $project->update($request->all());
        if($upateRecord) {
            return redirect()->route('admin.index')->with('successMsg', 'Project updated successfully');
        }
        else {
            return redirect()->back()->with('errorMsg', 'Something gone wrong please try again.');
        }
    }

    public function UpdateProjectStatus(Request $request, $id) {

        $validatedData = $request->validate([
            'step' => 'required|array|min:1',
        ]);

        $data = Project::find($id);
        
        // Get the previous project status
        $previousStatus = $data->project_status;

        // Map project status values to routes
        $statusRoutes = [
            'pending' => 'project.pending',
            'Takeoff On Progress' => 'project.progress',
            'revision' => 'project.revision',
            'hold' => 'project.hold',
            'completed' => 'project.completed',
            // 'deliver' => 'project.deliver',
            'deliver' => 'project.completed',
            'Pricing On Progress' => 'project.pricingProgress',
        ];

        if (in_array('pending', $validatedData['step'])) {
            $data->project_status = 'pending';
        }
        if (in_array('Takeoff On Progress', $validatedData['step'])) {
            $data->project_status = 'Takeoff On Progress';
        }
        if (in_array('revision', $validatedData['step'])) {
            $data->project_status = 'revision';
        }
        if (in_array('hold', $validatedData['step'])) {
            $data->project_status = 'hold';
        }
        if (in_array('completed', $validatedData['step'])) {
            $data->project_status = 'completed';
        }
        if (in_array('deliver', $validatedData['step'])) {
            $data->project_status = 'deliver';
        }
        if (in_array('Pricing On Progress', $validatedData['step'])) {
            $data->project_status = 'Pricing On Progress';
        }
        $data->save();
       
        $notificationEmail = 'mudasirabbas578@gmail.com';
        $subject = 'Project Status Updated';
        //$bodytext = 'The project status has been updated.';
        $title = $data->project_title;
        $address = $data->project_address;
        $url = '';
        $url = url('/type/project/' . $data->id);
        $bodytext = 'Project Status changed from "' . $previousStatus . '" to "' . $data->project_status . '".';

        // $job = (new \App\Jobs\SendQueueEmail(
        //                                       $notificationEmail,
        //                                       $subject,
        //                                       $title,
        //                                       $address,
        //                                       $bodytext,
        //                                       $url,
        //                                     ))
        //                             ->delay(now()->addSeconds(2)); 
        
        // dispatch($job);

        $notification = new NotificationLog();
        $notification->notification_from = Auth::user()->id;
        $notification->title = "The project status has been updated";
        $notification->message = $bodytext;
        $notification->url = $url;
        $notification->save();

        // Retrieve the ID of the newly created notification
        $notificationId = $notification->id;

        // Get the list of users who should receive the notification
        $users = User::all();

        // Create user notifications for each user
        foreach ($users as $user) {
            $userNotification = new UserNotification();
            $userNotification->user_id = $user->id;
            $userNotification->notification_id = $notificationId;
            $userNotification->status = 0; // Set the status as unread
            $userNotification->save();
        }

        // Redirect based on the updated project status
        if (isset($statusRoutes[$data->project_status])) {
            $route = $statusRoutes[$data->project_status];
            return redirect()->route($route)->with('successMsg', $bodytext);
        } else {
            return redirect()->back()->with('errorMsg', 'Somethings gone wrong please try again or contact with developer.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project) {
        $project->delete();
        return redirect()->route('admin.index')->with('successMsg', 'Project Deleted Successfully');
    }


    public function projectPending() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.admin.project.pending', ['projects' => $projects]);
    }

    public function adminCurrentProgress() {
        $projects = Project::with('actions.user')
        ->whereNotIn('project_status', ['deliver', 'completed', 'pending'])
        ->get();
        return view('dashboard.admin.project.current', ['projects' => $projects]);
    }
    
    public function projectProgress() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.admin.project.progress', ['projects' => $projects]);
    }
    public function pricingProgress() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.admin.project.pricingonprogress', ['projects' => $projects]);
    }

    public function projectCompleted() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.admin.project.completed', ['projects' => $projects]);
    }

    public function projectDeliver() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.admin.project.deliver', ['projects' => $projects]);
    }

    public function projectHold() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.admin.project.hold', ['projects' => $projects]);
    }

    public function projectRevision() {
        $projects = Project::with('actions.user')->get();
        return view('dashboard.admin.project.revision', ['projects' => $projects]);
    }

    public function adminProjectFilter(Request $request) {
        $users = User::where('type', '!=', 1)->get();
        return view('dashboard.admin.project.filter', ['users' => $users ]);
    }

    public function ProjectFilterData(Request $request){
        // Retrieve form data
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $status = $request->input('status');
        $userId = $request->input('userid');

        // Filter projects based on the provided data
        $query = Project::query();

        if ($startDate) {
            $query->where('project_due_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('project_due_date', '<=', $endDate);
        }

        if ($status && $status !== 'Default All.') {
            $query->where('project_status', $status);
        }

        // Retrieve the filtered projects
        $filteredProjects = $query->get();

        // Filter projects based on the selected user
        if ($userId && $userId !== 'Default None.') {
            $filteredProjects = $filteredProjects->filter(function ($project) use ($userId) {
                return $project->actions->contains('user_id', $userId);
            });
        }

        // Retrieve the users for the dropdown
        $users = User::where('type', '!=', 1)->get();

        // Pass form data, filtered projects, and users to the view
        return view('dashboard.admin.project.filter', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status' => $status,
            'filteredProjects' => $filteredProjects,
            'users' => $users,
            'userId' => $userId,
        ]);
    }

    // public function adminProjectFilterUser($id) {
    //     $user = User::findOrFail($id);
    //     $projects = Project::whereHas('actions', function ($query) use ($user) {
    //         $query->where('user_id', $user->id);
    //     })->with('actions.user')->latest('created_at')->get();
    //     return view('dashboard.admin.project.userfilter', ['projects' => $projects, 'user' => $user]);
    // }

    public function adminProjectFilterUser($id)
    {
        $user = User::findOrFail($id);

        $projects = Project::join('actions', 'projects.id', '=', 'actions.project_id')
            ->where('actions.user_id', $user->id)
            ->with('actions.user')
            ->latest('projects.created_at')
            ->get();

        return view('dashboard.admin.project.userfilter', ['projects' => $projects, 'user' => $user]);
    }

    public function copyProject($id) {
        $projects = Project::where('id', $id)->get();
        return view('dashboard.admin.project.copy', ['projects'=> $projects]);
    }
}