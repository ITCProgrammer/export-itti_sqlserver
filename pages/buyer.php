<?PHP
session_start();
include "koneksi.php";

?>
<?php
//set base constant
if ($_SESSION['levelEX'] == "SPV" or $_SESSION['levelEX'] == "Staff") {

?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Buyer</title>
  </head>

  <body>
    <?php
    $dataByr = sqlsrv_query($con,"SELECT * FROM db_qc.tbl_exim_buyer ORDER BY id DESC");
    $no = 1;
    $n = 1;
    $c = 0;
    ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box table-responsive">
          <div class="box-header">
            <a href="#" data-toggle="modal" data-target="#DataBuyer" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add</a>
          </div>
          <div class="box-body">
            <table id="example2" width="100%" class="table table-bordered table-hover display">
              <thead class="btn-primary">
                <tr>
                  <th width="4%">
                    <div align="center">No</div>
                  </th>
                  <th width="20%">
                    <div align="center">NAMA</div>
                  </th>
                  <th width="37%">
                    <div align="center">ALAMAT</div>
                  </th>
                  <th width="11%">
                    <div align="center">NEGARA</div>
                  </th>
                  <th width="6%">
                    <div align="center">KODE</div>
                  </th>
                  <th width="13%">
                    <div align="center">KETERANGAN</div>
                  </th>
                  <th width="9%">
                    <div align="center">Action</div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $col = 0;
                while ($rowd = sqlsrv_fetch_array($dataByr, SQLSRV_FETCH_ASSOC)) {
                  $bgcolor = ($col++ & 1) ? 'gainsboro' : 'antiquewhite';
                ?>
                  <tr align="center" bgcolor="<?php echo $bgcolor; ?>">
                    <td><?php echo $no; ?></td>
                    <td align="left"><?php echo $rowd['nama']; ?></td>
                    <td align="left"><?php echo $rowd['alamat']; ?></td>
                    <td><?php echo $rowd['negara']; ?></td>
                    <td><?php echo $rowd['kode']; ?></td>
                    <td align="left"><?php echo $rowd['keterangan']; ?></td>
                    <td>
                      <div class="btn-group"><a href="#" id='<?php echo $rowd['id'] ?>' class="btn btn-xs btn-info buyer_edit"><i class="fa fa-edit"></i> </a><a href="#" class="btn btn-xs btn-danger" onclick="confirm_delete('?p=buyer_hapus&id=<?php echo $rowd['id']; ?>');"><i class="fa fa-trash"></i> </a></div>
                    </td>
                  </tr>
                <?php
                  $no++;
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="DataBuyer">
      <div class="modal-dialog ">
        <div class="modal-content">
          <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=simpan_buyer" enctype="multipart/form-data">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Data Buyer</h4>
            </div>
            <div class="modal-body">
              <input type="hidden" id="id" name="id">
              <div class="form-group">
                <label for="nama" class="col-md-3 control-label">Nama</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" id="nama" name="nama" required>
                  <span class="help-block with-errors"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="alamat" class="col-md-3 control-label">Alamat</label>
                <div class="col-md-6">
                  <textarea class="form-control" name="alamat" id="alamat"></textarea>
                  <span class="help-block with-errors"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="negara" class="col-md-3 control-label">Negara</label>
                <div class="col-md-5">
                  <input type="text" class="form-control" id="negara" name="negara" required>
                  <span class="help-block with-errors"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="negara" class="col-md-3 control-label">Kode</label>
                <div class="col-md-3">
                  <input type="text" class="form-control" id="kode" name="kode" required>
                  <span class="help-block with-errors"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="alamat" class="col-md-3 control-label">Keterangan</label>
                <div class="col-md-6">
                  <textarea class="form-control" name="ket" id="ket"></textarea>
                  <span class="help-block with-errors"></span>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- Modal Popup untuk Edit-->
    <div id="BuyerEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
    <!-- Modal Popup untuk delete-->
    <div class="modal fade" id="delBuyer" tabindex="-1">
      <div class="modal-dialog modal-sm">
        <div class="modal-content" style="margin-top:100px;">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
          </div>

          <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
            <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
            <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </body>

  </html>

<?php } else {
  echo 'Illegal Acces';
} ?>
<script type="text/javascript">
  function confirm_delete(delete_url) {
    $('#delBuyer').modal('show', {
      backdrop: 'static'
    });
    document.getElementById('delete_link').setAttribute('href', delete_url);
  }
</script>