<?php 
session_start();
if( !isset( $_SESSION["login"])){
	header("Location: login.php");
	exit;
}
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require 'koneksi.php';
include 'genetika.php';

if (isset($_POST["submit"])) {

    $awal   = $_POST['tanggal_mulai'];
    $akhir  = $_POST['tanggal_selesai'];


    $a = new DateTime($awal);
    $b= new DateTime($akhir);
    $tanggal=date_diff($a,$b);
    $jumlah= (intval($tanggal->days)+1);
    // array date
    function getDatesFromRange($start, $end, $format = 'Y-m-d') {
      
        // Declare an empty array
        $array = array();
          
        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');
      
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
      
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
      
        // Use loop to store date into array
        foreach($period as $date) {                 
            $array[] = $date->format($format); 
        }
      
        // Return the array elements
        return $array;
    }
    $daterange = getDatesFromRange($_POST['tanggal_mulai'],$_POST['tanggal_selesai']);
    $_SESSION['daterange'] = $daterange;
  
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

    // get params
    $params = mysqli_query($kon, "SELECT * FROM parameter ");
    $row_params = mysqli_fetch_row($params);
    $individu   = $row_params[1];
    $iterasi    = $row_params[2];
    $pc         = $row_params[3];
    $pm         = $row_params[4];


    // prosess
    $penjadwalan = new GenetikaPenjadwalan;
    $penjadwalan->setUkuranPopulasi($individu);
    $penjadwalan->setJmlHari($jumlah);
    //$penjadwalan->setCrossoverRate($_POST['crossoverRate']);
    $penjadwalan->setMutationRate($pm);
    $penjadwalan->setMaksimalGen($iterasi);
    $nama_anggota = $penjadwalan->prosesPenjadwalanGA();

   
    $_SESSION['anggota'] = $nama_anggota;

    if(isset($_SESSION['jml_hari'])){
        $jml_hari = $_SESSION['jml_hari'];
    }
    if(isset($_SESSION['ukuran_populasi'])){
    $ukuran_populasi = $_SESSION['ukuran_populasi'];
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

    <title>Halaman Jadwal</title>

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
            <?php
                echo '<table class="table table-striped table-sm"">';
                echo '<tr>
                    <td>Populasi<td>
                    <td> : <td>
                    <td>'.$penjadwalan->getUkuranPopulasi().'<td>
                </tr>';
                echo '<tr>
                    <td>Jumlah Hari<td>
                    <td> : <td>
                    <td>'.$penjadwalan->getJmlHari().'<td>
                </tr>';
                echo '<tr>
                    <td>Mutation Rate<td>
                    <td> : <td>
                    <td>'.$penjadwalan->getMutationRate().'<td>
                </tr>';
                echo '<tr>
                    <td>Max Generasi<td>
                    <td> : <td>
                    <td>'.$penjadwalan->getMaksimalGen().'<td>
                </tr>';
               
                echo '<tr>
                    <td>Iterasi<td>
                    <td> : <td>
                    <td>'.$nama_anggota['iterasi'].'<td>
                </tr>';
                echo '<tr>
                    <td>Fitness<td>
                    <td> : <td>
                    <td>'.$nama_anggota['fitness'].'<td>
                </tr>';
                echo '<tr>
                    <td>Waktu Eksekusi<td>
                    <td> : <td>
                    <td>'.implode(" ",$nama_anggota['exec']).'<td>
                </tr>';
                echo '<tr>
                    <td>Kesesuaian<td>
                    <td> : <td>
                    <td>'.$nama_anggota['akurasi'].' %<td>
                </tr>';
                echo '<table>';
                ?>
               

            </div>
            
            <div class="col-md-12">
                <div class="table-responsive">
                    <?php
                        echo '<table class="table table-bordered mt-3" align="center" cellspacing="0" cellpadding="2">';
                        echo '<tr>
                            <td align="center">Tgl</td>
                            <td align="center">Shift</td>
                            <td colspan="8" align="center">Daftar Anggota</td>
                        </tr>';
                        for ($i=0; $i < ($penjadwalan->getJmlHari()*3); $i++) {
                            if ($i % 3 == 0) {
                                echo '<tr><td align="center" rowspan="3">'. (($i/3)+1) .'</td>';
                            }
                            echo '<td align="center">' .(($i % 3) + 1). '</td>';
                            //$bg_color = "";
                            for ($j=0; $j < 8; $j++) {
                                echo '<td bgcolor="' .$nama_anggota['kromosom'][$j]['bg']. '">' .$nama_anggota['kromosom'][$j]['nama']. '</td>' ;
                            }
                            array_splice($nama_anggota['kromosom'], 0, 8);
                            echo '</tr>';
                        }
                        echo '</table>';
                    ?>
                </div>

            </div>

            <a href="cetak.php" target="_blank" class="btn btn-success btn-icon-split float-right">
                    <span class="icon text-white-50">
                    <i class="fa fa-print"></i>
                    </span>
                    <span class="text">Print Jadwal</span>
                </a>








            </main>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

</body>

</html>