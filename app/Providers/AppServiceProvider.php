<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\Admin\Project;
use App\Models\NotificationLog;
use App\Models\UserNotification;
use App\Models\User;

use Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
    
      view()->composer('*', function ($view) {
          // Set default values
          $defaultValues = [
            // For All User.
              'ProjectCount' => 0,
              'ProjectPendingCount' => 0,
              'ProjectCurrentCount' => 0,
              'ProjectTakeOfOnProgressCount' => 0,
              'ProjectPricingOnProgressCount' => 0,
              'ProjectCompletedCount' => 0,
              'ProjectHoldCount' => 0,
              'ProjectRevisionCount' => 0,
              'ProjectDeliverCount' => 0,

              // For Self User.
              'SelfProjectCount' => 0,
              'SelfProjectTakeOfOnProgressCount' => 0,
              'SelfProjectPricingOnProgressCount' => 0,
              'SelfProjectCompletedCount' => 0,
              'SelfProjectHoldCount' => 0,
              'SelfProjectRevisionCount' => 0,
              'SelfProjectDeliverCount' => 0,

              // For Notifications.
              'NotificationsCount' => 0,
              'NotificationsCountNew' => 0,
              'NotificationsCountNewToMe' => 0,

              // Get All Users 
              'AllUsers' => 0,

          ];
      
          if (Auth::check()) {
              $user = Auth::user();
      
              // Override default values when the user is logged in
              $defaultValues['ProjectCount'] = Project::count();
              $defaultValues['ProjectPendingCount'] = Project::where('project_status', 'pending')->count();
              $defaultValues['ProjectCurrentCount'] = Project::whereNotIn('project_status', ['deliver', 'completed', 'pending'])->count();
              $defaultValues['ProjectTakeOfOnProgressCount'] = Project::where('project_status', 'Takeoff On Progress')->count();
              $defaultValues['ProjectPricingOnProgressCount'] = Project::where('project_status', 'Pricing On Progress')->count();
              $defaultValues['ProjectCompletedCount'] = Project::where('project_status', 'completed')->count();
              $defaultValues['ProjectHoldCount'] = Project::where('project_status', 'hold')->count();
              $defaultValues['ProjectRevisionCount'] = Project::where('project_status', 'revision')->count();
              $defaultValues['ProjectDeliverCount'] = Project::where('project_status', 'deliver')->count();
              $defaultValues['AllUsers'] = User::where('type', '!=', 1)->get();
      
              // Self Project Count.
              $defaultValues['SelfProjectCount'] = Project::whereHas('actions', function ($query) use ($user) {
                  $query->where('user_id', $user->id);
              })->count();
      
              $defaultValues['SelfProjectTakeOfOnProgressCount'] = Project::whereHas('actions', function ($query) use ($user) {
                  $query->where('user_id', $user->id);
              })->where('project_status', 'Takeoff On Progress')->count();
      
              $defaultValues['SelfProjectPricingOnProgressCount'] = Project::whereHas('actions', function ($query) use ($user) {
                  $query->where('user_id', $user->id);
              })->where('project_status', 'Pricing On Progress')->count();
      
              $defaultValues['SelfProjectCompletedCount'] = Project::whereHas('actions', function ($query) use ($user) {
                  $query->where('user_id', $user->id);
              })->where('project_status', 'completed')->count();
      
              $defaultValues['SelfProjectHoldCount'] = Project::whereHas('actions', function ($query) use ($user) {
                  $query->where('user_id', $user->id);
              })->where('project_status', 'hold')->count();
      
              $defaultValues['SelfProjectRevisionCount'] = Project::whereHas('actions', function ($query) use ($user) {
                  $query->where('user_id', $user->id);
              })->where('project_status', 'revision')->count();
      
              $defaultValues['SelfProjectDeliverCount'] = Project::whereHas('actions', function ($query) use ($user) {
                  $query->where('user_id', $user->id);
              })->where('project_status', 'deliver')->count();
      
              // Notifications Count.
              
              $defaultValues['NotificationsCount'] = NotificationLog::count();

              $defaultValues['NotificationsCountNew'] = NotificationLog::with(['userNotification' => function ($query) use ($user) {
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

              $defaultValues['NotificationsCountNewToMe'] = NotificationLog::where('notification_to', $user->id)
              ->whereHas('userNotification', function ($query) use ($user) {
                  $query->where('status', 0)->where('user_id', $user->id);
              })
              ->with('userNotification')
              ->count();
          }
      
          $view->with($defaultValues);
        });
    
    }
}