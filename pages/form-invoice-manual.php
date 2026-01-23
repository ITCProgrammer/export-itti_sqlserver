<?php

// $qry=sqlsrv_query($conn,"SELECT TOP 1 a.ID,CAST(d.[PONumber] AS VARCHAR(8000)) AS PONumber,
// CAST(a.[SalesPersonName] AS VARCHAR(8000)) AS SalesPerson,
// CAST(e.[PartnerName] AS VARCHAR(8000)) AS Buyer,
// CAST(j.[PartnerName] AS VARCHAR(8000)) AS Consignee,
// CAST(j.[Address] AS VARCHAR(8000)) AS Consignee_adr,
// CAST(j.[PhoneNumber] AS VARCHAR(8000)) As Consignee_phone,
// CAST(m.[CountryName] AS VARCHAR(8000)) AS Consignee_c, 
// CAST(k.[CountryName] AS VARCHAR(8000)) AS Destination,
// CAST(f.[PartnerName] AS VARCHAR(8000)) AS Messr,
// CAST(f.[Address] AS VARCHAR(8000)) AS Messr_adr,
// CAST(f.[PhoneNumber] AS VARCHAR(8000)) AS Messr_phone,
// CAST(l.[CountryName] AS VARCHAR(8000)) AS Messr_c,  
// CAST(c.[Documentno] AS VARCHAR(8000)) AS OrderNO,
// CAST(h.[Description] AS VARCHAR(8000)) AS Payment,
// CAST(g.[Description] AS VARCHAR(8000)) AS Term,
// CONVERT(varchar(10), i.[DeliveryDate], 121) AS TglDelivery
// FROM SalesOrders a 
// LEFT JOIN SODetails b ON a.ID=b.SOID
// LEFT JOIN sodetailsadditional d ON d.sodid=b.id
// LEFT JOIN JobOrders c ON a.ID=c.SOID
// LEFT JOIN Partners e ON a.BuyerID=e.ID
// LEFT JOIN Partners f ON a.CustomerID=f.ID
// LEFT JOIN Incoterms g ON a.IncotermID=g.ID
// LEFT JOIN PaymentTerms h ON a.PaymentTermID=h.ID
// LEFT JOIN SODelivery i ON a.ID=i.SOID
// LEFT JOIN Partners j ON i.ConsigneeID=j.ID
// LEFT JOIN Countries k ON i.CountryID=k.ID
// LEFT JOIN Countries l ON f.CountryID=l.ID
// LEFT JOIN Countries m ON j.CountryID=m.ID
// WHERE a.SONumber='".$_GET['pi']."'");
// 	$data=sqlsrv_fetch_array($qry,SQLSRV_FETCH_ASSOC);
?>
<?php

$sqlCek = sqlsrv_query($con, "SELECT TOP 1 * FROM db_qc.tbl_exim_pim WHERE no_pi='" . $_GET['pi'] . "' ");
$cek = sqlsrv_num_rows($sqlCek);
$r = sqlsrv_fetch_array($sqlCek);
?>

