<?php


ob_start();
include('../includes/db.php');


$response = array();

if (isTheseParametersAvailable(array('customer_id'))) {


    $customer_id = $_GET["customer_id"];


    try {
        $query = $conn->prepare("SELECT * FROM users WHERE role='3' and id='$customer_id'");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_OBJ);


        $response['error'] = false;
        $response["status"] = "success";
        $response['message'] = 'Fetched Successfully';
        $response['result'] = $result;


    } catch (PDOException $e) {


        $response['error'] = true;
        $response["status"] = "fail";
        $response['message'] = $e->getMessage();;
    }
} else {
    $response['error'] = true;
    $response["status"] = "fail";
    $response['message'] = 'required parameters are not available';
}

echo json_encode($response);


function isTheseParametersAvailable($params) //method to check whther the varaibles which we recieved from POST request have values or not.
{

    foreach ($params as $param) {
        if (!isset($_GET[$param])) {
            return false;
        }
    }
    return true;
}
