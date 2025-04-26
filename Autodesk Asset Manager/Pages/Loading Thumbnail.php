<?php
$db = new SQLite3('Asset-Manager-DB.db');


$results = $db->query("SELECT BaseID, thumbnail FROM Assets");

echo "<h1>Stored Assets</h1>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Thumbnail</th></tr>";

while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $id = $row['BaseID'];
    $thumbnailBlob = $row['Thumbnail'];

    $base64Image = base64_encode($thumbnailBlob);
    $imgSrc = "data:image/png;base64," . $base64Image;

    echo "<tr>";
    echo "<td>$id</td>";
    echo "<td><img src='$imgSrc' width='100'></td>";
    echo "</tr>";
}

echo "</table>";
?>