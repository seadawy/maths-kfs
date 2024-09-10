<?php
//all the variables defined here are accessible in all the files that include this one
include('includes/config2.php'); ?>
<?php
session_start();
?>
<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>مدير الامتحانات</title>
    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
        div.dataTables_wrapper div.dataTables_filter label,
        div.dataTables_wrapper div.dataTables_paginate {
            text-align: left !important;
        }

        div.dataTables_wrapper div.dataTables_length label,
        div.dataTables_wrapper div.dataTables_info {
            text-align: right !important;
        }
    </style>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <?php include('includes/topbar.php'); ?>
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php'); ?>
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <h2 align="center" class="title">مدير الامتحانات</h2>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <!--MANAGE quiz-->
                                    <?php if (@$_GET['q'] == 'manage') {
                                        $result = mysqli_query($dbh, "SELECT * FROM quiz ORDER BY date DESC");
                                        echo '<section class="section">
                                            <div class="container-fluid">
                                            <div class="row">
                                            <div class="col-md-12">
                                            <div class="panel">
                                        <div class="panel-body p-20">
                            
                                        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                <th>#</th>
                                                <th>العنوان</th> 
                                                <th>لفصل</th>
                                                <th>عدد الاسإله</th>
                                                <th>الدرجه</th>
                                                <th>الوقت</th>
                                                <th>ادوات</th> 
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                <th>#</th>
                                                <th>العنوان</th> 
                                                <th>لفصل</th>
                                                <th>عدد الاسإله</th>
                                                <th>الدرجه</th>
                                                <th>الوقت</th>
                                                <th>ادوات</th>                                               
                                                </tr>
                                            </tfoot>
                                            <tbody>';
                                        $c = 1;
                                        while ($row = mysqli_fetch_array($result)) {
                                            $title = $row['title'];
                                            $total = $row['total'];
                                            $tw = $row['tot_w'];
                                            $nw = $row['write_s'];
                                            $sahi = $row['sahi'];
                                            $cl = $row['ClassNameNumeric'];
                                            $time = $row['time'];
                                            $eid = $row['eid'];
                                            $nnnn = $total + $tw;
                                            $mark =  $sahi * $total + $nw * $tw;
                                            $l = mysqli_query($dbh, "SELECT * FROM tblclasses WHERE ClassNameNumeric='$cl'");
                                            while ($we = mysqli_fetch_array($l)) {
                                                $clsn = $we['ClassName'];
                                                echo '<tr><td>' . $c++ . '</td><td>' . $title . '</td><td>' . $clsn . '</td><td>' . $nnnn . '</td><td>' . $mark . '</td><td>' . $time . '&nbsp;دقيقه</td>
                                                <td>&nbsp&nbsp<a href="update.php?q=rmquiz&eid=' . $eid . '"><i title="delete"><svg style="width: 10px !important;height: 10px !important;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg> ازاله </i> </a></tb>';
                                            }
                                        }
                                        $c = 0;
                                        echo '</tbody></table></div></div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/DataTables/datatables.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="js/select2/select2.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(function($) {
            $('#example').DataTable();

            $('#example2').DataTable({
                "scrollY": "300px",
                "scrollCollapse": true,
                "paging": false
            });

            $('#example3').DataTable();
        });
    </script>
    <script>
        $(function($) {
            $(".js-states").select2();
            $(".js-states-limit").select2({
                maximumSelectionLength: 2
            });
            $(".js-states-hide").select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>
</body>

</html>