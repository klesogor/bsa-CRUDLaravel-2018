<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Services\Currency;
use App\Services\CurrencyBuilder;
use App\Services\CurrencyPresenter;
use App\Services\CurrencyRepositoryInterface;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyRepositoryInterface $repo)
    {
        $result = array_map(
            function($item){
                return CurrencyPresenter::present($item);
            }, $repo->findAll());
        return response($result);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCurrencyRequest $request, CurrencyRepositoryInterface $repo)
    {
        $builder = app()->make(CurrencyBuilder::class);
        $data = $request->validated();
        $currency = $builder->setName($data['name'])
            ->setShortName($data['short_name'])
            ->setCourse($data['actual_course'])
            ->setDate($data['actual_course_date'])
            ->setActive($data['active'])
            ->build();
        $repo->save($currency);
        return response(CurrencyPresenter::present($currency));
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        return response(CurrencyPresenter::present($currency));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurrencyRequest $request, Currency $currency)
    {
        $currency->update($request->validated());
        return response(CurrencyPresenter::present($currency));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency, CurrencyRepositoryInterface $repo)
    {
        $repo->delete($currency);
        return response([
            'message' => "deleted entity",
        ]);
    }
}
