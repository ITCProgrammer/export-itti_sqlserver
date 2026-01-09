<?php
if($_POST){ 
	extract($_POST);
	$id = $_POST['id'];
	$user = $_POST['username'];
	$pass = $_POST['password'];   
    $repass = $_POST['re_password']; 
    $level = $_POST['level'];
    $status = $_POST['status'];
	if($pass!=$repass)
		{
			echo " <script>alert('Not Match Re-New Password!!');window.location='?p=User';</script>";
			}else
			{
				$sqlupdate=mysqli_query($con,"UPDATE `user_login` SET 
				`user`='$user', 
				`password`='$pass',
				`level`='$level',
				`status`='$status'
				WHERE `id`='$id' LIMIT 1");
				echo " <script>window.location='?p=User';</script>";
				}
		
		}
		

?>
