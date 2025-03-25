<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .Thumbnail img {
            width: 100%;
            height: 100%;
        }
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
                .table-container {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;

                    max-width: 1300px; 
                    margin: 0 auto; 
                }

    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>View Asset</title>
</head>
<body>
    <?php
        include("NavBar.php");
    ?>
    <main>
        <a href="javascript:history.back()" class="back-button">← Back</a>
        <div class="table-container">
            <div style="overflow-x:auto;">
            <table>
                <tr>
                    <th>Asset ID</th>
                    <th>Thumbnail</th>
                    <th>Asset Name</th>
                    <th>Status</th>
                    <th>Dimensions(Height, Width, Depth (cm))</th>
                    <th>Version</th>
                    <th>Last Updated</th>
                    <th>Uploaded By</th>
                    <th>Upload Date</th>
                    <th>Action</th>
                    
                </tr>

                <tr>
                    <td>1</td>
                    <td class="Thumbnail"><img src="..\Thumbnails\Benchy.jpeg" alt="Benchy 3D Model"></td>
                    <td>Benchy 2</td>
                    <td>In Progress</td>
                    <td>5x7x4</td>
                    <td>1</td>
                    <td>20/03/2025</td>
                    <td>Myles Bradley</td>
                    <td>17/03/2025</td>
                    <td> <a href='View-Asset.php'> View Asset </a> </td>
                </tr>
            </table>
            </div>

            <div class="right-panel">
                <h3>Comments</h3>
                <input type="text">
                <div class="actions">
                    <button class="submit-btn">Submit</button>
                </div>
            </div>


            </div>
    </main>
</body>
<footer></footer>
</html>