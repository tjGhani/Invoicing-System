<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>View Receipts</title>
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/DataTables/datatables.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            require("connection.php");
            require("header.php");

            $utype = $_SESSION['utype'];
            if(isset($_SESSION['emptype']))
                $emptype=$_SESSION['emptype'];

            if(strcmp($utype,"EMPLOYEE")==0)
                include("empNav.html");
            else if(strcmp($utype,"CUSTOMER")==0)
                include("custNav.html");

        ?>

        <h2><br /><center>View Receipts</center><br /></h2>
        <form id="form" class="form-back" method="POST" width="900px">
            <center>
                <div class="btn-group" role="group">
                    <button class='btn btn-lg btn-default' type='button' data-toggle='modal' data-target='#createRcpt'>Generate New</button>
                    <button class="btn btn-lg btn-default matter" type="submit" value="viewInvDet" onclick="form.action='viewDet.php';">View Details</button>
                </div>
            </center>
            <br />
            <br />
            <div class="content">
                <table border="1" id="receipts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Receipt ID</th>
                            <?php
                                if(strcmp($utype,"EMPLOYEE")==0)
                                    echo "<th>Customer</th>";
                            ?>
                            <th>Date</th>
                            <th>Amount Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $UserID = $_SESSION['UserID'];
                            $_SESSION['objType'] = "receipt";
                            if(strcmp($utype,"CUSTOMER")==0)
                                $query = "SELECT R_ID,RCREATED_DATE,RAMOUNT_PAID FROM RECEIPTS WHERE CUST_ID=".$UserID;
                            else
                                $query = "SELECT R.R_ID,U.UFNAME,U.ULNAME,R.RCREATED_DATE,R.RAMOUNT_PAID FROM RECEIPTS R INNER JOIN
                                          USERS U ON R.CUST_ID=U.USER_ID";
                            $result = oci_parse($conn,$query);
                            oci_define_by_name($result,"R_ID", $rid);
                            oci_execute($result);

                            if(strcmp($utype,"CUSTOMER")==0) {
                                while(oci_fetch($result)) {
                                    echo "<tr><td><center><input type='radio' class='receipt' name='rcpt' value='" . $rid . "'></center></td>";
                                    echo "<td>" . oci_result($result, "R_ID") . "</td>";
                                    echo "<td>" . oci_result($result, "RCREATED_DATE") . "</td>";
                                    echo "<td>" . oci_result($result, "RAMOUNT_PAID") . "</td></tr>";
                                }
                            }
                            else {
                                while (oci_fetch($result)) {
                                    echo "<tr><td><center><input type='radio' class='receipt' name='rcpt' value='".$rid."'></center></td>";
                                    echo "<td>".oci_result($result, "R_ID")."</td>";
                                    echo "<td>".oci_result($result, "UFNAME")." ".oci_result($result, "ULNAME")."</td>";
                                    echo "<td>".oci_result($result, "RCREATED_DATE")."</td>";
                                    echo "<td>".oci_result($result, "RAMOUNT_PAID")."</td></tr>";
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
                $('#receipts').DataTable();
            } );
        </script>
        <script type="text/javascript">
            $(".matter").click(function (e) {
                if (!$(".receipt").is(':checked')) {
                    alert('Nothing is checked!');
                    e.preventDefault();
                }
            });
        </script>

        <div class="modal fade" id="createRcpt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Create Receipt</h4>
                    </div>
                    <form method="POST" action="rcptSave.php">
                        <div class="modal-body">
                            <div class="form-group">
                                <input class="form-control" type="text" name="cid" placeholder="Customer ID">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="rdate" placeholder="Date">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>
                            <input type="submit" class="btn btn-primary" value="Next">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

</html>