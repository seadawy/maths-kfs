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
        <title>اسئله الطلاب</title>
        <link rel="stylesheet" href="css/cards.css" media="screen">
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
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
                    $q7 = mysqli_query($dbh, "SELECT * FROM feedback WHERE classid='$nameid'");
                    $ewq = mysqli_num_rows($q7);
                    echo '<br><br><a class="myButton" href="feedback-admin.php?q=2&g=' . $nameid . '">' . $name . ' (' . $ewq . ') </a><br><br>';
                }
                echo '</div>';
            }
            if (@$_GET['q'] == 2) { ?>
                <ul class="cards">
                    <?php
                    $cls = @$_GET['g'];
                    $q7 = mysqli_query($dbh, "SELECT * FROM feedback WHERE classid='$cls'");
                    while ($row = mysqli_fetch_array($q7)) {
                        $title = $row['name'];
                        $imm = $row['photo'];
                        $q32 = $row['funiq'];
                        echo '
    <li class="cards__item">
        <div class="card">
        <a href="#" class="pop">
            <img src="img/feed/' . $imm . '" class="card__image">
        </a>
            <div class="card__content">
                <div class="card__title">' . $title . '</div>
                <a href="update.php?q=df&g=' . $q32 . '&m=' . $imm . '&c=' . $cls . '" style="background:red;color:#ffffff;font-size:large" class="btn btn--block card__btn">مسح</a>
            </div>
        </div>
    </li>';
                    }
                    ?>
                </ul>
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
            <?php } ?>
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


    </body>

</html>

<?php  } ?>