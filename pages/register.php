<?php
session_start();

// Automatically log out any existing session
session_unset();
session_destroy();
session_start();

$errors = array();

if (isset($_SESSION['username'])) {
    header('Location: ../pages/shop.php');
    exit();
}

if (isset($_POST["submit"])) {
    require_once '../database/config.php';

    $firstname = $_POST["firstname"] ?? '';
    $lastname = $_POST["lastname"] ?? '';
    $email = $_POST["email"] ?? '';
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';
    $phone = $_POST["phone"] ?? '';
    $location = $_POST["location"] ?? '';

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }

    // Validate password match
    if ($password !== $confirm_password) {
        array_push($errors, "Passwords do not match");
    }

    $pattern = '/^(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
    if(!preg_match($pattern, $password))
    {
      array_push($errors, "Password must contain at least 1 number, 1 uppercase letter and be between 8 and 20 characters long");
    }

    $pattern = '/^[a-zA-Z]+$/';
    if(!preg_match($pattern, $firstname) || !preg_match($pattern, $lasttname))
    {
      array_push($errors, "Name can only countain letters and spaces");
    }
    if(!preg_match($pattern, $location))
    {
      array_push($errors, "Location can only countain letters and spaces");
    }
    
    if (!preg_match('/^\d{9,15}$/', $phone)) {
        array_push($errors, "Phone number must be between 9 and 15 digits");

    // Check if required fields are filled
    if (empty($firstname)) {
        array_push($errors, "First name is required");
    }
    if (empty($lastname)) {
        array_push($errors, "Last name is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    if (empty($phone)) {
        array_push($errors, "Phone number is required");
    }
    if (empty($location)) {
        array_push($errors, "Location is required");
    }

    // Check if username or email already exists
    $user_check_query = "SELECT * FROM Users WHERE username=:username OR email=:email LIMIT 1";
    $stmt = $db->prepare($user_check_query);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $result = $stmt->execute();
    if ($result) {
        $user = $result->fetchArray(SQLITE3_ASSOC);
        if ($user) {
            array_push($errors, "Email or username already registered");
        }
    } else {
        array_push($errors, "Database query failed: " . $db->lastErrorMsg());
    }

    // If no errors, insert user into the database
    if (count($errors) == 0) {
        $password_encrypted = md5($password); // Securely hash the password

        $query = "INSERT INTO Users (firstname, lastname, username, email, password, phoneNumber, location, profilePath) 
                  VALUES (:firstname, :lastname, :username, :email, :password, :phone, :location, :profilePath)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':firstname', $firstname, SQLITE3_TEXT);
        $stmt->bindValue(':lastname', $lastname, SQLITE3_TEXT);
        $stmt->bindValue(':username', $username, SQLITE3_TEXT);
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->bindValue(':password', $password_encrypted, SQLITE3_TEXT);
        $stmt->bindValue(':phone', $phone, SQLITE3_TEXT);
        $stmt->bindValue(':location', $location, SQLITE3_TEXT);
        
        // Generate profile path based on userID which will be known after insertion
        $stmt->bindValue(':profilePath', '', SQLITE3_TEXT); // Temporarily set to an empty string

        if ($stmt->execute()) {
            // Retrieve the new user ID and update profilePath
            $userId = $db->lastInsertRowID();
            $profilePath = $userId . "/profile.png";

            $update_query = "UPDATE Users SET profilePath = :profilePath WHERE userID = :userID";
            $update_stmt = $db->prepare($update_query);
            $update_stmt->bindValue(':profilePath', $profilePath, SQLITE3_TEXT);
            $update_stmt->bindValue(':userID', $userId, SQLITE3_INTEGER);
            $update_stmt->execute();

            // Set session variables
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $userId;
            $_SESSION['email'] = $email;
            $_SESSION['location'] = $location;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['phone_number'] = $phone;
            $_SESSION['lastname'] = 0;

            // Retrieve user permission
            $permission_query = "SELECT permission FROM Users WHERE userID = :userID";
            $stmt = $db->prepare($permission_query);
            $stmt->bindValue(':userID', $userId, SQLITE3_INTEGER);
            $result = $stmt->execute();
            if ($result) {
                $user = $result->fetchArray(SQLITE3_ASSOC);
                $_SESSION['permission'] = $user['permission'];

                header('Location: ../pages/shop.php');
                exit();
            } else {
                array_push($errors, "Failed to retrieve user data after registration");
            }
        } else {
            array_push($errors, "Failed to register user: " . $db->lastErrorMsg());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popmarket Register</title>
    <link rel="stylesheet" href="../css/account.css">
</head>
<body>
    <header class="flex-header">
        <h1><a href="../index.php" class="logo">popmarket<span class="dot">.</span></a></h1>
    </header>
    <div class="register-box">
        <div class="login-header">
            <header>Register</header>
        </div>
        <form action="" method="POST" class="scrollable-form-container">
            <div class="input-box">
                <input type="text" name="firstname" class="input-field" placeholder="First Name" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="text" name="lastname" class="input-field" placeholder="Last Name" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="text" name="email" class="input-field" placeholder="Email" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="text" name="username" class="input-field" placeholder="Username" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" class="input-field" placeholder="Password" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="password" name="confirm_password" class="input-field" placeholder="Confirm Password" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="text" name="phone" class="input-field" placeholder="Phone Number" autocomplete="off" required>
            </div>
            <div class="input-box">
                <input type="text" name="location" class="input-field" placeholder="Location" autocomplete="off" required>
            </div>
            <div style="color: red;">
                <?php echo !empty($errors) ? implode('<br>', $errors) : ''; ?>
            </div>
            <input class="submit-btn" type="submit" name="submit" value="Register">
        </form>
        <div class="sign-up-link">
            <p>Already have an account? <a href="login.php">Sign In</a></p>
        </div>
    </div>
</body>
</html>
