<?php
include("../koneksi.php");

?>
<div class="modal-dialog modal-lg" style="width: 90%">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Detail CI </h4>
    </div>
    <div class="modal-body">
	<table id="tbl2" class="table table-bordered table-hover table-striped" width="100%">
					<thead class="bg-green">
						<tr>
							<th width="749">
								<div align="center">NO INVOICE</div>
							</th>
							<th width="206"><div align="center">KG</div></th>
							<th width="134"><div align="center">PANJANG</div></th>
							<th width="104"><div align="center">SATUAN</div></th>
							<th width="104">
								<div align="center">PCS</div>
							</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$qry3=mysqli_query($con,"SELECT *,b.no_invoice FROM tbl_exim_pim_detail a 
LEFT JOIN tbl_exim_cim_detail b ON a.id=b.id_pimd
WHERE a.id='".$_GET['id']."' ORDER BY a.id ASC");	
							
					while($r=mysqli_fetch_array($qry3)){
					
					?>
						<tr>
							<td align="center"><?php echo $r['no_invoice']; ?></td>
							<td><div align="right"><?php echo $r['kg']; ?></div></td>
							<td><div align="right"><?php echo $r['panjang']; ?></div></td>
							<td align="center"><?php echo $r['satuan']; ?></td>
							<td><div align="right"><?php echo $r['pcs']; ?></div></td>
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
