<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    // Redirect back to login page if no session is found or Access is wrong. Replace the "Admin" with whatever is appropriate for the page.
    header("Location: http://localhost/Autodesk-Asset-Management/Autodesk%20Asset%20Manager/Pages/Login.php");
    exit;
}
?>
<html lang="en">
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            min-width: 400px;
            border-radius: 5px 5px 0 0;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            }

            thead tr {
                background-color: grey;
                color: #ffffff;
                text-align: left;
                }
                
                th {
                 padding: 12px 15px;
                }

                td {
                 text-align: center;
                  padding: 12px 15px;
                }

                tbody tr {
                  border-bottom: 1px solid #dddddd;
                }

                tbody tr:nth-of-type(even) {
                  background-color:rgb(182, 223, 250);
                }

                tbody tr:last-of-type {
                  border-bottom: 2px solid skyblue;
                }

    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>View Projects</title>
</head>
<body>
    <?php
    include ("Navbar.php");
    ?>
    <main>
    <a href="javascript:history.back()" class="back-button">← Back</a>
       
        <div>
            <?php
                $db = new SQLITE3("Asset-Manager-DB.db");
                $UserID = 1;/*$_SESSION['UserID'];*/
                $select_query = "SELECT * FROM Assignment LEFT JOIN Project ON Assignment.ProjectID = Project.ProjectID WHERE Assignment.USERID = $UserID";
                $result = $db->query($select_query);
                echo "<table>";
                echo "<tr> <th>Project ID</th> <th>Project Name</th> <th>Project Description</th> <th>Project Manager</th> <th> Action </th></tr>";

                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    $ProjectID=$row['ProjectID'];
                    $ProjectName= $row['ProjectName'];
                    $ProjectDescription= $row['ProjectDescription'];
                    $ProjectManager= $row['ProjectManager'];
                    echo "<tr>
                            <td><h1>$ProjectID</h1></td>
                            <td>$ProjectName</td>
                            <td>$ProjectDescription</td>
                            <td>$ProjectManager</td>
                            <td>
                                <a href='set-project-id.php?ProjectID=$ProjectID'>
                                    <button class='submit-btn'>view</button>
                                </a>                                
                            </td>
                        </tr>";
                }
                echo "</table>";
                $db->close();
            ?>
            </div>
    </main>
</body>
</html>