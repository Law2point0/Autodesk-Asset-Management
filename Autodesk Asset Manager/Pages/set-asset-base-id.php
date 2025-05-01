<?php
session_start();

if (isset($_GET['BaseID'])) {
    $_SESSION['BaseID'] = $_GET['BaseID'];
    header("Location: View-Asset.php");
    exit;
} else {
    echo "BaseID not provided.";
}
?>