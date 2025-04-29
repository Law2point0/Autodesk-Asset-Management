<?php
    session_start();
    if (isset($_GET['BaseID'])) {  
        $BaseID = intval($_GET['BaseID']);
        $BaseID = 3;
        
        $db = new SQLite3('Asset-Manager-DB.db');
        $query = "SELECT AssetBase.BaseID, AssetBase.AssetName, Assets.AssetFile 
            FROM AssetBase
            INNER JOIN Assets ON AssetBase.BaseID = Assets.BaseID
            Where AssetBase.BaseID = '$BaseID';";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':BaseID', $BaseID, SQLITE3_INTEGER);
        //$stmt->bindValue(':AssetName', $AssetName, SQLITE3_TEXT);
        $result = $stmt->execute();
        $file = $result->fetchArray(SQLITE3_ASSOC);

        if ($file) {
            $fileData = $file['AssetFile'];
            $AssetName = $file['AssetName'] . ".glb";
            $mimeType = 'model/gltf-binary';

            // Send headers for file download
            header("Content-Type: $mimeType");
            header("Content-Disposition: attachment; filename=\"$AssetName\"");
            header("Content-Length: " . strlen($fileData));

            // Output the file
            echo $fileData;
        } else {
            echo "File not found.";
        }

        $db->close();
    } else {
        echo "Invalid request.";
    }
?>