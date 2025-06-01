<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    Auth\LoginController,
    Auth\RegisterController,
    PageController,
    BulkOrderController,
    AdminDashboardController,
    PaymentController,
    LoyaltyController,
    OrderController,
    QRController,
    GuestController
};
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Auth;

// ✅ Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', fn() => view('layouts.main'));

    Route::post('/guest/email', [GuestController::class, 'store'])->name('guest.email.store');

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// ✅ Public Access — Stripe Redirect Fix (No auth middleware)
Route::get('/payment/regular/success', [PaymentController::class, 'regularSuccess'])->name('payment.regular.success');

// ✅ QR System Routes
Route::get('/qr', [QRController::class, 'entry'])->name('qr.entry');
Route::get('/qr-demo', [QRController::class, 'demo'])->middleware('auth')->name('qr.demo');

// ✅ Guest-Accessible Order Flow (for QR)
Route::get('/orders/new', [OrderController::class, 'createOrder'])->name('orders.create');
Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
Route::get('/payment/guest', [PaymentController::class, 'guestMultiPaymentPage'])->name('payment.guest.multi');
Route::post('/payment/guest/initiate', [PaymentController::class, 'guestInitiatePayment'])->name('payment.guest.initiate');
Route::get('/payment/guest/success', [PaymentController::class, 'guestSuccess'])->name('payment.guest.success');
Route::post('/payment/regular/initiate', [PaymentController::class, 'regularInitiate'])->name('payment.regular.initiate');


// ✅ Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'redirectDashboard'])->name('dashboard');

    Route::get('/notifications', fn() => view('notifications.index', [
        'notifications' => Auth::user()->notifications()->paginate(10)
    ]))->name('notifications.all');

    Route::post('/notifications/mark-all-read', fn() => tap(Auth::user()->unreadNotifications->markAsRead(), fn() => back()))->name('notifications.readall');

    // 🧠 Regular User Routes
    Route::get('/regular-dashboard', [DashboardController::class, 'regularDashboard'])->name('regular.dashboard');
    Route::get('/transactions', [LoyaltyController::class, 'transactionHistory'])->name('transactions.history');
    Route::get('/regular/orders', [DashboardController::class, 'orders'])->name('regular.orders');
    Route::get('/orders/{id}/receipt-pdf', [OrderController::class, 'downloadReceipt'])->name('receipt.download');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');


    // Stripe Regular Payment
    Route::get('/payment/regular/multi', [PaymentController::class, 'regularPaymentMultiPage'])->name('payment.regular.multi');
    Route::get('/payment/regular/{order}', [PaymentController::class, 'regularPaymentPage'])->name('payment.regular.page');
    Route::get('/checkout/{order}', [PaymentController::class, 'showCheckoutPage'])->name('checkout.page');

    // Loyalty Points
    Route::post('/loyalty/redeem', [LoyaltyController::class, 'redeemPoints']);
    Route::get('/loyalty', [LoyaltyController::class, 'showLoyaltyPage'])->name('loyalty.index');

    // Profile Update
    Route::post('/update-profile', [DashboardController::class, 'updateProfile'])->name('update.profile');

    // Redemption Catalog
    Route::get('/redeem_catalog', [LoyaltyController::class, 'showRedeemCatalog'])->name('redeem_catalog');
    Route::post('/redeem/generate/{rewardId}', [LoyaltyController::class, 'generateCoupon'])->name('redeem.generate');

    // Bulk User Dashboard
    Route::get('/bulk-dashboard', [DashboardController::class, 'bulkDashboard'])->name('bulk.dashboard');

    // Bulk Order Management
    Route::get('/bulk-orders', [BulkOrderController::class, 'index'])->name('bulk.orders.index');
    Route::get('/bulk-orders/create', [BulkOrderController::class, 'create'])->name('bulk.orders.create');
    Route::post('/bulk-orders', [BulkOrderController::class, 'store'])->name('bulk.orders.store');
    Route::get('/bulk-orders/{id}/edit', [BulkOrderController::class, 'edit'])->name('bulk.orders.edit');
    Route::put('/bulk-orders/{id}', [BulkOrderController::class, 'update'])->name('bulk.orders.update');
    Route::delete('/bulk-orders/{id}', [BulkOrderController::class, 'destroy'])->name('bulk.orders.destroy');

    Route::get('/bulk-orders/{id}', [BulkOrderController::class, 'show'])->name('bulk.orders.show');
    Route::get('/bulk-orders/{id}/payment-gateway', [BulkOrderController::class, 'paymentGateway'])->name('payment.bulk.gateway');

    // Payment
    Route::post('/payment/bulk/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.bulk.initiate');
    Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

    // Admin
    Route::put('/admin/update-order-status/{id}/{type}', [AdminDashboardController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/create-admin', [AdminDashboardController::class, 'showCreateAdminForm'])->name('admin.createForm');
    Route::post('/admin/store-admin', [AdminDashboardController::class, 'storeAdmin'])->name('admin.store');
    Route::post('/admin/make-admin/{id}', [AdminDashboardController::class, 'makeAdmin'])->name('admin.makeAdmin');
    Route::get('/admin/bulk-order/transaction-history', [AdminDashboardController::class, 'transactionHistory'])->name('admin.transactionHistory');
    Route::get('/admin/export-transaction-history', [AdminDashboardController::class, 'exportTransactionHistory'])->name('admin.exportTransactionHistory');
    Route::get('/admin/export-bulk-orders', [AdminDashboardController::class, 'exportBulkOrders'])->name('admin.exportBulkOrders');
    Route::get('/admin/bulk-orders', [AdminDashboardController::class, 'bulkOrders'])->name('admin.bulkOrders');
    Route::get('/admin/bulk-order/{id}/details', [AdminDashboardController::class, 'viewBulkOrderDetails'])->name('admin.viewBulkOrderDetails');

    Route::middleware(['auth', IsAdmin::class])->prefix('admin')->group(function () {
        Route::resource('promotions', PromotionController::class)->names([
            'index' => 'promotions.index',
            'create' => 'promotions.create',
            'store' => 'promotions.store',
            'edit' => 'promotions.edit',
            'update' => 'promotions.update',
            'destroy' => 'promotions.destroy',
        ]);
    });

    // Pages
    Route::get('services', [PageController::class, 'services'])->name('services');
    Route::get('about', [PageController::class, 'about'])->name('about');

    // Profile
    Route::get('/profile/edit', [RegisterController::class, 'showEditProfileForm'])->name('edit.profile');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
