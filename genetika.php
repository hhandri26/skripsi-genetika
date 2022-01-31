<?php

class Genetika {
     
    private $PRAKTIKUM = 'PRAKTIKUM';
    private $TEORI = 'TEORI';
    private $LABORATORIUM = 'LABORATORIUM';
    
    private $jenisSemester;
    private $tahunAkademik;
    private $populasi;
    private $crossOver;
    private $mutasi;
    
    private $pengampu = [];
    private $individu = [[[]]];
    private $sks = [];
    private $dosen = [];
    
    private $jam = [];
    private $hari = [];
    private $idosen = [];
    
    //waktu keinginan dosen
    private $waktuDosen = [];
    private $jenisMk = []; //reguler or praktikum
    
    private $ruangLaboratorium = [];
    private $ruangReguler = [];
    private $logAmbilData;
    private $logInisialisasi;
    
    private $log;
    private $induk = [];
    
    //jumat
    private $idJumat;
    private $rangeJumat = [];
    private $kodeDhuhur;
    //private $is_waktuDosen_tidak_bersedia_empty;
    
    private $CI;
    
    //function __construct($jenisSemester, $tahunAkademik, $populasi, $crossOver, $mutasi, $idJumat, $rangeJumat, $kodeDhuhur){               
    public function __construct( $params ) { 
        
        $this->CI =& get_instance();
        
        $this->jenisSemester    = $params['jenisSemester'];
        $this->tahunAkademik    = $params['tahunAkademik'];
        $this->populasi         = intval( $params['populasi'] );
        $this->crossOver        = $params['crossOver'];
        $this->mutasi           = $params['mutasi'];
        $this->idJumat          = intval( $params['idJumat'] );
        $this->rangeJumat       = explode( '-',$params['rangeJumat'] );//$hari_jam = explode(':', $this->waktuDosen[$j][1]);
        $this->kodeDhuhur       = intval( $params['kodeDhuhur'] );
       
    }
    
