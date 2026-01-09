<?php
include("../koneksi.php");
    $modal_id=$_GET['id'];
    $qrySts=mysql_query("SELECT * FROM tbl_exim_pim_detail
WHERE id='$modal_id'");
    $rSts=mysql_fetch_array($qrySts);
    ?>
<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <form class="form-horizontal" name="modal_popup" method="post" action="?p=edit_status1" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Status</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="status" class="col-sm-4 control-label">Status</label>
          <div class="col-sm-6">
            <select name="status" class="form-control">
				<option value="Closed" <?php if($rSts[status]=="Closed"){echo "SELECTED"; }?>>Closed</option>
				<option value="On Going" <?php if($rSts[status]=="On Going"){echo "SELECTED"; }?>>On Going</option>			
			</select>
          </div>
        </div>
        <input type="hidden" id="id" name="id" value="<?php echo $modal_id;?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="save" >Save</button>
      </div>
    </form>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<?php
if (isset($_POST[save])) {
    extract($_POST);
    $id = mysql_real_escape_string($_POST['id']);
    $sts = mysql_real_escape_string($_POST['status']);
    $sqlupdate=mysql_query("UPDATE `tbl_exim_pim_detail` SET
				`status`='$sts'
				WHERE `id`='$id' LIMIT 1");
    //echo " <script>window.location='?p=Proforma-Invoice-Manual';</script>";
	echo"<script>alert('tt');</script>";
}
?>
<script>
  //Date picker
  $('#datepicker').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    }),
    //Date picker
    $('#datepicker1').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    }),
    //Date picker
    $('#datepicker2').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    }),
    //Date picker
    $('#datepicker3').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    })

</script>
