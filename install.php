<?php
require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$REDIRECT_URI=urlencode($_ENV["NGROK_URL"] . "/elana/token.php");
$NONCE = bin2hex( random_bytes(12) );
$SHOP = $_GET["shop"];

$oauth_url = "https://{$SHOP}/admin/oauth/authorize?client_id={$_ENV["API_KEY"]}&scope={$_ENV["SCOPES"]}&redirect_uri={$REDIRECT_URI}&state={$NONCE}&grant_options[]={$_ENV["ACCESS_MODE"]}";

header("Location:" . $oauth_url);
exit();
?>