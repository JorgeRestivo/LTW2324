<?php
    require_once('../database/connection.db.php');
    require_once('../database/users.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/user.tpl.php');

    $db = getDatabaseConnection();
    $user = $_SESSION['userID'];
?>

<?php
    print_header(); ?>
    <main class="edit-user">
        <h1>Edit Profile</h1>
        <form action="" method="POST" class="form-container">
            <div class="input-box">
                <input type="text" name="email" class="input-field" placeholder="New Email" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="text" name="username" class="input-field" placeholder="New Username" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" class="input-field" placeholder="New Password" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="password" name="confirm_password" class="input-field" placeholder="Confirm Password" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="text" name="phone" class="input-field" placeholder="New Phone Number" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="text" name="location" class="input-field" placeholder="New Location" autocomplete="off" required>
            </div>
            <div style="color: red;">
                <?php echo !empty($errors) ? implode('<br>', $errors) : ''; ?>
            </div>
            <button class="action-btn" type="submit" >Sell Now</button>
        </form>
    </main>
    <?= print_footer();