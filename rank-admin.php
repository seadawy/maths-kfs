<?php
include('includes/config.php');
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>الترتيب</title>
    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <?php if (@$_GET['q'] == 2 || @$_GET['q'] == 1) {
        echo '
        <style>
            div.dataTables_wrapper div.dataTables_filter label ,div.dataTables_wrapper div.dataTables_paginate {
            text-align: left !important;
            }
            div.dataTables_wrapper div.dataTables_length label ,div.dataTables_wrapper div.dataTables_info {
                text-align: right !important;
            }
        </style>
        ';
    }
    ?>

</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">

                <!-- ========== LEFT SIDEBAR ========== -->
                <?php include('includes/leftbar.php'); ?>
                <!-- /.left-sidebar -->

                <div class="main-page">

                    <div class="container-fluid">
                        <div align="center" class="row page-title-div">
                            <h2 class="title">ترتيب الاوائل على الفصول</h2>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <?php if (@$_GET['q'] == 1) {
                                echo '
                                <form class="form-horizontal" method="post">
                                    <div class="form-group">
                                        <div style="margin: 3%" class="col-sm-10">
                                            <select name="class" class="form-control clid" id="classid" onChange="getStudent(this.value);" required="required">
                                                <option value="">اختر الفصل</option>';
                                $sql = "SELECT * from tblclasses ";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {
                                        echo '<option value="' . htmlentities($result->ClassNameNumeric) . '">' . htmlentities($result->ClassName) . '</option>';
                                    }
                                }
                                echo '
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div align="center" class="col-sm-offset-2 col-sm-10">
                                            <button name="submit" id="submit" class="btn btn-primary">اعرض</button>
                                        </div>
                                    </div>';
                                include('includes/config2.php');
                                $classid = $_POST['class'];
                                $q = mysqli_query($dbh, "SELECT * FROM rank WHERE ClassNameNumeric='$classid' ORDER BY score DESC ");
                                echo  '
                                <section class="section">
                                <div class="container-fluid">
                                <div class="row">
                                <div class="col-md-12">
                                <div class="panel">
                            <div class="panel-body p-20">
                
                            <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>مجموع الدرجات</th>
                                        <th>الادوات</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>مجموع الدرجات</th>
                                    <th>الادوات</th>
                                    </tr>
                                </tfoot>
                                <tbody>';
                                $c = 0;
                                while ($row = mysqli_fetch_array($q)) {
                                    $name = $row['name'];
                                    $s = $row['score'];
                                    $m = mysqli_query($dbh, "SELECT RollId FROM tblstudents WHERE StudentName ='$name'");
                                    while ($r = mysqli_fetch_array($m)) {
                                        $id = $r['RollId'];
                                    }
                                    $c++;
                                    echo '<tr>
                                        <td style="color:#99cc32"><b>' . $c . '</b></td>
                                        <td>' . $name . '</td>
                                        <td>' . $s . '</td>
                                        <td><a target="_blank" href="rank-admin.php?q=2&id=' . $id . '"><i class="fa fa-edit" title="Edit Record"> Show Exam</i></a>
                                        </td>
                                        </tr>';
                                }
                                $c = 0;
                                echo '
                                    </tbody>
                                    </table>
                                </div>
                                </div>
                                </div
                            </div>
                            </section></form>';
                            } ?>

                            <?php if (@$_GET['q'] == 2) {
                                include('includes/config2.php');
                                $id = @$_GET['id'];
                                $q = mysqli_query($dbh, "SELECT * FROM history WHERE idroll ='$id'");
                                echo  '
                                    <section class="section">
                                    <div class="container-fluid">
                                    <div class="row">
                                    <div class="col-md-12">
                                    <div class="panel">
                                <div class="panel-body p-20">
                                
                    
                                <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>اجابة خاطئه</th>
                                            <th>حقق / من</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>اجابة خاطئه</th>
                                    <th>حقق / من</th>
                                        
                                        </tr>
                                    </tfoot>
                                    <tbody>';
                                $c = 0;
                                while ($row = mysqli_fetch_array($q)) {
                                    $namee = $row['eid'];
                                    $s = $row['score'];
                                    $r = $row['wrong'];

                                    $m = mysqli_query($dbh, "SELECT * FROM quiz WHERE eid ='$namee'");
                                    while ($rm = mysqli_fetch_array($m)) {
                                        $vew = $rm['title'];
                                        $t = $rm['total'];
                                        $si = $rm['sahi'];
                                        $f = $rm['write_s'];
                                        $f2 = $rm['tot_w'];
                                    }
                                    $c++;
                                    $marll = $si * $t + $f * $f2;
                                    echo '<tr>
                                        <td style="color:#99cc32"><b>' . $c . '</b></td>
                                        <td>' . $vew . '</td>
                                        <td>' . $r . '</td>
                                        <td>' . $s . ' / ' . $marll  . '</td>
                                        </td>
                                        </tr>';
                                }
                                $c = 0;
                                echo '
                                    </tbody>
                                    </table>
                                </div>
                                </div>
                                </div
                            </div>
                            </section></form>';
                            } { ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <script src="js/DataTables/datatables.min.js"></script>

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <script>
        $("#prospects_form").submit(function(e) {
            e.preventDefault();
        });
    </script>
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

<?php } ?>