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

    <div class="left-lock">
    <a href="http://localhost/Autodesk-Asset-Management/Autodesk%20Asset%20Manager/Pages/View-Assets-Grid.php"><button class="upload-button">Switch to grid view</button></a>
    </div>
    <main>
        <a href="javascript:history.back()" class="back-button">← Back</a>
        <div class="table-container">
            <div style="overflow-x:auto;">
            <?php
            $db = new SQLITE3('Asset-Manager-DB.db');
            $UserID = $_SESSION['UserID'];
            $ProjectID = $_SESSION['ProjectID'];
            if ($db) {
                echo 'db connected successfully';
            }
            else {
                echo 'db not connected';
            }
            $select_query = "SELECT * FROM Assets 
            LEFT JOIN ProjectAssets ON AssetBase.BaseID = ProjectAssets.BaseID
            LEFT JOIN AssetBase ON Assets.BaseID = AssetBase.BaseID
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
                    $ThumbnailLink = "..\\Thumbnails\\";
                    $ThumbnailLink .=$Thumbnail;
                    $BaseID = $row['BaseID'];
                    echo"<tr>
                            <td>$AssetID</td>
                            <td class='Thumbnail'>Thumbnail</td>".
                            //<td class='Thumbnail'><img src='$ThumbnailLink' width='100' height='100'></td>"
                            "<td>$AssetName</td>
                            <td>$Status</td>
                            <td>$Dimensions</td>
                            <td>$Version</td>
                            <td>$LastUpdated</td>
                            <td>$UploadedBy</td>
                            <td>$UploadDate</td>
                            <div class='actions'>
                                <td> 
                                    <a href='set-base-id.php?BaseID=$BaseID'>
                                        <button class='submit-btn'> View Asset </button>
                                    </a> 
                                </td>
                            </div>
                    </tr>";
                } 
                echo"</table>";
            ?>
            </div>

            <!-- Comments don't work for some reason.-->
            <!--<div class='right-panel'>
                <h3>Comments</h3>
                <input type='text'>
                <div class='actions'>
                    <button class='submit-btn'>Submit</button>
                </div>
                    <?php /* 
                    $select_comments = 'SELECT * FROM Comment
                    LEFT JOIN AssetComments ON Comment.CommentID = AssetComments.CommentID;';
                    $comment_result = $db->query($select_comments);
                    echo"
                    <table>
                        <tr>
                            <th>User ID</th>
                            <th>Comment</th>
                            <th>Date commented</th>                   
                        </tr>";

                while ($row = $comment_result->fetchArray(SQLITE3_ASSOC)) {
                    $UserID = $row['UserID'];
                    $Comment = $row['Comment'];
                    $Date = $row['Date'];

                    echo"<tr>
                            <td>$UserID</td>
                            <td>$Comment</td>
                            <td>$Date</td>
                    </tr>";
                } 
                echo"</table>";*/
                    ?>-->
                    
                </div>


            </div>
    </main>
</body>
<footer></footer>
</html>