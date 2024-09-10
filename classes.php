<!-- CREATE CLASS -->
<?php
include('includes/config.php');
session_start();
error_reporting(0);
if ($_SESSION['alogin'] != "som3a") {
    header("Location: index.php");
} else {
    if (@$_GET['q'] == 'create') {
        if (isset($_POST['submit'])) {
            $classname = $_POST['classname'];
            $sm = $str = strtolower($classname);
            $classnamenumeric = rand(1, 10000);
            $q = "SELECT * FROM tblclasses WHERE classnamenumeric=:classnamenumeric AND classname!=:sm";
            $f = $dbh->prepare($q);
            if ($f->rowCount() == 0) {
                $sql = "INSERT INTO  tblclasses(ClassName,ClassNameNumeric) VALUES(:classname,:classnamenumeric)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':classname', $classname, PDO::PARAM_STR);
                $query->bindParam(':classnamenumeric', $classnamenumeric, PDO::PARAM_STR);
                $query->execute();
                header("location:classes.php?q=manage");
            } else {
                echo "<script>alert('try again one more time');</script>";
            }
        }
    }
?>
    <!DOCTYPE html>
    <html dir="rtl">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>انشاء فصل</title>
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
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
                            <div align="center" class="row page-title-div">
                                <?php
                                if (@$_GET['q'] == 'create') {
                                    echo '<h2 class="title">انشاء فصل</h2>';
                                }
                                if (@$_GET['q'] == 'manage') {
                                    echo '<h2 class="title">ادارة الفصول</h2>';
                                }
                                ?>
                            </div>
                        </div>

                        <section class="section">
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- CREAT CLASS -->
                                    <?php if (@$_GET['q'] == 'create') {
                                        echo '
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form method="post">
                                                    <div class="form-group has-success">
                                                        <label for="success" class="control-label">اسم الفصل</label>
                                                        <div class="">
                                                            <input type="text" name="classname" class="form-control" required="required" id="success">
                                                            <span class="help-block">مثال : الاول الثانوى </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group has-success">
                                                        <div class="">
                                                            <button type="submit" name="submit" class="btn btn-success btn-labeled">اضافه<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    </div></div></div>';
                                    }
                                    ?>
                                    <!-- MANAGE CLASS -->
                                    <?php
                                    if (@$_GET['q'] == 'manage') {
                                        echo '
                                            <div class="col-md-12">
                                                <div class="panel">
                                    <div class="panel-body p-20">
                                       <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>اسم الفصل</th>
                                                <th>ادوات</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                            <th>#</th>
                                            <th>اسم الفصل</th>
                                            <th>ادوات</th>                                          
                                        </tfoot>
                                        <tbody>';
                                        $sql = "SELECT * from tblclasses";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                echo '
                                                    <tr>
                                                        <td>' . htmlentities($cnt) . '</td>
                                                        <td>' . htmlentities($result->ClassName) . '</td>
                                                        <td>
                                                            <a href="classes.php?q=show-student&classid=' . htmlentities($result->ClassNameNumeric) . '" style="font-family:\'Reem Kufi\', sans-serif"><i class="fa fa-eye" title="Edit Record"></i> &nbsp&nbspاظهارالطلاب </a>
                                                            &nbsp&nbsp<a href="update.php?q=rmclass&classid=' . htmlentities($result->ClassNameNumeric) . '"><i title="Edit Record"><svg style="width: 10px !important;height: 10px !important;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg> &nbsp&nbspازاله</i></a>
                                                        </td>
                                                    </tr>';
                                                $cnt = $cnt + 1;
                                            }
                                        }
                                        echo '
                                            </tbody>
                                                </table>
                                                    </div>
                                                        </div>
                                                    </div>
                                            </div>';
                                    } ?>

                                <?php if (@$_GET['q'] == 'show-student') {
                                    include('includes/config2.php');
                                    $cid = @$_GET['classid'];
                                    $qm = mysqli_query($dbh, "SELECT * FROM tblstudents WHERE ClassId='$cid'");
                                    if (isset($_POST['restes'])) {
                                        $num = 0;
                                        $f = mysqli_query($dbh, "UPDATE tblstudents SET Status='$num' WHERE ClassId='$cid'");
                                    }
                                    echo  '
                                <section class="section">
                                <div class="row">    
                                <div class="col-md-12">
                                <div class="panel">
                            <div class="panel-body p-20">
                            <form action="" method="POST">
                            <div align="center">
                                <button name="restes" class="btn">اعادة تعين الحسابات</button>
                                <br>
                            </div>';
                                    while ($row = mysqli_fetch_array($qm)) {
                                        $name = $row['StudentName'];
                                        $id = $row['RollId'];
                                        $dd = $row['phd'];
                                        $pass = $row['password'];
                                        echo '
                                        <div style="border:1px solid black">
                                        <h1 align="center">' . $name . '</h1>
                                        <br>
                                        <div align="center">
                                            <p style="font-size:20px;line-height:1.5"> ت/الطالب : ' . $id . '</p>
                                            <p style="font-size:20px;line-height:1.5"> ت/ولى الامر :' . $dd . '</p>
                                            <p style="font-size:20px;line-height:1.5">كلمة المرور :' . $pass . '</p>
                                        </div>
                                        </div><br>';
                                    }
                                }
                                echo '
                                </div>
                                </div>
                                </div>
                            </div>
                            </section>';
                            }
                                ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
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

        <script src="js/prism/prism.js"></script>
        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
    </body>

    </html>