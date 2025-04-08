<?php
session_start();
if (!isset($_SESSION['UserID']) || $_SESSION['AccessLevel'] !== "Admin") {
    // Redirect back to login page if no session is found or Access is wrong. Replace the "Admin" with whatever is appropriate for the page.
    header("Location: http://localhost/Autodesk-Asset-Management/Autodesk%20Asset%20Manager/Pages/Login.php");
    exit;
}
?>

<?php 
session_start();
$UserID = $_SESSION['UserID'];
$AccessLevel = $_SESSION['AccessLevel'];
?>