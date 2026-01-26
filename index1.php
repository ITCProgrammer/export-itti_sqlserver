<?php
session_start();
//include config
//require_once "waktu.php";
include('koneksi.php');
ini_set("error_reporting", 1);
?>



<?php
//set base constant
if (!isset($_SESSION['usernmEX'])) {
?>
  <script>
    setTimeout("location.href='login'", 500);
  </script>
<?php
  die('Illegal Acces');
} elseif (!isset($_SESSION['passwordEX'])) {
?>
  <script>
    setTimeout("location.href='lockscreen'", 500);
  </script>
<?php
  die('Illegal Acces');
}

//request page
$page = isset($_GET['p']) ? $_GET['p'] : '';
$act  = isset($_GET['act']) ? $_GET['act'] : '';
$id   = isset($_GET['id']) ? $_GET['id'] : '';
$page = strtolower($page);
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Export |
    <?php if ($_GET['p'] != "") {
      echo ucwords($_GET['p']);
    } else {
      echo "Home";
    } ?>
  </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css"> -->
  <!-- toast CSS -->
  <link href="bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link href="bower_components/datatables.net-bs/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="dist/css/skins/skin-purple.min.css">
  <!-- Sweet Alert -->
  <link href="bower_components/sweetalert/sweetalert2.css" rel="stylesheet" type="text/css">
  <!-- Sweet Alert -->
  <script type="text/javascript" src="bower_components/sweetalert/sweetalert2.min.js"></script>
  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <link href="bower_components/toastr/toastr.css" rel="stylesheet">

  <!-- Google Font -->
  <!--
  <link rel="stylesheet"
        href="dist/css/font/font.css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  -->
  <link rel="icon" type="image/png" href="dist/img/index.ico">
  <style>
    .blink_me {
      animation: blinker 1s linear infinite;
    }

    .bulat {
      border-radius: 50%;
      /*box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);*/
    }

    .border-dashed {
      border: 3px dashed #083255;
    }

    .border-dashed-tujuan {
      border: 3px dashed #FF0007;
    }

    @keyframes blinker {
      50% {
        opacity: 0;
      }
    }

    body {
      font-family: Calibri, "sans-serif", "Courier New";
      /* "Calibri Light","serif" */
      font-style: normal;
    }
  </style>

