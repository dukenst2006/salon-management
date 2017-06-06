<?php

use Illuminate\Http\Request;
use Salon\Square\Square;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::put('/technician-sale/change', 'TechnicianSaleApiController@changeSale');
Route::get('/technician-sale/search', 'TechnicianSaleController@searchByDate');

Route::get('/pay-period/current', 'PayPeriodApiController@current');

Route::get('/technician-sale/all/', 'TechnicianSaleApiController@searchSaleByDate');
Route::post('/salon-sale/store/','SalonSaleApiController@createSale');

Route::get('/salon/square-sale','SalonSaleApiController@getSquareSale')->middleware('auth:api');


Route::get('/salon/tech-sale','SalonSaleApiController@getTechSale')->middleware('auth:api');

/*Test API*/
Route::get('/salon/square-test/metric', function(){
    $dailySale = Square::getDailySaleMetrics();

    return response()->json($dailySale);
})->middleware('auth:api');
Route::get('/salon/square-test/raw-payments', function(){

    $beginDate =  \Carbon\Carbon::now()->startOfDay();
    $newDate = clone $beginDate;

    $endDate=  $newDate->addDay();
    $dates = http_build_query(['begin_time' => $beginDate->toIso8601String(),
        'end_time' => $endDate->toIso8601String()]);
    $payments = Square::getRawPayments($dates);

    return response()->json($payments);
})->middleware('auth:api');