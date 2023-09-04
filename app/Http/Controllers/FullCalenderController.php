<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\NotificationLog;
use Auth;
  
class FullCalenderController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */

     public function employeeCalenderIndex(Request $request)
     {
   
         if($request->ajax()) {
        
              $data = Event::whereDate('start', '>=', $request->start)
                        ->whereDate('end',   '<=', $request->end)
                        ->get(['id', 'title', 'start', 'end']);
   
              return response()->json($data);
         }
   
         return view('dashboard.employee.calender');
     }

    public function adminCalenderIndex(Request $request)
    {
  
        if($request->ajax()) {
       
             $data = Event::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get(['id', 'title', 'start', 'end']);
  
             return response()->json($data);
        }
  
        return view('dashboard.admin.calender.index');
    }
 
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function adminCalenderAdd(Request $request)
    {
 
        switch ($request->type) {
           case 'add':
              $event = Event::create([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end,
              ]);
 
              $notification = new NotificationLog();
              $notification->notification_from = Auth::user()->id;
              $notification->title = $event->title; // Use the event title
              $notification->message = "Start: " . $event->start . " - End: " . $event->end; // Use the event start and end dates
              $notification->save();
              
              return response()->json($event);
             break;
  
           case 'update':
              $event = Event::find($request->id)->update([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'delete':
              $event = Event::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             # code...
             break;
        }
    }
}