</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition skin-purple sidebar-collapse fixed">

  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header ">

      <!-- Logo -->
      <a href="?p=Home" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Exp</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Exp</b>ort</span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <?php        ?>

            <!-- Notifications Menu -->
            <li class="dropdown notifications-menu">
              
            </li>
           
           
            

            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="dist/img/<?php echo $_SESSION['fotoEX']; ?>.png" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">
                  <?php echo strtoupper($_SESSION['usernmEX']); ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="dist/img/<?php echo $_SESSION['fotoEX']; ?>.png" class="img-circle" alt="User Image">

                  <p>
                    <?php echo strtoupper($_SESSION['usernmEX']); ?> -
                    <?php echo "-"; ?>
                    <small>Member since
                      <?php echo "-"; ?></small>
                  </p>
                </li>
                <!-- Menu Body -->
                <!-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div> -->
                <!-- /.row -->
            <!--</li>-->
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="lockscreen" class="btn btn-default btn-flat">LockScreen</a>
              </div>
              <div class="pull-right">
                <a href="logout" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="dist/img/<?php echo $_SESSION['fotoEX']; ?>.png" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>
              <?php echo strtoupper($_SESSION['usernmEX']); ?>
            </p>
            <!-- Status -->
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- search form (Optional) -->
        <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
        </div>
      </form>-->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">HEADER</li>
          <!-- Optionally, you can add icons to the links -->
          <li class="<?php if ($_GET['p'] == "Home" or $_GET['p'] == "") {
                        echo "active";
                      } ?>"><a href="?p=Home"><i class="fa fa-dashboard text-success"></i> <span>DashBoard</span></a></li>
          <?php if(strtolower($_SESSION['usernmEX'])!="mkt") { ?>
          <li class="treeview <?php if ($_GET['p'] == "Proforma-Invoice-Manual" or $_GET['p'] == "Commercial-Invoice" or $_GET['p'] == "Detail-PI-Manual" or $_GET['p'] == "Form-Invoice-Manual" or $_GET['p'] == "Commercial-Invoice-Manual" or $_GET['p'] == "Form-Detail-CI-Manual" or $_GET['p'] == "Form-Commercial-Manual" or $_GET['p'] == "Form-Tambah-Pengembalian" or $_GET['p'] == "PI-Detail-Manual") {
                                echo "active";
                              } ?>">
            <a href="#"><i class="fa fa-cubes text-primary"></i> <span>Data Export</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="<?php if ($_GET['p'] == "Proforma-Invoice-Manual" or $_GET['p'] == "Form-Invoice-Manual" or $_GET['p'] == "Detail-PI-Manual") {
                            echo "active";
                          } ?>"><a href="?p=Proforma-Invoice-Manual"><i class="fa fa-calendar text-warning"></i> <span>Proforma Invoice</span></a>
              </li>
              <li class="<?php if ($_GET['p'] == "PI-Detail-Manual") {
                            echo "active";
                          } ?>"><a href="?p=PI-Detail-Manual"><i class="fa fa-calendar text-success"></i> <span>Detail PI</span></a></li>
              <!-- <li class="<?php if ($_GET['p'] == "Commercial-Invoice-Manual" or $_GET['p'] == "Form-Detail-CI-Manual" or $_GET['p'] == "Form-Commercial-Manual" or $_GET['p'] == "Form-Tambah-Pengembalian") {
                            echo "active";
                          } ?>"><a href="?p=Commercial-Invoice-Manual"><i class="fa fa-calendar text-danger"></i> <span>Manual CI</span></a>
              </li>
              <li class="<?php if ($_GET['p'] == "Commercial-Invoice" or $_GET['p'] == "Form-Detail-CI" or $_GET['p'] == "Form-Commercial") {
                            echo "active";
                          } ?>"><a href="?p=Commercial-Invoice"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                  <span>Commercial Invoice</span></a>
              </li> -->
            </ul>
          </li>
          <!-- <li class="treeview <?php if ($_GET['p'] == "PEB-Kite" or $_GET['p'] == "Detail-CI-KITE" or $_GET['p'] == "Konversi" or $_GET['p'] == "Data-BCLKT") {
                                echo "active";
                              } ?>">
            <a href="#"><i class="fa fa-cubes text-danger"></i> <span>Data KITE</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="<?php if ($_GET['p'] == "PEB-Kite" or $_GET['p'] == "Detail-CI-KITE") {
                            echo "active";
                          } ?>"><a href="?p=PEB-Kite"><i class="fa fa-calendar text-info"></i> <span>PEB Kite</span></a></li>
              <li class="<?php if ($_GET['p'] == "Data-BCLKT") {
                            echo "active";
                          } ?>"><a href="?p=Data-BCLKT"><i class="fa fa-calendar text-success"></i> <span>Data BCLKT</span></a></li>
              <li class="<?php if ($_GET['p'] == "Konversi") {
                            echo "active";
                          } ?>"><a href="?p=Konversi"><i class="fa fa-calendar text-yellow"></i> <span>Konversi</span></a></li>
            </ul>
          </li> -->
          <!-- <li class="treeview <?php if ($_GET['p'] == "Data-Packing" or $_GET['p'] == "Data-Packing-NOW" or $_GET['p'] == "Data-Pas-Qty" or $_GET['p'] == "Cek-Order" or $_GET['p'] == "Import-Konversi" or $_GET['p'] == "Cek-NoKO") {
                                echo "active";
                              } ?>">
            <a href="#"><i class="fa fa-edit text-warning"></i> <span>Utility</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="<?php if ($_GET['p'] == "Data-Packing") {
                            echo "active";
                          } ?>"><a href="?p=Data-Packing"><i class="fa fa-columns text-blue"></i> <span>Data Packing</span></a></li>
			        <li class="<?php if ($_GET['p'] == "Data-Packing-NOW") {
                            echo "active";
                          } ?>"><a href="?p=Data-Packing-NOW"><i class="fa fa-columns text-green"></i> <span>Data Packing (NOW)</span></a></li>	
              <li class="<?php if ($_GET['p'] == "Data-Pas-Qty") {
                            echo "active";
                          } ?>"><a href="?p=Data-Pas-Qty"><i class="fa fa-columns text-red"></i> <span>Data Pas Qty</span></a></li>
              <li class="<?php if ($_GET['p'] == "Cek-Order") {
                            echo "active";
                          } ?>"><a href="?p=Cek-Order"><i class="fa fa-columns text-yellow"></i> <span>Cek-Order</span></a></li>
              <li class="<?php if ($_GET['p'] == "Cek-NoKO") {
                            echo "active";
                          } ?>"><a href="?p=Cek-NoKO"><i class="fa fa-columns text-black"></i> <span>Cek-NoKO</span></a></li>
              <li class="<?php if ($_GET['p'] == "Import-Konversi") {
                            echo "active";
                          } ?>"><a href="?p=Import-Konversi"><i class="fa fa-columns text-green"></i> <span>Import-Konversi</span></a></li>
            </ul>
          </li> -->
          <!-- <li class="treeview <?php if ($_GET['p'] == "Lap-PI-Manual" or $_GET['p'] == "Lap-CI-Manual") {
                                echo "active";
                              } ?>">
            <a href="#"><i class="fa fa-line-chart text-primary"></i> <span>Report</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="<?php if ($_GET['p'] == "Lap-PI-Manual") {
                            echo "active";
                          } ?>"><a href="?p=Lap-PI-Manual"><i class="fa fa-calendar text-warning"></i> <span>Lap-PI-Manual</span></a></li>
              <li class="<?php if ($_GET['p'] == "Lap-CI-Manual") {
                            echo "active";
                          } ?>"><a href="?p=Lap-CI-Manual"><i class="fa fa-line-chart text-danger"></i> <span>Lap-CI-Manual</span></a></li>
            </ul>
          </li> -->
		      <?php } ?>	
          <li class="treeview <?php if ($_GET['p'] == "Buyer" or $_GET['p'] == "Forwarder" or $_GET['p'] == "HS-Code" or $_GET['p'] == "User") {
                                echo "active";
                              } ?>">
            <a href="#"><i class="fa fa-edit text-purple"></i> <span>Master</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
			        <!-- <?php if(strtolower($_SESSION['usernmEX'])!="mkt") { ?>	
              <li class="<?php if ($_GET['p'] == "Buyer") {
                            echo "active";
                          } ?>"><a href="?p=Buyer"><i class="fa fa-columns text-blue"></i> <span>Buyer</span></a></li>
              <li class="<?php if ($_GET['p'] == "Forwarder") {
                            echo "active";
                          } ?>"><a href="?p=Forwarder"><i class="fa fa-columns text-red"></i> <span>Forwarder</span></a></li>
			        <?php } ?>	 -->
              <li class="<?php if ($_GET['p'] == "HS-Code") {
                            echo "active";
                          } ?>"><a href="?p=HS-Code"><i class="fa fa-columns text-green"></i> <span>HS-Code</span></a></li>
              <!-- <?php if ($_SESSION['levelEX'] == "SPV" or $_SESSION['levelEX'] == "Manager") { ?>
                <li class="<?php if ($_GET['p'] == "User") {
                              echo "active";
                            } ?>"><a href="?p=User"><i class="fa fa-columns text-yellow"></i> <span>User</span></a></li>
              <?php } ?> -->
            </ul>
          </li>

        </ul>
        <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->


      <!-- Main content -->
      <section class="content container-fluid">
        <?php
        if (!empty($page) and !empty($act)) {
          $files = 'pages/' . $page . '.' . $act . '.php';
        } elseif (!empty($page)) {
          $files = 'pages/' . $page . '.php';
        } else {
          $files = 'pages/home.php';
        }

        if (file_exists($files)) {
          include_once($files);
        } else {
          include_once("blank.php");
        }
        ?>

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="pull-right hidden-xs">
        DIT
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2019 <a href="#">Indo Taichen Textile Industry</a>.</strong> All rights reserved.
    </footer>
    
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED JS SCRIPTS -->
  <!-- Select2 -->
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
  <script src="bower_components/toastr/toastr.js"></script>
  <!-- DataTables -->
  <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <!-- start - This is for export functionality only -->
  <script src="bower_components/datatables.net-bs/js/dataTables.buttons.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/buttons.flash.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/jszip.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/pdfmake.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/vfs_fonts.js"></script>
  <script src="bower_components/datatables.net-bs/js/buttons.html5.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/buttons.print.min.js"></script>
  <!-- end - This is for export functionality only -->
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap time picker -->
  <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
  <script src="bower_components/toast-master/js/jquery.toast.js"></script>
  <script src="bower_components/jquery_validation/jquery.validate.min.js"></script>
  <script>
    //Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
      }),
      $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
      }),
      //Date picker
      $('#datepicker1').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
      }),
      //Date picker
      $('#datepicker2').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
      }),
      //Date picker
      $('#datepicker3').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight: true,
      });
    //Date picker
    $('#datepicker4').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight: true,
    });
    //Date picker
    $('#datepicker5').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight: true,
    });
    //Timepicker
    $('#timepicker').timepicker({
      showInputs: false
    })
  </script>
  <script>
    $(function() {

      $('#example1').DataTable({
        'scrollX': true,
        'paging': true,

      })
      $('#example2').DataTable()
      $('#example3').DataTable({
        'scrollX': true,
        dom: 'Bfrtip',
        buttons: [
          'excel',
          {
            orientation: 'portrait',
            pageSize: 'LEGAL',
            extend: 'pdf',
            footer: true,
          },
        ]
      })
      $('#example4').DataTable({
        'paging': false,
      })
      $('#example5').DataTable({
        'scrollX': true,
        'paging': false,
        dom: 'Bfrtip',
        buttons: [
          'excel',
          {
            orientation: 'portrait',
            pageSize: 'LEGAL',
            extend: 'pdf',
            footer: true,
          },
        ]
      })
      $('#tblr1').DataTable()
      $('#tblr2').DataTable()
      $('#tblr3').DataTable()
      $('#tblr4').DataTable()
      $('#tblr5').DataTable()
      $('#tblr6').DataTable()
      $('#tblr7').DataTable()
      $('#tblr8').DataTable()
      $('#tblr9').DataTable()
      $('#tblr10').DataTable()
      $('#tblr11').DataTable()
      $('#tblr12').DataTable()
      $('#tblr13').DataTable()
      $('#tblr14').DataTable()
      $('#tblr15').DataTable()
      $('#tblr16').DataTable()
      $('#tblr17').DataTable()
      $('#tblr18').DataTable()
      $('#tblr19').DataTable()
      $('#tblr20').DataTable()

    })
  </script>
  <!-- Javascript untuk popup modal Edit-->
  <script type="text/javascript">
    $(document).ready(function() {

    });
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()
    });
  </script>
  <script type="text/javascript">
    //            jika dipilih, PO akan masuk ke input dan modal di tutup
    $(document).on('click', '.pilih', function(e) {
      document.getElementById("no_po").value = $(this).attr('data-po');
      document.getElementById("no_po").focus();
      $('#myModal').modal('hide');
    });
    //            jika dipilih, BON akan masuk ke input dan modal di tutup
    $(document).on('click', '.pilih-bon', function(e) {
      document.getElementById("no_bon").value = $(this).attr('data-bon');
      document.getElementById("no_bon").focus();
      $('#myModal').modal('hide');
    });
    // jika dipilih, Kode Benang akan masuk ke input dan modal di tutup
    $(document).on('click', '.pilih-kd', function(e) {
      document.getElementById("kd").value = $(this).attr('data-kd');
      document.getElementById("kd").focus();
      $('#myModal').modal('hide');
    });
    $(document).on('click', '.dci_edit', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "pages/dci_edit.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#DetailCIEdit").html(ajaxData);
          $("#DetailCIEdit").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.cimkite_edit', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "pages/cimkite_edit.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#CIMKiteEdit").html(ajaxData);
          $("#CIMKiteEdit").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.edit_status', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "pages/status_edit.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#EditStatus").html(ajaxData);
          $("#EditStatus").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.edit_status1', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "pages/status_edit1.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#EditStatus1").html(ajaxData);
          $("#EditStatus1").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.detail_pi', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "pages/detail_pi.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#DetailPI").html(ajaxData);
          $("#DetailPI").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.detail_order', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "pages/detail_order.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#DetailCekOrder").html(ajaxData);
          $("#DetailCekOrder").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.user_edit', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "pages/user_edit.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#UserEdit").html(ajaxData);
          $("#UserEdit").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.hs_edit', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "pages/hs_edit.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#HSEdit").html(ajaxData);
          $("#HSEdit").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.buyer_edit', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "pages/buyer_edit.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#BuyerEdit").html(ajaxData);
          $("#BuyerEdit").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.forwarder_edit', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "pages/forwarder_edit.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#ForwarderEdit").html(ajaxData);
          $("#ForwarderEdit").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.detail_datapi', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "pages/detail_datapi.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#DetailDataPI").html(ajaxData);
          $("#DetailDataPI").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.detail_ci', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "pages/detail_ci.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#DetailCI").html(ajaxData);
          $("#DetailCI").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    $(document).on('click', '.detail_ci_bclkt', function(e) {
      var m = $(this).attr("id");
      $.ajax({
        url: "pages/detail_ci_bclkt.php",
        type: "GET",
        data: {
          id: m,
        },
        success: function(ajaxData) {
          $("#DetailCIBCLKT").html(ajaxData);
          $("#DetailCIBCLKT").modal('show', {
            backdrop: 'true'
          });
        }
      });
    });
    //            tabel lookup KO status terima
    $(function() {
      $("#lookup").dataTable();
    });
    $(function() {
      $("#lookup1").dataTable();
    });
    $(function() {
      $("#lookup2").dataTable();
    });
  </script>
  <script type="text/javascript">
    function bukaInfo() {
      $('#myModal').modal('show');
    }
  </script>

</body>

</html>