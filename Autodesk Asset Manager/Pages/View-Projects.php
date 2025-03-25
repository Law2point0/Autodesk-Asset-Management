<!DOCTYPE html>
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
    <title>View Projects</title>
</head>
<body>
    <?php
    include ("Navbar.php");
    ?>
    <main>
        <div class="container">
            <table>
                <tr>
                    <th>Project ID</th>
                    <th>Project Name</th>
                    <th>Project Description</th>
                    <th>Project Manager</th>
                </tr>

                <tr>
                    <th>1</th>
                    <th>The Benchy Project</th>
                    <th>I Love Benchy</th>
                    <th>John Benchy Project Creator of Benchy Project</th>
                    <td>
                    <div class="actions">
                        <a href="View-Assets-list.php">
                            <button class="submit-btn">view</button>
                        </a>
                    </div>
                    </td>
                </tr>
            </table>
        </div>
    </main>
</body>
</html>