<?php
require_once("includes/mysql_connect.php");
require_once("includes/shopify.php");

/**
 *  CREATE THE SHOPIFY VARIABLE
 * 
 */

$shopify = new Shopify();

require_once("includes/check_token.php");

?>

<?php include_once("components/header.php"); ?>
    <section>
        <div class="columns twelve">
            <div class="card">
                <div class="alert">
                    <dl>
                        <dt>
                            <p>Welcome to Elana!</p>
                        </dt>
                    </dl>
                </div>
            </div>
        </div>
    </section>

<?php include_once("components/footer.php"); ?>