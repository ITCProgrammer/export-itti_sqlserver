<?php
include("koneksi.php");
ini_set("error_reporting", 1);
if(isset($_FILES['xml_data']['name']) &&  $_FILES['xml_data']['name'] != '')
{
	$accept_ext = array('xml');
	$file_data = explode('.', $_FILES['xml_data']['name']);
	$file_ext = strtolower(end($file_data));
	if(in_array($file_ext, $accept_ext))
	{
		$xml_data = simplexml_load_file($_FILES['xml_data']['tmp_name']);
		//echo $xml_data;
	    foreach ($xml_data->HEADER as $row) {	
			//$row=$xml_data->children();
			$no_konv = $row->NO_KONVERSI;
			$tgl_konv = $row->TGL_KONVERSI;
			$niper = $row->NIPER;
			$pimp= $row->TTD_KONVERSI;
    		$sql = "INSERT INTO tk_konv_hdr_temp (ID_KONV, TGL_KONV, ID_NIPER, PIMP_PERUSAHAAN) VALUES('" . $no_konv . "','". $tgl_konv . "','" .$niper . "','" . $pimp . "')";
			$result = sqlsrv_query($con,$sql);
			if(!$result)
			{	
				$resultData['status'] = '400';
				$resultData['message'] = 'XML file have invalid data or conntion error';
				echo json_encode($resultData);
				exit;
			}
			
		}
		foreach ($xml_data->BB->DETIL_BB as $row1) {	
			$kdbj = $row1->KD_BJ; //eks
			$kdbb = $row1->KD_BB; //imp
			$nourut = $row1->NO_URUT;
			$hscode = $row1->HS_CODE;
			$urbrg = $row1->UR_BRG;
			$kdsat = $row1->KD_SAT;
			$koef = $row1->KOEFISIEN;
			$tkdg = $row1->TERKANDUNG;
			$waste = $row1->WASTE;
			$nokonv = $row1->NO_KONVERSI;
			$flubah = $$row1->FL_UBAH;
						
    		$sql1 = "INSERT INTO `tk_konv_imp_temp`(`KD_KONV_IMP`, `KD_KONV_EKS`, `NO_URUT`, `UR_BRG`, `HS_CODE`, `KD_SAT`, `JML_SAT`, `NIL_KOEFISIEN`, `NIL_KANDUNG`, `NIL_WASTE`) VALUES('" . $kdbb . "','". $kdbj . "','" .$nourut. "','".$urbrg. "','".$hscode. "','".$kdsat. "','".$flubah. "','".$koef. "','".$tkdg. "','" . $waste . "')";
			$result1 = sqlsrv_query($con,$sql1);
			if(!$result1)
			{	
				$resultData['status'] = '400';
				$resultData['message'] = 'XML file have invalid data or conntion error';
				echo json_encode($resultData);
				exit;
			}
			
		}
		foreach ($xml_data->BJ->DETIL_BJ as $row2) {	
			$nokonv = $row2->NO_KONVERSI;	
			$kdbj = $row2->KD_BJ; //eks
			$nourut = $row2->NO_URUT;
			$hscode = $row2->HS_CODE;
			$urbrg = $row2->UR_BRG;
			$kdsat = $row2->KD_SAT;
			$totbb = $row2->TOTAL_BB;
			$tkdsat = $row2->TOTAL_KD_SAT_BB;
			$flubah = $row2->FL_UBAH;
						
    		$sql2 = "INSERT INTO `tk_konv_eks_temp`(`ID_KONV`, `KD_KONV_EKS`, `NO_URUT`, `UR_BRG`, `HS_CODE`, `KD_SAT`) VALUES('" . $nokonv . "','". $kdbj . "','" .$nourut. "','".$urbrg. "','".$hscode. "','".$kdsat. "')";
			$result2 = sqlsrv_query($con,$sql2);
			if(!$result2)
			{	
				$resultData['status'] = '400';
				$resultData['message'] = 'XML file have invalid data or conntion error';
				echo json_encode($resultData);
				exit;
			}
			
		}
        $resultData['status'] = '200';
		$resultData['message'] = 'XML Data Imported Successfully';
	}
	else
	{
		$resultData['status'] = '400';
		$resultData['message'] = 'Not a Valid File Format';
	}
}
else
{
	$resultData['status'] = '400';
	$resultData['message'] = 'Please Choose XML File';
}

echo json_encode($resultData);
?>