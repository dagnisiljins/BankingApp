<?php

namespace App\Console\Commands;

use App\Models\Currency;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchCurrencyCommand extends Command
{

    protected $signature = 'currencies:fetch';//lai palaistu komandu, terminālī jāpalaiž: php artisan currencies:fetch


    protected $description = 'Fetch all currency rates';
    private const BASE_CURRENCY = 'EUR';
    private array $validCurrencies = [
        'EUR',
        'GBP',
        'USD',
    ];


    public function handle()
    {
        $client = new Client();

        $response = $client->get('https://api.coinbase.com/v2/exchange-rates?currency=' . self::BASE_CURRENCY);

        $response = json_decode($response->getBody()->getContents());

        foreach ($response->data->rates as $symbol => $rate) {
            if ( ! in_array($symbol, $this->validCurrencies)) {
                continue;
            }

            Currency::updateOrCreate([
                'symbol' => $symbol,
            ], [
                'rate' => $rate,
            ]);
        }

        $this->info('Currency rates updated successfully.');
        return 0;
    }
}
