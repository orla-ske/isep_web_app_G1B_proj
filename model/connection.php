<?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "petstridedb";

    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function getpdoection() {
        $this->pdo = null;
        
        try {
            $this->pdo = new PDO(
                "mysql:host=" . $this->servername . ";dbname=" . $this->dbname,
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "pdoection Error: " . $e->getMessage();
        }
        
        return $this->pdo;
    }
?>