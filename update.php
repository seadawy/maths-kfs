<?php
include('includes/config2.php'); ?>
<?php
session_start();
if (@$_GET['q'] == 'rmstu') {
  $idxc = @$_GET['idroll'];
  $n = mysqli_query($dbh, "SELECT * FROM tblstudents WHERE RollId='$idxc'");
  while ($r = mysqli_fetch_array($n)) {
    $name = $r['StudentName'];
  }
  $u = mysqli_query($dbh, "DELETE FROM tblstudents WHERE RollId='$idxc'");
  $rank = mysqli_query($dbh, "DELETE FROM rank WHERE name='$name'");
  $h = mysqli_query($dbh, "DELETE FROM history WHERE idroll='$idxc'");
  header("location:manage-students.php");
}


//remove class مع كل سلطاتو
if (@$_GET['q'] == 'rmclass') {
  $clas = @$_GET['classid'];
  $result = mysqli_query($dbh, "SELECT * FROM quiz WHERE ClassNameNumeric='$clas'");
  while ($row = mysqli_fetch_array($result)) {
    $eid = $row['eid'];
    $qq = mysqli_query($dbh, "SELECT * FROM questions WHERE eid='$eid'");
    while ($rw = mysqli_fetch_array($qq)) {
      $qid = $rw['qid'];
      $r1 = mysqli_query($dbh, "DELETE FROM options WHERE qid='$qid'");
      $r2 = mysqli_query($dbh, "DELETE FROM answer WHERE qid='$qid'");
    }
    $r3 = mysqli_query($dbh, "DELETE FROM questions WHERE eid='$eid'");
    $r4 = mysqli_query($dbh, "DELETE FROM quiz WHERE eid='$eid'");
    $r4 = mysqli_query($dbh, "DELETE FROM history WHERE eid='$eid'");
  }
  $stu = mysqli_query($dbh, "DELETE FROM tblstudents WHERE ClassId='$clas'");
  $rc =  mysqli_query($dbh, "DELETE FROM tblclasses WHERE ClassNameNumeric='$clas'");
  header("location:classes.php?q=manage");
}

//remove quiz
if (@$_GET['q'] == 'rmquiz') {
  $eid = @$_GET['eid'];
  $result = mysqli_query($dbh, "SELECT * FROM questions WHERE eid='$eid' ");
  while ($row = mysqli_fetch_array($result)) {
    $qid = $row['qid'];
    $r1 = mysqli_query($dbh, "DELETE FROM options WHERE qid='$qid'");
    $r2 = mysqli_query($dbh, "DELETE FROM answer WHERE qid='$qid' ");
  }
  $r3 = mysqli_query($dbh, "DELETE FROM questions WHERE eid='$eid'");
  $r4 = mysqli_query($dbh, "DELETE FROM quiz WHERE eid='$eid' ");
  $r4 = mysqli_query($dbh, "DELETE FROM writer_w WHERE eid='$eid'");
  $ewqwe = mysqli_query($dbh, "SELECT * FROM history WHERE eid='$eid'");
  while ($weef = mysqli_fetch_array($ewqwe)) {
    $sss = $weef['score'];
    $idrpe = $weef['idroll'];
    $sqlre = mysqli_query($dbh, "SELECT * FROM tblstudents WHERE RollId='$idrpe'");
    while ($dcjk = mysqli_fetch_array($sqlre)) {
      $namsddcf = $dcjk['StudentName'];
      $dassdsadf = mysqli_query($dbh, "SELECT * FROM rank WHERE name='$namsddcf'");
      while ($dbskasfk = mysqli_fetch_array($dassdsadf)) {
        $s = $dbskasfk['score'];
        $rehab = $s - $sss;
        $new = mysqli_query($dbh, "UPDATE `rank` SET `score`=$rehab WHERE name='$namsddcf'") or die('Error124');
      }
    }
  }
  $r23 = mysqli_query($dbh, "DELETE FROM history WHERE eid='$eid'");
  $wqw = mysqli_query($dbh, "DELETE FROM writer_q WHERE eid='$eid'");
  header("location:quiz.php?q=manage");
}

//add quiz
if (@$_GET['q'] == 'addquiz') {
  $name = $_POST['name'];
  $name = ucwords(strtolower($name));
  $total = $_POST['total'];
  $sahi = $_POST['right'];
  $write_s = $_POST['rigw'];
  $n_w = $_POST['write'];
  $time = $_POST['time'];
  $classid = $_POST['class'];
  $id = uniqid();
  $q3 = mysqli_query($dbh, "INSERT INTO quiz VALUES  ('$id','$name' ,'$classid', '$sahi' , '$write_s' , '$sahi' ,'$total','$n_w','$time', NOW())");
  header("location:add-quiz.php?q=0&step=2&eid=$id&n=$total&nw=$n_w");
}

