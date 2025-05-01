<?php
session_start(); 

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['model'], $data['thumbnail'], $data['name'])) {
    $name = $data['name'];
    $modelData = base64_decode($data['model']);

    // Remove the "data:image/png;base64," prefix
    $thumbnailBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $data['thumbnail']);
    $thumbnailData = base64_decode($thumbnailBase64);

    $db = new SQLite3('Asset-Manager-DB.db');
    $db->exec("CREATE TABLE IF NOT EXISTS Assets (
        AssetID INTEGER PRIMARY KEY AUTOINCREMENT,
        BaseID INTEGER,
        Uploader TEXT,
        UploadDate DATE,
        Dimensions TEXT,
        AssetFile BLOB,
        License BLOB,
        Version INTEGER,
        Status TEXT,
        Thumbnail BLOB
    );");

    $stmt = $db->prepare("INSERT INTO Assets ( AssetFile, BaseID, Uploader, UploadDate, Status, Thumbnail) VALUES (:AssetFile, :BaseID, :Uploader, :UploadDate, :Status, :thumbnail)");
    $stmt->bindValue(':BaseID', $_SESSION["BaseID"], SQLITE3_INTEGER);
    $stmt->bindValue(':Uploader', $_SESSION["UserID"], SQLITE3_INTEGER);
    $stmt->bindValue(':UploadDate', date('Y-m-d H:i:s'), SQLITE3_TEXT);
    $stmt->bindValue(':AssetFile', $modelData, SQLITE3_BLOB);
    $stmt->bindValue(':thumbnail', $thumbnailData, SQLITE3_BLOB);
    $stmt->bindValue(':Status', 'Pending', SQLITE3_TEXT);
    $stmt->execute();


    $stmt = $db->prepare("INSERT INTO AssetBase (AssetName, BaseID) VALUES (:AssetName, :BaseID)");
    $stmt->bindValue(':BaseID', $_SESSION["BaseID"], SQLITE3_BLOB);
    $stmt->bindValue(':AssetName', $name, SQLITE3_TEXT);

    echo "Saved!";
} else {
    echo "Missing fields.";
}
?>
