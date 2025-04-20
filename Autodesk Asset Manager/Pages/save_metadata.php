<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$data = file_get_contents("php://input");
$decoded = json_decode($data, true);

// Validate and create folder if it doesn't exist
$assetsDir = __DIR__ . '/assets';
if (!is_dir($assetsDir)) {
    mkdir($assetsDir, 0755, true);
}

if ($data && !empty($decoded)) {
    $filename = 'metadata_' . time() . '.json';
    $filePath = $assetsDir . '/' . $filename;

    if (file_put_contents($filePath, json_encode($decoded, JSON_PRETTY_PRINT))) {
        echo json_encode([
            "status" => "success",
            "message" => "Metadata saved",
            "file" => $filename
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to write file"
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Invalid or empty data"
    ]);
}
?>
