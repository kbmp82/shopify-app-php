<?php 
require_once('vendor/autoload.php');
require_once('includes/mysql_connect.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$hmac = $_GET["hmac"];
$shop_url = $_GET['shop']; 
$params = array_diff_key($_GET, array("hmac" => ""));
ksort($params);

$new_hmac = hash_hmac("sha256", http_build_query($params), $_ENV["SECRET_KEY"]);

if(hash_equals($hmac, $new_hmac)){
    $access_token_endpoint = "https://{$shop_url}/admin/oauth/access_token";
    $creds = array(
        "client_id" => $_ENV["API_KEY"],
        "client_secret" => $_ENV["SECRET_KEY"],
        "code" => $_GET["code"]
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $access_token_endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, count($creds));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($creds));
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);
    // echo print_r($response);
    // exit();
   
    $query="INSERT INTO shops (shop_url, access_token, install_date) VALUES ('" . $shop_url . "','" . $response['access_token'] . "', NOW()) ON DUPLICATE KEY UPDATE access_token='" . $response['access_token'] . "'";
    
    if($mysql->query($query)){
        header("Location: https://" . $shop_url . "/admin/apps");
    }else{
        die("error: ". mysqli_connect_error());
    }

   
}else{
    echo "This app is not coming from Shopify!";
}

?>