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
    <p style="text-align: center; margin-top:-10px"><b>Laporan Arus Kas</b></p>
    <p style="text-align: center; margin-top:-10px"><b>Periode : <?php echo date('d-m-Y', strtotime($startAt))?> s/d <?php echo date('d-m-Y', strtotime($endAt))?></b></p>

    <table style="width: 100% !important;">
        <?php
              $saldo = 0;
              $no = 1; 
              foreach ($data as $row) {  ?>
        <tr style="background:#e0e0e0 !important; font-weight:bold; width:100% !important">
            <td colspan="3" ><col width="245">ARUS KAS DARI <?php echo strtoupper(str_replace('_', ' ', $row['title'])); ?></td>
     
        </tr>
        <?php foreach($row['content'] as $c ) {
                  if($c['kredit']>0){
                    $saldo += $c['kredit'];
                  }else{
                    $saldo -= $c['debit'];
                  }
                  
                  ?>
        <tr>
            <td><?php echo "      ".$c['akun'];?></td>
            <td>Rp<?php echo number_format($c['debit'] > 0 ? $c['debit'] : $c['kredit'], 0, ',', '.'); ?></td>
            <td></td>
        </tr>

        <?php } ?>

        <?php } ?>
        <tr style="background:#e0e0e0 !important; ; font-weight:bold">
            <td colspan="2"> KAS BERSIH</td>
            <td >Rp<?php echo number_format($saldo, 0, ',', '.'); ?></td>

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
