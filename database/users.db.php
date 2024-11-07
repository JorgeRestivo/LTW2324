<?php
    function getUser($db, $id) {
        $stmt = $db->prepare('SELECT * FROM usersView WHERE userID = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    function addUser($db, $username, $email, $password) {
        $stmt = $db->prepare('INSERT INTO users (username, email, password) VALUES (Çusername, :email, :password)');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    }

    function editUser($query) {
        global $db;
        $stmt = $db->prepare($query);
        $stmt->execute();
    }

    function deleteUser($db) {
        $stmt = $db->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();
    }

    function loginUser($db, $email, $password) {
        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return $stmt->fetch();
    }
    