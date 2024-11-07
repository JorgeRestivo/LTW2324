<?php 
    require_once('../database/products.db.php');
    require_once('../database/connection.db.php');

    $db = getDatabaseConnection();


    if(isset($_POST['title'], $_POST['price'], $_POST['description'], $_POST['category'], $_POST['condition'], $_FILES['image'])) {
        $prodID = getProdCount($db) + 1;
        $title = htmlspecialchars($_POST['title']);
        $imageName = strtolower(str_replace(' ', '', $title));
        $price = floor(doubleval($_POST['price']) * 100);
        $description = htmlspecialchars($_POST['description']);
        $category = intval($_POST['category']);
        $condition = htmlspecialchars($_POST['condition']);

        if (!is_dir('../database/userImages/'.$_SESSION['userID'].'/'.$prodID)) mkdir('../database/userImages/'.$_SESSION['userID'].'/'.$prodID);
        $tempFileName = $_FILES['image']['tmp_name'];

        $original = @imagecreatefromjpeg($tempFileName);
        if (!$original) $original = @imagecreatefrompng($tempFileName);
        if (!$original) $original = @imagecreatefromgif($tempFileName);
        if (!$original) die('Unknown image format!');

        $imagePath = '../database/userImages/'.$_SESSION['userID'].'/'.$prodID.'/'.$imageName.'.png';
        imagepng($original, $outputPath);
        imagedestroy($original);

        addProduct($db, $title, $price, $description, $category, $condition, $imagePath, $prodID);
    
        //header("Location: ../product.php?id=$prodID");
        exit();
    } else {
        header("Location: ../index.php");
        exit();
    }