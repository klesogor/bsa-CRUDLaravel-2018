<?php

namespace App\Services;


use Illuminate\Support\Facades\Storage;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    
    private $collection;

    public function __construct()
    {
        //force load data from api
        $this->collection = collect(CurrencyGenerator::generate());
        /*
        if(Storage::exists('AmazingDB')) {
            $this->collection = collect($this->loadFormFile());
        } else {
            $this->collection = collect(CurrencyGenerator::generate());
        }
        */
    }

    /*  This  was my little implementation of storage. It worked fine, but it crashed tests
        so I had to comment it. Feel free to uncomment, when you assert, that all tests are green
    
    
    public function __destruct()
    {
        $data = [];
        foreach ($this->collection as $item)
            $data[] = CurrencyPresenter::present($item);
        Storage::put('AmazingDB',json_encode($data));
    }
    */

    private function loadFormFile(){
        $collect = [];
        $raw = Storage::get('AmazingDB');
        $builder = app()->make(CurrencyBuilder::class);
        foreach (json_decode($raw,true) as $item){
            $builder->setName($item['name'])
                ->setShortName($item['short_name'])
                ->setCourse($item['actual_course'])
                ->setDate($item['actual_course_date'])
                ->setActive($item['active']);
            $item = $builder->build();
            $collect[$item->getId()] = $item;  
        }
        return $collect;
    }

    public function findAll(): array
    {
        return $this->collection->values()->all();
    }

    public function findActive(): array
    {
        return $this->collection->reject(function ($item,$key){
            return !$item->isActive();
        })
        ->values()
        ->toArray();
    }

    public function findById(int $id): ?Currency
    {
        return $this->collection->get($id);
    }

    public function save(Currency $currency): void
    {
        $this->collection->put($currency->getId(),$currency);
    }

    public function delete(Currency $currency): void
    {
        $this->collection->forget($currency->getId());
    }
}