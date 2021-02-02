<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'WelcomeController@index');
Route::get('/rides', 'RideController@index')->name('rides.index');
Route::get('/rides/{ride}/show', 'RideController@show')->name('rides.show');
Route::post('/post-ride', 'WelcomeController@postRide')->name('post-ride');

Route::get('/contact', 'ContactController@index')->name('contact.index');
Route::post('/contact', 'ContactController@store')->name('contact.store');

Route::resource('drivers', 'DriverController');

Auth::routes(['verify' => true]);

Route::post('newsletter/register', 'NewsletterController@register')->name('newsletter.register');

Route::get('phone/verify', 'Auth\PhoneVerificationController@show')->name('phoneverification.notice');
Route::get('phone/send', 'Auth\PhoneVerificationController@send')->name('phoneverification.send');
Route::post('phone/verify', 'Auth\PhoneVerificationController@verify')->name('phoneverification.verify');
Route::post('phone/send', 'Auth\PhoneVerificationController@verifyPhone')->name('phoneverification.verify-phone');
Route::post('build-twiml/{code}', 'Auth\PhoneVerificationController@buildTwiMl')->name('phoneverification.build');

Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'Auth\SocialController@getSocialRedirect']);
Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'Auth\SocialController@getSocialHandle']);

Route::group(['middleware' => ['verified', 'verifiedphone']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard')->middleware('settings_completed');
    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::post('/settings/role', 'SettingsController@storeRole')->name('settings.store-role');
    Route::get('/settings/info', 'SettingsController@showInfo')->name('settings.show-info');
    Route::post('/settings/info', 'SettingsController@storeInfo')->name('settings.store-info');
    Route::get('/settings/address', 'SettingsController@showAddress')->name('settings.show-address');
    Route::post('/settings/address', 'SettingsController@storeAddress')->name('settings.store-address');
    Route::get('/settings/license', 'SettingsController@showLicense')->name('settings.show-license');
    Route::post('/settings/license', 'SettingsController@storeLicense')->name('settings.store-license');

    Route::post('/settings', 'SettingsController@update')->name('settings.update');

    Route::get('/settings/second', 'SettingsController@showSecond')->name('settings.second');

    Route::get('/settings/password', 'SettingsController@showPasswordForm')->name('settings.password-form');
    Route::post('/settings/password', 'SettingsController@changePassword')->name('settings.change-password');

    Route::group(['middleware' => ['level:1']], function () {
        Route::resource('notifications', 'NotificationController');
        Route::put('/notifications', 'NotificationController@updateAll')->name('notifications.update-all');

        Route::post('/chat/create-user', 'ChatkitController@createUser')->name('chat.create-user');
        Route::post('/chat/send-message', 'ChatkitController@sendMessage')->name('chat.send-message');
        Route::get('/messages', 'ChatkitController@showInbox')->name('chat.inbox');

        Route::get('/rides/{ride}/track', 'RideController@track')->name('rides.track');

        Route::resource('reviews', 'ReviewController');
        Route::resource('bookmarks', 'BookmarkController');

        Route::resource('bids', 'BidController')->only([
            'index', 'create', 'store', 'edit', 'show', 'update', 'destroy'
        ]);

        Route::post('bids/accept', 'BidController@accept')->name('bids.accept');
        Route::post('bids/cancel', 'BidController@cancel')->name('bids.cancel');
        Route::get('bids/{bid}/checkout', 'BidController@checkoutPage')->name('bids.checkout-page');
        Route::post('bids/{bid}/checkout', 'BidController@checkout')->name('bids.checkout');

//    Route::resource('payment-methods', 'PaymentController');

        Route::get('payment-verify', 'StripeController@index')->name('payment-verification.index')->middleware('password.confirm');
        Route::post('payment-verify', 'StripeController@verify')->name('payment-verification.verify');
    });

    Route::group(['middleware' => ['auth', 'level:2', 'settings_completed']], function () {
        Route::resource('rides', 'RideController')->except(['index', 'show']);
    });

    Route::group(['middleware' => ['role:driver']], function () {
        Route::resource('locations', 'DriverLocationController');

        Route::post('/rides/{id}/accept', 'BidController@acceptFromDriver')->name('rides.accept-from-driver');

//        Route::get('/rides/{id}/track', '');
    });

    Route::group(['middleware' => ['role:customer']], function () {
        Route::get('/payments/billing-methods', 'BillingMethodController@index')->name('billing-methods.index');
        Route::post('/payments/billing-methods', 'BillingMethodController@store')->name('billing-methods.store');
    });

    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('users', 'UserController');
        Route::resource('cities', 'CityController');
        Route::resource('deleted-users', 'TrashedUserController');
//    Route::get('/accept/{bid}', 'AcceptController@index')->name('accept-bid');
    });
});
