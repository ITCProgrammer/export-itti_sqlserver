<?php
session_start();
include '../koneksi.php';

$id = $_GET["pk"];
$listno = $_GET["listno"];
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Details-Packing</h4>
    </div>
    <div class="modal-body">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">Item No.</th>
                    <th scope="col">Color</th>
                    <th scope="col">Lot</th>
                    <th scope="col">Roll No</th>
                    <th scope="col">Bales No</th>
                    <th scope="col">KGS</th>
                    <th scope="col">YDS</th>
                    <th scope="col">PCS</th>
                    <th scope="col">MEAS</th>
                    <th scope="col">GW</th>
                    <th scope="col">FOC</th>
                    <th scope="col"><i class="fa fa-trash"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = mysql_query(" SELECT a.id,a.sisa,a.pack,a.weight,a.yard_,a.no_roll,b.ukuran,b.netto,
                                    c.no_item,c.warna,c.no_lot from detail_pergerakan_stok a
                                    INNER JOIN tmp_detail_kite b ON a.id_detail_kj=b.id
                                    INNER JOIN tbl_kite c ON b.id_kite=c.id 
                                    WHERE a.lott='$id' AND a.refno='$listno' ORDER BY a.no_roll ASC,c.no_lot ASC");
                $no = 1;
                $n = 1;
                $c = 0;
                while ($r = mysql_fetch_array($sql)) {
                    $bgcolor = ($c++ & 1) ? '#33CCFF' : '#FFCC99';
                ?>
                    <tr bgcolor="<?php echo $bgcolor; ?>">
                        <th><?php echo $r[no_item]; ?></th>
                        <th><?php echo $r[warna]; ?></th>
                        <th><?php echo $r[no_lot]; ?></th>
                        <th><?php if ($r['pack'] == "ROLLS") {
                                echo $r[no_roll];
                            } else {
                                echo "-";
                            }; ?></th>
                        <th><?php if ($r['pack'] == "BALES") {
                                echo $r[no_roll];
                            } else {
                                echo "-";
                            }; ?></th>
                        <th><?php if ($r[sisa] != "FOC") {
                                echo $r[weight];
                            } else {
                                echo "-";
                            } ?></th>
                        <th><?php echo $r[yard_]; ?></th>
                        <th><?php if ($r[netto] != "") {
                                echo $r[netto];
                            } else {
                                echo "-";
                            } ?></th>
                        <th><?php if ($r[netto] != "") {
                                echo $r[ukuran];
                            } else {
                                echo "-";
                            } ?></th>
                        <th><?php if ($r[pack] == "ROLLS") {
                                echo $r[weight] + 0.6;
                            } else if ($r[pack] == "BALES") {
                                echo $r[weight] + 0.2;
                            } ?></th>
                        <th><?php if ($r[sisa] == "FOC") {
                                echo $r[weight];
                            } else {
                                echo "-";
                            } ?></th>
                        <th><button type="button" class="btn btn-xs btn-danger text-dark DltDtlInvc" data-pk="<?php echo $r['id'] ?>"><i class="fa fa-trash"></i></button></th>
                        <?php $n++; ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</div>