<?php
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$modal=sqlsrv_query($con,"SELECT * FROM db_qc.tbl_exim_code WHERE id='$modal_id' ");
while($r=sqlsrv_fetch_array($modal)){
?>
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_hs" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit HS-CODE</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r['id'];?>">
                  <div class="form-group">
                  <label for="item" class="col-md-3 control-label">Item</label>
                  <div class="col-md-5">
                  <input type="text" class="form-control" id="item" name="item" value="<?php echo $r['no_item']; ?>" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label for="sts" class="col-md-3 control-label">Status Pengajuan</label>
                  <div class="col-md-3">
                  <select name="sts" class="form-control" id="sts" required>
                  	<option value="BELUM" <?php if($r['sts']=="BELUM"){echo "SELECTED";}?>>BELUM</option>
                  	<option value="SUDAH" <?php if($r['sts']=="SUDAH"){echo "SELECTED";}?>>SUDAH</option>
                  </select>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>                  
                <div class="form-group">
                  <label for="ket" class="col-md-3 control-label">Keterangan</label>
                  <div class="col-md-6">
                  <textarea class="form-control" name="ket" id="ket"><?php echo $r['ket']; ?></textarea>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>			    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Save</button>
              </div>
            </form>
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
          <?php } ?>
