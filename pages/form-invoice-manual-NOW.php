<?php 
	
/*$qry=sqlsrv_query($conn,"SELECT TOP 1 a.ID,CAST(d.[PONumber] AS VARCHAR(8000)) AS PONumber,
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
LEFT JOIN SODetails b ON a.ID=b.SOID
LEFT JOIN sodetailsadditional d ON d.sodid=b.id
LEFT JOIN JobOrders c ON a.ID=c.SOID
LEFT JOIN Partners e ON a.BuyerID=e.ID
LEFT JOIN Partners f ON a.CustomerID=f.ID
LEFT JOIN Incoterms g ON a.IncotermID=g.ID
LEFT JOIN PaymentTerms h ON a.PaymentTermID=h.ID
LEFT JOIN SODelivery i ON a.ID=i.SOID
LEFT JOIN Partners j ON i.ConsigneeID=j.ID
LEFT JOIN Countries k ON i.CountryID=k.ID
LEFT JOIN Countries l ON f.CountryID=l.ID
LEFT JOIN Countries m ON j.CountryID=m.ID
WHERE a.SONumber='".$_GET['pi']."'");
$data=sqlsrv_fetch_array($qry,SQLSRV_FETCH_ASSOC);*/

$sql1DB2="SELECT 
s.ORDERPARTNERBRANDCODE AS BUYER,s.CODE AS ORDERNO,
o.PAYMENTMETHODCODE AS PAYMENT,
o.TERMSOFDELIVERYCODE AS TERM,
b.LEGALNAME1 AS CONSIGNEE,
b.LEGALNAME1 AS MESSR,
b.ADDRESSLINE1 AS DESTINATION,
s.CREATIONUSER AS SALESPERSON,
s.REQUIREDDUEDATE AS TGLDELIVERY  FROM SALESORDER s
LEFT JOIN ORDERPARTNER o ON o.CUSTOMERSUPPLIERCODE =s.ORDPRNCUSTOMERSUPPLIERCODE
LEFT JOIN BUSINESSPARTNER b ON b.NUMBERID=o.ORDERBUSINESSPARTNERNUMBERID 
				WHERE s.CODE ='".$_GET['pi']."'";
$stmt1=db2_exec($conn1,$sql1DB2, array('cursor'=>DB2_SCROLLABLE));
$rdb2 = db2_fetch_assoc($stmt1);
?>
<?php
   
$sqlCek = sqlsrv_query(
	$con,
	"SELECT TOP 1 * FROM db_qc.tbl_exim_pim WHERE no_pi = ?",
	[$_GET['pi']],
	["Scrollable" => SQLSRV_CURSOR_KEYSET]
);
$cek = ($sqlCek === false) ? 0 : sqlsrv_num_rows($sqlCek);
$r   = ($sqlCek && $cek > 0) ? sqlsrv_fetch_array($sqlCek, SQLSRV_FETCH_ASSOC) : [];
// normalize dates for form display
$tglTerimaVal = (!empty($r['tgl_terima']) && $r['tgl_terima'] instanceof DateTimeInterface) ? $r['tgl_terima']->format('Y-m-d') : '';
$tglDelivVal  = (!empty($rdb2['TGLDELIVERY']) && !is_object($rdb2['TGLDELIVERY'])) ? $rdb2['TGLDELIVERY'] : '';
?>

