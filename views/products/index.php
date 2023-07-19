<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/elana/includes/mysql_connect.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/elana/includes/shopify.php");

/**
 *  CREATE THE SHOPIFY VARIABLE
 * 
 */

$shopify = new Shopify();

require_once($_SERVER['DOCUMENT_ROOT'] . "/elana/includes/check_token.php");

/**
 *  RETRIEVE SHOPIFY PRODUCTS
 * 
 */

 $products = $shopify->rest_api("/admin/api/2023-07/products.json", array(), "GET");

 $response = json_decode($products["body"], true);

 echo print_r($response);

?>