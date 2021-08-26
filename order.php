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

if (!isset($_GET["order_id"])) {
    header('location:all_orders.php');
} else {
    $order_id = $_GET["order_id"];
    $user_id = $_SESSION["user_id"];
    $query = $conn->prepare(
        "SELECT orders.id order_id, orders.created_at order_date, orders.total_price, users.* from orders join users on orders.customer_id=users.id  where orders.id='$order_id' order by orders.id desc"
    );
    $query->execute();

    // var_dump($query->fetch(PDO::FETCH_ASSOC));
    $order = $query->fetchAll(PDO::FETCH_OBJ);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("includes/head.php"); ?>

    <title>Order #<?php $order_id ?></title>
</head>

<body class="page-body" data-url="http://neon.dev">

    <div class="page-container">
        <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

        <!-- leftbar starts -->

        <?php include_once("includes/left-bar.php"); ?>

        <!-- leftbar ends -->


        <div class="main-content">


            <ol class="breadcrumb bc-2 hidden-print">
                <li>
                    <a href="index.php">
                        <i class="fa-home"></i>Home
                    </a>
                </li>
                <li>
                    <a href="#">Order #<?php echo $order_id ?></a>
                </li>
                <li class="active">
                    <strong>Order Details</strong>
                </li>
            </ol>
            <br class="hidden-print">
            <div class="invoice">
                <div class="row">
                    <div class="col-sm-6 invoice-left">
                        <a href="#">
                            <img src=" <?php echo $_SESSION["user_image"] != NULL ? "images/vendor_images/" . $_SESSION["user_image"] : "assets/images/thumb-1@2x.png" ?>" alt="" class="img-circle" width="55" />
                            <b><?php echo ucwords($_SESSION["user_name"]); ?></b>
                        </a>
                    </div>
                    <div class="col-sm-6 invoice-right">
                        <h3>Order Id. <?php $order_id ?></h3>
                        <span><?php echo $order[0]->order_date ?></span>
                    </div>
                </div>
                <hr class="margin">
                <div class="row">
                    <div class="col-sm-3 invoice-left">
                        <h4>Customer details</h4>
                        <b> <?php echo $order[0]->name; ?></b>

                    </div>
                    <div class="col-sm-3 invoice-left">
                        <h4>&nbsp;</h4>
                        <b> <?php echo $order[0]->address ?></b>
                        <br>
                        <b> <?php echo $order[0]->city . "," . $order[0]->state . "," . $order[0]->country ?></b>
                    </div>
                    <!-- <div class="col-md-6 invoice-right">
                        <h4>Payment Details:</h4>
                        <strong>V.A.T Reg #:</strong>
                        542554(DEMO)78
                        <br>
                        <strong>Account Name:</strong>
                        FoodMaster Ltd
                        <br>
                        <strong>SWIFT code:</strong>
                        45454DEMO545DEMO
                    </div> -->
                </div>
                <div class="margin"></div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th width="60%">Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

$i=1;
                        $query = $conn->prepare(
                            "SELECT * from order_items join products on order_items.product_id=products.id where order_id='$order_id'"
                        );
                        $query->execute();

                        // var_dump($query->fetch(PDO::FETCH_ASSOC));
                        while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                        ?>

                            <tr>
                                <td class="text-center"><?php echo $i++ ?></td>
                                <td><?php echo $result["product_name"] ?></td>
                                <td><?php echo $result["quantity"] ?></td>
                                <td class="text-right"><?php echo $result["price"] ?>Pkr</td>
                            </tr>

                        <?php
                        }
                        ?>

                    </tbody>
                </table>
                <div class="margin"></div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- <div class="invoice-left">
                            795 Park Ave, Suite 120
                            <br>
                            San Francisco, CA 94107
                            <br>
                            P: (234) 145-1810
                            <br>
                            Full Name
                            <br>
                            first.last@email.com
                        </div> -->
                    </div>
                    <div class="col-sm-6">
                        <div class="invoice-right">
                            <ul class="list-unstyled">
                                <!-- <li>
                                    Sub - Total amount:
                                    <strong>$6,487</strong>
                                </li>
                                <li>
                                    VAT:
                                    <strong>12.9%</strong>
                                </li>
                                <li>
                                    Discount:
                                    -----
                                </li> -->
                                <li>
                                    Grand Total:
                                  
                                    <strong><?php echo $order[0]->total_price ?></strong>
                                </li>
                            </ul>
                            <br>
                            <a href="javascript:window.print();" class="btn btn-primary btn-icon icon-left hidden-print">
                                Print Invoice
                                <i class="entypo-doc-text"></i>
                            </a>
                            &nbsp;
                            <!-- <a href="mailbox-compose.html" class="btn btn-success btn-icon icon-left hidden-print">
                                Send Invoice
                                <i class="entypo-mail"></i>
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->

        </div>




    </div>





    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="assets/js/datatables/datatables.css">
    <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
    <link rel="stylesheet" href="assets/js/select2/select2.css">

    <!-- Bottom scripts (common) -->
    <script src="assets/js/gsap/TweenMax.min.js"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/joinable.js"></script>
    <script src="assets/js/resizeable.js"></script>
    <script src="assets/js/neon-api.js"></script>


    <!-- Imported scripts on this page -->
    <script src="assets/js/datatables/datatables.js"></script>
    <script src="assets/js/select2/select2.min.js"></script>
    <script src="assets/js/neon-chat.js"></script>


    <!-- JavaScripts initializations and stuff -->
    <script src="assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="assets/js/neon-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#search-group-table').DataTable({
                responsive: true,


            })

        });
    </script>



</body>

</html>