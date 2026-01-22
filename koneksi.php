<?php
date_default_timezone_set('Asia/Jakarta');

############### Koneksi via username & password ###############
$serverName = "10.0.0.221"; // Contoh: localhost\SQLEXPRESS
$connectionInfo = array("Database" => "db_qc", "UID" => "sa", "PWD" => "Ind@taichen2024", "CharacterSet" => "UTF-8");
$con = sqlsrv_connect($serverName, $connectionInfo);

$dt = array();
$options = array(
     "Scrollable" => SQLSRV_CURSOR_STATIC
);

if ($con) {
     echo "";
} else {
     echo "Koneksi Gagal: " . sqlsrv_errors()[0]['message'];
     die(print_r(sqlsrv_errors(), true));
}


// ############### Koneksi via Windows Authentication ###############
// $serverName = "W-DIT-000162";
// $connectionInfo = array( "Database"=>"db_qc");

// // connect
// $conn = sqlsrv_connect( $serverName, $connectionInfo);

// if( $conn ) {
//      echo "Connection established bla..bla...<br />";
// }else{
//      echo "Connection could not be established.<br />";
//      die( print_r( sqlsrv_errors(), true));
// }

// // close connection
// sqlsrv_close( $conn);


// Koneksi ke IBM
$hostname = "10.0.0.21";
$database = "NOWPRD";
$user = "db2admin";
$passworddb2 = "Sunkam@24809";
$port = "25000";
$conn_string = "DRIVER={IBM ODBC DB2 DRIVER}; HOSTNAME=$hostname; PORT=$port; PROTOCOL=TCPIP; UID=$user; PWD=$passworddb2; DATABASE=$database;";
$conn1 = db2_connect($conn_string, '', '');

if ($conn1) {
} else {
     exit("DB2 Connection failed");
}
