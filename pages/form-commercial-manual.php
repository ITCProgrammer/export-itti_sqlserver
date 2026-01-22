<?php

    if (isset($_POST['save'])) {
		$note= str_replace("'","''",$_POST['note']);
		$noci= $_POST['no_ci'];
		$nosi= $_POST['no_si'];
		$nosj= $_POST['no_sj'];
		$nopeb= $_POST['no_peb'];
		$nobl= $_POST['no_bl'];
		if($_POST['tgl_si']!=""){$tglsi=" tgl_si='".$_POST['tgl_si']."',";}else{$tglsi="tgl_si=null,";}
		if($_POST['tgl_sj']!=""){$tglsj=" tgl_sj='".$_POST['tgl_sj']."',";}else{$tglsj="tgl_sj=null,";}
		if($_POST['tgl_peb']!=""){$tglpeb=" tgl_peb='".$_POST['tgl_peb']."',";}else{$tglpeb="tgl_peb=null,";}
		if($_POST['tgl_etd']!=""){$tgletd=" etd='".$_POST['tgl_etd']."',";}else{$tgletd="etd=null,";}
        $qry1=sqlsrv_query($con,"INSERT INTO db_qc.tbl_exim_cim SET
		no_invoice='$noci',
		consignee='".$_POST['consignee']."',
		fasilitas='".$_POST['fasilitas']."',
		no_si='$nosi',
		$tglsi
		no_sj='$nosj',
		$tglsj
		no_peb='$nopeb',
		$tglpeb
		no_bl='$nobl',
		$tgletd
		note='$note',
		author='".$_POST['author']."',
		tgl_update=GETDATE()
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
    window.location.href='?p=Commercial-Invoice-Manual';
  }
});</script>";
        } else {
            echo "There's been a problem: " . mysql_error();
        }
    }
if (isset($_POST['edit'])) {
		$note= $_POST['note'];
		$noci= $_POST['no_ci'];
		$nosi= $_POST['no_si'];
		$nosj= $_POST['no_sj'];
		$nopeb= $_POST['no_peb'];
		$nobl= $_POST['no_bl'];
		if($_POST['tgl_si']!=""){$tglsi=" tgl_si='".$_POST['tgl_si']."',";}else{$tglsi="tgl_si=null,";}
		if($_POST['tgl_sj']!=""){$tglsj=" tgl_sj='".$_POST['tgl_sj']."',";}else{$tglsj="tgl_sj=null,";}
		if($_POST['tgl_peb']!=""){$tglpeb=" tgl_peb='".$_POST['tgl_peb']."',";}else{$tglpeb="tgl_peb=null,";}
		if($_POST['tgl_etd']!=""){$tgletd=" etd='".$_POST['tgl_etd']."',";}else{$tgletd="etd=null,";}
        $qry1=sqlsrv_query($con,"UPDATE db_qc.tbl_exim_cim SET
		consignee='".$_POST['consignee']."',
		fasilitas='".$_POST['fasilitas']."',
		no_si='$nosi',
		$tglsi
		no_sj='$nosj',
		$tglsj
		no_peb='$nopeb',
		$tglpeb
		no_bl='$nobl',
		$tgletd
		note='$note',
		author='".$_POST['author']."',
		tgl_update=GETDATE()
		WHERE id='".$_POST['id']."'
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
    window.location.href='?p=Commercial-Invoice-Manual';
  }
});</script>";
        } else {
            echo "There's been a problem: " . mysql_error();
        }
    }
$qCI=sqlsrv_query($con,"SELECT TOP 1 * FROM db_qc.tbl_exim_cim WHERE no_invoice='".$_GET['ci']."' ");
$cCI=sqlsrv_num_rows($qCI);
$dCI=sqlsrv_fetch_array($qCI);
?>

