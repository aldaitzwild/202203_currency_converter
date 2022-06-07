<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class PriceConvertor 
{
    private HttpClientInterface $httpClient;
    private string $apiKey;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $_ENV['API_KEY'];
    }

    private function convertEuroToCurrency(float $price, string $currency): float
    {
        $arrayResponse = $this->httpClient
                ->request('GET', 'https://v6.exchangerate-api.com/v6/' . $this->apiKey . '/pair/EUR/' . $currency . '/' . $price)
                ->toArray()
        ;

        return $arrayResponse['conversion_result'];
    }

    public function convertEuroToDollar(float $price): float
    {
        return $this->convertEuroToCurrency($price, 'USD');
    }

    public function convertEuroToYen(float $price): float
    {
        return $this->convertEuroToCurrency($price, 'JPY');
    }
}