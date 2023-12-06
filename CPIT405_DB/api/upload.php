<?php
// Set common HTTP response headers
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Methods: POST, OPTIONS, GET, PUT");
header("Access-Control-Allow-Headers: Content-Type, multipart/form-data");


// Handle OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Check HTTP request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('ALLOW: POST');
    http_response_code(405);
    echo json_encode(array('message' => 'Method not allowed'));
    return;
}

if (!isset($_FILES['file'])) {
    exit(json_encode(array('message'=> 'No file was found')));
}

$file = $_FILES['file'];

//this will be triggered when thing go really bad with uploading
if ($file['error'] !== UPLOAD_ERR_OK) {
    exit(json_encode(array('text' => 'File upload failed. Error code: ' . $file['error'])));
}


$cfile = new CURLFile($file['tmp_name'], $file['type'], $file['name']);
$postData = array('file' => $cfile, 'model' => 'whisper-1');

$curl = curl_init();

$response = curl_exec($curl);

echo $response;
curl_close($curl);