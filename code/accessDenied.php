<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Access Denied</title>
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <?php
            session_start();
            require("connection.php");
            //echo $_SESSION['utype'];
            //echo $_SESSION['UserID'];
            require("header.php");
        ?>
        <br />
        <br />
        <br />
        <br />
        <h3 align='center'><br />Access Denied.<br /></h3>
        <form name='back' action='home.php'>
            <center><button class='btn btn-lg btn-default' type='submit' name='Home'>Home</button></center>
        </form>

    </body>
</html>



		