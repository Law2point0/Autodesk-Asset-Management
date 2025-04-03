<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>View Asset</title>
</head>
<body>
    <?php
        include("NavBar.php");
    ?>
    <main>
        
        <div style="display: flex; flex-direction: column;">
            <ul>
                <li><a href="Login.php">Login Page</a></li>
                <li><a href="Admin-Dashboard.php">Admin-Dashboard</a></li>
                <li><a href="Manager-Dashboard.php">Manager-Dashboard</a></li>
                <li><a href="View-Assets-Grid.php">View-Assets-Grid</a></li>
                <li><a href="View-Assets-List.php">View-Assets-List</a></li>
                <li><a href="View-Asset.php">Asset Page</a></li>
                <li><a href="View-Projects.php">Project Page</a></li>
                <li><a href="Manage-Projects.php">Manage Projects Page</a></li>
                <li></li>
            </ul>
            <form method="post" action="">
                <button type="submit" name="generateDB" >Generate DB</button>
                <button type="submit" name="resetData">Reset DB Data</button>
            </form>
        </div>
    </main>
</body>
<footer></footer>
</html>

<?php
    include("../db-init.php");
    // Check if the buttons are clicked and call the respective functions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['generateDB'])) {
            generateDB($db); // Call the generateTables function
        }
        if (isset($_POST['resetData'])) {
            resetData($db); // Call the resetData function
        }
    }
?>