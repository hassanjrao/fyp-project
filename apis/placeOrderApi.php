<?php

//The api which is used by c# application to fetch the data from server.

ob_start();
include('../includes/db.php');

$response = array();


if (isTheseParametersAvailable(array('user_id', 'products'))) {

    $user_id = $_POST["user_id"];

    foreach ($_POST["products"] as $key => $product) {
        # code...

        try {
            $stmt = $conn->prepare("INSERT INTO `orders`( `user_id`,`product_id`,`created_at`) VALUES (:user_id,:product_id,CURRENT_TIMESTAMP)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':product_id', $product);
            $stmt->execute();
        } catch (PDOException $e) {

            $response['error'] = true;
            $response["status"] = "fail";
            $response['message'] =  $e->getMessage();
            die();
        }
    }
    $response['error'] = false;
    $response["status"] = "success";
    $response['message'] = 'Created Successfully';
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
