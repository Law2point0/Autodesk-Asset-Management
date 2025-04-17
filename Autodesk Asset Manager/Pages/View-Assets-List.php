<?php
    session_start();
?>

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
            <?php
            $db = new SQLITE3('Asset-Manager-DB.db');
            $UserID = 1;/*$_SESSION['UserID'];*/
            $ProjectID = $_SESSION['ProjectID'];
            if ($db) {
                echo 'db connected successfully';
            }
            else {
                echo 'db not connected';
            }
            $select_query = "SELECT * FROM Assets 
            LEFT JOIN ProjectAssets ON Assets.AssetID = ProjectAssets.AssetID
            WHERE ProjectAssets.ProjectID = $ProjectID;";
            $result = $db->query($select_query);

            echo"
            <table>
                <tr>
                    <th>Asset ID</th>
                    <th>Thumbnail</th>
                    <th>Asset Name</th>
                    <th>Status</th>
                    <th>Dimensions(Quality)</th>
                    <th>Version</th>
                    <th>Last Updated</th>
                    <th>Uploaded By</th>
                    <th>Upload Date</th>
                    <th>Action</th>
                    
                </tr>";

                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    $AssetID = $row['AssetID'];
                    $Thumbnail = $row['Thumbnail'];
                    $AssetName = $row['AssetName'];
                    $Status = $row['Status'];
                    $Dimensions = $row['Dimensions'];
                    $Version = $row['Version'];
                    $LastUpdated = $row['LastUpdated'];
                    $UploadedBy = $row['Uploader'];
                    $UploadDate = $row['UploadDate'];

                    echo"<tr>
                            <td>$AssetID</td>
                            <td>$Thumbnail</td>
                            <td>$AssetName</td>
                            <td>$Status</td>
                            <td>$Dimensions</td>
                            <td>$Version</td>
                            <td>$LastUpdated</td>
                            <td>$UploadedBy</td>
                            <td>$UploadDate</td>
                            <div class='actions'>
                                <td> <input class='submit-btn' type='submit' value='View Asset'> <!--<a href='View-Asset.php'> View Asset </a>--> </td>
                            </div>
                    </tr>";
                } 
                echo"</table>";
            ?>
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