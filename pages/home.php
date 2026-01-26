<?php
session_start();
//include config
//require_once "waktu.php";
include_once('koneksi.php');

?>



<?php
//set base constant 
if (!isset($_SESSION['usernmEX']) || !isset($_SESSION['passwordEX'])) {
?>
  <script>
    setTimeout("location.href='index.php'", 500);
  </script>
<?php
  die('Illegal Acces');
}

//request page
$page  = isset($_GET['p']) ? $_GET['p'] : '';
$act  = isset($_GET['act']) ? $_GET['act'] : '';
$id    = isset($_GET['id']) ? $_GET['id'] : '';
$page  = strtolower($page);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head><!-- Created by Artisteer v4.3.0.60745 -->
  <meta charset="utf-8">
  <title>Home</title>
  <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">

<body>
  <blockquote style="margin: 0px">
    <h1>Welcome <?php echo strtoupper($_SESSION['usernmEX']); ?> at Indo Taichen Textile Industry</h1>
  </blockquote>
  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12"><a href="?p=Proforma-Invoice-Manual">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-file-text"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Proforma Invoice</span>
              <span class="info-box-number">&nbsp;</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="?p=PI-Detail-Manual">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-pencil-square-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Details PI</span>
              <span class="info-box-number">&nbsp;</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>

      <!-- <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="?p=Commercial-Invoice-Manual">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-tasks"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Commercial Invoice</span>
              <span class="info-box-number">&nbsp;</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
        <!-- /.info-box -->
      </div> -->
      <!-- /.col -->
      <!-- <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="?p=PEB-Kite">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-gears"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">PEB Kite</span>
              <span class="info-box-number">&nbsp;</span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
        <!-- /.info-box -->
      </div> -->
      <!-- /.col -->
    </div>
    <!-- /.row -->

  </section>
  <!-- /.content -->

</body>

</html>