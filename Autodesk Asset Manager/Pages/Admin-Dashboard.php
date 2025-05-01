<?php
session_start();
$db = new SQLite3('Autodesk database_2.db');

session_start();
if (!isset($_SESSION['UserID']) || $_SESSION['AccessLevel'] !== "Admin") {
    // Redirect back to login page if no session is found or Access is wrong. Replace the "Admin" with whatever is appropriate for the page.
    header("Location: http://localhost/Autodesk-Asset-Management/Autodesk%20Asset%20Manager/Pages/Login.php");
    exit;
}

$totalProjects = $db->querySingle("SELECT COUNT(*) FROM projects");
$completedProjects = $db->querySingle("SELECT COUNT(*) FROM projects WHERE status = 'completed'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Admin Dashboard</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
<style>
body { padding: 2rem; }
.card { box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
</style>
</head>
<body>
<?php include("Navbar.php"); ?>
<div class="container">
<h1 class="text-center mb-4">Admin Dashboard</h1>
<div class="row mb-4">
<div class="col-md-3 mb-4">
<div class="card text-center h-100">
<div class="card-body d-flex flex-column justify-content-between">
<p class="card-text">Assign an editor.</p>
<a href="Assign_Editors.php" class="btn btn-primary mt-3">Go to assign</a>
</div>
</div>
</div>
<div class="col-md-3 mb-4">
<div class="card text-center h-100">
<div class="card-body d-flex flex-column justify-content-between">
<h5 class="card-title">View assigned projects</h5>
<p class="card-text">View, add, edit, and delete assigned projects.</p>
<a href="View-Asset.php" class="btn btn-primary mt-3">Manage projects</a>
</div>
</div>
</div>
<div class="col-md-3 mb-4">
<div class="card text-center h-100">
<div class="card-body d-flex flex-column justify-content-between">
<h5 class="card-title">Assign managers</h5>
<p class="card-text">View, add, edit, and assign a manager.</p>
<a href="Assign_Managers.php" class="btn btn-primary mt-3">Assign manager</a>
</div>
</div>
</div>
<div class="col-md-3 mb-4">
<div class="card text-center h-100">
<div class="card-body d-flex flex-column justify-content-between">
<h5 class="card-title">Assign users</h5>
<p class="card-text">View, add, edit, and assign a user.</p>
<a href="assignuser.php" class="btn btn-primary mt-3">Assign user</a>
</div>
</div>
</div>
</div>
<div class="row justify-content-center">
<div class="col-md-3">
<div class="card text-center border-success h-100">
<div class="card-body d-flex flex-column justify-content-between">
<div>
<h5 class="card-title text-success">Projects</h5>
<p class="card-text">Total: <strong><?php echo $totalProjects; ?></strong></p>
<p class="card-text">Completed: <strong><?php echo $completedProjects; ?></strong></p>
</div>
<a href="View-Projects.php" class="btn btn-success mt-3">View All Projects</a>
</div>
</div>
</div>
</div>
</div>
</body>
</html>



