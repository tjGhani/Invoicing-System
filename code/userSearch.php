<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Home Page</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/css/style.css" rel="stylesheet">
    </head>
    <body>

        <br />
        <h2><br />Manage Users<br /></h2>

        <form class="form-back" method="POST" width="600px">
            <div class="menu" style="width:300px; vertical-align:middle">
                <button class="btn btn-lg btn-primary btn-block" type="submit" value="createUser" onclick="form.action='createUser.html';">Create User</button>
                <button class="btn btn-lg btn-primary btn-block" type="submit" value="editUser" onclick="form.action='userUpdate.php';">Edit</button>
                <button class="btn btn-lg btn-primary btn-block" type="submit" value="deleteUser" onclick="form.action='userDelete.php';">Delete</button>
                <button class="btn btn-lg btn-primary btn-block" type="submit" value="searchUser" onclick="form.action='searchUser.html'">Search</button>
                <button class="btn btn-lg btn-primary btn-block" type="submit" value="viewIn" onclick="form.action='viewInactive.php';">View Inactive Users</button>
                <button class="btn btn-lg btn-primary btn-block" type="submit" value="back" onclick="form.action='home.php';">Back</button>
            </div>
            <div class="content">
                <table border="1" class="table table-hover">
                    <tr>
                        <th>Check</th>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>Status</th>
                        <th>Log Count</th>
                        <th>Lock Status</th>
                    </tr>

                    <?php
                        session_start();
                        require("connection.php");
                        require("admHeader.php");

                        $param = $_POST['parameter'];
                        $text = $_POST['searchWith'];

                        //var_dump($param,$text);
                        //$basename(path)ack = $_SESSION['Back'];
                        if(strcmp($param,"USER_ID")==0)
                            $query = "SELECT USER_ID,UNAME,UTYPE,USTART_DATE,USTATUS,ULOG_COUNT,ULOCK FROM USERS
      								WHERE ".$param."=".$text;
                        else
                            $query = "SELECT USER_ID,UNAME,UTYPE,USTART_DATE,USTATUS,ULOG_COUNT,ULOCK FROM USERS
      								WHERE ".$param."='".$text."'";
                        echo $query;
                        var_dump($param, $text);

                        $stmt = oci_parse($conn,$query);

                        oci_define_by_name($stmt, 'USER_ID', $uid);

                        oci_execute($stmt);

                        while (oci_fetch($stmt)) {
                            //$_SESSION['uid'] = $uid;
                            //echo  "<tr><td><input type='radio' name='user' value='".$_SESSION['uid']."'></td>";
                            echo  "<tr><td><input type='radio' name='user' value='".$uid."'></td>";
                            echo  	  "<td>".oci_result($stmt, "USER_ID")."</td>";
                            echo      "<td>".oci_result($stmt, "UNAME")."</td>";
                            echo 	  "<td>".oci_result($stmt, "UTYPE")."</td>";
                            echo      "<td>".oci_result($stmt, "USTART_DATE")."</td>";
                            echo      "<td>".oci_result($stmt, "USTATUS")."</td>";
                            echo      "<td>".oci_result($stmt, "ULOG_COUNT")."</td>";
                            echo      "<td>".oci_result($stmt, "ULOCK")."</td></tr>";
                        }

                        $_SESSION['activity'] = "inactive";

                    ?>
                </table>
            </div>
        </form>
    </body>
</html>