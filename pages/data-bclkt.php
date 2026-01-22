<?php
session_start();
include "koneksi.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Data BCLKT</title>

</head>

<body>
  <div class="row">
    <div class="col-xs-12">
      <div class="box table-responsive">
        <div class="box-header with-border">
          <h3 class="box-title">Data BCLKT</h3><br>
          <br>
          <a href="?p=Form-BCLKT" class="btn btn-primary pull-left"><span class="fa fa-plus-circle"></span>
            Tambah</a>
        </div>
        <div class="box-body">
          <table id="example2" class="table table-bordered table-hover table-striped nowrap" style="width:100%">
            <thead class="bg-red">
              <tr>
                <th width="29" rowspan="2">
                  <div align="center">No</div>
                </th>
                <th width="87" rowspan="2">
                  <div align="center">BCLKT No.</div>
                </th>
                <th colspan="2">
                  <div align="center">BCLKT</div>
                </th>
                <th colspan="3">
                  <div align="center">SKEP</div>
                </th>
                <th width="87" rowspan="2">
                  <div align="center">SPM Diterima</div>
                </th>
                <th width="72" rowspan="2">
                  <div align="center">Uang Masuk</div>
                </th>
                <th width="130" rowspan="2">
                  <div align="center">Note</div>
                </th>
                <th width="80" rowspan="2">
                  <div align="center">Action</div>
                </th>
              </tr>
              <tr>
                <th width="186">
                  <div align="center">Perhitungan</div>
                </th>
                <th width="92">
                  <div align="center">Diajukan</div>
                </th>
                <th width="98">
                  <div align="center">Pengajuan</div>
                </th>
                <th width="102">
                  <div align="center">Disetujui</div>
                </th>
                <th width="86">
                  <div align="center">Pencairan</div>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = sqlsrv_query($con, "SELECT * FROM db_qc.tbl_exim_bclkt ORDER BY pengajuan DESC");
              $akhir = strtotime("now");
              while ($r = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
                $no++;
                $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
                // $sqlck = sqlsrv_query($con, "SELECT *, GETDATE() AS tglskrng FROM db_qc.tbl_exim_bclkt ");
                // $ck = sqlsrv_num_rows($sqlck);
                // $rck = sqlsrv_fetch_array($sqlck, SQLSRV_FETCH_ASSOC);
                // $akhir = strtotime($rck[tglskrng]);

                $awal  = ($r['pengajuan'])->getTimestamp();
                // $awal_datetime = new DateTime($awal);
                $diff  = ($akhir - $awal);
                $tjam  = round($diff / (60 * 60));
                $hari  = floor($tjam / 24);

                $awal1  = $r['disetujui'] ? ($r['disetujui'])->getTimestamp() : null;
                $diff1  = ($akhir - $awal1);
                $tjam1 = round($diff1 / (60 * 60));
                $hari1  = floor($tjam1 / 24);

                $awal2  = $r['pencairan'] ? ($r['pencairan'])->getTimestamp() : null;
                $diff2  = ($akhir - $awal2);
                $tjam2  = round($diff2 / (60 * 60));
                $hari2  = floor($tjam2 / 24);

                $awal3  = $r['terima_spm'] ? ($r['terima_spm'])->getTimestamp() : null;
                $diff3  = ($akhir - $awal3);
                $tjam3  = round($diff3 / (60 * 60));
                $hari3  = floor($tjam3 / 24);
                $no_bclkt = $r['no_bclkt'];
                $sqlHitung = sqlsrv_query($con, "SELECT sum(nilai) AS tot FROM db_qc.tbl_exim_cim a
                INNER JOIN db_qc.tbl_exim_cim_detail b ON a.id=b.id_cim
                LEFT JOIN db_qc.tbl_exim_pengembalian c ON b.id=c.id_cimd
                WHERE c.sts='Ajukan' AND b.no_bclkt='".$no_bclkt."' "); // 
                $rHtg = sqlsrv_fetch_array($sqlHitung);

              ?>
                <tr bgcolor="<?php echo $bgcolor; ?>">
                  <td align="center"><?php echo $no; ?></td>
                  <td align="center"><?php echo $r['no_bclkt']; ?></td>
                  <td align="right"><a href="#" class="detail_ci_bclkt" id="<?php echo $r['no_bclkt'] ?>"><?php echo number_format($rHtg['tot'], "2", ".", ","); ?></a></td>
                  <td align="right"><?php echo number_format($r['ajukan'], "2", ".", ","); ?></td>
                  <td align="center"><?php echo $r['pengajuan'] ? $r['pengajuan']->format('Y-m-d') : null; ?></td>
                  <td align="center"><?php if ($r['disetujui'] != "") {
                                        echo $r['disetujui']->getTimestamp();
                                      } else if ($r['pengajuan'] != "") {
                                        echo '<span class="label label-danger">' . $hari . ' Hari</span>';
                                      } ?></td>
                  <td align="center"><?php if ($r['pencairan'] != "") {
                                        echo $r['pencairan']->getTimestamp();
                                      } else if ($r['disetujui'] != "") {
                                        echo '<span class="label label-danger">' . $hari1 . ' Hari</span>';
                                      } ?></td>
                  <td align="center"><?php if ($r['terima_spm'] != "") {
                                        echo $r['terima_spm']->getTimestamp();
                                      } else if ($r['pencairan'] != "") {
                                        echo '<span class="label label-danger">' . $hari2 . ' Hari</span>';
                                      } ?></td>
                  <td align="center"><?php if ($r['uang_msk'] != "") {
                                        echo $r['uang_msk']->getTimestamp();
                                      } else if ($r['terima_spm'] != "") {
                                        echo '<span class="label label-danger">' . $hari3 . ' Hari</span>';
                                      } ?></td>
                  <td><?php echo $r['note']; ?></td>
                  <td align="center">
                    <div class="btn-group">
                      <a href="#" class="btn btn-xs btn-danger <?php
                                                                if (($_SESSION['levelEX'] == "Manager" or $_SESSION['levelEX'] == "SPV")) {
                                                                  echo "enabled";
                                                                } else {
                                                                  echo "disabled";
                                                                } ?>" onclick="confirm_delBCLKT('?p=bclkt_hapus&id=<?php echo $r['id'] ?>');"><i class="fa fa-trash"></i> </a>
                      <a href="?p=edit-bclkt&id=<?php echo $r['id']; ?>" class="btn btn-xs btn-info <?php
                                                                                                    if ($_SESSION['levelEX'] == "Manager" or $_SESSION['levelEX'] == "SPV") {
                                                                                                      echo "enabled";
                                                                                                    } else {
                                                                                                      echo "disabled";
                                                                                                    } ?>"><i class="fa fa-edit"></i> </a>
                      <a href="?p=form-bclkt02&no=<?php echo $r['no_bclkt']; ?>" class="btn btn-xs btn-success <?php
                                                                                                                if ($_SESSION['levelEX'] == "Manager" or $_SESSION['levelEX'] == "SPV") {
                                                                                                                  echo "enabled";
                                                                                                                } else {
                                                                                                                  echo "disabled";
                                                                                                                } ?>" target="_blank"><i class="fa fa-search"></i> </a>
                    </div>
                  </td>
                </tr>
              <?php
              } ?>
            </tbody>
            <tfoot class="bg-red">
            </tfoot>
          </table>
          </form>

          <!-- Modal Popup untuk delete-->
          <div class="modal fade" id="delBCLKT" tabindex="-1">
            <div class="modal-dialog modal-sm">
              <div class="modal-content" style="margin-top:100px;">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                </div>

                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                  <a href="#" class="btn btn-danger" id="delBCLKT_link">Delete</a>
                  <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </div>
          <script type="text/javascript">
            function confirm_delBCLKT(delete_url) {
              $('#delBCLKT').modal('show', {
                backdrop: 'static'
              });
              document.getElementById('delBCLKT_link').setAttribute('href', delete_url);
            }
          </script>
        </div>
      </div>
    </div>
  </div>
  <div id="DetailCIBCLKT" class="modal fade modal-3d-slit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
</body>

</html>