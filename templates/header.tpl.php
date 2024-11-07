<?php
function print_header() {
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the user is logged in
    $loggedIn = isset($_SESSION['username']);
    $username = $loggedIn ? $_SESSION['username'] : '';
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>popmarket</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/dropdown.js" defer></script>
    <script src="../js/filter.js" defer></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <header class="flex-header">
        <h1><a href="../index.php" class="logo">popmarket<span class="dot">.</span></a></h1>
        <nav id="navbar" class="flex-item">
            <ul>
                <li id="shop"><a href="../pages/shop.php">Shop</a></li>
                <li id="loved"><a href="../pages/loved.php">Loved</a></li>
                <li id="cart"><a href="../pages/basket.php">Cart</a></li>
                <?php if ($loggedIn): ?>
                    <li class="dropdown" id="account">
                        <a href="javascript:void(0)" class="dropbtn">My Account</a>
                        <div class="dropdown-content">
                            <a href="../pages/messages.php">Messages</a>
                            <a href="../pages/user_profile.php?id=<?= $_SESSION['userID'] ?>">Profile</a>
                            <?php if ($_SESSION['permission'] == 1): ?>
                                <a href="../pages/admin.php">Admin Page</a>
                            <?php endif; ?>
                            <a href="../pages/logout.php">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li id="account"><a href="../pages/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
            <form>
                <div class="search">
                    <span class="material-symbols-outlined">search</span>
                    <input class="search-input" type="search" placeholder="Search" id="search" name="search">
                </div>
            </form>
        </nav>
    </header>
<?php } ?>
