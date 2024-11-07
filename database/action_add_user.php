<?php 
    require_once('../database/users.db.php');

    if(isset($_POST['email']) && $_POST['password']) {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        addUser($db, $username, $email, $password);
        header("Location: ../index.php");
        exit();
    } else {
        header("Location: ../login.php");
        exit();
    }