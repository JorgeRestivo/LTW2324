<?php 
    require_once('../database/chat.db.php');
    require_once('../database/connection.db.php');
    require_once('../database/products.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/chat.tpl.php');
    
    $db = getDatabaseConnection();
    
    // Check if the user is logged in
    session_start();
    if (!isset($_SESSION['userID'])) {
        header("Location: ../pages/login.php");
    exit();
    }

    // Fetch user's chats from the database
    $chats = getUserChats($db, $_SESSION['userID']);

    // Print header
    print_header();
?>

<div class="container">
    <aside class="sidebar">
        <h2>Chats</h2>
        <ul>
            
            <?php foreach ($chats as $chat): ?>
                <li><a href="?chat=<?= $chat['chatID']; ?>"><?= $chat['chatName']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </aside>
    <main class="content">
        <?php
        // Check if a chat is selected
        if (isset($_GET['chat'])) {
            $chatID = $_GET['chat'];
            // Fetch messages for the selected chat
            $messages = getChatMessages($db, $chatID);
            // Display messages
            foreach ($messages as $message) {
                echo "<div class='message'>";
                echo "<p class='sender'>" . $message['sender'] . "</p>";
                echo "<p class='content'>" . $message['content'] . "</p>";
                echo "</div>";
            }
        } else {
            // Display default message
            echo "<p>Select a chat to view messages.</p>";
        }
        ?>
    </main>
</div>

<?php
// Print footer
print_footer();
?>