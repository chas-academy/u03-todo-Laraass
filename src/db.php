<?php
    $servername = "mariadb";
    $username = "mariadb";
    $password = "mariadb";
    $dbname = "todolist";

        try {
            $conn = new PDO ("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        catch (PDOException $e) {
            echo "Failed to connect" . $e->getMessage();
        }