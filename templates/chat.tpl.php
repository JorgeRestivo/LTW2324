<?php
function renderChatPage($productID, $buyerID, $buyerUsername, $sellerID, $sellerUsername, $messages) {
    // Start session if not already started
    session_start();

    // Check if the user is logged in
    $loggedIn = isset($_SESSION['userID']);

    // If not logged in, redirect to the login page
    if (!$loggedIn) {
        header("Location: ../pages/login.php");
        exit(); // Stop further execution
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="../css/chat.css"> 
</head>
<body>
    <div class="chat-page">
        <div class="chat-box">
            <div class="chat-messages">
                <?php 
                // Iterate over messages in reverse order
                for ($i = count($messages) - 1; $i >= 0; $i--) {
                    $message = $messages[$i];
                    $isBuyer = $message['senderID'] == $buyerID;
                    $username = $isBuyer ? $sellerUsername : $buyerUsername;
                ?>
                    <div class="message">
                        <span><?= $username ?> - <?= $message['timestamp'] ?></span>
                        <p><?= $message['message'] ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
        
        <form class="chat-form" action="send_message.php" method="post">
            <input type="hidden" name="productID" value="<?= $productID ?>">
            <input type="hidden" name="buyerID" value="<?= $buyerID ?>">
            <input type="hidden" name="sellerID" value="<?= $sellerID ?>">
            <textarea name="message" placeholder="Type your message here..." required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>
<?php
}
?>
