<?php
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$modal=mysql_query("SELECT * FROM `tbl_exim_cim_detail` WHERE id='$modal_id' ");
while($r=mysql_fetch_array($modal)){
?>
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_dci" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah BCKLT NO</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r[id];?>">
                  <div class="form-group">
                  <label for="urut" class="col-md-3 control-label">No Urut PEB</label>
                  <div class="col-md-5">
                  <input type="text" class="form-control" id="urut" name="urut" value="<?php echo $r['no_urut_peb']; ?>">
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
				  <div class="form-group">
                  <label for="bcklt" class="col-md-3 control-label">BCKLT No</label>
                  <div class="col-md-5">
                  <input type="text" class="form-control" id="bcklt" name="bcklt" value="<?php echo $r['no_bclkt']; ?>">
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
