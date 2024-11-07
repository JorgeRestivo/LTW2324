<?php 
    require_once('../database/connection.db.php');
    require_once('../database/products.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/product.tpl.php');
    
    $db = getDatabaseConnection();
    $products = getAllProducts($db);
?>
<?php
    print_header(); ?>
    <section class="shop">
        <?= print_filters(); ?>
        <?= print_products($products, 0); ?>
    </section>
    <?= print_footer();
?>
</body>