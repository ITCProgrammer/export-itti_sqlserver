<?php
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$modal=sqlsrv_query($con,"SELECT * FROM `tbl_exim_buyer` WHERE id='$modal_id' ");
while($r=sqlsrv_fetch_array($modal)){
?>
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_buyer" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Buyer</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r['id'];?>">
                  <div class="form-group">
                  <label for="nama" class="col-md-3 control-label">Nama</label>
                  <div class="col-md-6">
                  <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $r['nama'];?>" required>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
				  <div class="form-group">
                  <label for="alamat" class="col-md-3 control-label">Alamat</label>
                  <div class="col-md-6">
                  <textarea class="form-control" name="alamat" id="alamat"><?php echo $r['alamat'];?></textarea>
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
				  <div class="form-group">
                  <label for="negara" class="col-md-3 control-label">Negara</label>
                  <div class="col-md-5">
                  <input type="text" class="form-control" id="negara" name="negara" value="<?php echo $r['negara'];?>" required>
                  <span class="help-block with-errors"></span>
                  </div>
                </div>
				<div class="form-group">
                  <label for="negara" class="col-md-3 control-label">Kode</label>
                  <div class="col-md-3">
                  <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $r['kode'];?>" required>
                  <span class="help-block with-errors"></span>
                  </div>
                </div>  
                <div class="form-group">
                  <label for="alamat" class="col-md-3 control-label">Keterangan</label>
                  <div class="col-md-6">
                  <textarea class="form-control" name="ket" id="ket"><?php echo $r['keterangan'];?></textarea>
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
