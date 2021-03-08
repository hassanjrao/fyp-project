<?php

//The api which is used by c# application to fetch the data from server.

ob_start();
include('../includes/db.php');


$response = array();

if (isTheseParametersAvailable(array('customer_name', 'customer_email','customer_password','customer_address'))) {

    $customer_name = $_POST["customer_name"];
    $customer_email = $_POST["customer_email"];
    $customer_password = $_POST["customer_password"];
    $customer_address = $_POST["customer_address"];
    $customer_role = 3;
    $customer_status = "active";
    $created_by = "1";


    $query = $conn->prepare("SELECT email FROM users WHERE `email` LIKE '$customer_email'");
    $query->execute();



    if ($query->rowCount() > 0) {
        $response['error'] = true;
        $response["status"]="fail";
        $response["message"] = "Email Already Exist!";
    } else {

        $stmt = $conn->prepare("INSERT INTO `users`( `name`,`email`,`password`,`role`,`address`,`status`,`created_by`,`created_at`) VALUES (:name,:email,:password,:role,:address,:status,:created_by ,CURRENT_TIMESTAMP)");

        $stmt->bindParam(':name', $customer_name);
        $stmt->bindParam(':email', $customer_email);
        $stmt->bindParam(':password', $customer_password);
        $stmt->bindParam(':role', $customer_role);
        $stmt->bindParam(':address', $customer_address);
        $stmt->bindParam(':status', $customer_status);
        $stmt->bindParam(':created_by', $created_by);


        if ($stmt->execute()) {
            $response['error'] = false;
            $response["status"]="success";
            $response['message'] = 'Created Successfully';
           
        }
    }
} else {
    $response['error'] = true;
    $response["status"]="fail";
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
