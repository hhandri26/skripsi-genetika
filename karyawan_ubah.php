<?php 
session_start();
if( !isset( $_SESSION["login"])){
	header("Location: login.php");
	exit;
}
require 'koneksi.php';


// ambil data di url
$nik = $_GET["nik"];

$result = mysqli_query($kon, "SELECT * FROM karyawan WHERE nik = $nik");



// apakah tombol submit sudah pernah terpakai atau belum
if (isset($_POST["submit"])) {


	$nik = htmlspecialchars($_POST["nik"]);
	$nama = htmlspecialchars($_POST["nama_karyawan"]);
	$area = htmlspecialchars($_POST["area"]);
	$plotting = htmlspecialchars($_POST["plotting"]);


	mysqli_query($kon, "UPDATE karyawan SET
	nik = '$nik',
	nama_karyawan = '$nama',
	area = '$area',
	plotting = '$plotting'
	WHERE nik = '$nik'
	");



// cek apakah data berhasil diubah atau tidak
if( mysqli_affected_rows($kon) > 0){
	echo "<script>
	alert('Data Berhasil Diubah');
	document.location.href = 'karyawan.php';
	</script>";
} else {
	echo "<script>
	alert('Data gagal Diubah');
	document.location.href = 'karyawan.php';
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
                            <a class="nav-link active" href="karyawan.php">
                                <span data-feather="file"></span>
                                Data Karyawan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="libur.php">
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
				<ul>
					<?php	
				while( $data = mysqli_fetch_array($result)) :
				?>
					<li>
						<label for="nik">NIK :</label>
						<input type="text" name="nik" class="form-control"  id="nik" required value="<?= $data["nik"] ?>">
					</li>
					<li>
						<label for="nama_karyawan">Nama :</label>
						<input type="text" name="nama_karyawan" class="form-control" id="nama_karyawan" value="<?= $data["nama_karyawan"] ?>">
					</li>
					<li>
						<label for="area">Area :</label>
						<input type="text" name="area" id="area" class="form-control" value="<?= $data["area"] ?>">
					</li>
					<li>
						<label for="plotting">Plotting :</label>
						<input type="text" name="plotting" class="form-control" id="plotting" value="<?= $data["plotting"] ?>">
					</li>
					<br>
					<li>
						<button text="submit" name="submit">Ubah</button>
					</li>
					<?php endwhile; ?>
				</ul>
				


			</form>
               







            </main>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

</body>

</html>