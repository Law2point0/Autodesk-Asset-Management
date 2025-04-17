<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>3D Model Thumbnail Generator</title>
  <style>
    body { margin: 0; }
    canvas { display: block; }
    #thumbnail {
      margin-top: 10px;
      border: 1px solid #ccc;
    }
  </style>
      <?php
        include("NavBar.php");
    ?>
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
</head>
<body>
  <script type="module">
    import * as THREE from 'three';
    import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
    import { OBJLoader } from 'three/examples/jsm/loaders/OBJLoader.js';
    import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';

    // Scene setup
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xf0f0f0);

    const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100);
    camera.position.set(2, 2, 2);
    camera.lookAt(0, 0, 0);

    const renderer = new THREE.WebGLRenderer({ antialias: true, preserveDrawingBuffer: true });
    renderer.setSize(300, 300);
    document.body.appendChild(renderer.domElement);

    // Lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
    directionalLight.position.set(5, 5, 5);
    scene.add(directionalLight);


    // Loaders
    const gltfLoader = new GLTFLoader();
    const objLoader = new OBJLoader();

    function loadModel(filePath){
      const fileExtension = filePath.split('.').pop().toLowerCase();

      if (fileExtension === 'gltf' || fileExtension === 'glb'){
        gltfLoader.load(
          filePath,
          (gltf) => {
            console.log('GLB Model loaded successfully!', gltf);
            const model = gltf.scene;
            addModelToScene(model);
          },
          (xhr) => {
            console.log(`Loading GLB: ${(xhr.loaded / xhr.total * 100).toFixed(2)}%`);
          },
          (error) => {
            console.error('Error loading GLTF/GLB model:', error);
          }
        );
      } else if (fileExtension === 'obj'){
        objLoader.load(
          filePath,
          (object) => {
            console.log('OBJ Model loaded successfully!', object);
            addModelToScene(object);
          },
          (xhr) => {
            console.log(`Loading OBJ: ${(xhr.loaded / xhr.total * 100).toFixed(2)}%`);
          },
          (error) => {
            console.error('Error loading OBJ model:', error);
          }
        );
      } else {
        console.error('Unsupported file format:', fileExtension);
      }
    }

    // Load GLB model
    function addModelToScene(model) {
    scene.add(model);

    const box = new THREE.Box3().setFromObject(model);
    const center = box.getCenter(new THREE.Vector3());
    const size = box.getSize(new THREE.Vector3()).length();
    model.position.sub(center); // Center the model

    // Move camera back based on size
    camera.position.set(0, size * 0.5, size * 1.5);
    camera.lookAt(0, 0, 0);

    renderer.render(scene, camera);

    const thumbnailDataURL = renderer.domElement.toDataURL('image/png');
    const img = document.createElement('img');
    img.id = 'thumbnail';
    img.src = thumbnailDataURL;
    img.width = 150;
    img.height = 150;
    document.body.appendChild(img);

    saveThumbnail(thumbnailDataURL);
    }
    function saveThumbnail(dataURL) {
      const modelName = 'Large Rock';
      fetch('save-thumbnail.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 
          image: dataURL,
          name: modelName,
        }),
      })
        .then((response) => response.text())
        .then((data) => {
          console.log('Thumbnail saved successfully:', data);
        })
        .catch((error) => {
          console.error('Error saving thumbnail:', error);
        });
    }

  loadModel('../Assets/rock/Rock Large.glb');

  </script>
</body>
</html>