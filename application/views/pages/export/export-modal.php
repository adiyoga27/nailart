<html>

<head>
    <title>Cetak Arus Kas</title>
    <style>
        #row1 {
    position: relative;
    max-width: 6.8in;
}

.left {
    float: left;
}

.right {
    float: right;
}
    </style>
</head>

<body>
    <h3 style="text-align: center;">MAKE NAIL STUDIO</h3>
    <!-- <p style="text-align: center; margin-top:-10px">Jl. Nelayan No.31, Canggu, Kec. Kuta Utara, Kabupaten Badung, Bali
        80361, Indonesia</p> -->
    <hr>
    <br>
    <p style="text-align: center; margin-top:-10px"><b>Laporan Perubahan Modal</b></p>
    <p style="text-align: center; margin-top:-10px"><b>Periode : <?php echo date('d-m-Y', strtotime($startDate)); ?> s/d <?php echo date('d-m-Y', strtotime($endDate)); ?></b></p>

    <table >
          <?php 
         
         $modal = $pendapatan =$prive = 0;
          foreach ($data as $row) {
      
           
            if ($row->kategori_akun == 'modal') {
              $modal = $row->kredit;
            }else if($row->kategori_akun == 'pendapatan'){
              $pendapatan = $pendapatan + $row->kredit;
            }else if($row->kategori_akun == 'prive'){
              $prive = $row->kredit;
            }else if($row->kategori_akun == 'beban'){
              $pendapatan = $pendapatan - $row->debit;
            }

            ?>
            <?php } ?>

              <tr>
                <td style="width: 400px;">Modal Awal</td>
                <td  style="width: 150px;"></td>
                <td style="width: 150px;">Rp<?php echo (number_format($modal,0,',','.') ) ?></td>
              </tr>
              <tr>
                <td>Laba Bersih</td>
                <td>Rp<?php echo ( number_format($pendapatan,0,',','.')) ?></td>
                <td></td>
              </tr>
              <tr>
                <td >Prive</td>
                <td>Rp<?php echo (number_format($prive,0,',','.') ) ?></td>
                <td></td>
              </tr>
              <tr>
                <td >Penambahan Modal</td>
                <td></td>
                <td>Rp<?php echo (number_format($pendapatan-$prive,0,',','.'));?></td>
              </tr>


              <tr style="background:#e0e0e0; ; font-weight:bold">
                <td class="table-dark" colspan="2" >Modal Akhir </td>
                <td class="table-dark" colspan="2">Rp<?php echo (number_format($modal + ($pendapatan-$prive),0,',','.'));?></td>
              </tr>
   <tr style="height: 100px !important">

                  
    <td class="tg-0lax"></td>
    <td class="tg-0lax"><br><br><br><br><br></td>
    <td class="tg-0lax"></td>
   </tr>

        <tr>
            <td>Diketahui dan Setujui Oleh,</td>
            <td></td>

            <td style="text-align: right;">Denpasar, <?php echo date('d-F-Y')."<br> Dibuat Oleh"?>,</td>
        </tr>
        <tr height="50px">
                 
    <td class="tg-0lax"></td>
    <td class="tg-0lax"><br><br><br></td>
    <td class="tg-0lax"></td>
</tr>
        <tr >
            <td >( ........................)</td>
            <td></td>
            <td style="text-align: right;">( ........................)</td>
        </tr>
        <tr >
            <td><span style="padding-left: 30px;"></span>  Owner</td>
            <td></td>

            <td style="text-align: right;">Accounting<span style="padding-left: 15px;"></span> </td>
        </tr>
</table>
</body>
