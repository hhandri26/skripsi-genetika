<?php 
session_start();
if( !isset( $_SESSION["login"])){
	header("Location: login.php");
	exit;
}
require 'koneksi.php';
// apakah tombol submit sudah pernah terpakai atau belum
if (isset($_POST["submit"])) {


	$kode = htmlspecialchars($_POST["kd_libur"]);
	$nik = htmlspecialchars($_POST["nik"]);
	$nama = htmlspecialchars($_POST["nama_karyawan"]);
	$tanggal =  htmlspecialchars($_POST["tanggal"]);
	$hari = htmlspecialchars($_POST["hari"]);
	$keterangan = htmlspecialchars($_POST["keterangan"]);


	$libur = "INSERT INTO libur
VALUES 
('$kode','$nik','$nama','$tanggal','$hari','$keterangan')";
mysqli_query($kon, $libur);




// cek apakah data berhasil ditambahkan atau tidak
if( mysqli_affected_rows($kon) > 0){
	echo "
	<script>
	alert('Data Berhasil Ditambahkan');
	document.location.href = 'libur.php';
	</script>";
} else {
	echo "<script>
	alert('Data gagal Ditambahkan');
	document.location.href = 'libur.php';
	</script>";

}
}
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/css/dashboard.css">
    <script src="asset/js/jquery-3.2.1.slim.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/popper.min.js"></script>

    <title>Halaman Karyawan</title>

</head>

<body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Aplikasi</a>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="logout.php">Log out</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="index.php">
                                <span data-feather="home"></span>
                                Dashboard <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="karyawan.php">
                                <span data-feather="file"></span>
                                Data Karyawan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="libur.php">
                                <span data-feather="shopping-cart"></span>
                                Data Libur
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="shift.php">
                                <span data-feather="users"></span>
                                Data Shift
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="parameter_ubah.php">
                                <span data-feather="users"></span>
                                Data Parameter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="jadwal.php">
                                <span data-feather="bar-chart-2"></span>
                                Data Jadwal
                            </a>
                        </li>

                    </ul>


                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
			<form action="" method="post">
			

				
				<label for="kd_libur">Kode Libur :</label>
				<input type="text" name="kd_libur" id="kd_libur" class="form-control" required><br><br>

				<label for="nik">Nik :</label>
				<input type="text" name="nik" id="nik" required class="form-control"><br><br>
			
				<label for="nama_karyawan">Nama Karyawan :</label>
				<input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control"><br><br>
			
				<label for="tanggal">Tanggal :</label>
				<input type="date" name="tanggal" id="tanggal" class="form-control"><br><br>

				<label for="hari">Hari :</label>
				<input type="text" name="hari" id="hari" class="form-control"><br><br>
			
				<label for="keterangan">Keterangan :</label>
				<input type="text" name="keterangan" id="keterangan" class="form-control"><br><br>
			
				<button text="submit" name="submit"> Tambah</button>
				


			</form>
               







            </main>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

</body>

</html>