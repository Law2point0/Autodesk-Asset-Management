<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $assetName = $data['assetName'];
    $modelData = base64_decode($data['model']);
    $thumbnail = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['thumbnail']));
    $uploader = $_SESSION['UserID']; // Assuming the uploader's ID is stored in the session
    $projectID = $_SESSION['ProjectID']; // Assuming the project ID is stored in the session


    // Connect to the database
    $db = new SQLite3('Asset-Manager-DB.db');

    // Insert into AssetBase table
    $stmt = $db->prepare("INSERT INTO AssetBase (AssetName) VALUES (:assetName)");
    $stmt->bindValue(':assetName', $assetName, SQLITE3_TEXT);
    if (!$stmt->execute()) {
        http_response_code(500);
        echo "Failed to insert into AssetBase.";
        exit;
    }

    // Get the newly inserted BaseID
    $baseID = $db->lastInsertRowID();

    // Insert into Assets table
    $stmt = $db->prepare("INSERT INTO Assets (BaseID, Uploader, UploadDate, AssetFile, Thumbnail) VALUES (:baseID, :uploader, :uploadDate, :assetFile, :thumbnail)");
    $stmt->bindValue(':baseID', $baseID, SQLITE3_INTEGER);
    $stmt->bindValue(':uploader', $uploader, SQLITE3_INTEGER);
    $stmt->bindValue(':uploadDate', date('Y-m-d'), SQLITE3_TEXT);
    $stmt->bindValue(':assetFile', $modelData, SQLITE3_BLOB);
    $stmt->bindValue(':thumbnail', $thumbnail, SQLITE3_BLOB);

    // Assign the new BaseID to the project in the ProjectAssets table
    $stmt = $db->prepare("INSERT INTO ProjectAssets (BaseID, ProjectID) VALUES (:baseID, :projectID)");
    $stmt->bindValue(':baseID', $baseID, SQLITE3_INTEGER);
    $stmt->bindValue(':projectID', $projectID, SQLITE3_INTEGER);

    if ($stmt->execute()) {
        echo "New asset uploaded and assigned to the project successfully.";
    } else {
        http_response_code(500);
        echo "Failed to assign the asset to the project.";
    }

    $db->close();
}
?>