<?php
/**
 *  SET THE APP CREDENTIALS 
 * 
 */

/*use Query and SELECT statement to get the shop information
  if num < 1, then redirect to install.php
*/
 $query="SELECT * FROM shops WHERE shop_url ='". $_GET['shop']. "' LIMIT 1";
 $result = $mysql->query($query) or die($mysql->error);
 
 if($result->num_rows < 1){
    header("Location: install.php?shop=" . $_GET["shop"]);
    exit();
 }
 
 //Use fetch assoc function to get the records
 
 $store_data = $result->fetch_assoc();
 
 //set shopify params
 $shopify->set_url($_GET["shop"]);
 $shopify->set_token($store_data["access_token"]);
 // echo $shopify->get_url();
 // echo "<br>" . $shopify->get_token();

 ?>