//add question
if (@$_GET['q'] == 'addqns') {
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

  $n = @$_GET['n'];
  $eid = @$_GET['eid'];
  $nw = @$_GET['nw'];
  $ch = @$_GET['ch'];
  mkdir('img/total_quiz/' . $eid . '');
  if ($n > 0) {
    for ($i = 1; $i <= $n; $i++) {
      $qid = uniqid();
      $qns = time() . '_' . $_FILES['qns' . $i . '']['name'];
      $target = 'img/total_quiz/' . $eid . '/' . $qns;
      $fileType = pathinfo($target, PATHINFO_EXTENSION);
      $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
      if (in_array($fileType, $allowTypes)) {
        $xx = $_FILES['qns' . $i . '']['tmp_name'];
        $compressedImage = compressImage($xx, $target, 80);
      }
      $q3 = mysqli_query($dbh, "INSERT INTO questions VALUES  ('$eid','$qid','$qns','$ch')");
      $oaid = uniqid();
      $obid = uniqid();
      $ocid = uniqid();
      $odid = uniqid();
      $a = $_POST[$i . '1'];
      $b = $_POST[$i . '2'];
      $c = $_POST[$i . '3'];
      $d = $_POST[$i . '4'];
      $qa = mysqli_query($dbh, "INSERT INTO options VALUES  ('$qid','$a','$oaid')") or die('Error61');
      $qb = mysqli_query($dbh, "INSERT INTO options VALUES  ('$qid','$b','$obid')") or die('Error62');
      $qc = mysqli_query($dbh, "INSERT INTO options VALUES  ('$qid','$c','$ocid')") or die('Error63');
      $qd = mysqli_query($dbh, "INSERT INTO options VALUES  ('$qid','$d','$odid')") or die('Error64');
      $e = $_POST['ans' . $i];
      switch ($e) {
        case 'a':
          $ansid = $oaid;
          break;
        case 'b':
          $ansid = $obid;
          break;
        case 'c':
          $ansid = $ocid;
          break;
        case 'd':
          $ansid = $odid;
          break;
        default:
          $ansid = $oaid;
      }
      $qans = mysqli_query($dbh, "INSERT INTO answer VALUES  ('$qid','$ansid')");
    }
  }
  if ($nw > 0) {
    mkdir('img/anser_w/' . $eid . '');
    for ($l = 1; $l <= $nw; $l++) {
      $qid = uniqid();
      $qnl = time() . '_' . $_FILES['qn' . $l . '']['name'];
      $target = 'img/total_quiz/' . $eid . '/' . $qnl;
      $fileType = pathinfo($target, PATHINFO_EXTENSION);
      $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
      if (in_array($fileType, $allowTypes)) {
        $xxl = $_FILES['qn' . $l . '']['tmp_name'];
        $compressedImage = compressImage($xxl, $target, 80);
      }
      $q3 = mysqli_query($dbh, "INSERT INTO writer_q VALUES ('$eid','$qid','$qnl')");
    }
  }
  if (@$_GET['l'] == 1) {
    header("location:curriculum.php?q=addlesson");
  } else {
    header("location:quiz.php?q=manage");
  }
}

