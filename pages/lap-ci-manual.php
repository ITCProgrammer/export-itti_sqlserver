<?php
session_start();
include "koneksi.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Data Commercial Invoice Manual</title>

  </head>

  <body>
    <div class="row">
      <div class="col-xs-12">
        <div class="box table-responsive">
          <div class="box-header with-border">
            <font size="+2" class="box-title">Data Commercial Invoice Manual</font>
          </div>
          <div class="box-body">
            <table id="example2" class="table table-bordered table-hover table-striped" style="width:100%">
              <thead class="bg-red">
                <tr>
                  <th width="29">
                    <div align="center">No</div>
                  </th>
                  <th width="87">
                    <div align="center">No Invoice</div>
                  </th>
                  <th width="186">
                    <div align="center">Consignee</div>
                  </th>
                  <th width="92">
                    <div align="center">Fasilitas</div>
                  </th>
                  <th width="98">
                    <div align="center">Tgl SJ</div>
                  </th>
                  <th width="102">
                    <div align="center">No SI</div>
                  </th>
                  <th width="86">
                    <div align="center">No PEB</div>
                  </th>
                  <th width="87"> <div align="center">No B/L</div>
                  </th>
                  <th width="72"> <div align="center">ETD</div>
                  </th>
                  <th width="99"> <div align="center">Progress</div>
                  </th>
                  <th width="130"><div align="center">Next</div></th>
                  <th width="130"> <div align="center">Note</div>
                  </th>
                  <th width="80">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
  $sql=sqlsrv_query($con,"SELECT * FROM tbl_exim_cim ORDER BY etd ASC");
  while ($r=sqlsrv_fetch_array($sql)) {
      $no++;
      $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite'; 
	  $sqlck=sqlsrv_query($con,"SELECT * FROM tbl_exim_cim_detail WHERE id_cim='".$r['id']."' ");
	  $ck=sqlsrv_num_rows($sqlck);
	 ?>
                <tr bgcolor="<?php echo $bgcolor; ?>">
                  <td align="center"><?php echo $no; ?></td>
                  <td align="center"><a href="?p=Form-Detail-CI-Manual&id=<?php echo $r['id']; ?>"><?php echo $r['no_invoice']; ?></a></td>
                  <td align="center"><?php echo $r['consignee']; ?></td>
                  <td align="center"><?php echo $r['fasilitas']; ?></td>
                  <td align="center"><?php echo $r['tgl_sj']; ?></td>
                  <td align="center"><?php echo $r['no_si']; ?></td>
                  <td align="center"><?php echo $r['no_peb']; ?></td>
                  <td align="center"><?php echo $r['no_bl']; ?></td>
                  <td align="center"><?php echo $r['etd']; ?></td>
                  <td align="center">
				  <?php
	  				if($r['no_bl']!=""){
						 echo "<span class='label label-primary'>KONFIRMASI B/L</span>";}else
					if($r['no_sj']!=""){
			 			 echo "<span class='label label-primary'>KIRIM CARGO</span>";}else
					if($r['no_peb']!=""){
						 echo "<span class='label label-primary'>BUAT PEB</span>";}else	
	  				if($r['no_si']!=""){
						 echo "<span class='label label-primary'>BOOKING</span>";}else
					{	 echo "<span class='label label-primary'>BUAT CI/PL</span>";}	
					  ?>
				  </td>
                  <td align="center"><?php
	  		 		 if($r['no_bl']!=""){
						 echo "<span class='label label-success'>BAYAR TAGIHAN</span>";}else
					if($r['no_sj']!=""){
			 			 echo "<span class='label label-success'>KONFIRMASI B/L</span>";}else
					if($r['no_peb']!=""){
						 echo "<span class='label label-success'>KIRIM CARGO</span>";}else	
	  				if($r['no_si']!=""){
						 echo "<span class='label label-success'>BUAT PEB</span>";}else
					{	 echo "<span class='label label-success'>BOOKING</span>";}
				  ?></td>
                  <td align="center"><?php echo $r['note']; ?></td>
                  <td align="center">
					<div class="btn-group">  
                    <a href="#" class="btn btn-xs btn-danger <?php
                    if(($_SESSION['levelEX']=="Manager" or $_SESSION['levelEX']=="SPV") and $ck=="0"){ echo "enabled" ; }
                    else { echo "disabled" ; } ?>" onclick="confirm_del_mohon('?p=ci_hapus&id=<?php echo $r['id']; ?>');"><i class="fa fa-trash"></i> </a>
					<a href="?p=Form-Commercial-Manual&ci=<?php echo $r['no_invoice']; ?>" class="btn btn-xs btn-info <?php
                    if($_SESSION['levelEX']=="Manager" or $_SESSION['levelEX']=="SPV"){ echo "enabled" ; }
                    else { echo "disabled" ; } ?>"><i class="fa fa-edit"></i> </a>
					</div></td>
                </tr>
                <?php
  } ?>
              </tbody>
              <tfoot class="bg-red">
              </tfoot>
            </table>
            </form>
            <!-- Modal Popup untuk Edit-->
            <div id="DetailProduksi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            </div>
            <div id="MohonBEdit" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            </div>
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
            <script type="text/javascript">
              function confirm_del_mohon(delete_url) {
                $('#delMohon').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('delMohon_link').setAttribute('href', delete_url);
              }

            </script>
          </div>
        </div>
      </div>
    </div>

  </body>

</html>
