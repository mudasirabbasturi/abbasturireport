<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\NotificationLog;
use App\Models\UserNotification;
use Auth;

class EmployeeNotification extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        
        // $notifications = NotificationLog::with('userNotification')->get();
        // foreach ($notifications as $notification) {
        //     foreach ($notification->userNotification as $userNotification) {
        //         if($userNotification->user_id === Auth::user()->id) {
        //             echo $userNotification->status . "</br>";
        //         }
        //     }
        // }
        // return view("dashboard.employee.notifications.index", compact('notifications'));

        $notifications = NotificationLog::with('userNotification')
        ->where(function ($query) {
            $query->where('notification_to', auth()->user()->full_name)
                ->orWhereNull('notification_to');
        })
        ->get();
        return view("dashboard.employee.notifications.index", compact('notifications'));

   }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('full_name', '!=', Auth::user()->full_name)->get();
        return view("dashboard.employee.notifications.create", ['users'=>$users]);
    }

    public function EmployeeNewNotifications() {

        $user = Auth::user();

        $notificationLogs = NotificationLog::with(['userNotification' => function ($query) use ($user) {
            $query->where('status', 0)->where('user_id', $user->id);
        }])
            ->where(function ($query) use ($user) {
                $query->where('notification_to', $user->full_name)
                    ->orWhereNull('notification_to');
            })
            ->whereDoesntHave('userNotification', function ($query) use ($user) {
                $query->where('status', 1)->where('user_id', $user->id);
            })
            ->get();
        
        return view("dashboard.employee.notifications.new", ['notifications' => $notificationLogs]);
    }

    public function EmployeeNotificationsToMe() {
        $user = Auth::user();
        $notifications = NotificationLog::where('notification_to', $user->full_name)
        ->whereHas('userNotification', function ($query) use ($user) {
            $query->where('status', 0)->where('user_id', $user->id);
        })
        ->with('userNotification')
        ->get();
         return view("dashboard.employee.notifications.self", ['notifications' => $notifications]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data = NotificationLog::create($data);

        $notificationId = $data->id;
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
        return redirect()->back()->with('successMsg', 'Notification Created Successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        
        $notification = NotificationLog::find($id);

        if (!$notification) {
            return redirect()->back()->with('errorMsg', 'Notification not found.');
        }

        $userNotification = UserNotification::where('user_id', $user->id)
            ->where('notification_id', $notification->id)
            ->first();

        if (!$userNotification) {
            return redirect()->back()->with('errorMsg', 'User notification not found.');
        }

        $userNotification->status = $request->has('status') ? 1 : 0;
        $userNotification->save();

        return redirect()->back()->with('successMsg', 'Notification is marked as read successfully.');
   }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

