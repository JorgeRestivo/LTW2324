<?php
   function getAllProducts($db) {
        $stmt = $db->prepare('SELECT * FROM products JOIN categories ON products.category = categories.categoryID');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getProductInfo($db, $id) {
        $stmt = $db->prepare('SELECT * FROM ProductView WHERE productID = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    function getProduct($db, $id) {
        $stmt = $db->prepare('SELECT * FROM products p 
                                JOIN Product_Images i ON p.productID = i.productID 
                                JOIN Categories c ON p.categoryID = c.categoryID 
                                WHERE p.productID = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    function getUserProducts($db, $user_id) {
        $stmt = $db->prepare('SELECT p.* FROM products p JOIN user_products up ON p.productID = up.productID WHERE up.userID = :userID');
        $stmt->bindParam(':userID', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function editProduct($query){
        global $db;
        $stmt = $db->prepare($query);
        $stmt->execute();
    }

    function deleteProduct($query){
        global $db;
        $stmt = $db->prepare($query);
        $stmt->execute();
    }

    function addProduct($db, $title, $price, $description, $category, $condition, $imagePath, $productID){
        $stmt = $db->prepare('INSERT INTO Products (title, description, publishDate, category, condition, price, imagePath)
                            VALUES (:title, :description, NOW(), :category , :condition, :price , :imagePath);');
                            if ($stmt === false) {
        var_dump($db->errorInfo());
        return;
    }
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':condition', $condition);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':imagePath', $imagePath);

        $stmt->execute();

        $stmt2 = $db->prepare('INSERT INTO Product_Hashtags (productID, hashtagID) VALUES (:productID, :hashtagID);');
        $stmt2->bindParam(':productID', $productID);
        $stmt2->bindParam(':hashtagID', $category);
        $stmt2->execute();

        $stmt3 = $db->prepare('INSERT INTO User_Products (userID, productID) 
                                VALUES (:userID, :productID);');
        $stmt3->bindParam(':userID', $_SESSION['userID']);
        $stmt3->bindParam(':productID', $productID);
        $stmt3->execute();

        $stmt4 = $db->prepare('INSERT INTO Product_Images (productID, imagePath) 
                                VALUES (:productID, :imagePath);');
        $stmt4->bindParam(':productID', $productID);
        $stmt4->bindParam(':imagePath', $imagePath);
        $stmt4->execute();
    }

    function searchProducts($db, $search) {
        $stmt = $db->prepare('SELECT * FROM products WHERE title LIKE :search');
        $stmt->bindParam(':search', '%'.$search.'%');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getProductsByCategory($db, $category, $excludedId = null) {
        $stmt = $db->prepare('SELECT * FROM products WHERE category = :category AND productID != :id');
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':id', $excludedId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getProductsByPrice($db, $price) {
        $stmt = $db->prepare('SELECT * FROM products WHERE price <= :price');
        $stmt->bindParam(':price', $price);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getProductsByCondition($db, $condition) {
        $stmt = $db->prepare('SELECT * FROM Product WHERE condition = :condition');
        $stmt->bindParam(':condition', $condition);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getCategories($db) {
        $stmt = $db->prepare('SELECT * FROM Categories');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getSellerID($db, $productID) {
        $stmt = $db->prepare('SELECT userID FROM User_Products WHERE productID = :productID');
        $stmt->bindParam(':productID', $productID);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['userID']; 
    }
    ?>

<?php function getProdCount($db) {
    $stmt = $db->prepare('SELECT COUNT(*) FROM products');
    $stmt->execute();
    return $stmt->fetchColumn();
} ?>