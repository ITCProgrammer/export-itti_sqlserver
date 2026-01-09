<?php
include("../koneksi.php");
    $modal_id=$_GET['id'];
	$modal=mysql_query("SELECT * FROM `tbl_exim_cim` WHERE id='$modal_id' ");
while($r=mysql_fetch_array($modal)){
?>
          <div class="modal-dialog ">
            <div class="modal-content">
            <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_cimkite" enctype="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah LHPRE NO</h4>
              </div>
              <div class="modal-body">
                  <input type="hidden" id="id" name="id" value="<?php echo $r[id];?>">
                  <div class="form-group">
                  <label for="no_lhpre" class="col-md-3 control-label">No LHPRE</label>
                  <div class="col-md-5">
                  <input type="text" class="form-control" id="no_lhpre" name="no_lhpre" value="<?php echo $r['no_lhpre']; ?>">
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
				  <div class="form-group">
                  <label for="tgl_lhpre" class="col-sm-3 control-label">Tgl LHPRE</label>			      
                  <div class="col-sm-4">					  
						  <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="tgl_lhpre" type="text" class="form-control pull-right" id="datepicker" placeholder="0000-00-00" value="<?php echo $r[tgl_lhpre];?>" autocomplete="off" />
          </div>
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
<script>
		//Date picker
        $('#datepicker').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          todayHighlight: true,
        });
</script>	
