<?php
$ganti= $_POST['template'];

?>
<?php
	
?>
<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1">
<div class="box box-info">	
		<div class="box-header with-border">
			<h3 class="box-title">Data Packing</h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<?php
     
     ?>
		<div class="box-body">
			<div class="col-md-6">
			<div class="form-group">
				<label for="bon" class="col-sm-3 control-label">Bon Order</label>
				<div class="col-sm-4">
				  <input name="bon" type="text" id="bon" class="form-control" onchange="window.location='index1.php?p=Data-Packing-NOW&amp;bon='+this.value"  value="<?php echo $_GET['bon'];?>" size="20"/>
				</div>
			</div>
			
			<div class="form-group">
				<label for="byer" class="col-sm-3 control-label">Buyer</label>
				<div class="col-sm-6">
					<select name="byer" id="byer" class="form-control"  onchange="window.location='index1.php?p=Data-Packing-NOW&amp;bon=<?php echo $_GET['bon'];?>&amp;byer='+this.value">
      <option value="">PILIH</option>
      <?php 
		$sqlDB2="SELECT s.ORDERPARTNERBRANDCODE  FROM SALESORDER s WHERE s.CODE='$_GET[bon]'";
		$stmt=db2_exec($conn1,$sqlDB2, array('cursor'=>DB2_SCROLLABLE));
		while($rowdb2 = db2_fetch_assoc($stmt)){			
	   ?>
		<option value="<?php echo trim($rowdb2['ORDERPARTNERBRANDCODE']); ?>" <?php if(trim($rowdb2['ORDERPARTNERBRANDCODE'])==$_GET['byer']){ echo "SELECTED"; } ?>><?php echo $rowdb2['ORDERPARTNERBRANDCODE']; ?></option>					
	  <?php } ?>
      
    </select>
				</div>
			</div>
			<div class="form-group">
				<label for="nopo" class="col-sm-3 control-label">PO No.</label>
				<div class="col-sm-5">
				  <select name="nopo" class="form-control" onchange="window.location='index1.php?p=Data-Packing-NOW&amp;bon=<?php echo $_GET['bon'];?>&amp;byer=<?php echo $_GET['byer']; ?>&amp;nopo='+this.value">
				    <option value="">PILIH</option>
					<?php 
		$sql1DB2="SELECT s.EXTERNALREFERENCE AS PO1,sl.EXTERNALREFERENCE AS PO2 FROM SALESORDER s
				LEFT JOIN SALESORDERLINE sl ON s.CODE=sl.SALESORDERCODE 
				WHERE s.CODE ='$_GET[bon]' AND s.ORDERPARTNERBRANDCODE='$_GET[byer]'
				GROUP BY sl.EXTERNALREFERENCE,s.EXTERNALREFERENCE";
		$stmt1=db2_exec($conn1,$sql1DB2, array('cursor'=>DB2_SCROLLABLE));
		while($row1db2 = db2_fetch_assoc($stmt1)){	
			if($row1db2['PO2']!=""){ $POLG=$row1db2['PO2'];}else{ $POLG=$row1db2['PO1']; }
	   ?>
		<option value="<?php echo urlencode($POLG);?>" <?php if(urldecode($_GET['nopo'])==$POLG){ echo "SELECTED";} ?>><?php echo $POLG;?></option>				
	  <?php } ?>
					</select>
				</div>
			</div>	
			<div class="form-group">
				<label for="itm" class="col-sm-3 control-label">Item </label>
				<div class="col-sm-5">
				  <select name="itm" id="itm" class="form-control"
onchange="window.location='index1.php?p=Data-Packing-NOW&amp;bon=<?php echo $_GET['bon'];?>&amp;byer=<?php echo $_GET['byer']; ?>&amp;nopo=<?php echo urlencode($_GET['nopo']); ?>&amp;itm='+this.value">
				    <option value="">PILIH</option>
				   	<?php 
			$npo=urldecode($_GET['nopo']);		  
		$sql2DB2="SELECT CONCAT(trim(sl.SUBCODE02),trim(sl.SUBCODE03)) AS ITM, o.LONGDESCRIPTION AS ITMADS  FROM SALESORDER s
