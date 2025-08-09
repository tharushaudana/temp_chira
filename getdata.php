<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle OPTIONS preflight request and exit early
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$servername = "localhost";
$username = "temp1101";
$password = "TeP@11245";
$dbName = "if0_39640263_unityapi";

$conn = new mysqli($servername, $username, $password, $dbName);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Set charset to utf8
$conn->set_charset("utf8");

$level = $_GET['level'] ?? null;
$faults = [];

if ($level !== null && in_array($level, ['1', '2', '3'], true)) {
    $stmt = $conn->prepare("SELECT level, fault FROM faults WHERE level = ?");
    if ($stmt === false) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to prepare statement"]);
        exit();
    }
    
    $stmt->bind_param("s", $level);
    
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to execute query"]);
        $stmt->close();
        exit();
    }
    
    $result = $stmt->get_result();
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $faults[] = $row;
        }
        $result->free();
    }
    
    $stmt->close();
} else {
    $result = $conn->query("SELECT level, fault FROM faults");
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $faults[] = $row;
        }
        $result->free();
    }
}

http_response_code(200);
echo json_encode($faults);

$conn->close();
?>
