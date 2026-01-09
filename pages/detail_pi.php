<?php
include("../koneksi.php");

?>
<div class="modal-dialog modal-lg" style="width: 90%">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">Detail PI </h4>
    </div>
    <div class="modal-body">
	<table id="tbl3" class="table table-bordered table-hover table-striped" width="100%">
					<thead class="bg-green">
						<tr>
						  <th width="93">Status</th>
							<th width="157">
								<div align="center">PI</div>
							</th>
							<th width="110">
								<div align="center">Order</div>
							</th>
							<th width="127">
								<div align="center">
									<div align="center">PO</div>
							</th>
							<th width="104">
								<div align="center">Item</div>
							</th>
							<th width="139">
								<div align="center">Color</div>
							</th>
							<th width="101">
								<div align="center">Size</div>
							</th>
							<th width="92">
								<div align="center">HS Code</div>
							</th>
							<th width="52">
								<div align="center">USD</div>
							</th>
							<th width="51"><div align="center">Per</div></th>
							<th width="55"><div align="center">KG</div></th>
							<th width="35"><div align="center">YD</div></th>
							<th width="41">
								<div align="center">PCS</div>
							</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$qry3=mysql_query("SELECT a.*,b.no_pi,b.bon_order FROM tbl_exim_pim_detail a 
					INNER JOIN tbl_exim_pim b ON a.id_pi=b.id 
					WHERE a.id_pi='$_GET[id]' ORDER BY a.id ASC");	
							
					while($r=mysql_fetch_array($qry3)){
					$qryD=mysql_query("SELECT kg,panjang,pcs,satuan FROM tbl_exim_cim_detail WHERE id_pimd='$r[id]'");
					$rD=mysql_fetch_array($qryD);
						
					?>
						<tr>
						  <td align="center"><a href="#" class="edit_status" id="<?php echo $r['id']; ?>"><?php echo $r[status]; ?></a></td>
							<td align="center"><?php echo $r[no_pi]; ?></td>
							<td align="center"><?php echo $r[bon_order]; ?></td>
							<td><div align="center"><?php echo $r[po]; ?></div></td>
							<td><div align="center"><?php echo $r[item]; ?></div></td>
							<td><div align="center"><?php echo $r[color]; ?></div></td>
							<td><div align="center"><?php echo $r[size]; ?></div></td>
							<td><div align="center"><?php echo $r[hs_code]; ?></div></td>
							<td><div align="right"><?php echo $r[price]; ?></div></td>
							<td><div align="center"><span class="label <?php if($r[per]=="yd") {echo" label-primary";}else if($r[per]=="kg"){ echo "label-warning";} ?>"><?php echo $r[per]; ?></span></div></td>
							<td><div align="right"><?php echo round($r[kg],2)." (".round($r[kg]-$rD[kg],2).")"; ?></div></td>
							<td><div align="right"><?php echo round($r[yd],2)." (".round($r[yd]-$rD[panjang],2).")"; ?></div></td>
							<td><div align="right"><?php echo round($r[pcs],2)." (".round($r[pcs]-$rD[pcs],2).")"; ?></div></td>
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
    $("#tbl3").dataTable();
  });

</script>
