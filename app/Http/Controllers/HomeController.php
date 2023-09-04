<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Admin\Project;
use App\Models\Event;
use App\Models\Employee\Action;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function employeeIndex() {
        return view('dashboard.employee.index');
    }
    
    public function adminIndex() {
        $projects = Project::with('actions.user')->get();
        $notificationCount = 10;
        return view('dashboard.admin.index', ['projects' => $projects, 'notificationCount'=>$notificationCount]);
    }

    public function chart() {

        $projects = DB::table('projects')
        ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
        ->groupBy('year', 'month')
        ->get();
        return view('dashboard.admin.chart', compact('projects'));

    }

    public function ClientIndex() {
        $clients = DB::table('clients')->get();
        return view('dashboard.admin.client.index',['clients' => $clients]);
    }
    public function ClientCreate() {
        return view('dashboard.admin.client.create');
    }

    public function ClientStore(Request $request) {

        // Validate the form data
        $validatedData = $request->validate([
            'client_name' => 'required',
            'client_notes' => 'nullable',
        ]);

        // Insert the data into the "clients" table
        DB::table('clients')->insert([
            'client_name' => $validatedData['client_name'],
            'client_notes' => $validatedData['client_notes'],
        ]);

        // Redirect or return a response
        return redirect()->route('admin.clients')->with('successMsg', 'Client added successfully.');

    }

    public function ClientEdit(Request $request, $edit) {
        $client = DB::table('clients')->where('client_id', $edit)->first();
        return view('dashboard.admin.client.update', ['client'=> $client]);
    }

    public function ClientUpdate(Request $request, $update) {
        // Validate the form data
        $validatedData = $request->validate([
            'client_name' => 'required',
            'client_notes' => 'nullable',
        ]);

        // Update the client in the "clients" table
        DB::table('clients')->where('client_id', $update)->update([
            'client_name' => $validatedData['client_name'],
            'client_notes' => $validatedData['client_notes'],
        ]);

        // Redirect or return a response
        return redirect()->route('admin.clients')->with('successMsg', 'Client updated successfully.');
    }

    public function ClientDestroy(Request $request, $destroy) {

        DB::table('clients')->where('client_id', $destroy)->delete();
        // Redirect or return a response
        return redirect()->route('admin.clients')->with('successMsg', 'Client deleted successfully.');
    }

}