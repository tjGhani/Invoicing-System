<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Choose Customer</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/DataTables/datatables.min.css" rel="stylesheet">
    </head>
    <body>
        <br />
        <?php
            session_start();
            require("connection.php");
            require("header.php");
            $_SESSION['step'] = "second";

            $utype = $_SESSION['utype'];

            if(strcmp($utype,"ADMIN")==0)
                header("location:accessDenied.php");
            else if(strcmp($utype,"EMPLOYEE")==0)
                include("empNav.html");
            else if(strcmp($utype,"CUSTOMER")==0)
                include("custNav.html");
        ?>

        <h3><br /><center>Choose Customer</center><br /></h3>
        <form id="form" class="form-back" method="POST" action="custLedger.php" width="600px">
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-lg btn-default" type="submit" value="editProd">Next</button>
                </div>
            </center>
            <div class="content">
                <table id="chooseCust" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
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
                $('#chooseCust').DataTable();
            } );
        </script>
        <script type="text/javascript">
            $("#form").submit(function (e) {
                if (!$(".customer").is(':checked')) {
                    alert('Nothing is checked!');
                    e.preventDefault();
                }
            });
        </script>
    </body>
</html>