$notificationCount = UserNotification::count();
        $notificationCountNew = UserNotification::where('status', 0)->count();

        view()->composer('*', function ($view) use ($notificationCount, $notificationCountNew) {
        // view()->composer('*', function ($view) {
            $view->with([
                'projectCount' => Project::count(),
                'projectCountPending' => Project::where('project_status', 'pending')->count(),
                'projectCountTakeoffOnProgress' => Project::where('project_status', 'Takeoff On Progress')->count(),
                'projectCountPriceOnProgress' => Project::where('project_status', 'Pricing On Progress')->count(),
                'projectCountCompleted' => Project::where('project_status', 'completed')->count(),
                'projectCountDeliver' => Project::where('project_status', 'deliver')->count(),
                'projectCountHold' => Project::where('project_status', 'hold')->count(),
                'projectCountRevision' => Project::where('project_status', 'revision')->count(),
                'notificationCount' => $notificationCount,
                'notificationCountNew' => $notificationCountNew,
                'notificationCountNewTome' => NotificationLog::where('notification_to', '=', 'Auth::user()->full_name')->count(),
            ]);
        });




        view()->composer('*', function ($view) {
            $notificationLogs = NotificationLog::whereHas('userNotification', function ($query) {
                $query->where('status', 0);
            })->get();
        
            $notificationCount = UserNotification::count();
            $notificationCountNew = UserNotification::where('status', 0)->count();
        
            $view->with([
                'projectCount' => Project::count(),
                'projectCountPending' => Project::where('project_status', 'pending')->count(),
                'projectCountTakeoffOnProgress' => Project::where('project_status', 'Takeoff On Progress')->count(),
                'projectCountPriceOnProgress' => Project::where('project_status', 'Pricing On Progress')->count(),
                'projectCountCompleted' => Project::where('project_status', 'completed')->count(),
                'projectCountDeliver' => Project::where('project_status', 'deliver')->count(),
                'projectCountHold' => Project::where('project_status', 'hold')->count(),
                'projectCountRevision' => Project::where('project_status', 'revision')->count(),
                'notificationLogs' => $notificationLogs,
                'notificationCount' => $notificationCount,
                'notificationCountNew' => $notificationCountNew,
                'notificationCountNewToMe' => NotificationLog::where('notification_to', '=', Auth::user()->full_name)->count(),
            ]);
        });





        public function boot(): void
    {

        $notificationCountNew = NotificationLog::whereHas('userNotification', function ($query) {
            $query->where('status', 0);
        })->count();

        $notificationCountNewTome = NotificationLog::where('notification_to', '=', Auth::user()->full_name)
        ->whereHas('userNotification', function ($query) {
            $query->where('status', 0);
        })
        ->count();

        view()->composer('*', function ($view) use ($notificationCountNew,$notificationCountNewTome) {
        // view()->composer('*', function ($view) {
            $view->with([
                'projectCount' => Project::count(),
                'projectCountPending' => Project::where('project_status', 'pending')->count(),
                'projectCountTakeoffOnProgress' => Project::where('project_status', 'Takeoff On Progress')->count(),
                'projectCountPriceOnProgress' => Project::where('project_status', 'Pricing On Progress')->count(),
                'projectCountCompleted' => Project::where('project_status', 'completed')->count(),
                'projectCountDeliver' => Project::where('project_status', 'deliver')->count(),
                'projectCountHold' => Project::where('project_status', 'hold')->count(),
                'projectCountRevision' => Project::where('project_status', 'revision')->count(),
                'notificationCount' => NotificationLog::count(),
                'notificationCountNew' => $notificationCountNew,
                'notificationCountNewTome' => $notificationCountNewTome,
            ]);
        });
        


        Paginator::useBootstrap();
    }
