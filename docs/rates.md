Exchange Rates Documentation
============================

Official documentation on the [Blockchain Exchange Rates API page](https://blockchain.info/api/exchange_rates_api).

```php
$Blockchain = new \Blockchain\Blockchain($api_code);

// Make calls on the $Blockchain->Rates object
```

Convert Fiat Amount to Bitcoin
------------------------------
Get the amount of Bitcoin that could be purchased for a given fiat amount. Returns a `float`.

```php
$btc_amount = $Blockchain->Rates->toBTC(500, 'USD');
```

Convert Bitcoin to Fiat Currency
--------------------------------
Get the amount of a given fiat currency for a given bitcoin amount (in satoshi). Returns a `float`.

```php
/*
* Optional param:
* $symbol - the fiat currency to convert to ('USD' by default)
*/
$one_btc_in_usd = $Blockchain->Rates->fromBTC(100000000);
```

Get Rates
---------
Get a set of exchange rate tickers for various currencies. Returns an associative array with the currency code for keys and `Ticker` objects for values.

```php
$rates = $Blockchain->Rates->get();

// $rates array has currency code for keys
foreach($rates as $cur=>$ticker) { ... }
```

Response Object Properties
--------------------------

### Ticker

```php
class Ticker {
    public $m15;                                // float
    public $last;                               // float
    public $buy;                                // float
    public $sell;                               // float
    public $cur;                                // string
    public $symbol;                             // string
}
```