<?php 
	
	
$qry=mssql_query("SELECT TOP 1 a.ID,CAST(d.[PONumber] AS VARCHAR(8000)) AS PONumber,
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
WHERE a.SONumber='$_GET[pi]'");
	$data=mssql_fetch_array($qry);
$sqlInv=mysql_query("SELECT * FROM tbl_exim_cim WHERE id='$_GET[id]' LIMIT 1");
$dInv=mysql_fetch_array($sqlInv);
?>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header with-border">
			<h3 class="box-title">Detail CI KITE</h3>	
		    <button type="button" class="btn btn-default pull-right" name="save" Onclick="window.location='?p=PEB-Kite'">Kembali <i class="fa fa-cycle"></i></button>
			</div>
			<div class="box-body">
			<?php $qry3=mysql_query("SELECT c.po,c.item,c.color,a.no_pi,b.no_invoice,a.kg,a.panjang,a.satuan,a.pcs,a.no_urut_peb,a.no_bclkt,a.id FROM tbl_exim_cim_detail a 
INNER JOIN tbl_exim_cim b ON b.id=a.id_cim
LEFT JOIN tbl_exim_pim_detail c ON a.id_pimd=c.id
WHERE a.id_cim='$_GET[id]' ORDER BY a.id ASC"); ?>	
				<table id="example2" class="table table-bordered table-hover table-striped" width="100%">
					<thead class="bg-green">
						<tr>
						  <th width="54"><div align="center">No.</div></th>
							<th width="133">
								<div align="center">PI</div>
							</th>
							<th width="171">
								<div align="center">
									<div align="center">PO</div>
							</th>
							<th width="169">
								<div align="center">Item</div>
							</th>
							<th width="158">
								<div align="center">Color</div>
							</th>
							<th width="78"><div align="center">KG</div></th>
							<th width="60"><div align="center">YDs</div></th>
							<th width="63"> <div align="center">PCS</div>
						  </th>
							<th width="99"><div align="center">No Urut PEB</div></th>
							<th width="86"><div align="center">BCLKT No</div></th>
							<th width="77">Action</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$c=1;
					$no=1;
					while($r=mysql_fetch_array($qry3)){
					$bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';					
					?>
						<tr bgcolor="<?php echo $bgcolor; ?>">
						  <td align="center"><?php echo $no; ?></td>
							<td align="center">
								<?php echo $r[no_pi]; ?>
							</td>
							<td><div align="center">
							  <?php echo $r[po]; ?>
							  </div></td>
							<td><div align="center"><?php echo $r[item]; ?></div></td>
							<td><div align="center"><?php echo $r[color]; ?></div></td>
							<td><div align="right">
							  <?php echo $r[kg]; ?>
							  </div></td>
							<td><div align="right">
							  <?php echo $r[panjang]; ?>
							  </div></td>
							<td><div align="right"><?php echo $r[pcs]; ?></div></td>
							<td><div align="center"> <?php echo $r[no_urut_peb]; ?> </div></td>
							<td><div align="center"> <?php echo $r[no_bclkt]; ?> </div></td>
							<td align="center"><a href="#" id='<?php echo $r['id'] ?>' class="btn btn-sm btn-info dci_edit"><i class="fa fa-edit"></i> </a></td>
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
<!-- Modal Popup untuk Edit--> 
<div id="DetailCIEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

if (isset($_POST[save])) {
        $qry1=mysql_query("INSERT INTO tbl_exim_cim_detail SET
		id_cim='$_GET[id]',
		no_pi='$_POST[no_pi]',
		id_pimd='$_GET[pid]',
		panjang='$_POST[panjang]',
		satuan='$_POST[satuan]',
		kg='$_POST[berat]',
		no_invoice='$_POST[no_inv]'
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
    window.location.href='?p=Form-Detail-CI-Manual&id=$_GET[id]&pi=$_GET[pi]';
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