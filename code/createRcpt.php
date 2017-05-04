<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Employee Home</title>
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            require("connection.php");
            require("header.php");

            $utype = $_SESSION['utype'];

            if(strcmp($utype,"ADMIN")==0)
                include("admNav.html");
            else if(strcmp($utype,"EMPLOYEE")==0)
                include("empNav.html");
            else if(strcmp($utype,"CUSTOMER")==0)
                include("custNav.html");

            $_SESSION['step'] = "first";
        ?>
        <h2><br /><center>Make a Payment</center><br /></h2>
        <div align="left|right|center|justify" class="container" style="width:900px">
            <form class="form-back" method="POST" action="rcptSave.php" width="900px">
                <table border="1" class="table" width="900px">
                    <tr>
                        <td>Customer ID</td>
                        <td><input class="form-control" type="text" name="cid"></td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td><input class="form-control" type="text" name="rdate"></td>
                    </tr>
                </table>
                <input style="width:300px" class="btn btn-lg btn-default" type="submit" value="Proceed">
            </form>
        </div>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    </body>
</html>
