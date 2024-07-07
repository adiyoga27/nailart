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
    <p style="text-align: center; margin-top:-10px"><b>Periode : <?php echo date('d-m-Y', strtotime($startDate)); ?> s/d <?php echo date('d-m-Y', strtotime($endDate)); ?></b></p>

    <table >
    <tr style="background:#e0e0e0; font-weight:bold;">
              <th style="width: 20px; text-align: center;" ><col width="10">No</th>
              <th style="width: 100px; text-align: center;" >  <col width="150"> Tanggal</th>
              <th style="width: 300px; text-align: center;" >Keterangan</th>
              <th style="width: 100px; text-align: center;" >Kas Masuk</th>
              <th style="width: 100px; text-align: center;" >Kas Keluar</th>
            </tr>
              <?php
              $saldo =  $debit = $kredit = 0;
              $no = 1; foreach ($data as $row) { 
                $debit += $row->debit;
                $kredit += $row->kredit;
                $saldo += ($row->kredit - $row->debit); 
                ?>
              <tr>
                <td><?=$no++?></td>
                <td><?=tanggal($row->tanggal)?></td>
                <td style="text-align: left"><?=$row->keterangan?></td>
                <td style="text-align: right">Rp<?=number_format($row->kredit,0,",",".")?></td>
                <td style="text-align: right">Rp<?=number_format($row->debit,0,",",".")?></td>
              </tr>
              <?php } ?>
                  <tr style="background:#e0e0e0 !important; font-weight:bold;">
                    <th colspan="3">Total</th>
                    <th style="text-align: right;">Rp<?=number_format($kredit,0,",",".")?></th>
                    <th style="text-align: right;">Rp<?=number_format($debit,0,",",".")?></th>
                  </tr>
                  <tr style="background:#e0e0e0 !important; font-weight:bold;">
                    <th colspan="3">Total Kas Bersih</th>
                    <th  colspan="2" style="text-align: center;">Rp<?=number_format($saldo,0,",",".")?></th>
                  </tr>

                  

<tr style="height: 100px !important">

                  
        <td></td>
        <td></td>
        <td class="tg-0lax"></td>
<td class="tg-0lax"><br><br><br><br><br></td>
<td class="tg-0lax"></td>
</tr>

    <tr>
        <td>Diketahui dan Setujui Oleh,</td>
        <td></td>
        <td></td>
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
        <td></td>
        <td></td>
        <td style="text-align: right;">( ........................)</td>
    </tr>
    <tr >
        <td><span style="padding-left: 30px;"></span>  Owner</td>
        <td></td>
        <td></td>
        <td></td>

        <td style="text-align: right;">Accounting<span style="padding-left: 15px;"></span> </td>
    </tr>
</table>
</body>
