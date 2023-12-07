<?php
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, multipart/form-data");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
}
$file = $_FILES['file'];

if (preg_match('/audio\/*/', $file['type'])) {
    $cfile = new CURLFile($file['tmp_name'], $file['type'], $file['name']);
    $postData = array('file' => $cfile , 'model' => 'whisper-1');

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.openai.com/v1/audio/transcriptions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . getenv('KEY'),
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    echo $response;
}
//this will be triggered when thing go really bad with uploading
if ($file['error'] !== UPLOAD_ERR_OK) {
    exit(json_encode(array('text' => 'File upload failed. Error code: ' . $file['error'])));
}
