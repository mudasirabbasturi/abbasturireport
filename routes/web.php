<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PayrollController;

use App\Http\Controllers\Employee\EmployeeHomeController;
use App\Http\Controllers\Employee\ActionController;
use App\Http\Controllers\Employee\EmployeeNotification;

use App\Http\Controllers\FullCalenderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
// Deny access to register and forgot password routes
Route::middleware('guest')->group(function () {
    Route::get('register', function () {
        abort(403);
    });
    Route::post('register', function () {
        abort(403);
    });
    Route::get('forgot-password', function () {
        abort(403);
    });
    Route::post('forgot-password', function () {
        abort(403);
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        if (auth()->user()->type == 'admin') {
            return redirect('/admin');
        } 
        else if(auth()->user()->type == 'employee') {
            return redirect('/employee');
        }
    });
    Route::get('/admin', [adminIndex::class, 'index'])->name('admin.index');
    Route::get('/employee', [EmployeeHomeController::class, 'index'])->name('employee.index');
});
/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:employee'])->group(function () {
    Route::get('/employee', [HomeController::class, 'employeeIndex'])->name('employee.index');
    
    /**
     * Calander Routes.
     */
    Route::get('/employee/calender', [FullCalenderController::class, 'employeeCalenderIndex'])->name('employee.calender');
   
    Route::get('/employee/project/{project}', [EmployeeHomeController::class, 'projectShow'])->name('projectShow.show');
    // Route::redirect('/type/project/{project}','/employee/project/{project}', 301);
    
    Route::get('/employee/project', [EmployeeHomeController::class, 'employeeProjectIndex'])->name('employeeProjectIndex');
    Route::post('/employee/project/{id}', [EmployeeHomeController::class, 'projectUpdate'])->name('projectUpdate.store');
    Route::resource('/employee', EmployeeHomeController::class);
    Route::resource('/employee/action', ActionController::class);
    Route::get('/employee/action/percent/{id}', [ActionController::class, 'percent'])->name('action.percent');
    Route::post('/employee/action/completed/{id}', [ActionController::class, 'actionCompleted'])->name('action.complete');
    Route::post('/employee/action/newupdate/{id}', [ActionController::class, 'showUpdate'])->name('action.showUpdate');
    Route::get('/employee/projects/pending', [EmployeeHomeController::class, 'Pending'])->name('pending');
    Route::get('/employee/projects/current-progress', [EmployeeHomeController::class, 'CurrentProgress'])->name('current.progress');
    Route::get('/employee/projects/take-of-on-progress', [EmployeeHomeController::class, 'takeOfOnprogress'])->name('takeOfOnprogress');
    Route::get('/employee/projects/pricing-on-progress', [EmployeeHomeController::class, 'pricingOnprogress'])->name('pricingOnprogress');
    Route::get('/employee/projects/hold', [EmployeeHomeController::class, 'Hold'])->name('hold');
    Route::get('/employee/projects/revision', [EmployeeHomeController::class, 'Revision'])->name('revision');
    Route::get('/employee/projects/completed', [EmployeeHomeController::class, 'Completed'])->name('completed');
    Route::get('/employee/projects/deliver', [EmployeeHomeController::class, 'Deliver'])->name('deliver');
    
    /** 
     * Self User Routing List. 
    */
    Route::get('/employee/self/projects/', [EmployeeHomeController::class, 'selfProjectIndex'])->name('selfProIndex');
    Route::get('/employee/self/projects/pending', [EmployeeHomeController::class, 'selfProjectPending'])->name('selfProPending');
    Route::get('/employee/self/projects/take-of-on-progress', [EmployeeHomeController::class, 'selfProjectTakeOfOnProgress'])->name('selfProTakeOfonProgress');
    Route::get('/employee/self/projects/pricing-on-progress', [EmployeeHomeController::class, 'selfProjectPricingOnProgress'])->name('selfProPricingOnProgress');
    Route::get('/employee/self/projects/hold', [EmployeeHomeController::class, 'selfProjectHold'])->name('selfProHold');
    Route::get('/employee/self/projects/revision', [EmployeeHomeController::class, 'selfProjectRevision'])->name('selfProRevision');
    Route::get('/employee/self/projects/completed', [EmployeeHomeController::class, 'selfProjectCompleted'])->name('selfProCompleted');
    Route::get('/employee/self/projects/deliver', [EmployeeHomeController::class, 'selfProjectDeliver'])->name('selfProDeliver');

    /** 
     * Notifications Route.
    */
    Route::get('/employee/notifications/new', [NotificationController::class, 'EmployeeNotificationNew'])->name('employee.notifications.new');
    Route::get('/employee/notifications/new/to-me', [NotificationController::class, 'EmployeeNotificationNewToMe'])->name('employee.notifications.NewToMe');
    Route::get('/employee/notifications/send', [NotificationController::class, 'EmployeeNotificationSend'])->name('employee.notification.send');
    Route::post('/employee/notification/send', [NotificationController::class, 'NotificationStore'])->name('employee.notification.store');
    Route::match(['get', 'post', 'put'], '/employee/notification/update/{id}', [NotificationController::class, 'NotificationUpdate'])->name('employee.notification.update');
    Route::post('/employee/notification/notify', [NotificationController::class, 'EmployeeNotify'])->name('employee.notify.store');

    /**
     * Ajax Notifications and Projects Count.
     */
    Route::get('/employee/api/notifications/count', [NotificationController::class, 'GetNotificationsCount'])->name('employee.notifications.count');
    Route::get('/employee/api/projects/count', [NotificationController::class, 'GetProjectsCount'])->name('employee.projects.count');

});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {

    // Main Route.
    Route::get('/admin', [HomeController::class, 'adminIndex'])->name('admin.index');
    // Chart Route.

    Route::get('/admin/chart', [HomeController::class, 'chart'])->name('admin.chart');
    
    // Employee Routes.
    
    Route::resource('/admin/employee', EmployeeController::class)->names([
        'index' => 'adminEmployeeIndex'
    ]);
    
    Route::get('/admin/client', [HomeController::class, 'ClientIndex'])->name('admin.clients');
    Route::get('/admin/client/create', [HomeController::class, 'ClientCreate'])->name('admin.client.create');
    Route::post('/admin/client/store', [HomeController::class, 'ClientStore'])->name('admin.client.store');
    Route::match(['get', 'post', 'delete'],'/admin/client/{destroy}', [HomeController::class, 'ClientDestroy'])->name('admin.client.destroy');
    Route::get('/admin/client/edit/{edit}', [HomeController::class, 'ClientEdit'])->name('admin.client.edit');
    Route::put('/admin/client/update/{update}', [HomeController::class, 'ClientUpdate'])->name('admin.client.update');

    Route::post('/admin/employee/{id}', [EmployeeController::class, 'updateCredentials'])->name('update.credentials');
    Route::post('/admin/update-details/{id}', [EmployeeController::class, 'UpdateDetails'])->name('update.details');
    Route::post('/admin/update-files/{id}', [EmployeeController::class, 'UpdateFiles'])->name('update.files');
    
    // Project Routes.

    Route::resource('/admin/project', ProjectController::class);
    // Route::redirect('/type/project/{project}','/admin/project/{project}');
    
    Route::get('/admin/clients/{id}', [ProjectController::class, 'clients'])->name('clients.data');
    
    Route::post('/admin/project/{id}', [ProjectController::class, "UpdateProjectStatus"])->name('adminActionStatus.update');

    Route::get('/project/report/{id}', [ProjectController::class, 'report'])->name('report.show');
    Route::get('/admin/projects/pending', [ProjectController::class, 'projectPending'])->name('project.pending');
    Route::get('/admin/projects/current-progress', [ProjectController::class, 'adminCurrentProgress'])->name('admin.current.progress');
    Route::get('/admin/projects/take-of-on-progress', [ProjectController::class, 'projectProgress'])->name('project.progress');
    Route::get('/admin/projects/pricing-on-progress', [ProjectController::class, 'pricingProgress'])->name('project.pricingProgress');
    Route::get('/admin/projects/completed', [ProjectController::class, 'projectCompleted'])->name('project.completed');
    Route::get('/admin/projects/deliver', [ProjectController::class, 'projectDeliver'])->name('project.deliver');
    Route::get('/admin/projects/hold', [ProjectController::class, 'projectHold'])->name('project.hold');
    Route::get('/admin/projects/revision', [ProjectController::class, 'projectRevision'])->name('project.revision');
    Route::get('/admin/filter', [ProjectController::class, 'adminProjectFilter'])->name('project.adminFilter');
    Route::get('/admin/userfilter/{id}', [ProjectController::class, 'adminProjectFilterUser'])->name('project.adminFilter.user');
    Route::get('/admin/project/copy/{id}', [ProjectController::class, 'copyProject'])->name('project.copy');
    Route::match(['get', 'post'], '/admin/filterData', [ProjectController::class, 'ProjectFilterData'])->name('project.FilterData');
   
    // Notifications Route.
    Route::get('/admin/notifications/', [NotificationController::class, 'AdminNotificationIndex'])->name('admin.notifications');
    Route::get('/admin/notifications/new', [NotificationController::class, 'AdminNotificationNew'])->name('admin.notifications.new');
    Route::get('/admin/notifications/new/to-me', [NotificationController::class, 'AdminNotificationNewToMe'])->name('admin.notifications.NewToMe');
    Route::get('/admin/notification/send', [NotificationController::class, 'AdminNotificationSend'])->name('admin.notification.send');
    Route::post('/admin/notification/send', [NotificationController::class, 'NotificationStore'])->name('admin.notification.store');
    Route::match(['get', 'post', 'put'], '/admin/notification/update/{id}', [NotificationController::class, 'NotificationUpdate'])->name('admin.notification.update');
    Route::match(['get', 'post', 'delete'],'/admin/notification/{id}', [NotificationController::class, 'AdminNotificationDestroy'])->name('admin.notification.destroy');
    Route::delete('/admin/notification/', [NotificationController::class, 'AdminNotificationDestroyAll'])->name('admin.notificatons.DestroyAll');
  
    // Payroll.
    Route::resource('/admin/payroll', PayrollController::class);
    
    // Calander Routes.
    Route::get('/admin/calender', [FullCalenderController::class, 'adminCalenderIndex'])->name('admin.calender');
    Route::post('/admin/calender', [FullCalenderController::class, 'adminCalenderAdd'])->name('admin.calender.add');

    /**
     * Ajax Notifications and Projects Count.
     */
    Route::get('/admin/api/notifications/count', [NotificationController::class, 'GetNotificationsCount'])->name('admin.notifications.count');
    Route::get('/admin/api/projects/count', [NotificationController::class, 'GetProjectsCount'])->name('admin.projects.count');

});

// https://cpanel-b14.web-hosting.com/