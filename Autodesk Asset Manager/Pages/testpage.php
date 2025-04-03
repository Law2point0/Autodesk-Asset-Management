<?php

    //$db = ("Asset-Manager-DB.db");
    //$pdo = new PDO("sqlite:" . $db);
    $db = new SQLite3('Asset-Manager-DB.db');
    $query = "SELECT * FROM Assets";
    $result = $db->query($query);

    //echo($result);

    echo"<table>";
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