<?php

    if (isset($_POST[save])) {
		$note=mysql_real_escape_string($_POST[note]);
		$bclkt=mysql_real_escape_string($_POST[no_bcklkt]);
		$ajukan=mysql_real_escape_string($_POST[diajukan]);
		if($_POST[pengajuan]!=""){$pengajuan=" `pengajuan` = '$_POST[pengajuan]', ";}else{$pengajuan=" `pengajuan`=null, ";}
		if($_POST[disetujui]!=""){$disetujui=" `disetujui` = '$_POST[disetujui]', ";}else{$disetujui=" `disetujui`=null, ";}
		if($_POST[pencairan]!=""){$pencairan=" `pencairan` = '$_POST[pencairan]', ";}else{$pencairan=" `pencairan`=null, ";}
		if($_POST[spm_terima]!=""){$terima_spm=" `terima_spm` = '$_POST[spm_terima]', ";}else{$terima_spm=" `terima_spm`=null, ";}
		if($_POST[uang_masuk]!=""){$uang_msk=" `uang_msk` = '$_POST[uang_masuk]', ";}else{$uang_msk=" `uang_msk`=null, ";}
        $qry1=mysql_query("INSERT INTO tbl_exim_bclkt SET
		`no_bclkt`='$bclkt',
		`ajukan` = '$ajukan',
		$pengajuan
		$disetujui
		$pencairan
		$terima_spm
		$uang_msk
		`status` = '$_POST[status]',
		`note`='$note',
		`tgl_buat`=now()
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
    window.location.href='?p=Data-BCLKT';
  }
});</script>";
        } else {
            echo "<script>swal({
  title: 'Data Gagal diSimpan',
  text: 'Klik Ok untuk melanjutkan',
  type: 'warning',
  }).then((result) => {
  if (result.value) {
    window.location.href='?p=Data-BCLKT';
  }
});</script>"; 
        }
    }

$qCI=mysql_query("SELECT * FROM tbl_exim_bclkt WHERE `no_bclkt`='$_GET[no]' LIMIT 1");
$cCI=mysql_num_rows($qCI);
$dCI=mysql_fetch_array($qCI);
?>

<div class="box box-info">
	<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
		<div class="box-header with-border">
			<h3 class="box-title">Form BCL-KT</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>		
		<div class="box-body">
			<input type="hidden" name="id" value="<?php echo $dCI[id]; ?>">
			<div class="col-md-6">
			<div class="form-group">
				<label for="no_ci" class="col-sm-3 control-label">No BCLKT</label>
				<div class="col-sm-4">
					<input name="no_bcklkt" type="text" class="form-control" id="no_bcklkt" onchange="window.location='?p=Form-BCLKT&no='+this.value" value="<?php echo $_GET[no];?>" placeholder="No BCL-KT" required>
				</div>
			</div>
			<div class="form-group">
				<label for="diajukan" class="col-sm-3 control-label">Diajukan</label>
				<div class="col-sm-3">
					<input name="diajukan" type="text" class="form-control" id="diajukan" value="<?php echo $r[no_peb]; ?>" placeholder="">
				</div>
			</div>	
			<div class="form-group">
				<label for="tgl_si" class="col-sm-3 control-label">Tgl Pengajuan</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="pengajuan" class="form-control pull-right" id="datepicker" placeholder="0000-00-00" value="<?php echo $dCI[tgl_si]; ?>" autocomplete="off"/>
					</div>
				</div>
			</div>				
			<div class="form-group">
				<label for="tgl_peb" class="col-sm-3 control-label">Tgl Disetujui</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="disetujui" class="form-control pull-right" id="datepicker2" placeholder="0000-00-00" value="<?php echo $dCI[tgl_peb]; ?>" autocomplete="off"/>
					</div>
				</div>
			</div>	           				
			<div class="form-group">
				<label for="tgl_peb" class="col-sm-3 control-label">Tgl Pencairan</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="pencairan" class="form-control pull-right" id="datepicker3" placeholder="0000-00-00" value="<?php echo $dCI[tgl_peb]; ?>" autocomplete="off"/>
					</div>
				</div>
			</div>
			</div>
			<div class="col-md-6">
			 
			<div class="form-group">
				<label for="tgl_peb" class="col-sm-3 control-label">SPM Diterima</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="spm_terima" class="form-control pull-right" id="datepicker4" placeholder="0000-00-00" value="<?php echo $dCI[tgl_peb]; ?>" autocomplete="off"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_peb" class="col-sm-3 control-label">Uang Masuk</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="uang_masuk" class="form-control pull-right" id="datepicker5" placeholder="0000-00-00" value="<?php echo $dCI[tgl_peb]; ?>" autocomplete="off"/>
					</div>
				</div>
			</div>
			<div class="form-group" hidden="hidden">
				<label for="fasilitas" class="col-sm-3 control-label">Status</label>
				<div class="col-sm-3">
					<select name="fasilitas" class="form-control">
						<option value="">Pilih</option>
						<option value="OK" <?php if($dCI[status]=="OK"){echo "SELECTED";}?>>OK</option>
						<option value="TIDAK" <?php if($dCI[status]=="TIDAK"){echo "SELECTED";}?>>TIDAK</option>
					</select>
				</div>
			</div>	
            <div class="form-group">
				<label for="note" class="col-sm-3 control-label">Note</label>
				<div class="col-sm-6">
					<textarea name="note" class="form-control" id="note" placeholder="Note..."><?php echo $r[note]; ?></textarea>
				</div>
			</div>
			</div>
		</div>
		<div class="box-footer">
			<div class="col-sm-2">							
				<button type="submit" class="btn btn-social btn-linkedin" name="save">Simpan <i class="fa fa-save"></i></button>
			</div>
			<button type="button" class="btn btn-default pull-right" name="save" Onclick="window.location='?p=Data-BCLKT'">Kembali <i class="fa fa-cycle"></i></button>
		</div>
		<!-- /.box-footer -->


	</form>
</div>           
