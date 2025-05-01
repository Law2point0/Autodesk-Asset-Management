<?php session_start() ?>

<?php
if (isset($_POST['submitComment'])) {
    $db = new SQLite3('Asset-Manager-DB.db');
    echo "<!-- DEBUG: Database connected -->";

    $UserID = $_SESSION['UserID'];    // User ID from session
    $BaseID = $_SESSION['BaseID'];    // BaseID from session
    $Comment = $_POST['comment'];     // Comment from form
    $Date = date('Y-m-d H:i:s');      // Current date/time

    
    $insertCommentQuery = $db->prepare("INSERT INTO Comment (UserID, Comment, Date) VALUES (:userid, :comment, :date)");
    $insertCommentQuery->bindValue(':userid', $UserID, SQLITE3_INTEGER);
    $insertCommentQuery->bindValue(':comment', $Comment, SQLITE3_TEXT);
    $insertCommentQuery->bindValue(':date', $Date, SQLITE3_TEXT);
    $insertCommentQuery->execute();


    $CommentID = $db->lastInsertRowID();

    
    $insertCommentLinkQuery = $db->prepare("INSERT INTO AssetComments (CommentID, BaseID) VALUES (:commentid, :baseid)");
    $insertCommentLinkQuery->bindValue(':commentid', $CommentID, SQLITE3_INTEGER);
    $insertCommentLinkQuery->bindValue(':baseid', $BaseID, SQLITE3_INTEGER);
    $insertCommentLinkQuery->execute();

    
    header("Location: View-Asset.php?assetName=$BaseID");
    exit();
}
?>