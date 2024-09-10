<?php
include('includes/config2.php');
session_start();
$id = $_SESSION['alogin'];
$eid = @$_GET['eid'];
$t = @$_GET['t'];
$test_Aad = mysqli_query($dbh, "SELECT * FROM history WHERE idroll='$id' AND eid='$eid'");
if (mysqli_num_rows($test_Aad) == 0) {
    header("location:learn.php?q=1");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الاجابات</title>
    <link rel="stylesheet" href="css/quiz.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }

        .progress {
            display: none;
            position: relative;
            width: 400px;
            border: 1px solid #ddd;
            padding: 1px;
            border-radius: 3px;
        }

        .bar {
            background-color: #B4F5B4;
            width: 0%;
            height: 20px;
            border-radius: 3px;
        }

        .percent {
            position: absolute;
            display: inline-block;
            top: 3px;
            left: 48%;
        }
    </style>
</head>

<body style="margin-top: 50px !important;" class="top-navbar-fixed">
    <div class="main-wrapper">
        <nav id="nanan" class="navbar top-navbar navbar-default" style="height:50px !important">
            <p style="font-size:18px;color:red;margin-top:12px" class="a7a" align="center">
                <?php
                $q122 = mysqli_query($dbh, "SELECT * FROM quiz WHERE eid='$eid'");
                while ($awd = mysqli_fetch_array($q122)) {
                    $less = $awd['eid'];
                    $total = $awd['total'];
                    $r = $awd['sahi'];
                    $q12 = mysqli_query($dbh, "SELECT * FROM history WHERE eid='$less' AND idroll='$id'");
                    while ($qew = mysqli_fetch_array($q12)) {
                        $nnb = $qew['score'];
                        $rrr = $total * $r;
                        echo 'درجتك : ' . $nnb . '  من :  ' . $rrr . '<br>';
                    }
                }
                ?>
            </p>
        </nav>
        <?php
        $q = mysqli_query($dbh, "SELECT * FROM questions WHERE eid='$eid'");
        $i = 1;
        $l = 1;
        while ($row = mysqli_fetch_array($q)) {
            $qustionname = $row['qns'];
            $qustionid = $row['qid'];
            echo '
                <a name="q-' . $i++ . '"></a>
                <fieldset style="margin:0px 2px auto;border:2px solid #8e3636;">
                    <legend style="margin-bottom: 2px;" align="right"> السؤال ' . $l++ . '</legend>
                    <div align="center">
                    <img style="margin-bottom: 7px;width:90%" width="300" class="zoom" src="img/total_quiz/' . $eid . '/' . $qustionname . '">
                    </div>
                    <ul class="answer-options">
                    ';
            $q0 = mysqli_query($dbh, "SELECT * FROM options WHERE qid ='$qustionid'");
            while ($rw = mysqli_fetch_array($q0)) {
                $op = $rw['option'];
                $opid = $rw['optionid'];
                $q4rt = mysqli_query($dbh, "SELECT * FROM answer WHERE qid='$qustionid'");
                while ($row = mysqli_fetch_array($q4rt)) {
                    $ansid = $row['ansid'];
                }
                if ($ansid == $opid) {
                    echo '                
                <li class="answer-option answer-correct answer-selected answered-correct">
                <input type="radio" disabled="disabled" checked="checked" class="option-check" id="' . $opid . '" value="' . $opid . '" name="' . $qustionid . '"/>
                    <div class="option-title">
                        <div class="option-title-content">' . $op . '</div>
                    </div>                    
                </li>';
                } else {
                    echo '
                <li class="answer-option">
                    <input type="radio" disabled="disabled" class="option-check" id="' . $opid . '" value="' . $opid . '" name="' . $qustionid . '"/>
                        <div class="option-title">
                            <div class="option-title-content">' . $op . '</div>
                        </div>                    
                </li>';
                }
            }
            echo '</ul></fieldset>';
        }
        echo '
            </div><br><div align="center">
            <a type="submit" id="end" name="end" href="exam.php" align="center" class="button"><span>خروج</span>
            <svg>
                <polyline class="o1 " points="0 0, 150 0, 150 55, 0 55, 0 0 "></polyline>
                <polyline class="o2 " points="0 0, 150 0, 150 55, 0 55, 0 0 "></polyline>
            </svg>
            </a>
            </div>
            </form>';
        echo '</div>';

        ?>
    </div>
    </div>
</body>
<script src="js/jquery/jquery-2.2.4.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script>
    function openNav() {
        document.getElementById("mySidebar").style.width = "-webkit-fill-available";
    }

    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
    }

    function nNav() {
        document.getElementById("ss").style.width = "-webkit-fill-available";
    }
</script>

</html>