LEFT JOIN SALESORDERLINE sl ON s.CODE=sl.SALESORDERCODE 
LEFT JOIN ORDERITEMORDERPARTNERLINK o ON 
(sl.SUBCODE01=o.SUBCODE01  AND sl.SUBCODE02=o.SUBCODE02 AND sl.SUBCODE03=o.SUBCODE03 AND sl.SUBCODE04=o.SUBCODE04 AND 
sl.SUBCODE05=o.SUBCODE05  AND sl.SUBCODE06=o.SUBCODE06 AND sl.SUBCODE07=o.SUBCODE07 AND sl.SUBCODE08=o.SUBCODE08 AND 
sl.SUBCODE09=o.SUBCODE09 AND sl.SUBCODE10 =o.SUBCODE10 AND sl.ITEMTYPEAFICODE =o.ITEMTYPEAFICODE )
WHERE s.CODE ='$_GET[bon]' AND s.ORDERPARTNERBRANDCODE='$_GET[byer]' 
AND (sl.EXTERNALREFERENCE ='$npo' OR s.EXTERNALREFERENCE ='$npo' )
GROUP BY sl.SUBCODE02,sl.SUBCODE03,o.LONGDESCRIPTION";
		$stmt2=db2_exec($conn1,$sql2DB2, array('cursor'=>DB2_SCROLLABLE));
		while($row2db2 = db2_fetch_assoc($stmt2)) { ?>			  
				    <option value="<?php echo $row2db2['ITM'];?>" <?php if($row2db2['ITM']==$_GET['itm']){ echo "SELECTED"; }?>><?php echo $row2db2['ITM']." | ".$row2db2['ITMADS'];?></option>
		<?php } ?>	    
			      </select>
				</div>
			</div>
			<div class="form-group">
				<label for="warna" class="col-sm-3 control-label">Warna</label>
				<div class="col-sm-6">
				  <select name="warna" id="warna" class="form-control" onchange="window.location='index1.php?p=Data-Packing-NOW&amp;bon=<?php echo $_GET['bon'];?>&amp;byer=<?php echo $_GET['byer'];?>&amp;nopo=<?php echo urlencode($_GET['nopo']);?>&amp;itm=<?php echo $_GET['itm'];?>&amp;wrn='+this.value">
				    <option value="">PILIH</option>
				     <?php  
		$sql3DB2="SELECT u.LONGDESCRIPTION, sl.ORDERLINE  FROM SALESORDER s
