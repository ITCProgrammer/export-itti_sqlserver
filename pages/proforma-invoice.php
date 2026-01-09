<?php
session_start();
include "koneksi.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Data Proforma Invoice</title>
  </head>
<?php 
$Thn	= isset($_POST['thn']) ? $_POST['thn'] : '';
if($Thn!=""){$Thn1=$Thn;}else{$Thn1=date('Y');}
?>
  <body>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Data Proforma Invoice</h3>           
			<form method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" id="form1">
     <div class="box-body">
      <div class="form-group">       
		<div class="col-sm-1">
		<select name="thn" id="thn" class="form-control">
          <option value="">Pilih</option>
          <?php
                $thn_skr = date('Y');
                for ($x = $thn_skr; $x >= 2016; $x--) {
                ?>
          <option value="<?php echo $x ?>" <?php if($Thn!=""){if($x==$Thn){echo "SELECTED";}}else{if($x==$thn_skr){echo "SELECTED";}}?>><?php echo $x ?></option>
          <?php
                }
   ?>
			</select>
        </div>  
        <button type="submit" class="btn btn-success " name="cari" ><i class="fa fa-search"></i> Cari</button>
        <!-- /.input group -->
		<a href="?p=Form-Invoice" class="btn btn-primary pull-right" ><span class="fa fa-plus-circle"></span>
              Add Proforma Invoice</a>  
      </div>
    <!-- /.box-body -->
    

