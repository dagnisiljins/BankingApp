<?php

namespace App\Console\Commands;

use App\Models\Crypto;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchCryptoCommand extends Command
{
    protected $signature = 'crypto:fetch';
    protected $description = 'Fetch crypto rates';
    private const BASE_CRYPTO = [
        'BTC',
        'ETH',
        'LTC'
        ];

    public function handle()
    {
        $client = new Client();

        foreach (self::BASE_CRYPTO as $crypto) {
            $response = $client->get('https://api.coinbase.com/v2/exchange-rates?currency=' . $crypto);
            $data = json_decode($response->getBody()->getContents());

            if (!isset($data->data->rates)) {
                $this->error('Failed to fetch rates for ' . $crypto);
                continue;
            }

            $rates = $data->data->rates;
            $eurRate = $rates->EUR ?? null;
            $usdRate = $rates->USD ?? null;
            $gbpRate = $rates->GBP ?? null;

            if ($eurRate && $usdRate && $gbpRate) {
                Crypto::updateOrCreate(
                    ['crypto_symbol' => $crypto],
                    [
                        'EUR' => $eurRate,
                        'USD' => $usdRate,
                        'GBP' => $gbpRate,
                    ]
                );
            } else {
                $this->error('Missing rates for ' . $crypto);
            }
        }

        $this->info('Crypto rates updated successfully.');
        return 0;
    }
}
