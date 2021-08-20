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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("includes/head.php"); ?>

    <title>All Orders</title>
</head>

<body class="page-body" data-url="http://neon.dev">

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
                    <a href="index.html"><i class="fa-home"></i>Home</a>
                </li>
                <li>

                    <a href="#">orders</a>
                </li>
                <li class="active">

                    <strong>All orders</strong>
                </li>
            </ol>

            <h2>All orders</h2>

            <?php

            if (isset($_GET["status"])) {


                if ($_GET["status"] == "del_succ") {

            ?>
                    <br>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <strong>Congrats!</strong> Successfully Deleted
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
                }
                if ($_GET["status"] == "del_fail") {

                ?>
                    <br>
                    <div class="alert alert-success alert-danger" role="alert">
                        <strong>Congrats!</strong> Something Went Wrong, Deltetion Failed
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            <?php
                }
            }

            ?>


            <br />


            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    var $table1 = jQuery('#table-2');

                    // Initialize DataTable
                    $table1.DataTable({
                        "aLengthMenu": [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        "bStateSave": true
                    });

                    // Initalize Select Dropdown after DataTables is created
                    $table1.closest('.dataTables_wrapper').find('select').select2({
                        minimumResultsForSearch: -1
                    });
                });
            </script>



            <!-- <h3>Table without DataTable Header</h3> -->


            <table class="table table-bordered datatable  dt-responsive nowrap" id="table-2">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Product</th>

                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php


                    $i = 1;

                    $user_id = $_SESSION["user_id"];

                    // var_dump($user_id);

                    $query = $conn->prepare(
                        "SELECT * from orders join products on orders.product_id=products.id where orders.vendor_id='$user_id' order by orders.id desc"
                    );
                    $query->execute();

                    // var_dump($query->fetch(PDO::FETCH_ASSOC));
                    while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                        $v_id = $result["vendor_id"];

                        $query2 = $conn->prepare(
                            "SELECT * from users  where users.id='$v_id'"
                        );
                        $query2->execute();

                        // var_dump($query->fetch(PDO::FETCH_ASSOC));
                        while ($result2 = $query2->fetch(PDO::FETCH_ASSOC)) {

                    ?>

                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $result2["name"]; ?></td>
                                <td><?php echo $result2["email"]; ?></td>
                                <td><?php echo $result2["address"]; ?></td>
                                <td><?php echo $result2["city"]; ?></td>
                                <td><?php echo $result["product_name"]; ?></td>




                                <td>
                                    <a href="#" class="btn btn-default btn-sm btn-icon icon-left">
                                        <i class="entypo-pencil"></i>
                                        Dispatch
                                    </a>



                                </td>
                            </tr>

                    <?php
                        }
                    } ?>







                </tbody>
            </table>

            <br />


            <br />
            <!-- Footer starts -->
            <?php include_once("includes/footer.php"); ?>
            <!-- Footer end -->
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