<div class="box box-info">
	<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
		<div class="box-header with-border">
			<h3 class="box-title">Form Proforma Invoice Manual</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body">
			<input name="id" type="hidden" class="form-control" id="id" value="<?php echo $r['id']; ?>">
			<div class="col-md-6">
				<div class="form-group">
					<label for="no_pi" class="col-sm-3 control-label">No PI</label>
					<div class="col-sm-3">
						<input name="no_pi" type="text" class="form-control" id="no_pi" onchange="window.location='?p=Form-Invoice-Manual&amp;pi='+this.value" value="<?php echo strtoupper($_GET['pi']); ?>" placeholder="No Pi">
					</div>
				</div>
				<div class="form-group">
					<label for="tgl_terima" class="col-sm-3 control-label">Tgl Terima</label>
					<div class="col-sm-4">
						<div class="input-group date">
							<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
							<input name="tgl_terima" type="text" required class="form-control pull-right" id="datepicker" placeholder="0000-00-00" autocomplete="off" value="<?php if ($cek > 0) {
																																													echo $r['tgl_terima'];
																																												} ?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="author" class="col-sm-3 control-label">Author</label>
					<div class="col-sm-3">
						<input name="author" type="text" class="form-control" id="author" value="<?php if ($row['author'] != "") {
																										echo strtoupper($row['author']);
																									} else {
																										echo strtoupper($_SESSION['usernmEX']);
																									} ?>" placeholder="Author">
					</div>
				</div>
				<div class="form-group">
					<label for="bon_order" class="col-sm-3 control-label">Bon Order</label>
					<div class="col-sm-4">
						<input name="bon_order" type="text" class="form-control" id="bon_order" value="<?php echo $data['OrderNO']; ?>" placeholder="Bon Order">
					</div>
				</div>
				<div class="form-group">
					<label for="buyer" class="col-sm-3 control-label">Buyer</label>
					<div class="col-sm-4">
						<input name="buyer" type="text" class="form-control" id="buyer" value="<?php echo $data['Buyer'] ?>" placeholder="Buyer">
					</div>
				</div>
				<div class="form-group">
					<label for="messr" class="col-sm-3 control-label">Messr</label>
					<div class="col-sm-4">
						<input name="messr" type="text" class="form-control" id="messr" value="<?php echo $data['Messr']; ?>" placeholder="Messr">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="consignee" class="col-sm-3 control-label">Consignee</label>
					<div class="col-sm-4">
						<input name="consignee" type="text" class="form-control" id="consignee" value="<?php echo $data['Consignee']; ?>" placeholder="Consignee">
					</div>
				</div>
				<div class="form-group">
					<label for="dest" class="col-sm-3 control-label">Destination</label>
					<div class="col-sm-4">
						<input name="dest" type="text" class="form-control" id="dest" value="<?php echo $data['Destination']; ?>" placeholder="Destination">
					</div>
				</div>
				<div class="form-group">
					<label for="payment" class="col-sm-3 control-label">Payment</label>
					<div class="col-sm-4">
						<input name="payment" type="text" class="form-control" id="payment" value="<?php echo $data['Payment']; ?>" placeholder="Payment">
					</div>
				</div>
				<div class="form-group">
					<label for="incoterm" class="col-sm-3 control-label">Incoterm</label>
					<div class="col-sm-4">
						<input name="incoterm" type="text" class="form-control" id="incoterm" value="<?php echo $data['Term']; ?>" placeholder="Incoterm">
					</div>
				</div>
				<div class="form-group">
					<label for="sales" class="col-sm-3 control-label">Sales Assistant</label>
					<div class="col-sm-4">
						<input name="sales" type="text" class="form-control" id="sales" value="<?php echo $data['SalesPerson']; ?>" placeholder="Sales Assistant">
					</div>
				</div>
				<div class="form-group">
					<label for="tgl_delivery" class="col-sm-3 control-label">Tgl Delivery</label>
					<div class="col-sm-4">
						<div class="input-group date">
							<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
							<input type="text" name="tgl_delivery" class="form-control pull-right" id="datepicker1" placeholder="0000-00-00" value="<?php echo $data['TglDelivery']; ?>" autocomplete="off" />
						</div>
					</div>
				</div>
			</div>


		</div>
		<div class="box-footer">
			<?php if ($cek > 0) { ?>
				<div class="col-sm-2">
					<button type="submit" class="btn btn-social btn-github" name="edit">Ubah <i class="fa fa-edit"></i></button>
				</div>
			<?php } else { ?>
				<div class="col-sm-2">
					<button type="submit" class="btn btn-social btn-linkedin" name="save">Simpan <i class="fa fa-save"></i></button>
				</div>
			<?php } ?>
			<button type="button" class="btn btn-default pull-right" name="save" Onclick="window.location='?p=Proforma-Invoice-Manual'">Kembali <i class="fa fa-cycle"></i></button>
		</div>
		<!-- /.box-footer -->


	</form>
