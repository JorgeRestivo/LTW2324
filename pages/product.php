<?php 
    require_once('../database/connection.db.php');
    require_once('../database/products.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/product.tpl.php');
    require_once('../database/images.db.php');
    
    $db = getDatabaseConnection();
    $id = $_GET['id'];
    $imgs = getProductImages($db, $id);
    $info = getProductInfo($db, $id);
    $products = getProductsByCategory($db, $info['category'], $id);
    $sellerID = getSellerID($db, $id); // Assuming you have a function named getSellerID to fetch sellerID

?>
    <?php
        print_header();
        print_product_page($info, $imgs, $products, $sellerID);
        print_footer();
    ?>
</body>