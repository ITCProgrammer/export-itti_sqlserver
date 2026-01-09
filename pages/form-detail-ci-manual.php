<?php
$qry = sqlsrv_query($conn,"SELECT TOP 1 a.ID,CAST(d.[PONumber] AS VARCHAR(8000)) AS PONumber,
CAST(a.[SalesPersonName] AS VARCHAR(8000)) AS SalesPerson,
CAST(e.[PartnerName] AS VARCHAR(8000)) AS Buyer,
CAST(j.[PartnerName] AS VARCHAR(8000)) AS Consignee,
CAST(j.[Address] AS VARCHAR(8000)) AS Consignee_adr,
CAST(j.[PhoneNumber] AS VARCHAR(8000)) As Consignee_phone,
CAST(m.[CountryName] AS VARCHAR(8000)) AS Consignee_c, 
CAST(k.[CountryName] AS VARCHAR(8000)) AS Destination,
CAST(f.[PartnerName] AS VARCHAR(8000)) AS Messr,
CAST(f.[Address] AS VARCHAR(8000)) AS Messr_adr,
CAST(f.[PhoneNumber] AS VARCHAR(8000)) AS Messr_phone,
CAST(l.[CountryName] AS VARCHAR(8000)) AS Messr_c,  
CAST(c.[Documentno] AS VARCHAR(8000)) AS OrderNO,
CAST(h.[Description] AS VARCHAR(8000)) AS Payment,
CAST(g.[Description] AS VARCHAR(8000)) AS Term,
CONVERT(varchar(10), i.[DeliveryDate], 121) AS TglDelivery
FROM SalesOrders a 
INNER JOIN SODetails b ON a.ID=b.SOID
INNER JOIN sodetailsadditional d ON d.sodid=b.id
INNER JOIN JobOrders c ON a.ID=c.SOID
INNER JOIN Partners e ON a.BuyerID=e.ID
INNER JOIN Partners f ON a.CustomerID=f.ID
INNER JOIN Incoterms g ON a.IncotermID=g.ID
INNER JOIN PaymentTerms h ON a.PaymentTermID=h.ID
INNER JOIN SODelivery i ON a.ID=i.SOID
INNER JOIN Partners j ON i.ConsigneeID=j.ID
INNER JOIN Countries k ON i.CountryID=k.ID
INNER JOIN Countries l ON f.CountryID=l.ID
INNER JOIN Countries m ON j.CountryID=m.ID
WHERE a.SONumber='".$_GET['pi']."'");
$data = sqlsrv_fetch_array($qry,SQLSRV_FETCH_ASSOC);
$sqlInv = mysqli_query($con,"SELECT * FROM tbl_exim_cim WHERE id='".$_GET['id']."' LIMIT 1");
$dInv = mysqli_fetch_array($sqlInv);
?>
<div class="box box-info collapsed-box">
	<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
		<div class="box-header with-border">
			<h3 class="box-title">Form Detail CI Manual</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div class="form-group">
				<label for="no_inv" class="col-sm-2 control-label">No Invoice</label>
				<div class="col-sm-2">
					<input name="no_inv" type="text" class="form-control" id="no_inv" value="<?php echo $dInv['no_invoice']; ?>" placeholder="No Invoice" readonly>
				</div>
			</div>
			<div class="form-group">
				<label for="no_pi" class="col-sm-2 control-label">No PI</label>
				<div class="col-sm-2">
					<input name="no_pi" type="text" class="form-control" id="no_pi" onchange="window.location='?p=Form-Detail-CI-Manual&amp;id=<?php echo $_GET['id']; ?>&amp;pi='+this.value" value="<?php echo strtoupper($_GET['pi']); ?>" placeholder="No Pi">
				</div>
			</div>
			<div class="form-group">
				<label for="detail_pi" class="col-sm-2 control-label">Detail PI</label>
				<div class="col-sm-6">
					<select name="detail_pi" class="form-control select2" onchange="window.location='?p=Form-Detail-CI-Manual&amp;id=<?php echo $_GET['id']; ?>&amp;pi=<?php echo $_GET['pi']; ?>&amp;pid='+this.value" required>
						<option value="">Pilih</option>
						<?php
						$qrycon = mysqli_query($con,"SELECT
	a.id,
	a.po,
	a.item,
	a.color,
	a.kg,
	a.yd,
	a.pcs 
FROM
	tbl_exim_pim_detail a
	INNER JOIN
	tbl_exim_pim b ON b.id=a.id_pi
WHERE
	b.no_pi='".$_GET['pi']."' ORDER BY a.id ASC");
						while ($rcon = mysqli_fetch_array($qrycon)) {
						?>
							<option value="<?php echo $rcon['id']; ?>" <?php if ($rcon['id'] == $_GET['pid']) {
																			echo "SELECTED";
																		} ?>><?php echo strtoupper($rcon['po']); ?> | <?php echo strtoupper($rcon['item']); ?> | <?php echo strtoupper($rcon['color']); ?> | <?php echo $rcon['kg']; ?> | <?php echo $rcon['yd']; ?> | <?php echo $rcon['pcs']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="berat" class="col-sm-2 control-label">Berat</label>
				<div class="col-sm-2">
					<div class="input-group">
						<input name="berat" type="text" class="form-control" id="berat" value="" placeholder="0.00" style="text-align: right;" autocomplete="off">
						<span class="input-group-addon">KGs</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="panjang" class="col-sm-2 control-label">Panjang</label>
				<div class="col-sm-2">
					<div class="input-group">
						<input name="panjang" type="text" class="form-control" id="panjang" value="" placeholder="0.00" style="text-align: right;" autocomplete="off">
						<span class="input-group-addon">
							<select name="satuan" style="font-size: 12px;">
								<option value="Yard">Yard</option>
								<option value="Meter">Meter</option>
							</select>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="pcs" class="col-sm-2 control-label">PCS</label>
				<div class="col-sm-1">
					<input name="pcs" type="text" class="form-control" id="pcs" value="" placeholder="0" style="text-align: right;" autocomplete="off">
				</div>

			</div>
		</div>
		<div class="box-footer">

			<div class="col-sm-2">
				<button type="submit" class="btn btn-block btn-social btn-linkedin" name="save" style="width: 80%">Simpan <i class="fa fa-save"></i></button>
			</div>

			<button type="button" class="btn btn-default pull-right" name="save" Onclick="window.location='?p=Commercial-Invoice-Manual'">Kembali <i class="fa fa-cycle"></i></button>
		</div>
		<!-- /.box-footer -->


	</form>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="box table-responsive">
			<div class="box-header with-border">
				<div class="container-fluid pull-right">
					<a href="javascript:void(0)" title="[Cetak Invoice]" class="btn btn-danger btn-sm cetak_ci" id="<?php echo $rowd['listno']; ?>"><i class="fa fa-print"></i> <strong> Commercial Invoice</strong></a>
				</div>
			</div>
			<div class="box-body">
				<?php $qry3 = mysqli_query($con,"SELECT c.po,c.item,c.color,a.no_pi,b.no_invoice,a.kg,a.panjang,a.satuan,a.pcs,a.id FROM tbl_exim_cim_detail a 
											INNER JOIN tbl_exim_cim b ON b.id=a.id_cim
											LEFT JOIN tbl_exim_pim_detail c ON a.id_pimd=c.id
											WHERE a.id_cim='".$_GET['id']."' ORDER BY a.id ASC"); ?>
				<table id="example2" class="table table-bordered table-hover table-striped" width="100%">
					<thead class="bg-green">
						<tr>
							<th width="108">
								<div align="center">No.</div>
							</th>
							<th width="237">
								<div align="center">PI</div>
							</th>
							<th width="228">
								<div align="center">
									<div align="center">PO</div>
							</th>
							<th width="182">
								<div align="center">Item</div>
							</th>
							<th width="205">
								<div align="center">Color</div>
							</th>
							<th width="67">
								<div align="center">KG</div>
							</th>
							<th width="58">
								<div align="center">YDs</div>
							</th>
							<th width="75">
								<div align="center">PCS</div>
							</th>
							<th width="81">
								<div align="center">PENGEMBALIAN</div>
							</th>
							<th width="81">
								<div align="center">Status</div>
							</th>
							<th width="81">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$c = 1;
						$no = 1;
						while ($r = mysqli_fetch_array($qry3)) {
							$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
							$sqlKembali = mysqli_query($con,"SELECT count(nilai) as jml,sum(nilai) as kembali,GROUP_CONCAT(DISTINCT sts) as sts FROM tbl_exim_pengembalian WHERE id_cimd='".$r['id']."'");
							$rKmbl = mysqli_fetch_array($sqlKembali);
							$sqlAjukan = mysqli_query($con,"SELECT sum(nilai) as kembali,sts FROM tbl_exim_pengembalian 
					WHERE id_cimd='".$r['id']."' and sts='Ajukan' GROUP BY sts");
							$rAjukan = mysqli_fetch_array($sqlAjukan);
							$sqldiAjukan = mysqli_query($con,"SELECT sum(nilai) as kembali,sts FROM tbl_exim_pengembalian 
					WHERE id_cimd='".$r['id']."' and sts='Tidak diajukan' GROUP BY sts");
							$rdiAjukan = mysqli_fetch_array($sqldiAjukan);
						?>
							<tr bgcolor="<?php echo $bgcolor; ?>">
								<td align="center"><?php echo $no; ?></td>
								<td align="center">
									<?php echo $r['no_pi']; ?>
								</td>
								<td>
									<div align="center">
										<?php echo $r['po']; ?>
									</div>
								</td>
								<td>
									<div align="center"><?php echo $r['item']; ?></div>
								</td>
								<td>
									<div align="center"><?php echo $r['color']; ?></div>
								</td>
								<td>
									<div align="right">
										<?php echo $r['kg']; ?>
									</div>
								</td>
								<td>
									<div align="right">
										<?php echo $r['panjang']; ?>
									</div>
								</td>
								<td>
									<div align="right"><?php echo $r['pcs']; ?></div>
								</td>
								<td>
									<div align="right"><a href="?p=Form-Tambah-Pengembalian&DCI=<?php echo $_GET['id']; ?>&id=<?php echo $r['id']; ?>"><?php if ($rKmbl['kembali'] > 0) {
																																							echo number_format($rKmbl['kembali'], "2", ".", ",");
																																						} else {
																																							echo "0";
																																						} ?></a></div>
								</td>
								<td align="center"><?php if ($rKmblr['sts'] == "Ajukan") { ?><span class="label label-success"><?php echo $rKmbl['sts']; ?></span><?php } else if ($rKmbl['sts'] == "Tidak diajukan") { ?><span class="label label-danger"><?php echo $rKmbl['sts']; ?></span><?php } else if ($rKmbl['sts'] == "Non-KITE") { ?><span class="label label-primary"><?php echo $rKmbl['sts']; ?></span><?php } else { ?><span class="label label-info"><?php echo $rKmbl['sts']; ?></span><?php } ?></td>
								<td align="center"><a href="#" class="btn btn-sm btn-danger <?php if ($rKmbl['jml'] > 0) {
																								echo "disabled";
																							} else {
																								echo "enabled";
																							} ?>" onclick="confirm_delete('?p=dci_hapus&id=<?php echo $r['id'] ?>&ci=<?php echo $_GET['id'] ?>');"><i class="fa fa-trash"></i> </a></td>
							</tr>
						<?php
							$totalP = $totalP + $rKmbl['kembali'];
							$tAjukan = $tAjukan + $rAjukan['kembali'];
							$tDiajukan = $tDiajukan + $rdiAjukan['kembali'];
							$no++;
						} ?>
					</tbody>
					<tfooter>
						<tr bgcolor="<?php echo $bgcolor; ?>">
							<td align="center">&nbsp;</td>
							<td align="center">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td colspan="2" align="right">Ajukan</td>
							<td align="right"><?php echo number_format($tAjukan, "2", ".", ","); ?></td>
							<td align="center">&nbsp;</td>
							<td align="center">&nbsp;</td>
						</tr>
						<tr bgcolor="<?php echo $bgcolor; ?>">
							<td align="center">&nbsp;</td>
							<td align="center">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td colspan="2" align="right">Tidak diajukan</td>
							<td align="right"><?php echo number_format($tDiajukan, "2", ".", ","); ?></td>
							<td align="center">&nbsp;</td>
							<td align="center">&nbsp;</td>
						</tr>
						<tr bgcolor="<?php echo $bgcolor; ?>">
							<td align="center">&nbsp;</td>
							<td align="center">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td colspan="2" align="right">Total</td>
							<td align="right"><?php echo number_format($totalP, "2", ".", ","); ?></td>
							<td align="center">&nbsp;</td>
							<td align="center">&nbsp;</td>
						</tr>
					</tfooter>


				</table>
				<div id="PrintCI" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Popup untuk delete-->
<div class="modal fade" id="delDetail" tabindex="-1">
	<div class="modal-dialog modal-sm">
		<div class="modal-content" style="margin-top:100px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
			</div>
			<div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
				<a href="#" class="btn btn-danger" id="delete_link">Delete</a>
				<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<?php

if (isset($_POST['save'])) {
	$qry1 = mysqli_query($con,"INSERT INTO tbl_exim_cim_detail SET
		id_cim='".$_GET['id']."',
		no_pi='".$_POST['no_pi']."',
		id_pimd='".$_GET['pid']."',
		panjang='".$_POST['panjang']."',
		satuan='".$_POST['satuan']."',
		kg='".$_POST['berat']."',
		no_invoice='".$_POST['no_inv']."'
		");

	if ($qry1) {
		//echo "<script>alert('Data Tersimpan');</script>";
		//echo "<script>window.location.href='?p=Form-Pemeriksaan&no_mesin=$_GET[no_mesin]';</script>";
		echo "<script>swal({
  title: 'Data Tersimpan',
  text: 'Klik Ok untuk melanjutkan',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    window.location.href='?p=Form-Detail-CI-Manual&id=".$_GET['id']."&pi=".$_GET['pi']."';
  }
});</script>";
	} else {
		echo "There's been a problem: " . mysql_error();
	}
}

?>
<script type="text/javascript">
	function confirm_delete(delete_url) {
		$('#delDetail').modal('show', {
			backdrop: 'static'
		});
		document.getElementById('delete_link').setAttribute('href', delete_url);
	}
</script>

<script>
	$(document).ready(function() {
		$(".cetak_ci").click(function(e) {
			var m = $(this).attr("id");
			$.ajax({
				url: "pages/print-temp-ci.php",
				type: "GET",
				data: {
					id: m,
				},
				success: function(ajaxData) {
					$("#PrintCI").html(ajaxData);
					$("#PrintCI").modal('show', {
						backdrop: 'true'
					});
				}
			});
		});
	})
</script>