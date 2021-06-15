<?php
    error_reporting(0);

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/contact.php';


    $database = new Database();
    $db = $database->getConnection();

    if ( ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => 422, 'message' => "Email is not valid."]);

        http_response_code(422);
    } else {
        $item = new Contact($db);
        
        $data = $_POST;
    
        $item->fullname = filter_var($data['fullname'], FILTER_SANITIZE_STRING);
        $item->email    = filter_var($data['email'], FILTER_SANITIZE_STRING);
        $item->subject  = filter_var($data['subject'], FILTER_SANITIZE_STRING);
        $item->message  = filter_var($data['message'], FILTER_SANITIZE_STRING);
        
        try {
            $item->createContact();
            http_response_code(200);
            echo json_encode(["status" => 200, 'message' => "Created contact successfully."]);
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode(["status" => 500, 'message' => "Contact is currently cannot be accepted."]);
        }
    }
    

?>
