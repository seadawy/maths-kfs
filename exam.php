<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>الامتحانات الشامله</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <link rel="stylesheet" href="css/shome.css">
    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
        .button {
            border: none;
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .button4 {
            background-color: white;
            margin-left: 1em;
            color: black;
            border: 2px solid #e7e7e7;
        }

        .button4:hover {
            background-color: #e7e7e7;
        }
    </style>
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
                <div align="left" style="margin-right:12px;margin-top:12px;">
                    <a style="padding: 5px 10px;" href="index.php"><svg aria-labelledby="svg-inline--fa-title-K0trAEtPUD7Z " data-prefix="far " data-icon="sign-in-alt " role="img " xmlns="http://www.w3.org/2000/svg " viewBox="0 0 512 512 " class="svg-inline--fa fa-sign-in-alt fa-w-16 fa-fw
                    fa-lg ">
                            <path fill="currentColor " d="M144 112v51.6H48c-26.5 0-48 21.5-48 48v88.6c0 26.5 21.5 48 48 48h96v51.6c0 42.6 51.7 64.2 81.9 33.9l144-143.9c18.7-18.7 18.7-49.1 0-67.9l-144-144C195.8 48 144 69.3 144 112zm192 144L192 400v-99.7H48v-88.6h144V112l144
                    144zm80 192h-84c-6.6 0-12-5.4-12-12v-24c0-6.6 5.4-12 12-12h84c26.5 0 48-21.5 48-48V160c0-26.5-21.5-48-48-48h-84c-6.6 0-12-5.4-12-12V76c0-6.6 5.4-12 12-12h84c53 0 96 43 96 96v192c0 53-43 96-96 96z " class=" "></path>
                        </svg></a>
                </div>
            </div>
    </nav>
    <?php
    error_reporting(0);
    include('includes/config2.php');
    session_start();
    echo '
    
        <section class="section">
            <div class="container-fluid">
                <div class="row">

                <div class="panel-body p-20">
                <select name="thesearchbottom" id="searchtt" class="form-control clid" required="required">
                <option value="">اختر الفصل</option>
                <option value=" 9152 ">الاول الثانوى&nbsp; </option>
                <option value=" 9981 ">الثانى الثانوى&nbsp; </option>
                <option value=" 855 ">الثالث الثانوي&nbsp; </option>
            </select>

                <br>
                        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>العنوان</th>
                                    <th>عدد الاسئله</th>
                                    <th>الدرجه</th>
                                    <th>الوقت</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th>#</th>
                                <th>العنوان</th>
                                <th>عدد الاسئله</th>
                                <th>الدرجه</th>
                                <th>الوقت</th>
                                <th></th>
                                </tr>
                            </tfoot>
                            <tbody id="display" style="background-color:#f9f9f9;"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>';
    ?>

    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <script src="js/DataTables/datatables.min.js"></script>
    <!-- ========== THEME JS ========== -->
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
        $(document).ready(function() {
            $("#searchtt").change(function() {
                var name = $(this).val();
                if (name != "") {
                    $.ajax({
                        type: "POST",
                        url: "search.php",
                        data: {
                            search: name
                        },
                        success: function(html) {
                            $("#display").html(html).show();
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>