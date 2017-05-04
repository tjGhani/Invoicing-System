<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>View Credit Notes</title>
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/DataTables/datatables.min.css" rel="stylesheet">
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
        <form id="form" class="form-back" method="POST" width="900px">
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-lg btn-default matter" type="submit" value="viewCNoteDet" onclick="form.action='viewCNoteDet.php';">View Details</button>
                </div>
            </center>
            <br />
            <br />
            <div class="content">
                <table id="viewCNotes" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Credit Note ID</th>
                            <?php
                                if(strcmp($utype,"EMPLOYEE")==0)
                                    echo "<th>Customer</th>";
                            ?>
                            <th>Date</th>
                            <th>Amount Requested</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $_SESSION['approve'] = "false";
                            if(strcmp($utype,"CUSTOMER")==0)
                                $query = "SELECT CR_ID,CRCREATED_DATE,CR_AMOUNT,CR_STATUS FROM CREDIT_NOTES
                                                WHERE CUST_ID=".$_SESSION['UserID'];
                            else if(strcmp($utype,"EMPLOYEE")==0)
                                $query = "SELECT C.CR_ID,U.UFNAME,U.ULNAME,C.CRCREATED_DATE,C.CR_AMOUNT,C.CR_STATUS FROM CREDIT_NOTES C INNER JOIN
                                          USERS U ON C.CUST_ID=U.USER_ID WHERE U.UTYPE='CUSTOMER'";
                            $result = oci_parse($conn,$query);
                            oci_define_by_name($result,"CR_ID", $crid);
                            oci_execute($result);

                            if(strcmp($utype,"EMPLOYEE")==0) {
                                while (oci_fetch($result)) {
                                    echo "<tr><td><center><input type='radio' class='creditnote' name='cr' value='" . $crid . "'></center></td>";
                                    echo "<td>".oci_result($result, "CR_ID")."</td>";
                                    echo "<td>".oci_result($result, "UFNAME")." ".oci_result($result, "ULNAME")."</td>";
                                    echo "<td>".oci_result($result, "CRCREATED_DATE")."</td>";
                                    echo "<td>".oci_result($result, "CR_AMOUNT")."</td>";
                                    echo "<td>".oci_result($result, "CR_STATUS")."</td></tr>";
                                }
                            }
                            else {
                                while (oci_fetch($result)) {
                                    echo "<tr><td><center><input type='radio' class='creditnote' name='cr' value='" . $crid . "'></center></td>";
                                    echo "<td>" . oci_result($result, "CR_ID") . "</td>";
                                    echo "<td>" . oci_result($result, "CRCREATED_DATE") . "</td>";
                                    echo "<td>" . oci_result($result, "CR_AMOUNT") . "</td>";
                                    echo "<td>" . oci_result($result, "CR_STATUS") . "</td></tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/DataTables/datatables.js" rel="stylesheet"></script>
        <script>
            $(document).ready(function() {
                $('#viewCNotes').DataTable();
            } );
        </script>
        <script type="text/javascript">
            $(".matter").click(function (e) {
                if (!$(".creditnote").is(':checked')) {
                    alert('Nothing is checked!');
                    e.preventDefault();
                }
            });
        </script>
    </body>
</html>