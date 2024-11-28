<?php
// define('MYSITE', true);
include '../db/dbconnect.php';


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Simulating a logged-in user (Replace this with actual session handling)
session_start();
if (!isset($_SESSION['username'])) {
    echo "You must log in first!";
    exit();
}
$logged_in_username = $_SESSION['username'];




// Fetch previous orders for the logged-in user
$sql = "SELECT service_title FROM user_order WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $logged_in_username);
$stmt->execute();
$result = $stmt->get_result();

// Fetch user details from the `login` table (if additional details are needed)
$user_query = "SELECT * FROM login WHERE username = ?";
$user_stmt = $conn->prepare($user_query);
$user_stmt->bind_param("s", $logged_in_username);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_data = $user_result->fetch_assoc();


?>









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .profile-header {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    
    
    
    <div class="container">
        <br>
        <br>
        <?php
        $user_query = "SELECT login_id FROM login WHERE username = ?";
$user_stmt = $conn->prepare($user_query);
$user_stmt->bind_param("s", $logged_in_username);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_data = $user_result->fetch_assoc();
if ($user_data) { $login_id = $user_data['login_id'];
       
       $address_query = "SELECT address, first_name, last_name, phone, email FROM customer WHERE login_id = ?";
        $address_stmt = $conn->prepare($address_query); 
        $address_stmt->bind_param("i", $login_id); 
        $address_stmt->execute();
         $address_result = $address_stmt->get_result();
          $address_data = $address_result->fetch_assoc(); 
          if ($address_data) { $address = $address_data['address'];
             $first_name = $address_data['first_name'];
              $last_name = $address_data['last_name'];
               $phone = $address_data['phone'];
                $email = $address_data['email'];
                
                } else { echo "No user data found in customer table for login ID: " . $login_id . "<br>";
                 } } else { echo "No login ID found for username: " . $logged_in_username . "<br>";
                 }


                 ?>
   
    <div class="container mt-5"> 
        <div class="profile-header">
             <h2>User Profile</h2>
              <p><strong>First Nameee:</strong>
               <?php echo htmlspecialchars($first_name); ?>
            </p> <p><strong>Last Name:</strong> 
            <?php echo htmlspecialchars($last_name); 
            ?></p>
             <p><strong>Address:</strong>
              <?php echo htmlspecialchars($address);
               ?></p>
                <p><strong>Phone:</strong> 
                <?php echo htmlspecialchars($phone);
                 ?></p>
                  <p><strong>Email:</strong> 
                  <?php echo htmlspecialchars($email); 
                  ?></p>
                   </div> 
                   <div class="change-password mt-5">
                     <h2>Change Password</h2> 
                     <form action="change_password.php" method="POST"> 
                        <div class="form-group"> <label for="current_password">Current Password</label> 
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                     </div>
                      <div class="form-group"> <label for="new_password">New Password</label> <input type="password" class="form-control" id="new_password" name="new_password" required>
                     </div>
                      <div class="form-group"> <label for="confirm_password">Confirm New Password</label> <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                     </div>
                      <button type="submit" class="btn btn-primary">Change Password</button>
                     </form> 
                    </div>
                    <?php
        $customer_id = $_SESSION['customer_id'];
        $query1 = "SELECT * FROM `order_master` WHERE `customer_id` = $customer_id ORDER BY order_id DESC";
        $result1 = mysqli_query($conn, $query1);
        if ($result1 && mysqli_num_rows($result1) > 0) {
            while ($row1 = mysqli_fetch_assoc($result1)) {
                $order_id = $row1['order_id'];
                $full_name = $row1['full_name'];
                $delivery_address = $row1['address'];
                $pay_mode = $row1['pay_mode'];
                $total = $row1['total'];
                $order_date = $row1['order_date'];
                $due_date = $row1['due_date'];
                $estimated_date = date('j F, Y g:i A', strtotime($due_date));
                $real_order_date = date('j F, Y', strtotime($order_date));
        ?>

                <div class="bg-dark p-5">

                    <div class="table-responsive-sm mt-3 ">
                        <table class="table table-hover table-dark p-5 ">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" colspan="5">Order Confirmation <?php echo $order_id; ?> </th>
                                    <th scope="col" colspan="2">Order Date:</th>
                                    <th scope="col" colspan="2"><?php echo $real_order_date; ?> </th>
                                </tr>
                                <tr>
                                    <th scope="col">Sno. </th>
                                    <th scope="col">Service name</th>
                                    <th scope="col">Service prvider name</th>
                                    <th scope="col">Phone(SP)</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Qty.</th>
                                    <th scope="col">Price(&#8377;)</th>
                                    <th scope="col">Total(&#8377;)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sno = 0;
                                $query2 = "SELECT * FROM `user_order` WHERE `order_id` = $order_id";
                                $result2 = mysqli_query($conn, $query2);
                                if ($result2) {
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        $service_title = $row2['service_title'];
                                        $price = $row2['price'];
                                        $qty = $row2['qty'];
                                        $status = $row2['status'];
                                        $sp_id = $row2['sp_id'];
                                        $sno += 1;

                                        $spname = "SELECT * FROM `sp` WHERE sp_id = $sp_id";
                                        $spname_result = mysqli_query($conn, $spname);
                                        while ($sprow = mysqli_fetch_assoc($spname_result)) {
                                            $sp_name = $sprow['sp_name'];
                                            $phone = $sprow['phone'];
                                        }
                                        

                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $sno ?></th>
                                            <td><?php echo $service_title  ?></td>
                                            <td class="align-middle"><?php echo $sp_name  ?></td>
                                            <td><?php echo $phone  ?></td>
                                            <td class="align-middle">
                                                <?php
                                                if ($status == 'pending') {
                                                    echo '<span class="badge badge-warning">Pending</span>';
                                                }
                                                if ($status == 'rejected') {
                                                    echo '<span class="badge badge-danger">Rejected</span>';
                                                }
                                                if ($status == 'inprogress') {
                                                    echo '<span class="badge badge-primary">In Progress</span>';
                                                }
                                                if ($status == 'completed') {
                                                    echo '<span class="badge badge-success">Completed</span>';
                                                }
                                                if ($status == 'uncompleted') {
                                                    echo '<span class="badge badge-secondary">Uncompleted</span>';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $qty  ?></td>
                                            <td><?php echo $price  ?></td>
                                            <td><?php echo $price * $qty  ?></td>
                                        </tr>


                                <?php
                                    } //while row2 end
                                } // if result 2 end

                                ?>
                            </tbody>
                            <!-- total amount -->
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th colspan="4">
                                    <h3>TOTAL</h3>
                                </th>
                                <td>
                                    <h3>&#8377; <?php echo $total ?></h3>
                                </td>
                            </tr>
                            <!-- delivery address -->
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th colspan="4">Delivery Address</th>
                                <td><?php echo $delivery_address ?></td>
                            </tr>
                            <!-- Estimate date -->
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th colspan="4">Estimated Delivery Date</th>
                                <td><?php echo $estimated_date ?></td>
                            </tr>
                            <tr>
                                <th colspan="7"></th>
                                <td>
                                    <form action="../php/invoice.php" method="post">
                                        <button type="submit" name="invoice" class="btn btn-success">Invoice</button>
                                        <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                                        <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>">
                                        <!-- <button class="btn btn-danger">Cancel Order</button> -->
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <br>
                <?php
    } // End of while $row1
} else {
    echo "<p>No orders found.</p>";
} // End of if $result1
?>


    </div>

    <?php
 
    ?>


</body>
</html>
