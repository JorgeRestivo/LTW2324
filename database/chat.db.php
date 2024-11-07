<?php
function getChatMessages($db, $productID, $sellerID) {
    $stmt = $db->prepare('SELECT * FROM Chats WHERE productID = :productID AND sellerID = :sellerID ORDER BY timestamp DESC');
    $stmt->bindParam(':productID', $productID);
    $stmt->bindParam(':sellerID', $sellerID);
    $stmt->execute();
    return $stmt->fetchAll();
}

function sendMessage($db, $productID, $buyerID, $sellerID, $message) {
    $stmt = $db->prepare('INSERT INTO Chats (productID, buyerID, sellerID, message) VALUES (:productID, :buyerID, :sellerID, :message)');
    $stmt->bindParam(':productID', $productID);
    $stmt->bindParam(':buyerID', $buyerID);
    $stmt->bindParam(':sellerID', $sellerID);
    $stmt->bindParam(':message', $message);
    return $stmt->execute();
}

function getUsernameByID($db, $userID) {
    $stmt = $db->prepare('SELECT username FROM Users WHERE userID = ?');
    $stmt->execute(array($userID));
    return $stmt->fetchColumn();
}

function getProductChats($db, $productID) {
    $stmt = $db->prepare('SELECT * FROM Chats WHERE productID = :productID');
    $stmt->bindParam(':productID', $productID);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getUserChats($db, $userID) {
    // Prepare SQL query to fetch user chats
    $query = "SELECT * FROM Chats WHERE buyerID = :userID OR sellerID = :userID";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':userID', $userID, SQLITE3_INTEGER);
    
    // Execute the query
    $result = $stmt->execute();

    // Check for errors
    if (!$result) {
        // Handle the error
        $errorInfo = $stmt->errorInfo();
        // Log or display the error message
        echo "Error executing query: " . $errorInfo[2];
        return array();
    }

    // Fetch the results into an array
    $chats = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $chats[] = $row;
    }

    return $chats;
}

?>
