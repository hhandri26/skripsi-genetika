<?php 
session_start();
if( !isset( $_SESSION["login"])){
	header("Location: login.php");
	exit;
}
require 'koneksi.php';

if (isset($_POST["submit"])) {

$awal= $_POST['tanggal_mulai'];
$akhir= $_POST['tanggal_selesai'];


$a = new DateTime($awal);
$b= new DateTime($akhir);
$tanggal=date_diff($a,$b);
$jumlah= (intval($tanggal->days)+1);

echo "$jumlah ";
// populasi
$populasi = 0;

// ambil data karyawan
$array_karyawan = array();
$karyawan = mysqli_query($kon, "SELECT a.*, b.tanggal, b.hari, b.keterangan FROM karyawan a LEFT JOIN libur b ON a.nik = b.nik ");

while( $row = mysqli_fetch_assoc($karyawan)){
    $kr['nik']              = $row["nik"];
    $kr['nama_karyawan']    = $row["nama_karyawan"];
    $kr['area']             = $row["area"];
    $kr['plotting']         = $row["plotting"];
    $kr['tanggal_libur']    = $row["tanggal"];
    $kr['keterangan_libur'] = $row["keterangan"];
    $populasi++;
    array_push($array_karyawan,$kr);

}

// hitung jumlah hari jadwal
$startTimeStamp = strtotime($awal);
$endTimeStamp = strtotime($akhir);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400;
$numberDays = intval($numberDays);

// ambil jumlah shift
$jumlah_shift = 0;
$array_shift = array();
$shift = mysqli_query($kon, "SELECT * FROM shift ");

while( $row = mysqli_fetch_assoc($shift)){
    $sf['kd_shift']         = $row["kd_shift"];
    $sf['nama_shift']       = $row["nama_shift"];
    $sf['jam_mulai']        = $row["jam_mulai"];
    $sf['jam_selesai']      = $row["jam_selesai"];
    $jumlah_shift++;
    array_push($array_shift,$sf);

}
$prosess_jadwal = array();
    // inisialisasi
   $month =date("m",strtotime(str_replace('-','/', $awal)));
   $year = date("Y",strtotime(str_replace('-','/', $awal)));
   
    for ($i = 1; $i <= $numberDays; $i++) {
        $hari_ke            =  date("d-m-Y",strtotime($month.'/'.$i.'/'.$year));
       
        $count_prosess = count($prosess_jadwal);
        
            for ($j = 0; $j <= $jumlah_shift; $j++) {            
                // melakukan pengacakan 
                $rand_id_karyawan   =  mt_rand(0,$populasi);
                    $dt['nik']              = $array_karyawan[$rand_id_karyawan]['nik'];
                    $dt['nama_karyawan']    = $array_karyawan[$rand_id_karyawan]['nama_karyawan'];
                    $dt['tanggal']          = $hari_ke;
                    $dt['kd_shift']         =$array_shift[$j]['kd_shift'];
                    $dt['nama_shift']       = $array_shift[$j]['nama_shift'];
                    $dt['jam_mulai']        = $array_shift[$j]['jam_mulai'];
                    $dt['jam_selesai']      = $array_shift[$j]['jam_selesai'];

                    array_push($prosess_jadwal,$dt);

                
               
    
               
          
            

        }
        
        
        
       

      

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
                            <a class="nav-link" href="shift.php">
                                <span data-feather="users"></span>
                                Data Shift
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="parameter_ubah.php">
                                <span data-feather="users"></span>
                                Data Parameter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="jadwal.php">
                                <span data-feather="bar-chart-2"></span>
                                Data Jadwal
                            </a>
                        </li>

                    </ul>


                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
			

	

			<form action="" method="post">
		
			
				<label for="tanggal_mulai">Tanggal Mulai:</label>
				<input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai"><br><br>
				<label for="tanggal_selesai">Tanggal Selesai:</label>
				<input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai"><br><br>


				<button text="submit" name="submit"> Proses</button>

			</form>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nik</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Shift</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            <?php 

                            $nomor=1;

                            if(isset($prosess_jadwal)){


                            foreach($prosess_jadwal as $row){
                                if($row['nik'] !=='' && $row['nama_karyawan'] !=='' &&  $row['nama_shift'] ){



                            ?>
                                    <tr>
                                        <td><?= $nomor++ ?></td>
                                        <td><?= $row['nik']; ?></td>
                                        <td><?= $row['nama_karyawan']; ?></td>
                                        <td><?= $row['tanggal']; ?></td>
                                        <td><?= $row['nama_shift']; ?></td>
                                        <td><?= $row['jam_mulai']; ?></td>
                                        <td><?= $row['jam_selesai']; ?></td>
                                    
                                    </tr>
                                <?php  }}}else{
                                    echo '<tr><td colspan="6" align="center"><i>Data Tidak Ditemukan</i></td></tr>';
                                } ?>
                        </tbody>
                    </table>
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