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

Route::get('/', function () {
	return view('welcome');
});

Route::view('admin/admin', 'admin.admin');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'TestController@index')->name('test');
Route::get('/test/create', 'TestController@create')->name('testcreate');


// create a resource full route for all the modules 1
Route::resource('/customer', 'CustomerController');
Route::resource('/vendor', 'VendorController');
Route::get('/inwards/create/get-customer-data', 'InwardsController@getCustomerData');
Route::resource('/inwards', 'InwardsController');
Route::get('/outwards/create/get-customer-data', 'OutwardsController@getCustomerData');
Route::resource('/outwards', 'OutwardsController');
Route::get('/quotation/create/get-customer-data', 'QuotationController@getCustomerData');
Route::resource('/quotation', 'QuotationController');
Route::get('/purchase/create/get-customer-data', 'PurchaseController@getCustomerData');
Route::resource('/purchase', 'PurchaseController');
Route::get('/log/create/get-customer-data', 'LogController@getCustomerData');
Route::resource('/log', 'LogController');
Route::resource('/callcomplete', 'CallCompleteController');
Route::resource('/maintainance', 'MaintainanceController');

//-------------------------------------Master-----------------------------------------// 
	// customer routes
	// Route::get('/customer', 'CustomerController@index')->name('customer');
	// Route::get('/customer/create', 'CustomerController@create')->name('customercreate');

	// vendor routes
	// Route::get('/vendor', 'VendorController@index')->name('vendor');
	// Route::get('/vendor/create', 'VendorController@create')->name('vendorcreate');
//-------------------------------------Master-----------------------------------------// 

//-------------------------------------Process-----------------------------------------// 
	// inwards routes
	// Route::get('/inwards', 'InwardsController@index')->name('inwards');
	// Route::get('/inwards/create', 'InwardsController@create')->name('inwardscreate');

	// outwards routes
	// Route::get('/outwards', 'OutwardsController@index')->name('outwards');
	// Route::get('/outwards/create', 'OutwardsController@create')->name('outwardscreate');

	// quotation routes
	// Route::get('/quotation', 'QuotationController@index')->name('quotation');
	// Route::get('/quotation/create', 'QuotationController@create')->name('quotationcreate');

	// purchase order routes
	// Route::get('/purchase', 'PurchaseController@index')->name('purchase');
	// Route::get('/purchase/create', 'PurchaseController@create')->name('purchasecreate');
//-------------------------------------Process-----------------------------------------// 

//-------------------------------------Logs-----------------------------------------// 
	// Logs
	// Route::get('/log', 'LogController@index')->name('log');
	// Route::get('/log/create', 'LogController@create')->name('logcreate');

	// call complete
	// Route::get('/callcomplete', 'CallCompleteController@index')->name('callcomplete');
	// Route::get('/callcomplete/create', 'CallCompleteController@create')->name('callcompletecreate');
//-------------------------------------Logs-----------------------------------------// 

//-------------------------------------Maintainance-----------------------------------------// 
	// Route::get('/maintainance', 'MaintainanceController@index')->name('maintainance');
	// Route::get('/maintainance/create', 'MaintainanceController@create')->name('maintainancecreate');
//-------------------------------------Maintainance-----------------------------------------// 
