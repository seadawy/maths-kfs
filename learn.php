<!DOCTYPE html>
<html dir="rtl">
<?php
$_SESSION['flag'] = false;
include('includes/config2.php');
session_start();
$classid = @$_GET['c'];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="login/images/ee.png" type="image/png" sizes="194x194">
    <title>الحصص</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link href="https://fonts.googleapis.com/css2?family=Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/cards.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
</head>

<body>
    <nav class="navbar top-navbar bg-white box-shadow">
        <div class="container-fluid">
            <div class="row">
                <div align="center" class="no-padding">
                    <i style="margin-left: 0px;" class="navbar-brand">
                        MATHS-KFS
                    </i>
                </div>
                <div align="left" style="margin-left:12px;margin-top:12px;">
                    <button align="left" style="margin-top: 0px;padding-top: 0px;border-left-width: 0px;margin-right: 0px;" id="aloo" type="button" class="navbar-toggle mobile-nav-toggle">
                        <i class="fa fa-bars"></i>
                    </button>
                    <script>
                        document.getElementById("aloo").click()
                    </script>
                </div>
            </div>
        </div>
    </nav>
    <?php
    if (@$_GET['q'] == 1) {
        $q7 = mysqli_query($dbh, "SELECT * FROM unit WHERE classid='$classid'");
        $r = mysqli_num_rows($q7);
        if ($r == 0) {
            echo '<div align="center" style="margin-top :10%"><p align="center">لا يوجد محتوى الان حاول فى وقت اخر</p></div>';
        }
    ?>
        <h2>الترم الاول</h2>
        <ul class="cards">
            <?php
            $q7 = mysqli_query($dbh, "SELECT * FROM unit WHERE classid='$classid' AND term =1 ORDER BY id ASC");
            while ($row = mysqli_fetch_array($q7)) {
                $title = $row['uname'];
                $idun = $row['unitid'];
                echo '
        <li class="cards__item">
            <div class="card">
            <img src="images/t2.webp" class="card__image">
                <div class="card__content">
                   <center><div class="card__title">' . $title . '</div></center>
                        <a style="width:5em" href="learn.php?q=2&idun=' . $idun . '" class="btn btn-primary">ابدأ</a>
                    </div>
                </div>
            </div
        </li>';
            }
            echo '</ul>';
            ?>
            <h2>الترم الثانى</h2>

            <ul class="cards">
                <?php
                $q7 = mysqli_query($dbh, "SELECT * FROM unit WHERE classid='$classid' AND term =2 ORDER BY id ASC");
                while ($row = mysqli_fetch_array($q7)) {
                    $title = $row['uname'];
                    $idun = $row['unitid'];
                    $imm = $row['im'] ?? "";
                    echo '
        <li class="cards__item">
            <div class="card">
            <img src="images/t1.webp" class="card__image">
                <div class="card__content">
                   <center><div class="card__title">' . $title . '</div></center>
                        <a style="width:5em" href="learn.php?q=2&idun=' . $idun . '" class="btn btn-primary">ابدأ</a>
                    </div>
                </div>
            </div
        </li>';
                }
            }
            echo '</ul>';

            if (@$_GET['q'] == 2) {
                $idunit = $_GET['idun'];
                $wewe = array();
                $q7fwe = mysqli_query($dbh, "SELECT * FROM lesson WHERE ud='$idunit'");
                while ($ger = mysqli_fetch_array($q7fwe)) {
                    $idu = $ger['lessonid'];
                    array_push($wewe, $idu);
                }

                function covid19($dbh, $idu)
                {
                    if (isset($_POST['' . $idu . ''])) {
                        $e = $_POST['unawe'];
                        $qwew = mysqli_query($dbh, "SELECT * FROM `r-code` WHERE code='$e'");
                        $wfaqe = mysqli_num_rows($qwew);
                        if ($wfaqe == 1) {
                            $q234 = mysqli_query($dbh, "DELETE FROM `r-code` WHERE code='$e'");
                            $_SESSION['flag'] = true;
                            header('location:watch.php?id=' . $idu . '');
                        } else {
                            echo "<script>alert('تأكد من ادخال الكود بطريقه صحيحه');</script>";
                        }
                    }
                }

                foreach ($wewe as $v) {
                    covid19($dbh, $v);
                }
                ?>
                <ul class="cards">
                <?php
                $c = 1;
                $q7 = mysqli_query($dbh, "SELECT * FROM lesson WHERE ud='$idunit' ORDER BY `lesson`.`ord` ASC");
                while ($row = mysqli_fetch_array($q7)) {
                    $title = $row['title'];
                    $idles = $row['lessonid'];
                    $imm = $row['youtube'];
                    $code = $row['code'];
                    echo '
                    <li class="cards__item">
                        <div class="card">
                        <img src="images/t3.webp" class="card__image">
                            <div class="card__content">
                                 <center><div class="card__title">' . $c . '. ' . $title . '</div></center>';
                    if ($code) {
                        echo '
                    <form action="" method="post">
                        <input placeholder="كود التفعيل" class="form-control input-md" style="margin: 7px 0px;;display: initial;width: -webkit-fill-available;" type="text" name="unawe"><br>
                        <input class="btn btn-primary" style="margin:0" type="submit" name="' . $idles . '" value="تحقق">
                    </form>';
                    } else {
                        echo ' <a style="width:5em" href="watch.php?id=' . $idles . '" class="btn btn-primary">ابدأ</a>';
                    }
                    echo '
                    </div>
                </div>
            </div
        </li>';
                    $c++;
                }
                echo '</ul>';
            } ?>
</body>

</html>