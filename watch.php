<!DOCTYPE html>
<html dir="rtl">
<?php
include('includes/config2.php');
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="login/images/ee.png" type="image/png" sizes="194x194">
    <title>الحصص</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/cards.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <style>
        #overlay {
            /* we set all of the properties for our overlay */
            width: 80%;
            margin: 0 auto;
            background: white;
            color: black;
            padding: 10px;
            position: absolute;
            top: -10%;
            left: 10%;
            z-index: 1000;
            display: none;
            /* CSS 3 */
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            -o-border-radius: 10px;
            border-radius: 10px;
        }

        #mask {
            /* create are mask */
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 500;
            width: 100%;
            height: 100%;
            display: none;
        }

        /* use :target to look for a link to the overlay then we find our mask */
        #overlay:target,
        #overlay:target+#mask {
            display: block;
            opacity: 1;
        }

        .close {
            /* to make a nice looking pure CSS3 close button */
            display: block;
            position: absolute;
            top: -20px;
            right: -20px;
            background: red;
            color: white;
            height: 40px;
            width: 40px;
            line-height: 40px;
            font-size: 35px;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            -webkit-border-radius: 40px;
            -moz-border-radius: 40px;
            -o-border-radius: 40px;
            border-radius: 40px;
        }

        #open-overlay {
            /* open the overlay */
            padding: 10px 17px;
            background: #2B2A4C;
            color: white;
            text-decoration: none;
            display: inline-block;
            margin: 20px;
            font-weight: bold;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            -o-border-radius: 10px;
            border-radius: 10px;
            transition: .4s;
        }

        #open-overlay:hover {
            background: #181659;
        }

        .container {
            position: relative;
            width: 97%;
            overflow: hidden;
            padding-top: 56.25%;
            /* 16:9 Aspect Ratio */
        }

        .responsive-iframe {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>

<body>
    <?php
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $flag = "none";
    $uploadPath = "img/HomeWork/";
    $status = $statusMsg = '';

    if (isset($_POST["feed"])) {
        $status = 'error';
        if (!empty($_FILES["feeed"]["name"])) {
            $fileName = basename($_FILES["feeed"]["name"]);
            $fileName = preg_replace("/[^a-zA-Z0-9.-]/", "_", $fileName); // Sanitize filename
            $imageUploadPath = $uploadPath . uniqid() . '_' . $fileName;

            if (move_uploaded_file($_FILES["feeed"]["tmp_name"], $imageUploadPath)) {
                $status = 'success';
                $flag = "block";

                // Use prepared statements to prevent SQL injection
                $stmt = $dbh->prepare("INSERT INTO `homework` (lessonId, theImg) VALUES (?, ?)");
                $stmt->bind_param("is", $id, $fileName);

                if ($stmt->execute()) {
                    $statusMsg = "File uploaded successfully.";
                } else {
                    $statusMsg = "File upload failed, please try again.";
                    $status = 'error';
                    unlink($imageUploadPath); // Remove the uploaded file
                }
                $stmt->close();
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        } else {
            $statusMsg = "Please select a file to upload.";
        }
    }
    ?>
    <nav class="navbar top-navbar bg-white box-shadow">
        <div class="container-fluid">
            <div class="row">
                <div align="center" class="no-padding">
                    <i style="margin-left: 0px;" class="navbar-brand">
                        MATHS-KFS
                    </i>
                </div>
                <div align="center" style="float: left;" class="no-padding">
                    <a href="index.php?q=2" class="navbar-brand">
                        <i style="margin-left: 0px; float:left" class="fa fa-arrow-left"> </i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="content-wrapper">
        <div class="content-container">
            <!-- main -->
            <div class="main-page">
                <div class="container-fluid">
                    <!-- section 1 -->
                    <?php
                    $less = @$_GET['id'];
                    $ew = mysqli_query($dbh, "SELECT * FROM lesson WHERE lessonid='$less'");
                    while ($we = mysqli_fetch_array($ew)) {
                        $u = $we['youtube'];
                        echo '
                                <h2 style="margin-top: 17px !important;" class="titles" align="center">' . $we['title'] . '</h2>
                                <h2 style="margin-top: 17px !important;" class="titles" align="center">الشرح</h2>
                                <div class="container" align="center">
                                <iframe src="' . $u . '" frameborder="0" class ="responsive-iframe" allow="autoplay; fullscreen" allowfullscreen></iframe>
                                </div>                                
                                ';
                    } ?>
                </div>

                <div align="center">
                    <div align="center">
                    </div>
                    <?php
                    $less = @$_GET['id'];
                    $ew = mysqli_query($dbh, "SELECT * FROM lesson WHERE lessonid='$less'");
                    while ($we = mysqli_fetch_array($ew)) {
                        $work = $we['work'];
                    }
                    $new = mysqli_query($dbh, "SELECT * FROM lessonsasset WHERE lessonId='$less' limit 1 ");
                    $pdf = mysqli_fetch_assoc($new);
                    ?>
                    <a style="display: none;" href="#overlay" id="open-overlay" <?php if ($work == null) echo 'style="pointer-events: none;background: #9494c5;"' ?>>
                        <?php if ($work == null) echo "لا يوجد واجب لهذه الحصه";
                        else echo "الواجب" ?>
                    </a>
                    <a href="Assets/<?= $pdf['file'] ?>" id="open-overlay" <?php if ($pdf == null) echo 'style="pointer-events: none;background: #9494c5;"' ?> target="_blank" download>
                        <?php if ($pdf == null) echo "لا يوجد ملف لهذه الحصه";
                        else echo "اضغط لتحميل pdf ملف" ?>
                    </a>
                    <div id="overlay">
                        <a href="#" class="close">&times;</a>
                        <h2>التعليمات</h2>
                        <p style="font-size:20px;">
                            حمل الواجب ثم بعد الحل
                            إختر الصورة ثم اضغط إرسال تأكد من وضوح الصوره و كتابة إسمك فى اعلى الصفحه
                        </p>
                        <h2>الواجب</h2>
                        <br>
                        <a href="HomeWork/<?php echo $work ?> " style="background: green;
                                padding: 10px;
                                color: white;
                                border-radius: 5px;
                                font-size: 15px;" target="_blank" download>اضغط هنا لتحميل الواجب <i class="fa fa-download" aria-hidden="true"></i>
                        </a>
                        <h2>ارسال الواجب</h2>
                        <form name="form1" method="POST" enctype="multipart/form-data">
                            <input type="file" name="feeed" required><br>
                            <input type="submit" name="feed" value="ارسال" style="background:wheat;border:0;">
                        </form>
                        <br>
                        <div style="display: <?php echo $flag ?>;">
                            <i class="fa fa-check-circle" style="color:green;font-size:10em;" aria-hidden="true"></i>
                            <p>تم الارسال</p>
                        </div>
                    </div>
                    <div id="mask" onclick="document.location='#';"></div> <!-- the only javascript -->
                </div>
            </div>
            </main>
        </div>
    </div>
</body>

</html>