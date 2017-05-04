<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Manage Customers</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/DataTables/datatables.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            require("connection.php");
            require("empHeader.php");
            include("empNav.html");
        ?>
        <h2><br /><center>Manage Customers</center><br /></h2>

        <form id="form" class="form-back" method="POST" width="600px">
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-lg btn-default" type="button" data-toggle="modal" data-target="#createCust">New</button>
                    <button class="btn btn-lg btn-default matter" type="submit" value="editCust" onclick="form.action='updaaate.php';">Edit</button>
                    <button class="btn btn-lg btn-default matter" type="submit" value="deleteCust" onclick="form.action='deleteUser.php';">Delete</button>
                    <button class="btn btn-lg btn-default" type="submit" value="viewIn" onclick="form.action='viewInactive.php';">View Inactive</button>
                    <button class="btn btn-lg btn-default matter" type="submit" value="viewIn" onclick="form.action='createDNote.php';">Issue Debit Note</button>
                    <button class="btn btn-lg btn-default" type="button" data-toggle="modal" data-target="#createDNoteAll">Issue Debit Note to All</button>
                </div>
            </center>
            <br />
            <br />
            <div class="content">
                <table id="manageCustomers" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Start Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //$basename(path)ack = $_SESSION['Back'];
                            $_SESSION['dnoteSA'] = "all";
                            $_SESSION['object'] = "user";
                            $query = "SELECT USER_ID,UFNAME,ULNAME,UPHONE,UEMAIL,USTATUS,USTART_DATE FROM USERS
        								WHERE UTYPE!='ADMIN' AND UTYPE!='EMPLOYEE' AND USTATUS='ACTIVE'";
                            $stmt = oci_parse($conn,$query);

                            oci_define_by_name($stmt, 'USER_ID', $uid);

                            oci_execute($stmt);

                            while (oci_fetch($stmt)) {
                                //$_SESSION['uid'] = $uid;
                                //echo  "<tr><td><input type='radio' name='user' value='".$_SESSION['uid']."'></td>";
                                echo  "<tr><td><center><input type='radio' class='customer' name='user' value='".$uid."'></center></td>";
                                echo      "<td>".oci_result($stmt, "UFNAME")." ".oci_result($stmt, "ULNAME")."</td>";
                                echo      "<td>".oci_result($stmt, "UPHONE")."</td>";
                                echo      "<td>".oci_result($stmt, "UEMAIL")."</td>";
                                echo      "<td>".oci_result($stmt, "USTART_DATE")."</td>";
                                echo      "<td>".oci_result($stmt, "USTATUS")."</td></tr>";
                            }

                            $_SESSION['activity'] = "inactive";

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
                $('#manageCustomers').DataTable();
            } );
        </script>
        <script type="text/javascript">
            $(".matter").click(function (e) {
                if (!$(".customer").is(':checked')) {
                    alert('Nothing is checked!');
                    e.preventDefault();
                }
            });
        </script>

        <div class="modal fade" id="createCust" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add New Customer</h4>
                    </div>
                    <form method="POST" action="userCreate.php">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" name="txtUfname" class="form-control" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <input type="text" name="txtUlname" class="form-control" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <input type="number" name="txtUphone" class="form-control" placeholder="Phone No.">
                            </div>
                            <div class="form-group">
                                <input type="text" name="txtUemail" class="form-control" placeholder="Email">
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