<?php
// koneksi ke database
$kon = mysqli_connect("localhost","root","","skripsi-genetika");

// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
error_reporting(0);



?>