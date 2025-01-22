<?php

use App\Http\Controllers\AddComment;
use App\Http\Controllers\ArchieveUserController;
use App\Http\Controllers\AreaLocationController;
use App\Http\Controllers\AssignTicket;
use App\Http\Controllers\AssignViewTicket;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\BillingDownload;
use App\Http\Controllers\ChangePackageController;
use App\Http\Controllers\CloseTicket;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisableDueUser;
use App\Http\Controllers\InvoiceDownload;
use App\Http\Controllers\OpenTicket;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PayBillController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentDownload;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShowUser;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDisable;
use App\Http\Controllers\UserDownload;
use App\Http\Controllers\UserEnable;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserRefresh;
use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/administration', function () {
        return view('administration');
    })->name('administration');

    Route::resource('/packages', PackageController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/customer-biiling', UserController::class);
    Route::resource('/billing', BillingController::class);
    Route::resource('/payment', PaymentController::class)->only(['index', 'store']);
    Route::resource('/ticket', TicketController::class);
    Route::resource('/paybill', PayBillController::class);
    Route::resource('user-management', UserManagementController::class);
    Route::resource('area-location', AreaLocationController::class);
    Route::resource('user-type', UserTypeController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/archive', [UserController::class, 'archieve_data'])->name('users.archive');
    Route::resource('/transaction', TransactionController::class);
    Route::get('/transaction/user/{user}', [TransactionController::class, 'userTransactions'])->name('transaction.user');
    // Route::get('transaction/user/{id}', [TransactionController::class, 'userTransactions']);
    Route::resource('/router', RouterController::class);

    //User Lock
    Route::post('/users/bulk-lock', [UserController::class, 'bulkLock'])->name('users.bulk-lock');




    Route::resource('/archieve-users', ArchieveUserController::class);
    Route::get('/archieve/edit/{user}', [ArchieveUserController::class, 'edit'])->name('archieve.edit');
    Route::post('/archieve/{user}/archive', [ArchieveUserController::class, 'restore_data'])->name('archive.archive');

    //myself
    Route::get('/paybill/create/{user}', [PaybillController::class, 'create'])->name('paybill.create');
    Route::get('/paybill/update-due', [PaybillController::class, 'update_due'])->name('paybill.update-due');
    Route::get('/due', [PaybillController::class, 'due'])->name('paybill.due');
    Route::post('/paybill/due-update', [PayBillController::class, 'updateDue'])->name('paybill.due_update');
    Route::get('/get-user/{id}', [PayBillController::class, 'getUser'])->name('get.user');
    //Users
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::delete('/users-delete/{user}', [UserController::class, 'destroyother'])->name('users.destroyother');

    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('/{id}', [TransactionController::class, 'view'])->name('view');
        Route::get('/{id}/edit', [TransactionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TransactionController::class, 'update'])->name('update');
        Route::delete('/{id}', [TransactionController::class, 'destroy'])->name('delete');
    });

    Route::get('/payment/create/{param}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');

    Route::get('/isp', [CompanyController::class, 'edit'])->name('company.edit');
    Route::patch('/isp', [CompanyController::class, 'update'])->name('company.update');

    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    // Route::patch('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/change-package/{user}/edit', [ChangePackageController::class, 'edit'])->name('package-change');
    Route::patch('/change-package/{user}', [ChangePackageController::class, 'update'])->name('package-update');
    Route::patch('/user-disable/{user}', UserDisable::class)->name('user.disable');
    Route::patch('/user-enable/{user}', UserEnable::class)->name('user.enable');

    Route::post('/due-user-disable', DisableDueUser::class)->name('due.user.disable');
    Route::get('/log/{param}', \App\Http\Controllers\Log::class)->name('log');

    Route::post('/open-ticket/{ticket}', OpenTicket::class)->name('open.ticket');
    Route::post('/close-ticket/{ticket}', CloseTicket::class)->name('close.ticket');
    Route::get('/getassign-ticket/{ticket}', [AssignViewTicket::class, 'assignTicket'])->name('getassign.ticket');
    Route::post('/assign-ticket/{ticket}', AssignTicket::class)->name('assign.ticket');

    Route::post('/add-comment', AddComment::class)->name('add.comment');

    Route::get('/user-download', UserDownload::class)->name('user.download');
    Route::get('/billing-download', BillingDownload::class)->name('billing.download');
    Route::get('/payment-download', PaymentDownload::class)->name('payment.download');
    Route::get('/single-download/{user}', ShowUser::class)->name('single.download');
    Route::get('/invoice-download/{row}', InvoiceDownload::class)->name('invoice.download');

    //refresh mikrotik

    Route::get('/user-mikrotik', UserRefresh::class)->name('user.mikrotik-refresh');


    Route::group(['middleware' => ['web']], function () {
        // Payment Routes for bKash
        Route::get('/bkash/payment', [App\Http\Controllers\BkashTokenizePaymentController::class, 'index']);
        Route::get('/bkash/create-payment/{param}', [App\Http\Controllers\BkashTokenizePaymentController::class, 'createPayment'])->name('bkash-create-payment');
        Route::get('/bkash/callback', [App\Http\Controllers\BkashTokenizePaymentController::class, 'callBack'])->name('bkash-callBack');

        //search payment
        Route::get('/bkash/search/{trxID}', [App\Http\Controllers\BkashTokenizePaymentController::class, 'searchTnx'])->name('bkash-serach');

        //refund payment routes
        Route::get('/bkash/refund', [App\Http\Controllers\BkashTokenizePaymentController::class, 'refund'])->name('bkash-refund');
        Route::get('/bkash/refund/status', [App\Http\Controllers\BkashTokenizePaymentController::class, 'refundStatus'])->name('bkash-refund-status');

    });
});

require __DIR__ . '/auth.php';
