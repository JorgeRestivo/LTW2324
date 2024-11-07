<?php 
    function getDatabaseConnection() {
        return new PDO('sqlite:../database/database.db');
    }
    