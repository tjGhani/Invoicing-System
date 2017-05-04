<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Reset Password</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            require("connection.php");
            require("header.php");
            $utype = $_SESSION['utype'];
            //var_dump($utype);
            if(strcmp($utype,"ADMIN")==0)
                include("admNav.html");
            else if(strcmp($utype,"EMPLOYEE")==0)
                include("empNav.html");
            else if(strcmp($utype,"CUSTOMER")==0)
                include("custNav.html");

        ?>
        <h3><br/><center>Reset Password</center><br/></h3>

        <div class="container" style="width:300px">
            <p align='center'><br />Enter old and new password.<br /></p>
            <form name="tempReset" method="post" action="tempReset.php">
                <label for="oldPassword" class="sr-only">Old Password</label>
                <input type="password" id="oldPassword" name="oldPassword" class="form-control" placeholder="Old Password" required=""/>
                <label for="newPassword" class="sr-only">New Password</label>
                <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="New Password" required=""/>
                <label for="confPassword" class="sr-only">Confirm Password</label>
                <input type="password" id="confPassword" name="confPassword" class="form-control" placeholder="Confirm Password" required=""/>
                <button class="btn btn-lg btn-default" type="submit" name="rpass">Reset Password</button>
            </form>
        </div>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

    </body>
</html>

