 <?php 
 if(isset($prosess_jadwal)){
             foreach( $prosess_jadwal as $jd){
            var_dump($prosess_jadwal);
                 //var_dump($jd['nik'] .'!=='. $array_karyawan[$rand_id_karyawan]['nik'] .'&&'. $jd['tanggal'] .'!=='. $hari_ke .'&&'. $array_karyawan[$rand_id_karyawan]['tanggal_libur'] .'!=='. $hari_ke );
                 if($jd['nik'] !== $array_karyawan[$rand_id_karyawan]['nik'] && $jd['tanggal'] !== $hari_ke && $array_karyawan[$rand_id_karyawan]['tanggal_libur'] !== $hari_ke  ){
                     for ($j = 1; $j <= $jumlah_shift; $j++) {            
                         // melakukan pengacakan 
                         if($jd['kd_shift'] !== $array_shift[$j]['kd_shift']){
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
    
            }

        }else{
            for ($j = 1; $j <= $jumlah_shift; $j++) {            
                // melakukan pengacakan 
                if($jd['kd_shift'] !== $array_shift[$j]['kd_shift']){
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