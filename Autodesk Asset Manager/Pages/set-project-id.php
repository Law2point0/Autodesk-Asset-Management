<?php
session_start(); // Start the session

if (isset($_GET['ProjectID'])) {
    $_SESSION['ProjectID'] = $_GET['ProjectID'];
    header("Location: View-Assets-list.php");
    exit();
}
?>
