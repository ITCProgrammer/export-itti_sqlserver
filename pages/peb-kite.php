<?php
session_start();
include "koneksi.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Data Commercial Invoice KITE</title>

  </head>

  <body>
    <div class="row">
      <div class="col-xs-12">
        <div class="box table-responsive">
          <div class="box-header with-border">
            <h3 class="box-title">Data Commercial Invoice KITE</h3><br>
            <!--<br>
            <a href="?p=Form-Commercial-Manual" class="btn btn-primary pull-left" ><span class="fa fa-plus-circle"></span>
              Tambah</a>-->
          </div>
          <div class="box-body">
            <table id="example2" class="table table-bordered table-hover table-striped nowrap" style="width:100%">
              <thead class="bg-red">
                <tr>
                  <th width="29">
                    <div align="center">No</div>
                  </th>
                  <th width="87">
                    <div align="center">No Invoice</div>
                  </th>
                  <th width="92">
                    <div align="center">Fasilitas</div>
                  </th>
                  <th width="98">
                    <div align="center">Tidak Diajukan</div>
                  </th>
                  <th width="102">
                    <div align="center">Pengembalian</div>
                  </th>
                  <th width="86">
                    <div align="center">Tgl Export</div>
                  </th>
                  <th width="87"> <div align="center">Tgl LHPRE</div>
                  </th>
                  <th width="72"> <div align="center">Tgl Expiry</div>
                  </th>
                  <th width="130"> <div align="center">BCL.KT02</div>
                  </th>
                  <th width="130"><div align="center">Tgl Pengajuan</div></th>
                  <th width="130"><div align="center">Keterangan</div></th>
                  <th width="130"><div align="center">Action</div></th>
                </tr>
              </thead>
              <tbody>
                <?php
  $sql=mysqli_query($con,"SELECT *,tgl_lhpre + INTERVAL 180 DAY as tgl_expiry,DATEDIFF(tgl_lhpre + INTERVAL 180 DAY,now()) as hari FROM tbl_exim_cim WHERE fasilitas='KITE' or fasilitas='UMUM(KITE)' ORDER BY fasilitas,etd ASC");
  while ($r=mysqli_fetch_array($sql)) {
      $no++;
      $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite'; 
	  $sqlck=mysqli_query($con,"SELECT * FROM tbl_exim_cim_detail WHERE id_cim=$r[id] ");
	  $ck=mysqli_num_rows($sqlck);
	  $rCIMD=mysqli_fetch_array($sqlck);
	  if($r['hari']>0){$jmlhari=$r['hari']." Hari lagi";}else{$jmlhari="sudah EXPIRED";}
	  if($r['hari']>=30){$warna=" label-success";}else if($r['hari']>=0){$warna=" label-warning";}else{$warna=" label-danger";}
	  $sqlTA=mysqli_query($con,"SELECT sum(nilai) as tajukan FROM tbl_exim_pengembalian a
	  INNER JOIN tbl_exim_cim_detail b ON a.id_cimd=b.id
	  INNER JOIN tbl_exim_cim c ON b.id_cim=c.id
	  WHERE c.no_invoice='".$r['no_invoice']."' AND a.sts='Tidak diajukan'");
	  $rTA=mysqli_fetch_array($sqlTA);
	  $sqlAJ=mysqli_query($con,"SELECT sum(nilai) as tajukan FROM tbl_exim_pengembalian a
	  INNER JOIN tbl_exim_cim_detail b ON a.id_cimd=b.id
	  INNER JOIN tbl_exim_cim c ON b.id_cim=c.id
	  WHERE c.no_invoice='".$r['no_invoice']."' AND a.sts='Ajukan'");
	  $rAJ=mysqli_fetch_array($sqlAJ);
	  $sqlTglA=mysqli_query($con,"SELECT * FROM tbl_exim_bclkt WHERE no_bclkt='".$rCIMD['no_bclkt']."'");
	  $rTglA=mysqli_fetch_array($sqlTglA);
	 ?>
                <tr bgcolor="<?php echo $bgcolor; ?>">
                  <td align="center"><?php echo $no; ?></td>
                  <td><a href="?p=Detail-CI-KITE&id=<?php echo $r['id']; ?>"><?php echo $r['no_invoice']; ?></a></td>
                  <td align="center"><?php echo $r['fasilitas']; ?></td>
                  <td align="right"><?php echo number_format($rTA['tajukan'],"2",".",",");?></td>
                  <td align="right"><?php echo number_format($rAJ['tajukan'],"2",".",",");?></td>
                  <td align="center"><?php echo $r['tgl_peb']; ?><br>
                  <em><?php echo $r['no_peb']; ?></em></td>
                  <td align="center"><?php echo $r['tgl_lhpre']; ?></br>
                  <em><?php echo $r['no_lhpre']; ?></em></td>
                  <td align="center"><?php echo $r['tgl_expiry']; ?><br><?php if($rTglA['pengajuan']!=""){}else {if($r['tgl_expiry']!="") { ?><span class="label <?php echo $warna;?>"><?php echo $jmlhari; ?></span><?php } }?></td>
                  <td align="center"><?php echo $rCIMD['no_bclkt']; ?></td>
                  <td align="center"><?php echo $rTglA['pengajuan']; ?></td>
                  <td align="center"><?php echo $r['note']; ?></td>
                  <td align="center"><a href="#" id='<?php echo $r['id'] ?>' class="btn btn-sm btn-info cimkite_edit"><i class="fa fa-edit"></i> </a></td>
                </tr>
                <?php
  } ?>
              </tbody>
              <tfoot class="bg-red">
              </tfoot>
            </table>
            </form>
            <!-- Modal Popup untuk Edit--> 
			<div id="CIMKiteEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
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
