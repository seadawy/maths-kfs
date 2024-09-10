<!DOCTYPE html>
<html lang="en">
<?php
include('includes/config2.php');
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>محمد اسماعيل</title>
    <link rel="stylesheet" href="css/base.css" media="screen">
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.css" media="screen">
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
            </div>
    </nav>
    <?php

    function compressImage($source, $destination, $quality)
    {
        $imgInfo = getimagesize($source);
        $mime = $imgInfo['mime'];
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                imagejpeg($image, $destination, $quality);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                imagepng($image, $destination, $quality);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                imagegif($image, $destination, $quality);
                break;
            default:
                $image = imagecreatefromjpeg($source);
                imagejpeg($image, $destination, $quality);
        }
        return $destination;
    }
    $uploadPath = "img/feed/";

    $status = $statusMsg = '';
    if (isset($_POST["feed"])) {
        $status = 'error';
        if (!empty($_FILES["feeed"]["name"])) {
            $fileName = basename($_FILES["feeed"]["name"]);
            $imageUploadPath = $uploadPath . $fileName;
            $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                $imageTemp = $_FILES["feeed"]["tmp_name"];
                $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
                if ($compressedImage) {
                    $status = 'success';
                }
            }
        }
        $cls = $_POST['class'];
        $qq = uniqid();
        $imageTemp =  $_FILES['feeed']['name'];
        $n = $_POST['question'];
        $q1 = mysqli_query($dbh, "INSERT INTO `feedback` (`funiq`, `name`, `classid`, `photo`) VALUES ('$qq', '$n', '$cls', '$imageTemp')");
    }
    ?>
    <div style="border:3px solid #000000; padding:2%;margin:3%">

        <form align="center" name="form1" method="POST" enctype="multipart/form-data">
            <textarea rows="1" cols="2" class="form-control" name="question" type="text" placeholder="الاسم رباعى" required="required"></textarea>
            <select name="class" class="form-control clid" id="classid" required="required">
                <option value="">اختر الفصل</option>';
                <option value=" 9152 ">الاول الثانوى&nbsp; </option>
                <option value=" 9981 ">الثانى الثانوى&nbsp; </option>
                <option value=" 855 ">الثالث الثانوي&nbsp; </option>
            </select>
            <p style="font-size: 30px; color:white;background:#fd5f00;margin:10px;padding :10px">صوره الواجب</p>
            <input align="center" style="display: inline !important;" type="file" class="btn" name="feeed" required="required">
            <br>
            <button id="prospects_form" class="btn btn-primary" name="feed" type="submit">ارسال</button>
        </form>
        <br>  
        <br>
        <br>
        <br>
        <center>
            <div>
                <?php if ($status == 'success') {
                    echo '
                <div class="alert alert-success" role="alert"><strong> تم الارسال </strong></div>';
                } else if ($status == 'error') {
                    echo '
                <div class="alert alert-danger" role="alert"><strong> فشل فى الارسال حاول مره اخرى </strong></div>';
                }
                ?>
            </div>
        </center>
</body>

</html>