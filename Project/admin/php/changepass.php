<?php
$con = mysqli_connect("localhost", "root", "", "sms") or die("Connection Failed...");

if (isset($_POST['changepass'])) {
    $id = $_POST['id'];
    $cpass = $_POST['cpass'];
    $newpass = $_POST['npass'];
    $cnewpass = $_POST['cnpass'];

    if($newpass <> $cnewpass)
    {
        echo "<script type='text/javascript'>alert('Both Password Not Matched!');</script>";
        echo "<script type='text/javascript'> document.location = '../change-password.php'; </script>";  
    }
    else{
        $sql = "SELECT * FROM member WHERE M_USERNAME='$id' AND M_PASSWORD='$cpass'";
        $result = $con->query($sql);

        if(mysqli_num_rows($result)>0)
        {
            $sql = "UPDATE member SET M_PASSWORD='$newpass' where M_USERNAME='$id' AND M_PASSWORD='$cpass'";

            if($con->query($sql))
            {
                echo "<script type='text/javascript'>alert('Password Updated Successfully');</script>";
                echo "<script type='text/javascript'> document.location = '../index.php'; </script>";
            }
            else
            {
                echo "<script type='text/javascript'>alert('Invalid Current Password');</script>";
                echo "<script type='text/javascript'> document.location = '../change-password.php'; </script>";  
            }

        }
        else
        {
            echo "<script type='text/javascript'>alert('Invalid Current Password');</script>";
                echo "<script type='text/javascript'> document.location = '../change-password.php'; </script>";
        }

    }

    mysqli_close($con);
}
?>