
<?php

ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['user_id'])) {

        header('location:login.php');
    }
}

if ($_SESSION['role'] != 2) {
    header('location:index.php');
}

$request = NULL;

if (isset($_GET['id'])) {

    $del_id = $_GET["id"];

    try {

        $query = $conn->prepare(
            "SELECT * from order_items WHERE product_id='$del_id' "
        );
        $query->execute();

        $order_arr = array();
        while ($result = $query->fetch(PDO::FETCH_ASSOC)) {



            $order_id = $result["order_id"];

            array_push($order_arr,$order_id);

            $del = $conn->prepare("DELETE FROM order_items WHERE order_id='$order_id'");
            $del->execute();

            $del = $conn->prepare("DELETE FROM orders WHERE id='$order_id'");
            $del->execute();
        }

        // foreach ($order_arr as $key => $id) {
        //     # code...

        //     $del = $conn->prepare("DELETE FROM orders WHERE id='$id'");
        //     $del->execute();
        // }



        $del = $conn->prepare("DELETE FROM products WHERE id='$del_id'");
        $del->execute();

        $request = "success";

        header("location: all_products.php?request=$request");
    } catch (PDOException $e) {
        $request = "<br>" . $e->getMessage();
        header("location: all_products.php?request=$request");
    }
} else {
    header("location: all_products.php");
}


ob_end_flush();

?>
