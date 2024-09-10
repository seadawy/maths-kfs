<!DOCTYPE html>
<html dir="rtl">
<?php
include('includes/config2.php');
session_start();
if ($_SESSION['alogin'] != "som3a") {
    header("Location: index.php");
} else {
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>تصحيح المقالى</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/cardss.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/main.css" media="screen">
        <link rel="stylesheet" href="css/corr.css">
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>

    <body class="top-navbar-fixed">
        <?php include('includes/topbar.php'); ?>
        <div class="content-wrapper">
            <?php include('includes/leftbar.php'); ?>
            <?php
            if (@$_GET['q'] == 1) {
                echo '<div style="top:0; left:0" align="center">';
                $q321 = mysqli_query($dbh, "SELECT * FROM tblclasses");
                while ($l = mysqli_fetch_array($q321)) {
                    $nameid = $l['ClassNameNumeric'];
                    $name = $l['ClassName'];
                    echo '<br><br><a class="myButton" href="correct.php?q=2&g=' . $nameid . '">' . $name . '</a><br><br>';
                }
                echo '</div>';
            }

            if (@$_GET['q'] == 2) {
                $cls = @$_GET['g'];
                echo '<div style="top:0; left:0;display:grid" align="center">';
                $q321 = mysqli_query($dbh, "SELECT * FROM quiz WHERE ClassNameNumeric='$cls'");
                while ($l = mysqli_fetch_array($q321)) {
                    $nameid = $l['eid'];
                    $name = $l['title'];
                    $q31 = mysqli_query($dbh, "SELECT * FROM w_a_s WHERE class='$cls' AND eid='$nameid'");
                    $qwert = mysqli_num_rows($q31);
                    echo '<br><br><a class="myButton" href="correct.php?q=3&quiz=' . $nameid . '">' . $name . ' (' . $qwert . ') </a>';
                }
                echo '</div>';
            }

            if (@$_GET['q'] == 3) {
                $quizid = @$_GET['quiz'];
                $q0 = mysqli_query($dbh, "SELECT * FROM quiz WHERE eid='$quizid'");
                while ($w = mysqli_fetch_array($q0)) {
                    $s = $w['write_s'];
                }
                $s2 = $s / 2;
                $q = mysqli_query($dbh, "SELECT * FROM w_a_s WHERE eid='$quizid' LIMIT 1");
                while ($row = mysqli_fetch_array($q)) {
                    $id = $row['idroll'];
                    $clls = $row['class'];
                }
                $q1 = mysqli_query($dbh, "SELECT * FROM tblstudents WHERE RollId='$id' LIMIT 1");
                while ($rw = mysqli_fetch_array($q1)) {
                    $name = $rw['StudentName'];
                    echo '<h2 align="center">' . $name . '</h2>';
                    $q2 = mysqli_query($dbh, "SELECT * FROM w_a_s WHERE eid='$quizid' AND idroll='$id'");
                    $c = -1;
                    echo '
                    <form action="" method="POST">
                    <ul class="cards">';
                    while ($r = mysqli_fetch_array($q2)) {
                        $img = $r['f_anser'];
                        $c++;
                        echo '
                            <li class="cards__item">
                                <div class="card">
                                <a href="#" class="pop">
                                <img src="img/anser_w/' . $quizid . '/' . $img . '" class="card__image">
                                </a>    
                                <div class="card__content">
                                        <input type="radio" name="q' . $c . '" value="' . $s . '" required="required" checked>&nbsp&nbsp' . $s . '  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="radio" name="q' . $c . '" value="' . $s2 . '" required="required">&nbsp&nbsp' . $s2 . '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="radio" name="q' . $c . '" value="0" required="required">&nbsp&nbsp0
                                    </div>
                                </div>
                            </li>';
                    }
                }
                echo '</ul>
                <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <img src="" class="imagepreview" style="width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
                <input type="number" name="btnc" style="display:none" value="' . $c . '"> 
                <div align="center">
                <br>
                <button align="center" type="submit" style="btn" name="fuckup">ارسال</button>
                </div>
                </form>';
            }
            if (isset($_POST['fuckup'])) {
                $r = $_POST['btnc'];
                $the = array();
                for ($i = 0; $i <= $r; $i++) {
                    $a = $_POST['q' . $i . ''];
                    array_push($the, $a);
                }
                $sum = array_sum($the);
                $q5 = mysqli_query($dbh, "SELECT * FROM history WHERE idroll='$id'");
                while ($wl = mysqli_fetch_array($q5)) {
                    $s = $wl['score'];
                }
                $rank = mysqli_query($dbh, "SELECT * FROM rank WHERE name='$name'");
                while ($sd = mysqli_fetch_array($rank)) {
                    $mm = $sd['score'];
                }
                $mark = $mm - $s;
                $ss = $sum + $s;
                $Wfinish = mysqli_query($dbh, "UPDATE `history` SET `score`=$ss WHERE idroll = '$id' AND eid = '$quizid'");
                $mar = $mark + $ss;
                $Rfinish = mysqli_query($dbh, "UPDATE `rank` SET `score`=$mar WHERE name='$name'");
                $q72 = mysqli_query($dbh, "SELECT * FROM w_a_s WHERE eid='$quizid' AND idroll='$id'");
                while ($rere = mysqli_fetch_array($q72)) {
                    $d = $rere['f_anser'];
                    unlink('img/anser_w/' . $quizid . '/' . $d . '');
                }
                $del = mysqli_query($dbh, "DELETE FROM w_a_s WHERE eid='$quizid' AND idroll='$id'");
                echo "<script type='text/javascript'> document.location = 'correct.php?q=3&quiz=$quizid'; </script>";
            }
            ?>
        </div>
        </div>
    </body>
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="js/select2/select2.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(function() {
            $('.pop').on('click', function() {
                $('.imagepreview').attr('src', $(this).find('img').attr('src'));
                $('#imagemodal').modal('show');
            });
        });
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
<?php
} ?>