<?php
if ($_POST) {
    extract($_POST);
    $id = mysql_real_escape_string($_POST['id']);
    $line = mysql_real_escape_string($_POST['line_news']);
    $sqlupdate=mysql_query("UPDATE `tbl_news_line` SET
				`news_line`='$line',
				`tgl_update`=now()
				WHERE `id`='$id' LIMIT 1",$con);
    //echo " <script>window.location='?p=Line-News';</script>";
    echo "<script>swal({
  title: 'Data Tersimpan',
  text: 'Klik Ok untuk melanjutkan',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    window.location='?p=Line-News';
  }
});</script>";
}
