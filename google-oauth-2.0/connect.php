<?php
require 'config.php';
require './vendor/autoload.php';
session_start();

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

$client = new Client([
    'timeout'  => 2.0,
]);
if (!isset($_SESSION['access_token'])) {
    $response = $client->request('POST', 'https://oauth2.googleapis.com/token', [
        'form_params' => [
            'code' => $_GET['code'],
            'client_id' => GOOGLE_ID,
            'client_secret' => GOOGLE_SECRET,
            'redirect_uri' => 'http://localhost/google-oauth-2.0/connect.php',
            'grant_type' => 'authorization_code'
        ]
    ]);

    $access_token = json_decode($response->getBody())->access_token;
    $_SESSION['access_token'] = $access_token;
}
try {
    $response = $client->request('GET', 'https://openidconnect.googleapis.com/v1/userinfo', [
        'headers' => [
            'Authorization' => 'Bearer ' . $_SESSION['access_token']
        ]
    ]);

    $_SESSION['email'] = json_decode($response->getBody())->email;
    header('Location: secret.php');
    exit;
} catch (ClientException $exception) {
    dd($exception->getMessage());
}
