
<?php

ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['user_id'])) {

        header('location:login.php');
    }
}

if($_SESSION['role']!=2){
    header('location:index.php');
}

$request=NULL;

if (isset($_GET['id'])) {

    $del_id = $_GET["id"];

    try {
       
        $del = $conn->prepare("DELETE FROM products WHERE id='$del_id'");
        $del->execute();

        $request="success";

        header("location: all_products.php?request=$request");

      } catch(PDOException $e) {
        $request= "<br>" . $e->getMessage();
        header("location: all_products.php?request=$request");
      }


}
else{
    header("location: all_products.php");   
}


ob_end_flush();

?>
