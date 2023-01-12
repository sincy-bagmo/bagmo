<?php
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'user', 'namespace' => 'User','as' => 'user.'], function() {

    // User Dashboard pages
    Auth::routes(['register' => false]);

    Route::group(['middleware' => ['auth:user']], function() {

        // Home
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/calendar/events/', 'HomeController@getEvents')->name('calendar.get-events');

        // Orders
        Route::group(['prefix' => 'order', 'as' => 'order.', 'namespace' => 'Order'], function () {
            // Analytics
            Route::get('/', 'AnalyticsController@index')->name('index');

            // Pending Orders
            Route::resource('pending-order', 'PendingOrderController');
            Route::get('operation-details/{operations}/', 'PendingOrderController@getOperationTraysDetailsWithInstruments')->name('operation.get-tray-details');
            Route::get('surgery-details/{operations}/', 'PendingOrderController@getSurgeryTraysDetailsWithInstruments')->name('operation.get-tray-category-details');
            Route::get('tray-categories/{trayCategory}/', 'PendingOrderController@geTraysDetailsWithInstruments')->name('get-tray-category-details');
            Route::get('tray-details/{trayCategory}/', 'PendingOrderController@geTraysDetailsWithInstrumentsInOperation')->name('get-tray-details');
            Route::get('{orders}/additional-trays-details/{operation}/', 'PendingOrderController@geTraysDetailsWithInstrumentsInOrder')->name('get-additional-tray-details');
            Route::get('instrument-details/{categories}/', 'PendingOrderController@geInstrumentDetails')->name('get-instrument-details');
            Route::get('/print-tray-barcode/{tray}/{orders}', 'PendingOrderController@trayBarcode')->name('tray-barcode');
            Route::get('/print-order-barcode/{orders}', 'PendingOrderController@orderBarcode')->name('order-barcode');

            // Issued Orders
            Route::get('issued-order/', 'IssuedOrderController@index')->name('issued-order.index');
            Route::get('view/{orders}/', 'IssuedOrderController@show')->name('issued-order.show');
            Route::get('order-details/{orders}/', 'IssuedOrderController@orderDetailsView')->name('issued-order.details');
            Route::post('return-order/{orders?}/', 'IssuedOrderController@orderReturn')->name('issued-order.return');
       


            // Returned Orders
            Route::get('returned-order/', 'ReturnedOrderController@index')->name('returned-order.index');
            Route::get('missing-instruments/{orders}', 'IssuedOrderController@missingInstruments')->name('issued-order.missing-instruments');
            Route::get('damaged-instruments/{orders}', 'IssuedOrderController@damagedInstruments')->name('issued-order.damaged-instruments');

        });

        //Profile
        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('/', 'ProfileController@index')->name('index');
            Route::put('/update', 'ProfileController@update')->name('update');
            Route::get('/change-password', 'ProfileController@viewChangePassword')->name('change-password');
            Route::put('/update-password', 'ProfileController@updatePassword')->name('update-password');
            Route::put('/update-image', 'ProfileController@updateImage')->name('update-image');
            Route::get('/recent-login', 'ProfileController@viewRecentLogin')->name('recent-login');
        });

    });
});
