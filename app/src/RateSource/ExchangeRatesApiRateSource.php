<?php

declare(strict_types=1);

namespace CommissionCalculator\RateSource;

class ExchangeRatesApiRateSource implements RateSourceInterface
{
    const BASE_URL = "https://api.exchangeratesapi.io/latest";

    public function getRates(): array
    {
        $params = [
            'access_key' => $_ENV['EXCHANGE_RATES_ACCESS_KEY'],
            'symbols' => implode(',', [
                'USD',
                'JPY',
                'EUR'
            ])
        ];
        $url = self::BASE_URL . '?' . http_build_query($params);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        $response = curl_exec($ch);

        if ($error = curl_error($ch)) {
            echo $error;
        }

        $decodedData = json_decode($response, true);

        curl_close($ch);

        return $decodedData['rates'];
    }
}