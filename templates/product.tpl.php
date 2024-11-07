<?php 
    require_once('../templates/user.tpl.php');
    require_once('../templates/images.tpl.php');
?>
<?php function print_product($product) { ?>
    <div class="product">
        <img src="../database/userImages/<?= $product['imagePath']; ?>" alt="<?= $product['title']; ?>">
        <h2><?= $product['title']; ?></h2>
        <p><?= $product['price']; ?></p>
        <p><?= $product['description']; ?></p>
    </div>
<?php } ?>

<?php function print_product_preview($product) { 
    $price = (double) $product['price']/100; ?>
    
        <div class="product-preview" category="<?= $product['categoryName'] ?>" price="<?= $price; ?>" condition="<?= $product['condition'] ?>">
            <img src="../database/userImages/<?= $product['imagePath']; ?>" alt="<?= $product['title']; ?>" width="100%" height="75%">
            <div>    
                <a href="product.php?id=<?= $product['productID'] ?>">    
                    <h3 class="title"><?= $product['title']; ?></h3>
                    <p class="price"><?= $price; ?>€</p>
                    <p class="category"><?= $product['categoryName']; ?></p>
                    <p class="condition"><?= $product['condition']; ?></p>
                </a>
            </div>
        </div>
<?php } ?>

<?php function print_user_products($products) { ?>
    <div class="user-products">
        <?php foreach ($products as $product) { ?>
            <?php print_product_preview($product); ?>
        <?php } ?>
    </div>
<?php } ?>

<?php function print_products($products, $n) {
    if($n != 0)
        $products = array_slice($products, 0, min($n, count($products)-1)); ?> 

    <div class="product-list">
        <?php foreach ($products as $product) {
            print_product_preview($product);
        } ?>
    </div>
<?php } ?>

<?php function print_product_page($info, $imgs, $products, $sellerID) { 
    $price = (double) $info['price']/100; ?>
    <div class="product-page">
        <?= print_img_slider($imgs, $info['imagePath']); ?>
        <div class="description">
            <h2>Description</h2>
            <p><?= $info['description']; ?></p>
        </div>
        <div class="product-data">
            <div class="info">
                <h2><?= $info['title']; ?></h2>
                <p class="price"><?= $price; ?>€</p>
                <div class="category">
                    <?php foreach ($info['hashtags'] as $hashtag) { ?>
                        <span><?= $hashtag ?></span> 
                    <?php } ?>
                </div>
            </div>
            <?= print_user_card($info); ?>
        </div>
        <div class="chat-button">
            <a href="chat.php?productID=<?= $info['productID'] ?>&sellerID=<?= $sellerID ?>" class="button">Message Seller</a>
        </div>
        <?= print_products($products, 6); ?>
    </div>
<?php } ?>

<?php function print_add_product_form($db, $user_id) { ?>
    <form action="../database/action_add_product.php" method="post" enctype="multipart/form-data">

        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>

        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" id="price" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="10" cols="100" required></textarea>
        
        <label for="condition">Condition:</label>
        <select name="condition" id="condition" required>
            <option value="">Select condition</option>
            <option value="Novo">New</option>
            <option value="Com marcas de uso">Very Good</option>
            <option value="Usado">Used</option>
        </select>

        <label for="category">Category:</label>
        <select name="category" id="category" required>
            <option value="">Select category</option>
            <option value="1">Electronics</option>
            <option value="2">Books</option>
            <option value="3">Furniture</option>
            <option value="4">Clothing</option>
            <option value="5">Other</option>
        </select>
        
        <label for="image">Image:</label>
        <input type="file" name="image" id="image" required>
        
        <input type="submit" value="Add Product">
    </form>
<?php } ?>

<?php function print_filters() { ?>
    <aside>
        <h2>Filters</h2>
        <form id="filters">
            <label for="category">Category:</label>
            <select name="category" id="category">
                <option value="all">All</option>
                <option value="Clothing">Clothing</option>
                <option value="Electronics">Electronics</option>
                <option value="Furniture">Furniture</option>
                <option value="Books">Books</option>
                <option value="Other">Other</option>
            </select>
            <label for="min-price">Price:</label>
            <input type="number" name="min-price" id="min-price" placeholder="From">
            <label for="max-price"></label>
            <input type="number" name="max-price" id="max-price" placeholder="To">
            <label for="condition">Condition:</label>
            <select name="condition" id="condition">
                <option value="all">All</option>
                <option value="Novo">New</option>
                <option value="Com marcas de uso">Very Good</option>
                <option value="Usado">Used</option>
            </select>
            <input type="submit" value="Apply">
            <input id="clear-form" type="reset" value="Clear" class="hidden">
        </form>
    </aside>
<?php } ?>
