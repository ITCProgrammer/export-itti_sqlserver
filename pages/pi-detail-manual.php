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
					$qry3=mysqli_query($con,"SELECT a.*,b.no_pi,b.bon_order FROM tbl_exim_pim_detail a 
					INNER JOIN tbl_exim_pim b ON a.id_pi=b.id 
				    WHERE a.`status`='On Going' ORDER BY a.status ASC");	
					$no=1;
					$col=0;	
					while($r=mysqli_fetch_array($qry3)){
						$bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
					$qryD=mysqli_query($con,"SELECT kg,panjang,pcs,satuan FROM tbl_exim_cim_detail WHERE id_pimd='".$r['id']."'");
					$rD=mysqli_fetch_array($qryD);
						
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
							<td><div align="right"><?php echo $r['price']; ?></div></td>
							<td><div align="center"><span class="label <?php if($r['per']=="yd") {echo" label-primary";}else if($r['per']=="kg"){ echo "label-warning";}else{ echo "label-info"; } ?>"><?php echo $r['per']; ?></span></div></td>
							<td><div align="right"><a href="#" class="detail_datapi" id="<?php echo $r['id']; ?>"><?php if(round($r['kg']-$rD['kg'],2)>0){
								echo round($r['kg'],2)."<br>(".round($r['kg']-$rD['kg'],2).")";}
						    else if(round($r['kg']-$rD['kg'],2)<=0 and $r['per']=="kg"){
								echo round($r['kg'],2)."<br><span class='label label-warning'>".round($r['kg']-$rD['kg'],2)."</span>";}
						    else{
								echo round($r['kg'],2)."<br>(".round($r['kg']-$rD['kg'],2).")";} ?></a></div></td>
							<td><div align="right"><?php 
						if(round($r['yd']-$rD['panjang'],2)>0){
							echo round($r['yd'],2)."<br><font color=green>(".round($r['yd']-$rD['panjang'],2).")</font>";}
						else if(round($r['yd']-$rD['panjang'],2)<=0 and $r['per']=="yd"){
							echo round($r['yd'],2)."<br><span class='label label-primary'>".round($r['yd']-$rD['panjang'],2)."</span>";}
						else{ echo round($r['yd'],2)."<br>(".round($r['yd']-$rD['panjang'],2).")";} 
							?></div></td>							
							<td><div align="right"><?php echo round($r['pcs'],2)."<br><font color=red>(".round($r['pcs']-$rD['pcs'],2).")</font>"; ?></div></td>
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

