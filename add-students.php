<?php
include('includes/config.php');
error_reporting(0);
session_start();
if (isset($_POST['submit'])) {
    $studentname = $_POST['fullanme'];
    $roolid = $_POST['rollid'];
    $q = $dbh->prepare("SELECT RollId FROM tblstudents WHERE RollId=:roolid");
    $q->execute();
    $rowcount = $q->rowCount();
    if ($rowcount == 0) {
        $classid = $_POST['class'];
        $password = $_POST['password'];
        $phon = $_POST['phon'];
        $status = 1;
        $sql = "INSERT INTO  tblstudents(StudentName,phone,RollId,ClassId,password,Status) VALUES(:studentname,:phon,:roolid,:classid,:password,:status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':studentname', $studentname, PDO::PARAM_STR);
        $query->bindParam(':roolid', $roolid, PDO::PARAM_STR);
        $query->bindParam(':phon', $phon, PDO::PARAM_STR);
        $query->bindParam(':classid', $classid, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg = " done";
            header('location:index.php?is=' . $roolid . '');
        } else {
            $error = "Something went wrong. Please try again";
        }
    } else {
        echo "<script>alert('this roll id is alredy use');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>get account</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Piedra&display=swap');

        label {
            background: black;
            text-align: left !important;
        }

        * {
            color: red;
            font-size: 20px;
        }

        nav ul {
            padding: 0;
            list-style-type: none;
        }

        nav li {
            width: 20rem;
            height: 7rem;
            font-size: 20px;
            text-align: center;
            line-height: 7rem;
            font-family: sans-serif !important;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            transition: 0.3s;
            margin: 3rem;
            margin-top: 1rem !important
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: sans-serif !important;
        }

        nav li::before,
        nav li::after {
            content: \'\';
            position: absolute;
            width: inherit;
            height: inherit;
            top: 0;
            left: 0;
            transition: 0.3s;
        }

        nav li::before {
            background-color: white;
            z-index: -1;
            box-shadow: 0.2rem 0.2rem 0.5rem rgba(0, 0, 0, 0.2);
        }

        nav li::after {
            background-color: goldenrod;
            transform: translate(1.5rem, 1.5rem);
            z-index: -2;
        }

        nav li:hover {
            transform: translate(1.5rem, 1.5rem);
            color: white;
        }

        nav li:hover::before {
            background-color: goldenrod;
        }

        nav li:hover::after {
            background-color: white;
            transform: translate(-1.5rem, -1.5rem);
        }
    </style>
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="top-navbar-fixed" style="background: url(login/ass.gif);">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php');
        ?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel" style="background: #00000000;">
                                    <div class="panel-heading">
                                        <div align="center" class="panel-title">
                                            <h1 style="background:black">your info</h1>
                                        </div>
                                    </div>
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

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Full Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="fullanme" class="form-control" id="fullanme" required="required" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Your Phone</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="phon" class="form-control" id="fullanme" required="required" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">User Id</label>
                                                <div class="col-sm-10">
                                                    <input type="number" name="rollid" class="form-control" value="<?php echo (rand(1, 99999)) ?>" id="rollid" maxlength="5" required="required" autocomplete="off" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Class</label>
                                                <div class="col-sm-10">
                                                    <select name="class" class="form-control" id="default" required="required">
                                                        <option value="">Select Class</option>
                                                        <?php $sql = "SELECT * from tblclasses";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {   ?>
                                                                <option value="<?php echo htmlentities($result->ClassNameNumeric); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp;</option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Password</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="password" value="" class="form-control" id="date">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="submit" class="btn btn-primary">sing up</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
</body>

</html>