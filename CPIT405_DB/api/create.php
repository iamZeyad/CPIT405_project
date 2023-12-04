<?php

// Set common HTTP response headers
// header("Access-Control-Allow-Origin: http://localhost:3001");
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Content-Type: application/json"); //NEED TO CHANGE
// Allow only requests from specific origins
header('Access-Control-Allow-Origin: http://localhost:3001');

// Allow certain methods if needed (e.g., GET, POST)
header('Access-Control-Allow-Methods: GET, POST');

// Allow certain headers if needed
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

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


require_once '../db/Database.php';
include_once '../models/Script.php';

$database = new Database();
$dbConnection = $database->connect();
//instantiate script object
$script = new Script($dbConnection);
//get the http post request JSON body
$data = json_decode(file_get_contents('php://input'), true);
//if no script is included in the json body, return an error
if(!$data) {
    http_response_code(422);
    echo json_encode(
        array('message'=> 'Error missing required parameter script in the JSON body')
    );
    return;
}

//Create a script item
$script->setScript($data['script']);
$script->setDescribtion($data['describtion']);



if($script->create()) {
    echo json_encode(
        array('message'=>'A script item was created',
            'id' => $script->lasId()
        )
    );
}
else{
    echo json_encode(
        array('message'=> 'Error: No script Item was created')
    );

}