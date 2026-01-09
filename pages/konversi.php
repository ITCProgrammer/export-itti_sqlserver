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
            <h3 class="box-title">Data Konversi</h3><br>            
          </div>
          <div class="box-body">
            <table id="example2" class="table table-bordered table-hover table-striped" style="width:100%">
              <thead class="bg-red">
                <tr>
                  <th width="30">
                    <div align="center">No</div>
                  </th>
                  <th width="117">
                    <div align="center">Tgl</div>
                  </th>
                  <th width="121">
                    <div align="center">No Konv</div>
                  </th>
                  <th width="139">
                    <div align="center">Hasil Produksi</div>
                  </th>
                  <th width="124">
                    <div align="center">HS Code</div>
                  </th>
                  <th width="90">
                    <div align="center">No Urut</div>
                  </th>
                  <th width="91"> <div align="center">Bahan Baku</div>
                  </th>
                  <th width="75"> <div align="center">HS Code</div>
                  </th>
                  <th width="104"> <div align="center">Koefisien</div>
                  </th>
                  <th width="136"><div align="center">Terkandung</div></th>
                  <th width="142"> <div align="center">Loss</div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
  $sql=mysql_query("SELECT
	c.TGL_KONV,
	c.ID_KONV,
	a.KD_KONV_EKS,
	a.NO_URUT AS URUT_IMP,
	a.HS_CODE AS HS_IMP,
	a.KD_KONV_IMP,
	a.NIL_KANDUNG,
	a.NIL_KOEFISIEN,
	a.NIL_WASTE,
	b.NO_URUT AS URUT_EKS,
	b.HS_CODE AS HS_EKS	
FROM
	tk_konv_imp_temp a
	LEFT JOIN tk_konv_eks_temp b ON a.KD_KONV_EKS = b.KD_KONV_EKS
	LEFT JOIN tk_konv_hdr_temp c ON b.ID_KONV = c.ID_KONV 
ORDER BY
	c.ID_KONV DESC,
	b.NO_URUT,
	a.NO_URUT ASC");
  while ($r=mysql_fetch_array($sql)) {
      $no++;
      $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
	 ?>
                <tr bgcolor="<?php echo $bgcolor; ?>">
                  <td align="center"><?php echo $no; ?></td>
                  <td align="center"><?php echo $r['TGL_KONV']; ?></td>
                  <td align="center"><?php echo $r['ID_KONV']; ?></td>
                  <td align="center"><?php echo substr($r['KD_KONV_EKS'],11,20); ?></td>
                  <td align="center"><?php echo $r['HS_EKS']; ?></td>
                  <td align="center"><?php echo $r['URUT_IMP']; ?></td>
                  <td align="center"><?php echo $r['KD_KONV_IMP']; ?></td>
                  <td align="center"><?php echo $r['HS_IMP']; ?></td>
                  <td align="center"><?php echo $r['NIL_KOEFISIEN']; ?></td>
                  <td align="center"><?php echo $r['NIL_KANDUNG']; ?></td>
                  <td align="center"><?php echo $r['NIL_WASTE']; ?></td>
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
            
          </div>
        </div>
      </div>
    </div>

  </body>

</html>
