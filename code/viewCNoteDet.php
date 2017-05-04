<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>View Credit Notes</title>
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            require("connection.php");
            require("header.php");
            $utype = $_SESSION['utype'];
            if(strcmp($utype,"EMPLOYEE")==0)
                include("empNav.html");
            else if(strcmp($utype,"CUSTOMER")==0)
                include("custNav.html");
            else if(strcmp($utype,"ADMIN")==0)
                header("location:accessDenied.php");
        ?>

        <h2><br /><center>View Credit Notes</center><br /></h2>
        <form class="form-back" method="POST" width="900px">
            <center>
                <div class="btn-group" role="group">
                    <?php
                        $sql = "SELECT CR_STATUS FROM CREDIT_NOTES WHERE CR_ID=".$_POST['cr'];
                        $result = oci_parse($conn, $sql);
                        oci_define_by_name($result, "CR_STATUS", $crstatus);
                        oci_execute($result);
                        oci_fetch($result);
                        if(strcmp($utype,"EMPLOYEE")==0 && strcmp($crstatus,"PENDING")==0) {
                            $_SESSION['credNote'] = "update";
                            //$_SESSION['decision'] = "APPROVED";
                            ?>
                            <button class='btn btn-lg btn-default' type='submit' name='decisionA' value='approve'
                                    onclick="form.action='credNoteSave.php';">Approve
                            </button>

                            <button class='btn btn-lg btn-default' type='submit' name='decisionR' value='reject'
                                    onclick="form.action='credNoteSave.php';">Reject
                            </button>
                            <?php
                        }
                        else if(strcmp($utype,"CUSTOMER")==0 || strcmp($crstatus,"APPROVED")==0 || strcmp($crstatus,"REJECTED")==0) {
                            ?>
                            <button class='btn btn-lg btn-default' type='submit' onclick="form.action='viewCNote.php';">Back</button>
                            <?php
                        }
                    ?>
                </div>
            </center>
            <br />
            <br />
            <div class="content">
                <table id="viewCNotes" class="table table-striped table-bordered" border="1" cellspacing="0" width="80%">
                    <?php
                        if(strcmp($utype,"CUSTOMER")==0) {
                            $query = "SELECT CR_ID,CRCREATED_DATE,CR_AMOUNT,CR_STATUS,CR_DESC FROM CREDIT_NOTES
                                            WHERE CR_ID=" . $_POST['cr'];
                            $result = oci_parse($conn, $query);
                            oci_define_by_name($result,"CR_ID", $crid);
                            oci_define_by_name($result,"CRCREATED_DATE", $crdate);
                            oci_define_by_name($result,"CR_AMOUNT", $cramount);
                            oci_define_by_name($result,"CR_STATUS", $crstatus);
                        }
                        else if(strcmp($utype,"EMPLOYEE")==0) {
                            $query = "SELECT C.CR_ID,U.USER_ID,U.UFNAME,U.ULNAME,C.CRCREATED_DATE,C.CR_AMOUNT,C.CR_STATUS,C.CR_DESC FROM CREDIT_NOTES C INNER JOIN
                                        USERS U ON C.CR_ID=" . $_POST['cr'];
                            $result = oci_parse($conn, $query);
                            oci_define_by_name($result, "CR_ID", $crid);
                            oci_define_by_name($result, "USER_ID", $uid);
                            oci_define_by_name($result, "UFNAME", $ufname);
                            oci_define_by_name($result, "ULNAME", $ulname);
                            oci_define_by_name($result, "CRCREATED_DATE", $crdate);
                            oci_define_by_name($result, "CR_AMOUNT", $cramount);
                            oci_define_by_name($result, "CR_STATUS", $crstatus);
                            oci_define_by_name($result, "CR_DESC", $crdesc);
                        }
                        oci_execute($result);
                        oci_fetch($result);
                        $_SESSION['crid'] = $crid;
                        $_SESSION['custID'] = $uid;
                    ?>
                    <tr>
                        <td>Credit Note ID</td>
                        <td><?php echo $crid; ?><br /></td>
                    </tr>
                    <?php
                        if(strcmp($utype,"EMPLOYEE")==0) {
                            echo "<tr><td>Customer</td>";
                            echo "<td>".$ufname." ".$ulname."</td></tr>";
                        }
                    ?>
                    <tr>
                        <td>Request Date</td>
                        <td><?php echo $crdate; ?></td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td><?php echo $cramount; ?></td>
                    </tr>
                    <tr>
                        <td>Reason</td>
                        <td><?php echo $crdesc; ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><?php echo $crstatus; ?></td>
                    </tr>
                </table>
            </div>
        </form>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js" rel="stylesheet"></script>
    </body>
</html>