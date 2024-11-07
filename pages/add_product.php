<?php 
    require_once('../database/connection.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/product.tpl.php');

    $db = getDatabaseConnection(); 
    $user_id = $_GET['id'];    
?>

<?php
    print_header(); ?>
    <section class="add-product">
        <?= print_add_product_form($db, $user_id); ?>
    </section>
<?= print_footer(); ?>