<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Asset</title>
  <link rel="stylesheet" href="Log-in.css">
  <?php
    session_start();
    include("NavBar.php");

    if (isset($_GET['assetName'])) {
      $BaseID = $_GET['assetName'];    
      $_SESSION["BaseID"] = $BaseID;
      
    }
    $BaseID = 4;
    $db = new SQLite3('Asset-Manager-DB.db');
    $results = $db->query("SELECT BaseID, AssetName
                    FROM AssetBase
                    Where BaseID = $BaseID;");

    $row = $results->fetchArray(SQLITE3_ASSOC);
  ?>
</head>
<body>
  <main>
    <div class="panel-container">
      <form id="uploadForm" enctype="multipart/form-data" style="width: 100%; background-color: #f0f0f0; padding: 25px;">
        <div class="upload-panel">
          <a href="View-Assets-Grid.php" class="back-button">← Back</a>
          <div class="asset-display">
            <div class="asset-title-card">
              <h2>Upload New Asset</h2>
              <div id="titleBuffer"></div>
            </div>
            <div class="asset-image" style="width: auto; height: 400px; background-color: #ddd; display: flex; align-items: center; justify-content: center; border: 1px solid #bbb;">
              <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; width: 100%; padding: 20px;">
                <p>Enter Asset Name:</p>
                <input type="text" name="assetName" id="assetName" placeholder="Enter asset name" required style="width: 80%; padding: 10px; margin-bottom: 20px; border: 1px solid #bbb; border-radius: 5px;">
                <p>Select model to upload:</p>
                <label for="fileToUpload" class="custom-file-upload">+</label>
                <input type="file" accept=".glb,.gltf" name="fileToUpload" id="fileToUpload" class=".custom-file-upload" style="width: 150px; padding: 10px; border: 1px dashed #BBB; text-align: center; background-color: #DDD; cursor: pointer;">
              </div>
            </div>
          </div>
          <div class="upload-panel-bottom" style="display: flex; flex-direction: table; align-items: center; justify-content: center; padding: 20px;">
            <button type="button" id="uploadButton" style="padding: 15px 25px; background-color: #3977B0; color: #fff; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer;">Upload Asset</button>
          </div>
        </div>
      </form>
    </div>
  </main>
</body>

<script type="importmap">
{
  "imports": {
    "three": "https://cdn.jsdelivr.net/npm/three@0.152.2/build/three.module.js",
    "three/examples/jsm/loaders/GLTFLoader.js": "https://cdn.jsdelivr.net/npm/three@0.152.2/examples/jsm/loaders/GLTFLoader.js",
    "three/examples/jsm/loaders/OBJLoader.js": "https://cdn.jsdelivr.net/npm/three@0.152.2/examples/jsm/loaders/OBJLoader.js",
    "three/examples/jsm/controls/OrbitControls.js": "https://cdn.jsdelivr.net/npm/three@0.152.2/examples/jsm/controls/OrbitControls.js"
  }
}
</script>

<script type="module">
import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import { OBJLoader } from 'three/examples/jsm/loaders/OBJLoader.js';

// Set up scene
const scene = new THREE.Scene();
scene.background = new THREE.Color(0xf0f0f0);

const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100);
camera.position.set(2, 2, 2);

const renderer = new THREE.WebGLRenderer({ antialias: true, preserveDrawingBuffer: true });
renderer.setSize(300, 300);
document.body.appendChild(renderer.domElement);

scene.add(new THREE.AmbientLight(0xffffff, 0.6));
const dirLight = new THREE.DirectionalLight(0xffffff, 1);
dirLight.position.set(5, 5, 5);
scene.add(dirLight);

// Loaders
const gltfLoader = new GLTFLoader();
const objLoader = new OBJLoader();

// Upload button logic
document.getElementById("uploadButton").addEventListener("click", function () {
  const fileInput = document.getElementById('fileToUpload');
  const file = fileInput.files[0];

  if (!file) {
    alert("Please select a file to upload.");
    return;
  }

  const fileURL = URL.createObjectURL(file);
  const fileName = file.name;

  loadModel(fileURL, file, fileName);
});


function loadModel(fileURL, originalFile, fileName) {
  const extension = fileName.split('.').pop().toLowerCase();

  const onLoad = (model) => {
    scene.add(model);

    //sets up scene objects
    const box = new THREE.Box3().setFromObject(model);
    const center = box.getCenter(new THREE.Vector3());
    const size = box.getSize(new THREE.Vector3()).length();
    model.position.sub(center);

    camera.position.set(0, size * 0.5, size * 1.5);
    camera.lookAt(0, 0, 0);

    renderer.render(scene, camera);

    //defines thumbnail size 
    const thumbnailDataURL = renderer.domElement.toDataURL('image/png');
    const img = document.createElement('img');
    img.id = 'thumbnail';
    img.src = thumbnailDataURL;
    img.width = 150;
    img.height = 150;
    document.body.appendChild(img);

    saveData(originalFile, fileName, thumbnailDataURL);
  };

  if (extension === 'glb' || extension === 'gltf') {
    gltfLoader.load(fileURL, gltf => onLoad(gltf.scene));
  } else if (extension === 'obj') {
    objLoader.load(fileURL, obj => onLoad(obj));
  } else {
    alert('Unsupported file type.');
  }
}

function saveData(file, name, thumbnailDataURL) {
  const assetName = document.getElementById('assetName').value; // Get the asset name from the input field

  if (!assetName) {
    alert('Please enter an asset name.');
    return;
  }

  const reader = new FileReader();
  reader.onloadend = () => {
    const modelBase64 = reader.result.split(',')[1];
    fetch('save-new-asset.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        assetName: assetName, // Include the asset name
        model: modelBase64,
        thumbnail: thumbnailDataURL
      })
    })
    .then(res => res.text())
    .then(console.log)
    .catch(console.error);
  };
  reader.readAsDataURL(file);
}
</script>
