<?php
    require_once(dirname(__DIR__) . '/vendor/autoload.php');

    $loader = new Twig_Loader_Array([
        'index' =>
            ' 
            <!doctype html>
            <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width initial-scale=1">
                <title>Should I Hodl?</title>
                <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            </head>
                <body>
                    <div class="should-i-hodl__content">
                    1 Bitcoin is currently worth ${{ currentUSValue }}.
                    Yesterday, 1 Bitcoin was worth ${{ yesterdaysValue }} on average - so Bitcoin {{ balance }} by ${{ difference }}.
                    This means you {{ shouldHold }}.
                    </div>
                </body>
            </html>
            '
    ]);

    $twig = new Twig_Environment($loader);

    $Blockchain = new \Blockchain\Blockchain();

    // Determine HODL status
    define("SHOULD_HODL", "YOU SHOULD HODL");

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

    echo $twig->render('index', [
            'currentUSValue' => $currentUSValue,
            'yesterdaysValue' => $yesterdaysAvgBitCoinValue,
            'balance' => $balance,
            'difference' => abs($difference),
            'shouldHold' => SHOULD_HODL,
    ]);

?>

