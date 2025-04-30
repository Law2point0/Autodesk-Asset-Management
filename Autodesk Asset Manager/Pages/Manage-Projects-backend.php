<?php
    session_start();
?>

<?php
    include("NavBar.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ProjectID = $_SESSION['ProjectID'];
        $ProjectName=$_POST['ProjectName'];
        $ProjectDescription=$_POST['Description'];
        $ProjectManager=$_POST['ProjectManager'];

        $db = new SQLite3('Asset-Manager-DB.db');

        $stmt = $db->prepare("UPDATE Project SET
                              ProjectName=:ProjectName,
                              ProjectDescription=:ProjectDescription,
                              ProjectManager=:ProjectManager
                              WHERE ProjectID=:ProjectID");
        $stmt->bindvalue(':ProjectName', $ProjectName, SQLITE3_TEXT);
        $stmt->bindvalue(':ProjectDescription', $ProjectDescription, SQLITE3_TEXT);
        $stmt->bindvalue(':ProjectManager', $ProjectManager, SQLITE3_INTEGER);

        if($stmt->execute())
            echo 'Project has been updated sucessfully!';
        else
            echo 'Error updating the Project.';
        $db->close();
    }
?>