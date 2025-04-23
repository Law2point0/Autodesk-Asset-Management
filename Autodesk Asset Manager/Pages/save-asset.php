<?php
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['model'], $data['thumbnail'], $data['name'])) {
    $name = $data['name'];
    $modelData = base64_decode($data['model']);

    // Remove the "data:image/png;base64," prefix
    $thumbnailBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $data['thumbnail']);
    $thumbnailData = base64_decode($thumbnailBase64);

    $db = new SQLite3('models.db');
    $db->exec("CREATE TABLE Assets (
	AssetID	INTEGER,
	BaseID	INTEGER NOT NULL,
	Uploader	TEXT NOT NULL,
	UploadDate	DATE NOT NULL,
	LastUpdated	TEXT,
	Dimensions	TEXT NOT NULL,
	Model	BLOB NOT NULL,
	License	BLOB,
	Version	INTEGER NOT NULL,
	Status	TEXT,
	Thumbnail	BLOB NOT NULL,
	PRIMARY KEY("AssetID" AUTOINCREMENT),
	FOREIGN KEY("BaseID") REFERENCES "AssetBase"("BaseID") ON DELETE CASCADE
);");

    $stmt = $db->prepare("INSERT INTO models (name, model, thumbnail) VALUES (:name, :model, :thumbnail)");
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':model', $modelData, SQLITE3_BLOB);
    $stmt->bindValue(':thumbnail', $thumbnailData, SQLITE3_BLOB);
    $stmt->execute();

    echo "Saved!";
} else {
    echo "Missing fields.";
}
?>
