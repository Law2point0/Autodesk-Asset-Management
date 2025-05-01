<?php session_start();

if (!isset($_SESSION['UserID'])) {
  // Redirect back to login page if no session is found or Access is wrong. 
  header("Location: http://localhost/Autodesk-Asset-Management/Autodesk%20Asset%20Manager/Pages/Login.php");
  exit;
} elseif (!isset($_SESSION['ProjectID'])){
  header("Location: http://localhost/Autodesk-Asset-Management/Autodesk%20Asset%20Manager/Pages/View-Projects.php");
  exit;
} elseif (!isset($_SESSION['BaseID'])) {
  header("Location: http://localhost/Autodesk-Asset-Management/Autodesk%20Asset%20Manager/Pages/View-Assets-List.php");
  exit;
          }

$BaseID = $_SESSION["BaseID"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
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
        <div class="panel-container">
            <div class="left-panel">
                <a href="javascript:history.back()" class="back-button">← Back</a>
                <div class="asset-display" max-width="100%">
                    <div class=asset-title-card>
                        <?php
                            if (isset($_SESSION["BaseID"])) {
                                //$BaseID = $_GET['assetName'];    
                                $BaseID = $_SESSION["BaseID"];                         
                            }               
                            //$BaseID = 8;
                            $db = new SQLite3('Asset-Manager-DB.db');
                            $results = $db->query("SELECT AssetBase.BaseID, AssetBase.AssetName, Assets.Thumbnail, AssetBase.AssetDescription
                                FROM AssetBase
                                INNER JOIN Assets ON AssetBase.BaseID = Assets.BaseID
                                Where AssetBase.BaseID = $BaseID;");

                            $row = $results->fetchArray(SQLITE3_ASSOC);
                            $thumbnailBlob = $row['Thumbnail'];
                            $description = $row['AssetDescription'];

                            $base64Image = base64_encode($thumbnailBlob);
                            $imgSrc = "data:image/png;base64," . $base64Image;


                            echo "<h2>" . $row["AssetName"] . "</h2>";
                        ?>
                        
                        <div id="titleBuffer"></div>
                    </div>
                    <div class="asset-image">
                        <?php echo "<img src='$imgSrc' style='max-width: 100%'>"; ?>
                    </div>
                    <div class="status-label">
                        <h3> Status: </h3>
                        <h3 id="status-text"> In Progress </h3>
                    </div>
                </div>
                <div>
                    <div class="asset-details">             
                    
                        <div id="left">
                            <p>Uploaded By:</p>
                            <p>Last Uploaded:</p>
                            <p>File Size:</p>
                            <p>Vertex Count:</p>
                        </div>
                        <div id="right">
                            <p><strong>Myles Bradley</strong></p>
                            <p><strong>27/01/2025</strong></p>
                            <p><strong>27 MB</strong></p>
                            <p><strong>112,569</strong></p>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="right-panel">
                <div class="asset-info">
                    <div class="asset-info-header">
                        <h3>Asset Details</h3>
                    </div>
                    <p class="description-header"><strong>Description:</strong></p>
                    <div class="description-box">
                        <p><?php echo htmlspecialchars($description); ?></p>
                    </div>
                </div>
                <div class="comments-section">
                    <h3>Comments</h3>            
                    <div class="comments-list">
                        <?php
                            // Fetch and display comments for the current asset
                            $commentsQuery = "SELECT c.CommentID, c.UserID, c.Comment, c.Date, u.FName, u.LName
                                    FROM AssetComments ac
                                    JOIN Comment c ON ac.CommentID = c.CommentID
                                    JOIN User u ON c.UserID = u.UserID
                                    WHERE ac.BaseID = $BaseID;";
                            $commentsResult = $db->query($commentsQuery);
                            ?>
                            <div class="scrollable-comments">
                                <?php
                                while ($commentRow = $commentsResult->fetchArray(SQLITE3_ASSOC)) {
                                    echo "<div class='comment'>";
                                    echo "<div class='comment-header'>";
                                    echo "<p><strong>" . htmlspecialchars($commentRow['FName']) . " " . htmlspecialchars($commentRow['LName']) . "</strong> (#" . htmlspecialchars($commentRow['UserID']) . ")</p>";
                                    echo "<p class='comment-date'>" . htmlspecialchars($commentRow['Date']) . "</p>";
                                    echo "</div>";

                                    echo "<div class='comment-body'>";
                                    echo "<p>" . htmlspecialchars($commentRow['Comment']) . "</p>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                                ?>
                            </div>
                        <form method="POST" action="Comment-Submission.php">
                            <div class="comment-input-container">
                                <textarea class="comment-input"name="comment" placeholder="Write your comment here..." required></textarea>
                                <button class = "comment-btn"type="submit" name="submitComment">Post Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="actions">
                    <a href="Upload-Asset-Version.php"><button class="download-btn">Upload</button></a>
                    <a href="download.php?BaseID=<?php echo $row['BaseID']; ?>">
                        <button class="download-btn">Download</button>
                    </a>
                </div>
                <div class="delete">
                    <?php 
                        $_SESSION["AccessLevel"];
                        if($_SESSION["AccessLevel"] == "Admin" || $_SESSION["AccessLevel"] == "Manager"){
                            echo "<a href='Delete-Asset.php?BaseID=$BaseID'><button class='delete-btn'>Delete</button></a>";
                        };
                    ?>
                </div>
            </div>
        </div>
        <div style="display: flex ; justify-content: center; align-items: center; margin-top: 20px;">
            <div class="asset-history">
                <h3>Asset History</h3>  
                <?php
                    
                    // Check if the asset name is set in the URL
                    if (isset($_GET['assetName'])) {
                        $BaseID = $_GET['assetName'];    
                        $_SESSION["BaseID"] = $BaseID;
                    }
                    //;  
                    //print_r($_SESSION);
                    $db = new SQLite3('Asset-Manager-DB.db');
                    $query = "SELECT * FROM Assets Where BaseID = '$BaseID'";
                    $result = $db->query($query);

                    //echo($result);

                    echo"<table class='Asset-History-tb'>";
                    echo"<tr> <th>Date</th> <th>User</th> <th>Action</th> </tr>";

                    while($row = $result->fetchArray(SQLITE3_ASSOC)){
                        $uploadDate = $row["UploadDate"];
                        $uploader = $row["Uploader"];

                        echo "<tr>
                                <td>$uploadDate</td>
                                <td>$uploader</td>
                            </tr>";
                    }
                    echo"</table>";
                    $db->close();
                ?>
            </div>
        </div>
    </main>
</body>
<footer></footer>
</html>
<<<<<<< HEAD

=======
>>>>>>> 44f47b22afd4dd741a5d792f496151cc687019c8
