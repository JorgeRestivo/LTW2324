<?php
session_start();

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$errors = array();

if (isset($_POST["submit"])) {
    require_once '../database/config.php';

    $id = $_SESSION["userID"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"]; // New confirm password field
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $location = $_POST["location"]; // New location field
    $phone_number = $_POST["phone_number"]; // New phone number field

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }
    
    // Validate password if provided
    if (!empty($password)) {
        $pattern = '/^(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
        if (!preg_match($pattern, $password)) {
            array_push($errors, "Password must contain at least 1 number, 1 uppercase letter and be between 8 and 20 characters long");
        }
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        array_push($errors, "Passwords do not match");
    }

    if ($user) {
        $current_password_encrypted = md5($current_password);
        if ($user['password'] !== $current_password_encrypted) {
            array_push($errors, "Incorrect current password");
        }
    }

    // Check if the username or email already exists for another user
    $user_check_query = "SELECT * FROM Users WHERE (username = :username OR email = :email) AND userID != :userID LIMIT 1";
    $stmt = $db->prepare($user_check_query);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':userID', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);
    
    if ($user) {
        array_push($errors, "Email or username already registered");
    }

    // If no validation errors, update the user's profile
    if (count($errors) == 0) {
        if (!empty($password)) {
            $password_encrypted = md5($password); // Securely hash the password
            $query = "UPDATE Users SET username = :username, firstName = :firstname, lastName = :lastname, email = :email, location = :location, phonenumber = :phone_number, password = :password WHERE userID = :userID";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':password', $password_encrypted, SQLITE3_TEXT);
        } else {
            $query = "UPDATE Users SET username = :username, firstName = :firstname, lastName = :lastname, email = :email, location = :location, phonenumber = :phone_number WHERE userID = :userID";
            $stmt = $db->prepare($query);
        }

        $stmt->bindValue(':username', $username, SQLITE3_TEXT);
        $stmt->bindValue(':firstname', $firstname, SQLITE3_TEXT);
        $stmt->bindValue(':lastname', $lastname, SQLITE3_TEXT);
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->bindValue(':location', $location, SQLITE3_TEXT); // Bind location parameter
        $stmt->bindValue(':phone_number', $phone_number, SQLITE3_TEXT); // Bind phone number parameter
        $stmt->bindValue(':userID', $id, SQLITE3_INTEGER);
        
        if ($stmt->execute()) {
            // Update session variables
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['location'] = $location; // Update session variable for location
            $_SESSION['phone_number'] = $phone_number; // Update session variable for phone number
            // Redirect to the profile page
            header('Location: ../pages/user_profile.php?id=' . $_SESSION['userID']);
            exit();
        } else {
            array_push($errors, "Failed to update profile");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/profile.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>
<body>
    <div class="header">
        <div id="profileButton">
            <a href="profile.php"><i class='fas fa-user-circle'></i></a>
        </div>
    </div>
    <div class="profileContainer">
        <h1>Edit Profile</h1>
        <div class="profile">
            <div class="profilePicture">
                <i class='fas fa-user-circle'></i>
            </div>
            <div class="editProfile">
                <form action="" method="POST">
                    <label for="username">Username:</label>
                    <br/>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
                    <br/>
                    <label for="firstname">First Name:</label>
                    <br/>
                    <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($_SESSION['firstname']); ?>" required>
                    <br/>
                    <label for="lastname">Last Name:</label>
                    <br/>
                    <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($_SESSION['lastname']); ?>" required>
                    <br/>
                    <label for="email">Email:</label>
                    <br/>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                    <br/>
                    <label for="location">Location:</label> <!-- New location field -->
                    <br/>
                    <input type="text" id="location" name="location" value="<?php echo isset($_SESSION['location']) ? htmlspecialchars($_SESSION['location']) : ''; ?>" required>
                    <br/>
                    <label for="phone_number">Phone Number:</label> <!-- New phone number field -->
                    <br/>
                    <input type="text" id="phone_number" name="phone_number" value="<?php echo isset($_SESSION['phone_number']) ? htmlspecialchars($_SESSION['phone_number']) : ''; ?>" required>
                    <br/>
                    <label for="password">New Password:</label> <!-- New password field -->
                    <br/>
                    <input type="password" id="password" name="password">
                    <br/>
                    <label for="confirm_password">Confirm New Password:</label> 
                    <br/>
                    <input type="password" id="confirm_password" name="confirm_password">
                    <br/>
                    <label for="current_password">Current Password:</label> <!-- New field for current password -->
                    <br/>
                    <input type="password" id="current_password" name="current_password" required>
                    <br/>
                    <div style="color: red;"><?php echo !empty($errors) ? implode('<br>', $errors) : ''; ?></div>
                    <input type="submit" value="Save Profile" name="submit">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
                   
