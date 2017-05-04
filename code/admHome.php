<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Admin Home</title>
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/css/style.css" rel="stylesheet">
    </head>
    <body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Accounts Receivable</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Sign In</a>
                    </li>
                    <li>
                        <a href="#">About</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
        <?php

            //session_start();
            require("connection.php");
            require("admHeader.php");

            $UserID = $_SESSION['UserID'];
            $uname = $_SESSION['uname'];

            echo "<h2><br />My Account - Admin $UserID - Welcome $uname!<br /></h2>";

        ?>

        <br />

        <div class="btn-group-vertical" role="group">
            <form class="form-pickaction" id="content">
                <button class="btn btn-default" type="submit" name="mngUser" onclick="form.action='adminMngUser.php';">Manage Users</button>
                <button class="btn btn-default" type="submit" name="mngUserRight">Manage User Rights</button>
                <button class="btn btn-default" type="submit" name="mngWrkflw">Manage Workflow</button>
                <button class="btn btn-default" type="submit" name="dataBack">Data Backup</button>
                <button class="btn btn-default" type="submit" name="respass" onclick="form.action='resetpassword.php';">Reset Password</button>
                <button class="btn btn-default" type="submit" name="logout" onclick="form.action='logout.php';">Logout</button>
            </form>
        </div>
        <div class="content" id="stuff" style="text-align:center">
            <br />
            <h3> Pick an Action </h3>
        </div>
    </body>
</html>