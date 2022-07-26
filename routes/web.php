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



Auth::routes();
Route::group( ['middleware' => 'auth'], function()
{
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/','HomeController@index')->name('home');



    //Employee
    Route::get('employees','EmployeeController@view_employees');
    Route::get('generate-employees','EmployeeController@generate_employees');

    //ChangeRole
    Route::post('change-role','UserController@changeRole');

    //Inventories
    Route::get('inventories','InventoryController@inventories');
    Route::post('new-item','InventoryController@new_item');


    //Request
    Route::get('requests','RequestController@requests');
    Route::post('new-requests','RequestController@newRequest');

    //Deliveries
    Route::get('deliveries','DeliveryController@deliveries');
    Route::post('new-stock','DeliveryController@newStock');

});

