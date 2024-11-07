<?php function getProductImages($db, $productID) {
        $stmt = $db->prepare('SELECT pi.imagePath FROM product_images pi WHERE productID = :productID');
        $stmt->bindParam(':productID', $productID);
        $stmt->execute();
        return $stmt->fetchAll();
    }