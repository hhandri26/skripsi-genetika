<?php 
require 'koneksi.php';

$kd = $_GET["kd_shift"];

	
	mysqli_query($kon, "DELETE FROM shift WHERE kd_shift = $kd");



if( mysqli_affected_rows($kon) > 0) {
	echo "
	<script>
	alert('Data Berhasil Dihapus');
	document.location.href = 'shift.php';
	</script>";
} else {
	echo "<script>
	alert('Data gagal Dihapus');
	document.location.href = 'shift.php';
	</script>";

}

 ?>