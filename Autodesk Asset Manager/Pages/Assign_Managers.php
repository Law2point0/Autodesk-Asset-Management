<?php
include __DIR__ . '/NavBar.php';

$db = new SQLite3(__DIR__ . '/../Asset-Manager-DB.db');
$db->exec('PRAGMA foreign_keys = ON;');

// Assign project manager by updating the ProjectManager field
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign_manager'])) {
    $project_id = (int)$_POST['project_id'];
    $manager_id = (int)$_POST['manager_id'];

    $stmt = $db->prepare('UPDATE Project SET ProjectManager = :manager_id WHERE ProjectID = :project_id');
    $stmt->bindValue(':project_id', $project_id, SQLITE3_INTEGER);
    $stmt->bindValue(':manager_id', $manager_id, SQLITE3_INTEGER);
    $stmt->execute();

    header('Location: Assign_Managers.php');
    exit;
}

// Unassign a manager by setting ProjectManager to NULL
if (isset($_GET['remove_id'])) {
    $remove_id = (int)$_GET['remove_id'];

    $stmt = $db->prepare('UPDATE Project SET ProjectManager = NULL WHERE ProjectID = :project_id');
    $stmt->bindValue(':project_id', $remove_id, SQLITE3_INTEGER);
    $stmt->execute();

    header('Location: Assign_Managers.php');
    exit;
}

// Fetch all projects and their assigned managers
$result = $db->query('
    SELECT 
        p.ProjectID, 
        p.ProjectName, 
        u.FName || " " || u.LName AS ManagerName,
        p.ProjectManager 
    FROM Project p
    LEFT JOIN User u ON p.ProjectManager = u.UserID
');
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
    <label>Project ID</label>
    <input type="number" name="project_id" class="form-control" required>
</div>
<div class="form-group">
    <label>Manager (User) ID</label>
    <input type="number" name="manager_id" class="form-control" required>
</div>
<button type="submit" name="assign_manager" class="btn btn-primary">Assign Manager</button>
<a href="Admin-Dashboard.php" class="btn btn-secondary">Back</a>
</form>

<h3 class="text-primary">Assigned Managers</h3>
<table class="table table-bordered table-striped mt-3">
<thead class="thead-dark">
<tr>
<th>Project ID</th>
<th>Project Name</th>
<th>Manager ID</th>
<th>Manager Name</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php while($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
<tr>
<td><?= $row['ProjectID'] ?></td>
<td><?= htmlspecialchars($row['ProjectName']) ?></td>
<td><?= $row['ProjectManager'] ?? 'Unassigned' ?></td>
<td><?= htmlspecialchars($row['ManagerName'] ?? 'N/A') ?></td>
<td>
    <?php if ($row['ProjectManager']): ?>
        <a href="Assign_Managers.php?remove_id=<?= $row['ProjectID'] ?>" class="btn btn-danger btn-sm">Unassign</a>
    <?php else: ?>
        <span class="text-muted">No manager</span>
    <?php endif; ?>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
</body>
</html>
