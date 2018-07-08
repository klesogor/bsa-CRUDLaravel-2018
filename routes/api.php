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
            $result = array_map(function($currency){
                return \App\Services\CurrencyPresenter::present($currency);
            },$repo->findActive());
            return response($result);
        });

        Route::get('/{currency}',function(\App\Services\Currency $currency){ //used currencie for route-model binding
           return  response(\App\Services\CurrencyPresenter::present($currency));
        })->where('currency','[0-9]+');
    }
);

Route::group(['prefix' => '/admin'],function(){

   Route::any('/',function(){})->middleware('redirectCurrencies');

   Route::apiResource('currencies', 'Admin\CurrencyController');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