LEFT JOIN SALESORDERLINE sl ON s.CODE=sl.SALESORDERCODE 
LEFT JOIN USERGENERICGROUP u ON sl.SUBCODE05 = u.CODE 
WHERE s.CODE ='$_GET[bon]' AND s.ORDERPARTNERBRANDCODE='$_GET[byer]' 
AND (sl.EXTERNALREFERENCE ='$_GET[nopo]' OR s.EXTERNALREFERENCE ='$_GET[nopo]' ) AND CONCAT(trim(sl.SUBCODE02),trim(sl.SUBCODE03))='$_GET[itm]'";
		$stmt3=db2_exec($conn1,$sql3DB2, array('cursor'=>DB2_SCROLLABLE));
		while($row3db2 = db2_fetch_assoc($stmt3)) { ?>
						    <option value="<?php echo $row3db2['ORDERLINE'];?>" <?php if($row3db2['ORDERLINE']==$_GET['wrn']){echo"selected";}?>><?php echo $row3db2['LONGDESCRIPTION'];?></option>
				  <?php } ?>
			      </select>
				</div>
			</div>
			</div>
			<div class="col-md-6">
			<div class="form-group">
				<label for="lot" class="col-sm-3 control-label">ProdOrder</label>
				<div class="col-sm-3">
				  <select name="lot" id="lot" class="form-control"  onchange="window.location='index1.php?p=Data-Packing-NOW&amp;bon=<?php echo $_GET['bon'];?>&amp;byer=<?php echo $_GET['byer'];?>&amp;nopo=<?php echo urlencode($_GET['nopo']);?>&amp;itm=<?php echo $_GET['itm'];?>&amp;wrn=<?php echo $_GET['wrn'];?>&amp;lot='+this.value">
				    <option value="">PILIH</option>
				    <?php  
		$sql4DB2="SELECT CODE FROM PRODUCTIONDEMAND p WHERE p.PROJECTCODE='$_GET[bon]' AND p.ORIGDLVSALORDERLINEORDERLINE='$_GET[wrn]' AND ITEMTYPEAFICODE ='KFF'";
		$stmt4=db2_exec($conn1,$sql4DB2, array('cursor'=>DB2_SCROLLABLE));
		while($row4db2 = db2_fetch_assoc($stmt4)) { ?>
				    <option value="<?php echo $row4db2['CODE'];?>" <?php if($row4db2['CODE']==$_GET['lot']){echo"selected";}?>><?php echo $row4db2['CODE'];?></option>
					 <?php } ?> 
				   </select>
				</div>
				<div class="col-sm-6">
				Posisi:  	
				</div>	
			</div>	
			<div class="form-group">
				<label for="lot" class="col-sm-3 control-label">ProdDemand</label>
				<div class="col-sm-3">
				  <select name="lot" id="lot" class="form-control"  onchange="window.location='index1.php?p=Data-Packing-NOW&amp;bon=<?php echo $_GET['bon'];?>&amp;byer=<?php echo $_GET['byer'];?>&amp;nopo=<?php echo urlencode($_GET['nopo']);?>&amp;itm=<?php echo $_GET['itm'];?>&amp;wrn=<?php echo $_GET['wrn'];?>&amp;lot=<?php echo $_GET['lot'];?>&amp;lot1='+this.value">
				    <option value="">PILIH</option>
				    <?php  
		$sql4DB2="SELECT CODE FROM PRODUCTIONORDER p WHERE p.DEMANDLIST  LIKE '%$_GET[lot]%' ";
		$stmt4=db2_exec($conn1,$sql4DB2, array('cursor'=>DB2_SCROLLABLE));
		while($row4db2 = db2_fetch_assoc($stmt4)) { ?>
				    <option value="<?php echo $row4db2['CODE'];?>" <?php if($row4db2['CODE']==$_GET['lot1']){echo"selected";}?>><?php echo $row4db2['CODE'];?></option>
					 <?php } ?> 
				   </select>
				</div>
			</div>		
				
			<div class="form-group">
				<label for="packing" class="col-sm-3 control-label">Packing</label>
				<div class="col-sm-2">
				  <select name="packing" id="packing" class="form-control" onchange="window.location='index1.php?p=Data-Packing-NOW&amp;bon=<?php echo $_GET['bon'];?>&amp;byer=<?php echo $_GET['byer'];?>&amp;nopo=<?php echo urlencode($_GET['nopo']);?>&amp;itm=<?php echo $_GET['itm'];?>&amp;wrn=<?php echo $_GET['wrn'];?>&amp;lot=<?php echo $_GET['lot'];?>&amp;lot1=<?php echo $_GET['lot1'];?>&amp;pk='+this.value">
				    <option value="">PILIH</option>
				    <option value="Rolls" <?php if($_GET['pk']=="Rolls"){echo "SELECTED";} ?> >Rolls</option>
				    <option value="Bales" <?php if($_GET['pk']=="Bales"){echo "SELECTED";} ?> >Bales</option>
			      </select>
				</div>
			</div>
			<div class="form-group">
				<label for="gudang" class="col-sm-3 control-label">Gudang</label>
				<div class="col-sm-4">
				<?php 
		$sql5DB2="SELECT  trim(p.WAREHOUSELOCATIONCODE) AS TEMPAT FROM BALANCE p WHERE p.LOTCODE ='$_GET[lot1]' AND p.ITEMTYPECODE ='KFF' AND LOGICALWAREHOUSECODE ='M031' LIMIT 1";
		$stmt5=db2_exec($conn1,$sql5DB2, array('cursor'=>DB2_SCROLLABLE));
		$row5db2 = db2_fetch_assoc($stmt5); ?>	
					<input name="gudang" type="text" class="form-control" id="gudang" value="<?php echo $row5db2['TEMPAT'];?>" placeholder="Tempat">
				</div>
			</div>
			<div class="form-group">
				<label for="payment" class="col-sm-3 control-label">Templete</label>
				<div class="col-sm-2">
				  <select name="template" id="template" class="form-control">
				    <option value="1" <?php if($ganti=="1"){echo "SELECTED";}?>>1</option>
				    <option value="2" <?php if($ganti=="2"){echo "SELECTED";}?>>2</option>
				    <option value="3" <?php if($ganti=="3"){echo "SELECTED";}?>>3</option>
			      </select>				  
				</div>
				<div class="col-sm-2"><input type="submit" name="ganti" id="ganti" value="ganti" class="btn btn-default pull-right"/></div>
			</div>	
			</div>
			

		</div>		
		<!-- /.box-footer -->
</div>	
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header with-border"><h3 class="box-title">Detail Data</h3></div>
			<div class="box-body">
