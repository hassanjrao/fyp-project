<?php
ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['user_id'])) {

        header('location:login.php');
    }
}

// if(!in_array(4,$_SESSION["vendor_access_arr"])){
// 	header('location:index.php');
// }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("includes/head.php"); ?>

    <title>Profile Setting</title>




    <style>
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #map {
            height: 100%;
        }


        #locationField,
        #controls {
            position: relative;
            width: 480px;
        }

        #autocomplete {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 99%;
        }

        .label {
            text-align: right;
            font-weight: bold;
            width: 100px;
            color: #303030;
            font-family: "Roboto", Arial, Helvetica, sans-serif;
        }

        #address {
            border: 1px solid #000090;
            background-color: #f0f9ff;
            width: 480px;
            padding-right: 2px;
        }

        #address td {
            font-size: 10pt;
        }

        .field {
            width: 99%;
        }

        .slimField {
            width: 80px;
        }

        .wideField {
            width: 200px;
        }

        #locationField {
            height: 20px;
            margin-bottom: 2px;
        }
    </style>


    
  


<script>
    // This sample uses the Autocomplete widget to help the user select a
    // place, then it retrieves the address components associated with that
    // place, and then it populates the form fields with those details.
    // This sample requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script
    // src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    let placeSearch;
    let autocomplete;
    const componentForm = {
        // street_number: "short_name",
        // route: "long_name",
        locality: "long_name",
        administrative_area_level_1: "short_name",
        country: "long_name",
        // postal_code: "short_name",


    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search predictions to
        // geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
            document.getElementById("autocomplete"), {
                types: ["geocode"]
            }
        );
        // Avoid paying for data that you don't need by restricting the set of
        // place fields that are returned to just the address components.
        autocomplete.setFields(["address_component", "geometry"]);
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocomplete.addListener("place_changed", fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        const place = autocomplete.getPlace();

        console.log(place);

        for (const component in componentForm) {
            document.getElementById(component).value = "";
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        for (const component of place.address_components) {
            const addressType = component.types[0];

            if (componentForm[addressType]) {
                const val = component[componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }

        document.getElementById("lati").value = "";
        document.getElementById("lati").disabled = false;

        document.getElementById("lngt").value = "";
        document.getElementById("lngt").disabled = false;

        document.getElementById("lati").value = place.geometry.location.lat();
        document.getElementById("lngt").value = place.geometry.location.lng();
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                const circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy,
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAj9usER0ugIW7lhWuU7NKDEq_gtNM0-zQ&callback=initAutocomplete&libraries=places&v=weekly" async></script>

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

                    <a href="#">Profile Settings</a>
                </li>
                <li class="active">

                    <strong>Edit Profile</strong>
                </li>
            </ol>

            <h2>Edit Profile</h2>
            <br />


            <div class="row">
                <div class="notification-div">
                </div>
                <div class="col-md-12">

                    <div id="notification-div">
                    </div>

                    <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                Edit Profile
                            </div>

                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

                            </div>
                        </div>

                        <div class="panel-body">

                            <?php

                            $vendor_id = $_SESSION["user_id"];

                            $query = $conn->prepare("SELECT * FROM users where id='$vendor_id'");
                            $query->execute();
                            $result = $query->fetch(PDO::FETCH_ASSOC);


                            ?>


                            <form id="form" class="form-horizontal form-groups-bordered">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Image</label>

                                    <div class="col-sm-5">

                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">


                                                <img src=" <?php echo $result["image"] != NULL ? "images/vendor_images/" . $result['image'] : "http://placehold.it/200x150" ?>" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                            <div>
                                                <span class="btn btn-white btn-file">
                                                    <span class="fileinput-new">Select image</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="image">
                                                </span>
                                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- <input type="file" name="img"> -->

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Vendor Name</label>

                                    <div class="col-sm-5">
                                        <input type="text" name="name" value="<?php echo $result["name"] == "" || NULL ? "" : $result["name"]; ?>" class="form-control" id="field-1" placeholder="Vendor Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Price Per Litre</label>

                                    <div class="col-sm-5">
                                        <input type="number" name="price_per_litre" value="<?php echo $result["price_per_litre"] == "" || NULL ? "" : $result["price_per_litre"]; ?>" class="form-control" id="field-1" placeholder="Price Per Litre">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Vendor Email</label>

                                    <div class="col-sm-5">
                                        <input required="" type="email" name="email" value="<?php echo $result["email"] == "" || NULL ? "" : $result["email"]; ?>" class="form-control" id="field-1" placeholder="Email">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="field-3" class="col-sm-3 control-label">Vendor Password</label>

                                    <div class="col-sm-5">
                                        <input required="" type="password" name="password" value="<?php echo $result["password"] == "" || NULL ? "" : $result["password"]; ?>" class="form-control" id="field-3" placeholder="Password">
                                    </div>
                                </div>


                                <div class="form-group">




                                    <label for="field-3" class="col-sm-3 control-label">Address</label>


                                    <div class="col-sm-5">
                                        <input id="autocomplete" name="address" class="form-control" value="<?php echo $result['address'] ?>" placeholder="Enter your address" onFocus="geolocate()" type="text" />

                                    </div>

                                </div>


                                <div class="form-group">




                                    <label for="field-3" class="col-sm-3 control-label">City</label>


                                    <div class="col-sm-5">
                                        <input name="city" value="<?php echo $result['city'] ?>" class="field form-control" id="locality" />

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label for="field-3" class="col-sm-3 control-label">State</label>


                                    <div class="col-sm-5">
                                        <input name="state" value="<?php echo $result['state'] ?>" class="field form-control" id="administrative_area_level_1" />

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label for="field-3" class="col-sm-3 control-label">Contry</label>


                                    <div class="col-sm-5">
                                        <input name="country" value="<?php echo $result['country'] ?>" class="field form-control" id="country" />

                                    </div>

                                </div>


                                <input name="lati" type="hidden" value="<?php echo $result['lat'] ?>" class="field" id="lati" />

                                <input name="lngt" type="hidden" value="<?php echo $result['lng'] ?>" class="field" id="lngt" />






                                <input type="hidden" name="vendor_id" value="<?php echo $vendor_id ?>">
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" onclick="sendFormData()" name="upd-submit" class="btn btn-default">Update</button>
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
    <script src="assets/js/fileinput.js"></script>

    <!-- Demo Settings -->
    <script src="assets/js/neon-demo.js"></script>

    <script src="assets/js/jquery.validate.min.js"></script>




    <script>
        function sendFormData() {
            $('#form').validate({ // initialize the plugin
                ignore: [],

                rules: {

                    name: {
                        required: true,

                    },
                    email: {
                        required: true,
                        email: true

                    },
                    password: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                    country: {
                        required: true,
                    }


                },
                submitHandler: function(form) { // for demo
                    var form_data = new FormData($("#form")[0]);



                    console.log(form_data);

                    $.ajax({
                        type: "POST",
                        url: "send_data/send_vendor_profile_data.php",
                        data: form_data,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            var res = $.parseJSON(data);
                            console.log(res);
                            $("#notification-div").html(res[1]);


                            $('html, body').animate({
                                scrollTop: $("#notification-div").offset().top
                            }, 100);

                            // if (res[0] == "success") {
                            //     $("#form")[0].reset();
                            // }
                        }
                    });


                }
            });

            // console.log($("#song-form").validate());


        }
    </script>

</body>

</html>