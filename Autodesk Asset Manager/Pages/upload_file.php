<?php
session_start();
// Error Checking - Uncomment for debugging, Displays in php_error.log

//ini_set('display_errors', 0); // hide PHP errors from frontend
//ini_set('log_errors', 1);
//ini_set('error_log', __DIR__ . '/php_error.log');

header('Content-Type: application/json');

$db = new SQLite3('Asset-Manager-DB.db');

$userID = $_SESSION['UserID'] ?? null;
if (!$userID) {
    echo json_encode(['message' => 'User not logged in.']);
    exit;
}

$query = $db->prepare('SELECT FName, LName FROM User WHERE UserID = :userID');
$query->bindValue(':userID', $userID, SQLITE3_INTEGER);
$result = $query->execute();
$userData = $result->fetchArray(SQLITE3_ASSOC);

if (!$userData) {
    echo json_encode(['message' => 'User not found.']);
    exit;
}

$uploader = $userData['FName'] . ' ' . $userData['LName'];
$baseID = $_POST['baseID'] ?? 1;
$uploadDate = date('Y-m-d');
$lastUpdated = date('Y-m-d H:i:s');
$dimensions = $_POST['dimensions'] ?? 'N/A';
$version = $_POST['version'] ?? 1;
$status = $_POST['status'] ?? 'Pending';
$thumbnail = $_POST['thumbnail'] ?? 'default.jpg';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['modelFile']) && $_FILES['modelFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['modelFile']['tmp_name'];
        $fileContent = file_get_contents($fileTmpPath);

        $stmt = $db->prepare('
            INSERT INTO Assets (BaseID, Uploader, UploadDate, LastUpdated, Dimensions, AssetFile, Version, Status, Thumbnail)
            VALUES (:baseID, :uploader, :uploadDate, :lastUpdated, :dimensions, :assetFile, :version, :status, :thumbnail)
        ');
        $stmt->bindValue(':baseID', $baseID, SQLITE3_INTEGER);
        $stmt->bindValue(':uploader', $uploader, SQLITE3_TEXT);
        $stmt->bindValue(':uploadDate', $uploadDate, SQLITE3_TEXT);
        $stmt->bindValue(':lastUpdated', $lastUpdated, SQLITE3_TEXT);
        $stmt->bindValue(':dimensions', $dimensions, SQLITE3_TEXT);
        $stmt->bindValue(':assetFile', $fileContent, SQLITE3_BLOB);
        $stmt->bindValue(':version', $version, SQLITE3_INTEGER);
        $stmt->bindValue(':status', $status, SQLITE3_TEXT);
        $stmt->bindValue(':thumbnail', $thumbnail, SQLITE3_TEXT);

        $result = $stmt->execute();

        if ($result) {
            echo json_encode(['message' => '3D asset file uploaded to Assets table successfully!']);
        } else {
            echo json_encode(['message' => 'Database insertion failed.']);
        }
    } else {
        echo json_encode(['message' => 'No file uploaded or file error.']);
    }
} else {
    echo json_encode(['message' => 'Invalid request method.']);
}
?>
