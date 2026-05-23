<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle upload speed test
    $input = file_get_contents('php://input');
    $size = strlen($input);
    
    echo json_encode([
        'success' => true,
        'size' => $size,
        'timestamp' => time()
    ]);
} else {
    // Provide test data for download
    $testFile = 'test.dat';
    $testSize = 5 * 1024 * 1024; // 5MB
    
    if (!file_exists($testFile)) {
        $randomData = random_bytes($testSize);
        file_put_contents($testFile, $randomData);
    }
    
    header('Content-Type: application/octet-stream');
    header('Content-Length: ' . filesize($testFile));
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    
    readfile($testFile);
}
?>