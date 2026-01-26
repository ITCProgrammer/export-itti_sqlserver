<div class="row">
	<div class="col-xs-12">
		<div class="box table-responsive">
			<div class="box-header with-border">
			<font size="+2"class="box-title">Detail Proforma Invoice Manual</font>			
		  </div>
			<div class="box-body">			
			  	<table id="example2" class="table table-bordered table-hover table-striped" width="100%">
					<thead class="bg-green">
						<tr>
						  <th width="75">No</th>
						  <th width="96">Status</th>
							<th width="141">
								<div align="center">PI</div>
							</th>
							<th width="102">
								<div align="center">Order</div>
							</th>
							<th width="114">
								<div align="center">
									<div align="center">PO</div>
							</th>
							<th width="95">
								<div align="center">Item</div>
							</th>
							<th width="127">
								<div align="center">Color</div>
							</th>
							<th width="92">
								<div align="center">Size</div>
							</th>
							<th width="85">
								<div align="center">HS Code</div>
							</th>
							<th width="49">
								<div align="center">USD</div>
							</th>
							<th width="47"><div align="center">Per</div></th>
							<th width="51"><div align="center">KG</div></th>
							<th width="33"><div align="center">YD</div></th>
							<th width="46">
								<div align="center">PCS</div>
							</th>
						</tr>
					</thead>
					<tbody>
					<?php 
						$qry3=sqlsrv_query($con,"SELECT TOP 1000
							a.*, 
							b.no_pi, 
							b.bon_order 
						FROM db_qc.tbl_exim_pim_detail a 
						INNER JOIN db_qc.tbl_exim_pim b ON a.id_pi = b.id 
						WHERE a.[status] = 'On Going' 
						ORDER BY a.[status] ASC");
						if ($qry3 === false) {
							die(print_r(sqlsrv_errors(), true));
						}	
						$no=1;
						$col=0;	
						while($r=sqlsrv_fetch_array($qry3, SQLSRV_FETCH_ASSOC)){
							$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
						$qryD = sqlsrv_query($con,"SELECT kg,panjang,pcs,satuan FROM db_qc.tbl_exim_cim_detail WHERE id_pimd = ?", [$r['id']]);
						if ($qryD === false) {
							die(print_r(sqlsrv_errors(), true));
						}
						$rD = sqlsrv_fetch_array($qryD, SQLSRV_FETCH_ASSOC);
						
						$kgOut   = isset($rD['kg']) ? (float)$rD['kg'] : 0;
						$ydOut   = isset($rD['panjang']) ? (float)$rD['panjang'] : 0;
						$pcsOut  = isset($rD['pcs']) ? (float)$rD['pcs'] : 0;

						$kgPlan  = isset($r['kg']) ? (float)$r['kg'] : 0;
						$ydPlan  = isset($r['yd']) ? (float)$r['yd'] : 0;
						$pcsPlan = isset($r['pcs']) ? (float)$r['pcs'] : 0;
						
						?>
						<tr bgcolor="<?php echo $bgcolor; ?>">
						  <td align="center"><?php echo $no;?></td>
						  <td align="center"><a href="#" class="edit_status1" id="<?php echo $r['id']; ?>"><?php if($r['status']=="On Going"){echo "<span class='label label-success'>".$r['status']."</span>";}else{echo "<span class='label label-danger'>".$r['status']."</span>";} ?></a></td>
							<td align="center"><?php echo $r['no_pi']; ?></td>
							<td align="center"><?php echo $r['bon_order']; ?></td>
							<td><div align="center"><?php echo $r['po']; ?></div></td>
							<td><div align="center"><?php echo $r['item']; ?></div></td>
							<td><div align="center"><?php echo $r['color']; ?></div></td>
							<td><div align="center"><?php echo $r['size']; ?></div></td>
							<td><div align="center"><?php echo $r['hs_code']; ?></div></td>
							<td><div align="right"><?php echo number_format((float)$r['price'], 2, ',', '.'); ?></div></td>
							<td><div align="center"><span class="label <?php if($r['per']=="yd") {echo" label-primary";}else if($r['per']=="kg"){ echo "label-warning";}else{ echo "label-info"; } ?>"><?php echo $r['per']; ?></span></div></td>
							<td><div align="right"><a href="#" class="detail_datapi" id="<?php echo $r['id']; ?>"><?php 
								$kgBalance = round($kgPlan - $kgOut, 2);
								if($kgBalance > 0){
									echo number_format($kgPlan,2,',','.')."<br>(" . number_format($kgBalance,2,',','.') . ")";
								} else if($kgBalance <= 0 and $r['per']=="kg"){
									echo number_format($kgPlan,2,',','.')."<br><span class='label label-warning'>".number_format($kgBalance,2,',','.')."</span>";
								} else {
									echo number_format($kgPlan,2,',','.')."<br>(" . number_format($kgBalance,2,',','.') . ")";
								} ?></a></div></td>
							<td><div align="right"><?php 
						$ydBalance = round($ydPlan - $ydOut, 2);
						if($ydBalance>0){
							echo number_format($ydPlan,2,',','.')."<br><font color=green>(" . number_format($ydBalance,2,',','.') . ")</font>";
						}
						else if($ydBalance<=0 and $r['per']=="yd"){
							echo number_format($ydPlan,2,',','.')."<br><span class='label label-primary'>".number_format($ydBalance,2,',','.')."</span>";
						}
						else{ echo number_format($ydPlan,2,',','.')."<br>(" . number_format($ydBalance,2,',','.') . ")";} 
							?></div></td>							
							<td><div align="right"><?php 
								$pcsBalance = round($pcsPlan - $pcsOut, 2);
								echo number_format($pcsPlan,2,',','.')."<br><font color=red>(" . number_format($pcsBalance,2,',','.') . ")</font>"; ?></div></td>
						</tr>
						<?php
						$no++;
  } ?>
					</tbody>

				</table>		
			</div>
		</div>
	</div>
</div>
<div id="EditStatus1" class="modal fade modal-3d-slit" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div id="DetailDataPI" class="modal fade modal-3d-slit" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