//quiz start
if (@$_GET['q'] == 'quiz' && @$_GET['step'] == 2) {
  $eid = @$_GET['eid'];
  $sn = @$_GET['n'];
  $id = $_SESSION['alogin'];
  $total = @$_GET['t'];
  $ans = $_POST['ans'];
  $qid = @$_GET['qid'];
  /* حته رجوله منى */
  $ass = mysqli_query($dbh, "SELECT * FROM tblstudents WHERE RollId= '$id'");
  while ($rw = mysqli_fetch_array($ass)) {
    $name = $rw['StudentName'];
    $csls = $rw['ClassId'];
  }
  $q = mysqli_query($dbh, "SELECT * FROM answer WHERE qid='$qid' ");
  while ($row = mysqli_fetch_array($q)) {
    $ansid = $row['ansid'];
  }
  if ($ans == $ansid) {
    $q = mysqli_query($dbh, "SELECT * FROM quiz WHERE eid='$eid' ");
    while ($row = mysqli_fetch_array($q)) {
      $sahi = $row['sahi'];
    }
    if ($sn == 1) {
      $q = mysqli_query($dbh, "INSERT INTO history VALUES('$id','$eid' ,'0','0','0','0',NOW())") or die('Error');
    }
    $q = mysqli_query($dbh, "SELECT * FROM history WHERE eid='$eid' AND idroll='$id' ") or die('Error115');

    while ($row = mysqli_fetch_array($q)) {
      $s = $row['score'];
      $r = $row['sahi'];
    }
    $r++;
    $s = $s + $sahi;
    $q = mysqli_query($dbh, "UPDATE `history` SET `score`=$s,`level`=$sn,`sahi`=$r, date= NOW()  WHERE  idroll = '$id' AND eid = '$eid'") or die('Error124');
  } else {
    $q = mysqli_query($dbh, "SELECT * FROM quiz WHERE eid='$eid' ") or die('Error129');

    while ($row = mysqli_fetch_array($q)) {
      $wrong = $row['wrong'];
    }
    if ($sn == 1) {
      $q = mysqli_query($dbh, "INSERT INTO history VALUES('$id','$eid' ,'0','0','0','0',NOW() )") or die('Error137');
    }
    $q = mysqli_query($dbh, "SELECT * FROM history WHERE eid='$eid' AND idroll='$id' ") or die('Error139');
    while ($row = mysqli_fetch_array($q)) {
      $s = $row['score'];
      $w = $row['wrong'];
    }
    $w++;
    $s = $s;
    $q = mysqli_query($dbh, "UPDATE `history` SET `score`=$s,`level`=$sn,`wrong`=$w, date=NOW() WHERE idroll = '$id' AND eid = '$eid'") or die('Error147');
  }
  if ($sn != $total) {
    $sn++;
    header("location:index.php?q=quiz&step=2&eid=$eid&n=$sn&t=$total") or die('Error152');
  } else if ($_SESSION['key'] != 'elseadawy' || $_SESSION['key'] == 'elseadawy') {
    $q = mysqli_query($dbh, "SELECT score FROM history WHERE eid='$eid' AND idroll='$id'") or die('Error156');
    while ($row = mysqli_fetch_array($q)) {
      $s = $row['score'];
    }
    $q = mysqli_query($dbh, "SELECT * FROM rank WHERE name='$name'") or die('Error161');
    $rowcount = mysqli_num_rows($q);
    if ($rowcount == 0) {
      $q2 = mysqli_query($dbh, "INSERT INTO rank VALUES('$name','$csls','$s',NOW())") or die('Error165');
    } else {
      while ($row = mysqli_fetch_array($q)) {
        $sun = $row['score'];
      }
      $sun = $s + $sun;
      $q = mysqli_query($dbh, "UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE name = '$name'") or die('Error174');
    }
    header("location:index.php?q=result&eid=$eid&roll=$id");
  } else {
    header("location:index.php?q=result&eid=$eid");
  }
}


//restart quiz
if (@$_GET['q'] == 'quizre' && @$_GET['step'] == 25) {
  $eid = @$_GET['eid'];
  $n = @$_GET['n'];
  $id = $_SESSION['alogin'];
  $name = @$_GET['name'];
  $t = @$_GET['t'];
  $q = mysqli_query($dbh, "SELECT score FROM history WHERE eid='$eid' AND idroll='$id'") or die('Error156');
  if ($q) {
    while ($row = mysqli_fetch_array($q)) {
      $s = $row['score'];
    }
    $ass = mysqli_query($dbh, "SELECT * FROM tblstudents WHERE RollId= '$id'");
    while ($rw = mysqli_fetch_array($ass)) {
      $name = $rw['StudentName'];
    }
    $q = mysqli_query($dbh, "DELETE FROM history WHERE eid='$eid' AND idroll='$id' ") or die('Error184');
    $q = mysqli_query($dbh, "SELECT * FROM rank WHERE name='$name'") or die('Error161');
    while ($row = mysqli_fetch_array($q)) {
      $sun = $row['score'];
    }
    $sun = $sun - $s;
    $q = mysqli_query($dbh, "UPDATE rank SET score=$sun ,time=NOW() WHERE name= '$name'") or die('Error174');
    header("location:index.php?q=quiz&step=2&eid=$eid&n=1&t=$t");
  }
}

if (@$_GET['q'] == 'df') {
  $iq = @$_GET['g'];
  $ims = @$_GET['m'];
  $cl = @$_GET['c'];
  $h = mysqli_query($dbh, "DELETE FROM feedback WHERE funiq='$iq'");
  unlink('img/feed/' . $ims . '');
  header("location:feedback-admin.php?q=2&g=$cl");
}
