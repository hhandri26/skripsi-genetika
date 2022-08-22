<?php 
session_start();
if( !isset( $_SESSION["login"])){
	header("Location: login.php");
}
require 'koneksi.php';

$id = $_GET["id"];

	
	mysqli_query($kon, "DELETE FROM admin WHERE kd_admin = $id");



if( mysqli_affected_rows($kon) > 0) {
	echo "
	<script>
	alert('Data Berhasil Dihapus');
	document.location.href = 'admin.php';
	</script>";
} else {
	echo "<script>
	alert('Data gagal Dihapus');
	document.location.href = 'admin.php';
	</script>";

}

 ?>