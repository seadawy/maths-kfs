<?php
include('includes/config.php');
session_start();
if ($_SESSION['alogin'] != "som3a") {
    header("Location: index.php");
}
$stid = intval($_GET['stid']);
if (isset($_POST['submit'])) {
    $studentname = $_POST['fullanme'];
    $roolid = $_POST['rollid'];
    $studentemail = $_POST['emailid'];
    $status = $_POST['status'];
    $pass = $_POST['pass'];
    $dd = $_POST['phd'];
    $sql = "update tblstudents set StudentName=:studentname,RollId=:roolid,phd=:dd,password=:pass,Status=:status WHERE StudentId=:stid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pass', $pass, PDO::PARAM_STR);
    $query->bindParam(':studentname', $studentname, PDO::PARAM_STR);
    $query->bindParam(':dd', $dd, PDO::PARAM_STR);
    $query->bindParam(':roolid', $roolid, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':stid', $stid, PDO::PARAM_STR);
    $query->execute();
    $msg = "Student info updated successfully";
    header('location:manage-students.php');
}


?>
<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تعديل الطلاب</title>
    <link rel="shortcut icon" href="ee.png" type="image/png" sizes="194x194">
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
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
                            <h2 align="center" class="title">تعديل بيانات الطلاب </h2>
                        </div>
                    </div>
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <?php if ($msg) { ?>
                                            <div class="alert alert-success left-icon-alert" role="alert">
                                                <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                            </div><?php } else if ($error) { ?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>
                                        <form class="form-horizontal" method="post">
                                            <?php

                                            $sql = "SELECT tblstudents.StudentName,tblstudents.password,tblstudents.RollId,tblstudents.phd,tblstudents.StudentId,tblstudents.Status,tblclasses.ClassName from tblstudents join tblclasses on tblclasses.ClassNameNumeric=tblstudents.ClassId where tblstudents.StudentId=:stid";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':stid', $stid, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {  ?>
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">الاسم</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="fullanme" class="form-control" id="fullanme" value="<?php echo htmlentities($result->StudentName) ?>" required="required" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">رقم تلفون الطالب</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="rollid" class="form-control" id="rollid" value="<?php echo htmlentities($result->RollId) ?>" maxlength="13" required="required" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">رقم تلفون ولى الامر</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="phd" class="form-control" id="rollid" value="<?php echo htmlentities($result->phd) ?>" maxlength="13" required="required" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">الفصل</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="classname" class="form-control" id="classname" value="<?php echo htmlentities($result->ClassName) ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">كلمة المرور</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="pass" class="form-control" value="<?php echo htmlentities($result->password) ?>" minlength="4" required="required" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">الحاله</label>
                                                        <div class="col-sm-10">
                                                            <?php $stats = $result->Status;
                                                            if ($stats == "1") {
                                                            ?>
                                                                <input type="radio" name="status" value="1" required="required" checked>نشط &nbsp&nbsp&nbsp&nbsp<input type="radio" name="status" value="0" required="required">احظر
                                                            <?php } ?>
                                                            <?php
                                                            if ($stats == "0") {
                                                            ?>
                                                                <input type="radio" name="status" value="1" required="required">نشط &nbsp&nbsp&nbsp&nbsp<input type="radio" name="status" value="0" required="required" checked>احظر
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                            <?php }
                                            } ?>
                                            <div align="center" class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="submit" class="btn btn-primary">تعديل</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div align="center" class="form-group">
                                            <div align="center" class="col-sm-10">
                                                <?php
                                                include('includes/config2.php');
                                                if (isset($_POST['allo'])) {
                                                    $wddw = mysqli_query($dbh, "DELETE FROM user_token WHERE username='$result->RollId'");
                                                }
                                                $q567g = mysqli_query($dbh, "SELECT * FROM user_token WHERE username='$result->RollId'");
                                                $numqq = mysqli_num_rows($q567g);
                                                echo '
                                                            <form method="POST">
                                                                <button type="submit" name="allo" style="';
                                                if ($numqq == 0) {
                                                    echo 'background-color: red;';
                                                } elseif ($numqq == 1) {
                                                    echo 'background-color: green;';
                                                }
                                                echo '" class="btn btn-primary">اتصال الحساب بجهاز</button>
                                                            </form>';
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
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
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