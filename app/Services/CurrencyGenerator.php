<?php

namespace App\Services;

use GuzzleHttp\Client;

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
        $id = 1;
        $builder = new CurrencyBuilder();
        foreach ($data as $result){
            $builder->setId($id)
                ->setName($result['name'])
                ->setShortName($result['symbol'])
                ->setCourse($result['quote']['USD']['price'])
                ->setDateTimestamp($result['last_changed'])
                ->setActive(true);
            $currencies['id'] = $builder->build();
            $id++;
        }
        return $currencies;

    }
}