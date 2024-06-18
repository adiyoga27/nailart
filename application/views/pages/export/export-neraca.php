<html>
<head>
    <title>Cetak Neraca</title>
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
    <p style="text-align: center; margin-top:-10px"><b>Laporan Neraca</b></p>
    <p style="text-align: center; margin-top:-10px"><b>Periode : <?php echo date('d-m-Y', strtotime($year."-".$month."-01")); ?> s/d <?php echo date('t-m-Y', strtotime($year."-".$month."-01")); ?></b></p>
    <table>
              <tr style="background:#e0e0e0 !important; font-weight:bold; width:100% !important">
                <th style="text-align: center" rowspan="2" width="1%">No</th>
                <th style="text-align: center" rowspan="2">Akun</th>
                <th style="text-align: center" colspan="2">Saldo</th>
              </tr>
              <tr style="background:#e0e0e0 !important; font-weight:bold; width:100% !important">
                <th style="text-align: center">Debit</th>
                <th style="text-align: center">Kredit</th>
              </tr>
              <?php
              $debit = 0;
              $kredit= 0;
              $no = 1; foreach ($data as $row) {?>
              <tr>
                <td  style="width:5px; text-align: center; "><?=$no++?></td>
                <td  style="width:300px; text-align: left"><?=$row->nama_akun?></td>
                <td  style="width:120px; text-align: right">Rp. <?=number_format($row->kategori_akun == 'aset' ? $row->kredit_ : $row->debit_)?></td>
                <td  style="width:120px; text-align: right">Rp. <?=number_format($row->kategori_akun == 'aset' ? $row->debit_ : $row->kredit_) ?></td>
              </tr>
              <?php 

              $debit += $row->kategori_akun == 'aset' ? $row->kredit_ : $row->debit_; 
              $kredit+= $row->kategori_akun == 'aset' ? $row->debit_ : $row->kredit_;
              } ?>
              <tr style="background:#e0e0e0 !important; font-weight:bold; width:100% !important">
                <th colspan="2">Total</th>
                <th style="text-align: right">Rp. <?=number_format($debit) ?></th>
                <th style="text-align: right">Rp. <?=number_format($kredit) ?></th>
              </tr>
              <tr style="height: 100px !important">

                  
<td class="tg-0lax"></td>
<td class="tg-0lax"></td>

<td class="tg-0lax"><br><br><br><br><br></td>
<td class="tg-0lax"></td>
</tr>

    <tr>
        <td>Diketahui dan Setujui Oleh,</td>
        <td></td>
        <td></td>

        <td style="text-align: right;">Denpasar, <?php echo date('d-F-Y')."<br> Dibuat Oleh"?>,</td>
    </tr>
    <tr height="50px">
             
<td class="tg-0lax"></td>
<td class="tg-0lax"></td>
<td class="tg-0lax"><br><br><br></td>
<td class="tg-0lax"></td>
</tr>
    <tr >
        <td >( ........................)</td>
        <td></td>
        <td></td>
        <td style="text-align: right;">( ........................)</td>
    </tr>
    <tr >
        <td><span style="padding-left: 30px;"></span>  Owner</td>
        <td></td>
        <td></td>

        <td style="text-align: right;">Accounting<span style="padding-left: 15px;"></span> </td>
    </tr>
          </table>
   
</body>