</div>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header with-border">

			</div>
			<div class="box-body">
				<?php
				// 			$qry3=sqlsrv_query($conn,"
				// 	SELECT
				// 	jo.DocumentNo,
				// 	so.PONumber,
				//     SODA.PONumber as POADD,	
				// 	ISNULL(pmp.ProductCode,pm.hangerno) AS ProductCode,
				// 	pm.Color,
				// 	pm.ColorNo,
				// 	SOD.UnitPrice,
				// 	UD.UnitName,
				// 	so.SONumber,
				// 	SOD.Weight,
				// 	SOD.QuantityToOrder
				// FROM
				// 	SODetails SOD
				// LEFT JOIN SalesOrders so ON SOD.SOID = so.ID
				// LEFT JOIN SODetailsAdditional SODA ON SODA.SODID=SOD.ID
				// LEFT JOIN UnitDescription UD ON UD.id = SOD.UnitID
				// LEFT JOIN JobOrders jo ON jo.SOID = so.ID
				// LEFT JOIN Partners p ON p.ID = so.CustomerID
				// LEFT JOIN ProductMaster pm ON pm.ID = SOD.ProductID
				// LEFT JOIN ProductPartner pmp ON sod.ProductID = pmp.ProductID
				// AND so.BuyerID = pmp.PartnerID
				// WHERE
				// 	so.SONumber LIKE '".$_GET['pi']."'
				// ORDER BY
				// 	SOD.ID ASC"); 
				?>
				<table id="example5" class="table table-bordered table-hover table-striped" width="100%">
					<thead class="bg-green">
						<tr>
							<th width="144">
								<div align="center">PI</div>
							</th>
							<th width="122">
								<div align="center">Order</div>
							</th>
							<th width="145">
								<div align="center">
									<div align="center">PO</div>
							</th>
							<th width="116">
								<div align="center">Item</div>
							</th>
							<th width="156">
								<div align="center">Color</div>
							</th>
							<th width="113">
								<div align="center">Size</div>
							</th>
							<th width="102">
								<div align="center">HS Code</div>
							</th>
							<th width="56">
								<div align="center">USD</div>
							</th>
							<th width="56">
								<div align="center">Per</div>
							</th>
							<th width="60">
								<div align="center">KG</div>
							</th>
							<th width="38">
								<div align="center">YD</div>
							</th>
							<th width="36">
								<div align="center">PCS</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$c = 1;

						// while($r=sqlsrv_fetch_array($qry3,SQLSRV_FETCH_ASSOC)){
						$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
						$sqlHS = sqlsrv_query($con, "SELECT TOP 1 hs_code FROM db_qc.tbl_exim_code WHERE no_item='" . $r['ProductCode'] . "' ");
						$rHS = sqlsrv_fetch_array($sqlHS);
						?>
						<tr bgcolor="<?php echo $bgcolor; ?>">
							<td align="center">
								<?php echo $r['SONumber']; ?>
							</td>
							<td align="center"><?php echo $r['DocumentNo']; ?></td>
							<td>
								<div align="center">
									<?php if ($r['POADD'] == "") {
										echo $r['PONumber'];
									} else {
										echo $r['POADD'];
									} ?>
								</div>
							</td>
							<td>
								<div align="center"><?php echo $r['ProductCode']; ?></div>
							</td>
							<td>
								<div align="center"><?php echo $r['Color']; ?></div>
							</td>
							<td>&nbsp;</td>
							<td>
								<div align="center"><?php echo $rHS['hs_code']; ?></div>
							</td>
							<td>
								<div align="right"><?php echo number_format($r['UnitPrice'], "3", ".", ""); ?></div>
							</td>
							<td>
								<div align="center">
									<?php if ($r['UnitName'] == "yard") {
										echo "YD";
									} elseif ($r['UnitName'] == "kg") {
										echo "KG";
									} elseif ($r['UnitName'] == "pc") {
										echo "PC";
									} ?>
								</div>
							</td>
							<td>
								<div align="right">
									<?php if ($r['UnitName'] == "kg") {
										echo $r['QuantityToOrder'];
									} else {
										echo round($r['Weight']);
									} ?>
								</div>
							</td>
							<td>
								<div align="right">
									<?php if ($r['UnitName'] == "yard") {
										echo $r['QuantityToOrder'];
									} ?>
								</div>
							</td>
							<td>&nbsp;</td>
						</tr>
						<?php
						// } 
						?>
					</tbody>

				</table>
				<div id="PeriksaEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

				</div>

			</div>
		</div>
	</div>
