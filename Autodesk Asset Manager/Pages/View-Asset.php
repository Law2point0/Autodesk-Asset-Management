<?php session_start() ?>

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
                <div class="asset-display">
                    <div class=asset-title-card>
                        <?php
                            if (isset($_GET['assetName'])) {
                                $BaseID = $_GET['assetName'];    
                                $_SESSION["BaseID"] = $BaseID;
                                $BaseID = 4;
                            }
                            $db = new SQLite3('Asset-Manager-DB.db');
                            $results = $db->query("SELECT AssetBase.BaseID, AssetBase.AssetName, Assets.Thumbnail 
                                FROM AssetBase
                                INNER JOIN Assets ON AssetBase.BaseID = Assets.BaseID
                                Where AssetBase.BaseID = $BaseID;");

                            $row = $results->fetchArray(SQLITE3_ASSOC);
                            $thumbnailBlob = $row['Thumbnail'];

                            $base64Image = base64_encode($thumbnailBlob);
                            $imgSrc = "data:image/png;base64," . $base64Image;


                            echo "<h2>'" . $row["AssetName"] . "'</h2>";
                        ?>
                        
                        <div id="titleBuffer"></div>
                    </div>
                    <div class="asset-image">
                        <?php echo "<img src='$imgSrc' width='100'>"; ?>
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
                    <h3>Asset Details</h3>
                    <input type="text">
                </div>
                <div class="asset-info">
                    <h3>Manager Notes</h3>
                    <input type="text">
                </div>
                <div class="asset-info">
                    <h3>Asset Description</h3>
                    <input type="text">
                </div>
                <div class="asset-info">
                    <h3>Tags</h3>
                    <input type="text">
                </div>
                <div class="actions">
                    <a href="Upload-Asset-Version.php"><button class="download-btn">Upload</button></a>
                    <a href="download.php?BaseID=<?php echo $row['BaseID']; ?>">
                        <button class="download-btn">Download</button>
                    </a>
                </div>
                <div class="actions">
                    <button class="delete-btn">Delete</button>
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

