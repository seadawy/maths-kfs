<?php
include('includes/config.php');
session_start();
error_reporting(0);
if ($_SESSION['alogin'] != "som3a") {
  header("Location: index.php");
} else {
?>
  <!DOCTYPE html>
  <html dir="rtl">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>اضافة امتحان</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen">
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
              <div align="center" class="row page-title-div">
                <h1 align="center">اضافةامتحان</h1>
              </div>
            </div>
            <section class="section">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-9 col-md-offset-2">
                    <div class="panel">
                      <div class="panel-body">
                        <?php
                        if (@$_GET['q'] == 0 && !(@$_GET['step'])) {
                        ?>
                          <form align="center" name="form" action="update.php?q=addquiz" method="POST">
                            <!-- Text input-->
                            <div class="form-group has-success">
                              <label style="text-align: start;" for="success" class="control-label">عنوان الامتحان</label>
                              <textarea rows="1" cols="2" type="text" name="name" class="form-control" required="required" id="success"></textarea>
                            </div>

                            <!-- Text input-->
                            <div class="form-group has-success">
                              <label style="text-align: start;" for="defult" class="control-label">عدد الاسإله الاختيارى</label>
                              <input id="total" name="total" required="required" class="form-control" min="0" type="number">
                            </div>

                            <!-- Text input-->
                            <div class="form-group has-success">
                              <label style="text-align: start;" for="defult" class="control-label">درجة كل سؤال اختيارى</label>
                              <input id="right" name="right" class="form-control input-md" min="0" type="number" required="required">
                            </div>

                            <!-- Text input-->
                            <div class="form-group has-success">
                              <label style="text-align: start;" for="defult" class="control-label">عدد الاسإله المقالى</label>
                              <input id="writ" name="write" class="form-control input-md" min="0" type="number" required="required">
                            </div>

                            <!-- Text input-->
                            <div class="form-group has-success">
                              <label style="text-align: start;" for="defult" class="control-label">درجة كل سؤال مقالى</label>
                              <input id="rigw" name="rigw" class="form-control input-md" min="0" type="number" required="required">
                            </div>

                            <!-- Text input-->
                            <div class="form-group has-success">
                              <label style="text-align: start;" for="defult" class="control-label">الوقت بالدقائق</label>
                              <input id="time" name="time" class="form-control input-md" min="0" type="number" required="required">
                            </div>

                            <!-- Text input-->
                            <div class="form-group has-success">
                              <select name="class" class="form-control clid" id="classid" onChange="getStudent(this.value);" required="required">
                                <option value="">حدد الفصل</option>
                                <?php
                                $sql = "SELECT * from tblclasses";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                  foreach ($results as $result) {
                                    echo '<option value=" ' .  htmlentities($result->ClassNameNumeric) . ' ">' . htmlentities($result->ClassName) . '&nbsp; </option>';
                                  }
                                }
                                ?>
                              </select>
                            </div>
                            <input type="submit" align="center" class="btn btn-primary" value="اضافه" class="btn btn-primary">
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    <?php
                        }
    ?>
    <!--add quiz end-->

    <!--add quiz step2 start-->
    <?php
    if (@$_GET['q'] == 0 && (@$_GET['step']) == 2) {
      echo '
<form name="form" action="update.php?q=addqns&n=' . @$_GET['n'] . '&eid=' . @$_GET['eid'] . '&ch=4&nw=' . @$_GET['nw'] . '" method="POST" enctype="multipart/form-data">';
      for ($i = 1; $i <= @$_GET['n']; $i++) {
        echo '<b>السؤال ال&nbsp;' . $i . '&nbsp;:</b><br>
        <!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="qns' . $i . ' "></label>  
  <div class="col-md-12">
    <input name="qns' . $i . '" class="form-control" placeholder="السؤال  ' . $i . ' هو ..." required="required" type="file">  
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="' . $i . '1"></label>  
  <div class="col-md-12">
  
  <textarea rows="1" cols="2" id="' . $i . '1" name="' . $i . '1" placeholder="الاختيار الاول" class="form-control input-md" type="text" required="required"></textarea>
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="' . $i . '2"></label>  
  <div class="col-md-12">
  <textarea rows="1" cols="2" id="' . $i . '2" name="' . $i . '2" placeholder="الاختيار الثانى" class="form-control input-md" type="text" required="required"></textarea>
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="' . $i . '3"></label>  
  <div class="col-md-12">
  <textarea rows="1" cols="2" id="' . $i . '3" name="' . $i . '3" placeholder="الاختيار الثالث" class="form-control input-md" type="text"></textarea>
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="' . $i . '4"></label>  
  <div class="col-md-12">
  <textarea rows="1" cols="2" id="' . $i . '4" name="' . $i . '4" placeholder="الاختيار الرابع" class="form-control input-md" type="text"></textarea>
  </div>
</div>
<br />
<b>الاجابه الصحيحه :</b>:<br />
<select id="ans' . $i . '" name="ans' . $i . '" placeholder="الاجابه الصحيحه هى" class="form-control input-md" required="required">
   <option value="a">حدد الاجابه الصحيحه للسؤال ال ' . $i . '</option>
  <option value="a">الاختيار الاول</option>
  <option value="b">الاختيار الثانى</option>
  <option value="c">الاختيار الثالث</option>
  <option value="d">الاختيار الرابع</option> 
</select>';
      }
      if (@$_GET['nw'] > 0) {
        echo '<h2 align="center">الاسئله المقاليه</h2>';
        for ($l = 1; $l <= @$_GET['nw']; $l++) {
          echo '
          <div class="form-group">
  <label class="col-md-12 control-label" for="qn' . $l . '"> السؤال المقالى رقم ' . $l . '</label>
  <div class="col-md-12">
  <input name="qn' . $l . '" class="form-control" type="file" placeholder="السؤال  ' . $l . ' هو ..." required="required"></textarea>  
  </div>
</div>';
        }
      }
      echo '
  </div>
</div>
<input align="center" type="submit" class="btn btn-primary" value="انتهى">
</form>';
    }
    ?>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="js/select2/select2.min.js"></script>
    <script src="js/main.js"></script>
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
<?php
} ?>