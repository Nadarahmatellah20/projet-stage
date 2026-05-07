<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminAuthController, AdminController, UserAuthController, UserController,
    HardwareController, SoftwareController, ServiceController, CourseController,
    FrontendController, OrderController, ReviewController, TicketController
};
use App\Http\Middleware\{AdminAuth, RedirectIfLogedIn, UserLoggedIn};

/*---------------- USER AUTH -----------------*/

Route::prefix('user')->group(function () {
    Route::get('register', [UserAuthController::class, 'showRegisterForm'])->name('registerForm');
    Route::get('login', [UserAuthController::class, 'showLoginForm'])->middleware(RedirectIfLogedIn::class)->name('loginForm');
    Route::post('register', [UserAuthController::class, 'register'])->name('userRegister');
    Route::post('login', [UserAuthController::class, 'login'])->name('userLogin')->middleware('throttle:5,1'); // FIX: max 5 محاولات في الدقيقة
    Route::get('signout', [UserAuthController::class, 'signout'])->name('userSignOut');
});

/*---------------- FRONTEND & DASHBOARD -----------------*/

Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('main');
    Route::get('search', 'searchProduct');

    Route::get('dashboard', 'showDashboard')->middleware(UserLoggedIn::class)->name('userDashboard');
    Route::get('dashboard/account', 'accountSettings')->middleware(UserLoggedIn::class)->name('userAccountSettings');

    Route::post('dashboard/account/update-info', 'updateUserInfo')->middleware(UserLoggedIn::class)->name('updateUserInfo');
    Route::post('dashboard/account/update-email', 'updateUserEmail')->middleware(UserLoggedIn::class)->name('updateUserEmail');
    Route::post('dashboard/account/update-password', 'updateUserPassword')->middleware(UserLoggedIn::class)->name('updateUserPassword');
});

/*---------------- PRODUCTS -----------------*/

Route::prefix('products')->group(function () {

    Route::get('hardwares', [HardwareController::class, 'siteIndex'])->name('hwSiteIndex');
    Route::get('hardwares/{hardware}', [HardwareController::class, 'siteShow'])->name('hwSiteShow');

    Route::get('softwares', [SoftwareController::class, 'siteIndex'])->name('swSiteIndex');
    Route::get('softwares/{software}', [SoftwareController::class, 'siteShow'])->name('swSiteShow');

    Route::get('services/{service}', [ServiceController::class, 'siteShow'])->name('svSiteShow');

    Route::get('courses', [CourseController::class, 'siteIndex'])->name('crSiteIndex');
    Route::get('courses/{course}', [CourseController::class, 'siteShow'])->name('crSiteShow');
});

/*---------------- ORDERS (USER) -----------------*/

Route::controller(OrderController::class)->middleware(UserLoggedIn::class)->group(function () {

    Route::get('dashboard/orders/new', 'NewOrderForm')->name('newOrderForm');
    Route::post('dashboard/orders/new/submit', 'store')->name('newOrder');

    Route::get('dashboard/orders', 'DisplayAllOrders')->name('displayAllOrders');
    Route::get('dashboard/orders/cancelled', 'DisplayCancelledOrders')->name('displayCancelledOrders'); // FIX: صفحة الطلبات الملغية
    Route::get('dashboard/orders/{order}', 'DisplayOrder')->name('displayOrder');
    Route::get('dashboard/orders/{order}/invoice', 'DisplayInvoice')->name('displayInvoice');

    Route::get('dashboard/orders/{order}/cancel', 'CancelOrder')->name('cancelOrder');

    Route::get('products/{category}/{id}/addProductToList', 'AddProductToList')->name('addProductToList');
    Route::get('orderList/removeItem={listItem}', 'RemoveProductFromList')->name('removeProductFromList');
});

/*---------------- REVIEWS (USER) -----------------*/

Route::controller(ReviewController::class)->middleware(UserLoggedIn::class)->group(function () {

    Route::post('review/new.cat={prod_category}.id={prod_id}', 'Add')->name('addNewReview');
    Route::get('review/{review}', 'Remove')->name('removeReview');
    Route::put('review/{review}', 'Edit')->name('editReview');

    Route::get('dashboard/reviews', 'IndexForUser')->name('indexForUser');
});

/*---------------- TICKETS (USER) -----------------*/

