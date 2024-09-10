<?php
include('includes/config2.php');
session_start();
if ($_SESSION['alogin'] != "som3a") {
    header("Location: index.php");
} else {
    function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }
    
    function getToken($length)
    {
        $token = "#";
        $codeAlphabet  = "01234";
        $codeAlphabet .= "56789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
        }

        return $token;
    }
    if (isset($_POST['send32'])) {
        $n = $_POST['a7adw'];
        for ($i = 0; $i <= $n; $i++) {
            $idsasf = getToken(11);
            $IN = mysqli_query($dbh, "INSERT INTO `r-code` VALUES ('$idsasf')");
        }
    }
?>
    <!DOCTYPE html>
    <html dir="rtl">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>اكواد تفعيل</title>
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
        <link rel="stylesheet" href="css/select2/select2.min.css">
        <link rel="stylesheet" href="css/main.css" media="screen">
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>

    <body class="top-navbar-fixed">
        <div class="main-wrapper">
            <?php include('includes/topbar.php'); ?>
            <div class="content-wrapper">
                <div class="content-container">
                    <?php include('includes/leftbar.php'); ?>
                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <h2 align="center" class="title">انشاء كود تفعيل</h2>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <form id="form3" align="center" method="post">
                                <input class="has-success form-control" type="number" name="a7adw" value="1">
                                <input type="submit" id="cliv" name="send32" value="انشاء كود تفعيل">
                            </form>
                            <br>
                            <div align="center">
                                <label for="defult">كود التفعيل</label>
                                <input class="has-success form-control" style="padding: 0 10px;font-size: xx-large;width: fit-content;margin: 7px 0 0px 0px;" type="text" id="s" value="<?php echo ($idsasf) ?>" readonly>
                            </div><br>
                            <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                <tbody style="background-color:#f9f9f9;">
                                    <?php
                                    $result = mysqli_query($dbh, "SELECT * FROM `r-code` LIMIT 10000");
                                    $c = 1;
                                    while ($row = mysqli_fetch_array($result)) {
                                        $title = $row['code'];
                                        echo '
                                        <tr style="background:#f9f9f9 !important">
                                        <td>' . $title . '</td>
                                    </tr>';
                                    }
                                    ?>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    </body>

    </html>
<?php } ?>