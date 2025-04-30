<?php
session_start(); 

<?php
session_start(); 


if (!isset($_SESSION['UserID'])) {
  // Redirect back to login page if no session is found or Access is wrong. 
  header("Location: http://localhost/Autodesk-Asset-Management/Autodesk%20Asset%20Manager/Pages/Login.php");
  exit;
} elseif (!isset($_SESSION['ProjectID'])){
  header("Location: http://localhost/Autodesk-Asset-Management/Autodesk%20Asset%20Manager/Pages/View-Projects.php");
  exit;
};

$UserID = $_SESSION['UserID'];
$AccessLevel = $_SESSION['AccessLevel'];
$ProjectID = $_SESSION['ProjectID'];


?>


$UserID = $_SESSION['UserID'];
$AccessLevel = $_SESSION['AccessLevel'];
$ProjectID = $_SESSION['ProjectID'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>View Asset</title>
    <style>
        div.row{
        text-align: center;
        width: 700px;
        }

        div.desc {
        padding: 15px;
        text-align: center;
        background-color: black;
        color: white;
        }

        div.gallery img {
        width: 100%;
        height: auto;
        }

        div.gallery:hover {
        border: 1px solid #777;
        }

        div.gallery {
        border: 10px solid #ffffff;
        width: 200px;
        display: inline-block;
        margin-left: auto;
        margin-right: auto;

        }
        .table-container {
         display: flex;
         justify-content: space-between;
         align-items: center;
         align: center;
         margin: 0 auto; 
         }

        div.black-project{ 
          background-color: black;
          color: white;
          padding: 10px;
          font-size: 16px;
          font-weight: bold;
          align-self: flex-start;
        }

        .upload-button{
          color: white;
          background-color: black;
          font-size: 16px;
          padding: 7px 32px;
          font-weight: bold;
        }

        .upload-button:hover{
          background-color: #777;
          color: black;
        }

        .right-lock {
          display: flex;
         justify-content: flex-end;
         align-items: center;
         
        }

        .left-lock{
          display: flex;
         justify-content: flex-start;
         align-items: center;
        }
      
        .blue-banner {
        display: grid;
        grid-template-columns: auto 1fr auto; /* Three sections: left, center, right */
        align-items: center;
        padding: 0 10px;
        height: 40px;
        background-color: #3977B0;
        width: 700px;
        position: relative;
      }


        .white-bold-center {
          font-weight: bold;
          color: white;
          position: absolute;
          left: 50%;
          transform: translateX(-50%);
          margin: 0; 
          }

          .black-banner {
          background-color: black;
          color: white;
          font-weight: bold;
          display: flex;
          align-items: center;
          padding: 0 10px; 
          height: 100%; 
          position: relative;
          right: 10%;

          }

        .Half-triangle {
          height: 0;
          border-left: 50px solid black; 
          border-bottom: 40px solid transparent; 
          border-top: 0px solid transparent; 
          display: inline-block;
          align-self: flex-start;
          margin-left: -13px;
         }

         main {
          padding-left: 30px;
          padding-right: 30px;
         }
    </style>
</head>
<body>
    <?php
        include("NavBar.php");
    ?>
    <div class="right-lock">
    <a href="Autodesk Asset Manager\Pages\Upload-Asset-Version.php"><button class="upload-button"> Upload </button></a>
    </div>

    <div class="left-lock">
    <a href="http://localhost/Autodesk-Asset-Management/Autodesk%20Asset%20Manager/Pages/View-Assets-List.php"><button class="upload-button">Switch to list view</button></a>
    </div>

      <main>
      <a href="javascript:history.back()" class="back-button">← Back</a>
      <div class="table-container">
      <div style="overflow-y:auto;">
      <div class="blue-banner">
        <div class="black-banner">
            <h3>Project Title</h3>
        </div>
        <div class="Half-triangle">
        </div> 
        <h3 class="white-bold-center"> Assets </h3>
        <div class="right-lock"> <input type="text" id="searchBox" placeholder="Search by title..."> </div>
      </div>

      <div class="row">


    <?php
    $db = new SQLite3('Asset-Manager-DB.db');

    $selectQuery = "
    SELECT 
        ab.AssetName,
        a.Thumbnail
    FROM 
        ProjectAssets pa
    JOIN 
        AssetBase ab ON pa.BaseID = ab.BaseID
    JOIN 
        Assets a ON a.AssetID = (
            SELECT AssetID 
            FROM Assets 
            WHERE BaseID = pa.BaseID 
            ORDER BY Version DESC 
            LIMIT 1
        )
    WHERE 
        pa.ProjectID = :projectID;
    ";

    $stmt = $db->prepare($selectQuery);
    $stmt->bindValue(':projectID', $ProjectID, SQLITE3_INTEGER); 
    $result = $stmt->execute();
    
    $GalleryDiv = "";
    
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        if (!$row) continue; // skip if empty row
    
        $AssetName = htmlspecialchars($row['AssetName']);
        $thumbnailBlob = $row['Thumbnail'];
        $base64Image = base64_encode($thumbnailBlob);
        $imgSrc = "data:image/png;base64," . $base64Image;

        $GalleryDiv .= "
        <div class=\"gallery\">
            <form action=\"\">
                <a type=\"submit\" target=\"\" href=\"View-Asset.php?assetName={$AssetName}\">
                    <img src='$imgSrc' alt=\"{$AssetName}\" width=\"300\" height=\"200\" onerror=\"this.onerror=null; this.src='/Autodesk-Asset-Management/Autodesk Asset Manager/Thumbnails/Benchy.jpeg';\">
                    <div class=\"desc\">{$AssetName}</div>
                </a>
            </form>
        </div>
        ";
    }
    
    echo "<div id='gallery-container'>$GalleryDiv</div>";
    ?>

  <script>
  document.addEventListener('DOMContentLoaded', () => {
      const searchInput = document.getElementById('searchBox');
      const galleryItems = document.querySelectorAll('#gallery-container .gallery');

      searchInput.addEventListener('input', () => {
          const searchValue = searchInput.value.toLowerCase();

          galleryItems.forEach(item => {
              const desc = item.querySelector('.desc').textContent.toLowerCase();
              if (desc.includes(searchValue)) {
                  item.style.display = 'inline-block';
              } else {
                  item.style.display = 'none';
              }
          });
      });
  });
  </script>

