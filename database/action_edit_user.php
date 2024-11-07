<?php 
    require_once('../database/users.db.php');

    if(isset($_POST['id'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['img'])) {
        $id = intval($_POST['id']);
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $img = htmlspecialchars($_POST['img']);

        editUser("UPDATE users SET username = '$username', email = '$email', password = '$password', img = '$img' WHERE id = " . $id);
        header("Location: ../index.php");
        exit();
    } else {
        header("Location: ../index.php");
        exit();
    }
