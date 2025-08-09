<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database configuration
$servername = "localhost";
$username = "temp1101";
$password = "TeP@11245";
$dbName = "if0_39640263_unityapi";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbName;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

if ($method === 'DELETE' || ($method === 'POST' && $action === 'delete')) {
    // Handle single fault deletion
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Fault ID is required']);
        exit();
    }
    
    $faultId = $input['id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM faults WHERE id = ?");
        $stmt->execute([$faultId]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Fault deleted successfully',
                'deleted_id' => $faultId
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Fault not found']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to delete fault: ' . $e->getMessage()]);
    }
    
} elseif ($method === 'POST' && $action === 'clear_level') {
    // Handle clearing all faults for a specific level
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['level'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Level is required']);
        exit();
    }
    
    $level = $input['level'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM faults WHERE level = ?");
        $stmt->execute([$level]);
        
        $deletedCount = $stmt->rowCount();
        
        echo json_encode([
            'success' => true,
            'message' => "Cleared $deletedCount faults from level $level",
            'deleted_count' => $deletedCount,
            'level' => $level
        ]);
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to clear level: ' . $e->getMessage()]);
    }
    
} elseif ($method === 'POST' && $action === 'clear_all') {
    // Handle clearing all faults
    try {
        $stmt = $pdo->prepare("DELETE FROM faults");
        $stmt->execute();
        
        $deletedCount = $stmt->rowCount();
        
        echo json_encode([
            'success' => true,
            'message' => "Cleared all $deletedCount faults",
            'deleted_count' => $deletedCount
        ]);
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to clear all faults: ' . $e->getMessage()]);
    }
    
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>