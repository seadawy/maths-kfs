<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>امتحان</title>
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

<!-- START QUIZ -->
<?php
include('includes/config2.php');
session_start();
$id = $_SESSION['alogin'];
$eid = @$_GET['eid'];
if (@$_GET['q'] == 'ff') {
    $eid = @$_GET['eid'];
    $t = @$_GET['t'];
    $test_Aad = mysqli_query($dbh, "SELECT * FROM history WHERE idroll='$id' AND eid='$eid'");
    if (mysqli_num_rows($test_Aad) == 0) {
        $InsertH = mysqli_query($dbh, "INSERT INTO history VALUES('$id', '$eid' , '0', '0', '0', NOW())");
        $_SESSION['bis'] = uniqid();
        header("location:quiz_ex.php?q=quiz&step=1&eid=$eid&n=1&t=$t");
    } else {
        header("location:exam.php");
    }
}

if (@$_GET['q'] == 'quiz') {
    if (strlen($_SESSION['bis']) == "") {
        header("Location: exam.php");
    } else {
        $ass = mysqli_query($dbh, "SELECT * FROM tblstudents WHERE RollId='$id' ");
        while ($rw = mysqli_fetch_array($ass)) {
            $name = $rw['StudentName'];
            $csls = $rw['ClassId'];
        }
        function compressImage($source, $destination, $quality)
        {
            $imgInfo = getimagesize($source);
            $mime = $imgInfo['mime'];

            switch ($mime) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($source);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($source);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($source);
                    break;
                default:
                    $image = imagecreatefromjpeg($source);
            }
            imagejpeg($image, $destination, $quality);
            return $destination;
        }

        if (isset($_POST['end'])) {
            $_SESSION['bis'] = '';
            $t = @$_GET['t'];
            $m = $_POST['valuew'];
            for ($wq = 1; $wq <= $m; $wq++) {
                $qnw = $id . '_' . $_FILES['an' . $wq . '']['name'];
                $target = 'img/anser_w/' . $eid . '/' . $qnw;
                $fileType = pathinfo($target, PATHINFO_EXTENSION);
                $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                if (in_array($fileType, $allowTypes)) {
                    $xx = $_FILES['an' . $wq . '']['tmp_name'];
                    $compressedImage = compressImage($xx, $target, 80);
                }
                $done = mysqli_query($dbh, "INSERT INTO w_a_s VALUES ('$id','$csls','$eid','$qnw')");
            }
            $qusSelect = mysqli_query($dbh, "SELECT * FROM questions WHERE eid='$eid'");
            while ($row = mysqli_fetch_array($qusSelect)) {
                $qustionid = $row['qid'];

                $oSelect = mysqli_query($dbh, "SELECT * FROM options WHERE qid='$qustionid'");
                while ($rw = mysqli_fetch_array($oSelect)) {
                    $optid = $rw['optionid'];
                    $anser = $_POST['' . $qustionid . ''];
                }

                $aSelect = mysqli_query($dbh, "SELECT * FROM answer WHERE qid='$qustionid' ");
                while ($rw = mysqli_fetch_array($aSelect)) {
                    $rightopt = $rw['ansid'];
                }

                $qSelect = mysqli_query($dbh, "SELECT * FROM quiz WHERE eid='$eid' ");
                while ($rw = mysqli_fetch_array($qSelect)) {
                    $sahi = $rw['sahi'];
                    $wrong = $rw['wrong'];
                }

                if ($anser == $rightopt) {
                    $hSelect = mysqli_query($dbh, "SELECT * FROM history WHERE eid='$eid' AND idroll='$id' ") or die('Error115');
                    while ($rw = mysqli_fetch_array($hSelect)) {
                        $s = $rw['score'];
                        $r = $rw['sahi'];
                    }
                    $r++;
                    $s = $s + $sahi;
                    $Rfinish = mysqli_query($dbh, "UPDATE `history` SET `score`=$s,`sahi`=$r, date= NOW()  WHERE  idroll = '$id' AND eid = '$eid'") or die('Error124');
                } else {
                    $hSelect = mysqli_query($dbh, "SELECT * FROM history WHERE eid='$eid' AND idroll='$id' ") or die('Error115');
                    while ($rw = mysqli_fetch_array($hSelect)) {
                        $s = $rw['score'];
                        $w = $rw['wrong'];
                    }
                    $w++;
                    $s = $s;
                    $Wfinish = mysqli_query($dbh, "UPDATE `history` SET `score`=$s,`wrong`=$w, date=NOW() WHERE idroll = '$id' AND eid = '$eid'");
                }
            }
            $sSelectH = mysqli_query($dbh, "SELECT score FROM history WHERE eid='$eid' AND idroll='$id'") or die('Error156');
            while ($row = mysqli_fetch_array($sSelectH)) {
                $s = $row['score'];
            }
            $rankSelect = mysqli_query($dbh, "SELECT * FROM rank WHERE name='$name'") or die('Error161');
            $rowcount = mysqli_num_rows($rankSelect);
            if ($rowcount == 0) {
                $q = mysqli_query($dbh, "INSERT INTO rank VALUES('$name','$csls','$s',NOW())") or die('Error165');
            } else {
                while ($row = mysqli_fetch_array($rankSelect)) {
                    $sun = $row['score'];
                }
                $sun = $s + $sun;
                $q = mysqli_query($dbh, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE name = '$name'") or die('Error174');
            }
            header("location:anser.php?eid=$eid");
        }

        $eid = @$_GET['eid'];
        $t = @$_GET['t'];
        $qwf = mysqli_query($dbh, "SELECT * FROM quiz WHERE eid='$eid'");
        while ($f = mysqli_fetch_array($qwf)) {
            $time = $f['time'];
        }
?>

        <body style="margin-top: 50px !important;" class="top-navbar-fixed">
            <div class="main-wrapper">
                <nav id="nanan" class="navbar top-navbar navbar-default" style="height:50px !important">
                    <div class="container-fluid">
                        <button align="right" type="button" class="navbar-toggle collapsed" onclick="openNav()">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <button align="right" type="button" style="display:none" id="bbew" onclick="nNav()"></button>
                        <p style="float:left;margin-top:12px">الوقت : <i style="width:fit-content;padding: 0px .5em;margin:0px;border:1px solid blue"><span id="time"></span></i></p>
                    </div>
                </nav>
                <div class="content-wrapper">
                    <div class="content-container">
                        <div id="ss" class="sidebar">
                            <h2 align="center" style="color:#ffffff">انتظر جارى ارسال اجاباتك</h2>
                            <h3 align="center" style="color:#ffffff">لن يتم ارسال اجباتك قبل التحويل التلقائى</h3>
                            <h3 align="center" style="color:#ffffff">لا تحاول الخروج حتى لا تحدث اى مشاكل</h3>
                            <h3 align="center" style="color:#ffffff">سيتم تحويلك تلقائى عند الانتهاء</h3>
                        </div>
                    </div>
                    <div id="mySidebar" class="sidebar">
                        <a href="javascript:void(0)" style="color:red" class="closebtn" onclick="closeNav()">x</a>
                    <?php
                    for ($i = 1; $i <= $t; $i++) {
                        echo '
                        <div class="grid-cell grid-25">
                            <div class="square square-100">
                                <a onclick="closeNav()" href="#q-' . $i . '">' . $i . ' </a>
                            </div>
                        </div>';
                    }
                    echo '</div>';
                    echo '<form action="" id="MyForm" method="POST" enctype="multipart/form-data">
                            <br>';














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
                        <img style="margin-bottom: 7px;" width="300" class="zoom" src="img/total_quiz/' . $eid . '/' . $qustionname . '">
                    </div>
                    <ul class="answer-options">
                    ';
                        $q0 = mysqli_query($dbh, "SELECT * FROM options WHERE qid ='$qustionid'");
                        while ($rw = mysqli_fetch_array($q0)) {
                            $op = $rw['option'];
                            $opid = $rw['optionid'];
                            echo '
                            <li class="answer-option">
                            <input type="radio" class="option-check" id="' . $opid . '" value="' . $opid . '" name="' . $qustionid . '"/>
                            <div class="option-title">
                                <div class="option-title-content">' . $op . '</div>
                            </div>                    
                            </li>';
                        }
                        echo '</ul></fieldset>';
                    }








                    $i = $i;
                    $l = $l;
                    $ml = 1;
                    $qq = mysqli_query($dbh, "SELECT * FROM writer_q WHERE eid='$eid'");
                    $m = mysqli_num_rows($qq);
                    while ($row = mysqli_fetch_array($qq)) {
                        $qustionname = $row['qns'];
                        $qustionid = $row['qid'];
                        echo '<a name="q-' . $i++ . '"></a>
            <br>
            <fieldset style="margin:0px 2px auto;border:2px solid #8e3636;">
            <legend align="right"> السؤال ' . $l++ . '</legend>
            <div align="center">
            <img class="zoom" width="300" src="img/total_quiz/' . $eid . '/' . $qustionname . '">
            </div>
            <hr style="margin:1px;color:black;border:solid">
                <input type="file" name="an' . $ml++ . '">';
                        echo '</fieldset>';
                    }

                    echo '
            <input style="display:none !important" type="number" name="valuew" value="' . $m . '" required="required">
            </div><br><div align="center">
            <button type="submit" id="end" name="end" onclick="bitch()" align="center" class="button"><span>انهاء</span>
            <svg>
                <polyline class="o1 " points="0 0, 150 0, 150 55, 0 55, 0 0 "></polyline>
                <polyline class="o2 " points="0 0, 150 0, 150 55, 0 55, 0 0 "></polyline>
            </svg>
            </button>
            </div>
            </form>';
                    echo '</div>';
                }
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
        <?php
        echo '
                <script>
    function startTimer(duration, display) {
        var timer = duration,
            minutes, seconds;
        setInterval(function() {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) {
                timer = duration;
            }
        }, 1000);
    }

    window.onload = function() {
        var Minutess = 60 * ' . $time . ',
            display = document.querySelector(\'#time\');
        startTimer(Minutess, display);
    };
    var varTimerInMiliseconds = 60000*' . $time . '
    setTimeout(function(){ 
        document.getElementById("bbew").click();
        document.getElementById("end").click();
        document.getElementById("nanan").style.display = "none";
    }, varTimerInMiliseconds);

    
    function bitch() {
        document.getElementById("bbew").click();
        document.getElementById("nanan").style.display = "none";
    }
    </script>';
        ?>

</html>
<?php
}
?>