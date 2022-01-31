<?php 
require 'koneksi.php';


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
                        <li class="nav-item ">
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
                <div class="row">
				<div class="col-md-12"> 
                        <a href="shift_tambah.php" class="btn btn-info">Tambah Data Shift</a>
                        


                    </div>
                   
                    <div class="col-md-12">
                    <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
								<th>Kode Shift</th>
								<th>Nama Shift</th>
								<th>Jam Mulai</th>
								<th>Jam Selesai</th>
								<th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                           
						<?php 

							$result = mysqli_query($kon, "SELECT * FROM shift");


							while( $row = mysqli_fetch_assoc($result)) :
							?>
								<tr>
									<td><?= $row["kd_shift"]; ?></td>
									<td><?= $row["nama_shift"]; ?></td>
									<td><?= $row["jam_mulai"]; ?></td>
									<td><?= $row["jam_selesai"]; ?></td>
									<td>
										<a href="shift_ubah.php?kd_shift=<?= $row["kd_shift"]; ?>">ubah</a> |
										<a href="shift_hapus.php?kd_shift=<?= $row["kd_shift"]; ?>" onclick="return confirm('yakin ?')">hapus</a>
									</td>
								</tr>	
							<?php endwhile; ?>
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