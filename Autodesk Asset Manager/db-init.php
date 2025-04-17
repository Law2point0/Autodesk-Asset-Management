<?php

$db = ('Asset-Manager-DB.db');
$query = "SELECT name FROM sqlite_master WHERE type='table' ";

function generateDB($db)
{
    if (file_exists($db)) {
        echo "Database already exists.<br>";
    } else {
        echo "Database does not exist. Creating database...<br>";
        generateTables($db);
        insertData($db);
        //resetData($db);
    }
}




function generateTables($db){
    try {
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
            "BaseID" INTEGER NOT NULL,
            "LastUpdated" TEXT,
            "Uploader" TEXT NOT NULL,
            "UploadDate" DATE NOT NULL,
            "Dimensions" TEXT NOT NULL,
            "AssetFile" BLOB NOT NULL,
            "License" BLOB,
            "Version" INTEGER NOT NULL,
            "Status" TEXT,
            "Thumbnail" TEXT NOT NULL,
            FOREIGN KEY("BaseID") REFERENCES "AssetBase"("BaseID")
        );

        CREATE TABLE "AssetBase" (
            "BaseID" INTEGER PRIMARY KEY AUTOINCREMENT,
            "AssetName" TEXT NOT NULL
        );

        CREATE TABLE "AssetsTags" (
            "AssetID" INTEGER NOT NULL,
            "TagID"	INTEGER NOT NULL,
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
            "AccessLevel" TEXT NOT NULL,
            "Password" TEXT NOT NULL,
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
}

function insertData($db){
    try {
        $pdo = new PDO("sqlite:" . $db);
        echo "Database connected successfully.<br>";

        $sql ="
        INSERT INTO 'User' (AccessLevel, Password, FName, LName, Email) VALUES
        ('Admin', 'hashed_password_1', 'John', 'Doe', 'john.doe@example.com'),
        ('Manager', 'hashed_password_2', 'Jane', 'Smith', 'jane.smith@example.com'),
        ('Editor', 'hashed_password_3', 'Alice', 'Johnson', 'alice.johnson@example.com');

        INSERT INTO 'Project' (ProjectID, ProjectName, ProjectDescription, ProjectManager) VALUES
        (1, 'Ocean', 'Ocean themed assets for the sea people', 1),
        (2, 'Marketing Campaign', 'Digital marketing push for product launch', 2);

        INSERT INTO 'Assignment' (ProjectID, UserID, AccessLevel) VALUES
        (1, 1, 'Admin'),
        (1, 2, 'Manager'),
        (2, 3, 'Editor');

        INSERT INTO Assets (BaseID, LastUpdated, Uploader, UploadDate, Dimensions, AssetFile, License, Version, Status, Thumbnail) VALUES
        (1, '2025-01-15', 'Myles Bradley', '2025-01-15', '1920x1080', x'FFD8FFE0', x'00010203', 1, 'Approved', 'thumbnail1.jpg'),
        (1, '2025-02-28', 'Myles Bradley', '2025-02-28', '1920x1080', x'FFD8FFE0', x'00010203', 2, 'Approved', 'thumbnail1.jpg'),
        (2, '2025-02-19', 'Jane Smith', '2025-02-19', '500x500', x'FFD8FFE1', x'00040506', 1, 'Pending', 'thumbnail2.jpg');

        INSERT INTO AssetBase (AssetName) VALUES
        ('Benchy'),
        ('Buoy');

        INSERT INTO 'Tags' (TagID, TagName, AssetID) VALUES
        (1, 'Marketing', 1),
        (2, 'Graphics', 2);

        INSERT INTO 'AssetsTags' (AssetID, TagID) VALUES
        (1, 1),
        (2, 2);

        INSERT INTO 'Comment' (UserID, Comment, Date) VALUES
        (1, 'Looks great! Ready for approval.', '2025-03-02'),
        (2, 'Needs a slight color change.', '2025-02-21');

        INSERT INTO 'AssetComments' (CommentID, AssetID) VALUES
        (1, 1),
        (2, 1);

        INSERT INTO 'ProjectAssets' (AssetID, ProjectID) VALUES
        (1, 1),
        (2, 1);";

        $pdo->exec($sql);
        echo "Data inserted successfully.<br>";
    }
    catch (PDOException $e) {
        die("Insert error: " . $e->getMessage());
    }
}

function resetData($db) {
    try {
        $pdo = new PDO("sqlite:" . $db);
        echo "Database connected successfully.<br>";

        // SQL to clear all data from the tables
        $sql = "
        DELETE FROM AssetComments;
        DELETE FROM AssetsTags;
        DELETE FROM Tags;
        DELETE FROM Assets;
        DELETE FROM Assignment;
        DELETE FROM Comment;
        DELETE FROM ProjectAssets;
        DELETE FROM Project;
        DELETE FROM User;
        ";

        $pdo->exec($sql);
        echo "All data cleared successfully.<br>";

        // Repopulate the tables
        insertData($db);
    } catch (PDOException $e) {
        die("Reset error: " . $e->getMessage());
    }
}

?>