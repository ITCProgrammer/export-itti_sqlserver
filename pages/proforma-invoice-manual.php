<?php
session_start();
include "koneksi.php";
ini_set("error_reporting", 1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Data Proforma Invoice Manual</title>

</head>

<body>
  <div class="row">
    <div class="col-xs-12">
      <div class="box table-responsive">
        <div class="box-header with-border">
          <h3 class="box-title">Data Proforma Invoice Manual</h3><br>
          <br>
          <a href="?p=Form-Invoice-Manual" class="btn btn-primary"><span class="fa fa-plus-circle"></span>
            Tambah</a> <a href="?p=Form-Invoice-Manual-NOW" class="btn btn-danger"><span class="fa fa-plus-circle"></span>
            Tambah (N.O.W)</a>
        </div>
        <div class="box-body">
          <table id="example2" class="table table-bordered table-hover table-striped" style="width:100%">
            <thead class="bg-red">
              <tr>
                <th width="32">
                  <div align="center">No</div>
                </th>
                <th width="123">
                  <div align="center">Status</div>
                </th>
                <th width="195">
                  <div align="center">Tgl. Kirim</div>
                </th>
                <th width="193">
                  <div align="center">Consignee</div>
                </th>
                <th width="230">
                  <div align="center">Dest</div>
                </th>
                <th width="157">
                  <div align="center">Term</div>
                </th>
                <th width="153">
                  <div align="center">PI No.</div>
                </th>
                <th width="81">
                  <div align="center">(Order) KGs</div>
                </th>
                <th width="81">
                  <div align="center">(Export) KGs</div>
                </th>
                <th width="81">
                  <div align="center">Sales</div>
                </th>
                <th width="81">
                  <div align="center">Author</div>
                </th>
                <th width="81">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              //   $sql=sqlsrv_query($con,"SELECT a.*,if(locate('Closed',group_concat(DISTINCT b.`status` ORDER BY b.`status` ASC))='1','Closed','On Going') as `status`,sum(b.kg) as kg FROM tbl_exim_pim  a
              // INNER JOIN tbl_exim_pim_detail b ON a.id=b.id_pi
              // WHERE b.`status`='On Going'
              // GROUP BY a.id
              // ORDER BY if(locate('Closed',group_concat(DISTINCT b.`status` ORDER BY b.`status` ASC))='1','Closed','On Going') DESC, a.tgl_terima ASC");
              $query = "SELECT 
                  a.id, 
                  a.tgl_terima, a.no_pi, a.bon_order, a.buyer, a.messr, a.consignee, a.destination, a.payment, a.incoterm, a.sales_assistant, a.delivery,
                  a.author, a.tgl_terima, a.tgl_update,
                  CASE 
                      WHEN CHARINDEX('Closed', STRING_AGG(CAST(b.status AS VARCHAR(MAX)), ',') WITHIN GROUP (ORDER BY b.status ASC)) > 0 
                      THEN 'Closed' 
                      ELSE 'On Going' 
                  END AS [status],
                  SUM(b.kg) AS kg
              FROM db_qc.tbl_exim_pim a
              INNER JOIN db_qc.tbl_exim_pim_detail b ON a.id = b.id_pi
              WHERE b.status = 'On Going'
              GROUP BY 
                  a.id, 
                  a.tgl_terima, a.no_pi, a.bon_order, a.buyer, a.messr, a.consignee, a.destination, a.payment, a.incoterm, a.sales_assistant, a.delivery,
                  a.author, a.tgl_terima, a.tgl_update
              ORDER BY 
                  [status] DESC, 
                  a.tgl_terima ASC";
              $sql = sqlsrv_query($con, $query);
              if ($sql === false) {
                die(print_r(sqlsrv_errors(), true));
              }
              while ($r = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
                $no++;
                $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
                $qAct = sqlsrv_query($con, "SELECT sum(kg) as kg FROM db_qc.tbl_exim_cim_detail WHERE no_pi='" . $r['no_pi'] . "'");
                if ($qAct === false) {
                  die(print_r(sqlsrv_errors(), true));
                }
                $dAct = sqlsrv_fetch_array($qAct, SQLSRV_FETCH_ASSOC);
                $qAct1 = sqlsrv_query($con, "SELECT sum(kg) as kg FROM db_qc.tbl_exim_pim_detail a
					INNER JOIN db_qc.tbl_exim_pim b ON a.id_pi=b.id
					WHERE a.id_pi='" . $r['id'] . "' ORDER BY a.status ASC");
                if ($qAct1 === false) {
                  die(print_r(sqlsrv_errors(), true));
                }
                $dAct1 = sqlsrv_fetch_array($qAct1, SQLSRV_FETCH_ASSOC);
              ?>
                <tr bgcolor="<?php echo $bgcolor; ?>">
                  <td align="center"><?php echo $no; ?></td>
                  <td align="center"><?php echo $r['status']; ?></td>
                  <td align="center"><?php echo $r['delivery']; ?></td>
                  <td align="center"><?php echo $r['consignee']; ?></td>
                  <td align="center"><?php echo $r['destination']; ?></td>
                  <td align="center"><?php echo $r['incoterm']; ?></td>
                  <td align="center"><a href="?p=Detail-PI-Manual&id=<?php echo $r['id'] ?>"><?php echo $r['no_pi']; ?></a></td>
                  <td align="center"><?php echo $dAct1['kg']; ?><br>(<?php echo $r['kg']; ?>)</td>
                  <td align="center"><a href="#" class="detail_ci" id="<?php echo $r['no_pi'] ?>"><?php echo round($dAct['kg'], 2); ?></a></td>
                  <td align="center"><?php echo $r['sales_assistant']; ?></td>
                  <td align="center"><?php echo $r['author']; ?></td>
                  <td align="center">
                    <a href="#" class="btn btn-sm btn-danger <?php
                                                              if ($_SESSION['levelEX'] == "Manager" or $_SESSION['levelEX'] == "SPV") {
                                                                echo "enabled";
                                                              } else {
                                                                echo "disabled";
                                                              } ?>" onclick="confirm_del_mohon('?p=pi_hapus&id=<?php echo $r['id'] ?>');"><i class="fa fa-trash"></i> </a>
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