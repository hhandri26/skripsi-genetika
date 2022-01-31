<?php 
session_start();
if( !isset( $_SESSION["login"])){
	header("Location: login.php");
}
require 'koneksi.php';

$nik = $_GET["nik"];

	
	mysqli_query($kon, "DELETE FROM karyawan WHERE nik = $nik");



if( mysqli_affected_rows($kon) > 0) {
	echo "
	<script>
	alert('Data Berhasil Dihapus');
	document.location.href = 'karyawan.php';
	</script>";
} else {
	echo "<script>
	alert('Data gagal Dihapus');
	document.location.href = 'karyawan.php';
	</script>";

}

 ?>