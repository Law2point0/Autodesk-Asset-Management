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
         max-width: 1300px; 
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

        .right-lock {
        display: flex;
        justify-content: right;
        align-items: right;
        height: 30px;
        }

        .blue-banner {
        display: flex;
        align-items: center; 
        padding: 0;
        height: 40px;
        background-color: #3977B0;
        width: 100%; /* Ensure it spans the container */
        }


        .white-bold-center {
          font-weight: bold;
          color: white;
          position: absolute;
          left: 30%;
          transform: translateX(-50%);
          margin: 0; /* Remove default margins */
          }

        .black-banner{
          background-color: black;
          color: white;
          font-weight: bold;
          display: flex;
          align-items: center;
          padding: 0 10px;
          height: 80%;
          align-self: flex-start; 
        }

        .Half-triangle {
          height: 0;
          margin: 0;
          border: 0;
          border-left: 40px solid black; 
          border-bottom: 30px solid transparent; 
          border-top: 0px solid transparent; 
          display: inline-block;
          align-self: flex-start;
          height: 80%;
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
    <button class="upload-button"> Upload </button>
    </div>



    <main>
    <a href="javascript:history.back()" class="back-button">← Back</a>
    <div style="overflow-x:auto;">
    <div class="blue-banner">
      <div class="black-banner">
          <h3>Project Title</h3>
      </div>
      <div class="Half-triangle">
      </div> 
       <h3 class="white-bold-center"> Assets </h3>
    </div>
    <div class="table-container">
    <div class="row">

<div class="gallery">
  <form action="">
    <a type= "submit" target="" href="View-Asset.php?assetName=Benchy">
    <img src="..\Thumbnails\Benchy.jpeg" alt="Benchy 3D Model" width="300" height="200">
    <div class="desc">Benchy 2.obj</div>
    </a>
  </form>
</div>

<div class="gallery">
  <a target="_blank" href="">
    <img src="" alt="" width="300" height="200">
  </a>
  <div class="desc">Day.obj</div>
</div>

<div class="gallery">
  <a target="_blank" href="">
    <img src="" alt="" width="300" height="200">
  </a>
  <div class="desc">Hey.obj</div>
</div>
</div>
</div>
</div>
      <div class="right-panel">

        <div class="black-project">
          <h3>Project Details</h3>
         <div class="right-lock"> <input type="text" placeholder="Search.."> </div>
        </div>
        <h3>Comments</h3>
          <input type="text">
          <div class="actions">
            <button class="submit-btn">Submit</button>
          </div>
      </div>


    </main>
</body>
<footer></footer>
</html>