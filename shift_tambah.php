<?php 

require 'koneksi.php';
// apakah tombol submit sudah pernah terpakai atau belum
if (isset($_POST["submit"])) {


	$kd = htmlspecialchars($_POST["kd_shift"]);
	$nama = htmlspecialchars($_POST["nama_shift"]);
	$mulai = htmlspecialchars($_POST["jam_mulai"]);
	$selesai = htmlspecialchars($_POST["jam_selesai"]);


	$query = "INSERT INTO shift
VALUES 
('$kd','$nama','$mulai','$selesai')";
mysqli_query($kon, $query);




// cek apakah data berhasil ditambahkan atau tidak
if( mysqli_affected_rows($kon) > 0){
	echo "
	<script>
	alert('Data Berhasil Ditambahkan');
	document.location.href = 'shift.php';
	</script>";
} else {
	echo "<script>
	alert('Data gagal Ditambahkan');
	document.location.href = 'shift.php';
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

    <title>Halaman Shift</title>

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
                            <a class="nav-link" href="libur.php">
                                <span data-feather="shopping-cart"></span>
                                Data Libur
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="shift.php">
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
			<li>
				<label for="kd_shift">Kode Shift :</label>
				<input type="text" name="kd_shift" class="form-control" id="kd_shift" required>
			</li>
			<li>
				<label for="nama_shift">Nama Shift:</label>
				<input type="text" name="nama_shift" class="form-control" id="nama_shift">
			</li>
			<li>
				<label for="jam_mulai">Jam Mulai :</label>
				<input type="text" name="jam_mulai" class="form-control" id="jam_mulai">
			</li>
			<li>
				<label for="jam_selesai">Jam Selesai :</label>
				<input type="text" name="jam_selesai" class="form-control" id="jam_selesai">
			</li>
			<br>
			<li>
				<button text="submit" name="submit"> Tambah</button>
			</li>
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