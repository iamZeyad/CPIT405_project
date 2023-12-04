<?php

// Set common HTTP response headers
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, multipart/form-data");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json"); //NEED TO CHANGE

// Handle OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
//THE ABOVE CODE IS SOMEHOW MAKING MY CODE WORK!

// Check HTTP request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('ALLOW: POST');
    http_response_code(405);
    echo json_encode(array('message' => 'Method not allowed'));
    return;
}

if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
}

if (preg_match('/audio\/*/', $audioFile['type'])){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.openai.com/v1/audio/transcriptions',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('file'=> new CURLFILE('/Users/zeyad/Downloads/WhatsApp Ptt 2023-12-03 at 20.13.03 (online-audio-converter.com).mp3'),'model' => 'whisper-1','response_format' => 'text'),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: multipart/form-data',
    'Authorization: Bearer '. getenv('CPIT405_KEY'), //get the key from enviroment variable
    'Cookie: __cf_bm=CRnlVbLGvfjKlNCbWI3.s8Aoj8MbG05EJTn5xsyQVNk-1701689981-0-ATNP0LiNNkODYTPcF2tAtn8I096QiqNTLEWbaIKR4sZ/lJoXQECS0hbv2Y8V+4gW8rUjZY3urVD1gcHhEbzFO1Y=; _cfuvid=EgKCFpchb9J3OK91rOrU7xGNz4fH2.sihozo0DPNV4Y-1701689981359-0-604800000'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

}
