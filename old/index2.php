<?php

session_start();
if( !isset( $_SESSION["login"])){
	header("Location: login.php");
	exit;
}
require 'koneksi.php';



?>


<!DOCTYPE html>
<html>
<head>
	<title>Halaman Utama</title>
	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	<link rel="stylesheet" href="asset/css/sigin.css">
	<script src="asset/js/jquery-3.2.1.slim.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
	<script src="asset/js/popper.min.js"></script>
</head>
<body>
<div align="center">
	<a href="karyawan.php">Data Karyawan</a>
	<a href="libur.php">Data Libur</a>
	<a href="shift.php">Data Shift</a>
	<a href="parameter_ubah.php">Data Parameter</a>
	<a href="jadwal.php">Data Jadwal</a>
	<a href="logout.php">Logout</a>
</div>
<br><br><hr>
	<h1 align="center">Visi</h1><br><br>
	<h3 align="center">“Menjadi perusahaan penyedia layanan terbaik yang terpercaya dan berkualitas global”</h3><br><br>
	<hr>
	<h1 align="center">Misi</h1><br><br>
	<h3 align="center">A.	Menyediakan layanan yang nyaman dan aman bagi pengguna jasa dengan mengacu kepada standar global. <br>
B.	Mengedepankan pengelolahan bisnis yang profesional, berintegritas, dam kompetitif.
</h3>

</body>
</html>