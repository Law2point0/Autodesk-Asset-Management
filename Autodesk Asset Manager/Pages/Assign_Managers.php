<?php
include __DIR__ . '/NavBar.php';
$db = new SQLite3(__DIR__ . '/../Autodesk database_2.db');
$db->exec('PRAGMA foreign_keys = ON;');
if ($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['assign_manager'])){
$project_name=trim($_POST['project_name']);
$manager_id=(int)$_POST['manager_id'];
$stmt=$db->prepare('INSERT INTO assigned_managers(project_name,manager_id)VALUES(:project_name,:manager_id)');
$stmt->bindValue(':project_name',$project_name,SQLITE3_TEXT);
$stmt->bindValue(':manager_id',$manager_id,SQLITE3_INTEGER);
$stmt->execute();
header('Location:Assign_Managers.php');
exit;
}
if(isset($_GET['remove_id'])){
$remove_id=(int)$_GET['remove_id'];
$stmt=$db->prepare('DELETE FROM assigned_managers WHERE id=:id');
$stmt->bindValue(':id',$remove_id,SQLITE3_INTEGER);
$stmt->execute();
header('Location:Assign_Managers.php');
exit;
}
$result=$db->query('SELECT * FROM assigned_managers');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Assign Managers</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<h2 class="text-center text-primary">Assign a Manager</h2>
<form method="POST" class="card shadow p-4 mb-5">
<div class="form-group">
<label>Project Name</label>
<input type="text" name="project_name" class="form-control" required>
</div>
<div class="form-group">
<label>Manager ID</label>
<input type="number" name="manager_id" class="form-control" required>
</div>
<button type="submit" name="assign_manager" class="btn btn-primary">Assign Manager</button>
<a href="Admin-Dashboard.php" class="btn btn-secondary">Back</a>
</form>
<h3 class="text-primary">Assigned Managers</h3>
<table class="table table-bordered table-striped mt-3">
<thead class="thead-dark">
<tr>
<th>ID</th>
<th>Project Name</th>
<th>Manager ID</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php while($row=$result->fetchArray(SQLITE3_ASSOC)):?>
<tr>
<td><?= $row['id']?></td>
<td><?= htmlspecialchars($row['project_name'])?></td>
<td><?= $row['manager_id']?></td>
<td><a href="Assign_Managers.php?remove_id=<?= $row['id']?>" class="btn btn-danger btn-sm">Remove</a></td>
</tr>
<?php endwhile;?>
</tbody>
</table>
</div>
</body>
</html>

