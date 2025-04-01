<?php



$db = "Asset-Manager-DB.db";

try{
    $pdo = new PDO("sqlite:" . $db);
    echo "Database connected successfully.<br>";

    $sql =
    'CREATE TABLE "AssetComments" (
        "CommentID"	integer NOT NULL,
        "AssetID"	integer NOT NULL,
        PRIMARY KEY("CommentID","AssetID"),
        FOREIGN KEY("CommentID") REFERENCES "Comment"("CommentID"),
        FOREIGN KEY("AssetID") REFERENCES "Assets"("AssetID")
    );

    CREATE TABLE "Assets" ( 
        "AssetID" INTEGER PRIMARY KEY AUTOINCREMENT, 
        "AssetName" TEXT NOT NULL,
        "LastUpdated" TEXT,
        "Uploader" TEXT NOT NULL,
        "UploadDate" DATE NOT NULL,
        "Dimensions" TEXT NOT NULL,
        "AssetFile" BLOB NOT NULL,
        "License" blob,
        "Version" integer NOT NULL,
        "Status" TEXT,
        "Thumbnail" TEXT NOT NULL

    );

    CREATE TABLE "AssetsTags" (
        "AssetID"	INTEGER,
        "TagID"	INTEGER,
        PRIMARY KEY("AssetID","TagID"),
        FOREIGN KEY("AssetID") REFERENCES "Assets"("AssetID") ON UPDATE CASCADE,
        FOREIGN KEY("TagID") REFERENCES "Tags"("TagID") ON UPDATE CASCADE
    );

    CREATE TABLE "Assignment" (
        "ProjectID"	TEXT NOT NULL,
        "UserID"	integer NOT NULL,
        "AccessLevel"	TEXT NOT NULL,
        PRIMARY KEY("UserID","ProjectID"),
        FOREIGN KEY("ProjectID") REFERENCES  "Project"("ProjectID"),
        FOREIGN KEY("UserID") REFERENCES "User"("UserID")
    );

    CREATE TABLE "Comment" (
        "CommentID"	INTEGER,
        "UserID"	INTEGER NOT NULL,
        "Comment"	TEXT NOT NULL,
        "Date"	date NOT NULL,
        PRIMARY KEY("CommentID" AUTOINCREMENT)
        FOREIGN KEY("UserID") REFERENCES "User"("UserID") ON UPDATE CASCADE
    );

    CREATE TABLE "Project" (
        "ProjectID"	INTEGER,
        "ProjectName" TEXT NOT NULL,
        "ProjectDescription"	TEXT,
        "ProjectManager"	INTEGER,
        PRIMARY KEY("ProjectID")
    );

    CREATE TABLE "ProjectAssets" (
        "AssetID"	INTEGER NOT NULL,
        "ProjectID"	INTEGER NOT NULL,
        PRIMARY KEY("AssetID","ProjectID"),
        FOREIGN KEY("AssetID") REFERENCES "Assets"("AssetID") ON UPDATE CASCADE,
        FOREIGN KEY("ProjectID") REFERENCES "Project"("ProjectID") ON UPDATE CASCADE
    );

    CREATE TABLE "Tags" ( 
        "TagID" INTEGER PRIMARY KEY,
        "TagName" TEXT NOT NULL, 
        "AssetID" INTEGER NOT NULL, 
        FOREIGN KEY ("AssetID") REFERENCES "Assets"("AssetID")
    );

    CREATE TABLE "User" (
        "UserID"	INTEGER,
        "AccessLevel"	TEXT NOT NULL,
        "Password"	TEXT NOT NULL,
        "FName"	TEXT NOT NULL,
        "LName"	TEXT NOT NULL,
        "Email"	TEXT NOT NULL UNIQUE,
        PRIMARY KEY("UserID" AUTOINCREMENT)
    );';

    $pdo->exec($sql);
    echo "Tables created successfully.<br>";

}catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}


?>