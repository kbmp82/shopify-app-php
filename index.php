<?php
require_once("includes/mysql_connect.php");
require_once("includes/shopify.php");

/*use Query and SELECT statement to get the shop information
  if num < 1, then redirect to install.php
*/
$shopify = new Shopify();

$query="SELECT * FROM shops WHERE shop_url ='". $_GET['shop']. "' LIMIT 1";
$result = $mysql->query($query) or die($mysql->error);

function installApp(){
    header("Location: install.php?shop=" . $_GET["shop"]);
    exit();
}

if($result->num_rows < 1){
   installApp();
}

//Use fetch assoc function to get the records

$store_data = $result->fetch_assoc();

//set shopify params
$shopify->set_url($_GET["shop"]);
$shopify->set_token($store_data["access_token"]);
echo $shopify->get_url();
echo "<br>" . $shopify->get_token();

$products = $shopify->rest_api("/admin/api/2023-07/products.json", array(), "GET");

echo print_r($products["body"]);

$response = json_decode($products["body"], true);
if(array_key_exists("errors",$response)){
    installApp();
}
?>