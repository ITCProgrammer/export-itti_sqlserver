<?php
session_start();
include"koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Batas Produksi</title>
  </head>

  <body>
    <?php 	$news=mysql_query("SELECT * FROM tbl_news_line",$con); ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">

          </div>
          <div class="box-body">
            <table width="100%" id="example2" class="table table-bordered table-hover table-striped">
              <thead class="btn-danger">
                <tr>
                  <th width="2%">No</th>
                  <th width="6%">Gedung</th>
                  <th width="79%">Line News</th>
                  <th width="9%">Tgl Update</th>
                  <th width="4%">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
  $col=0;
  $no=1;
  while ($rNews=mysql_fetch_array($news)) {
      $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite'; ?>
                <tr align="center" bgcolor="<?php echo $bgcolor; ?>">
                  <td align="center">
                    <?php echo $no; ?>
                  </td>
                  <td align="center">
                    <?php echo $rNews['gedung']; ?>
                  </td>
                  <td align="left">
                    <?php echo $rNews['news_line']; ?>
                  </td>
                  <td align="center">
                    <?php echo $rNews['tgl_update']; ?>
                  </td>
                  <td align="center"><a href="#" id='<?php echo $rNews['id'] ?>' class="btn-sm btn-info news_edit"><i class="fa fa-edit"></i> </a></th>
                </tr>
                <?php
  $no++;
  } ?>
              </tbody>
              <tfoot class="btn-danger">
                <tr>
                  <th width="2%">No</th>
                  <th width="6%">Gedung</th>
                  <th width="79%">Line News</th>
                  <th width="9%">Tgl Update</th>
                  <th width="4%">Action</th>
                </tr>
              </tfoot>
            </table>
            <div id="NewsEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

            </div>
  </body>

</html>
