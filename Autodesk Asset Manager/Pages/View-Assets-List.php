<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .upload-button{
          color: white;
          background-color: black;
          font-size: 16px;
          padding: 7px 32px;
          font-weight: bold;
        }

        .right-lock {
        display: flex;
        justify-content: right;
        align-items: right;
        height: 30px;
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
    <div class="right-lock">
    <button class="upload-button"> Upload </button>
    </div>
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