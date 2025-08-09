<?php
// Allow POST from any origin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

// DB credentials
$servername = "localhost";
$username = "temp1101";
$password = "TeP@11245";
$dbName = "if0_39640263_unityapi";

// Connect
$conn = new mysqli($servername, $username, $password, $dbName);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed"]));
}

// Get POSTed JSON input
$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data["level"]) || !isset($data["fault"])) {
    echo json_encode(["status" => "error", "message" => "Missing data"]);
    exit();
}

// Sanitize inputs
$level = $conn->real_escape_string($data["level"]);
$fault = $conn->real_escape_string($data["fault"]);

// Insert into DB
$sql = "INSERT INTO faults (level, fault) VALUES ('$level', '$fault')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Data inserted"]);
} else {
    echo json_encode(["status" => "error", "message" => "Insert failed: " . $conn->error]);
}

$conn->close();
?>
