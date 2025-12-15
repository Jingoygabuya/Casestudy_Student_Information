<?php
// Database configuration for XAMPP
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

class Database {
    // Database credentials for XAMPP
    private $host = "localhost";
    private $database_name = "student_management";
    private $username = "root";  // Default XAMPP username
    private $password = "";      // Default XAMPP password (empty)
    public $conn;

    // Get database connection
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->database_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo json_encode([
                'success' => false,
                'message' => "Connection error: " . $exception->getMessage()
            ]);
        }

        return $this->conn;
    }
}
?>

