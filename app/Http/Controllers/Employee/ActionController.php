<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee\Action;
use App\Models\Admin\Project;
use Illuminate\Http\Request;

// use Twilio\Rest\Client;
// use Twilio\Exceptions\RestException;

use App\Models\User;
use App\Models\NotificationLog;
use App\Models\UserNotification;
use Auth;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //dd($request);
        $validatedData = $request->validate([
            'step' => 'required|array|min:1',
            'project_id' => 'required',
            'user_id' => 'required',
        ]);
    
        // Create a new Action instance
        $action = new Action();
    
        // Set the project, user IDs and status
        $action->project_id = $request->project_id;
        $action->user_id = $request->user_id;
    
        // Check which checkboxes are checked and set the corresponding fields in the Action instance
        if (in_array('Marking', $validatedData['step'])) {
            $action->project_marking = 'Marking';
        }

        if (in_array('Excel_Sheet', $validatedData['step'])) {
            $action->project_excel = 'Excel Sheet';
        }

        if (in_array('Pricing', $validatedData['step'])) {
            $action->project_pricing = 'Pricing';
        }

        if (in_array('Quality_Assurance', $validatedData['step'])) {
            $action->project_quality_assurance = 'Quality Assurance';
        }
        
        // Save the Action instance
        $saveData = $action->save();

        // Check if the project status is "pending"
        $project = Project::find($request->project_id);

        if ($project->project_status === 'pending') {
            // Update project status
            Project::where('id', $request->project_id)
                ->update(['project_status' => 'Takeoff On Progress']);
        }

        if($saveData) {
            // Redirect the user to a success page or perform some other action

            return redirect()->back()->with('successMsg', 'Get Envolved In A Project Successfully');
        }
        else {
            return redirect()->back()->with('errorMsg', 'Some thing gone Wrong Please Try Again..');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Action $action)
    {
        $id = $action->id;
        $action = Action::find($id);
        $data = [];
        $completedFields = 0;
        if ($action) {
            if ($action->project_marking === null) {
                $data['project_marking'] = 'Marking';
            } else {
                $completedFields++;
            }
            if ($action->project_excel === null) {
                $data['project_excel'] = "Excel Sheet";
            } else {
                $completedFields++;
            }
            if ($action->project_pricing === null) {
                $data['project_pricing'] = "Pricing";
            } else {
                $completedFields++;
            }
            if ($action->project_quality_assurance === null) {
                $data['project_quality_assurance'] = "Quality Assurance";
            } else {
                $completedFields++;
            }
        }
        if ($completedFields == 4) {
            $data['message'] = "You have selected all the task.";
        }
        return response()->json($data);
    }

    public function showUpdate(Request $request, $id) {
        $action = Action::find($id);
        $updateRecord = $action->update($request->all());
        if($updateRecord) {
            return redirect()->back();
        }
    }


    public function percent($id) {
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

    public function actionCompleted(Request $request, $id) {
        $validatedData = $request->validate([
            'step' => 'required|array|min:1',
        ]);

        $data = Project::find($id);

        // Get the previous project status
        $previousStatus = $data->project_status;

        if (in_array('completed', $validatedData['step'])) {
            $data->project_status = 'completed';
        }

        if (in_array('Pricing On Progress', $validatedData['step'])) {
            $data->project_status = 'Pricing On Progress';
            $data->save();
            $message = ' Status changed successfully from "' . $previousStatus . '" to "' . $data->project_status . '".';
            return redirect()->route('pricingOnprogress')->with('successMsg', $message);
        }

        $data->save();

        $message = ' Status changed successfully from "' . $previousStatus . '" to "' . $data->project_status . '".';
        return redirect()->back()->with('successMsg', $message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Action $action)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * Percent save 
     */
 

    public function update(Request $request, Action $action) {
        $action = Action::find($action->id);
        $markingPercent = $request->input('Marking');
        $excelPercent = $request->input('Excel_Sheet');
        $pricingPercent = $request->input('Pricing');
        $qualityAssurancePercent = $request->input('Quality_Assurance');
        
        if ($markingPercent) {
            $action->marking_percent = $markingPercent;
            $actionName = 'Marking';
            $percentValue = $markingPercent;
        }
        if ($excelPercent) {
            $action->excel_percent = $excelPercent;
            $actionName = 'Excel Sheet';
            $percentValue = $excelPercent;
        }
        if ($pricingPercent) {
            $action->pricing_percent = $pricingPercent;
            $actionName = 'pricing';
            $percentValue = $pricingPercent;
        }
        if ($qualityAssurancePercent) {
            $action->assurance_percent = $qualityAssurancePercent;
            $actionName = 'quality assurance';
            $percentValue = $qualityAssurancePercent;
        }
        
        $action->save();
        
        // Redirect to the appropriate page
        return redirect()->back()->with('successMsg', $percentValue . '% ' . $actionName . ' has been added successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Action $action)
    {
        $action->delete();
        return redirect()->back()->with('successMsg', 'You have exclude yourself from project successfully');
    }
}

