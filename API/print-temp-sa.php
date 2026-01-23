<?php
include("../koneksi.php");
$modal_id = $_GET['id'];
$sql = sqlsrv_query($con, "SELECT *, FORMAT(GETDATE(), 'yyyy-MM-dd') AS skrg 
        FROM tbl_exim 
        WHERE id = '$modal_id'");
$r = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC);
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">SHIPMENT ADVICE</h3>
            <h4 class="modal-title">CI No. : <?php echo $r['listno']; ?></h4>
        </div>
        <div class="modal-body">
            <button class="btn btn-success" onClick="OpenInNewWindows('pages/cetak/print-sa-nk.php?id=<?php echo $modal_id; ?>&ket=<?php echo $rowd['ket']; ?>','_blank')">TANPA KOP</button>
            <button class="btn btn-success" onClick="OpenInNewWindows('pages/cetak/print-sa.php?id=<?php echo $modal_id; ?>&ket=<?php echo $rowd['ket']; ?>','_blank')">DENGAN KOP</button>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<script>
    function OpenInNewWindows(url_print) {
        window.open(url_print, '', 'width=800, height=600');
    }
</script>