
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Import-File</title>
<style>
	.li-post-group {
		background: #f5f5f5;
		padding: 5px 10px;
		border-bottom: solid 1px #CFCFCF;
		margin-top: 5px;
	}
	.li-post-title {
		border-left: solid 4px #304d49;
		background: #a7d4d2;
		padding: 5px;
		color: #304d49;
	}
	.show-more {
	    background: #10c1b9;
	    width: 100%;
	    text-align: center;
	    padding: 10px;
	    border-radius: 5px;
	    margin: 5px;
	    color: #fff;
	    cursor: pointer;
	    font-size: 20px;
	    display: none;
	    margin: 0px;
    	margin-top: 25px;
	}
	.li-post-desc {
	    line-height: 15px !important;
	    font-size: 12px;
	    box-shadow: inset 0px 0px 5px #7d9c9b;
	    padding: 10px;
	}
	.panel-default {
	    margin-bottom: 100px;
	}
	.post-data-list {
	    max-height: 374px;
	    overflow-y: auto;
	}
	.radio-inline {
	    font-size: 20px;
	    color: #c36928;
	}
	.progress, .progress-bar{ height: 40px; line-height: 40px; display: none; }
	</style>
	<!-- Bootstrap Core Css  -->
    <link href="dist/css/xmldata/css/bootstrap.css" rel="stylesheet" />
    <!-- Font Awesome Css -->
    <link href="dist/css/xmldata/font-awesome.min.css" rel="stylesheet" />
	<!-- Bootstrap Select Css -->
    <link href="dist/css/xmldata/bootstrap-select.css" rel="stylesheet" /> 
    <!-- Custom Css --> 
    <link href="dist/css/xmldata/app_style.css" rel="stylesheet" /> 
</head>

<body>
      
	<div class="row">
      <div class="col-xs-12">
							<div class="panel panel-default">
								<div class="panel-heading bg-red">Import Konversi:</div>
								<div class="panel-body">
									
									<div class="form-group">
				                        <div class="progress">
				                            <div class="progress-bar progress-bar-primary file-progress" role="progressbar" style="width:0%">0%</div>
				                        </div>

				                        <div class="alert icon-alert with-arrow alert-success form-alter" role="alert">
											<i class="fa fa-fw fa-check-circle"></i>
											<strong> Success ! </strong> <span class="success-message"> </span>
										</div>
										<div class="alert icon-alert with-arrow alert-danger form-alter" role="alert">
											<i class="fa fa-fw fa-times-circle"></i>
											<strong> Note !</strong> <span class="warning-message"> </span>
										</div>

				                    </div>

									<form method="post" id="import_xml" enctype="multipart/form-data">
								      <div class="form-group">
								       <label>Choose XML Data File</label>
								       <input type="file" name="xml_data" id="xml_data" />
								      </div>
								      <br />
								      <div class="form-group">
								       <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-success" >Import XML Data</button>
								      </div>
								     </form>

							  </div>
		<div class="panel-body table-responsive">
            <table id="example2" class="table table-bordered table-hover table-striped" style="width: 100%;">
              <thead class="bg-blue">
                <tr align="center">
                  <td width="32">No                  </td>
                  <td width="123">KONV</td>
                  <td width="195">Tgl.                  </td>
                  <td width="193">Nip</td>
                  <td width="193">Nama</td>
                  <td width="193">Detail EKS                  </td>
                  <td width="230">Aksi                  </td>
                </tr>
              </thead>
              <tbody>
  <?php 
	$sqldt=mysql_query("SELECT * FROM tk_konv_hdr_temp ORDER BY ID_KONV DESC");
	$no=1;
	while($rowd=mysql_fetch_array($sqldt)){
		 $sqlEKS=mysql_query("SELECT COUNT(*) as jml FROM tk_konv_eks_temp WHERE ID_KONV='$rowd[ID_KONV]' GROUP BY ID_KONV ");
		 $rEKS=mysql_fetch_array($sqlEKS);		 
		?>
                <tr>
                  <td align="center" ><?php echo $no; ?></td>
                  <td align="center" ><?php echo $rowd[ID_KONV];?></td>
                  <td align="center" ><?php echo $rowd[TGL_KONV];?></td>
                  <td align="center" ><?php echo $rowd[ID_NIPER];?></td>
                  <td align="center" ><?php echo $rowd[PIMP_PERUSAHAAN];?></td>
                  <td align="center" ><?php echo $rEKS[jml];?></td>
                  <td align="center" ><a href="#" class="btn btn-danger" onclick="confirm_del('?p=koef_hapus&id=<?php echo $rowd[ID_KONV]; ?>');"><i class="fa fa-trash"></i> </a></td>
                </tr>
                <?php $no++;
  } ?>
              </tbody>
              <tfoot class="bg-red">
              </tfoot>
            </table>
            </form>
            
            <!-- Modal Popup untuk delete-->
            <div class="modal fade" id="delKonv" tabindex="-1">
              <div class="modal-dialog modal-sm">
                <div class="modal-content" style="margin-top:100px;">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                  </div>

                  <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delKonv_link">Delete</a>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
          </div>            
     	  
          </div>
							</div>
						</div>
	</div>
	
</body>
<!-- Jquery Core Js -->
    <script src="dist/js/xmldata/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="dist/js/xmldata/bootstrap.min.js"></script>

    <!-- Bootstrap Select Js -->
    <script src="dist/js/xmldata/bootstrap-select.js"></script>	
<script>

	$(document).ready(function(){
		$('#import_xml').on('submit', function(e){
			e.preventDefault();

		$.ajax({
			url:"data_upload.php",
			method:"POST",
			data: new FormData(this),
			contentType:false,
			cache:false,
			dataType: "json",
			processData:false,
			beforeSend:function(){
				$('.progress, .progress-bar').show();
				$('.file-progress').text('0%');
                $('.file-progress').css('width', '0%');
				$('#btn-submit').attr('disabled','disabled'),
				$('#btn-submit').html(' <i class="fa fa-spinner fa-pulse fa-fw"></i> Processing...');
			},
			xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('.file-progress').text(percentComplete + '%');
                        $('.file-progress').css('width', percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
			success:function(data){
				console.log(data);

				if(data['status'] == "200"){
					$('.alert-danger').hide();
					$('.alert-success').show();
					$('.success-message').html(data['message']);
				}else{
					$('.alert-success').hide();
					$('.alert-danger').show();
					$('.warning-message').html(data['message']);
				}
				
				$('#import_xml')[0].reset();
				$('#btn-submit').attr('disabled', false);
				$('#btn-submit').html('Import XML Data');
			}
		});

		});
	});
	function confirm_del(delete_url) {
                $('#delKonv').modal('show', {
                  backdrop: 'static'
                });
                document.getElementById('delKonv_link').setAttribute('href', delete_url);
              }
	</script>	
</html>  
	    