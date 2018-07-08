<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!

*/

Route::prefix('/currencies')->group(
    function(){
        Route::get('/',function(){
            $repo = App::make(\App\Services\CurrencyRepositoryInterface::class);
            return response($repo->findActive());
        });
        Route::get('/{currencie}',function(\App\Services\Currency $currency){ //used currencie for route-model binding
           return  response($currency->serialize());
        })->where('currencie','[0-9]+');
    }
);

Route::group(['prefix' => '/admin'],function(){
   Route::any('/',function(){})->middleware('redirectCurrencies');
   Route::apiResource('currencies', 'CurrencyController');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
