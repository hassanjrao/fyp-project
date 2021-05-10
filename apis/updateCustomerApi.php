<?php

//The api which is used by c# application to fetch the data from server.

ob_start();
include('../includes/db.php');


$response = array();

if (isTheseParametersAvailable(array('customer_id', 'customer_name', 'customer_email', 'customer_password', 'customer_address'))) {

    $customer_name = $_POST["customer_name"];
    $customer_email = $_POST["customer_email"];
    $customer_password = $_POST["customer_password"];
    $customer_address = $_POST["customer_address"];
    $customer_role = 3;
    $customer_status = "active";
    $created_by = "1";

    $customer_id = $_POST["customer_id"];


    $query = $conn->prepare("SELECT email FROM users WHERE `email` LIKE '$customer_email' and id!='$customer_id'");
    $query->execute();



    if ($query->rowCount() > 0) {
        $response['error'] = true;
        $response["status"] = "fail";
        $response["message"] = "Email Already Exist!";
    } else {


        if (isset($_POST["customer_image"])) {

            // && $_FILES['customer_image']['size'] == 0)

            $folder = "../images/customer_images/";
            $customer_image =  $_FILES['customer_image']['name'];
            $path = $folder . $customer_image;

            move_uploaded_file($_FILES['customer_image']['tmp_name'], $path);

            $stmt = $conn->prepare("UPDATE `users` SET name=:name,email=:email, password=:password,address=:address,image=:image,updated_by=:updated_by,updated_at=CURRENT_TIMESTAMP WHERE id=:id");


            $stmt->bindParam(':name', $customer_name);
            $stmt->bindParam(':email', $customer_email);
            $stmt->bindParam(':password', $customer_password);
            $stmt->bindParam(':address', $customer_address);
            $stmt->bindParam(':customer_image', $customer_image);
            $stmt->bindParam(':updated_by', $updated_by);

            $stmt->bindParam(':id', $customer_id);
        } else {


            $stmt = $conn->prepare("UPDATE `users` SET name=:name,email=:email, password=:password,address=:address,updated_by=:updated_by,updated_at=CURRENT_TIMESTAMP WHERE id=:id");


            $stmt->bindParam(':name', $customer_name);
            $stmt->bindParam(':email', $customer_email);
            $stmt->bindParam(':password', $customer_password);
            $stmt->bindParam(':address', $customer_address);
            $stmt->bindParam(':updated_by', $created_by);

            $stmt->bindParam(':id', $customer_id);
        }




        if ($stmt->execute()) {
            $response['error'] = false;
            $response["status"] = "success";
            $response['message'] = 'Updated Successfully';
        }
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
