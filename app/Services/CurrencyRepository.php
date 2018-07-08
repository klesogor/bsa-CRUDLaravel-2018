<?php

namespace App\Services;


use Illuminate\Support\Facades\Storage;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function __construct()
    {
        $collect = [];
        if(Storage::exists('AmazingDB')){
            $raw = Storage::get('AmazingDB');
            foreach (json_decode($raw,true) as $item){
                $collect[] = new Currency($item['id'],
                    $item['id'],
                    $item['name'],
                    $item['short_name'],
                    $item['actual_course'],
                    $item['actual_course_date'],
                    $item['active']
                    );
            }
            $this->collection = collect($collect);
        } else {
            $this->collection = collect(CurrencyGenerator::generate());
        }
    }

    public function __destruct()
    {
        $data = '';
        foreach ($this->collection as $item)
            $data .= json_encode($item->serialize());
        Storage::put('AmazingDB',$data);
    }

    private $collection;

    public function findAll(): array
    {
        return $this->collection->all();
    }

    public function findActive(): array
    {
        $this->collection->get(function ($item){
            return $item->isActive();
        });
    }

    public function findById(int $id): ?Currency
    {
        return $this->collection->first(function ($item) use ($id){
            return $item->getId === $id;
        });
    }

    public function save(Currency $currency): void
    {
        $this->collection->push($currency);
    }

    public function delete(Currency $currency): void
    {
        $this->collection = $this->collection->reject(function($item) use ($currency){
            return $item->getId() === $currency->getId();
        });
    }
}