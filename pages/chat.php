<?php
require_once('../database/connection.db.php');
require_once('../database/chat.db.php');
require_once('../templates/common.tpl.php');
require_once('../templates/chat.tpl.php');

// Start session if not already started
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: ../pages/login.php");
    exit(); // Stop further execution
}

// Get the userID and username of the logged-in user
$buyerID = $_SESSION['userID'];
$buyerUsername = $_SESSION['username'];

// Initialize the database connection
$db = getDatabaseConnection();

// Render header
print_header();
?>

<div class="container">
    <?php
    // Check if the productID and sellerID are provided
    if (isset($_GET['productID']) && isset($_GET['sellerID'])) {
        $productID = $_GET['productID'];
        $sellerID = $_GET['sellerID'];

        // Fetch the seller's username
        $sellerUsername = getUsernameByID($db, $sellerID);

        // Fetch chat messages
        $messages = getChatMessages($db, $productID, $sellerID);

        // Render chat template with the userID of the logged-in user
        renderChatPage($productID, $buyerID, $buyerUsername, $sellerID, $sellerUsername, $messages);
    } else {
        // Display error message and redirect
        echo "Error: Product ID or Seller ID is missing. Please provide both.";
    }
    ?>
</div>

<?php
// Render footer
print_footer();
?>
