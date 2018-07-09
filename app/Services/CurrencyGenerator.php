<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CurrencyGenerator
{
    public static function generate(): array
    {
        $client = new Client();
        $data = $client->get('https://api.coinmarketcap.com/v2/ticker/', [
            'query' => [
                'limit' => 10
            ]
        ])->getBody();

        $data = (json_decode($data,true))['data'];
        $currencies = [];
        $builder = app()->make(CurrencyBuilder::class);
        foreach ($data as $result){
            $builder->setName($result['name'])
                ->setShortName($result['symbol'])
                ->setCourse($result['quotes']['USD']['price'])
                ->setDateTimestamp($result['last_updated'])
                ->setActive(true);
            $item = $builder->build();
            $currencies[$item->getId()] = $item;
        }
        return $currencies;

    }
}