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

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
} else {
    header('location:index.php');
}

$request = NULL;

if (isset($_POST['upd-submit'])) {


    $litre = $_POST["litre"];
    $price = $_POST["price"];
    $product_name=$_POST["product_name"];

    $product_id = $_POST["product_id"];


    try {

        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_FILES['image']['size'] == 0) {

            $stmt = $conn->prepare("UPDATE `products` SET product_name=:product_name, litre=:litre,price=:price, updated_at=CURRENT_TIMESTAMP WHERE id=:id");

            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':litre', $litre);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':id', $product_id);
        } else {

            $folder = "images/product_images/";
            $image = time().$_FILES['image']['name'];
            $path = $folder . $image;
        
            move_uploaded_file($_FILES['image']['tmp_name'], $path);


            $stmt = $conn->prepare("UPDATE `products` SET   product_image=:product_image, product_name=:product_name, litre=:litre,price=:price, updated_at=CURRENT_TIMESTAMP WHERE id=:id");

            $stmt->bindParam(':product_image', $image);
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':litre', $litre);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':id', $product_id);
        }

        // use exec() because no results are returned
        $stmt->execute();

        $request = "success";
    } catch (PDOException $e) {

        $request =  "<br>" . $e->getMessage();
    }
}







?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("includes/head.php"); ?>

    <title>Edit Product</title>
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

                    <strong>Edit Product</strong>
                </li>
            </ol>

            <h2>Edit Product</h2>
            <br />


            <div class="row">
                <div class="col-md-12">



                    <?php

                    if (isset($request)) {

                        if ($request == "success") {
                    ?>

                            <div class="alert alert-success alert-dismissible" role="alert">
                                <strong>Congrats!</strong> Successfully Updated
                                <hr> <a href="all_products.php">Back to all Products</a>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        <?php
                        } else {
                        ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <strong>Oops!</strong> *Something Went Wrong! <?php echo $request ?>
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
                                Edit Product Info
                            </div>

                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

                            </div>
                        </div>

                        <div class="panel-body">



                            <?php





                            $query = $conn->prepare(
                                "SELECT * from products where id='$product_id' "
                            );

                            $query->execute();

                            $result = $query->fetch(PDO::FETCH_ASSOC);

                            ?>




                            <form method="post" id="form" class="form-horizontal form-groups-bordered" enctype="multipart/form-data">

                                <input type="hidden" name="product_id" value=<?php echo $product_id; ?>>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Image Upload</label>

                                    <div class="col-sm-5">

                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                                <img src=" <?php echo $result["product_image"] != NULL ? "images/product_images/" . $result['product_image'] : "http://placehold.it/200x150" ?>" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                            <div>
                                                <span class="btn btn-white btn-file">
                                                    <span class="fileinput-new">Select image</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="image" required>
                                                </span>
                                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Product Name</label>

                                    <div class="col-sm-5">
                                        <input type="text" name="product_name" class="form-control" value="<?php echo $result["product_name"] ?>" placeholder="Product Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Litres</label>

                                    <div class="col-sm-5">
                                        <input type="number" oninput="getPrice(<?php echo $_SESSION['price_per_litre'] ?>)" name="litre" class="form-control" id="litre" placeholder="Litres" value="<?php echo $result["litre"] ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Price</label>

                                    <div class="col-sm-5">
                                        <input required="" type="number" name="price" class="form-control" id="price" placeholder="Price" value="<?php echo $result["price"] ?>">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" name="upd-submit" class="btn btn-default">Update</button>
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
    <script src="assets/js/fileinput.js"></script>



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