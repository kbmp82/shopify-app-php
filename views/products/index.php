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

$response = $shopify->rest_api("/admin/api/2023-07/products.json", array("status" => "active"), "GET");

$products = json_decode($response["body"], true);

//echo print_r($products);

?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/elana/components/header.php"); ?>
<section>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th colspan="2">Product</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($products as $product) {

                    foreach ($product as $key => $value) {
                        $image = count($value['images']) > 0 ? $value['images'][0]["src"] : "";
                        ?>
                        <tr>
                            <td colspan="2"><img height="75" width="75" src="<?php echo $image; ?>" /></td>
                            <td>
                                <?php echo $value["title"]; ?>
                            </td>
                            <td>
                                <?php echo $value["status"]; ?>
                            </td>
                            <td>
                               <button class="secondary icon-trash"></button>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</section>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/elana/components/footer.php"); ?>