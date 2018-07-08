<?php

namespace App\Http\Controllers\Admin;

use App\Services\Currency;
use App\Services\CurrencyRepositoryInterface;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repo = App::make(CurrencyRepositoryInterface::class);
        return response($repo->findAll());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        return response($currency->serialize());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        $repo = App::make(CurrencyRepositoryInterface::class);
        $repo->delete($currency);
        return response([
            'message' => "deleted entity",
        ]);
    }
}