</div>
</form>  			  
          </div>
          <div class="box-body table-responsive">
            <table id="example2" class="table table-bordered table-hover table-striped">
              <thead class="bg-red">
                <tr>
                  <th width="32">
                    <div align="center" style="font-size: 12px;" >No</div>
                  </th>
                  <th width="123">
                    <div align="center" style="font-size: 12px;">Status</div>
                  </th>
                  <th width="195">
                    <div align="center" style="font-size: 12px;">Tgl. Terima</div>
                  </th>
                  <th width="193"><div align="center" style="font-size: 12px;">PI No.</div></th>
                  <th width="193"><div align="center" style="font-size: 12px;">BO No.</div></th>
                  <th width="193"><div align="center" style="font-size: 12px;">Buyer</div></th>
                  <th width="193">
                    <div align="center" style="font-size: 12px;">CNEE</div>
                  </th>
                  <th width="230">
                    <div align="center" style="font-size: 12px;">Dest</div>
                  </th>
                  <th width="157">
                    <div align="center" style="font-size: 12px;">Payment</div>
                  </th>
                  <th width="157"> <div align="center" style="font-size: 12px;">Term</div>
                  </th>
                  <th width="81"><div align="center" style="font-size: 12px;">KGs</div></th>
                  <th width="81"><div align="center" style="font-size: 12px;">KGS MASUK</div></th>
                  <th width="81"><div align="center" style="font-size: 12px;">LENGTH</div></th>
                  <th width="81"><div align="center" style="font-size: 12px;">DELIVERY</div></th>
                  <th width="81"><div align="center" style="font-size: 12px;">SA</div></th>
                  <th width="81"><div align="center" style="font-size: 12px;">FS</div></th>
                  <th width="81"><div align="center" style="font-size: 12px;">Author</div></th>
                </tr>
              </thead>
              <tbody>
  <?php 
	$sqldt=mysql_query("SELECT a.*,sum(qty) as qty,sum(b.length) as length,b.id as ids FROM tbl_exim_pi a
LEFT JOIN tbl_exim_pi_detail b ON a.pi_no=b.no_pi
WHERE DATE_FORMAT(tgl_terima,'%Y')='$Thn1'
GROUP BY a.id
ORDER BY a.status DESC,a.pi_no ASC");
	$no=1;
	while($rowd=mysql_fetch_array($sqldt)){
		$sqld=mysql_query("SELECT listno,b.warna,b.id from tbl_exim a
INNER JOIN tbl_exim_detail b ON a.id=b.id_list
INNER JOIN tbl_exim_pi_detail c ON b.id_pid=c.id
WHERE c.no_pi='$rowd[pi_no]' LIMIT 1");
$rd=mysql_fetch_array($sqld);	  		  
$sqlmasuk=mysql_query("SELECT sum(a.weight) as kgs,sum(a.yard_)as yds,sum(b.netto)as pcs,b.ukuran,c.user_packing ,c.warna
FROM detail_pergerakan_stok a
INNER JOIN tmp_detail_kite b ON b.id=a.id_detail_kj
INNER JOIN tbl_kite c ON c.id=b.id_kite  
WHERE refno='$rd[listno]' and  not refno=''");
$r=mysql_fetch_array($sqlmasuk);
?>
		<?php 
		$trpi=0;
  $sqlpi=mysql_query(" SELECT * FROM tbl_exim_pi_detail WHERE no_pi='$rowd[pi_no]' ORDER BY id ASC ");
  while($rpi=mysql_fetch_array($sqlpi)){	 
$sqldpi=mysql_query("SELECT listno,b.warna,b.id from tbl_exim a
INNER JOIN tbl_exim_detail b ON a.id=b.id_list
INNER JOIN tbl_exim_pi_detail c ON b.id_pid=c.id
WHERE c.id='$rpi[id]' LIMIT 1");
$rdpi=mysql_fetch_array($sqldpi);	  		  
$sqlmasukpi=mysql_query("SELECT refno,sum(a.weight) as kgs,sum(a.yard_)as yds,sum(b.netto)as pcs,b.ukuran,c.user_packing ,c.warna
FROM detail_pergerakan_stok a
INNER JOIN tmp_detail_kite b ON b.id=a.id_detail_kj
INNER JOIN tbl_kite c ON c.id=b.id_kite  
WHERE a.lott='$rdpi[id]'
GROUP BY refno ");
$rpi=mysql_fetch_array($sqlmasukpi);
  $trpi+=$rpi[kgs];
  } 
		?>
                <tr>
                  <td align="center" style="font-size: 11px;"><?php echo $no; ?></td>
                  <td align="center" style="font-size: 11px;"><?php if($rowd[status]=="Closed"){ echo strtoupper($rowd[status]);}else{echo strtoupper($rowd[status]);} ?></td>
                  <td align="center" style="font-size: 11px;"><?php echo $rowd[tgl_terima];?></td>
                  <td align="center" style="font-size: 11px;"><a href="?p=proforma_detail&amp;pi=<?php echo $rowd[pi_no]; ?>"><?php echo strtoupper($rowd[pi_no]);?></a></td>
                  <td align="center" style="font-size: 11px;"><?php echo strtoupper($rowd[bo_no]);?></td>
                  <td align="center" style="font-size: 11px;"><?php echo strtoupper($rowd[buyer]);?></td>
                  <td align="left" style="font-size: 11px;"><?php echo strtoupper($rowd[cnee]);?></td>
                  <td align="center" style="font-size: 11px;"><?php echo strtoupper($rowd[destinasi]);?></td>
                  <td align="center" style="font-size: 11px;"><?php echo strtoupper($rowd[payment]);?></td>
                  <td align="center" style="font-size: 11px;"><?php echo $rowd[incoterm];?></td>
                  <td align="center" style="font-size: 11px;"><?php if($rowd[qty]!=""){echo $rowd[qty];}else{echo"-";}?></td>
                  <td align="center" style="font-size: 11px;"><a href="#" class="open_rincian" id="<?php echo $rowd[pi_no]; ?>"><?php if($trpi!="" or $trpi!="0"){echo number_format($trpi,2,".",",");}else{echo"-";}?></a></td>
                  <td align="center" style="font-size: 11px;"><?php if($rowd[length]!=""){echo $rowd[length];}else{echo"-";}?></td>
                  <td align="center" style="font-size: 11px;"><?php echo $rowd[tgl_delivery];?></td>
                  <td align="center" style="font-size: 11px;"><?php echo strtoupper($rowd[sales_asst]);?></td>
                  <td align="center" style="font-size: 11px;"><?php echo $rowd[fasilitas];?></td>
                  <td align="center" style="font-size: 11px;"><?php echo strtoupper($rowd[author]);?><div class="btn-group">  
                    <a href="#" class="btn btn-xs btn-danger <?php
                    if(($_SESSION['levelEX']=="Manager" or $_SESSION['levelEX']=="SPV") and $ck=="0"){ echo "enabled" ; }
                    else { echo "disabled" ; } ?>" onclick="confirm_del_mohon('?p=ci_hapus&id=<?php echo $r[id] ?>');"><i class="fa fa-trash"></i> </a>
					<a href="?p=Form-Commercial-Manual&ci=<?php echo $r['no_invoice']; ?>" class="btn btn-xs btn-info <?php
                    if($_SESSION['levelEX']=="Manager" or $_SESSION['levelEX']=="SPV"){ echo "enabled" ; }
                    else { echo "disabled" ; } ?>"><i class="fa fa-edit"></i> </a>
					</div></td>
                </tr>
                <?php $no++;
  } ?>
              </tbody>
              <tfoot class="bg-red">
              </tfoot>
            </table>
            </form>
            
            <!-- Modal Popup untuk delete-->
            <div class="modal fade" id="delMohon" tabindex="-1">
              <div class="modal-dialog modal-sm">
                <div class="modal-content" style="margin-top:100px;">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                  </div>

                  <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delMohon_link">Delete</a>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>            
          </div>
        </div>
      </div>
    </div>	
	<div id="DetailPI" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
	<div id="DetailCI" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
	<div id="EditStatus" class="modal fade modal-3d-slit" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
	<script type="text/javascript">
              function confirm_del_mohon(delete_url) {
                $('#delMohon').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('delMohon_link').setAttribute('href', delete_url);
              }

            </script>
  </body>

</html>
