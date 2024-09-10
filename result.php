<?php
include('includes/config2.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>تواصل</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="contact/css/style.css">
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }

        h2,
        h1,
        h3 {
            font-family: 'Cairo', sans-serif !important;
        }
    </style>
</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">النتيجه</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="wrapper">
                        <div class="row mb-5" style="justify-content: space-evenly;">
                            <div class="col-md-3">
                                <div class="dbox w-100 text-center">
                                    <div style="background: green" class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-check"></span>
                                    </div>
                                    <div class="text">
                                        <p><span>اجابات صحيحه:</span> <?php echo ($_GET['r']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="dbox w-100 text-center">
                                    <div style="background: red" class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-times"></span>
                                    </div>
                                    <div class="text">
                                        <p><span> اجابات خطأ:</span> <?php echo ($_GET['w']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="dbox w-100 text-center">
                                    <div style="background: #cccc0c" class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-star"></span>
                                    </div>
                                    <div class="text">
                                        <p><span>الدرجه :</span> <?php echo ($_GET['s']);
                                                                    echo '/';
                                                                    echo ($_GET['t']) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>