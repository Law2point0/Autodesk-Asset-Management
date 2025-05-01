<?php
include("NavBar.php");

$db_file = 'Asset-Manager-DB.db';

try {
    $conn = new SQLite3($db_file);
    $conn->exec('PRAGMA foreign_keys = ON;');
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}

// Assign an editor to a project
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["assign_editor"])) {
    $project_id = $_POST["project_id"];
    $user_id = $_POST["user_id"];
    $access_level = $_POST["access_level"];

    $stmt = $conn->prepare("INSERT INTO Assignment (ProjectID, UserID, AccessLevel) VALUES (:project_id, :user_id, :access_level)");
    $stmt->bindValue(':project_id', $project_id, SQLITE3_TEXT);
    $stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
    $stmt->bindValue(':access_level', $access_level, SQLITE3_TEXT);
    $stmt->execute();
}

// Remove an assigned editor
if (isset($_GET["remove_user"]) && isset($_GET["remove_project"])) {
    $remove_user = $_GET["remove_user"];
    $remove_project = $_GET["remove_project"];

    $stmt = $conn->prepare("DELETE FROM Assignment WHERE UserID = :user_id AND ProjectID = :project_id");
    $stmt->bindValue(':user_id', $remove_user, SQLITE3_INTEGER);
    $stmt->bindValue(':project_id', $remove_project, SQLITE3_TEXT);
    $stmt->execute();
    header("Location: Assign_Editors.php");
    exit();
}

// Fetch current assignments with project and user info
$query = "
    SELECT a.ProjectID, p.ProjectName, u.UserID, u.FName || ' ' || u.LName AS FullName, a.AccessLevel
    FROM Assignment a
    JOIN Project p ON a.ProjectID = p.ProjectID
    JOIN User u ON a.UserID = u.UserID
";
$results = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Assign Editor</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center text-primary">Assign an Editor</h2>
    <div class="card shadow p-4">
        <form method="POST">
            <div class="form-group">
                <label>Project ID</label>
                <input type="text" name="project_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label>User ID</label>
                <input type="number" name="user_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Access Level</label>
                <select name="access_level" class="form-control" required>
                    <option value="Editor">Editor</option>
                    <option value="Viewer">Viewer</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <button type="submit" name="assign_editor" class="btn btn-primary">Assign Editor</button>
            <a href="Admin-Dashboard.php" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <h3 class="mt-5 text-primary">Current Assignments</h3>
    <table class="table table-bordered table-striped mt-3">
        <thead class="thead-dark">
        <tr>
            <th>Project ID</th>
            <th>Project Name</th>
            <th>User ID</th>
            <th>User Name</th>
            <th>Access Level</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $results->fetchArray(SQLITE3_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row["ProjectID"]); ?></td>
                <td><?php echo htmlspecialchars($row["ProjectName"]); ?></td>
                <td><?php echo htmlspecialchars($row["UserID"]); ?></td>
                <td><?php echo htmlspecialchars($row["FullName"]); ?></td>
                <td><?php echo htmlspecialchars($row["AccessLevel"]); ?></td>
                <td>
                    <a href="Assign_Editors.php?remove_user=<?php echo $row['UserID']; ?>&remove_project=<?php echo $row['ProjectID']; ?>" class="btn btn-danger btn-sm">Remove</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
