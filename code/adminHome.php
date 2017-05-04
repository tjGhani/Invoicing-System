<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Home</title>
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/css/sb-admin.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/css/morris.css" rel="stylesheet">
        <link rel="stylesheet" href="jqwidgets-ver3.9.1/jqwidgets/styles/jqx.base.css" type="text/css" />
        <link href="bootstrap-3.3.5-dist/css/font-awesome.min.css" rel="stylesheet">
        <script type="text/javascript" src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>

        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxcore.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxchart.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxchart.core.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxdraw.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxdata.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxdatatable.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxscrollbar.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxbuttons.js"></script>
    </head>
    <body style="background:white;">

        <?php
            session_start();
            require("connection.php");

            require("admHeader.php");
            include("admNav.html");

            $UserID = $_SESSION['UserID'];
            $uname = $_SESSION['uname'];

            echo "<h2><center>My Account - Admin $UserID - Welcome $uname!</center><br /></h2>";

            $sql = "SELECT COUNT(*) FROM USERS WHERE ULOCK='LOCKED'";
            $result = oci_parse($conn, $sql);
            oci_execute($result);
            oci_fetch($result);
            $locked = oci_result($result,"COUNT(*)");
            //var_dump($pending);

            $sql = "SELECT COUNT(*) FROM USERS WHERE UCREATED_DATE>(SELECT MAX(LOG_DATE) FROM LOGIN_LOG WHERE USER_ID=".$_SESSION['UserID']."
                            AND LOG_DATE<(SELECT MAX(LOG_DATE) FROM LOGIN_LOG WHERE USER_ID=".$_SESSION['UserID']."))";
            $result = oci_parse($conn, $sql);
            oci_execute($result);
            oci_fetch($result);
            $users = oci_result($result,"COUNT(*)");

            $sql = "SELECT COUNT(*) FROM USERS WHERE USTATUS='INACTIVE'";
            $result = oci_parse($conn, $sql);
            oci_execute($result);
            oci_fetch($result);
            $inactive = oci_result($result,"COUNT(*)");
        ?>
        <br />
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-lock" style="font-size:50px"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $locked; ?></div>
                                    <div>Users Locked!</div>
                                </div>
                            </div>
                        </div>
                        <a href="empApprOrd.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right glyphicon glyphicon-circle-arrow-right"></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-user" style="font-size:50px"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $users; ?></div>
                                    <div>Users Created!</div>
                                </div>
                            </div>
                        </div>
                        <a href="viewCNote.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right glyphicon glyphicon-circle-arrow-right"></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-thumbs-down" style="font-size:50px"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $inactive; ?></div>
                                    <div>Inactive Users!</div>
                                </div>
                            </div>
                        </div>
                        <a href="rcptSave.php">
                            <div class="panel-footer">
                                <span class="pull-left">Make a Payment</span>
                                <span class="pull-right glyphicon glyphicon-circle-arrow-right"></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!--row-->
        </div>
    </body>
</html>