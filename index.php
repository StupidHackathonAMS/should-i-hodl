<?php
require_once __DIR__ . '/vendor/autoload.php';

$loader = new Twig_Loader_Array([
    'index' =>
        ' 
            <!doctype html>
            <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width initial-scale=1">
                <title>Should I Hodl?</title>
                <link rel="stylesheet" href="style.css">
            </head>
                <body>
                    <div class="should-i-hodl-container">
                        <div class="should-i-hodl__header">
                                   Should I Hodl? 🤔
                            </div>
                        <div class="should-i-hodl-content">
                            <div class="should-i-hodl-content__current">
                                1 Bitcoin is currently worth <u>${{ currentUSValue }}</u>
                            </div>
                            <div class="should-i-hodl-content__yesterday">
                                  Yesterday, 1 Bitcoin was worth <u>${{ yesterdaysValue }}</u> on average, so it {{ balance }} by <u>${{ difference }}</u> <br><br>What does this mean for your personal cryptocurrency portfolio?
                            </div>
                                                      
                        </div>
                           <div class="should-i-hodl-content__holding-status">
                                 👉 {{ shouldHold }}.
                            </div>
                    </div>
                </body>
            </html>
            '
]);

$twig = new Twig_Environment($loader);

$Blockchain = new \Blockchain\Blockchain();

// Determine HODL status
define("SHOULD_HODL", true);

// Get last market price value of 1 Bitcoin in USD
$rates = $Blockchain->Rates->get();
$getUSRates = get_object_vars($rates['USD']);
$currentUSValue = $getUSRates['last'];

// Get yesterday's average value of 1 Bitcoin in USD
$chartName = 'market-price';
$yesterdaysDate = date('Y-m-d',strtotime("-1 days"));

$link = "https://api.blockchain.info/charts/$chartName?&start=$yesterdaysDate";
$getValueObjectProperties = array_shift(get_object_vars(json_decode(file_get_contents($link)))['values']);
$yesterdaysAvgBitCoinValue = get_object_vars($getValueObjectProperties)["y"];

$difference = $currentUSValue - $yesterdaysAvgBitCoinValue;

if ($difference < 0) {
    $balance = 'went down';
} else {
    $balance = 'went up';
}

$shouldHold = '';
if (SHOULD_HODL) {
    $shouldHold = 'YOU SHOULD HOLD';
}

echo $twig->render('index', [
    'currentUSValue' => $currentUSValue,
    'yesterdaysValue' => $yesterdaysAvgBitCoinValue,
    'balance' => $balance,
    'difference' => abs($difference),
    'shouldHold' => $shouldHold,
]);

?>

