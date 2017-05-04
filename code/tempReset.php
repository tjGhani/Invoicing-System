<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Reset Password</title>
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <?php

            session_start();
            require("connection.php");
            require("header.php");
            if(strcmp($_SESSION['utype'],"ADMIN")==0)
                include("admNav.html");
            else if(strcmp($_SESSION['utype'],"EMPLOYEE")==0)
                include("empNav.html");
            else if(strcmp($_SESSION['utype'],"CUSTOMER")==0)
                include("custNav.html");

            $UserID = $_SESSION['UserID'];

            $sql="SELECT * FROM USERS WHERE USER_ID=" . $UserID;
            $almost=oci_parse($conn,$sql);

            oci_define_by_name($almost, 'UPASSWORD', $uoldPass);

            $resultA = oci_execute($almost);
            $temp = oci_fetch($almost);

            $old_Pass = $_POST['oldPassword'];
            $new_Pass = $_POST['newPassword'];
            $conf_Pass = $_POST['confPassword'];

            if ($uoldPass == $old_Pass) {

                if (strcmp($new_Pass,$conf_Pass)==0) {

                    $sql1="UPDATE USERS SET UPASSWORD='" . $new_Pass . "' WHERE UPASSWORD='" . $old_Pass . "'";
                    //echo $sql1;

                    $result=oci_parse($conn,$sql1);
                    oci_execute($result);

                    echo "<br /><br /><br /><h3><center>Password Reset!</center></h3>";
                    $hi = 0;

                    //header("location:home.php");
                }
                else {
                    $hi = 1;
                    echo "<p align='center'><br />New Password and Confirmation don't match!<br /></p>";
                }
            }
            else {
                $hi =1;
                echo "<p align='center'><br />Old Password is incorrect!<br /></p>";
            }
        ?>
        <div align="center" class="container" style="width:600px">
            <form name="backToRes" method="post" action="resetpassword.php">
                <?php
                    if($hi==1) {
                        echo "<button class='btn btn-lg btn-default' type='submit' name='backToRes'>Back to Reset Password</button>";
                    }
                ?>

            </form>
        </div>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    </body>
</html>

