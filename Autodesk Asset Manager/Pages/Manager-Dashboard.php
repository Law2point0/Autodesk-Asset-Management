<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manager Dashboard</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<body>
    <?php
    include ("Navbar.php");
    ?>
    <main>
        <div class="container">
            <div class="left-panel">
                <a href="#" class="back-button">← Back</a>
            </div>
        </div>
    </main>
</body>



<div class="container mt-4">
<h1 class="text-center">Manager Dashboard</h1>
<div class="row mt-5">
<div class="col-md-3">
<div class="card text-center">
<div class="card-body">
<p class="card-text">Manage project members.</p>
<a href="Assign_Editors.php" class="btn btn-primary">Go to manage members</a>
</div>
</div>
</div>




<div class="col-md-3">
<div class="card text-center">
<div class="card-body">
<h5 class="card-title">Assign users</h5>
<p class="card-text">View, add, edit, and a user.</p>
<a href="View-Projects.php" class="btn btn-primary">Go to view projects</a>
</div>
</div>
</div>
</div>
</div>
</body>
</html>
