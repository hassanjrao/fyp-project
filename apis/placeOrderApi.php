<?php

ob_start();
include('../includes/db.php');

$response = array();


if (isTheseParametersAvailable(array('vendor_id', 'customer_id', 'products','total_price'))) {


    $customer_id = $_POST["customer_id"];
    $vendor_id = $_POST["vendor_id"];

    $total_price=$_POST["total_price"];

 
    try {
        $stmt = $conn->prepare("INSERT INTO `orders`( `vendor_id`,`customer_id`,`total_price`) VALUES (:vendor_id,:customer_id,:total_price)");
        $stmt->bindParam(':vendor_id', $vendor_id);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->execute();

        $order_id = $conn->lastInsertId();
    } catch (PDOException $e) {

        $response['error'] = true;
        $response["status"] = "fail";
        $response['message'] =  $e->getMessage();

        echo json_encode($response);
        die();
    }


  
    foreach ($_POST["products"] as $key => $product) {
        # code...

        try {
            $stmt = $conn->prepare("INSERT INTO `order_items`( `order_id`,`product_id`,`quantity`) VALUES (:order_id,:product_id,:quantity)");
            $stmt->bindParam(':order_id', $order_id);
            $stmt->bindParam(':product_id', $product["product"]);
            $stmt->bindParam(':quantity', $product["quantity"]);
            $stmt->execute();
        } catch (PDOException $e) {

            $response['error'] = true;
            $response["status"] = "fail";
            $response['message'] =  $e->getMessage();

            echo json_encode($response);
            die();
        }
    }
    $response['error'] = false;
    $response["status"] = "success";
    $response['message'] = 'Created Successfully';
} else {
    $response['error'] = true;
    $response["status"] = "fail";
    $response['message'] = 'required parameters are not available asdas';
}

echo json_encode($response);


function isTheseParametersAvailable($params) //method to check whther the varaibles which we recieved from POST request have values or not.
{
    foreach ($params as $param) {
        if (!isset($_POST[$param])) {
            var_dump($_POST[$param]);
            return false;
            
        }
    }
    return true;
}