<?php if($_POST['template']=="" or $_POST['template']=="1"){?>
<?php
$sqlT1DB2="SELECT COUNT(b.ELEMENTSCODE) AS ROLL, ROUND(SUM(b.BASEPRIMARYQUANTITYUNIT),2) AS BERAT,ROUND(SUM(b.BASESECONDARYQUANTITYUNIT),2) AS YARD FROM BALANCE b WHERE b.LOTCODE ='$_GET[lot1]' AND ITEMTYPECODE ='KFF' AND LOGICALWAREHOUSECODE ='M031'
";
$stmtT1=db2_exec($conn1,$sqlT1DB2, array('cursor'=>DB2_SCROLLABLE));
$rowkk1= db2_fetch_assoc($stmtT1);	
?>
  *<b> Total Roll <?php echo $rowkk1['ROLL']; ?> ,Total Berat <?php echo number_format($rowkk1['BERAT'],'2'); ?> Kg, Total Yard <?php echo number_format($rowkk1['YARD'],'2'); ?></b><br><br>
<table id="example5" class="table table-bordered table-hover table-striped" width="100%">
	<thead class="bg-green">
    <tr>
      <th><div align="center">LOT</div></th>
      <th><div align="center">PACK NO</div></th>
      <th><div align="center">BALES NO</div></th>
      <th><div align="center">KGS</div></th>
      <th><div align="center">YDS</div></th>
      <th><div align="center">PCS</div></th>
      <th><div align="center">UKURAN (FLATKNIT)</div></th>
      <th><div align="center">GW</div></th>
      <th><div align="center">KET(EXTRA QTY)</div></th>
    </tr>
	</thead>
	<tbody>
   <?php
	$no=1;
	$n=1;
	$c=0;
	$sqlC1DB2="SELECT * FROM BALANCE b WHERE b.LOTCODE ='$_GET[lot1]' AND ITEMTYPECODE ='KFF' AND LOGICALWAREHOUSECODE ='M031' ORDER BY b.ELEMENTSCODE ASC";
	$datacek=db2_exec($conn1,$sqlC1DB2, array('cursor'=>DB2_SCROLLABLE));
	while($rowd = db2_fetch_assoc($datacek)) {			
		    $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
			if($_GET['pk']=="Rolls"){$gw=0.6;}else{$gw=0.2;}
		
			$sqlC2DB2="SELECT ITXVIEWSTOCKBALANCEKFF.ITEMELEMENTCODE,ITXVIEWSTOCKBALANCEKFF.PROJECTCODE,QUALITYREASON.LONGDESCRIPTION 
			FROM DB2ADMIN.ITXVIEWSTOCKBALANCEKFF ITXVIEWSTOCKBALANCEKFF LEFT OUTER JOIN 
       		DB2ADMIN.QUALITYREASON QUALITYREASON ON ITXVIEWSTOCKBALANCEKFF.QUALITYREASONCODE=QUALITYREASON.CODE 
			WHERE ITXVIEWSTOCKBALANCEKFF.ITEMELEMENTCODE='".$rowd['ELEMENTSCODE']."' AND
			ITXVIEWSTOCKBALANCEKFF.PROJECTCODE='".$rowd['PROJECTCODE']."'
			ORDER BY ITXVIEWSTOCKBALANCEKFF.CREATIONDATETIME DESC";
	        $data2cek=db2_exec($conn1,$sqlC2DB2, array('cursor'=>DB2_SCROLLABLE));
			$rw2d = db2_fetch_assoc($data2cek);
			
		 ?> 
   
    <tr>
      <td align="center" ><?PHP echo $rowd['LOTCODE']; ?></td>
      <!--<td align="center" ><?PHP if($_GET['pk']=="Rolls" and substr($rowd['ELEMENTSCODE'],0,1)!="2"){echo substr($rowd['ELEMENTSCODE'],8,5);}else{echo"-";} ?></td>
      <td align="center" ><?PHP if($_GET['pk']=="Bales" and substr($rowd['ELEMENTSCODE'],0,1)!="2"){echo substr($rowd['ELEMENTSCODE'],8,5);}else{echo"-";} ?></td>-->
	  <td align="center" ><?PHP if($_GET['pk']=="Rolls"){echo substr($rowd['ELEMENTSCODE'],8,5);}else{echo"-";} ?></td>
      <td align="center" ><?PHP if($_GET['pk']=="Bales"){echo substr($rowd['ELEMENTSCODE'],8,5);}else{echo"-";} ?></td>	
      <td align="right" ><?PHP echo number_format(round($rowd['BASEPRIMARYQUANTITYUNIT'],2),'2','.',','); ?></td>
      <td align="right" ><?PHP echo number_format(round($rowd['BASESECONDARYQUANTITYUNIT'],2),'2','.',','); ?></td>
      <td align="center" ><?PHP if($rowd['netto']==""){echo"-";}else{echo $rowd['netto'];} ?></td>
      <td align="center" ><?PHP if($rowd['ukuran']==""){echo"-";}else{echo $rowd['ukuran']."CM";} ?></td>
      <td align="right" ><?PHP if($rowd['BASEPRIMARYQUANTITYUNIT']==""){echo"-";}else{echo number_format(round($rowd['BASEPRIMARYQUANTITYUNIT'],2)+$gw,'2','.',',');} ?></td>
      <td align="right" ><?PHP 
		if (trim($rw2d['LONGDESCRIPTION']) != ''){
			if(trim($rw2d['LONGDESCRIPTION'])=="FOC"){
				echo 'FOC';
			}else if(trim($rw2d['LONGDESCRIPTION'])=="Sisa Ganti Kain" or trim($rw2d['LONGDESCRIPTION'])=="Sisa MOQ" 
					 or trim($rw2d['LONGDESCRIPTION'])=="Sisa Produksi" or trim($rw2d['LONGDESCRIPTION'])=="Sisa Toleransi"){
				echo 'SISA';
			}
			else{
				echo '-';
			}
			
		}
			else {
	  			echo '-'; }
	  //if (trim($rw2d['LONGDESCRIPTION']) != ''){
	  // 			echo $rw2d['LONGDESCRIPTION']; } 
	  //		else if (substr(trim($rw2d['PROJECTCODE']),0,3)=='OPN' or substr(trim($rw2d['PROJECTCODE']),0,3)=='STO'){
      //				echo 'Booking';}
	  //		else if (substr(trim($rw2d['PROJECTCODE']),0,3)=='RPE'){
	  //			echo 'Ganti Kain';  }
	  //		else {
	  //			echo '-'; } ?></td>
    </tr>
    
  <?php 
	if($rowd['sisa']=="SISA" or $rowd['sisa']=="FKSI" or $rowd['sisa']=="FOC"){
		 $kgs="0";
		 $yds="0";}else{
		 $kgs=round($rowd['BASEPRIMARYQUANTITYUNIT'],2);
		 $yds=round($rowd['BASESECONDARYQUANTITYUNIT'],2);
	 }
		 $totkgs=$totkgs+$kgs;
		 $totyds=$totyds+$yds;
		 if($rowd['sisa']=="SISA" or $rowd['sisa']=="FKSI"){
			 $rol="0";
		 }else{
			 $rol="1";
		 }
		 $trol=$trol+$rol;
	$no++;  }?>
	</tbody>
	<tfoot>
     <tr>
      <td align="center" ><strong>Total</strong></td>
      <td align="center" ><b><?php echo $trol; ?> Roll</b></td>
      <td align="right" >&nbsp;</td>
      <td align="right" ><b><?php echo number_format($totkgs,'2'); ?> Kgs</b></td>
      <td align="right" ><b><?php echo number_format($totyds,'2'); ?> Yds</b></td>
      <td align="center" >&nbsp;</td>
      <td align="center" >&nbsp;</td>
      <td align="center" >&nbsp;</td>
      <td align="center" >&nbsp;</td>
    </tr>  
    <tfoot>
  </table>
  <?php }else if($_POST['template']=="2"){ ?>
  <?php
$sqlT1DB2="SELECT COUNT(b.ELEMENTSCODE) AS ROLL, ROUND(SUM(b.BASEPRIMARYQUANTITYUNIT),2) AS BERAT,ROUND(SUM(b.BASESECONDARYQUANTITYUNIT),2) AS YARD FROM BALANCE b WHERE b.LOTCODE ='$_GET[lot1]' AND ITEMTYPECODE ='KFF' AND LOGICALWAREHOUSECODE ='M031'
";
$stmtT1=db2_exec($conn1,$sqlT1DB2, array('cursor'=>DB2_SCROLLABLE));
$rowkk1= db2_fetch_assoc($stmtT1);
?>
  *<b> Total Roll <?php echo $rowkk1['ROLL']; ?> ,Total Berat <?php echo number_format($rowkk1['BERAT'],'2'); ?> Kg, Total Yard <?php echo number_format($rowkk1['YARD'],'2'); ?></b><br><br>
<table id="example5" class="table table-bordered table-hover table-striped" width="100%">
	<thead class="bg-purple">
    <tr>
      <th><div align="center">LOT NO.</div></th>
      <th><div align="center">C/No</div></th>
      <th><div align="center">Qty</div></th>
      <th><div align="center">FOC</div></th>
      <th><div align="center">Yard</div></th>
      <th><div align="center">WeiKg</div></th>
      <th><div align="center">Meter</div></th>
    </tr>
	</thead>
	<tbody>
   <?php    
	$no=1;
	$n=1;
	$c=0;
	$sqlC1DB2="SELECT * FROM BALANCE b WHERE b.LOTCODE ='$_GET[lot1]' AND ITEMTYPECODE ='KFF' AND LOGICALWAREHOUSECODE ='M031' ORDER BY b.ELEMENTSCODE ASC";
	$datacek=db2_exec($conn1,$sqlC1DB2, array('cursor'=>DB2_SCROLLABLE));
	while($rowd = db2_fetch_assoc($datacek)) {	
		
		    $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
			if($_GET['pk']=="Rolls"){$gw=0.6;}else{$gw=0.2;}
		 ?> 
    
    <tr>
      <td align="center" ><?PHP echo $rowd['LOTCODE']; ?></td>
      <td align="center" ><?PHP if($_GET['pk']=="Rolls"){echo substr($rowd['ELEMENTSCODE'],8,5);}else{echo"-";} ?></td>
      <td align="right" ><?PHP echo number_format(round($rowd['BASEPRIMARYQUANTITYUNIT'],2),'2','.',','); ?></td>
      <td align="right" ><?PHP 
	  if($rowd['sisa']=="FOC"){
	  echo $rowd['sisa'];}elseif($rowd['sisa']=="SISA" or $rowd['sisa']=="FKSI"){echo "SISA";}elseif($rowd['sisa']=="BS"){echo "BS";}else{echo"-";} ?></td>
      <td align="right" ><?PHP echo number_format(round($rowd['BASESECONDARYQUANTITYUNIT'],2),'2','.',','); ?></td>
      <td align="right" ><?PHP if($rowd['BASEPRIMARYQUANTITYUNIT']==""){echo"-";}else{echo number_format(round($rowd['BASEPRIMARYQUANTITYUNIT'],2)+$gw,'2','.',',');} ?></td>
      <td align="right" ><?PHP echo number_format(round($rowd['BASESECONDARYQUANTITYUNIT'],2)*0.9144,'2','.',','); ?></td>
    </tr>
    
  <?php 
		 if($rowd['sisa']=="SISA" or $rowd['sisa']=="FKSI" or $rowd['sisa']=="FOC"){
		 $kgs="0";
		 $yds="0";}else{
		 $kgs=round($rowd['BASEPRIMARYQUANTITY'],2);
		 $yds=round($rowd['BASESECONDARYQUANTITY'],2);
	 }
		 $totkgs=$totkgs+$kgs;
		 $totyds=$totyds+$yds;
		 if($rowd['sisa']=="SISA" or $rowd['sisa']=="FKSI"){
			 $rol="0";
		 }else{
			 $rol="1";
		 }
		 $trol=$trol+$rol;
	$no++;  }?>
	</tbody>
	<tfoot>
     <tr>
      <td align="center" ><strong>Total</strong></td>
      <td align="center" ><b><?php echo $trol; ?> Roll</b></td>
      <td align="right" ><b><?php echo number_format($totkgs,'2'); ?> Kgs</b></td>
      <td align="center" >&nbsp;</td>
      <td align="right" ><b><?php echo number_format($totyds,'2'); ?> Yds</b></td>
      <td align="center" >&nbsp;</td>
      <td align="center" >&nbsp;</td>
    </tr>  
    </tfoot>
  </table>
  <?php }else if($_POST['template']=="3"){?>
<?php
$sqlT1DB2="SELECT COUNT(b.ELEMENTSCODE) AS ROLL, ROUND(SUM(b.BASEPRIMARYQUANTITYUNIT),2) AS BERAT,ROUND(SUM(b.BASESECONDARYQUANTITYUNIT),2) AS YARD FROM BALANCE b WHERE b.LOTCODE ='$_GET[lot1]' AND ITEMTYPECODE ='KFF' AND LOGICALWAREHOUSECODE ='M031'
";
$stmtT1=db2_exec($conn1,$sqlT1DB2, array('cursor'=>DB2_SCROLLABLE));
$rowkk1= db2_fetch_assoc($stmtT1);
?>
  *<b> Total Roll <?php echo $rowkk1['ROLL']; ?> ,Total Berat <?php echo number_format($rowkk1['BERAT'],'2'); ?> Kg, Total Yard <?php echo number_format($rowkk1['YARD'],'2'); ?></b><br><br>
<table id="example5" class="table table-bordered table-hover table-striped" width="100%">
    <thead class="bg-red">
	<tr>
      <th><div align="center">LOT</div></th>
      <th><div align="center">PACK NO</div></th>
      <th><div align="center">BALES NO</div></th>
      <th><div align="center">KGS</div></th>
      <th><div align="center">YDS</div></th>
      <th><div align="center">METER</div></th>
      <th><div align="center">UKURAN (FLATKNIT)</div></th>
      <th><div align="center">GW</div></th>
      <th><div align="center">KET(EXTRA QTY)</div></th>
    </tr>
	</thead>
	<tbody>
   <?php
    $no=1;
	$n=1;
	$c=0;
	$sqlC1DB2="SELECT * FROM BALANCE b WHERE b.LOTCODE ='$_GET[lot1]' AND ITEMTYPECODE ='KFF' AND LOGICALWAREHOUSECODE ='M031' ORDER BY b.ELEMENTSCODE ASC";
	$datacek=db2_exec($conn1,$sqlC1DB2, array('cursor'=>DB2_SCROLLABLE));
	while($rowd = db2_fetch_assoc($datacek)) {
		
		    $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
			if($_GET['pk']=="Rolls"){$gw=0.6;}else{$gw=0.2;}
		$sqlC2DB2="SELECT ITXVIEWSTOCKBALANCEKFF.ITEMELEMENTCODE,ITXVIEWSTOCKBALANCEKFF.PROJECTCODE,QUALITYREASON.LONGDESCRIPTION 
			FROM DB2ADMIN.ITXVIEWSTOCKBALANCEKFF ITXVIEWSTOCKBALANCEKFF LEFT OUTER JOIN 
       		DB2ADMIN.QUALITYREASON QUALITYREASON ON ITXVIEWSTOCKBALANCEKFF.QUALITYREASONCODE=QUALITYREASON.CODE 
			WHERE ITXVIEWSTOCKBALANCEKFF.ITEMELEMENTCODE='".$rowd['ELEMENTSCODE']."' AND
			ITXVIEWSTOCKBALANCEKFF.PROJECTCODE='".$rowd['PROJECTCODE']."'
			ORDER BY ITXVIEWSTOCKBALANCEKFF.CREATIONDATETIME DESC";
	        $data2cek=db2_exec($conn1,$sqlC2DB2, array('cursor'=>DB2_SCROLLABLE));
			$rw2d = db2_fetch_assoc($data2cek);
		 ?> 
    
    <tr>
      <td align="center" ><?PHP echo $rowd['LOTCODE']; ?></td>
      <!--<td align="center" ><?PHP if($_GET['pk']=="Rolls" and substr($rowd['ELEMENTSCODE'],0,1)!="2"){echo substr($rowd['ELEMENTSCODE'],8,5);}else{echo"-";} ?></td>
      <td align="center" ><?PHP if($_GET['pk']=="Bales" and substr($rowd['ELEMENTSCODE'],0,1)!="2"){echo substr($rowd['ELEMENTSCODE'],8,5);}else{echo"-";} ?></td>-->
	  <td align="center" ><?PHP if($_GET['pk']=="Rolls"){echo substr($rowd['ELEMENTSCODE'],8,5);}else{echo"-";} ?></td>
      <td align="center" ><?PHP if($_GET['pk']=="Bales"){echo substr($rowd['ELEMENTSCODE'],8,5);}else{echo"-";} ?></td>	
      <td align="right" ><?PHP echo number_format(round($rowd['BASEPRIMARYQUANTITYUNIT'],2),'2','.',','); ?></td>
      <td align="right" ><?PHP echo number_format(round($rowd['BASESECONDARYQUANTITYUNIT'],2),'2','.',','); ?></td>
      <td align="right" ><?PHP echo number_format(round($rowd['BASESECONDARYQUANTITYUNIT'],2)*0.9144,'2','.',','); ?></td>
      <td align="center" ><?PHP if($rowd['ukuran']==""){echo"-";}else{echo $rowd['ukuran']."CM";} ?></td>
      <td align="right" ><?PHP if($rowd['BASEPRIMARYQUANTITYUNIT']==""){echo"-";}else{echo number_format(round($rowd['BASEPRIMARYQUANTITYUNIT'],2)+$gw,'2','.',',');} ?></td>
      <td align="right" ><?PHP 
	 if (trim($rw2d['LONGDESCRIPTION']) != ''){
			if(trim($rw2d['LONGDESCRIPTION'])=="FOC"){
				echo 'FOC';
			}else if(trim($rw2d['LONGDESCRIPTION'])=="Sisa Ganti Kain" or trim($rw2d['LONGDESCRIPTION'])=="Sisa MOQ" 
					 or trim($rw2d['LONGDESCRIPTION'])=="Sisa Produksi" or trim($rw2d['LONGDESCRIPTION'])=="Sisa Toleransi"){
				echo 'SISA';
			}
			else{
				echo '-';
			}
			
		}
			else {
	  			echo '-'; } ?></td>
    </tr>
    
  <?php 
		 if($rowd['sisa']=="SISA" or $rowd['sisa']=="FKSI" or $rowd['sisa']=="FOC"){
		 $kgs="0";
		 $yds="0";}else{
		 $kgs=round($rowd['BASEPRIMARYQUANTITYUNIT'],2);
		 $yds=round($rowd['BASESECONDARYQUANTITYUNIT'],2);
	 }
		 $totkgs=$totkgs+$kgs;
		 $totyds=$totyds+$yds;
		 if($rowd['sisa']=="SISA" or $rowd['sisa']=="FKSI"){
			 $rol="0";
		 }else{
			 $rol="1";
		 }
		 $trol=$trol+$rol;
	$no++;  }?>
	</tbody>
	<tfoot>
     <tr>
      <td align="center" ><strong>Total</strong></td>
      <td align="center" ><b><?php echo $trol; ?> Roll</b></td>
      <td align="right" >&nbsp;</td>
      <td align="right" ><b><?php echo number_format($totkgs,'2'); ?> Kgs</b></td>
      <td align="right" ><b><?php echo number_format($totyds,'2'); ?> Yds</b></td>
      <td align="center" >&nbsp;</td>
      <td align="center" >&nbsp;</td>
      <td align="center" >&nbsp;</td>
      <td align="center" >&nbsp;</td>
    </tr>  
    </tfoot>
  </table>
	<?php } ?>				
			
			<div id="PeriksaEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  
			  </div>
				
			</div>
		</div>
	</div>
