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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function() {

    Auth::routes(['register' => false]);
    Route::group(['middleware' => ['auth:admin']], function() {

        // Home
        Route::get('/', 'HomeController@index')->name('home');

        // Refrigerator
        Route::group(['prefix' => 'refrigerator', 'as' => 'refrigerator.', 'namespace' => 'Refrigerator'], function () {
            Route::get('/', 'RefrigeratorController@index')->name('index');
            Route::get('/create', 'RefrigeratorController@create')->name('create');
            Route::post('/create', 'RefrigeratorController@store')->name('store');
            Route::get('/edit/{refrigerator}', 'RefrigeratorController@edit')->name('edit');
            Route::put('/edit/{refrigerator}', 'RefrigeratorController@update')->name('update');
            Route::get('/view/{refrigerator}', 'RefrigeratorController@show')->name('show');
            Route::get('/refrigerator-barcode/{refrigerator}/', 'RefrigeratorController@refrigeratorBarcode')->name('refrigerator-barcode');
            Route::get('/rack-barcode/{refrigerator}/', 'RefrigeratorController@rackBarcode')->name('rack-barcode');

        });

        //  Blood Bag
        Route::group(['prefix' => 'blood-bag', 'as' => 'blood-bag.', 'namespace' => 'BloodBag'], function () {
            Route::get('/', 'BloodBagController@index')->name('index');
            Route::get('/create', 'BloodBagController@create')->name('create');
            Route::post('/create', 'BloodBagController@store')->name('store');
            Route::get('/view/{bloodBag}', 'BloodBagController@show')->name('show');
            Route::get('/get-refrigerator-rack/{refrigerator}/', 'BloodBagController@getRefriferatorRack')->name('get-refrigerator-rack');
            Route::get('/get-refrigerator-rack-on-barcode/', 'BloodBagController@scanRefrigeratorBarcode')->name('get-refrigerator-rack-on-barcode');
            Route::get('/check-bag-id/', 'BloodBagController@checkBagName')->name('check-bag-id');
            Route::get('/check-blood-group/', 'BloodBagController@checkBloodGroup')->name('check-blood-group');
            Route::get('/check-product-id/', 'BloodBagController@checkProductId')->name('check-product-id');
            Route::get('/check-bag-expiry-date/', 'BloodBagController@checkExpiryDate')->name('check-expiry-date');
            Route::get('/scan-barcode-out/', 'BloodBagController@scanBarcodeToBloodBagOut')->name('scan-barcode-out');
            Route::get('/scan-barcode-in/', 'BloodBagController@scanBarcodeToBloodBagIn')->name('scan-barcode-in');
            Route::get('/get-details-on-scan-barcode/', 'BloodBagController@getDetailsOnBarcodeScan')->name('get-details-on-scan-barcode');
            Route::post('/scan-barcode-out/', 'BloodBagController@BagScanOut')->name('bag-scan-out');
            Route::post('/scan-barcode-in/', 'BloodBagController@BagScanIn')->name('bag-scan-in');
            Route::get('/history/{bloodBag}', 'BloodBagController@history')->name('history');
            Route::get('/check-bag-details', 'BloodBagController@getBagDetails')->name('check-bag-details');

        });

        // Utilities
        Route::group(['prefix' => 'utility', 'as' => 'utility.', 'namespace' => 'Utility'], function () {
            Route::resource('department', 'DepartmentController');
            Route::resource('wash-method', 'WashMethodController');
            Route::resource('sterilization-method', 'SterilizationMethodController');
            Route::resource('surgical-washer', 'SurgicalWasherController');
            Route::get('/surgical-washer/barcode/{surgicalWasher}/', 'SurgicalWasherController@barcodeView')->name('surgical-washer.barcode');
        });

        //profile
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
