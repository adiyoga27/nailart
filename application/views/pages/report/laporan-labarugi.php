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
                <label>Tgl Mulai</label>
                <input class="form-control" type="date" name="startDate" value="<?php echo $startDate?>" required>
               
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Tgl Selesai</label>
                <input class="form-control" type="date" name="endDate" value="<?php echo $endDate?>" required>
               
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