</div>
<!-- Modal Popup untuk delete-->
<div class="modal fade" id="delJadwal" tabindex="-1">
	<div class="modal-dialog modal-sm">
		<div class="modal-content" style="margin-top:100px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
			</div>

			<div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
				<a href="#" class="btn btn-danger" id="delJadwal_link">Delete</a>
				<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<?php
// $qry4=sqlsrv_query($conn,"
// 	SELECT
// 	jo.DocumentNo,
// 	so.PONumber,
//     SODA.PONumber as POADD,	
// 	ISNULL(pmp.ProductCode,pm.hangerno) AS ProductCode,
// 	pm.Color,
// 	pm.ColorNo,
// 	SOD.UnitPrice,
// 	UD.UnitName,
// 	so.SONumber,
// 	SOD.Weight,
// 	SOD.QuantityToOrder
// FROM
// 	SODetails SOD
// LEFT JOIN SalesOrders so ON SOD.SOID = so.ID
// LEFT JOIN SODetailsAdditional SODA ON SODA.SODID=SOD.ID
// LEFT JOIN UnitDescription UD ON UD.id = SOD.UnitID
// LEFT JOIN JobOrders jo ON jo.SOID = so.ID
// LEFT JOIN Partners p ON p.ID = so.CustomerID
// LEFT JOIN ProductMaster pm ON pm.ID = SOD.ProductID
// LEFT JOIN ProductPartner pmp ON sod.ProductID = pmp.ProductID
// AND so.BuyerID = pmp.PartnerID
// WHERE
// 	so.SONumber LIKE '".$_GET['pi']."'
// ORDER BY
// 	SOD.ID ASC"); 
?>
<?php

