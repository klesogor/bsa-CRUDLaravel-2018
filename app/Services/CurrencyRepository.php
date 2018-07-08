<?php

namespace App\Services;


use Illuminate\Support\Facades\Storage;

class CurrencyRepository implements CurrencyRepositoryInterface
{

    private $collection;

    public function __construct()
    {
        if(Storage::exists('AmazingDB')) {
            $this->collection = collect($this->loadFormFile());
        } else {
            $this->collection = collect(CurrencyGenerator::generate());
        }
    }

    public function __destruct()
    {
        $data = [];
        foreach ($this->collection as $item)
            $data[] = CurrencyPresenter::present($item);
        Storage::put('AmazingDB',json_encode($data));
    }

    private function loadFormFile(){
        $collect = [];
        $raw = Storage::get('AmazingDB');
        $builder = new CurrencyBuilder();
        foreach (json_decode($raw,true) as $item){
            $builder->setId($item['id'])
                ->setName($item['name'])
                ->setShortName($item['short_name'])
                ->setCourse($item['actual_course'])
                ->setDate($item['actual_course_date'])
                ->setActive($item['active']);
            $collect[$item['id']] =  $builder->build();
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
        })->values()->toArray();
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