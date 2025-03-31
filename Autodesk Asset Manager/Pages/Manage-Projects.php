<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        form {
            width: 300px;
            margin: auto;
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
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        include("NavBar.php");
    ?>
    <main>
        <div class="container">
            
            <div class="main">
                <h2>Manage Projects</h2><br>
                    <form action="#" method="post">
                    <label for="ProjectID">Project ID</label><br>
                    <input type="number" id="ProjectID" name="ProjectID" readonly><br>
                    <label for="ProjectName">Project Name</label><br>
                    <input type="text" id="ProjectName" name="ProjectName" required><br>
                    <label for="Description">Description</label><br>
                    <input type="text" id="Description" name="Description"><br>
                    <label for="ProjectManager">Manager</label><br>
                    <input type="number" name="ProjectManager" id="ProjectManager"><br>
                    <button type="submit">Update Project</button>
                </form>
            </div>
        </div>
</main>
</body>
</html>