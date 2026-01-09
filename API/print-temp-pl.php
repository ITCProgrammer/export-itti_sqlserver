<?php
include '../koneksi.php';
$modal_id = $_GET['id'];
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">PACKING LIST</h3>
            <h4 class="modal-title">CI No. : <?php echo $modal_id; ?></h4>
        </div>
        <div class="modal-body">
            <h4>1. BODY ONLY</h4>
            <button class="btn btn-success" onClick="OpenInNewWindows('pages/cetak/print-packing-list.php?listno=<?php echo $modal_id; ?>','_blank')">TANPA KOP</button>
            <button class="btn btn-success" onClick="OpenInNewWindows('pages/cetak/print-packing-list-kop.php?listno=<?php echo $modal_id; ?>','_blank')">DENGAN KOP</button>
            <button class="btn btn-success" onClick="OpenInNewWindows('pages/cetak/print-packing-list-gudang.php?listno=<?php echo $modal_id; ?>','_blank')">UNTUK GUDANG</button>
            <h4>2. BODY+FLATKNIT</h4>
            <button class="btn btn-info" onClick="OpenInNewWindows('pages/cetak/not_available.php','_blank')">TANPA KOP</button>
            <button class="btn btn-info" onClick="OpenInNewWindows('pages/cetak/not_available.php','_blank')">DENGAN KOP</button>
            <button class="btn btn-info" onClick="OpenInNewWindows('pages/cetak/not_available.php','_blank')">UNTUK GUDANG</button>
            <h4>3. VERSI BUYER</h4>
            <button class="btn btn-danger" onClick="OpenInNewWindows('pages/cetak/not_available.php','_blank')">PRINT</button>

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