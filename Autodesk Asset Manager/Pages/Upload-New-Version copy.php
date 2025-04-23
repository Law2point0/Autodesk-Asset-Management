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
                <form id="uploadForm" enctype="multipart/form-data">
                    <p>Select image to upload:</p>
                    <input type="file" accept=".glb,.gltf,.obj" name="fileToUpload"  id="fileToUpload">
                    <button type="button" id="uploadButton">Upload Asset</button>
                </form>
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
    import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';

    //console.log("File path passed to loadModel:", filePath);
    
    //Initialises the scene
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xf0f0f0);

    //adds camera to the scene
    const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100);
    camera.position.set(2, 2, 2);
    camera.lookAt(0, 0, 0);

    //sets camera dimensions
    const renderer = new THREE.WebGLRenderer({ antialias: true, preserveDrawingBuffer: true });
    renderer.setSize(300, 300);
    document.body.appendChild(renderer.domElement);

    //adds lighting 
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
    directionalLight.position.set(5, 5, 5);
    scene.add(directionalLight);

    //Initialises loaders
    const gltfLoader = new GLTFLoader();
    const objLoader = new OBJLoader();

    document.getElementById("uploadButton").addEventListener("click", function () {
        const formData = new FormData(document.getElementById("uploadForm"));
        
        //console.log("Form data:", formData); // Log the FormData object
        /*fetch("upload.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                //console.log("Raw response:", text);
                if (data.success) {
                    console.log("File uploaded successfully:", data.filePath);
                    loadModel(data.filePath); // Call the loadModel function with the file path
                } else {
                    console.error("Error uploading file:", data.message);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });*/
        const fileInput = document.getElementById('uploadButton');
        const file = fileInput.files[0];

        if (!file) return;

        const fileURL = URL.createObjectURL(file);
        const fileName = file.name;

        // Load the model into the scene and generate the thumbnail
        loadModel(fileURL, file, fileName);
    });
    function loadModel(fileURL, originalFile, fileName) {
        const extension = fileName.split('.').pop().toLowerCase();

        const onLoad = (model) => {
            scene.add(model);

            const box = new THREE.Box3().setFromObject(model);
            const center = box.getCenter(new THREE.Vector3());
            const size = box.getSize(new THREE.Vector3()).length();
            model.position.sub(center);

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
        const reader = new FileReader();
        reader.onloadend = () => {
            const modelBase64 = reader.result.split(',')[1];
            fetch('save-asset.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name: name,
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
    /*function loadModel(filePath){
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
        } else {
            console.error('Unsupported file format:', fileExtension);
        }
    }*/

    //Loads selected model into the scene
    function addModelToScene(model) {
        scene.add(model);

        const box = new THREE.Box3().setFromObject(model);
        const center = box.getCenter(new THREE.Vector3());
        const size = box.getSize(new THREE.Vector3()).length();
        model.position.sub(center); // Center the model

        //Move camera back based on size
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

  </script>

