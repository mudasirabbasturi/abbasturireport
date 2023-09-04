<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('type', '!=', 1)->get();
        return view('dashboard.admin.employee.index', ['users' => $users]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.employee.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userData = $request->all();
        if ($request->hasFile('id_card')) {
            $idCard = $request->file('id_card');
            $idCardName = time() . '_' . $idCard->getClientOriginalName();
            $idCard->move(public_path('/images/users'), $idCardName);
            $userData['id_card'] = $idCardName;
        }
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentName = time() . '_' . $document->getClientOriginalName();
            $document->move(public_path('/images/users'), $documentName);
            $userData['document'] = $documentName;
        }
        if ($request->hasFile('profile_picture')) {
            $picture = $request->file('profile_picture');
            $pictureName = time() . '_' . $picture->getClientOriginalName();
            $picture->move(public_path('/images/users'), $pictureName);
            $userData['profile_picture'] = $pictureName;
        }
        $userData['password'] = bcrypt($request->input('password'));
        $submit = User::Create($userData);
        if($submit) {
            $successMsg = 'Employee created successfully.';
            return redirect()->back()->with('successMsg', $successMsg);
        }
        else {
            $errorMessage = "Data does not submit, please try again!";
            return redirect()->route('adminEmployeeIndex')->with('errorMessage', $errorMessage);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($user)
    {
        $users = User::where('id', $user)->get();
        return view('dashboard.admin.employee.view', ['users' => $users]);

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user) {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
        //
    }
    public function updateCredentials(Request $request, $id) {
        $employee = User::find($id);
        // Check if password field is not empty
        if(!empty($request->input('password'))) {
            // If password is not empty, update the password field
            $employee->password = bcrypt($request->input('password'));
        }
        // Update the username field
        $employee->email = $request->input('email');
        // Save the updated employee record
        $updateRecord = $employee->save();
        if($updateRecord) {
            return redirect()->back()->with('successMsg', 'Employee updated successfully');
        } else {
            return redirect()->back()->with('errorMsg', 'Something went wrong, please try again.');
        }
    }
    public function UpdateDetails(Request $request, $id) {
        $employee = User::find($id);
        $updateRecord = $employee->update($request->all());
        if($updateRecord) {
            return redirect()->back()->with('successMsg', 'Employee updated successfully');
        } else {
            return redirect()->back()->with('errorMsg', 'Something went wrong, please try again.');
        }
    }

    public function UpdateFiles(Request $request, $id) {
        $user = User::find($id);
        if ($request->hasFile('id_card')) {
            $idCard = $request->file('id_card');
            $idCardName = time() . '_' . $idCard->getClientOriginalName();
            $idCard->move(public_path('/images/users'), $idCardName);
            $user->id_card = $idCardName;
        }
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentName = time() . '_' . $document->getClientOriginalName();
            $document->move(public_path('/images/users'), $documentName);
            $user->document = $documentName;
        }
        if ($request->hasFile('profile_picture')) {
            $picture = $request->file('profile_picture');
            $pictureName = time() . '_' . $picture->getClientOriginalName();
            $picture->move(public_path('/images/users'), $pictureName);
            $user->profile_picture = $pictureName;
        }
        $updateRecord = $user->save();
        if($updateRecord) {
            return redirect()->back()->with('successMsg', 'Files updated successfully');
        } else {
            return redirect()->back()->with('errorMsg', 'Something went wrong, please try again.');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user)
    {
        $user = User::find($user);
        $user->delete();
        return redirect()->route('adminEmployeeIndex')
                         ->with('successMsg', 'Employee deleted successfully');
    }
}
