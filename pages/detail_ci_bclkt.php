<?php
include("../koneksi.php");

?>
<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Detail CI </h4>
    </div>
    <div class="modal-body">
	<table id="tbl22" class="table table-bordered table-hover table-striped" width="100%">
					<thead class="bg-green">
						<tr>
							<th width="749">
								<div align="center">NO INVOICE</div>
							</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$qry3=sqlsrv_query($con, "SELECT * FROM db_qc.tbl_exim_cim_detail a 
					WHERE a.no_bclkt='$_GET[id]' ORDER BY a.id ASC");	
							
					while($r=sqlsrv_fetch_array($qry3, SQLSRV_FETCH_ASSOC)){
					
					?>
						<tr>
							<td align="center"><?php echo $r['no_invoice']; ?></td>
						</tr>
						<?php
  } ?>
					</tbody>

				</table>  
	</div>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    $("#tbl2").dataTable();
  });

</script>
