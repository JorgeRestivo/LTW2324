<?php
session_start();

$errors = array();

if (isset($_POST["submit"])) {
    require_once '../database/config.php';

    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    $password_encrypted = md5($password);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }

    // Check if email and password fields are filled
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // Proceed if no validation errors
    if (count($errors) == 0) {
        $query = "SELECT * FROM Users WHERE email = :email LIMIT 1";
        $stmt = $db->prepare($query);
        
        if ($stmt) {
            $stmt->bindValue(':email', $email, SQLITE3_TEXT);
            $result = $stmt->execute();
            
            if ($result) {
                $user = $result->fetchArray(SQLITE3_ASSOC);
                if ($user) {
                    if ($user['password'] != $password_encrypted) {
                        
                        array_push($errors, "Wrong password");
                    } else {
                        // Set session variables
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['userID'] = $user['userID'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['permission'] = $user['permission'];
                        $_SESSION['firstname'] = $user['firstName'];
                        $_SESSION['lastname'] = $user['lastName'];
                        $_SESSION['location'] = $user['location']; 
                        $_SESSION['phone_number'] = $user['phoneNumber']; 


                        // Redirect to shop page after successful login
                        header('Location: ../pages/shop.php');
                        exit();
                    }
                } else {
                    array_push($errors, "User does not exist");
                }
            } else {
                array_push($errors, "Database query failed: " . $db->lastErrorMsg());
            }
        } else {
            array_push($errors, "Database query preparation failed: " . $db->lastErrorMsg());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popmarket Login</title>
    <link rel="stylesheet" href="../css/account.css">
</head>
<body>
    <header class="flex-header">
        <h1><a href="../index.php" class="logo">popmarket<span class="dot">.</span></a></h1>
    </header>
    <div class="login-box">
        <div class="login-header">
            <header>Login</header>
        </div>
        <form action="" method="POST">
            <div class="input-box">
                <input type="text" name="email" class="input-field" placeholder="Email" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" class="input-field" placeholder="Password" autocomplete="off" required>
            </div>
            <div class="forgot">
                <section>
                    <input type="checkbox" id="check">
                    <label for="check">Remember me</label>
                </section>
                <section>
                    <a href="#">Forgot Password</a>
                </section>
            </div>
            <div class="input-submit">
                <button class="submit-btn" id="submit" type="submit" name="submit">Sign In</button>
            </div>
            <div style="color: red;">
                <?php echo !empty($errors) ? implode('<br>', $errors) : ''; ?>
            </div>
        </form>
        <div class="sign-up-link">
            <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </div>
    </div>
</body>
</html>
