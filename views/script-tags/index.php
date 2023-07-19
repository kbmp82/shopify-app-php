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

 $script_tags = $shopify->rest_api("/admin/api/2023-07/script_tags.json", array(), "GET");

 $response = json_decode($script_tags["body"], true);

 echo print_r($response);

?>