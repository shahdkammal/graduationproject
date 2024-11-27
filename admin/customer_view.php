<?php
// Includes the database connection file
include '../db/dbconnect.php';

// session_start();
// Includes the admin header file.
include 'assets/include/admin_header.php';
?>



<div class="col-sm-9 col-xs-12 content pt-3 pl-0">


    <div class="row ">
        <div class="col-lg-5">

            <h5 class="mb-0"><strong>Customer</strong></h5>
            <span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> View Customer Details</span>
        </div>
        <div class="col-md-auto col-lg-7">  

            <!-- Message section -->
            <?php
            //Alert OR Error Message:
            // Checks if there is a 'status' message stored in the session.
            if (isset($_SESSION['status'])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success! </strong> ' . $_SESSION['status'] . '
                        
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                unset($_SESSION['status']);
            } elseif (isset($_SESSION['statusfail'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Success! </strong> ' . $_SESSION['statusfail'] . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                unset($_SESSION['statusfail']);
            }
            ?>




        </div>
    </div>


    <?php

    ?>


    <div class="row mt-3">
        <!-- A row division with top margin of 3 units. -->
        <div class="col-sm-12">
            <!-- A column division that spans the entire width on small screens and upwards. -->
            <!--Datatable-->
            <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
                <!-- A styled container with top margin, bottom margin, padding, white background, border, and shadow. -->

                <div class="table-responsive">
                    <!-- A responsive container for tables. -->
                    <table id="example" class="table table-striped table-bordered">
                        <!-- class="table": This is a Bootstrap class that styles the table with default Bootstrap table styling, making it look neat and organized. -->
                        <!-- class="table-striped": Another Bootstrap class that adds zebra-striping to the table rows. This means that alternate rows will have different background colors, making it easier to read across rows. -->
                        <!-- class="table-bordered": This Bootstrap class adds borders around all the cells in the table, making the table easier to distinguish from its surroundings. -->
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Pincode</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php // CUSTOMER VIEW CODE. Data get from CUSTOMER & CITY table using inner joinn becase we need "city name" from city table.
                            $sql = "SELECT `customer`.* , `city`.*
                            FROM `customer` INNER JOIN `city` 
                            ON `customer`.city_id=`city`.city_id";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                $sno = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $sno = $sno + 1;
                                    // Serial number ($sno)
                                    $login_id = $row['login_id'];
                                    $customer_id = $row['customer_id'];
                                    $first_name = $row['first_name'];
                                    $last_name = $row['last_name'];
                                    $email = $row['email'];
                                    $phone = $row['phone'];
                                    $city = $row['city_name'];
                                    $address = $row['address'];
                                    $pincode = $row['pincode'];

                            ?>
                                    <tr>
                                        <td><?php echo $sno ?></td>
                                        <td><?php echo $first_name." ".$last_name  ?></td>
                                        <td><?php echo $email ?></td>
                                        <td><?php echo $phone ?></td>
                                        <td><?php echo $city ?></td>
                                        <td><?php echo $address ?></td>
                                        <td><?php echo $pincode ?></td>
                                        <!-- <td><a href=""> <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-close"></i></button></a></td> -->
                                    </tr>

                            <?php
                                }
                            }
                            ?>


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sno.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Pincode</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!--/Datatable-->


            <!-- try-start-jsgrid BASIC SCENARIO-->
            <!-- <div class="row mt-3">
                <div class="col-sm-12">
    
                    <div class="mt-1 mb-4 p-3 button-container bg-white border shadow-sm">
                        <h6 class="mb-2">Basic Scenario</h6>

                        <div id="jsGrid"></div>
                    </div>
                 

                </div>
            </div> -->
            <!-- try-end-jsgrid BASIC SCENARIO -->


        </div>
    </div>






    <!-- Page JavaScript Files-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <!--Popper JS-->
    <script src="assets/js/popper.min.js"></script>
    <!--Bootstrap-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!--Sweet alert JS-->
    <script src="assets/js/sweetalert.js"></script>
    <!--Progressbar JS-->
    <script src="assets/js/progressbar.min.js"></script>
    <!--Charts-->
    <!--Canvas JS-->
    <script src="assets/js/charts/canvas.min.js"></script>
    <!--Bootstrap Calendar JS-->
    <script src="assets/js/calendar/bootstrap_calendar.js"></script>
    <script src="assets/js/calendar/demo.js"></script>
    <!--Bootstrap Calendar-->
    <!--Datatable-->
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <!--JsGrid table-->
    <script src="assets/js/jsgrid.min.js"></script>
    <script src="assets/js/jsgrid-demo.php"></script>

    <!--Custom Js Script-->
    <script src="assets/js/custom.js"></script>
    <!--Custom Js Script-->

    <script>
        $('#example').DataTable();
    </script>
    <?php
    include 'assets/include/admin_footer.php';
    ?>