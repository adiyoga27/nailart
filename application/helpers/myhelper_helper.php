<?php

function level($level)
{
    $teks = '';
    if ($level == 'A') { $teks = 'admin'; }
    elseif ($level == 'SA') { $teks = 'service advisor'; }
    elseif ($level == 'KR') { $teks = 'ketua regu'; }
    elseif ($level == 'MK') { $teks = 'mekanik'; }
    return $teks;
}

function tanggal($tanggal){
    $bulan = array (
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
 
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
function hari($date)
{
    $daftar_hari = array(
     'Sunday' => 'Minggu',
     'Monday' => 'Senin',
     'Tuesday' => 'Selasa',
     'Wednesday' => 'Rabu',
     'Thursday' => 'Kamis',
     'Friday' => 'Jumat',
     'Saturday' => 'Sabtu'
    );
    $namahari = date('l', strtotime($date));

    return $daftar_hari[$namahari];
}
function bulan($bln){
    $bulan = $bln;
    Switch ($bulan){
        case 1 : $bulan="Januari";
            Break;
        case 2 : $bulan="Februari";
            Break;
        case 3 : $bulan="Maret";
            Break;
        case 4 : $bulan="April";
            Break;
        case 5 : $bulan="Mei";
            Break;
        case 6 : $bulan="Juni";
            Break;
        case 7 : $bulan="Juli";
            Break;
        case 8 : $bulan="Agustus";
            Break;
        case 9 : $bulan="September";
            Break;
        case 10 : $bulan="Oktober";
            Break;
        case 11 : $bulan="November";
            Break;
        case 12 : $bulan="Desember";
            Break;
    }
    return $bulan;
}
function getRomawi($bln){
    switch ($bln){
        case 1: 
            return "I";
            break;
        case 2:
            return "II";
            break;
        case 3:
            return "III";
            break;
        case 4:
            return "IV";
            break;
        case 5:
            return "V";
            break;
        case 6:
            return "VI";
            break;
        case 7:
            return "VII";
            break;
        case 8:
            return "VIII";
            break;
        case 9:
            return "IX";
            break;
        case 10:
            return "X";
            break;
        case 11:
            return "XI";
            break;
        case 12:
            return "XII";
            break;
    }
}

?>
