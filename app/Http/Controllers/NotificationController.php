<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\NotificationLog;
use App\Models\UserNotification;
use Auth;

class NotificationController extends Controller
{

    /** 
    *  ADMIN SIDE CONTROLLER METHOD.
    */

    /** 
    * Nofications Index.
    */

    public function AdminNotificationIndex() 
    {
        $notifications = NotificationLog::all();
        return view("dashboard.admin.notifications.index", compact('notifications'));
    }

    /** 
    * New Nofications All.
    */

    public function AdminNotificationNew() 
    {
        $user = Auth::user();
        $notificationLogs = NotificationLog::with(['userNotification' => function ($query) use ($user) {
            $query->where('status', 0)->where('user_id', $user->id);
        }])
            ->where(function ($query) use ($user) {
                $query->where('notification_to', $user->id)
                    ->orWhereNull('notification_to');
            })
            ->whereDoesntHave('userNotification', function ($query) use ($user) {
                $query->where('status', 1)->where('user_id', $user->id);
            })
            ->get();
        return view("dashboard.admin.notifications.new", ['notifications' => $notificationLogs]);
    }

    /** 
    * New Nofications To Logedin Auth User.
    */

    public function AdminNotificationNewToMe() {
        $user = Auth::user();
        $notifications = NotificationLog::where('notification_to', $user->id)
        ->whereHas('userNotification', function ($query) use ($user) {
            $query->where('status', 0)->where('user_id', $user->id);
        })
        ->with('userNotification')
        ->get();

        // $query = NotificationLog::where('notification_to', $user->id)
        //     ->whereHas('userNotification', function ($query) use ($user) {
        //         $query->where('status', 0)->where('user_id', $user->id);
        //     })
        //     ->with('userNotification');

        // dd($query->toSql());
         return view("dashboard.admin.notifications.self", ['notifications' => $notifications]);
    }


    /** 
    * Send Nofications Form.
    */

    public function AdminNotificationSend() 
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return view("dashboard.admin.notifications.create", ['users'=>$users]);
    }

    /** 
    * Single Nofication Delete.
    */

    public function AdminNotificationDestroy($id) 
    {
        $notification = NotificationLog::findOrFail($id);
        $notification->delete();
        return redirect()->back()->with('successMsg', 'Notification Deleted Successfully');
    }

    /** 
    * Multiple Nofications Delete.
    */

    public function AdminNotificationDestroyAll(Request $request) 
    {
        $ids = $request->ids;
        $ids = explode(",", $ids);
        NotificationLog::whereIn('id', $ids)->delete();
        return response()->json(['success'=>"Notifications Deleted successfully."]);
    }

    /**
     * EMPLOYEE SIDE CONTROLLER METHOD.
     */

    /** 
    * New Nofications All.
    */

    public function EmployeeNotificationNew() 
    {
        $user = Auth::user();
        $notificationLogs = NotificationLog::with(['userNotification' => function ($query) use ($user) {
            $query->where('status', 0)->where('user_id', $user->id);
        }])
            ->where(function ($query) use ($user) {
                $query->where('notification_to', $user->id)
                    ->orWhereNull('notification_to');
            })
            ->whereDoesntHave('userNotification', function ($query) use ($user) {
                $query->where('status', 1)->where('user_id', $user->id);
            })
            ->get();
        return view("dashboard.employee.notifications.new", ['notifications' => $notificationLogs]);
    }

    /** 
    * New Nofications To Logedin Auth.
    */

    public function EmployeeNotificationNewToMe() 
    {
        $user = Auth::user();
        $notifications = NotificationLog::where('notification_to', $user->id)
        ->whereHas('userNotification', function ($query) use ($user) {
            $query->where('status', 0)->where('user_id', $user->id);
        })
        ->with('userNotification')
        ->get();
         return view("dashboard.employee.notifications.self", ['notifications' => $notifications]);
    }

    /** 
    * New Nofication form.
    */

    public function EmployeeNotificationSend() 
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return view("dashboard.employee.notifications.create", ['users'=>$users]);
    }

    /**
     * Notify The Employe To Join The Project.
     */

    public function EmployeeNotify(Request $request) 
    {
        $data = $request->all();
        $notificationLog = NotificationLog::create($data);
        $notificationId = $notificationLog->id;
        $notificationTo = $notificationLog->notification_to;

        $userNotification = new UserNotification(); // Instantiate UserNotification object
        $userNotification->notification_id = $notificationId;
        $userNotification->user_id = $notificationTo;
        $userNotification->status = 0;
        $userNotification->save();

        return redirect()->back()->with('successMsg', 'User Notified Successfully');
    }

    /** 
     * Common Method For Storing Notifications.
    */

    public function NotificationStore(Request $request) 
    {
        $data = $request->all();
        $data = NotificationLog::create($data);
        $notificationId = $data->id;
        if($data->notification_to == "") 
        {
            $users = User::all();
            foreach ($users as $user) 
            {
                $userNotification = new UserNotification();
                $userNotification->user_id = $user->id;
                $userNotification->notification_id = $notificationId;
                $userNotification->status = 0;
                $userNotification->save();
            }
            return redirect()->back()->with('successMsg', 'Notification Created Successfully');
        }
        else 
        {
            $userNotification = new UserNotification();
            $userNotification->user_id = $data->notification_to;
            $userNotification->notification_id = $notificationId;
            $userNotification->status = 0;
            $userNotification->save();
            return redirect()->back()->with('successMsg', 'Notification Created Successfully');
        }

    }

    /**
     * Common Method For Update Notification Status.
     */

     public function NotificationUpdate(Request $request, string $id)
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
     * Common Method For Notifictions And Project Count 
    */

    public function GetNotificationsCount()
    {

    $user = Auth::user();
    $count = NotificationLog::count();
    $countNew = NotificationLog::with(['userNotification' => function ($query) use ($user) {
        $query->where('status', 0)->where('user_id', $user->id);
        }])
        ->where(function ($query) use ($user) {
            $query->where('notification_to', $user->id)
                ->orWhereNull('notification_to');
        })
        ->whereDoesntHave('userNotification', function ($query) use ($user) {
            $query->where('status', 1)->where('user_id', $user->id);
        })
        ->count();

    $countNewToMe = NotificationLog::where('notification_to', '=', Auth::user()->id)
    ->whereHas('userNotification', function ($query) {
        $query->where('status', 0);
    })
    ->count();

    return response()->json([
                             'count' => $count, 
                             'countNew' => $countNew, 
                             'countNewToMe' => $countNewToMe
                            ]);
    }

    /** 
     * Projects Count.
    */
    public function GetProjectsCount() 
    {
        //
    }
    
}