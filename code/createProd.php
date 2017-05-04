<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Add Product</title>
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

        <h2><br /><center>Add Product</center><br /></h2>
        <div align="left|right|center|justify" class="container" style="width:900px">
            <form method="POST" action="prodSave.php">
                <table width="900px">
                    <tr>
                        <td>Name</td>
                        <td><input class="form-control" type="text" name="pname"><br /></td>
                    </tr>
                    <tr>
                        <td>Rate</td>
                        <td><input class="form-control" type="text" name="prate"><br /></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><input class="form-control" type="text" name="pdesc"><br /></td>
                    </tr>
                </table>
                <input style="width:300px" class="btn btn-lg btn-default" type="submit" value="Save">
            </form>
        </div>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    </body>
</html>