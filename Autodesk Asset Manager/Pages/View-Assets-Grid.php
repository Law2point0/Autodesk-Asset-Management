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
        }

        div.desc {
        padding: 15px;
        text-align: center;
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
        width: 250px;
        display: inline-block;
        margin-left: auto;
        margin-right: auto;

        }

    </style>
</head>
<body>
    <?php
        include("NavBar.php");
    ?>
    <main>
    
    <div class="row">

<div class="gallery">
  <a target="_blank" href="">
    <img src="" alt="" width="600" height="400">
  </a>
  <div class="desc">Ray</div>
</div>

<div class="gallery">
  <a target="_blank" href="">
    <img src="" alt="" width="600" height="400">
  </a>
  <div class="desc">Day</div>
</div>

<div class="gallery">
  <a target="_blank" href="">
    <img src="" alt="" width="600" height="400">
  </a>
  <div class="desc">Hey</div>
</div>
</div>

    </main>
</body>
<footer></footer>
</html>