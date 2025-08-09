<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration - REPLACE THESE WITH YOUR ACTUAL DATABASE DETAILS
$servername = "localhost";
$username = "temp1101";
$password = "TeP@11245";
$dbName = "if0_39640263_unityapi";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get the last update time from the client
    $lastUpdate = isset($_GET['last_update']) ? $_GET['last_update'] : '1970-01-01 00:00:00';
    
    // First, let's check if we have timestamp columns in the table
    $columnCheckSql = "SHOW COLUMNS FROM $table_name";
    $columnStmt = $pdo->prepare($columnCheckSql);
    $columnStmt->execute();
    $columns = $columnStmt->fetchAll(PDO::FETCH_COLUMN);
    
    $hasCreatedAt = in_array('created_at', $columns);
    $hasUpdatedAt = in_array('updated_at', $columns);
    
    if ($hasCreatedAt || $hasUpdatedAt) {
        // Method 1: Using timestamp columns
        $timestampCol = $hasUpdatedAt ? 'updated_at' : 'created_at';
        
        $sql = "SELECT level, fault as type, $timestampCol as timestamp
                FROM $table_name 
                WHERE $timestampCol > :last_update 
                ORDER BY $timestampCol DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':last_update', $lastUpdate);
        $stmt->execute();
        
        $updates = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $response = [
            'has_updates' => count($updates) > 0,
            'updates' => [],
            'latest_update_time' => $lastUpdate,
            'method' => 'timestamp'
        ];
        
        if (count($updates) > 0) {
            foreach ($updates as $update) {
                $response['updates'][] = [
                    'level' => $update['level'],
                    'type' => 'fault',
                    'timestamp' => $update['timestamp']
                ];
            }
            
            // Update the latest update time to the most recent update
            $response['latest_update_time'] = $updates[0]['timestamp'];
        }
        
    } else {
        // Method 2: Using count comparison (fallback method)
        $lastCount = isset($_GET['last_count']) ? (int)$_GET['last_count'] : 0;
        
        // Get current count of records
        $sql = "SELECT COUNT(*) as total_count FROM $table_name";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentTotalCount = (int)$result['total_count'];
        
        $hasUpdates = $currentTotalCount > $lastCount;
        
        $response = [
            'has_updates' => $hasUpdates,
            'updates' => [],
            'current_count' => $currentTotalCount,
            'latest_update_time' => date('Y-m-d H:i:s'),
            'method' => 'count'
        ];
        
        if ($hasUpdates) {
            $newRecordsCount = $currentTotalCount - $lastCount;
            $response['updates'][] = [
                'level' => 'all', 
                'type' => 'new_faults', 
                'count' => $newRecordsCount
            ];
        }
    }
    
    echo json_encode($response);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database connection failed: ' . $e->getMessage(),
        'has_updates' => false,
        'updates' => [],
        'debug_info' => [
            'last_update' => $lastUpdate ?? 'not_set',
            'server_time' => date('Y-m-d H:i:s')
        ]
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'General error: ' . $e->getMessage(),
        'has_updates' => false,
        'updates' => []
    ]);
}
?>