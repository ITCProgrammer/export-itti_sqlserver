<?php
   if(isset($_POST[save])){
	$tgl=$_POST[tgl_sa];
	$shipper=nl2br(htmlspecialchars(str_replace("'","''",$_POST[shipper])));
	$attn=str_replace("'","''",$_POST[attn]);
	$value=$_POST[inv_value];
	$merchandise=str_replace("'","''",$_POST[merchandise]);
	$ci=str_replace("'","''",$_POST[no_ci]);
	$qry=mysql_query("UPDATE tbl_exim_sa SET
	`attn`='$attn',
	`tgl`='$tgl',
	`inv_value`='$value',
	`merchandise`='$merchandise',
	`no_ci`='$ci',
	`author`='$_POST[author]',
	`tgl_update`=now()
	WHERE `id`='$_POST[id]'
	") or die("Gagal simpan");
	if($qry){
	//echo "<script>alert('Data has been Saved!');window.location='?p=Shipment-Advice';</script>";
	echo "<script>swal({
  title: 'Data Tersimpan',
  text: 'Klik Ok untuk melanjutkan',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    window.location.href='?p=Shipment-Advice';
  }
});</script>";	
	}
}	
	$sqlcek=mysql_query("SELECT COUNT(*) as jml FROM tbl_exim WHERE listno='$_GET[no]'");
	$cek=mysql_fetch_array($sqlcek);
	if($_GET[no]!=""){
	if($cek[jml]=="0"){echo "<script>alert('Invoice: $_GET[no] not found!');window.location='?p=Form-Shipment-Advice&no=';</script>";}
	}
	$qryCek=mysql_query("SELECT * FROM tbl_exim_sa WHERE id='$_GET[id]' LIMIT 1");
	$cekD=mysql_fetch_array($qryCek);
	?>

<div class="box box-info">
	<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
		<div class="box-header with-border">
			<h3 class="box-title">Edit Shipment Advice</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>		
		<div class="box-body">
			<input type="hidden" name="id" value="<?php echo $cekD[id]; ?>">
			<div class="col-md-6">
			<div class="form-group">
				<label for="no_sa" class="col-sm-3 control-label">No Urut</label>
				<div class="col-sm-2">
					<input name="no_sa" type="text" class="form-control" id="no_sa" value="<?php echo $cekD[no_sa];?>" placeholder="No Urut" readonly>
				</div>
			</div>
			<div class="form-group">
				<label for="no_ci" class="col-sm-3 control-label">NO CI</label>
				<div class="col-sm-4">
					<input name="no_ci" type="text" class="form-control" id="no_ci" value="<?php echo $cekD[no_ci]; ?>" placeholder="No CI">
				</div>
			</div>
			<div class="form-group">
				<label for="attn" class="col-sm-3 control-label">Attn</label>
				<div class="col-sm-5">
					<input name="attn" type="text" class="form-control" id="attn" value="IMPORT DEPARTEMENT" placeholder="Attn">
				</div>
			</div>	
			<div class="form-group">
				<label for="tgl_sa" class="col-sm-3 control-label">Tgl SA</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="tgl_sa" class="form-control pull-right" id="datepicker" placeholder="0000-00-00" value="<?php echo $cekD[tgl]; ?>" autocomplete="off"/>
					</div>
				</div>
			</div>				
				
			</div>	
			<div class="col-md-6">
			<div class="form-group">
				<label for="inv_value" class="col-sm-3 control-label">Invoice Value</label>
				<div class="col-sm-3">
					<div class="input-group">
					<input name="inv_value" type="text" class="form-control" id="inv_value" value="<?php echo $cekD[inv_value]; ?>" placeholder="0.00"><span class="input-group-addon">US$</span>
					</div>	
				</div>
			</div>				
			<div class="form-group">
				<label for="merchandise" class="col-sm-3 control-label">Merchandise</label>
				<div class="col-sm-6">
					<input name="merchandise" type="text" class="form-control" id="merchandise" value="<?php echo $cekD[merchandise]; ?>" placeholder="Merchandise">
				</div>
			</div>	
			<div class="form-group">
				<label for="no_bl" class="col-sm-3 control-label">Author</label>
				<div class="col-sm-3">
					<input name="author" type="text" class="form-control" id="author" value="<?php echo strtoupper($_SESSION['usernmEX']);?>" placeholder="Author" readonly>
				</div>
			</div>	
				
			</div>
			

		</div>
		<div class="box-footer">
			<button type="submit" class="btn btn-primary pull-right" name="save">Simpan <i class="fa fa-save"></i></button>
			<button type="button" class="btn btn-default" name="save" Onclick="window.location='?p=Shipment-Advice'">Kembali <i class="fa fa-cycle"></i></button>
		</div>
		<!-- /.box-footer -->


	</form>
</div>           
