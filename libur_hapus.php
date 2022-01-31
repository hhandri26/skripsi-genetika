<?php 
session_start();
if( !isset( $_SESSION["login"])){
	header("Location: login.php");
}
require 'koneksi.php';

$kode = $_GET["kd_libur"];

	
	mysqli_query($kon, "DELETE FROM libur WHERE kd_libur = $kode");



if( mysqli_affected_rows($kon) > 0) {
	echo "
	<script>
	alert('Data Berhasil Dihapus');
	document.location.href = 'libur.php';
	</script>";
} else {
	echo "<script>
	alert('Data gagal Dihapus');
	document.location.href = 'libur.php';
	</script>";

}

 ?>