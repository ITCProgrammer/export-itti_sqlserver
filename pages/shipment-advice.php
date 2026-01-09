<?php
session_start();
include "koneksi.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Data Shipment Advice</title>
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
            <h3 class="box-title">Data Shipment Advice</h3>           
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
		<a href="?p=Form-Shipment-Advice" class="btn btn-primary pull-right" ><span class="fa fa-plus-circle"></span>
              Add Shipment Advice</a>  
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
                  <th width="193"><div align="center" style="font-size: 12px;">No Urut</div></th>
                  <th width="193">
                    <div align="center" style="font-size: 12px;">Tgl SA</div>
                  </th>
                  <th width="157"> <div align="center" style="font-size: 12px;">Consignee</div>
                  </th>
                  <th width="81"><div align="center" style="font-size: 12px;">Inv Value</div></th>
                  <th width="81"><div align="center" style="font-size: 12px;">Author</div></th>
                  <th width="81"><div align="center" style="font-size: 12px;">Action</div></th>
                </tr>
              </thead>
              <tbody>
  <?php 
	$sqldt=mysql_query("SELECT a.*,b.nm_consign,b.listno FROM tbl_exim_sa a
	LEFT JOIN tbl_exim b ON a.no_sa=b.no_sa
	WHERE DATE_FORMAT(a.tgl,'%Y')='$Thn1'
	GROUP BY a.id
	ORDER BY a.id DESC");
	$no=1;
	while($rowd=mysql_fetch_array($sqldt)){
?>
                <tr>
                  <td align="center" style="font-size: 11px;"><?php echo $no; ?></td>
                  <td align="center" style="font-size: 11px;"><?php echo $rowd[no_sa];?></td>
                  <td align="center" style="font-size: 11px;"><?php echo strtoupper($rowd[tgl]);?></td>
                  <td align="center" style="font-size: 11px;"><?php echo strtoupper($rowd[nm_consign]);?></td>
                  <td align="center" style="font-size: 11px;"><?php echo strtoupper($rowd[inv_value]);?></td>
                  <td align="center" style="font-size: 11px;"><?php echo strtoupper($rowd[author]);?></td>
                  <td align="center" style="font-size: 11px;"><div class="btn-group">  
                    <a href="#" class="btn btn-xs btn-danger <?php
                    if(($_SESSION['levelEX']=="Manager" or $_SESSION['levelEX']=="SPV")){ echo "enabled" ; }
                    else { echo "disabled" ; } ?>" onclick="confirm_del_sa('?p=formsa_hapus&id=<?php echo $rowd[id]; ?>');"><i class="fa fa-trash"></i> </a>
					<a href="?p=Edit-Shipment-Advice&id=<?php echo $rowd[id]; ?>" class="btn btn-xs btn-info <?php
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
            <div class="modal fade" id="delSA" tabindex="-1">
              <div class="modal-dialog modal-sm">
                <div class="modal-content" style="margin-top:100px;">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                  </div>

                  <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delSA_link">Delete</a>
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
              function confirm_del_sa(delete_url) {
                $('#delSA').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('delSA_link').setAttribute('href', delete_url);
              }

            </script>
  </body>

</html>
