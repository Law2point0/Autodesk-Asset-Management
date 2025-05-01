<?php
session_start();

if (!isset($_SESSION['UserID']) || ($_SESSION["AccessLevel"] != "Admin" && $_SESSION["AccessLevel"] != "Manager")) {
    header("Location: View-Asset.php");
    exit;
}

if (isset($_POST['description']) && isset($_SESSION['BaseID'])) {
    $description = $_POST['description'];
    $BaseID = $_SESSION['BaseID'];

    // Connect to the database
    $db = new SQLite3('Asset-Manager-DB.db');

    // Update the description in the database
    $stmt = $db->prepare("UPDATE AssetBase SET AssetDescription = :description WHERE BaseID = :BaseID");
    $stmt->bindValue(':description', $description, SQLITE3_TEXT);
    $stmt->bindValue(':BaseID', $BaseID, SQLITE3_INTEGER);

    if ($stmt->execute()) {
        // Redirect back to the View-Asset page
        header("Location: View-Asset.php");
        exit;
    } else {
        echo "Failed to update the description.";
    }

    $db->close();
} else {
    echo "Invalid request.";
}
?>