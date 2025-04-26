<?php
header('Content-Type: application/json'); // Ensure the response is JSON

$target_dir = "../tmp/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

// Check if the file is valid
if (isset($_POST["submit"])) {
    $check = true; // Placeholder for validation
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}

if ($uploadOk == 0) {
    echo json_encode(["success" => false, "message" => "File is not allowed."]);
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo json_encode(["success" => true, "filePath" => $target_file]);
    } else {
        http_response_code(500); // Set HTTP status code for server error
        echo json_encode(["success" => false, "message" => "Error uploading file."]);
    }
}
?>
