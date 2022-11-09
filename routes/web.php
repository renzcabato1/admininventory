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

    // Route::group( ['middleware' => 'admin'], function()
    // {
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

            //Deliveries
            Route::get('deliveries','DeliveryController@deliveries');
            Route::post('new-stock','DeliveryController@newStock');

            //for deployments
            Route::get('for-deployments','RequestController@for_deployments');
            Route::post('deployed-item','RequestController@deployed_item');
            // });






    //Request
    Route::get('requests','RequestController@requests');
    Route::post('new-requests','RequestController@newRequest');
    Route::post('cancel-request','RequestController@cancelRequest');

    Route::post('declined-request','RequestController@declinedRequest');
    Route::post('approved-request','RequestController@approvedRequest');
    Route::get('for-approval','RequestController@for_approval');

    

});

