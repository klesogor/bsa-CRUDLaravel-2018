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
        foreach ($data as $result){
            $currencies[] = new Currency(
                $id,
                $result['name'],
                strtolower($result['symbol']),
                $result['quotes']['USD']['price'],
                date('Y-m-d H-i-s',1525137271),
                true
            );
        }
        return $currencies;

    }
}