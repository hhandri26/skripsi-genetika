<?php 
session_start();
if( !isset( $_SESSION["login"])){
	header("Location: login.php");
	exit;
}
//error_reporting(0);
require 'koneksi.php';

$jumlahDataPerHalaman = 2;
$result_halaman = (mysqli_query($kon, "SELECT * FROM libur"));
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

$result = mysqli_query($kon, "SELECT * FROM libur WHERE kd_libur LIKE '%$cari%' OR nik LIKE '%$cari%' LIMIT $awalData,$jumlahDataPerHalaman");



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

    <title>Halaman Libur</title>

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
                            <a class="nav-link" href="admin.php">
                                <span data-feather="file"></span>
                                Data admin
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="karyawan.php">
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
                <div class="row">
                    <div class="col-md-12"> 
                        <a href="libur_tambah.php" class="btn btn-info">Tambah Data Libur</a>
                        <form action="" method="Post">
		
							<input type="text" name="keyword" size="40" autofocus="" placeholder="Masukkan Nik" autocomplete="off">
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


                    </div>
                    <div class="col-md-12">
                    <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
								<th>Kode Libur</th>
								<th>Nik</th>
								<th>Nama</th>
								<th>Tanggal</th>
								<th>Hari</th>
								<th>Keterangan</th>
								<th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                           
						<?php 

						if(mysqli_num_rows($result)){

						while( $row = mysqli_fetch_assoc($result)) {
						?>
								<tr>
									<td><?= $row["kd_libur"]; ?></td>
									<td><?= $row["nik"]; ?></td>
									<td><?= $row["nama_karyawan"]; ?></td>
									<td><?= date('m-d-Y', strtotime($row["tanggal"])) ?></td>
									<td><?= $row["hari"]; ?></td>
									<td><?= $row["keterangan"]; ?></td>
									<td>
										<a href="libur_ubah.php?kd_libur=<?= $row["kd_libur"]; ?>">ubah</a> |
										<a href="libur_hapus.php?kd_libur=<?= $row["kd_libur"]; ?>" onclick="return confirm('yakin ?')">hapus</a>
									</td>
								</tr>
							<?php  }}else{
								echo '<tr><td colspan="6" align="center"><i>Data Tidak Ditemukan</i></td></tr>';
							} ?>
                        </tbody>
                    </table>
                </div>

                    </div>

                </div>
               







            </main>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

</body>

</html>