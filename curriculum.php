<?php
include('includes/config2.php');
session_start();
error_reporting(0);
if ($_SESSION['alogin'] != "som3a") {
    header("Location: index.php");
}
if (@$_GET['q'] == 'createunit') {
    if (isset($_POST['submitf1'])) {
        $class = $_POST['class'];
        $un = $_POST['unitname'];
        $tre = $_POST['term'];
        $uid =  uniqid();
        $q1 = mysqli_query($dbh, "INSERT INTO unit (classid,unitid,uname,term) VALUES ('$class','$uid','$un','$tre')");
        header('location:curriculum.php?q=addlesson');
    }
}

if (@$_GET['q'] == 'addlesson') {
    $s = 'none';
    $l = 'block';
    $uid = $_POST['unid'];
    $lesid = uniqid();
    $t = $_POST['nameleson'];
    $video = $_POST['youvideo'];
    $d = $_POST['def'];
    $total = $_POST['total'];
    $sahi = $_POST['right'];
    $time = $_POST['time'];
    $code = (int)!isset($_POST['code']);
    if (isset($_POST['submitf3'])) {
        $s = 'block';
        $l = 'none';
        $fileWrokName = basename($_FILES['home']['name']);
        if ($fileWrokName == null || $fileWrokName == "") {
            $fileWrokName = null;
        } else {
            $targetfolder = "HomeWork/";
            $targetfolder = $targetfolder . $fileWrokName;
            move_uploaded_file($_FILES['home']['tmp_name'], $targetfolder);
        }
        $fileAssetName = basename($_FILES['asset']['name']);
        if ($fileAssetName == null || $fileAssetName == "") {
            $fileAssetName = null;
        } else {
            $target2folder = "Assets/";
            $target2folder = $target2folder . $fileAssetName;
            move_uploaded_file($_FILES['asset']['tmp_name'], $target2folder);
        }
        $q2 = mysqli_query($dbh, "INSERT INTO `lesson`(`ud`, `lessonid`, `title`, `youtube`, `frist`, `time`, `code`, `work`) VALUES ('$uid','$lesid','$t','$video','$d',NOW(),$code,'$fileWrokName')");
        $q2 = mysqli_query($dbh, "INSERT INTO `lessonsasset` (`lessonId`, `file`) VALUES ('$lesid','$fileAssetName')");
    }
}
?>
<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المنهج</title>
    <link rel="shortcut icon" href="ee.png" type="image/png" sizes="194x194">
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body>

    <body class="top-navbar-fixed">
        <div class="main-wrapper">
            <!-- ========== TOP NAVBAR ========== -->
            <?php include('includes/topbar.php');
            ?>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">
                    <!-- ========== LEFT SIDEBAR ========== -->
                    <?php include('includes/leftbar.php');
                    ?>
                    <!-- /.left-sidebar -->
                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <h1 align="center">المنهج التعليمى</h1>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <?php if (@$_GET['q'] == 'createunit') { ?>
                                                <div style="border: 2px solid red;padding:5%;margin:3%">
                                                    <form align="center" name="form1" method="POST" enctype="multipart/form-data">
                                                        <select name="class" class="form-control clid" id="classid" required="required">
                                                            <option value="">اختر الفصل</option>';
                                                            <?php
                                                            $sql = "SELECT * from tblclasses";
                                                            $q = mysqli_query($dbh, $sql);
                                                            while ($row = mysqli_fetch_array($q)) {
                                                                echo '<option value=" ' .  htmlentities($row['ClassNameNumeric']) . ' ">' . htmlentities($row['ClassName']) . '&nbsp; </option>';
                                                            }
                                                            ?>
                                                        </select><br>
                                                        <textarea rows="1" cols="2" class="form-control" name="unitname" type="text" placeholder="اسم الشهر"></textarea>
                                                        <label for="term">الفصل الدراسى</label>
                                                        <br>
                                                        <input type="radio" name="term" value="1" id="term"> 1
                                                        <input type="radio" name="term" value="2" id="term"> 2
                                                        <button id="prospects_form" class="btn btn-primary" name="submitf1" type="submit">اضافه</button>
                                                    </form>
                                                </div>
                                            <?php } ?>
                                            <?php if (@$_GET['q'] == 'addlesson') {
                                                echo '
                                                        <div style="border: 2px solid red;padding:5%;margin:3%;display:' . $l . ' !important">'; ?>
                                                <form align="center" method="POST">
                                                    <select name="class2" class="form-control clid" id="classid" required="required">
                                                        <option value="">اختر الفصل</option>';
                                                        <?php
                                                        $sql = "SELECT * from tblclasses";
                                                        $q = mysqli_query($dbh, $sql);
                                                        while ($row = mysqli_fetch_array($q)) {
                                                            echo '<option value="' .  htmlentities($row['ClassNameNumeric']) . '">' . htmlentities($row['ClassName']) . '&nbsp; </option>';
                                                        }
                                                        ?>
                                                    </select><br>
                                                    <input id="prospects_form" class="btn btn-primary" value="تم الاختيار" type="submit">
                                                </form>
                                                <form align="center" name="form3" method="POST" enctype="multipart/form-data">
                                                    <hr style="border-top: 5px solid red !important;">
                                                    <select name="unid" class="form-control clid" required="required">
                                                        <option value="">اختر الشهر</option>';
                                                        <?php
                                                        $cl2 = $_POST['class2'];
                                                        $sql = "SELECT * FROM unit WHERE classid='$cl2'";
                                                        $q = mysqli_query($dbh, $sql);
                                                        while ($rw = mysqli_fetch_array($q)) {
                                                            echo '<option value="' .  htmlentities($rw['unitid']) . '">' . htmlentities($rw['uname']) . '&nbsp; </option>';
                                                        }
                                                        ?>
                                                    </select><br>
                                                    <textarea rows="1" cols="2" name="nameleson" class="form-control" placeholder="اسم الدرس" required="required"></textarea><br>
                                                    <textarea rows="1" cols="2" name="youvideo" class="form-control" placeholder="رابط الفيديو" required="required"></textarea>
                                                    <input type="checkbox" value="1" name="def"> لو دا اول درس فى الشهر حدد المربع
                                                    <br><br>
                                                    <input type="checkbox" value="0" name="code"> لو من غير كود
                                                    <br>
                                                    <br>
                                                    <div style="display: none;">
                                                        <h1>
                                                            ضيف واجب لو فيه
                                                        </h1>
                                                        <input type="file" name="home">
                                                    </div>
                                                    <h1>
                                                        ضيف ملف الحصه من هنا ⬇️⬇️
                                                    </h1>
                                                    <input type="file" name="asset" style="font-size: 30px;">
                                                    <h1>الاختبار</h1>
                                                    <fieldset style="border-style:none">
                                                        <!-- Text input-->
                                                        <div class="form-group">
                                                            <label class="col-md-12 control-label" for="total"></label>
                                                            <div class="col-md-12">
                                                                <input id="total" name="total" required="required" value="0" placeholder="عدد اسإلة الامتحان" class="form-control input-md" min="0" type="number">
                                                            </div>
                                                        </div>

                                                        <!-- Text input-->
                                                        <div class="form-group">
                                                            <label class="col-md-12 control-label" for="right"></label>
                                                            <div class="col-md-12">
                                                                <input id="right" name="right" placeholder="الدرجه للكل سؤال" value="0" class="form-control input-md" min="0" type="number" required="required">
                                                            </div>
                                                        </div>

                                                        <!-- Text input-->
                                                        <div class="form-group">
                                                            <label class="col-md-12 control-label" for="time"></label>
                                                            <div class="col-md-12">
                                                                <input id="time" name="time" placeholder="الوقت بالدقائق" value="0" class="form-control input-md" min="0" type="number" required="required">
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <br><button id="prospects_form" class="btn btn-primary" name="submitf3" type="submit">اضافة</button>
                                                </form>
                                                <br>
                                        </div>
                                        <?php echo '
                                                        <div style="border: 2px solid red;padding:5%;margin:3%;display:' . $s . ' !important">';
                                                echo '
                                                        <form class="form-horizontal title1" name="form" action="update.php?q=addqns&l=1&n=' . $total . '&eid=' . $lesid . '&ch=4 "  method="POST" enctype="multipart/form-data">
                                                        <fieldset>
                                                       ';

                                                for ($i = 1; $i <= $total; $i++) {
                                                    echo '<b>السؤال رقم&nbsp;' . $i . '&nbsp;:</><br />
                                                        <!-- Text input-->
                                                        <div class="form-group">
                                                        <label class="col-md-12 control-label" for="qns' . $i . ' "></label>  
                                                        <div class="col-md-12">
                                                          <input name="qns' . $i . '" class="form-control" placeholder="السؤال  ' . $i . ' هو ..." required="required" type="file">  
                                                        </div>
                                                      </div>                                                      <!-- Text input-->
                                                      <div class="form-group">
                                                        <label class="col-md-12 control-label" for="' . $i . '1"></label>  
                                                        <div class="col-md-12">
                                                        
                                                        <textarea rows="1" cols="2" id="' . $i . '1" name="' . $i . '1" placeholder="الاختيار الاول" class="form-control input-md" type="text" required="required"></textarea>
                                                          
                                                        </div>
                                                      </div>
                                                      <!-- Text input-->
                                                      <div class="form-group">
                                                        <label class="col-md-12 control-label" for="' . $i . '2"></label>  
                                                        <div class="col-md-12">
                                                        <textarea rows="1" cols="2" id="' . $i . '2" name="' . $i . '2" placeholder="الاختيار الثانى" class="form-control input-md" type="text" required="required"></textarea>
                                                          
                                                        </div>
                                                      </div>
                                                      <!-- Text input-->
                                                      <div class="form-group">
                                                        <label class="col-md-12 control-label" for="' . $i . '3"></label>  
                                                        <div class="col-md-12">
                                                        <textarea rows="1" cols="2" id="' . $i . '3" name="' . $i . '3" placeholder="الاختيار الثالث" class="form-control input-md" type="text"></textarea>
                                                          
                                                        </div>
                                                      </div>
                                                      <!-- Text input-->
                                                      <div class="form-group">
                                                        <label class="col-md-12 control-label" for="' . $i . '4"></label>  
                                                        <div class="col-md-12">
                                                        <textarea rows="1" cols="2" id="' . $i . '4" name="' . $i . '4" placeholder="الاختيار الرابع" class="form-control input-md" type="text"></textarea>
                                                        </div>
                                                      </div>
                                                      <br/>
                                                      <b>الاجابه الصحيحه :</b>:<br />
                                                      <select id="ans' . $i . '" name="ans' . $i . '" placeholder="الاجابه الصحيحه هى" class="form-control input-md" required="required">
                                                         <option value="a">حدد الاجابه الصحيحه للسؤال ال ' . $i . '</option>
                                                        <option value="a">الاختيار الاول</option>
                                                        <option value="b">الاختيار الثانى</option>
                                                        <option value="c">الاختيار الثالث</option>
                                                        <option value="d">الاختيار الرابع</option> 
                                                      </select><br /><br />';
                                                }
                                                echo '<div class="form-group">
                                                         <label class="col-md-12 control-label" for=""></label>
                                                         <div class="col-md-12"> 
                                                           <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="انتهى" class="btn btn-primary"/>
                                                         </div>
                                                       </div>
                                                       
                                                       </fieldset>
                                                       </form></div>';
                                            }
                                            if (@$_GET['q'] == 'editlesson') {
                                        ?>
                                        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>العنوان</th>
                                                    <th>لشهر</th>
                                                    <th>فصل</th>
                                                    <th>تاريخ الاضافه</th>
                                                    <th>ادوات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>العنوان</th>
                                                    <th>لشهر</th>
                                                    <th>فصل</th>
                                                    <th>تاريخ الاضافه</th>
                                                    <th>ادوات</th>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                $result = mysqli_query($dbh, "SELECT * FROM `lesson` ORDER BY time DESC");
                                                $c = 1;
                                                while ($row = mysqli_fetch_array($result)) {
                                                    $idles = $row['lessonid'];
                                                    $title = $row['title'];
                                                    $uuid = $row['ud'];
                                                    $t = $row['time'];
                                                    $resut = mysqli_query($dbh, "SELECT * FROM `unit` WHERE unitid='$uuid' ");
                                                    while ($ro = mysqli_fetch_array($resut)) {
                                                        $mon = $ro['uname'];
                                                        $clsae = $ro['classid'];
                                                        $rest = mysqli_query($dbh, "SELECT * FROM `tblclasses` WHERE ClassNameNumeric='$clsae'");
                                                        while ($r = mysqli_fetch_array($rest)) {
                                                            $sd = $r['ClassName'];
                                                            echo '
                                                        <tr style="background:#f9f9f9 !important">
                                                        <td>' . $c++ . '</td>
                                                        <td>' . $title . '</td>
                                                        <td>' . $mon . '</td>
                                                        <td>' . $sd . '</td>
                                                        <td>' . $t . '</td>
                                                        <td>
                                                        <a href="curriculum.php?q=edit&l=' . $idles . '"><i class="fa fa-edit"></i> تعديل </a>
                                                        </td>
                                                        </tr>';
                                                        }
                                                    }
                                                }
                                                echo '                        </table>
                                                    </div>';
                                            }
                                            if (@$_GET['q'] == 'edit') {
                                                $l = @$_GET['l'];
                                                $result = mysqli_query($dbh, "SELECT * FROM `lesson` WHERE lessonid='$l'");
                                                $c = 1;
                                                while ($row = mysqli_fetch_array($result)) {
                                                    $idles = $row['lessonid'];
                                                    $title = $row['title'];
                                                    $link = $row['youtube'];
                                                    $uuid = $row['ud'];
                                                    $t = $row['time'];
                                                    $resut = mysqli_query($dbh, "SELECT * FROM `unit` WHERE unitid='$uuid' ");
                                                    while ($ro = mysqli_fetch_array($resut)) {
                                                        $mon = $ro['uname'];
                                                        $clsae = $ro['classid'];
                                                        $rest = mysqli_query($dbh, "SELECT * FROM `tblclasses` WHERE ClassNameNumeric='$clsae'");
                                                        while ($r = mysqli_fetch_array($rest)) {
                                                            $sd = $r['ClassName'];
                                                        }
                                                    }
                                                }

                                                if (isset($_POST['submit'])) {
                                                    $studentname = $_POST['fullanme'];
                                                    $roolid = $_POST['rollid'];
                                                    $dd = $_POST['unid'];
                                                    $sql = mysqli_query($dbh, "UPDATE lesson SET title='$studentname',youtube='$roolid',ud='$dd' WHERE lessonid='$idles'");
                                                    echo "<script type='text/javascript'> document.location = 'curriculum.php?q=editlesson'; </script>";
                                                }
                                                ?>
                                                <form class="form-horizontal" method="post">
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">العنوان</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="fullanme" class="form-control" id="fullanme" value="<?php echo htmlentities($title) ?>" required="required" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">رابط الفيديو</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="rollid" class="form-control" id="rollid" value="<?php echo htmlentities($link) ?>" required="required" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">الشهر</label>
                                                        <div class="col-sm-10">
                                                            <select name="unid" class="form-control clid" required="required">
                                                                <option value="<?php echo "" . $uuid . ""; ?>"><?php echo ($mon); ?></option>
                                                                <?php
                                                                $sql = "SELECT * FROM unit WHERE classid='$clsae'";
                                                                $q = mysqli_query($dbh, $sql);
                                                                while ($rw = mysqli_fetch_array($q)) {
                                                                    if ($rw['unitid'] != $uuid) {
                                                                        echo '<option value="' .  htmlentities($rw['unitid']) . '">' . htmlentities($rw['uname']) . '&nbsp; </option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class=" form-group">
                                                        <label for="default" class="col-sm-2 control-label">الفصل</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="classname" class="form-control" id="classname" value="<?php echo htmlentities($sd) ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div align="center" class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="submit" class="btn btn-primary">تعديل</button>
                                                        </div>
                                                    </div>
                                                </form>
                                    </div>
                                <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </body>
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
        $("#prospects_form").submit(function(e) {
            e.preventDefault();
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

</html>