    public function AmbilData()
    {
        
        $rs_data = $this->CI->db->query("
            SELECT a.id_pengampu, b.sks, a.id_dosen, b.jenis
            FROM pengampu a 
            LEFT JOIN matakuliah b ON a.id_mk = b.id_mk 
            WHERE b.semester%2 = $this->jenisSemester AND a.tahun_akademik = '$this->tahunAkademik'");
        
        $i = 0;

        foreach ($rs_data->result() as $data) {
            $this->pengampu[$i]     = intval($data->id_pengampu);
            $this->sks[$i]          = intval($data->sks);
            $this->dosen[$i]        = intval($data->id_dosen);
            $this->jenisMk[$i]      = $data->jenis;
            $i++;
        }
        
        
        
        // data jam
        $rs_jam = $this->CI->db->query("SELECT id_jam FROM jam");
        
        $i = 0;
        foreach ($rs_jam->result() as $data) {
            $this->jam[$i] = intval($data->id_jam); $i++;
        }
        
        // data hari
        $rsHari = $this->CI->db->query("SELECT id_hari FROM hari");
        $i = 0;
        foreach ($rsHari->result() as $data) {
            $this->hari[$i] = intval($data->id_hari); $i++;
        }
        
        // ruang teori
        $rsRuangReguler = $this->CI->db->query("SELECT id_ruang FROM ruang WHERE jenis = '$this->TEORI'");
        $i = 0;
        foreach ($rsRuangReguler->result() as $data) {
            $this->ruangReguler[$i] = intval($data->id_ruang); $i++;
        }
        
        // ruang lab
        $rsRuanglaboratorium = $this->CI->db->query("SELECT id_ruang FROM ruang  WHERE jenis = '$this->LABORATORIUM'");
        $i = 0;
        foreach ($rsRuanglaboratorium->result() as $data) {
            $this->ruangLaboratorium[$i] = intval($data->id_ruang);
            $i++;
        }
        
        //var_dump($this->ruangLaboratorium);
        //exit(0);
        
        // $rs_WaktuDosen = $this->CI->db->query("SELECT kode_dosen, CONCAT_WS(':',kode_hari,kode_jam) as kode_hari_jam FROM waktu_tidak_bersedia");        
        // $i             = 0;
        // foreach ($rs_WaktuDosen->result() as $data) {
        //     $this->idosen[$i]         = intval($data->kode_dosen);
        //     $this->waktuDosen[$i][0] = intval($data->kode_dosen);
        //     $this->waktuDosen[$i][1] = $data->kode_hari_jam;
        //     $i++;
        // }  
     
        
    }
    
    
    public function Inisialisai()
    {
        
        $jumlahPengampu = count($this->pengampu);        
        $jumlahJam = count($this->jam);
        $jumlahHari = count($this->hari);
        $jumlahRuangReguler = count($this->ruangReguler);
        $jumlahRuangLab = count($this->ruangLaboratorium);
        
        for ($i = 0; $i < $this->populasi; $i++) {
            
            for ($j = 0; $j < $jumlahPengampu; $j++) {
                
                $sks = $this->sks[$j];
                
                $this->individu[$i][$j][0] = $j;
                
                // Penentuan jam secara acak ketika 1 sks 
                if ($sks == 1) {
                    $this->individu[$i][$j][1] = mt_rand(0,  $jumlahJam - 1);
                }
                
                // Penentuan jam secara acak ketika 2 sks 
                if ($sks == 2) {
                    $this->individu[$i][$j][1] = mt_rand(0, ($jumlahJam - 1) - 1);
                }
                
                // Penentuan jam secara acak ketika 3 sks
                if ($sks == 3) {
                    $this->individu[$i][$j][1] = mt_rand(0, ($jumlahJam - 1) - 2);
                }
                
                // Penentuan jam secara acak ketika 4 sks
                if ($sks == 4) {
                    $this->individu[$i][$j][1] = mt_rand(0, ($jumlahJam - 1) - 3);
                }
                
                $this->individu[$i][$j][2] = mt_rand(0, $jumlahHari - 1); // Penentuan hari secara acak 
                
                if ($this->jenisMk[$j] === $this->TEORI) {
                    $this->individu[$i][$j][3] = intval($this->ruangReguler[mt_rand(0, $jumlahRuangReguler - 1)]);
                } else {
                    $this->individu[$i][$j][3] = intval($this->ruangLaboratorium[mt_rand(0, $jumlahRuangLab - 1)]);                    
                }
            }
        }
    }
    
    private function CekFitness($indv)
    {
        $penalty = 0;
        
        $hariJumat = intval($this->idJumat);
        $jumat_0 = intval($this->rangeJumat[0]);
        $jumat_1 = intval($this->rangeJumat[1]);
        $jumat_2 = intval($this->rangeJumat[2]);
        
        //var_dump($this->rangeJumat);
        //exit();
        
        $jumlahPengampu = count($this->pengampu);
        
        for ($i = 0; $i < $jumlahPengampu; $i++)
        {
          
          $sks = intval($this->sks[$i]);
          
          $jamA = intval($this->individu[$indv][$i][1]);
          $hariA = intval($this->individu[$indv][$i][2]);
          $ruangA = intval($this->individu[$indv][$i][3]);
          $dosenA = intval($this->dosen[$i]);        
          
          
            for ($j = 0; $j < $jumlahPengampu; $j++) {                 
              
                $jamB = intval($this->individu[$indv][$j][1]);
                $hariB = intval($this->individu[$indv][$j][2]);
                $ruangB = intval($this->individu[$indv][$j][3]);
                $dosenB = intval($this->dosen[$j]);
                  
                  
                //1.bentrok ruang dan waktu dan 3.bentrok dosen
                
                //ketika pemasaran matakuliah sama, maka langsung ke perulangan berikutnya
                if ($i == $j)
                    continue;
                
                // Bentrok Ruang dan Waktu
                //Ketika jam,hari dan ruangnya sama, maka penalty + satu
                if ($jamA == $jamB && $hariA == $hariB && $ruangA == $ruangB) $penalty += 1;
        
                
                //Ketika sks  = 2, 
                //hari dan ruang sama, dan 
                //jam kedua sama dengan jam pertama matakuliah yang lain, maka penalty + 1
                if ($sks >= 2)
                {
                    if ($jamA + 1 == $jamB && $hariA == $hariB && $ruangA == $ruangB) { 
                        $penalty += 1;
                    }
                }
                
                
                //Ketika sks  = 3, 
                //hari dan ruang sama dan 
                //jam ketiga sama dengan jam pertama matakuliah yang lain, maka penalty + 1
                if ($sks >= 3) {
                    if ($jamA + 2 == $jamB && $hariA == $hariB && $ruangA == $ruangB) {
                        $penalty += 1;
                    }
                }
                
                //Ketika sks  = 4, 
                //hari dan ruang sama dan 
                //jam ketiga sama dengan jam pertama matakuliah yang lain, maka penalty + 1
                if ($sks >= 4) {
                    if ($jamA + 3 == $jamB && $hariA == $hariB && $ruangA == $ruangB) {
                        $penalty += 1;
                    }
                }
                
                // BENTROK DOSEN
                //ketika jam sama, hari, dosen sama
                if ($jamA == $jamB && $hariA == $hariB &&  $dosenA == $dosenB) $penalty += 1;
                          
                if ($sks >= 2) {
                    //ketika jam, hari, dosen sama
                    if (($jamA + 1) == $jamB && $hariA == $hariB && $dosenA == $dosenB) $penalty += 1;
                }
                
                if ($sks >= 3) {
                    if ( ($jamA + 2) == $jamB && $hariA == $hariB && $dosenA == $dosenB) $penalty += 1;
                }
                
                if ($sks >= 4) {
                    if ( ($jamA + 3) == $jamB && $hariA == $hariB && $dosenA == $dosenB) $penalty += 1;
                    
                }                
            }
            
            // Bentrok sholat Jumat
             //2.bentrok sholat jumat
            if (($hariA  + 1) == $hariJumat) {
                
                if ($sks == 1) {
                    if ( ($jamA == ($jumat_0 - 1)) || ($jamA == ($jumat_1 - 1)) || ($jamA == ($jumat_2 - 1)) ) {
                        $penalty += 1;
                    }
                }
                
                
                if ($sks == 2) {
                    if ( ($jamA == ($jumat_0 - 2)) || ($jamA == ($jumat_0 - 1)) || ($jamA == ($jumat_1 - 1)) || ($jamA == ($jumat_2 - 1)) ) {
                        /*
                        echo '$sks = ' . $sks. '<br>';
                        echo '$jamA = ' . $jamA. '<br>';
                        echo '($jumat_0 - 2) = ' . ($jumat_0 - 2) . '<br>';
                        echo '($jumat_0 - 1) = ' . ($jumat_0 - 1). '<br>';
                        echo '($jumat_1 - 1) = ' . ($jumat_1 - 1). '<br>';
                        echo '($jumat_2 - 1) = ' . ($jumat_2- 1). '<br>';
                        exit();
                        */
                        
                        $penalty += 1;                        
                    }
                }
                
                if ($sks == 3) {
                    if ( ($jamA == ($jumat_0 - 3)) || ($jamA == ($jumat_0 - 2)) ||
                          ($jamA == ($jumat_0 - 1)) ||($jamA == ($jumat_1 - 1)) ||
                          ($jamA == ($jumat_2 - 1)) ) {                        
                        $penalty += 1;                        
                    }
                }
                
                if ($sks == 4) {
                    if (
                          ($jamA == ($jumat_0 - 4)) || ($jamA == ($jumat_0 - 3)) ||
                          ($jamA == ($jumat_0 - 2)) || ($jamA == ($jumat_0 - 1)) ||
                          ($jamA == ($jumat_1 - 1)) || ($jamA == ($jumat_2 - 1))
                        ) {                        
                        $penalty += 1;                        
                    }
                }
            }
            
            // $jumlah_waktu_tidak_bersedia = count($this->idosen);
            
            // for ($j = 0; $j < $jumlah_waktu_tidak_bersedia; $j++)
            // {
            //     if ($dosenA == $this->idosen[$j])
            //     {
            //         $hari_jam = explode(':', $this->waktuDosen[$j][1]);
                    
            //         if ($this->jam[$jamA] == $hari_jam[1] &&
            //             $this->hari[$hariA] == $hari_jam[0])
            //         {                    
            //             $penalty += 1;                        
            //         }
            //     }                            
            // }
                       
            
            //
            
            // Bentrok waktu dhuhur
            /*
            if ($jamA == ($this->kodeDhuhur - 1))
            {                
                $penalty += 1;
            }
            */
            
        }      
        
        $fitness = floatval(1 / (1 + $penalty));  
        
        return $fitness;        
    }
    
    public function HitungFitness()
    {
        //hard constraint
        //1.bentrok ruang dan waktu
        //2.bentrok sholat jumat
        //3.bentrok dosen
        //4.bentrok keinginan waktu dosen 
        //5.bentrok waktu dhuhur 
        //=>6.praktikum harus pada ruang lab {telah ditetapkan dari awal perandoman
        //    bahwa jika praktikum harus ada pada LAB dan mata kuliah reguler harus 
        //    pada kelas reguler

        
        for ($indv = 0; $indv < $this->populasi; $indv++) {            
            $fitness[$indv] = $this->CekFitness($indv);            
        }
        
        return $fitness;
    }
    
    // Seleksi
    public function Seleksi( $fitness ) {
        $jumlah = 0;
        $rank   = [];
        
        
        for ($i = 0; $i < $this->populasi; $i++) {

            //proses ranking berdasarkan nilai fitness
            $rank[$i] = 1;
            for ($j = 0; $j < $this->populasi; $j++) {
                
                $fitnessA = floatval($fitness[$i]);
                $fitnessB = floatval($fitness[$j]);
                
                if ( $fitnessA > $fitnessB ) $rank[$i] += 1;                    
                
            }
            
            $jumlah += $rank[$i];
        }
        
        $jumlahRank = count($rank);
        for ($i = 0; $i < $this->populasi; $i++) {
            //proses seleksi berdasarkan ranking yang telah dibuat
            //int nexRandom = random.Next(1, jumlah);
            //random = new Random(nexRandom);
            $target = mt_rand(0, $jumlah - 1);           
          
            $cek    = 0;
            for ($j = 0; $j < $jumlahRank; $j++) {
                $cek += $rank[$j];
                if (intval($cek) >= intval($target)) {
                    $this->induk[$i] = $j;
                    break;
                }
            }
        }
    }

    public function StartCrossOver()
    {
        $individuBaru = [[[]]];
        $jumlahPengampu = count( $this->pengampu );
        
        for ($i = 0; $i < $this->populasi; $i += 2) {
            $b = 0;
            
            $cr = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
            
            if (floatval($cr) < floatval($this->crossOver)) {
                //ketika nilai random kurang dari nilai probabilitas pertukaran
                //maka jadwal mengalami prtukaran
                
                $a = mt_rand(0, $jumlahPengampu - 2);
                while ($b <= $a) {
                    $b = mt_rand(0, $jumlahPengampu - 1);
                }
                
                //penentuan jadwal baru dari awal sampai titik pertama
                for ($j = 0; $j < $a; $j++) {
                    for ($k = 0; $k < 4; $k++) {                        
                        $individuBaru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individuBaru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
                
                // Penentuan jadwal baru dai titik pertama sampai titik kedua
                for ($j = $a; $j < $b; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individuBaru[$i][$j][$k]     = $this->individu[$this->induk[$i + 1]][$j][$k];
                        $individuBaru[$i + 1][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
                    }
                }
                
                // Penentuan jadwal baru dari titik kedua sampai akhir
                for ($j = $b; $j < $jumlahPengampu; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individuBaru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individuBaru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            } else { 

                // Ketika nilai random lebih dari nilai probabilitas pertukaran, maka jadwal baru sama dengan jadwal terpilih
                for ($j = 0; $j < $jumlahPengampu; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individuBaru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individuBaru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            }
        }
        
        $jumlahPengampu = count($this->pengampu);
        
        for ($i = 0; $i < $this->populasi; $i += 2) {
            for ($j = 0; $j < $jumlahPengampu ; $j++) {
                for ($k = 0; $k < 4; $k++) {
                    $this->individu[$i][$j][$k] = $individuBaru[$i][$j][$k];
                    $this->individu[$i + 1][$j][$k] = $individuBaru[$i + 1][$j][$k];
                }
            }
        }
    }
    
    public function Mutasi(){
        $fitness = [];
        
        $r                  = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
        $jumlahPengampu     = count($this->pengampu);
        $jumlahJam          = count($this->jam);
        $jumlahHari         = count($this->hari);
        $jumlahRuangReguler = count($this->ruangReguler);
        $jumlahRuangLab     = count($this->ruangLaboratorium);
        
        for ($i = 0; $i < $this->populasi; $i++) {

            //Ketika nilai random kurang dari nilai probalitas Mutasi, 
            //maka terjadi penggantian komponen
            
            if ($r < $this->mutasi) {

                //Penentuan pada matakuliah dan kelas yang mana yang akan dirandomkan atau diganti
                $krom = mt_rand(0, $jumlahPengampu - 1);
                
                $j = intval($this->sks[$krom]);
                
                switch ($j) {
                    case 1:
                        $this->individu[$i][$krom][1] = mt_rand(0, $jumlahJam - 1);
                        break;
                    case 2:
                        $this->individu[$i][$krom][1] = mt_rand(0, ($jumlahJam - 1) - 1);
                        break;
                    case 3:
                        $this->individu[$i][$krom][1] = mt_rand(0, ($jumlahJam - 1) - 2);
                        break;
                    case 4:
                        $this->individu[$i][$krom][1] = mt_rand(0, ($jumlahJam - 1) - 3);
                        break;
                }
                //Proses penggantian hari
                $this->individu[$i][$krom][2] = mt_rand(0, $jumlahHari - 1);
                
                //proses penggantian ruang               
                if ($this->jenisMk[$krom] === $this->TEORI) {
                    $this->individu[$i][$krom][3] = $this->ruangReguler[mt_rand(0, $jumlahRuangReguler - 1)];
                } else {
                    $this->individu[$i][$krom][3] = $this->ruangLaboratorium[mt_rand(0, $jumlahRuangLab - 1)];
                }
                  
            }
            
            $fitness[$i] = $this->CekFitness($i);
        }
        return $fitness;
    }
    
    
    public function GetIndividu( $indv ) {

        $individuSolusi = [[]];
        for ($j = 0; $j < count($this->pengampu); $j++){
            $individuSolusi[$j][0] = intval($this->pengampu[$this->individu[$indv][$j][0]]);
            $individuSolusi[$j][1] = intval($this->jam[$this->individu[$indv][$j][1]]);
            $individuSolusi[$j][2] = intval($this->hari[$this->individu[$indv][$j][2]]);                        
            $individuSolusi[$j][3] = intval($this->individu[$indv][$j][3]);            
        }
        
        return $individuSolusi;
    }
    
    
}