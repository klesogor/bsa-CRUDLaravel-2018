<?php

namespace App\Services;


use Illuminate\Support\Facades\Storage;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function __construct()
    {
        $collect = [];
        if(Storage::exists('AmazingDB')) {
            $raw = Storage::get('AmazingDB');
            foreach (json_decode($raw,true) as $item){
                $collect[$item['id']] = new Currency($item['id'],
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
        return $this->collection->get($id);
    }

    public function save(Currency $currency): void
    {
        if($this->collection->has($currency->getId())){
            throw new \RuntimeException('Currency with given id already exists!');
        }
        $this->collection->put($currency->getId(),$currency);
    }

    public function delete(Currency $currency): void
    {
        $this->collection->forget($currency->getId());
    }
}