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
    <p style="text-align: center; margin-top:-10px"><b>Periode : <?php echo date('d-m-Y', strtotime($startDate)); ?> s/d <?php echo date('d-m-Y', strtotime($endDate)); ?></b></p>
    <table>
              <tr style="background:#e0e0e0 !important; font-weight:bold; width:50% !important">
                <th style="text-align: center" colspan="2">Aktiva</th>
                <th style="text-align: center" colspan="2">Pasiva</th>
              </tr>
              <tr style="background:#e0e0e0 !important; font-weight:bold; width:50% !important">
                <th style="text-align: start" colspan="2">Aktiva Lancar</th>
                <th style="text-align: start" colspan="2">Kewajiban</th>
              </tr>
      
              <tr>
                <td  style="width:5px; text-align: start; ">Kas</td>
                <td  style="width:200px; text-align: right">Rp<?=number_format($data['kas'],0,",",".")?></td>
                <td  style="width:120px; text-align: start">Hutang</td>
                <td  style="width:250px; text-align: right">Rp<?=number_format($data['hutang'],0,",",".")?></td>
              </tr>
              <tr>
                <td  style="width:120px; text-align: start">Perlengkapan</td>
                <td  style="width:120px; text-align: right">Rp<?=number_format($data['perlengkapan'],0,",",".")?></td>
                <td  style="width:5px; text-align: start; background:#e0e0e0; font-weight:bold;" colspan="2">Modal</td>
              </tr>
              <tr>
                <td  style="width:120px; text-align: start"></td>
                <td  style="width:120px; text-align: right"></td>
                <td  style="width:5px; text-align: start; ">Modal Awal</td>
                <td>Rp<?=number_format($data['modal'],0,",",".")?></td>
              </tr>
              <tr>
                <td  colspan="2"></td>
                <td  style="width:5px; text-align: start; ">Laba Ditahan</td>
                <td>Rp<?=number_format($data['ditahan'],0,",",".")?></td>
              </tr>
              <tr style="background:#e0e0e0 !important; font-weight:bold; width:100% !important">
                <td  style="text-align: start; ">Total Aktiva</td>
                <th style="text-align: right">Rp<?=number_format($data['kas']+$data['perlengkapan'],0,",",".")?></th>
                <td  style="text-align: start; ">Total Pasiva</td>
                <th style="text-align: right">Rp<?=number_format($data['modal'] + $data['ditahan']+ $data['hutang'],0,",",".")?></th>
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
