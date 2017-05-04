<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Create Customer</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/css/style.css" rel="stylesheet">
    </head>
    <body>
        <br />
        <?php
            session_start();
   			require("connection.php");
			require("empHeader.php");
            include("empNav.html");

		?>
        <h2><br /><center>Create a Customer</center><br /></h2>
        <form method="POST" action="userCreate.php">
            <div align="left|right|center|justify" class="container" style="width:900px">
                <table width="900px">
                    <tr>
                        <td>First Name<br /></td>
                        <td>
                            <input type="text" name="txtUfname" class="form-control"> </input>
                            <br />
                        </td>
                    </tr>
                    <tr>
                        <td>Last Name<br /></td>
                        <td>
                            <input type="text" name="txtUlname" class="form-control"> </input>
                            <br />
                        </td>
                    </tr>
                    <tr>
                        <td>Phone No.<br /></td>
                        <td>
                            <input type="number" name="txtUphone" class="form-control"> </input>
                            <br />
                        </td>
                    </tr>
                    <tr>
                        <td>Email<br /></td>
                        <td>
                            <input type="text" name="txtUemail" class="form-control"> </input>
                            <br />
                        </td>
                    </tr>
                </table>
            </div>
            <div class="btn-group" role="group">
                <button class="btn btn-lg btn-default" type="submit" value="createCust">Create</button>
            </div>
        </form>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    </body>
</html>