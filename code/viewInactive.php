<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>View Inactive</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/DataTables/datatables.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            require("connection.php");
            require("header.php");
            if(strcmp($_SESSION['utype'],"ADMIN")==0)
                include("admNav.html");
            else if(strcmp($_SESSION['utype'],"EMPLOYEE")==0)
                include("empNav.html");
            else
                header("location:accessDenied.php");
        ?>
        <h2><br /><center>Inactive</center><br /></h2>
        <form id="form" class="form-pickaction" method="POST" action="userActivity.php">
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-lg btn-default" type="submit" value="editUser">Reactivate</button>
                </div>
            </center>
            <br />
            <br />
            <div class="content" >
                <table id="viewInactive" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                    <thead>
                        <?php
                            //$basename(path)ack = $_SESSION['Back'];
                            if(strcmp($_SESSION['object'],"product")==0) {
                                echo "<tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Rate</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                      </tr>";
                                $query = "SELECT PROD_ID,PNAME,PRATE,PDESC,PSTATUS FROM PRODUCTS WHERE PSTATUS='INACTIVE'";
                                $stmt = oci_parse($conn,$query);
                                oci_define_by_name($stmt, 'PROD_ID', $pid);
                            }
                            else if(strcmp($_SESSION['object'],"user")==0) {
                                echo    "<tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Start Date</th>
                                            <th>Status</th>";
                                if(strcmp($_SESSION['utype'],"ADMIN")==0)
                                    echo   "<th>Log Count</th>
                                            <th>Lock Status</th>";
                                echo "</tr></thead><tbody>";
                                if(strcmp($_SESSION['utype'],"EMPLOYEE")==0)
                                    $query = "SELECT USER_ID,UFNAME,ULNAME,UPHONE,UEMAIL,UTYPE,USTART_DATE,USTATUS,ULOG_COUNT,ULOCK FROM USERS
      		            	    	    	WHERE UTYPE!='ADMIN' AND UTYPE!='EMPLOYEE' AND USTATUS='INACTIVE'";
                                else if(strcmp($_SESSION['utype'],"ADMIN")==0)
                                    $query = "SELECT USER_ID,UFNAME,ULNAME,UPHONE,UEMAIL,UTYPE,USTART_DATE,USTATUS,ULOG_COUNT,ULOCK FROM USERS
                                           WHERE UTYPE!='ADMIN' AND USTATUS='INACTIVE'";
                                $stmt = oci_parse($conn,$query);
                                oci_define_by_name($stmt, 'USER_ID', $uid);
                            }


                            oci_execute($stmt);
                            $count = oci_fetch($stmt);

                            /*if ($count ==0 && isset($_SESSION['product']))
                                header("location:empMngProd.php");
                            else if ($count == 0 && strcmp($_SESSION['utype'],"EMPLOYEE")==0)
                                header("location:empMngCust.php");
                            else if ($count == 0)
                                header("location:adminMngUser.php");*/

                            if (strcmp($_SESSION['object'],"product")==0 && $count>0) {
                                do {

                                    echo  "<tr><td><center><input type='radio' class='user' name='prod' value='".oci_result($stmt, 'PROD_ID')."'></center></td>";
                                    echo      "<td>".oci_result($stmt, "PNAME")."</td>";
                                    echo 	  "<td>".oci_result($stmt, "PRATE")."</td>";
                                    echo      "<td>".oci_result($stmt, "PDESC")."</td>";
                                    echo      "<td>".oci_result($stmt, "PSTATUS")."</td></tr>";
                                }while (oci_fetch($stmt));
                            }
                            else if(strcmp($_SESSION['utype'],"ADMIN")==0 && $count>0) {
                                do {
                                    $_SESSION['uid'] = $uid;
                                    echo  "<tr><td><center><input type='radio' class='user' name='user' value='".$uid."'></center></td>";
                                    echo      "<td>".oci_result($stmt, "UFNAME")." ".oci_result($stmt, "ULNAME")."</td>";
                                    echo 	  "<td>".oci_result($stmt, "UPHONE")."</td>";
                                    echo 	  "<td>".oci_result($stmt, "UEMAIL")."</td>";
                                    echo 	  "<td>".oci_result($stmt, "UTYPE")."</td>";
                                    echo      "<td>".oci_result($stmt, "USTART_DATE")."</td>";
                                    echo      "<td>".oci_result($stmt, "USTATUS")."</td>";
                                    echo      "<td>".oci_result($stmt, "ULOG_COUNT")."</td>";
                                    echo      "<td>".oci_result($stmt, "ULOCK")."</td></tr>";
                                }while (oci_fetch($stmt));
                            }
                            else if ($count>0){
                                do {
                                    $_SESSION['uid'] = $uid;
                                    echo  "<tr><td><center><input type='radio' class='user' name='user' value='".oci_result($stmt,'USER_ID')."'></center></td>";
                                    echo      "<td>".oci_result($stmt, "UFNAME")." ".oci_result($stmt, "ULNAME")."</td>";
                                    echo 	  "<td>".oci_result($stmt, "UPHONE")."</td>";
                                    echo 	  "<td>".oci_result($stmt, "UEMAIL")."</td>";
                                    echo 	  "<td>".oci_result($stmt, "UTYPE")."</td>";
                                    echo      "<td>".oci_result($stmt, "USTART_DATE")."</td>";
                                    echo      "<td>".oci_result($stmt, "USTATUS")."</td></tr>";
                                }while (oci_fetch($stmt));
                            }

                            $_SESSION['activity'] = "reactivate";
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
                $('#viewInactive').DataTable();
            } );
        </script>
        <script type="text/javascript">
            $("#form").submit(function (e) {
                if (!$(".user").is(':checked')) {
                    alert('Nothing is checked!');
                    e.preventDefault();
                }
            });
        </script>
    </body>
</html>