<div class="box box-info">
	<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
		<div class="box-header with-border">
			<h3 class="box-title">Form Commercial Invoice Manual</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>		
		<div class="box-body">
			<input type="hidden" name="id" value="<?php echo $dCI['id']; ?>">
			<div class="col-md-6">
			<div class="form-group">
				<label for="no_ci" class="col-sm-3 control-label">No Invoice</label>
				<div class="col-sm-4">
					<input name="no_ci" type="text" class="form-control" id="no_ci" onchange="window.location='?p=Form-Commercial-Manual&ci='+this.value" value="<?php echo $_GET['ci'];?>" placeholder="No Invoice" required>
				</div>
			</div>
			<div class="form-group">
				<label for="consignee" class="col-sm-3 control-label">Consignee</label>
				<div class="col-sm-8">
					<select name="consignee" class="form-control" required>
						<option value="">Pilih</option>
						<?php
						$qrycon= sqlsrv_query($con,"SELECT nama FROM db_qc.tbl_exim_buyer ORDER BY nama ASC");
		                while($rcon=sqlsrv_fetch_array($qrycon)){
						?>
						<option value="<?php echo strtoupper($rcon['nama']); ?>" <?php if($dCI['consignee']==strtoupper($rcon['nama'])){echo "SELECTED";}?>><?php echo strtoupper($rcon['nama']); ?></option>
						<?php }?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="fasilitas" class="col-sm-3 control-label">Fasilitas</label>
				<div class="col-sm-3">
					<select name="fasilitas" class="form-control" required>
						<option value="">Pilih</option>
						<option value="UMUM" <?php if($dCI['fasilitas']=="UMUM"){echo "SELECTED";}?>>UMUM</option>
						<option value="KITE" <?php if($dCI['fasilitas']=="KITE"){echo "SELECTED";}?>>KITE</option>
						<option value="UMUM(KITE)" <?php if($dCI['fasilitas']=="UMUM(KITE)"){echo "SELECTED";}?>>UMUM(KITE)</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="no_si" class="col-sm-3 control-label">NO SI</label>
				<div class="col-sm-3">
					<input name="no_si" type="text" class="form-control" id="no_si" value="<?php echo $dCI['no_si']; ?>" placeholder="No SI">
				</div>
			</div>	
			<div class="form-group">
				<label for="tgl_si" class="col-sm-3 control-label">Tgl SI</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="tgl_si" class="form-control pull-right" id="datepicker" placeholder="0000-00-00" value="<?php echo $dCI['tgl_si']; ?>" autocomplete="off"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="no_peb" class="col-sm-3 control-label">NO PEB</label>
				<div class="col-sm-3">
					<input name="no_peb" type="text" class="form-control" id="no_peb" value="<?php echo $dCI['no_peb']; ?>" placeholder="No PEB">
				</div>
			</div>	
			<div class="form-group">
				<label for="tgl_peb" class="col-sm-3 control-label">Tgl PEB</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="tgl_peb" class="form-control pull-right" id="datepicker2" placeholder="0000-00-00" value="<?php echo $dCI['tgl_peb']; ?>" autocomplete="off"/>
					</div>
				</div>
			</div>	
			</div>	
			<div class="col-md-6">
			<div class="form-group">
				<label for="no_sj" class="col-sm-3 control-label">NO Surat Jalan</label>
				<div class="col-sm-3">
					<input name="no_sj" type="text" class="form-control" id="no_sj" value="<?php echo $dCI['no_sj']; ?>" placeholder="No SJ">
				</div>
			</div>	
			<div class="form-group">
				<label for="tgl_si" class="col-sm-3 control-label">Tgl Surat Jalan</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="tgl_sj" class="form-control pull-right" id="datepicker1" placeholder="0000-00-00" value="<?php echo $dCI['tgl_sj']; ?>" autocomplete="off" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="no_bl" class="col-sm-3 control-label">NO B/L</label>
				<div class="col-sm-3">
					<input name="no_bl" type="text" class="form-control" id="no_bl" value="<?php echo $dCI['no_bl']; ?>" placeholder="No B/L">
				</div>
			</div>	
			<div class="form-group">
				<label for="tgl_etd" class="col-sm-3 control-label">ETD</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="tgl_etd" class="form-control pull-right" id="datepicker3" placeholder="0000-00-00" value="<?php echo $dCI['etd']; ?>" autocomplete="off" />
					</div>
				</div>
			</div>	
			<div class="form-group">
				<label for="note" class="col-sm-3 control-label">Note</label>
				<div class="col-sm-6">
					<textarea name="note" class="form-control" id="note" placeholder="Note..."><?php echo $dCI['note']; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="author" class="col-sm-3 control-label">AUTHOR</label>
				<div class="col-sm-4">
					<input name="author" type="text" class="form-control" id="author" value="<?php if($dCI['author']==""){echo strtoupper($_SESSION['usernmEX']);}else{ echo $dCI['author'];} ?>" placeholder="Author">
				</div>
			</div>	
			</div>
			

		</div>
		<div class="box-footer">
			<div class="col-sm-2">
				<?php if($cCI> 0){ ?>
				<button type="submit" class="btn btn-block btn-social btn-linkedin" name="edit" style="width: 80%">Ubah <i class="fa fa-edit"></i></button>
				<?php }else{ ?>				
				<button type="submit" class="btn btn-block btn-social btn-linkedin" name="save" style="width: 80%">Simpan <i class="fa fa-save"></i></button>
				<?php } ?>
			</div>
			<button type="button" class="btn btn-default pull-right" name="save" Onclick="window.location='?p=Commercial-Invoice-Manual'">Kembali <i class="fa fa-cycle"></i></button>
		</div>
		<!-- /.box-footer -->


	</form>
</div>           
