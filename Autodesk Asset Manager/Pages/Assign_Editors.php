<?php
include("NavBar.php");
include("Autodesk database_2.db");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["assign_editor"])) {
    $project_name = $_POST["project_name"];
    $member_id = $_POST["member_id"];
    
    $sql = "INSERT INTO assigned_editors (project_name, member_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $project_name, $member_id);
    $stmt->execute();



<?php

$db_file = 'Autodesk database_2.db'; 

try {
    
    $conn = new SQLite3($db_file);
    
    $conn->exec('PRAGMA foreign_keys = ON;');
    echo "Connected successfully to the database.";
} catch (Exception $e) {
die("Connection failed: " . $e->getMessage());
}
?>
}


if (isset($_GET["remove_id"])) {
    $remove_id = $_GET["remove_id"];
    $sql = "DELETE FROM assigned_editors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $remove_id);
    $stmt->execute();
    header("Location: assign_editor.php");
    exit();
}


$result = $conn->query("SELECT * FROM assigned_editors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Assign Editor</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center text-primary">Assign an Editor</h2>
    <div class="card shadow p-4">
        <form method="POST">
            <div class="form-group">
                <label>Project Name</label>
                <input type="text" name="project_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Member ID</label>
                <input type="number" name="member_id" class="form-control" required>
            </div>
            <button type="submit" name="assign_editor" class="btn btn-primary">Assign Editor</button>
            <a href="Admin-Dashboard.php" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <h3 class="mt-5 text-primary">Assigned Editors</h3>
    <table class="table table-bordered table-striped mt-3">
        <thead class="thead-dark">
<tr>
<th>ID</th>
<th>Project Name</th>
<th>Member ID</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
<td><?php echo $row["id"]; ?></td>
<td><?php echo $row["project_name"]; ?></td>
<td><?php echo $row["member_id"]; ?></td>
<td>
<a href="assign_editor.php?remove_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Remove</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

</body>
</html>
