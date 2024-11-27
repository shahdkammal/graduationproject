<?php
// define('MYSITE', true);
include '../db/dbconnect.php';


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
 if (!isset($_SESSION['username'])) { die("No user is logged in.");
 }
 $logged_in_username = $_SESSION['username'];

$user_query = "SELECT password FROM login WHERE username = ?";
 $user_stmt = $conn->prepare($user_query);
  $user_stmt->bind_param("s", $logged_in_username);
   $user_stmt->execute();
    $user_result = $user_stmt->get_result();
     $user_data = $user_result->fetch_assoc();
      if ($user_data) { $current_password_hash = $user_data['password'];
          
         } else { echo "No user found with username: " . htmlspecialchars($logged_in_username) . "<br>";
             exit;
              }  if ($_SERVER["REQUEST_METHOD"] == "POST") { $current_password = $_POST['current_password'];
                 $new_password = $_POST['new_password'];
                  $confirm_password = $_POST['confirm_password'];
                  if (password_verify($current_password, $current_password_hash)) { 
                     if ($new_password === $confirm_password) {
                         $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                           $update_query = "UPDATE login SET password = ? WHERE username = ?";
                            $update_stmt = $conn->prepare($update_query);
                             $update_stmt->bind_param("ss", $new_password_hash, $logged_in_username); 
                             if ($update_stmt->execute()) { echo "Password changed successfully!";
                                 echo '<br><a href="customer_profile.php" class="btn btn-primary mt-3">Return to Profile</a>';
                                  } else { echo "Error updating password."; 
                                } $update_stmt->close();
                            } else { echo "New passwords do not match.";
                             } } else { echo "Current password is incorrect.";
                             } }
                      $user_stmt->close(); 
                      $conn->close();