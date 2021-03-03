<?php

ob_start();
include('../includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['user_id'])) {

        header('location:../login.php');
    }
}



// ----------------------------------------------------------------------------------
// Add data
// ------------------------------------------------------------------------------

if (isset($_POST['add-submit'])) {

    
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$address = $_POST["address"];
$role = 2;
$status = $_POST["status"];



    $created_by = $_SESSION["user_id"];
    $query = $conn->prepare("SELECT email FROM users WHERE `email` LIKE '$email'");
    $query->execute();

    $response_arr[] = null;

    if ($query->rowCount() > 0) {

        $response_arr[0] = "fail";
        $response_arr[1] = '<div class="alert alert-danger alert-dismissible" role="alert">
    <strong>Oops!</strong> *This Email ' . $email . ' Already Exists!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';

        echo json_encode($response_arr);
    } else {



        $stmt = $conn->prepare("INSERT INTO `users`( `name`,`email`,`password`,`role`,`address`,`status`,`created_by`,`created_at`) VALUES (:name,:email,:password,:role,:address,:status,:created_by ,CURRENT_TIMESTAMP)");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_by', $created_by);

        if ($stmt->execute()) {

            $response_arr[0] = "success";

            $response_arr[1] = ' <div class="alert alert-success alert-dismissible" role="alert">
        <strong>Congrats!</strong> Successfully Added
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';

            echo json_encode($response_arr);
        } else {
            $response_arr[0] = "fail";
            $response_arr[1] = '<div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Oops!</strong> *Something Went Wrong!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';

            echo json_encode($response_arr);
        }
    }
}


// ----------------------------------------------------------------------------------
// Update data
// ------------------------------------------------------------------------------

if (isset($_POST['upd-submit'])) {

    
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$address = $_POST["address"];
$role = 2;
$status = $_POST["status"];



    $vendor_id = $_POST["vendor_id"];

    $updated_by = $_SESSION["user_id"];

    $query = $conn->prepare("SELECT email FROM users WHERE `email` LIKE '$email' and id!='$vendor_id'");
    $query->execute();

    $response_arr[] = null;

    if ($query->rowCount() > 0) {

        $response_arr[0] = "fail";
        $response_arr[1] = '<div class="alert alert-danger alert-dismissible" role="alert">
    <strong>Oops!</strong> *This Email ' . $email . ' Already Exists!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';

        echo json_encode($response_arr);
    } else {


        $stmt = $conn->prepare("UPDATE `users` SET name=:name,email=:email, password=:password,role=:role,address=:address,status=:status,updated_by=:updated_by,updated_at=CURRENT_TIMESTAMP WHERE id=:id");


        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':updated_by', $updated_by);

        $stmt->bindParam(':id', $vendor_id);


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
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';

            echo json_encode($response_arr);
        }
    }
}



// ----------------------------------------------------------------------------------
// Delete data
// ------------------------------------------------------------------------------


if (isset($_GET['id'])) {

    $del_id=$_GET["id"];

    $del = $conn->prepare("DELETE FROM users WHERE id='$del_id'");

    if ($del->execute()) {
        header("location:../all_vendors.php?status=del_succ");
    } else {
        header("location:../all_vendors.php?status=del_fai;");
    }
}