Route::controller(TicketController::class)->middleware(UserLoggedIn::class)->group(function () {

    Route::get('dashboard/tickets/new', 'NewTicketForm')->name('newTicketForm');
    Route::post('dashboard/tickets/new/submit', 'NewTicket')->name('newTicket');

    Route::get('dashboard/tickets/ongoing', 'UserIndexOngoingTickets')->name('userIndexOngoingTickets');
    Route::get('dashboard/tickets/closed', 'UserIndexClosedTickets')->name('userIndexClosedTickets');

    Route::get('dashboard/tickets/{ticket}', 'UserShowTicket')->name('userShowTicket');
    Route::post('dashboard/tickets/{ticket}/send-message', 'UserSendMessage')->name('userSendMessage');
});

Route::get('/dashboard/tickets/{ticket}/messages', [TicketController::class, 'UpdateMessageData'])
    ->middleware(UserLoggedIn::class)
    ->name('updateMessageData');

/*---------------- ADMIN AUTH -----------------*/

Route::prefix('cp')->group(function () {

    Route::get('login', [AdminAuthController::class, 'login'])->name('login');
    Route::post('login', [AdminAuthController::class, 'admLogin'])->name('login-c')->middleware('throttle:5,1'); // FIX: max 5 محاولات في الدقيقة
    Route::get('signout', [AdminAuthController::class, 'signOut'])->name('signout');
});

/*---------------- ADMIN PANEL -----------------*/

Route::prefix('cp')->middleware(AdminAuth::class)->group(function () {

    Route::get('/', [AdminAuthController::class, 'controlPanel'])->name('cp');
    Route::get('profile', [AdminAuthController::class, 'showProfile'])->name('adminProfile');

    Route::resources([
        'hardwares' => HardwareController::class,
        'softwares' => SoftwareController::class,
        'services' => ServiceController::class,
        'courses' => CourseController::class,
    ], ['only' => ['index','store','edit','update','destroy']]);

    Route::resources([
        'accounts/users' => UserController::class,
        'accounts/admins' => AdminController::class,
    ], ['only' => ['index','create','store','edit','update','destroy','show']]);

    // Orders
    Route::get('orders/pending', [OrderController::class, 'indexPendingOrders'])->name('indexPendingOrders');
    Route::get('orders/delivering', [OrderController::class, 'indexDeliveringOrders'])->name('indexDeliveringOrders');
    Route::get('orders/completed', [OrderController::class, 'indexCompletedOrders'])->name('indexCompletedOrders');
    Route::get('orders/archived', [OrderController::class, 'indexArchivedOrders'])->name('indexArchivedOrders');

    Route::get('orders/{order}', [OrderController::class, 'ShowOrder'])->name('showOrder');
    Route::get('orders/change-status/{order}', [OrderController::class, 'changeOrderStatus'])->name('changeOrderStatus');
    Route::get('orders/archive/{order}', [OrderController::class, 'ArchiveOrder'])->name('archiveOrder');
    Route::get('orders/unarchive/{order}', [OrderController::class, 'UnarchiveOrder'])->name('unarchiveOrder');

    Route::post('orders/{order}/add-task', [OrderController::class, 'AddTask'])->name('addTask');
    Route::post('orders/{order}/edit-task/{task}', [OrderController::class, 'EditTask'])->name('editTask');

    // Tickets
    Route::get('tickets/ongoing', [TicketController::class, 'AdminIndexOngoingTickets'])->name('adminIndexOngoingTickets');
    Route::get('tickets/closed', [TicketController::class, 'AdminIndexClosedTickets'])->name('adminIndexClosedTickets');
    Route::get('tickets/archived', [TicketController::class, 'AdminIndexArchivedTickets'])->name('adminIndexArchivedTickets');

    Route::get('tickets/{ticket}', [TicketController::class, 'AdminShowTicket'])->name('adminShowTicket');
    Route::post('tickets/{ticket}/send-message', [TicketController::class, 'AdminSendMessage'])->name('adminSendMessage');
    Route::post('tickets/{ticket}/update-status', [TicketController::class, 'UpdateTicketStatus'])->name('updateTicketStatus');
    Route::get('tickets/{ticket}/archive', [TicketController::class, 'ArchiveTicket'])->name('archiveTicket');
    Route::get('tickets/{ticket}/unarchive', [TicketController::class, 'UnarchiveTicket'])->name('unarchiveTicket'); // FIX: كانت ناقصة

    // Delete images
    Route::delete('hardwares/{hardware}/img/{img}', [HardwareController::class, 'deleteImg'])->name('hwdeleteImg');
    Route::delete('softwares/{software}/img/{img}', [SoftwareController::class, 'deleteImg'])->name('swdeleteImg');
    Route::delete('services/{service}/img/{img}', [ServiceController::class, 'deleteImg'])->name('services.deleteImg');
    Route::delete('courses/{course}/img/{img}', [CourseController::class,'deleteImg'])->name('courses.deleteImg');
});