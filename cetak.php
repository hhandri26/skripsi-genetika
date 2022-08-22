<?php
session_start();
require_once 'vendor/autoload.php';

if(isset($_SESSION['anggota'])){
    $anggota = $_SESSION['anggota'];
}


$mpdf = new \Mpdf\Mpdf();

ob_start();
echo '
<!DOCTYPE html>
<head>
    <title>Cetak Jadwal</title>
</head> 

<body>
    <h1 align="center">Jadwal Shift Karaywan</h1>
    <div class="row"> 
        <div class="col-md-6" style="width:50%;float:left;">
            <table>
                <tr>
                    <td>Fitness<td>
                    <td> : <td>
                    <td>'.$anggota['fitness'].'</td>
                </tr>
                <tr>
                    <td>Iterasi<td>
                    <td> : <td>
                    <td>'.$anggota['iterasi'].'</td>
                </tr>
                <tr>
                    <td>Waktu Eksekusi<td>
                    <td> : <td>
                    <td>'.implode(" ",$anggota['exec']).'</td>
                </tr>
                <tr>
                    <td>Kesesuaian<td>
                    <td> : <td>
                    <td>'.$anggota['akurasi'].' %</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
        shift pagi : 06.00-14.00 <br> shift siang : 14.00-22.00 <br> shift malam : 22.00-06.00
        
        </div>
    </div>
    <table align="center" border="1" cellpadding="10" cellspacing="0">
        <tr>
            <td align="center">Tgl</td>
            <td align="center">Shift</td>
            <td colspan="8" align="center">Daftar Anggota</td>
        </tr>';
    for ($i=0; $i < $anggota['jmlHari']*3; $i++) {
        echo "<tr>";
        if ($i % 3 == 0) {
            echo '<td align="center" rowspan="3">'. (($i/3)+1) .'</td>';
        }
        echo '<td align="center">' .(($i % 3) + 1). '</td>';
        for ($j=0; $j < 8; $j++) {
            if($anggota['kromosom'][$j]['bg'] != 'white'){
                $text_color = 'black';
            }else{
                $text_color = 'black';
            }
            //bgcolor="' .$anggota_polisi['kromosom'][$j]['bg']. '"
            echo '<td color="'.$text_color.'">' .$anggota['kromosom'][$j]['nama']. '</td>' ;
        }
        array_splice($anggota['kromosom'], 0, 8);
        echo '</tr>';
    }
echo '
    </table>
    <table>
    <tr>
        <td style="text-align:right">
        Yang Menandatangani
        </td>

    </tr>
    <tr>
    </tr>
    <tr>
    <td>
    <br>
                                  <br>
                                  <br>
                                  <br>
                                  <br>
                                  <br>
                                  <br>
                                  <br>
                                  <br>(&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;)</td>
    
    </tr>
    </table>
   
      
        
   
</body>
</html>
';

//return $html;
$html = ob_get_contents();
ob_end_clean();

$mpdf->WriteHTML($html);
$mpdf->Output('Jadwal-Shift-karyawan.pdf', \Mpdf\Output\Destination::INLINE);