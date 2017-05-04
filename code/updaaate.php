<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Update User</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>

        <?php
            session_start();
            require("connection.php");
            require("header.php");

            $utype = $_SESSION['utype'];

            $uid = $_POST['user'];
            //echo "this is the" . $uid;
            //$uid = $_SESSION['uid'];
            //var_dump($_SESSION['emptype']);
            if(strcmp($utype,"ADMIN")==0) {
                include("admNav.html");
                //oci_define_by_name($stmt, "EMP_TYPE", $u_emptype);
                $query = "SELECT USER_ID,UFNAME,ULNAME,UPHONE,UEMAIL,UTYPE,USTART_DATE,USTATUS,ULOG_COUNT,ULOCK,UEND_DATE FROM USERS
            						WHERE USER_ID=" . $uid;
                $stmt = oci_parse($conn, $query);
            }
            else if(strcmp($utype,"EMPLOYEE")==0) {
                include("empNav.html");
                $query = "SELECT USER_ID,UFNAME,ULNAME,UPHONE,UEMAIL,UTYPE,USTART_DATE,USTATUS,ULOG_COUNT,ULOCK,UEND_DATE FROM USERS
                                    WHERE USER_ID=" . $uid." AND UTYPE='CUSTOMER'";
                $stmt = oci_parse($conn, $query);

            }

            oci_define_by_name($stmt, "USER_ID", $User_ID);
            oci_define_by_name($stmt, "UFNAME", $u_fname);
            oci_define_by_name($stmt, "ULNAME", $u_lname);
            oci_define_by_name($stmt, "UPHONE", $u_phone);
            oci_define_by_name($stmt, "UEMAIL", $u_email);
            oci_define_by_name($stmt, "USTART_DATE", $u_stdate);
            oci_define_by_name($stmt, "USTATUS", $u_stat);
            oci_define_by_name($stmt, "ULOG_COUNT", $u_lcount);
            oci_define_by_name($stmt, "ULOCK", $u_lstat);
            oci_define_by_name($stmt, "UEND_DATE", $u_enddate);
            oci_execute($stmt);
            oci_fetch($stmt);


            $_SESSION['User_ID'] = $User_ID;
            $_SESSION['u_stdate'] = $u_stdate;
        ?>
        <h2><br /><center>Update User</center><br /></h2>
        <div align="left|right|center|justify" class="container" style="width:900px">
        <form method="POST" action="userSave.php">
            <table class="table" width="900px">
                <tr>
                    <td>First Name</td>
                    <td>
                        <input class="form-control" type='text' name='userFName' value='<?php echo $u_fname; ?>'> </input>
                    </td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td>
                        <input class="form-control" type='text' name='userLName' value='<?php echo $u_lname; ?>'> </input>
                    </td>
                </tr>
                <tr>
                    <td>Phone No.</td>
                    <td>
                        <input class="form-control" type='number' name='userPhone' value='<?php echo $u_phone; ?>'> </input>
                    </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>
                        <input class="form-control" type='text' name='userEmail' value='<?php echo $u_email; ?>'> </input>
                    </td>
                </tr>
                <tr>
                    <td>User Type</td>
                    <?php
                        if(strcmp($_SESSION['utype'],"EMPLOYEE")==0)
                            echo "<td>CUSTOMER</td>";
                        else {
                            echo "<td>EMPLOYEE</td>";
                        }
                    ?>
                </tr>
                <tr>
                    <td>Start Date</td>
                    <td>
                        <?php echo $u_stdate; ?>
                    </td>
                </tr>
                <tr>
                    <td>User Status</td>
                    <td>
                        <select class="form-control" name='userStatus'>
                            <option value='ACTIVE' <?php if (strcmp($u_stat,"ACTIVE")==0) echo "selected"; ?>>ACTIVE</option>
                            <option value='INACTIVE' <?php if (strcmp($u_stat,"INACTIVE")==0) echo "selected"; ?>>INACTIVE</option>
                        </select>
                    </td>
                </tr>
                <?php
                    if(strcmp($_SESSION['utype'],"ADMIN")==0) {
                        echo   "<tr>
                                    <td>Lock Status</td>
                                    <td>
                                        <select class='form-control' name='uLockStatus'>
                                            <option value='LOCKED' ";
                                                if (strcmp($u_lstat,"LOCKED")==0) echo "selected";
                                                    echo ">LOCKED</option>
                                            <option value='UNLOCKED'";
                                                if (strcmp($u_lstat,"UNLOCKED")==0) echo "selected"; echo ">UNLOCKED</option>
                                        </select>
                                    </td>
                                </tr>";
                    }
                ?>

                    <td>End Date</td>
                    <td>
                        <input class="form-control" type='text' name='uEndDate' value='<?php echo $u_enddate; ?>'>
                    </td>
                    </tr>
            </table>
            <br />
            <input style="width:300px" class="btn btn-lg btn-default" type='submit' value='Save'>
        </form>
        </div>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    </body>
</html>
