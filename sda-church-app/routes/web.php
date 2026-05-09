<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Admin creation page - access and delete once admin is set up
Route::get('/create-admin', [AdminController::class, 'create'])->name('admin.create');
Route::post('/create-admin', [AdminController::class, 'store'])->name('admin.store');

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', \App\Http\Middleware\RestrictTreasurerAccess::class, \App\Http\Middleware\RestrictFundsControllerAccess::class])->name('dashboard');

Route::middleware(['auth', \App\Http\Middleware\RestrictMemberAccess::class, \App\Http\Middleware\RestrictTreasurerAccess::class, \App\Http\Middleware\RestrictFundsControllerAccess::class])->group(function () {
    // Department Routes
    Route::get('/departments/export', [DepartmentController::class, 'export'])->name('departments.export');
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');

    // Member Management Routes
    Route::get('members/export', [MemberController::class, 'export'])->name('members.export');
    Route::resource('members', MemberController::class);

    // Baptism Management Routes
    Route::get('/baptisms/export', [App\Http\Controllers\BaptismController::class, 'export'])->name('baptisms.export');
    Route::resource('baptisms', App\Http\Controllers\BaptismController::class);

    // Announcement Management Routes
    Route::resource('announcements', App\Http\Controllers\AnnouncementController::class);

    // Transfer Management Routes
    Route::get('/transfers/export', [App\Http\Controllers\TransferController::class, 'export'])->name('transfers.export');
    Route::resource('transfers', App\Http\Controllers\TransferController::class);

    // Document Management Routes
    Route::get('/documents/bulk-download', [App\Http\Controllers\DocumentController::class, 'bulkDownload'])->name('documents.bulk-download');
    Route::resource('documents', App\Http\Controllers\DocumentController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/change-password', [\App\Http\Controllers\ForcePasswordController::class, 'create'])->name('password.change.form');
    Route::post('/change-password', [\App\Http\Controllers\ForcePasswordController::class, 'store'])->name('password.change.store');

    Route::get('/my-dashboard', [\App\Http\Controllers\MemberDashboardController::class, 'index'])->name('member.dashboard');
    Route::get('/activity-log', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-log.index');
    Route::get('/my-announcements', [\App\Http\Controllers\MemberAnnouncementsController::class, 'index'])->name('member.announcements');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Finance Management Routes (Restricted)
    Route::middleware('can:manage-finance')->group(function () {
        Route::get('/finance/export', [App\Http\Controllers\FinanceController::class, 'export'])->name('finance.export');
        Route::get('/finance', [App\Http\Controllers\FinanceController::class, 'index'])->name('finance.index');
        
        // Tithes
        Route::post('/finance/tithe', [App\Http\Controllers\FinanceController::class, 'storeTithe'])->name('finance.tithe.store');
        Route::delete('/finance/tithe/{tithe}', [App\Http\Controllers\FinanceController::class, 'destroyTithe'])->name('finance.tithe.destroy');
        
        // Offerings
        Route::post('/finance/offering', [App\Http\Controllers\FinanceController::class, 'storeOffering'])->name('finance.offering.store');
        Route::delete('/finance/offering/{offering}', [App\Http\Controllers\FinanceController::class, 'destroyOffering'])->name('finance.offering.destroy');
        
        // Donations
        Route::post('/finance/donation', [App\Http\Controllers\FinanceController::class, 'storeDonation'])->name('finance.donation.store');
        Route::delete('/finance/donation/{donation}', [App\Http\Controllers\FinanceController::class, 'destroyDonation'])->name('finance.donation.destroy');

        // Expenditures
        Route::post('/finance/expenditure', [App\Http\Controllers\FinanceController::class, 'storeExpenditure'])->name('finance.expenditure.store');
        Route::delete('/finance/expenditure/{expenditure}', [App\Http\Controllers\FinanceController::class, 'destroyExpenditure'])->name('finance.expenditure.destroy');
    });

    // Funds Controller Routes
    Route::get('/funds-controller', [\App\Http\Controllers\FundsController::class, 'index'])->name('funds-controller.index');
    Route::get('/funds-controller/classes/export', [\App\Http\Controllers\FundsController::class, 'exportClasses'])->name('funds-controller.classes.export');
    Route::get('/funds-controller/classes', [\App\Http\Controllers\FundsController::class, 'classes'])->name('funds-controller.classes');
    Route::post('/funds-controller/classes', [\App\Http\Controllers\FundsController::class, 'storeClass'])->name('funds-controller.classes.store');
    Route::get('/funds-controller/departments/export', [\App\Http\Controllers\FundsController::class, 'exportDepartments'])->name('funds-controller.departments.export');
    Route::get('/funds-controller/departments', [\App\Http\Controllers\FundsController::class, 'departments'])->name('funds-controller.departments');
    Route::post('/funds-controller/departments', [\App\Http\Controllers\FundsController::class, 'storeDepartment'])->name('funds-controller.departments.store');
});


require __DIR__.'/auth.php';
