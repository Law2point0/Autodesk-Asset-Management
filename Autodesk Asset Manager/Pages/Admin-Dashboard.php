<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("NavBar.php"); ?>

<div class="container mt-4">
<h1 class="text-center">Admin Dashboard</h1>
<div class="row mt-5">
<div class="col-md-3">
<div class="card text-center">
<div class="card-body">
<p class="card-text">Assign an editor.</p>
<a href="assigneditor.php" class="btn btn-primary">Go to assign</a>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-center">
<div class="card-body">
<h5 class="card-title">View assigned projects</h5>
<p class="card-text">View, add, edit, and delete assigned projects.</p>
<a href="View-Asset.php" class="btn btn-primary">Go to Manage projects</a>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-center">
<div class="card-body">
<h5 class="card-title">Assign managers</h5>
<p class="card-text">View, add, edit, and a manager.</p>
<a href="assignmanager.php" class="btn btn-primary">Go to assign a manager</a>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-center">
<div class="card-body">
<h5 class="card-title">Assign users</h5>
<p class="card-text">View, add, edit, and a user.</p>
<a href="assignuser.php" class="btn btn-primary">Go to assign a user</a>
</div>
</div>
</div>
</div>
</div>
</body>
</html>