</div>
</form>	
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
<?php $qry4=sqlsrv_query($conn,"
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
	SOD.ID ASC"); ?>
<?php 

if (isset($_POST['save'])) {
        $qry1=sqlsrv_query($con,"INSERT INTO tbl_exim_pim SET
		no_pi='".$_POST['no_pi']."',
		bon_order='".$_POST['bon_order']."',
		buyer='".$_POST['buyer']."',
		messr='".$_POST['messr']."',
		consignee='".$_POST['consignee']."',
		destination='".$_POST['dest']."',
		payment='".$_POST['payment']."',
		incoterm='".$_POST['incoterm']."',
		sales_assistant='".$_POST['sales']."',
		delivery='".$_POST['tgl_delivery']."',
		author='".$_POST['author']."',
		tgl_terima='".$_POST['tgl_terima']."',
		tgl_update=now()
		");
		$cekPI=sqlsrv_query($con,"SELECT id FROM tbl_exim_pim WHERE no_pi='".$_POST['no_pi']."' ORDER BY id DESC ");
		$rcekPI=sqlsrv_fetch_array($cekPI);
		
		$po="";
		$per="";
		$kg="0";
		$yd="0";
		$pc="0";
		while($r1=sqlsrv_fetch_array($qry4,SQLSRV_FETCH_ASSOC)){ 
		if($r1['POADD']==""){$po=str_replace("'","''",$r1['PONumber']);}else{ $po=str_replace("'","''",$r1['POADD']); }
		$sqlHS1=sqlsrv_query($con,"SELECT hs_code FROM tbl_exim_code WHERE no_item='".$r1['ProductCode']."' LIMIT 1");
		$rHS1=sqlsrv_fetch_array($sqlHS1);
		if($r1['UnitName']=="yard"){$per="yd";}elseif($r1['UnitName']=="kg"){$per="kg";}elseif($r1['UnitName']=="pc"){$per="pc";}	
		if($r1['UnitName']=="kg"){$kg=$r1['QuantityToOrder'];}else{$kg=round($r1['Weight']);}
		if($r1['UnitName']=="yard"){$yd=$r1['QuantityToOrder'];}	
		$qry1=sqlsrv_query($con,"INSERT INTO tbl_exim_pim_detail SET
		id_pi='".$rcekPI['id']."',
		po='$po',
		item='".$r1['ProductCode']."',
		color='".$r1['Color']."',
		hs_code='".$rHS1['hs_code']."',
		price='".$r1['UnitPrice']."',
		per='$per',
		kg='$kg',
		yd='$yd',
		pcs='$pc'
		");
			
		}
        if ($qry1) {
            //echo "<script>alert('Data Tersimpan');</script>";
            //echo "<script>window.location.href='?p=Form-Pemeriksaan&no_mesin=$_GET[no_mesin]';</script>";
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
            echo "There's been a problem: " . mysql_error();
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