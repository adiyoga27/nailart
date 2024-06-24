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

    <table  border="1">
    <tr>
              <th style="width: 50px;">No</th>
              <th style="width: 100px;">  <col width="100"> Tanggal</th>
              <th style="width: 300px;">Keterangan</th>
              <th  style="width: 100px;">Kas Masuk</th>
              <th  style="width: 100px;">Kas Keluar</th>
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
                <td style="text-align: right">Rp. <?=number_format($row->kredit,0,",",".")?></td>
                <td style="text-align: right">Rp. <?=number_format($row->debit,0,",",".")?></td>
              </tr>
              <?php } ?>
                  <tr>
                    <th colspan="3">Total</th>
                    <th style="text-align: right;">Rp. <?=number_format($kredit,0,",",".")?></th>
                    <th style="text-align: right;">Rp. <?=number_format($debit,0,",",".")?></th>
                  </tr>
                  <tr>
                    <th colspan="3">Total Kas Bersih</th>
                    <th  colspan="2" style="text-align: center;">Rp. <?=number_format($saldo,0,",",".")?></th>
                  </tr>
</table>
</body>
