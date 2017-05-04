<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Home</title>
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/css/style.css" rel="stylesheet">
    </head>
    <body>

        <?php

            session_start();
            require("connection.php");
            require("header.php");

            $utype = $_SESSION['utype'];
            $uname = $_SESSION['uname'];
            $UserID = $_SESSION['UserID'];

            if(strcmp($utype,"ADMIN")==0) {
                //require("admHeader.php");
                //include("admNav.html");
                header("location:adminHome.php");
            }
            else if(strcmp($utype,"EMPLOYEE")==0) {
                //require("empHeader.php");
                //include("empNav.html");
                header("location:empHome.php");
                //echo "<h2><br /><center>My Account - $utype $UserID - Welcome $uname!</center><br /></h2>";
                //include("displayProduct.php");
            }
            else if(strcmp($utype,"CUSTOMER")==0) {
                //require("custHeader.php");
                //include("custNav.html");
                header("location:custHome.php");
            }

            $utype = ucfirst(strtolower($utype));

            //echo "<h2><br /><center>My Account - $utype $UserID - Welcome $uname!</center><br /></h2>";

        ?>

        <br />
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    </body>
</html>
