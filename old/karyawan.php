<?php 
session_start();
if( !isset( $_SESSION["login"])){
	header("Location: login.php");
	exit;
}
//error_reporting(0);
require 'koneksi.php';

$jumlahDataPerHalaman = 4;
$result_halaman = (mysqli_query($kon, "SELECT * FROM karyawan"));
$jumlahData = mysqli_num_rows($result_halaman);
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

if( isset($_GET['halaman'])){
	$halamanAktif = $_GET['halaman'];
}else{
	$halamanAktif = 1;
}
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman ;


if( isset($_POST['cari'])) {
	$cari = $_POST['keyword'];
} else {
	$cari = '';
}

$result = mysqli_query($kon, "SELECT * FROM karyawan WHERE nik LIKE '%$cari%' OR nama_karyawan LIKE '%$cari%' LIMIT $awalData,$jumlahDataPerHalaman");



?>


<!DOCTYPE html>
<html>
<head>
	<title>Halaman karyawan</title>
</head>
<body>
<div align="center">
	<h1>Data Karyawan</h1>

	<a href="karyawan_tambah.php">Tambah Data Karyawan</a>
	<br><br>

	<form action="" method="Post">
		
		<input type="text" name="keyword" size="40" autofocus="" placeholder="Masukkan Nik . ." autocomplete="off">
		<button type="submit" name="cari">Cari</button>
	</form>
<br>
<?php if ($halamanAktif > 1) : ?>
<a href="?halaman=<?= $halamanAktif - 1; ?>">&laquo;</a>
<?php endif; ?>

<?php for($i = 1; $i <= $jumlahHalaman; $i++) : ?>
	<?php if($i == $halamanAktif) : ?>
		<a href="?halaman=<?= $i; ?>" style="font-weight: bold; color:red;"><?= $i; ?></a>
		<?php else : ?>
			<a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
		<?php endif; ?>
	<?php endfor; ?>

	<?php if ($halamanAktif < $jumlahHalaman) : ?>
<a href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
<?php endif; ?>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>No</th>
			<th>Nik</th>
			<th>Nama</th>
			<th>Area</th>
			<th>Plotting</th>
			<th>Aksi</th>
		</tr>
		<?php  ?>
<?php 

$nomor=1;

if(mysqli_num_rows($result)){


while( $row = mysqli_fetch_assoc($result)){



 ?>
		<tr>
			<td><?= $nomor++ ?></td>
			<td><?= $row["nik"]; ?></td>
			<td><?= $row["nama_karyawan"]; ?></td>
			<td><?= $row["area"]; ?></td>
			<td><?= $row["plotting"]; ?></td>
			<td>
				<a href="karyawan_ubah.php?nik=<?= $row["nik"]; ?>">ubah</a> |
				<a href="karyawan_hapus.php?nik=<?= $row["nik"]; ?>" onclick="return confirm('yakin ?')">hapus</a>
			</td>
		</tr>
	<?php  }}else{
		echo '<tr><td colspan="6" align="center"><i>Data Tidak Ditemukan</i></td></tr>';
	} ?>
	</table>

	<br><br><br>
</div>
<a href="index.php">KEMBALI</a>
</body>
</html>