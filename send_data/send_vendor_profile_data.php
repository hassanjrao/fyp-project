<?php

ob_start();
include('../includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['user_id'])) {

        header('location:../login.php');
    }
}



if (isset($_POST['upd-submit'])) {


    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $address = $_POST["address"];
    $vendor_id = $_POST["vendor_id"];

    $updated_by = $_SESSION["user_id"];



    $query = $conn->prepare("SELECT email FROM users WHERE `email` LIKE '$email' and id!='$vendor_id'");
    $query->execute();

    $response_arr[] = null;

    if ($query->rowCount() > 0) {

        $response_arr[0] = "fail";
        $response_arr[1] = '<div class="alert alert-danger alert-dismissible" role="alert">
<strong>Oops!</strong> *This Email ' . $email . ' Already Exists!

</div>';

        echo json_encode($response_arr);
    } else {

        if ($_FILES['image']['size'] == 0) {

           

            $stmt = $conn->prepare("UPDATE `users` SET name=:name,email=:email, password=:password,address=:address,updated_by=:updated_by,updated_at=CURRENT_TIMESTAMP WHERE id=:id");


            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':updated_by', $updated_by);

            $stmt->bindParam(':id', $vendor_id);
        } else {


           
            $folder = "../images/vendor_images/";
            $image =  $_FILES['image']['name'];
            $path = $folder . $image;

            move_uploaded_file($_FILES['image']['tmp_name'], $path);

            $stmt = $conn->prepare("UPDATE `users` SET name=:name,email=:email, password=:password,address=:address,image=:image,updated_by=:updated_by,updated_at=CURRENT_TIMESTAMP WHERE id=:id");


            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':updated_by', $updated_by);

            $stmt->bindParam(':id', $vendor_id);
        }





        if ($stmt->execute()) {


            $response_arr[0] = "success";

            $response_arr[1] = ' <div class="alert alert-success alert-dismissible" role="alert">
    <strong>Congrats!</strong> Successfully Updated <hr> <a href="all_vendors.php">Back to all vendors</a>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';

            echo json_encode($response_arr);
        } else {
            $response_arr[0] = "fail";
            $response_arr[1] = '<div class="alert alert-danger alert-dismissible" role="alert">
    <strong>Oops!</strong> *Something Went Wrong!
   
</div>';

            echo json_encode($response_arr);
        }
    }
}
