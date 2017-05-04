<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Error!</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

        <?php
            session_start();
            require("connection.php");


            //$_SESSION['UserID'] = session_id();

            $UserID = $_POST['inputUserID'];
            $password = $_POST['inputPassword'];

            if(is_numeric($UserID)) {

                $query = "SELECT * FROM USERS WHERE USER_ID=" . $UserID;
                $stid = oci_parse($conn, $query);
                $result = oci_execute($stid);
                $count = oci_fetch($stid);
                if ($count > 0) {

                    //verification of userid and password
                    $query = "SELECT * FROM USERS WHERE USER_ID=" . $UserID . " AND UPASSWORD='" . $password . "'";
                    $stid = oci_parse($conn, $query);

                    //to save type to save in session variable for further navigation
                    oci_define_by_name($stid, 'UTYPE', $utype);
                    //to save name for use in home page
                    oci_define_by_name($stid, 'UFNAME', $uname);
                    //to check number of times user has successively failed login attempt
                    oci_define_by_name($stid, 'ULOG_COUNT', $ulogcount);
                    //to check status of account, locked or unlocked
                    oci_define_by_name($stid, 'ULOCK', $ulock);
                    //to check status of account, active or inactive
                    oci_define_by_name($stid, 'USTATUS', $ustatus);

                    $result = oci_execute($stid);
                    $count = oci_fetch($stid);


                    if (strcmp($ulock, "LOCKED") == 0 || strcmp($ustatus, "INACTIVE") == 0)
                        //echo "<p align='center'><br />Access Denied, Account Locked. Contact Administrator.<br /></p>";
                        header("location:lockInactive.html");
                    else {
                        if ($ulogcount >= 3) {
                            //echo "<p align='center'><br />Access Denied, Account Locked. Contact Administrator.<br /></p>";
                            //creating an entry into the login log
                            $queryLOG = "INSERT INTO LOGIN_LOG(USER_ID, LOG_DATE, LOG_STATUS) VALUES(" . $UserID . ", SYSDATE, 'BLOCKED')";
                            $stidLOG = oci_parse($conn, $queryLOG);
                            $resultLOG = oci_execute($stidLOG);

                            //updating lock status
                            $querySET = "UPDATE USERS SET ULOCK='LOCKED' WHERE USER_ID=" . $UserID;
                            $stidSET = oci_parse($conn, $querySET);
                            $resultSET = oci_execute($stidSET);

                            header("location:lockInactive.html");
                        } else if ($count > 0) {
                            //saving variables into session variables
                            $_SESSION['UserID'] = $UserID;
                            var_dump($_SESSION['UserID']);
                            $_SESSION['uname'] = $uname;
                            $_SESSION['utype'] = $utype;

                            /*if (strcmp($utype,"EMPLOYEE")==0) {
                                $sql = "SELECT EMP_TYPE FROM EMPLOYEES WHERE EMP_ID=".$_SESSION['UserID'];
                                $result = oci_parse($conn,$sql);
                                oci_define_by_name($result,'EMP_TYPE',$emptype);
                                oci_execute($result);
                                oci_fetch($result);
                                $_SESSION['emptype'] = $emptype;
                            }*/


                            //login_log success entry
                            $queryLOG = "INSERT INTO LOGIN_LOG(USER_ID, LOG_DATE, LOG_STATUS) VALUES(" . $UserID . ", SYSDATE, 'SUCCESS')";
                            $stidLOG = oci_parse($conn, $queryLOG);
                            $resultLOG = oci_execute($stidLOG);

                            //reset user log count
                            $querySET = "UPDATE USERS SET ULOG_COUNT=0 WHERE USER_ID=" . $UserID;
                            $stidSET = oci_parse($conn, $querySET);
                            $resultSET = oci_execute($stidSET);

                            //header("location:home.php");
                            if (strcmp($utype, "ADMIN") == 0)
                                header("location:adminHome.php");
                            else if (strcmp($utype, "EMPLOYEE") == 0)
                                header("location:empHome.php");
                            else if (strcmp($utype, "CUSTOMER") == 0)
                                header("location:custHome.php");
                        } else {
                            //echo($ulogcount);

                            //entry into login log
                            $queryLOG = "INSERT INTO LOGIN_LOG(USER_ID, LOG_DATE, LOG_STATUS) VALUES(" . $UserID . ", SYSDATE, 'FAILURE')";
                            //echo($queryLOG);
                            $stidLOG = oci_parse($conn, $queryLOG);
                            $resultLOG = oci_execute($stidLOG);

                            //echo($ulogcount);

                            //increase ulog_count
                            echo "<p align='center'><br />Wrong User ID or Password<br /></p>";
                            $querySET = "UPDATE USERS SET ULOG_COUNT=ULOG_COUNT+1 WHERE USER_ID=".$UserID;
                            //echo ($querySET);
                            $stidSET = oci_parse($conn, $querySET);
                            $resultSET = oci_execute($stidSET);
                        }
                    }
                }
                else {
                    echo "<p align='center'><br />Invalid User ID<br /></p>";
                }
            }
            else {
                echo "<p align='center'><br />Invalid User ID<br /></p>";
            }
        ?>
        <div class="container" style="width:300px">
            <form name="back" action="index.html">
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="backToLogin">Back to Sign In</button>
            </form>
        </div>
    </body>
</html>

