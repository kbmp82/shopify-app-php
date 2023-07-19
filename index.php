<?php
require_once("includes/mysql_connect.php");
require_once("includes/shopify.php");

/**
 *  CREATE THE SHOPIFY VARIABLE
 * 
 */

$shopify = new Shopify();

require_once("includes/check_token.php");

echo "homepage";
?>