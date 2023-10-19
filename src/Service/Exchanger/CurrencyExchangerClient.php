<?php

namespace App\Service\Exchanger;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CurrencyExchangerClient
{
    private const CLIENT_URL = 'https://developers.paysera.com/tasks/api/currency-exchange-rates';

    public function getRates(): ?\stdClass
    {
        $client = new Client();

        try {
            $response = $client->request('GET', self::CLIENT_URL);
        } catch (GuzzleException) {
            return null;
        }

        return json_decode($response->getBody())->rates;
    }
}