if (isset($_POST['save'])) {
	// $qry1 = sqlsrv_query($con, "INSERT INTO db_qc.tbl_exim_pim SET
	// 	no_pi='" . $_POST['no_pi'] . "',
	// 	bon_order='" . $_POST['bon_order'] . "',
	// 	buyer='" . $_POST['buyer'] . "',
	// 	messr='" . $_POST['messr'] . "',
	// 	consignee='" . $_POST['consignee'] . "',
	// 	destination='" . $_POST['dest'] . "',
	// 	payment='" . $_POST['payment'] . "',
	// 	incoterm='" . $_POST['incoterm'] . "',
	// 	sales_assistant='" . $_POST['sales'] . "',
	// 	delivery='" . $_POST['tgl_delivery'] . "',
	// 	author='" . $_POST['author'] . "',
	// 	tgl_terima='" . $_POST['tgl_terima'] . "',
	// 	tgl_update=now()
	// 	");	// siapa yang bikin insert begini ???

		$qry1 = sqlsrv_query($con, "INSERT INTO db_qc.tbl_exim_pim (
			no_pi, 
			bon_order, 
			buyer, 
			messr, 
			consignee, 
			destination, 
			payment, 
			incoterm, 
			sales_assistant, 
			delivery, 
			author, 
			tgl_terima, 
			tgl_update
		)
		VALUES (
			'" . $_POST['no_pi'] . "', 
			'" . $_POST['bon_order'] . "', 
			'" . $_POST['buyer'] . "', 
			'" . $_POST['messr'] . "', 
			'" . $_POST['consignee'] . "', 
			'" . $_POST['dest'] . "', 
			'" . $_POST['payment'] . "', 
			'" . $_POST['incoterm'] . "', 
			'" . $_POST['sales'] . "', 
			'" . $_POST['tgl_delivery'] . "', 
			'" . $_POST['author'] . "', 
			'" . $_POST['tgl_terima'] . "', 
			GETDATE()
		);");
	$cekPI = sqlsrv_query($con, "SELECT id FROM db_qc.tbl_exim_pim WHERE no_pi='" . $_POST['no_pi'] . "' ORDER BY id DESC ");
	$rcekPI = sqlsrv_fetch_array($cekPI);
	$po = "";
	$price = 0;
	$per = "";
	$kg = "0";
	$yd = "0";
	$pc = "0";
	// while($r1=sqlsrv_fetch_array($qry4,SQLSRV_FETCH_ASSOC)){ 
	// if ($r1['POADD'] == "") {
	// 	$po = str_replace("'", "''", $r1['PONumber']);
	// } else {
	// 	$po = str_replace("'", "''", $r1['POADD']);
	// }
	// $sqlHS1 = sqlsrv_query($con, "SELECT TOP 1 hs_code FROM db_qc.tbl_exim_code WHERE no_item='" . $r1['ProductCode'] . "' ");
	// $rHS1 = sqlsrv_fetch_array($sqlHS1);
	// if ($r1['UnitName'] == "yard") {
	// 	$per = "yd";
	// } elseif ($r1['UnitName'] == "kg") {
	// 	$per = "kg";
	// } elseif ($r1['UnitName'] == "pc") {
	// 	$per = "pc";
	// }
	// if ($r1['UnitName'] == "kg") {
	// 	$kg = $r1['QuantityToOrder'];
	// } else {
	// 	$kg = round($r1['Weight']);
	// }
	// if ($r1['UnitName'] == "yard") {
	// 	$yd = $r1['QuantityToOrder'];
	// }
	$qry2 = sqlsrv_query($con, "INSERT INTO db_qc.tbl_exim_pim_detail (
			id_pi, 
			po, 
			item, 
			color, 
			hs_code, 
			price, 
			per, 
			kg, 
			yd, 
			pcs
		)
		VALUES (
			'" . $rcekPI['id'] . "', 
			'$po', 
			'', 
			'', 
			'', 
			$price, 
			'$per', 
			'$kg', 
			'$yd', 
			'$pc'
		)");

	// }
	if ($qry1 && $qry2) {
		echo "<script>swal({
  title: 'Data Tersimpan',
  text: 'Klik Ok untuk melanjutkan',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    window.location.href='?p=Proforma-Invoice-Manual';
  }
});</script>";
	} else {
		echo "There's been a problem";
	}
}
if (isset($_POST['edit'])) {
	$qry1 = sqlsrv_query($con, "UPDATE db_qc.tbl_exim_pim SET
		bon_order='" . $_POST['bon_order'] . "',
		buyer='" . $_POST['buyer'] . "',
		messr='" . $_POST['messr'] . "',
		consignee='" . $_POST['consignee'] . "',
		destination='" . $_POST['dest'] . "',
		payment='" . $_POST['payment'] . "',
		incoterm='" . $_POST['incoterm'] . "',
		sales_assistant='" . $_POST['sales'] . "',
		delivery='" . $_POST['tgl_delivery'] . "',
		author='" . $_POST['author'] . "',
		tgl_terima='" . $_POST['tgl_terima'] . "',
		tgl_update=now()
		WHERE id='" . $_POST['id'] . "'
		");
	if ($qry1) {
		echo "<script>swal({
  title: 'Data Telah Diubah',
  text: 'Klik Ok untuk melanjutkan',
  type: 'info',
  }).then((result) => {
  if (result.value) {
    window.location.href='?p=Proforma-Invoice-Manual';
  }
});</script>";
	} else {
		echo "There's been a problem";
	}
}
?>
<script type="text/javascript">
	function confirm_del_jdwl(delete_url) {
		$('#delJadwal').modal('show', {
			backdrop: 'static'
		});
		document.getElementById('delJadwal_link').setAttribute('href', delete_url);
	}
</script>