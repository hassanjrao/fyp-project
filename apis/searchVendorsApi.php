<?php


ob_start();
include('../includes/db.php');


$response = array();

if (isTheseParametersAvailable(array('vendor_name'))) {


    $vendor_name = $_GET["vendor_name"];


    try {
        $query = $conn->prepare("SELECT * FROM users WHERE role='2' and name LIKE '$vendor_name%'");
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
