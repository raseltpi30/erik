<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminSubscriptionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SubscribeController;
use App\Http\Controllers\frontend\CommercialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PlaceController;
use Illuminate\Support\Facades\Artisan;

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

Route::group(['namespace' => 'App\Http\Controllers\frontend'], function () {
    Route::get('/', 'IndexController@index')->name('home');
    Route::get('/check','IndexController@checkApiKey');
    Route::get('/book-now', 'PagesController@booking')->name('book-now');
    Route::get('/contact', 'PagesController@contact')->name('contact');
    Route::get('/services', 'PagesController@services')->name('services');
    Route::get('/faq', 'PagesController@faq')->name('faq');
    Route::get('/commercialquotes', 'PagesController@quotes')->name('quotes');
    Route::get('/terms-and-condition', 'PagesController@condition')->name('condition');
    Route::get('/booking-confirmation', 'PagesController@bookingThanks')->name('booking.thanks');
    Route::get('/contact-confirmation', 'PagesController@contactThanks')->name('contact.thanks');
    Route::get('/commercialquotes-confirmation', 'PagesController@qouteThanks')->name('qoute.thanks');
    Route::get('/subscription-confirmation', 'PagesController@subscribeThanks')->name('subscribe.thanks');
    Route::post('/subscribe', 'IndexController@subscribe')->name('subscribe');

    Route::post('/booking/store', 'BookingController@store')->name('booking.store');
    Route::get('/success', 'BookingController@success')->name('payment.success');
    Route::get('/cancel', 'BookingController@cancel')->name('payment.cancel');
    Route::get('/payment-canceled', 'BookingController@paymentCanceled')->name('payment.canceled');
    Route::get('/check-email/{email}', 'BookingController@checkEmail');
    // Route::get('/cancel', 'BookingController@cancel')->name('payment.succe');

    Route::post('/quotes-store', 'CommercialController@store')->name('qoutes.store');

    Route::redirect('/commercialquote', '/commercialquotes', 301);

    // for services

    Route::get('/general-cleaning', 'ServiceController@generalCleaning')->name('general.cleaning');
    Route::get('/deep-cleaning', 'ServiceController@deepCleaning')->name('deep.cleaning');
    Route::get('/office-cleaning', 'ServiceController@officeCleaning')->name('office.cleaning');
    Route::get('/end-less-cleaning', 'ServiceController@endLessCleaning')->name('end.cleaning');
    Route::get('organization-hour-cleaning','ServiceController@organizationHourCleaning')->name('organization.cleaning');
    Route::get('commercial-cleaning','ServiceController@commercialCleaning')->name('commercial.cleaning');

});

Route::post('/custom-coupon', [CouponController::class, 'customCoupon'])->name('custom.coupon');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
// Password Reset Routes
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::group(['namespace' => 'App\Http\Controllers\Admin','prefix' => 'admin','middleware' => 'auth'], function () {
    Route::get('/home',[HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('/customers',[CustomerController::class, 'index'])->name('customer');
    Route::get('/customer/details/{id}',[CustomerController::class, 'customerDetails'])->name('customer.details');
    Route::get('/customer/edit/{id}',[CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('/customer/update/{id}',[CustomerController::class, 'update'])->name('customer.update');
    Route::get('/customer/delete/{id}',[CustomerController::class, 'destroy'])->name('customer.delete');

    // for password change

    Route::get('/password/change',[AdminController::class,'passwordChange'])->name('admin.password.change');
    Route::post('/password/update',[AdminController::class,'passwordUpdate'])->name('admin.password.update');
    // for contact show
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/contact/delete/{id}', [ContactController::class, 'destroy'])->name('contact.delete');

    Route::get('/commercial', [ContactController::class, 'commercial'])->name('commercial.index');
    Route::get('/commercial/details/{id}',[ContactController::class, 'commercialDetails'])->name('commercial.details');
    Route::get('/commercial/delete/{id}',[ContactController::class, 'destroyCommercial'])->name('commercial.delete');

    // Route for subscribe

    Route::get('/subscribe', [SubscribeController::class, 'index'])->name('subscribe.index');
    Route::get('/subscribe/delete/{id}', [SubscribeController::class, 'destroy'])->name('subscribe.delete');
});

Route::get('/place-autocomplete', [PlaceController::class, 'autocomplete'])->name('place.autocomplete');
Route::get('/place-details', [PlaceController::class, 'details'])->name('place.details');

// for stripe
// Admin routes for managing subscriptions
Route::get('/admin/subscriptions', [AdminSubscriptionController::class, 'index'])->name('admin.subscriptions.index');
Route::get('/admin/subscriptions/{id}', [AdminSubscriptionController::class, 'show'])->name('admin.subscriptions.show');
Route::post('/admin/subscriptions/{id}/update', [AdminSubscriptionController::class, 'update'])->name('admin.subscriptions.update');
Route::post('/admin/subscriptions/{id}/cancel', [AdminSubscriptionController::class, 'cancel'])->name('admin.subscriptions.cancel');
 Route::get('/config-cache', function() {
     $exitCode = Artisan::call('config:cache');
     return 'Config cache cleared';
 });
 Route::get('/route-cache', function() {
     $exitCode = Artisan::call('route:cache');
     return 'Routes cache cleared';
 });
Route::get('/clear-cache', function() {
     $exitCode = Artisan::call('cache:clear');
     return 'Application cache cleared';
 });
 Route::get('/view-clear', function() {
     $exitCode = Artisan::call('optimize:clear');
     return 'View cache cleared';
 });
Auth::routes();
