<?php 
    require_once('../database/connection.db.php');
    require_once('../database/users.db.php');
    require_once('../templates/common.tpl.php');
    require_once('../templates/user.tpl.php');

    $db = getDatabaseConnection();
    $id = $_GET['id'];
    $user = getUser($db, $id);
    session_start();
    $_SESSION['userID'] = $user['userID'];


    print_header();
    print_user_page($db, $user);
    print_footer();