<div class="gallery">
  <form action="">
    <a type= "submit" target="" href="View-Asset.php?BaseID=1">
    <img src="..\Thumbnails\Benchy.jpeg" alt="Benchy 3D Model" width="300" height="200">
    <div class="desc">Benchy 2.obj</div>
    </a>
  </form>
</div>


</div>
</div>
</div>
      <div class="right-panel">

        <div class="black-project">
          <h3>Project Details</h3>
        </div>
        <h3>List of editors</h3>
        <?php
        $db = new SQLite3('Asset-Manager-DB.db');

        $selectQuery = "SELECT UserID FROM Assignment WHERE ProjectID = $ProjectID;";
        $result = $db->query($selectQuery);

        echo "<ul>";

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
       $queryUserID = $row['UserID'];

        $stmt = $db->prepare("SELECT FName, LName, Email FROM User WHERE UserID = :userid");
        $stmt->bindValue(':userid', $queryUserID, SQLITE3_INTEGER);
        $userResult = $stmt->execute();

        if ($userRow = $userResult->fetchArray(SQLITE3_ASSOC)) {
          $fname = htmlspecialchars($userRow['FName']);
          $lname = htmlspecialchars($userRow['LName']);
          $email = htmlspecialchars($userRow['Email']);

         echo "<li>$fname $lname - $email</li>";
         }
}

echo "</ul>";
?>


        <div class="actions">
        </div>


      </div>

    </main>
</body>

</html>
