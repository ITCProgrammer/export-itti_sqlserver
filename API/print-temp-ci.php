<?php
session_start();
include '../koneksi.php';
$modal_id = $_GET['id'];
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">COMMERCIAL INVOICE</h3>
            <h4 class="modal-title">CI No. : <?php echo $modal_id; ?></h4>
        </div>
        <div class="modal-body">
            <h4>1. BODY ONLY</h4>
            <button class="btn btn-success" onClick="OpenInNewWindows('pages/cetak/print-invoice.php?listno=<?php echo $modal_id; ?>&ket=<?php echo $rowd['ket']; ?>')">TANPA KOP</button>
            <button class="btn btn-success" onClick="OpenInNewWindows('pages/cetak/print-invoice-kop.php?listno=<?php echo $modal_id; ?>&ket=<?php echo $rowd['ket']; ?>','_blank')">DENGAN KOP</button>
            <button class="btn btn-success" onClick="OpenInNewWindows('pages/cetak/print-invoice-foc.php?listno=<?php echo $modal_id; ?>&ket=<?php echo $rowd['ket']; ?>','_blank')">FOC</button>
            <button class="btn btn-success" onClick="OpenInNewWindows('pages/cetak/print-invoice-kop-foc.php?listno=<?php echo $modal_id; ?>&ket=<?php echo $rowd['ket']; ?>','_blank')">FOC KOP</button>
            <h4>2. BODY+FLATKNIT</h4>
            <button class="btn btn-info" onClick="OpenInNewWindows('pages/cetak/print-invoice-pcs.php?listno=<?php echo $modal_id; ?>&ket=<?php echo $rowd['ket']; ?>','_blank')">TANPA KOP</button>
            <button class="btn btn-info" onClick="OpenInNewWindows('pages/cetak/print-invoice-pcs-kop.php?listno=<?php echo $modal_id; ?>&ket=<?php echo $rowd['ket']; ?>','_blank')">DENGAN KOP</button>
            <button class="btn btn-info" onClick="OpenInNewWindows('pages/cetak/print-invoice-pcs-foc.php?listno=<?php echo $modal_id; ?>&ket=<?php echo $rowd['ket']; ?>','_blank')">FOC</button>
            <button class="btn btn-info" onClick="OpenInNewWindows('pages/cetak/print-invoice-pcs-kop-foc.php?listno=<?php echo $modal_id; ?>&ket=<?php echo $rowd['ket']; ?>','_blank')">FOC KOP</button>
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