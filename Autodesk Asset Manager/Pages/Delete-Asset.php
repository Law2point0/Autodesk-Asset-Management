<?php
session_start();

if (!isset($_SESSION['UserID']) || ($_SESSION["AccessLevel"] != "Admin" && $_SESSION["AccessLevel"] != "Manager")) {
    // Redirect unauthorized users
    header("Location: View-Asset.php");
    exit;
}

if (isset($_GET['BaseID'])) {
    $BaseID = $_GET['BaseID'];

    $db = new SQLite3('Asset-Manager-DB.db');

    try {
        $db->exec('BEGIN TRANSACTION');

        $stmt = $db->prepare("DELETE FROM ProjectAssets WHERE BaseID = :BaseID");
        $stmt->bindValue(':BaseID', $BaseID, SQLITE3_INTEGER);
        $stmt->execute();

        $stmt = $db->prepare("DELETE FROM Assets WHERE BaseID = :BaseID");
        $stmt->bindValue(':BaseID', $BaseID, SQLITE3_INTEGER);
        $stmt->execute();

        $stmt = $db->prepare("DELETE FROM AssetComments WHERE BaseID = :BaseID");
        $stmt->bindValue(':BaseID', $BaseID, SQLITE3_INTEGER);
        $stmt->execute();


        $stmt = $db->prepare("DELETE FROM AssetBase WHERE BaseID = :BaseID");
        $stmt->bindValue(':BaseID', $BaseID, SQLITE3_INTEGER);
        $stmt->execute();


        $db->exec('COMMIT');


        header("Location: View-Assets-List.php");
        exit;
    } catch (Exception $e) {

        $db->exec('ROLLBACK');
        echo "Failed to delete the asset: " . $e->getMessage();
    }

    $db->close();
} else {
    echo "No BaseID provided.";
}
?>