<?php
    session_start();

    if (isset($_GET['AssetID'])) {
        $_SESSION['AssetID'] = $_GET['AssetID'];
        header("Location: View-Asset.php");
        exit();
    }
?>