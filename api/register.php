<?php
require_once __DIR__ . '/../dotenv.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$host = $_ENV['DB_HOST'] ?? 'localhost';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$dbName = $_ENV['DB_NAME'] ?? 'backend';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $username = $input['username'] ?? '';
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';

    $conn = new mysqli($host, $user, $pass, $dbName);

    if ($conn->connect_error) {
        echo json_encode(['error' => 'Database connection failed']);
        exit();
    }

    // VULNERABLE: Direct interpolation allows SQL Injection
    $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'user')";
    
    if ($conn->query($query) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Registration successful!']);
    } else {
        echo json_encode(['error' => 'Error: ' . $conn->error]);
    }
    
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
