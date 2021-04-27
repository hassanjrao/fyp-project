<?php


ob_start();
include('../includes/db.php');


$response = array();

try {

    $query = $conn->prepare(
        "SELECT * from users where role=2"
    );

    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_OBJ);
    

    $response['error'] = false;
    $response["status"] = "success";
    $response['message'] = 'Fetched Successfully Successfully';
    $response['result'] = $result;
   


} catch (PDOException $e) {
    echo "Error: " . 

    $response['error'] = true;
    $response["status"] = "fail";
    $response['message'] = $e->getMessage();;
}

echo json_encode($response);


ob_end_flush();
