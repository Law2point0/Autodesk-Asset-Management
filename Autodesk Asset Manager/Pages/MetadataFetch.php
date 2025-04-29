<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>3D Model Metadata Extractor</title>
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

    let selectedFile = null;
    let storedMetadata = [];

    const extractMeshData = (object) => {
      const metadata = [];
      object.traverse((child) => {
        if (child.isMesh) {
          const geometry = child.geometry;
          if (!geometry.boundingBox) geometry.computeBoundingBox();
          const bbox = geometry.boundingBox;
          metadata.push({
            name: child.name || 'Unnamed Mesh',
            vertexCount: geometry.attributes?.position?.count || 0,
            material: child.material?.name || null,
            boundingBox: {
              min: { x: bbox.min.x, y: bbox.min.y, z: bbox.min.z },
              max: { x: bbox.max.x, y: bbox.max.y, z: bbox.max.z }
            }
          });
        }
      });
      return metadata;
    };

    document.addEventListener('DOMContentLoaded', () => {
      const input = document.getElementById('modelInput');
      const extractBtn = document.getElementById('extractBtn');
      const saveBtn = document.getElementById('saveBtn');
      const fileUploadBtn = document.getElementById('fileUploadBtn');

      input.addEventListener('change', function (event) {
        selectedFile = event.target.files[0];
        extractBtn.disabled = !selectedFile;
        saveBtn.disabled = true;
        fileUploadBtn.disabled = !selectedFile;
        storedMetadata = [];
      });

      extractBtn.addEventListener('click', () => {
        if (!selectedFile) return;

        const reader = new FileReader();
        const fileName = selectedFile.name.toLowerCase();

        reader.onload = (e) => {
          if (fileName.endsWith('.glb') || fileName.endsWith('.gltf')) {
            const loader = new GLTFLoader();
            loader.parse(e.target.result, '', (gltf) => {
              storedMetadata = extractMeshData(gltf.scene);
              afterExtract();
            }, (err) => {
              console.error(err);
              alert("Failed to load GLTF/GLB.");
            });
          } else if (fileName.endsWith('.obj')) {
            try {
              const loader = new OBJLoader();
              const obj = loader.parse(e.target.result);
              storedMetadata = extractMeshData(obj);
              afterExtract();
            } catch (err) {
              console.error(err);
              alert("Failed to load OBJ.");
            }
          } else {
            alert("Unsupported file type.");
          }
        };

        if (fileName.endsWith('.obj')) {
          reader.readAsText(selectedFile);
        } else {
          reader.readAsArrayBuffer(selectedFile);
        }
      });

      saveBtn.addEventListener('click', () => {
        if (storedMetadata.length === 0) return;

          fetch('save_metadata.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            filename: selectedFile.name,
            metadata: storedMetadata
          })
        })
        .then(res => res.json())
        .then(data => {
          alert(`Metadata saved to: /assets/${data.file}`);
        })
        .catch(err => {
          console.error(err);
          alert("Failed to save metadata.");
        });
      });


      fileUploadBtn.addEventListener('click', () => {
        if (!selectedFile) return;

        const formData = new FormData();
        formData.append('modelFile', selectedFile);

        fetch('upload_file.php', {
          method: 'POST',
          body: formData
        })
        .then(res => res.json())
          .then(data => {
          alert(data.message);
        })
        .catch(err => {
          console.error(err);
          alert("Failed to upload 3D file.");
        });
      });

      const afterExtract = () => {
        if (storedMetadata.length > 0) {
          saveBtn.disabled = false;
          fileUploadBtn.disabled = false;
          console.log('Extracted Metadata:', storedMetadata);
          alert('Metadata extracted successfully!');
        } else {
          alert('No Metadata found.');
        }
      };
    });
  </script>
</head>
<body>
  <h2>3D Model Metadata Extractor</h2>
  <input type="file" id="modelInput" accept=".glb,.gltf,.obj" />
  <button id="extractBtn" disabled>Extract Metadata</button>
  <button id="saveBtn" disabled>Save Metadata</button>
  <button id="fileUploadBtn" disabled>Upload 3D File</button>
</body>
</html>
