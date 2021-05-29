<?php

//The api which is used by c# application to fetch the data from server.

ob_start();
include('../includes/db.php');


$response = array();

if (isTheseParametersAvailable(array('customer_email', 'customer_password'))) {


    $customer_email = $_POST["customer_email"];
    $customer_password = $_POST["customer_password"];


    $query = $conn->prepare("SELECT * FROM users WHERE `email` LIKE '$customer_email' and `password` = '$customer_password'");
    $query->execute();



    if ($query->rowCount() > 0) {
        $response['error'] = false;
        $response["status"] = "success";
        $response['message'] = 'Login Successfull';
    } else {
        $response['error'] = true;
        $response["status"] = "fail";
        $response["message"] = "Email or Password is Wrong!";
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
        if (!isset($_POST[$param])) {
            return false;
        }
    }
    return true;
}
