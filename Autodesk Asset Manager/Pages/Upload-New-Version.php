<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Log-in.css">
    <?php
        session_start();

        include("NavBar.php")
    ?>
</head>
<body>
    <main>
        <div class="panel-container">
            <div class="left-panel">
                <a href="View-Assets-Grid.php" class="back-button">← Back</a>
                <div class="asset-display">
                    <div class=asset-title-card>
                        <h2>Benchy 2</h2>
                        <div id="titleBuffer"></div>
                    </div>
                    <div class="asset-image">
                        <img src="..\Thumbnails\Benchy.jpeg" alt="Benchy 3D Model">
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
                    <a href="Upload-New-Version.php"><button class="download-btn">Upload</button></a>
                    <button class="download-btn">Download</button>   
                </div>
                <div class="actions">
                    <button class="delete-btn">Delete</button>
                </div>
            </div>
        </div>
    </main>
    
</body>
</html>