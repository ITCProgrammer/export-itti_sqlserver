<?php

 if (isset($_POST[edit])) {
		$note=mysql_real_escape_string($_POST[note]);
		$bclkt=mysql_real_escape_string($_POST[no_bcklkt]);
		$ajukan=mysql_real_escape_string($_POST[diajukan]);
		if($_POST[pengajuan]!=""){$pengajuan=" `pengajuan` = '$_POST[pengajuan]', ";}else{$pengajuan="`pengajuan`=null, ";}
		if($_POST[disetujui]!=""){$disetujui=" `disetujui` = '$_POST[disetujui]', ";}else{$disetujui=" `disetujui`=null, ";}
		if($_POST[pencairan]!=""){$pencairan=" `pencairan` = '$_POST[pencairan]', ";}else{$pencairan=" `pencairan`=null, ";}
		if($_POST[spm_terima]!=""){$terima_spm=" `terima_spm` = '$_POST[spm_terima]', ";}else{$terima_spm=" `terima_spm`=null, ";}
		if($_POST[uang_masuk]!=""){$uang_msk=" `uang_msk` = '$_POST[uang_masuk]', ";}else{$uang_msk=" `uang_msk`=null, ";}
        $qry1=mysql_query("UPDATE tbl_exim_bclkt SET
		`no_bclkt`='$bclkt',
		`ajukan` = '$ajukan',
		$pengajuan
		$disetujui
		$pencairan
		$terima_spm
		$uang_msk
		`status` = '$_POST[status]',
		`note`='$note'
		WHERE id='$_POST[id]'
		");
        if ($qry1) {
            
            echo "<script>swal({
  title: 'Data Telah diUbah',
  text: 'Klik Ok untuk melanjutkan',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    window.location.href='?p=Data-BCLKT';
  }
});</script>";
        } else {
           echo "<script>swal({
  title: 'Data Gagal diUbah',
  text: 'Klik Ok untuk melanjutkan',
  type: 'warning',
  }).then((result) => {
  if (result.value) {
    window.location.href='?p=Data-BCLKT';
  }
});</script>"; 
        }
    }
$qCI=mysql_query("SELECT * FROM tbl_exim_bclkt WHERE id='$_GET[id]' LIMIT 1");
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
			<input type="hidden" name="id" value="<?php echo $_GET[id]; ?>">
			<div class="col-md-6">
			<div class="form-group">
				<label for="no_ci" class="col-sm-3 control-label">No BCLKT</label>
				<div class="col-sm-4">
					<input name="no_bcklkt" type="text" class="form-control" id="no_bcklkt" value="<?php echo $dCI[no_bclkt];?>" placeholder="No BCL-KT" required>
				</div>
			</div>
			<div class="form-group">
				<label for="diajukan" class="col-sm-3 control-label">Diajukan</label>
				<div class="col-sm-3">
					<input name="diajukan" type="text" class="form-control" id="diajukan" value="<?php echo $dCI[ajukan]; ?>" placeholder="">
				</div>
			</div>	
			<div class="form-group">
				<label for="tgl_si" class="col-sm-3 control-label">Tgl Pengajuan</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="pengajuan" class="form-control pull-right" id="datepicker" placeholder="0000-00-00" value="<?php echo $dCI[pengajuan]; ?>" autocomplete="off"/>
					</div>
				</div>
			</div>				
			<div class="form-group">
				<label for="tgl_peb" class="col-sm-3 control-label">Tgl Disetujui</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="disetujui" class="form-control pull-right" id="datepicker2" placeholder="0000-00-00" value="<?php echo $dCI[disetujui]; ?>" autocomplete="off"/>
					</div>
				</div>
			</div>	           				
			<div class="form-group">
				<label for="tgl_peb" class="col-sm-3 control-label">Tgl Pencairan</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="pencairan" class="form-control pull-right" id="datepicker3" placeholder="0000-00-00" value="<?php echo $dCI[pencairan]; ?>" autocomplete="off"/>
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
						<input type="text" name="spm_terima" class="form-control pull-right" id="datepicker4" placeholder="0000-00-00" value="<?php echo $dCI[terima_spm]; ?>" autocomplete="off"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_peb" class="col-sm-3 control-label">Uang Masuk</label>
				<div class="col-sm-4">
					<div class="input-group date">
						<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
						<input type="text" name="uang_masuk" class="form-control pull-right" id="datepicker5" placeholder="0000-00-00" value="<?php echo $dCI[uang_msk]; ?>" autocomplete="off"/>
					</div>
				</div>
			</div>
			<div class="form-group" hidden>
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
					<textarea name="note" class="form-control" id="note" placeholder="Note..."><?php echo $dCI[note]; ?></textarea>
				</div>
			</div>
			</div>
		</div>
		<div class="box-footer">
			<div class="col-sm-2">
				
				<button type="submit" class="btn btn-social btn-linkedin" name="edit">Ubah <i class="fa fa-edit"></i></button>
				
			</div>
			<button type="button" class="btn btn-default pull-right" name="save" Onclick="window.location='?p=Data-BCLKT'">Kembali <i class="fa fa-cycle"></i></button>
		</div>
		<!-- /.box-footer -->


	</form>
</div>           
