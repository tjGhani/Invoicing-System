<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>View Debit Notes</title>
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

        <h2><br /><center>View Issued Debit Notes</center><br /></h2>
        <form class="form-back" method="POST" width="900px">
            <center>
                <div class="btn-group" role="group">
                    <?php
                        if(strcmp($utype,"EMPLOYEE")==0)
                            echo "<button class='btn btn-lg btn-default' type='button' data-toggle='modal' data-target='#createDNoteAll'>Issue Debit Note to All</button>";
                    ?>
                </div>
            </center>
            <br />
            <div class="content">
                <table id="viewDNotes" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Debit Note ID</th>
                            <?php
                                if(strcmp($utype,"EMPLOYEE")==0)
                                    echo "<th>Issued to</th>";
                            ?>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Amount Remaining</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(strcmp($utype,"CUSTOMER")==0) {
                                $query = "SELECT D_ID,D_AMOUNT,D_AMT_REMAINING,D.D_DESC,D.DCREATED_DATE FROM DEBIT_NOTES D
                                                WHERE CUST_ID=" . $_SESSION['UserID'];

                            }
                            else if(strcmp($utype,"EMPLOYEE")==0) {
                                $query = "SELECT D.D_ID,D.CUST_ID,D.DCREATED_DATE,D.D_AMOUNT,D.D_AMT_REMAINING,D.D_DESC FROM DEBIT_NOTES D";

                            }
                            $result = oci_parse($conn,$query);
                            oci_execute($result);


                            if(strcmp($utype,"EMPLOYEE")==0) {
                                while (oci_fetch($result)) {
                                    //echo "<tr><td><input type='radio' name='cr' value='" . $crid . "'></td>";
                                    echo "<td>".oci_result($result, "D_ID")."</td>";
                                    echo "<td>".oci_result($result, "CUST_ID")."</td>";
                                    echo "<td>".oci_result($result, "DCREATED_DATE")."</td>";
                                    echo "<td>".oci_result($result, "D_AMOUNT")."</td>";
                                    echo "<td>".oci_result($result, "D_AMT_REMAINING")."</td>";
                                    echo "<td>".oci_result($result, "D_DESC")."</td></tr>";
                                }
                            }
                            else {
                                while (oci_fetch($result)) {
                                    //echo "<tr><td><input type='radio' name='cr' value='" . $crid . "'></td>";
                                    echo "<td>" . oci_result($result, "D_ID") . "</td>";
                                    echo "<td>" . oci_result($result, "DCREATED_DATE") . "</td>";
                                    echo "<td>" . oci_result($result, "D_AMOUNT") . "</td>";
                                    echo "<td>".oci_result($result, "D_AMT_REMAINING")."</td>";
                                    echo "<td>" . oci_result($result, "D_DESC") . "</td></tr>";
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
                $('#viewDNotes').DataTable();
            } );
        </script>

        <div class="modal fade" id="createDNoteAll" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Issue Debit Note to All Customers</h4>
                    </div>
                    <form method="POST" action="debNoteSave.php">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" name="txtDAmount" class="form-control" placeholder="Amount">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="5" name="reason" placeholder="Reason"></textarea><br />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>
                            <input type="submit" class="btn btn-primary" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>