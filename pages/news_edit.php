<?php
include("../koneksi.php");
    $modal_id=$_GET['id'];
    $modal=mysql_query("SELECT * FROM `tbl_news_line` WHERE id='$modal_id' ",$con);
while ($r=mysql_fetch_array($modal)) {
    ?>
<div class="modal-dialog " style="width: 90%;">
  <div class="modal-content">
    <form class="form-horizontal" name="modal_popup" data-toggle="validator" method="post" action="?p=edit_news" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Line News</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id" name="id" value="<?php echo $r[id]; ?>">
        <div class="form-group">
          <label for="line_news" class="col-md-2 control-label">Line News</label>
          <div class="col-md-10">
            <textarea name="line_news" rows="10" class="form-control" id="line_news"><?php echo $r[news_line]; ?></textarea>
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
<?php
} ?>
