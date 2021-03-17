<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BitcoinController extends Controller
{
    /**
    * Create a new BitcoinController instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function __invoke()
    {
        $response = Http::get('https://www.mercadobitcoin.net/api/BTC/ticker');

        if ($response->getStatusCode() == 200) {
            $response = json_decode($response, true);

            return response()->json(['sell' => $response['ticker']['sell'], 'buy' => $response['ticker']['buy']]);
        }
    }
}
