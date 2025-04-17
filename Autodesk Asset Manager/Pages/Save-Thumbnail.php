<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['image']) && isset($data['name'])) {
        $imageData = $data['image'];
        $modelName = $data['name'];

        // Remove the "data:image/png;base64," part
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);

        // Decode the Base64 string
        $decodedImage = base64_decode($imageData);

        // Save the image to a file
        $filePath = '../Thumbnails/' . $modelName . '_' . time() . '.png';
        if (file_put_contents($filePath, $decodedImage)) {
            echo 'Thumbnail saved to ' . $filePath;
        } else {
            echo 'Failed to save thumbnail.';
        }
    } else {
        echo 'Invalid data received.';
    }
}
?>