<?php
include("../koneksi.php");
$dt=$_GET['id'];
$pos1=strpos($dt,"item:");
$pos2=strpos($dt,"warna:");
$item=trim(substr($dt,$pos1+5,500));
$positem=strpos($item,"warna:");
$item2=trim(substr($item,0,$positem));
$order=trim(substr($dt,0,$pos1));
$warna=trim(substr($item,$positem+6,400));
$poswarna=strpos($warna,"po:");
$warna2=trim(substr($warna,0,$poswarna));
$po=trim(substr($warna,$poswarna+3,500));
?>
<div class="modal-dialog modal-lg" style="width: 90%">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel"><strong>Detail Kartu Kerja</strong><br>
      Order: <?php echo $order?><br>PO: <?php echo $po;?><br>Item: <?php echo $item2;?><br>Color: <?php echo $warna2;?></h4>
    </div>
    <div class="modal-body">
	<table id="tbl3" class="table table-bordered table-hover table-striped" width="100%">
					<thead class="bg-green">
						<tr>
						  <th width="442"><div align="center">NOKK</div></th>
						  <th width="442">
							  <div align="center">WH</div>
							</th>
							<th width="131">
								<div align="center">LOT</div>
							</th>
							<th width="144"><div align="center">KG</div></th>
							<th width="174"><div align="center">YD</div></th>
							<th width="129">
								<div align="center">PCS</div>
							</th>
							<th width="118"><div align="center">FOC</div></th>
							<th width="43"> <div align="center">PACK</div>
						  </th>
						</tr>
					</thead>
					<tbody>
					<?php 
	$datasum=sqlsrv_query($con,"SELECT
	tbl_kite.no_lot,
	tbl_kite.nokk,
	sum(if( not detail_pergerakan_stok.sisa='FOC',detail_pergerakan_stok.weight,0)) as kgs,
	sum(if( not detail_pergerakan_stok.sisa='FOC',detail_pergerakan_stok.yard_,0)) as yds,
	sum(tmp_detail_kite.netto)as pcs,
	detail_pergerakan_stok.pack,
	count(detail_pergerakan_stok.weight) as jml_pack,
	sum(if(detail_pergerakan_stok.sisa='FOC',detail_pergerakan_stok.weight,0)) as foc
FROM
	pergerakan_stok
INNER JOIN detail_pergerakan_stok ON pergerakan_stok.id = detail_pergerakan_stok.id_stok
INNER JOIN tmp_detail_kite ON tmp_detail_kite.id = detail_pergerakan_stok.id_detail_kj
INNER JOIN tbl_kite ON tbl_kite.id = tmp_detail_kite.id_kite
WHERE
	(detail_pergerakan_stok.sisa !='FKTH' AND detail_pergerakan_stok.sisa !='TH' AND detail_pergerakan_stok.sisa !='SISA' AND typestatus='1'
AND `tbl_kite`.`no_order`='".$order."'
 ) AND `tbl_kite`.`no_item`='$item2' 
 AND `tbl_kite`.`warna`='$warna2' AND `tbl_kite`.`no_po`='$po' GROUP BY tbl_kite.no_lot,detail_pergerakan_stok.nokk  
 ORDER BY `pergerakan_stok`.`typestatus`,
	`detail_pergerakan_stok`.`nokk`,
	`detail_pergerakan_stok`.`no_roll` ASC");	
							
					while($r=sqlsrv_fetch_array($datasum)){		
						$mySql =sqlsrv_query($con,"select GROUP_CONCAT(distinct lokasi) as tempat from db_qc.detail_pergerakan_stok where `status`='1' and nokk='".$r['nokk']."'");
	   $myBlk = sqlsrv_fetch_array($mySql);
					?>
						<tr>
						  <td align="center"><?php echo $r['nokk'];?></td>
						  <td align="center"><?php echo $myBlk['tempat']; ?></td>
							<td align="center"><?php echo $r['no_lot'];?></td>
							<td align="right"><?php if($r['kgs']>0){echo $r['kgs'];}else{echo "-";}?></td>
							<td align="right"><?php if($r['yds']>0){echo $r['yds'];}else{echo "-";}?></td>
							<td align="right"><?php if($r['pcs']>0){echo $r['pcs'];}else{echo "-";}?></td>
							<td align="right"><?php if($r['foc']>0){echo $r['foc'];}else{echo "-";}?></td>
							<td align="center"><?php echo $r['jml_pack'];?></td>
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
