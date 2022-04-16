<?php
class MySQL
{
    private static $instance;
    public static function getInstance()
    {
        if (self::$instance != null) {
            return self::$instance;
        }
        self::$instance = new self();
        return self::$instance;
    }
    public function getPdo()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";

        try {
            $pdo = new PDO("mysql:host=$servername;dbname=orm", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $pdo;
    }
}
