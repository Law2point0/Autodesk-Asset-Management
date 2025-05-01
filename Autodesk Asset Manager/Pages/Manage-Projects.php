<?php
    session_start();

if (!isset($_SESSION['UserID'])) {
  // Redirect back to login page if no session is found or Access is wrong. 
  header("Location: http://localhost/Autodesk-Asset-Management/Autodesk%20Asset%20Manager/Pages/Login.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        form {
            width: 300px;
            margin: -10px;
            padding: 20px;
            border-radius: 8px;
        }
        input {
            width: 100%;
            height: 30px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;

        }
        .centre-panel {
            background-color: #E9E9E9;
            width: 100%;
            height: 100%;
            padding: 20px;
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include("NavBar.php");
        $ProjectIDParam = $_SESSION['ProjectID'];
        $db = new SQLite3('Asset-Manager-DB.db');
        $stmt= $db->prepare("SELECT * FROM Project WHERE ProjectID = :projectid");
        $stmt->bindvalue(':projectid', $ProjectIDParam, SQLITE3_INTEGER);
        $result= $stmt->execute();
        $row= $result->fetchArray(SQLITE3_ASSOC);
        $ProjectID= $row['ProjectID'];
        $ProjectName= $row['ProjectName'];
        $ProjectDescription= $row['ProjectDescription'];
        $ProjectManager= $row['ProjectManager'];
        $db->close();
    ?>
    <main>
    <a href="javascript:history.back()" class="back-button">← Back</a>
        <div class="container">
            <div class="main">
                <div class="centre-panel">
                    <h2>Manage Projects</h2><br>
                        <form action="Manage-Projects-backend.php" method="post">
                        <input type="hidden" id="ProjectID" name="ProjectID"><br>
                        <label for="ProjectName">Project Name</label><br>
                        <input type="text" id="ProjectName" name="ProjectName" value= <?php echo $ProjectName; ?> placeholder= <?php echo $ProjectName; ?> required><br>
                        <label for="Description">Description</label><br>
                        <input type="text" id="Description" name="Description" value= <?php echo $ProjectDescription; ?> placeholder= <?php echo $ProjectDescription; ?>><br>
                        <label for="ProjectManager">Manager</label><br>
                        <input type="number" name="ProjectManager" id="ProjectManager" value= <?php echo $ProjectManager; ?> placeholder= <?php echo $ProjectManager; ?>><br>
                        <button type="submit">Update Project</button>
                        </form>
                </div>
            </div>
        </div>
</main>
</body>
</html>
