<?php
//check HTTP request method

if($_SERVER ['REQUEST_METHOD'] !== 'GET') {
    header('ALLOW: GET');
    http_response_code(405);
    echo json_encode(
        array('message'=>'Method not allowed')
    );
    return;
}

//set http response headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');

include_once '../db/Database.php';
include_once '../models/Script.php';

//instantiate a DB object and connect

$database = new Database();
$dbConnection = $database->connect();
//instantiate script object
$script = new Script($dbConnection);

//Get the http GET request for all the script items
$result = $script->readAll();
if(!empty($result)) {
    echo json_encode($result);
}
else {
    echo json_encode(array('message'=> 'No Script items were found'));
}