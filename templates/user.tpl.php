<?php 
    require_once('../templates/product.tpl.php');
    require_once('../database/products.db.php');
?>

<?php function print_user_card($user) { ?>
    <a href="../pages/user.php?id=<?= $user['userID'] ?>">
        <div class="user-card">
            <div class="image-container">
                <?php if (isset($user['profilePath'])): ?>
                    <img src="../database/userImages/<?= $user['profilePath']; ?>" alt="<?= $user['username']; ?>">
                <?php else: ?>
                    <img src="../database/userImages/default_profile_image.webp" alt="<?= $user['username']; ?>">
                <?php endif; ?>            
            </div>
            <div class="user-info">
                <p class="name"><?= $user['firstName']; ?> <?= $user['lastName']; ?></p>
                <p>✉ <?= $user['email']; ?></p>
                <p>☏ <?= $user['phoneNumber']; ?></p>
            </div>
        </div>
    </a>
<?php } ?>

<?php function print_user_info($user) { ?>
    <div class="user">
        <div class="image-container">
            <?php if (isset($user['profilePath'])): ?>
                <img src="../database/userImages/<?= $user['profilePath']; ?>" alt="<?= $user['username']; ?>">
            <?php else: ?>
                <img src="../database/userImages/default_profile_image.webp" alt="<?= $user['username']; ?>">
            <?php endif; ?>           
        </div>
        <div class="user-info">
            <h2><?= isset($user['firstName']) ?  $user['firstName']." ".$user['lastName'] : "Unknown"?></h2>
            <p><?= isset($user['username']) ? $user['username'] : 'Unknown'; ?></p>
            <p>About:</p>
            <p>✉ <?= isset($user['email']) ? $user['email'] : 'No email provided'; ?></p>
            <p>☏ <?= isset($user['phoneNumber']) ? $user['phoneNumber'] : 'No phone number provided'; ?></p>
            <p>⚲ <?= isset($user['location']) ?  $user['location'] : 'No location provided' ?></p>
            <?php if(isset($_SESSION['userID']) && $user['userID'] == $_SESSION['userID']) { ?>
                <a href="../pages/edit_profile.php">Edit information</a>
                <a href="../pages/add_product.php"><button class="action-btn">Add product</button></a>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php function print_user_page($db, $user) { 
    $products = getUserProducts($db, $user['userID']) ?>

    <main class="user-page">
        <?= print_user_info($user); ?>
        <h2>Products</h2>
        <?= print_user_products($products); ?>
    </main>
<?php } ?>