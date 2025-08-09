<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Simple test script to verify your notification system works
// This simulates database updates for testing

$lastUpdate = isset($_GET['last_update']) ? $_GET['last_update'] : '1970-01-01 00:00:00';
$lastCount = isset($_GET['last_count']) ? (int)$_GET['last_count'] : 0;

// Simulate some test data
$testUpdates = [
    [
        'level' => '1',
        'type' => 'fault',
        'timestamp' => date('Y-m-d H:i:s')
    ],
    [
        'level' => '2', 
        'type' => 'fault',
        'timestamp' => date('Y-m-d H:i:s')
    ]
];

// For testing, always return updates
$response = [
    'has_updates' => true,
    'updates' => $testUpdates,
    'latest_update_time' => date('Y-m-d H:i:s'),
    'current_count' => $lastCount + count($testUpdates),
    'debug_info' => [
        'received_last_update' => $lastUpdate,
        'received_last_count' => $lastCount,
        'server_time' => date('Y-m-d H:i:s'),
        'message' => 'Test response - always returns updates'
    ]
];

echo json_encode($response, JSON_PRETTY_PRINT);
?>