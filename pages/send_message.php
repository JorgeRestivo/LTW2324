<?php
session_start(); // Start the session

require_once('../database/connection.db.php');
require_once('../database/chat.db.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the incoming data
    $productID = filter_input(INPUT_POST, 'productID', FILTER_VALIDATE_INT);
    $sellerID = filter_input(INPUT_POST, 'sellerID', FILTER_VALIDATE_INT);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Check if all required fields are present
    if ($productID && $sellerID && $message) {
        $db = getDatabaseConnection();

        // Get the buyer's ID from the session
        if (isset($_SESSION['username'])) {
            $buyerID = $_SESSION['userID'];
            
            // Insert the message into the database
            if (sendMessage($db, $productID, $buyerID, $sellerID, $message)) {
                // Redirect back to the chat page
                header("Location: chat.php?productID=$productID&sellerID=$sellerID");
                exit();
            } else {
                // Handle database error
                echo "Error: Failed to send message.";
            }
        } else {
            // Handle case where buyerID is not set in session
            echo "Error: User not logged in.";
        }
    } else {
        // Handle missing or invalid input
        echo "Error: Invalid or incomplete data received.";
    }
} else {
    // Handle case where form is not submitted
    echo "Error: Form not submitted.";
}
?>
