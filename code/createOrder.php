<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Place Order</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            require("connection.php");
            require("custHeader.php");
            $step = "first";
            $_SESSION['step'] = $step;
            include("custNav.html");
        ?>

        <h2><br /><center>Place Order</center><br /></h2>

        <div align="left|right|center|justify" class="container" style="width:900px">
            <form method="POST" action="ordPlace.php">
                <table class="table" width="900px">
                    <tr>
                        <td>Date</td>
                        <td><input class="form-control" type="text" name="oDate"></td>
                    </tr>
                    <tr>
                        <td>Customer ID</td>
                        <td><input class="form-control" type="text" name="ocID"></td>
                    </tr>
                </table>
                <input style="width:300px" class="btn btn-lg btn-default" type="submit" value="Next">
            </form>
        </div>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    </body>
</html>