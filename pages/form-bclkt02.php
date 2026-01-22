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
            <h3 class="box-title">FORMULIR BCL-KT02</h3>            
          </div>
          <div class="box-body">
            <table id="example2" class="table table-bordered table-hover table-striped nowrap" >
              <theader class="">
				<tr>
                  <td colspan="7" align="center">PENYELESAIAN</td>
                  <td colspan="8" align="center">PEMAKAIAN BARANG DAN/ATAU BAHAN ASAL IMPOR</td>
                </tr>
                <tr>
                  <td colspan="5" align="center">DATA DOK. PEMBERITAHUAN</td>
                  <td colspan="2" align="center">DATA DOK. PENUNJANG</td>
                  <td rowspan="2" align="center">No. Urut</td>
                  <td rowspan="2" align="center">Kode Jenis Dokumen</td>
                  <td rowspan="2">-Ke.Kantor<br />
                  -No.&amp;Tgl.</td>
                  <td rowspan="2" align="center">Seri Brg Ke</td>
                  <td rowspan="2" align="center"><p>-Kode Bahan Baku<br />
                    -HS<br />
                    -Uraian Barang
                  </td>
                  <td rowspan="2" align="center">Jumlah Satuan</td>
                  <td rowspan="2" align="center">Nilai CIF (Rp)</td>
                  <td rowspan="2" align="center">-BM<br />
                    -Cukai</td>
                </tr>
                <tr>
                  <td align="center">No</td>
                  <td align="center">Kode Jenis Dokumen</td>
                  <td width="186" align="right">-Kd. Kantor<br />
                  -No.&amp; Tgl.</td>
                  <td width="92" align="right">-Kode Barang Jadi<br />
                    -Seri Barang/ HS<br />
                    -Uraian Barang<br />
                    -HP/HPS/SHP/BB<br />
                    -Nilai(Rp)</td>
                  <td width="98" align="center">Jumlah Satuan</td>
                  <td width="102" align="center">No. &amp; Tanggal<br />
                    -LPBC/LHP<br />
                    -Berita Acara<br />
                    -Bukti Bayar<br />
                    -Faktur Penjualan</td>
                  <td width="86" align="center">-Jml Satuan/<br />
                    -Jml Nilai (Rp)</td>
                </tr>
                <tr>
                  <td align="center">1</td>
                  <td align="center">2</td>
                  <td align="right">3</td>
                  <td align="right">4</td>
                  <td align="center">5</td>
                  <td align="center">6</td>
                  <td align="center">7</td>
                  <td align="center">&nbsp;</td>
                  <td align="center">8</td>
                  <td>9</td>
                  <td align="center">10</td>
                  <td align="center">11</td>
                  <td align="center">12</td>
                  <td align="center">13</td>
                  <td align="center">14</td>
                </tr>
				</theader>
				<tbody>
                    <?Php $sql=sqlsrv_query($con, "SELECT 
              a.*, 
              agregat.nilai_, 
              agregat.kandung, 
              agregat.qtyeks, 
              agregat.cif
          FROM db_qc.tbl_exim_cim a
          INNER JOIN (
              SELECT 
                  b.id_cim,
                  b.no_urut_peb,
                  c.no_pend_pib,
                  c.urutan,
                  ROUND(SUM(c.nilai), 0) AS nilai_,
                  SUM(CAST(c.bb_kandung AS NUMERIC(18, 2))) AS kandung,
                  SUM(c.qty_eks) AS qtyeks,
                  ROUND(SUM(CAST(c.bb_kandung AS NUMERIC(18, 2)) * c.price * c.kurs), 0) AS cif
              FROM db_qc.tbl_exim_cim_detail b
              LEFT JOIN db_qc.tbl_exim_pengembalian c ON b.id = c.id_cimd
              WHERE c.sts = 'Ajukan' AND b.no_bclkt = '$_GET[no]'
              GROUP BY b.id_cim, b.no_urut_peb, c.no_pend_pib, c.urutan
          ) AS agregat ON a.id = agregat.id_cim
          ORDER BY a.no_peb, agregat.no_urut_peb, agregat.no_pend_pib, agregat.urutan ASC;");
					$no="1";
					while($row=sqlsrv_fetch_array($sql)){
					$sql1=sqlsrv_query($con, "SELECT 
              a.HS_CODE AS hs_eks,
              b.HS_CODE AS hs_imp 
          FROM db_qc.tk_konv_eks_temp a 
          INNER JOIN db_qc.tk_konv_imp_temp b 
              ON a.ID_KONV = SUBSTRING(b.KD_KONV_EKS, 1, 10)
          WHERE a.ID_KONV = '$row[konversi]' 
            AND SUBSTRING(a.KD_KONV_EKS, 12, 30) = ''$row[itm_eks]'' 
            AND b.KD_KONV_IMP = '$row[kode_fs]' ");
					$row1=sqlsrv_fetch_array($sql1);	
					$sql2=sqlsrv_query($con, "SELECT TOP 1 * FROM db_qc.tbl_exim_import WHERE no_pend='$row[no_pend_pib]' ");
					$row2=sqlsrv_fetch_array($sql2);	
					?>
                <tr>
                  <td align="center"><?php echo $no; ?> </td>
                  <td align="center">1</td>
                  <td align="center">?<br /><?php echo $row['no_peb']."/<br>".$row['tgl_peb']->format('Y-m-d'); ?></td>
                  <td align="right"><?php echo $row['konversi'].$row['itm_eks'];?><br><?php echo $row['no_urut_peb']." / ".$row1['hs_eks'];?><br>KNITTED FABRIC</td>
                  <td align="right"><?php echo number_format($row['qtyeks'],"4",".",","); ?><br>KGM</td>
                  <td align="center"><?php echo $row['no_lhpre']; ?><br><?php echo $row['tgl_lhpre']->format('Y-m-d'); ?></td>
                  <td align="right"><?php echo number_format($row['qtyeks'],"2",".",","); ?><br />
                  KGM</td>
                  <td align="center">&nbsp;</td>
                  <td align="center">3</td>
                  <td align="center"><?php echo $row2['kode_kantor']; ?><br />
                  <?php echo $row['no_pend_pib']." / "; ?><br /><?php echo $row2['tgl_pend']; ?></td>
                  <td align="center"><?php echo $row['urutan']; ?></td>
                  <td align="left"><?php echo $row['kode_fs']; ?><br />
                    <?php echo $row1['hs_imp']; ?><br />
                    YARN</td>
                  <td align="right"><?php echo number_format($row['kandung'],"4",".",","); ?><br />
                  KGM</td>
                  <td align="right"><?php echo number_format($row['cif'],"0",".",","); ?></td>
                  <td align="right"><?php echo number_format($row['nilai_'],"0",".",","); ?></br>0</td>
                </tr>
                <?php $no++;} ?>
              </tbody>
              <tfoot class="bg-red">
              </tfoot>
            </table>
            </form>
            
            
          </div>
        </div>
      </div>
    </div>
	
  </body>

</html>
