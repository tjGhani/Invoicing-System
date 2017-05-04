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
    </head>

    <body>

        <?php
            session_start();
            require("connection.php");
            require("header.php");

            print_r($_POST);

            $uid = $_POST['user'];
            //echo "this is the" . $uid;
            //$uid = $_SESSION['uid'];
            if(!isset($_SESSION['emptype'])) {
                $query = "SELECT U.USER_ID,UNAME,UTYPE,USTART_DATE,USTATUS,ULOG_COUNT,ULOCK,UEND_DATE,E.EMP_TYPE FROM USERS U INNER JOIN EMPLOYEES E
      						ON U.USER_ID = E.USER_ID WHERE U.USER_ID=" . $uid;
                $stmt = oci_parse($conn, $query);

                oci_define_by_name($stmt, 'USER_ID', $User_ID);
                oci_define_by_name($stmt, 'UNAME', $u_name);
                oci_define_by_name($stmt, 'USTART_DATE', $u_stdate);
                oci_define_by_name($stmt, 'USTATUS', $u_stat);
                oci_define_by_name($stmt, 'ULOG_COUNT', $u_lcount);
                oci_define_by_name($stmt, 'ULOCK', $u_lstat);
                oci_define_by_name($stmt, 'UEND_DATE', $u_enddate);
                oci_define_by_name($stmt, 'EMP_TYPE', $u_emptype);
            }
            else {
                $query = "SELECT U.USER_ID,UNAME,UTYPE,USTART_DATE,USTATUS,ULOG_COUNT,ULOCK,UEND_DATE FROM USERS U
                              WHERE U.USER_ID=" . $uid;
                $stmt = oci_parse($conn, $query);

                oci_define_by_name($stmt, 'USER_ID', $User_ID);
                oci_define_by_name($stmt, 'UNAME', $u_name);
                oci_define_by_name($stmt, 'USTART_DATE', $u_stdate);
                oci_define_by_name($stmt, 'USTATUS', $u_stat);
                oci_define_by_name($stmt, 'ULOG_COUNT', $u_lcount);
                oci_define_by_name($stmt, 'ULOCK', $u_lstat);
                oci_define_by_name($stmt, 'UEND_DATE', $u_enddate);
            }

            oci_execute($stmt);
            oci_fetch($stmt);

            $_SESSION['User_ID'] = $User_ID;
            $_SESSION['u_stdate'] = $u_stdate;
        ?>


        <form method="POST" action="userSave.php">
            <table class="table">
                <tr>
                    <td>User ID</td>
                    <td>
                        <?php echo $User_ID; ?>
                    </td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>
                        <input class="form-control" type='text' name='userName' value='<?php echo $u_name; ?>'>
                    </td>
                </tr>
                <tr>
                    <td>User Type</td>
                    <?php
                        if(isset($_SESSION['emptype']))
                            echo "<td>CUSTOMER</td>";
                        else {
                    ?>
                    <td>
                        <select class="form-control" name='userType'>
                            <option value='EMPLOYEE-FINANCE' <?php if (strcmp($u_emptype, "FINANCE") == 0) echo "selected"; ?>>EMPLOYEE-FINANCE</option>
                            <option value='EMPLOYEE-SALES' <?php if (strcmp($u_emptype, "SALES") == 0) echo "selected"; ?>>EMPLOYEE-FINANCE</option>
                        </select>
                    </td>
                    <?php
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
                <tr>
                    <td>Log Count</td>
                    <td>
                        <input class="form-control" type='text' name='uLogCount' value='<?php echo $u_lcount; ?>'>
                    </td>
                </tr>
                <tr>
                    <td>Lock Status</td>
                    <td>
                        <select class="form-control" name='uLockStatus'>
                            <option value='LOCKED' <?php if (strcmp($u_lstat,"LOCKED")==0) echo "selected"; ?>>LOCKED</option>
                            <option value='UNLOCKED' <?php if (strcmp($u_lstat,"UNLOCKED")==0) echo "selected"; ?>>UNLOCKED</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>End Date</td>
                    <td>
                        <input class="form-control" type='text' name='uEndDate' value='<?php echo $u_enddate; ?>'>
                    </td>
                </tr>
            </table>
            <br />
            <input style="width:300px" class="btn btn-lg btn-primary btn-block" type='submit' value='Save'>
        </form>
    </body>
</html>
