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



if (isset($_POST['add-submit'])) {


    $litre = $_POST["litre"];
    $price = $_POST["price"];


    $vendor_id = $_SESSION["user_id"];




    $stmt = $conn->prepare("INSERT INTO `products`(`litre`,`price`,`vendor_id`,`created_at`) VALUES (:litre,:price,:vendor_id,CURRENT_TIMESTAMP)");

    $stmt->bindParam(':litre', $litre);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':vendor_id', $vendor_id);



    if ($stmt->execute()) {

        $request = "success";
    } else {

        $request = "fail";
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("includes/head.php"); ?>

    <title>Add Product</title>
</head>

<body class="page-body">

    <div class="page-container">
        <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

        <!-- leftbar starts -->

        <?php include_once("includes/left-bar.php"); ?>

        <!-- leftbar ends -->

        <div class="main-content">

            <div class="row">

                <!-- header starts-->
                <?php include_once("includes/header.php"); ?>
                <!-- header ends -->

            </div>

            <hr />

            <ol class="breadcrumb bc-3">
                <li>
                    <a href="index.php"><i class="fa-home"></i>Home</a>
                </li>
                <li>

                    <a href="#">Products</a>
                </li>
                <li class="active">

                    <strong>Add Product</strong>
                </li>
            </ol>

            <h2>Add Product <a href="vendor_profile.php"><?php echo " (Price Per Litre " . $_SESSION['price_per_litre'] . " )" ?></a>
            </h2>
            <br />


            <div class="row">
                <div class="col-md-12">

                    <?php

                    if (isset($request)) {

                        if ($request == "success") {
                    ?>

                            <div class="alert alert-success alert-dismissible" role="alert">
                                <strong>Congrats!</strong> Successfully Added
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        <?php
                        } else if ($request == "fail") {
                        ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <strong>Oops!</strong> *Something Went Wrong!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                    <?php
                        }
                    }

                    ?>

                    <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                Add Product Info




                            </div>



                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

                            </div>
                        </div>

                        <div class="panel-body">


                            <form id="form" method="post" class="form-horizontal form-groups-bordered">

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Litres</label>

                                    <div class="col-sm-5">
                                        <input type="number" oninput="getPrice(<?php echo $_SESSION['price_per_litre'] ?>)" name="litre" class="form-control" id="litre" placeholder="Litres">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Price</label>

                                    <div class="col-sm-5">
                                        <input required="" type="number" name="price" class="form-control" id="price" placeholder="Price">
                                    </div>
                                </div>









                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" name="add-submit" class="btn btn-default">Add product</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>





            <!-- Footer starts -->
            <?php include_once("includes/footer.php"); ?>
            <!-- Footer end -->

        </div>




    </div>




    <!-- Bottom scripts (common) -->
    <script src="assets/js/gsap/TweenMax.min.js"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/joinable.js"></script>
    <script src="assets/js/resizeable.js"></script>
    <script src="assets/js/neon-api.js"></script>


    <!-- Imported scripts on this page -->
    <script src="assets/js/bootstrap-switch.min.js"></script>
    <script src="assets/js/neon-chat.js"></script>


    <!-- JavaScripts initializations and stuff -->
    <script src="assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="assets/js/neon-demo.js"></script>

    <script src="assets/js/jquery.validate.min.js"></script>

    <script>
        function getPrice(price_per_litre) {

            var litres = $("#litre").val();

            var price = price_per_litre * litres;

            $("#price").val(price);

            console.log($("#price").val());

        }


        $("#form").validate({
            rules: {
                litre: {
                    required: true,

                },
                price: {
                    required: true,
                },


            },
            messages: {
                litre: {
                    required: "Please Enter Some Value Here",

                },

                price: {
                    required: "Please Enter Some Value Here",
                },

            },

            errorPlacement: function(error, element) {

                error.insertAfter(element);

            },


        })
    </script>

</body>

</html>