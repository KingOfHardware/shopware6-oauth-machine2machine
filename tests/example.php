<?php

use GuzzleHttp\Exception\GuzzleException;
use Kingofhardware\ShopwareAuthentication;

// include put env config
require_once ('../config/config.php');
require_once ('../vendor/autoload.php');

// new object
$auth = new ShopwareAuthentication();

// this override the put env setting
//$auth->setShopUrl('add_your_data');
//$auth->setClientId('add_your_data');
//$auth->setClientSecret('add_your_data');

// build token send request to shopware store end get the token from it
try {
    $auth->buildToken();
} catch (GuzzleException|Exception $e) {
}


// here you can get the token
// echo $auth->getToken();


// use with guzzle http the
/*$endpoint = '/api/_action/sync';


$response = $this->client->post('https://'.$this->getShopUrl().$endpoint, [
    'headers' => [
        'Authorization'     => $auth->getTokenType().' '.$auth->getToken(),
        'Content-Type'      => 'application/json',
        'fail-on-error'     => 0,
        'indexing-behavior' => 'use-queue-indexing',
        'single-operation'  => 0,

    ],
    'body'    => '[{
                            "entity": "product",
                            "action": "upsert",
                            "payload": '.$payload.'
                                               
                                                }]',
]);*/