<div class="box box-info">
	<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
		<div class="box-header with-border">
			<h3 class="box-title">Form Proforma Invoice Manual (N.O.W)</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>		
		<div class="box-body">
			<input name="id" type="hidden" class="form-control" id="id" value="<?php echo $r['id'];?>">
			<div class="col-md-6">
			<div class="form-group">
				<label for="no_pi" class="col-sm-3 control-label">No PI</label>
				<div class="col-sm-3">
					<input name="no_pi" type="text" class="form-control" id="no_pi" onchange="window.location='?p=Form-Invoice-Manual-NOW&amp;pi='+this.value" value="<?php echo strtoupper($_GET['pi']);?>" placeholder="No Pi">
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_terima" class="col-sm-3 control-label">Tgl Terima</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input name="tgl_terima" type="text" required class="form-control pull-right" id="datepicker" placeholder="0000-00-00" autocomplete="off" value="<?php echo $tglTerimaVal; ?>"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="author" class="col-sm-3 control-label">Author</label>
				<div class="col-sm-3">
					<input name="author" type="text" class="form-control" id="author" value="<?php echo (!empty($r['author']) ? strtoupper($r['author']) : strtoupper($_SESSION['usernmEX']));?>" placeholder="Author">
				</div>
			</div>
			<div class="form-group">
				<label for="bon_order" class="col-sm-3 control-label">Bon Order</label>
				<div class="col-sm-4">
					<input name="bon_order" type="text" class="form-control" id="bon_order" value="<?php echo $rdb2['ORDERNO']; ?>" placeholder="Bon Order">
				</div>
			</div>
			<div class="form-group">
				<label for="buyer" class="col-sm-3 control-label">Buyer</label>
				<div class="col-sm-4">
					<input name="buyer" type="text" class="form-control" id="buyer" value="<?php echo $rdb2['BUYER'] ?>" placeholder="Buyer">
				</div>
			</div>
			<div class="form-group">
				<label for="messr" class="col-sm-3 control-label">Messr</label>
				<div class="col-sm-4">
					<input name="messr" type="text" class="form-control" id="messr" value="<?php echo $rdb2['MESSR']; ?>" placeholder="Messr">
				</div>
			</div>
			</div>
			<div class="col-md-6">
			<div class="form-group">
				<label for="consignee" class="col-sm-3 control-label">Consignee</label>
				<div class="col-sm-4">
					<input name="consignee" type="text" class="form-control" id="consignee" value="<?php echo $rdb2['CONSIGNEE']; ?>" placeholder="Consignee">
				</div>
			</div>
			<div class="form-group">
				<label for="dest" class="col-sm-3 control-label">Destination</label>
				<div class="col-sm-4">
					<input name="dest" type="text" class="form-control" id="dest" value="<?php echo $rdb2['DESTINATION']; ?>" placeholder="Destination">
				</div>
			</div>
			<div class="form-group">
				<label for="payment" class="col-sm-3 control-label">Payment</label>
				<div class="col-sm-4">
					<input name="payment" type="text" class="form-control" id="payment" value="<?php echo $rdb2['PAYMENT']; ?>" placeholder="Payment">
				</div>
			</div>
			<div class="form-group">
				<label for="incoterm" class="col-sm-3 control-label">Incoterm</label>
				<div class="col-sm-4">
					<input name="incoterm" type="text" class="form-control" id="incoterm" value="<?php echo $rdb2['TERM']; ?>" placeholder="Incoterm">
				</div>
			</div>
			<div class="form-group">
				<label for="sales" class="col-sm-3 control-label">Sales Assistant</label>
				<div class="col-sm-4">
					<input name="sales" type="text" class="form-control" id="sales" value="<?php echo $rdb2['SALESPERSON']; ?>" placeholder="Sales Assistant">
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_delivery" class="col-sm-3 control-label">Tgl Delivery</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="tgl_delivery" class="form-control pull-right" id="datepicker1" placeholder="0000-00-00" value="<?php echo $tglDelivVal; ?>" autocomplete="off"/>
					</div>
				</div>
			</div>	
			</div>
			

		</div>
		<div class="box-footer">
			<?php if($cek>0){?>
			<div class="col-sm-2">
				<button type="submit" class="btn btn-social btn-github" name="edit" >Ubah <i class="fa fa-edit"></i></button>				
			</div>
			<?php }else{ ?>
			<div class="col-sm-2">
				<button type="submit" class="btn btn-social btn-linkedin" name="save" >Simpan <i class="fa fa-save"></i></button>				
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
			<?php $sql2DB2="SELECT 
DISTINCT
sl.ORDERLINE,
s.ORDERPARTNERBRANDCODE AS BUYER,s.CODE AS ORDERNO,
s.EXTERNALREFERENCE AS NO_PO1, sl.EXTERNALREFERENCE AS NO_PO2,
o.PAYMENTMETHODCODE AS PAYMENT,
o.TERMSOFDELIVERYCODE AS TERM,
b.LEGALNAME1 AS CONSIGNEE,
b.LEGALNAME1 AS MESSR,
b.ADDRESSLINE1 AS DESTINATION,
s.CREATIONUSER AS SALESPERSON,
s.REQUIREDDUEDATE AS TGLDELIVERY,
opl.LONGDESCRIPTION AS NOITEM,
CONCAT(trim(sl.SUBCODE02),trim(sl.SUBCODE03)) AS HANGERNO,
u.LONGDESCRIPTION AS WARNA,
sl.PRICE,
trim(sl.PRICEUNITOFMEASURECODE) AS UNITNAME,
sl.BASEPRIMARYQUANTITY,
sl.BASESECONDARYQUANTITY,
sl.ITEMTYPEAFICODE,
sl.SUBCODE01,
sl.SUBCODE02,
sl.SUBCODE03,
sl.SUBCODE04,
sl.SUBCODE05,
sl.SUBCODE06,
sl.SUBCODE07,
sl.SUBCODE08,
sl.SUBCODE09,
sl.SUBCODE10,
w.WARNA AS WARNA1
FROM SALESORDER s
LEFT JOIN SALESORDERLINE sl ON sl.SALESORDERCODE =s.CODE 
LEFT JOIN ORDERITEMORDERPARTNERLINK opl ON s.ORDPRNCUSTOMERSUPPLIERCODE = opl.ORDPRNCUSTOMERSUPPLIERCODE AND 
	sl.ITEMTYPEAFICODE= opl.ITEMTYPEAFICODE AND 
	sl.SUBCODE01 = opl.SUBCODE01 AND sl.SUBCODE02 = opl.SUBCODE02 AND sl.SUBCODE03 = opl.SUBCODE03 AND
	sl.SUBCODE04 = opl.SUBCODE04 AND sl.SUBCODE05 = opl.SUBCODE05 AND sl.SUBCODE06 = opl.SUBCODE06 AND 
	sl.SUBCODE07 = opl.SUBCODE07 AND sl.SUBCODE08 = opl.SUBCODE08 AND sl.SUBCODE09 = opl.SUBCODE09 AND 
	sl.SUBCODE10 = opl.SUBCODE10 
LEFT JOIN ORDERPARTNER o ON o.CUSTOMERSUPPLIERCODE =s.ORDPRNCUSTOMERSUPPLIERCODE
LEFT JOIN BUSINESSPARTNER b ON b.NUMBERID=o.ORDERBUSINESSPARTNERNUMBERID 
LEFT JOIN USERGENERICGROUP u ON u.CODE =sl.SUBCODE05 
LEFT JOIN ITXVIEWCOLOR w ON w.ITEMTYPECODE =sl.ITEMTYPEAFICODE 
					AND w.SUBCODE01 = sl.SUBCODE01 AND w.SUBCODE02 = sl.SUBCODE02
					AND w.SUBCODE03 = sl.SUBCODE03 AND w.SUBCODE04 = sl.SUBCODE04 
					AND w.SUBCODE05 = sl.SUBCODE05 AND w.SUBCODE06 = sl.SUBCODE06 
					AND w.SUBCODE07 = sl.SUBCODE07 AND w.SUBCODE08 = sl.SUBCODE08 
					AND w.SUBCODE09 = sl.SUBCODE09 AND w.SUBCODE10 = sl.SUBCODE10
				WHERE s.CODE ='".$_GET['pi']."'";
$stmt2=db2_exec($conn1,$sql2DB2, array('cursor'=>DB2_SCROLLABLE));
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
							<th width="56"><div align="center">Per</div></th>
							<th width="60"><div align="center">KG</div></th>
							<th width="38"><div align="center">YD</div></th>
							<th width="36">
								<div align="center">PCS</div>
							</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$c=1;					
					while($r=db2_fetch_assoc($stmt2)){
					$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
					if($r['NOITEM']==""){$itmm=$r['HANGERNO'];}else{$itmm=$r['NOITEM'];}
					$sqlHS=sqlsrv_query($con,"SELECT TOP 1 hs_code FROM db_qc.tbl_exim_code WHERE no_item='".$itmm."' ");
					$rHS=sqlsrv_fetch_array($sqlHS);
					?>
						<tr bgcolor="<?php echo $bgcolor; ?>">
							<td align="center">
								<?php echo $r['ORDERNO']; ?>
							</td>
							<td align="center"><?php echo $r['ORDERNO']; ?></td>
							<td><div align="center">
							  <?php if($r['NO_PO2']==""){echo $r['NO_PO1'];}else{ echo $r['NO_PO2']; } ?>
							  </div></td>
							<td><div align="center"><?php if($r['NOITEM']==""){echo $r['HANGERNO'];}else{echo $r['NOITEM'];} ?></div></td>
							<td><div align="left"><?php if($r['WARNA1']!=""){echo $r['WARNA1'];}else{echo $r['WARNA'];} ?></div></td>
							<td>&nbsp;</td>
							<td><div align="center"><?php echo $rHS['hs_code']; ?></div></td>
							<td><div align="right"><?php echo number_format($r['PRICE'],"3",".",""); ?></div></td>
							<td><div align="center">
							  <?php if($r['UNITNAME']=="yd"){echo"YD";}elseif($r['UNITNAME']=="kg"){echo"KG";}elseif($r['UNITNAME']=="pcs"){echo"PC";} ?>
							  </div></td>
							<td><div align="right">
							  <?php //if($r['UNITNAME']=="kg"){echo number_format($r['BASEPRIMARYQUANTITY'],"1",".","");}
								echo number_format($r['BASEPRIMARYQUANTITY'],"1",".","");
								?>
							  </div></td>
							<td><div align="right">
							  <?php if($r['UNITNAME']=="yd" or $r['UNITNAME']=="kg"){echo number_format($r['BASESECONDARYQUANTITY'],"1",".","");} ?>
							  </div></td>
							<td align="center"><?php if($r['UNITNAME']=="pcs"){echo $r['BASESECONDARYQUANTITY'];} ?></td>
						</tr>
						<?php
  } ?>
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
<?php /*$qry4=sqlsrv_query($conn,"
	SELECT
	jo.DocumentNo,
	so.PONumber,
    SODA.PONumber as POADD,	
	ISNULL(pmp.ProductCode,pm.hangerno) AS ProductCode,
	pm.Color,
	pm.ColorNo,
	SOD.UnitPrice,
	UD.UnitName,
	so.SONumber,
	SOD.Weight,
	SOD.QuantityToOrder
FROM
	SODetails SOD
LEFT JOIN SalesOrders so ON SOD.SOID = so.ID
LEFT JOIN SODetailsAdditional SODA ON SODA.SODID=SOD.ID
LEFT JOIN UnitDescription UD ON UD.id = SOD.UnitID
LEFT JOIN JobOrders jo ON jo.SOID = so.ID
LEFT JOIN Partners p ON p.ID = so.CustomerID
LEFT JOIN ProductMaster pm ON pm.ID = SOD.ProductID
LEFT JOIN ProductPartner pmp ON sod.ProductID = pmp.ProductID
AND so.BuyerID = pmp.PartnerID
WHERE
	so.SONumber LIKE '".$_GET['pi']."'
ORDER BY
	SOD.ID ASC");*/ 
$sql2DB24="SELECT
DISTINCT
sl.ORDERLINE,
s.ORDERPARTNERBRANDCODE AS BUYER,s.CODE AS ORDERNO,
s.EXTERNALREFERENCE AS NO_PO1, sl.EXTERNALREFERENCE AS NO_PO2,
s.CURRENCYCODE,
o.PAYMENTMETHODCODE AS PAYMENT,
o.TERMSOFDELIVERYCODE AS TERM,
b.LEGALNAME1 AS CONSIGNEE,
b.LEGALNAME1 AS MESSR,
b.ADDRESSLINE1 AS DESTINATION,
s.CREATIONUSER AS SALESPERSON,
s.REQUIREDDUEDATE AS TGLDELIVERY,
opl.LONGDESCRIPTION AS NOITEM,
CONCAT(trim(sl.SUBCODE02),trim(sl.SUBCODE03)) AS HANGERNO,
u.LONGDESCRIPTION AS WARNA,
sl.PRICE,
trim(sl.PRICEUNITOFMEASURECODE) AS UNITNAME,
sl.BASEPRIMARYQUANTITY,
sl.BASESECONDARYQUANTITY
FROM SALESORDER s
LEFT JOIN SALESORDERLINE sl ON sl.SALESORDERCODE =s.CODE 
LEFT JOIN ORDERITEMORDERPARTNERLINK opl ON s.ORDPRNCUSTOMERSUPPLIERCODE = opl.ORDPRNCUSTOMERSUPPLIERCODE AND 
	sl.ITEMTYPEAFICODE= opl.ITEMTYPEAFICODE AND 
	sl.SUBCODE01 = opl.SUBCODE01 AND sl.SUBCODE02 = opl.SUBCODE02 AND sl.SUBCODE03 = opl.SUBCODE03 AND
	sl.SUBCODE04 = opl.SUBCODE04 AND sl.SUBCODE05 = opl.SUBCODE05 AND sl.SUBCODE06 = opl.SUBCODE06 AND 
	sl.SUBCODE07 = opl.SUBCODE07 AND sl.SUBCODE08 = opl.SUBCODE08 AND sl.SUBCODE09 = opl.SUBCODE09 AND 
	sl.SUBCODE10 = opl.SUBCODE10 
LEFT JOIN ORDERPARTNER o ON o.CUSTOMERSUPPLIERCODE =s.ORDPRNCUSTOMERSUPPLIERCODE
LEFT JOIN BUSINESSPARTNER b ON b.NUMBERID=o.ORDERBUSINESSPARTNERNUMBERID 
LEFT JOIN USERGENERICGROUP u ON u.CODE =sl.SUBCODE05 
				WHERE s.CODE ='".$_GET['pi']."'";
$stmt24=db2_exec($conn1,$sql2DB24, array('cursor'=>DB2_SCROLLABLE));
?>
<?php 

if (isset($_POST['save'])) {
	$insertPim = sqlsrv_query(
		$con,
		"INSERT INTO db_qc.tbl_exim_pim
		 (no_pi, bon_order, buyer, messr, consignee, destination, payment, incoterm, sales_assistant, delivery, author, tgl_terima, tgl_update)
		 VALUES (?,?,?,?,?,?,?,?,?,?,?, ?, GETDATE())",
		[
			$_POST['no_pi'],
			$_POST['bon_order'],
			$_POST['buyer'],
			$_POST['messr'],
			$_POST['consignee'],
			$_POST['dest'],
			$_POST['payment'],
			$_POST['incoterm'],
			$_POST['sales'],
			$_POST['tgl_delivery'],
			$_POST['author'],
			$_POST['tgl_terima']
		]
	);
	if ($insertPim === false) {
		die(print_r(sqlsrv_errors(), true));
	}

	$cekPI = sqlsrv_query($con, "SELECT TOP 1 id FROM db_qc.tbl_exim_pim WHERE no_pi = ? ORDER BY id DESC", [$_POST['no_pi']]);
	$rcekPI = sqlsrv_fetch_array($cekPI, SQLSRV_FETCH_ASSOC);		
	$po="";
	$per="";
	$kg="0";
	$yd="0";
	$pc="0";
	while($r4=db2_fetch_assoc($stmt24)){
		if($r4['NO_PO2']==""){$po=$r4['NO_PO1'];}else{ $po=$r4['NO_PO2']; }	
		if($r4['NOITEM']==""){$itmNo=$r4['HANGERNO'];}else{$itmNo=$r4['NOITEM'];}	
		$sqlHS1=sqlsrv_query($con,"SELECT TOP 1 hs_code FROM db_qc.tbl_exim_code WHERE no_item = ?", [$itmNo]);
		$rHS1=sqlsrv_fetch_array($sqlHS1, SQLSRV_FETCH_ASSOC);
		if($r4['UNITNAME']=="yd"){$per="yd";}elseif($r4['UNITNAME']=="kg"){$per="kg";}elseif($r4['UNITNAME']=="pcs"){$per="pc";}	
		if($r4['UNITNAME']=="kg"){$kg=$r4['BASEPRIMARYQUANTITY'];}
		if($r4['UNITNAME']=="yd"){$yd=$r4['BASESECONDARYQUANTITY'];}
		if($r4['UNITNAME']=="pcs"){$pc=$r4['BASEPRIMARYQUANTITY'];}	
		$qry1=sqlsrv_query($con,"INSERT INTO db_qc.tbl_exim_pim_detail
			(id_pi, po, item, color, hs_code, price, per, kg, yd, pcs)
			VALUES (?,?,?,?,?,?,?,?,?,?)",
			[
				$rcekPI['id'],
				$po,
				$itmNo,
				$r4['WARNA1'] ?: $r4['WARNA'],
				$rHS1['hs_code'],
				$r4['PRICE'],
				$per,
				$kg,
				$yd,
				$pc
			]
		);
			
		}
        if ($insertPim && $qry1) {            
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
        $qry1=sqlsrv_query($con,"UPDATE db_qc.tbl_exim_pim SET
		bon_order = ?,
		buyer = ?,
		messr = ?,
		consignee = ?,
		destination = ?,
		payment = ?,
		incoterm = ?,
		sales_assistant = ?,
		delivery = ?,
		author = ?,
		tgl_terima = ?,
		tgl_update = GETDATE()
		WHERE id = ?",
		[
			$_POST['bon_order'],
			$_POST['buyer'],
			$_POST['messr'],
			$_POST['consignee'],
			$_POST['dest'],
			$_POST['payment'],
			$_POST['incoterm'],
			$_POST['sales'],
			$_POST['tgl_delivery'],
			$_POST['author'],
			$_POST['tgl_terima'],
			$_POST['id']
		]);
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
