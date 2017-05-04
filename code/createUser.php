<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Create User</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/css/style.css" rel="stylesheet">
    </head>
    <>
        <?php
            session_start();
        	require("connection.php");
			require("admHeader.php");
            include("admNav.html");
		?>

        <h2><br /><center>Create User</center><br /></h2>
        <div align="left|right|center|justify" class="container" style="width:900px">
            <form method="POST" action="userCreate.php">
                <table class="table" width="900px">
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
                        <td>User Type<br /></td>
                        <td>
                            <select name="utype" class="form-control">
                                <option value='EMPLOYEE'>EMPLOYEE</option>
                                <option value='CUSTOMER'>CUSTOMER</option>
                            </select>
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
                        <td>Email Address<br /></td>
                        <td>
                            <input type="text" name="txtUemail" class="form-control"> </input>
                            <br />
                        </td>
                    </tr>
                    <tr>
                        <td>Start Date<br /></td>
                        <td>
                            <input type="date" name="dateUSDate" class="form-control"> </input>
                            <br />
                        </td>
                    </tr>
                </table>
                <input style="width:300px" class="btn btn-lg btn-default" type="submit" value="Create">
            </form>
        </div>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    </body>
</html>