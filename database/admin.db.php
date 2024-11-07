<?php

// Function to promote a user to admin
function promoteUserToAdmin($db, $user_id) {
    $query = "UPDATE Users SET permission = 1 WHERE userID = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
}

// Function to demote an admin to a normal user
function demoteAdminToUser($db, $user_id) {
    $query = "UPDATE Users SET permission = 0 WHERE userID = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
}

// Function to check if a user is an admin
function isAdmin($db, $user_id) {
    $query = "SELECT permission FROM Users WHERE userID = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($result['permission'] == 1);
}

// Function to remove a product
function removeProduct($db, $product_id) {
    $query = "DELETE FROM Products WHERE productID = :product_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
}


// Function to retrieve all users
function getAllUsers($db) {
    $query = "SELECT * FROM Users WHERE permission = 0 ";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Function to ban a user
function banUser($db, $user_id) {
    // Implement banning user functionality here
}

// Function to add a new category
function addCategory($category_name) {
    // Implement adding category functionality here
}

// Function to add a new condition
function addCondition($condition_name) {
    // Implement adding condition functionality here
}
// Function to retrieve all products
function getAllProducts($db) {
    $query = "SELECT * FROM Products";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Add more functions for other admin operations as needed

?>
