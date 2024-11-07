<?php
// Include necessary files
require_once('../database/connection.db.php');
require_once('../database/admin.db.php');
require_once('../templates/common.tpl.php');

session_start();

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['userID']) || $_SESSION['permission'] !== 1) {
    header("Location: login.php");
    exit();
}

$db = getDatabaseConnection();

// Check for actions
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'promote_to_admin':
            if (isset($_POST['user_id'])) {
                $user_id = $_POST['user_id'];
                promoteUserToAdmin($db, $user_id);
            }
            break;
        case 'remove_product':
            if (isset($_POST['product_id'])) {
                $product_id = $_POST['product_id'];
                removeProduct($db, $product_id);
            }
            break;
        // Add more cases for other actions like ban user, add category, add condition, etc.
    }
}


// Fetch users and posts from the database
$users = getAllUsers($db);
$products = getAllProducts($db);

// Display users and posts with admin actions
?>

<?php
    print_header();
?>
<!-- HTML for admin panel -->
<div class="container">
    <h2>Users</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?= $user['username'] ?>
                <!-- Form to promote user to admin -->
                <form action="admin.php" method="POST">
                    <input type="hidden" name="action" value="promote_to_admin">
                    <input type="hidden" name="user_id" value="<?= $user['userID'] ?>">
                    <button type="submit">Promote to Admin</button>
                </form>
                <!-- Add more admin actions here -->
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Posts</h2>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <?= $product['title'] ?>
                <!-- Form to remove post -->
                <form action="admin.php" method="POST">
                    <input type="hidden" name="action" value="remove_post">
                    <input type="hidden" name="post_id" value="<?= $product['productID'] ?>">
                    <button type="submit">Remove Product</button>
                </form>
                <!-- Add more admin actions here -->
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php print_footer(); ?>

