<?php
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['UserID']) || $_SESSION['AccessLevel'] !== 'Admin') {
    header("Location: http://localhost/Autodesk-Asset-Management/Autodesk%20Asset%20Manager/Pages/Login.php");
    exit;
}

if (!isset($_GET['ProjectID'])) {
    echo "No ProjectID provided.";
    exit;
}

$ProjectID = $_SESSION['ProjectID']; // Basic sanitization
// Open the database
$db = new SQLite3("Asset-Manager-DB.db");
if (!$db) {
    echo "Failed to open the database.";
    exit;
}

$stmt1 = $db->prepare("DELETE FROM Project WHERE ProjectID = :id");
$stmt1->bindValue(':id', $ProjectID, SQLITE3_INTEGER);
$result1 = $stmt1->execute();

$stmt2 = $db->prepare("DELETE FROM Project WHERE ProjectID = :id");
$stmt2->bindValue(':id', $ProjectID, SQLITE3_INTEGER);
$result2 = $stmt2->execute();

$stmt3 = $db->prepare("DELETE FROM Assignment WHERE ProjectID = :id");
$stmt3->bindValue(':id', $ProjectID, SQLITE3_INTEGER);
$result3 = $stmt3->execute();

if ($result1 && $result2 && $result3) {
    header("Location: View-Projects.php"); // Replace with the actual list page
    exit;
} else {
    echo "Failed to delete project.";
}

$db->close();
?>
