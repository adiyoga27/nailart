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
    <p style="text-align: center; margin-top:-10px"><b>Laporan Laba Rugi</b></p>
    <p style="text-align: center; margin-top:-10px"><b>Periode : <?php echo date('d-m-Y', strtotime($startAt)); ?> s/d <?php echo date('d-m-Y', strtotime($endAt)); ?></b></p>
    <table>
        <?php
              $saldo = 0;
              $no = 1; 
              foreach ($data as $row) {  ?>
        <tr style="background:#e0e0e0 !important; font-weight:bold; width:100% !important">
            <td colspan="3">
                <col width="330"> <?php echo ' ' . strtoupper(str_replace('_', ' ', $row['kategori'])); ?>
            </td>
        </tr>
        <?php foreach($row['content'] as $c ) {
                  $kredit = $debit = 0;
                  ?>
        <tr>
            <td colspan="3"> <b><?php echo ' ' . ucwords(str_replace('_', ' ', $c['title'])); ?></b></td>
        </tr>
        <?php foreach($c['content'] as $t ) {
                  if($t['kredit']>0){
                    $kredit += $t['kredit'];
                    $saldo += $t['kredit'];
                  }else{
                    $debit += $t['debit'];
                    $saldo -= $t['debit'];
                  }
                  ?>
        <tr>
            <td>&nbsp; &nbsp; &nbsp; &nbsp; <?php echo ucwords($t['akun']); ?></td>
            <?php if($t['debit'] > 0){?>
              <td>( Rp<?php echo number_format( $t['debit'] , 0, ',', '.'); ?>)</td>
              <?php }else{?>
              <td> Rp<?php echo number_format($t['kredit'], 0, ',', '.'); ?> </td>

              <?php }?>

            <td></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="1"><b> Total <?php echo ucwords(str_replace('_', ' ', $row['kategori'])); ?></b></td>
            <?php if($debit > 0){?>

            <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  <b>( Rp<?php echo number_format($debit, 0, ',', '.'); ?> )</b> </td>
            <?php }else{?>
              <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  <b> Rp<?php echo number_format($kredit, 0, ',', '.'); ?></b> </td>

              <?php }?>

        </tr>
        <?php } ?>
        <?php } ?>
        <tr style="background:#e0e0e0 !important; font-weight:bold; width:100% !important">
            <td  colspan="2"> KAS BERSIH</td>
            <td> <col width="300">Rp<?php echo number_format($saldo, 0, ',', '.'); ?></td>
        </tr>
    </table>
   
</body>
