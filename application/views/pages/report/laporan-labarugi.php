<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
      <div class="box box-danger">
        <div class="box-body">
          
          <form method="post" action="">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Bulan</label>
                <select name="month" class="form-control">
                  <option value="1" <?php echo ($month == 1 ? 'selected' : '')?>>Januari</option>
                  <option value="2" <?php echo ($month == 2 ? 'selected' : '')?>>Februari</option>
                  <option value="3" <?php echo ($month == 3 ? 'selected' : '')?>>Maret</option>
                  <option value="4" <?php echo ($month == 4 ? 'selected' : '')?>>April</option>
                  <option value="5" <?php echo ($month == 5 ? 'selected' : '')?>>Mei</option>
                  <option value="6" <?php echo ($month == 6 ? 'selected' : '')?>>Juni</option>
                  <option value="7" <?php echo ($month == 7 ? 'selected' : '')?>>Juli</option>
                  <option value="8" <?php echo ($month == 8 ? 'selected' : '')?>>Agustus</option>
                  <option value="9" <?php echo ($month == 9 ? 'selected' : '')?>>September</option>
                  <option value="10" <?php echo ($month == 10 ? 'selected' : '')?>>Oktober</option>
                  <option value="11" <?php echo ($month == 11 ? 'selected' : '')?>>November</option>
                  <option value="12" <?php echo ($month == 12 ? 'selected' : '')?>>Desember</option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>Tahun</label>
                <select name="year" class="form-control"> 
                  <option value="2023"  <?php echo ($year == 2023 ? 'selected' : '')?>>2023</option>
                  <option  value="2024" <?php echo ($year == 2024 ? 'selected' : '')?>>2024</option>
                </select>

              </div>
            </div>

            <div class="col-md-3">
              <button type="submit" name="button" value="filter" class="btn btn-info" style="margin-top: 23px"><span class="fa fa-refresh"></span> Filter</button>
              <button type="submit" name="button" value="cetak" class="btn btn-primary" style="margin-top: 23px"><span class="fa fa-print"></span> Cetak</button>
            </div>
          </div>
          </form>
           
        
        </div>
      </div>
    </section>

    <section class="col-lg-12 connectedSortable">
      <div class="box box-danger">
        <div class="box-body">
    <table class="table table-sm table-dark">
            <?php
              $saldo = 0;
              $no = 1; 
              
              foreach ($data as $row) {  ?>
              <tr style="background-color:darkgrey !important; font-weight:bold"><td class="table-dark" colspan="3"> <?php echo strtoupper(str_replace('_',' ',$row['kategori']))?></td></tr>
                <?php foreach($row['content'] as $c ) {
                  $kredit = $debit = 0;
                  ?>
                <!-- <tr ><td class="table-dark" colspan="3"> <b><?php echo ucwords(str_replace('_',' ',$c['title']))?></b></td></tr> -->
                 <?php foreach($c['content'] as $t ) {
                  
                  if($t['kredit']>0){
                    $kredit += $t['kredit'];
                    $saldo += $t['kredit'];
                  }else{
                    $debit += $t['debit'];
                    $saldo -= $t['debit'];
                  }
                  
                  ?>

                  <tr >
                    <td width="40%"> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo ucwords($t['akun'])?></td>
                    
                    <td>Rp<?php echo number_format($t['debit'] > 0 ? $t['debit'] : $t['kredit'],0,",",".") ?></td>
                    <td></td>
                  </tr>
                  <?php } ?>
                  <!-- <tr >
                    <td class="table-dark" colspan="1"> <b>Total <?php echo ucwords(str_replace('_',' ',$row['kategori']))?></b></td>
                    <td class="table-dark"> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <b> Rp. <?php echo number_format($debit > 0 ? $debit : $kredit,0,",",".")?></b> </td>
                  </tr> -->
                
                
                <?php } ?>

              <?php } ?>
              <tr style="background-color:darkgrey !important; ; font-weight:bold">
                <td class="table-dark" colspan="2">Laba / Rugi Bersih</td>
                <td class="table-dark" colspan="2">Rp<?php echo number_format($saldo,0,",",".")?></td>

              </tr>
            </table>
        </div>
      </div>
    </section>
  </div>
</section>