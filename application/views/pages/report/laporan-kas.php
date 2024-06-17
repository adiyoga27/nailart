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
                <label>Tanggal Awal</label>
                <input type="date" max="<?=date('Y-m-d')?>" name="awal" value="<?=isset($startAt) ? $startAt : ''?>" class="form-control" required>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>Tanggal Akhir</label>
                <input type="date" max="<?=date('Y-m-d')?>" name="akhir" value="<?=isset($endAt) ? $endAt : ''?>" class="form-control" required>
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
              <tr style="background-color:darkgrey !important; font-weight:bold"><td class="table-dark" colspan="3">ARUS KAS DARI <?php echo strtoupper(str_replace('_',' ',$row['title']))?></td></tr>
                <?php foreach($row['content'] as $c ) {
                  if($c['kredit']>0){
                    $saldo += $c['kredit'];
                  }else{
                    $saldo -= $c['debit'];
                  }
                  
                  ?>
                  <tr >
                    <td width="40%"> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $c['akun']?></td>
                    
                    <td>Rp<?php echo number_format($c['debit'] > 0 ? $c['debit'] : $c['kredit'],0,",",".") ?></td>
                    <td></td>
                  </tr>
                
                <?php } ?>

              <?php } ?>
              <tr style="background-color:darkgrey !important; ; font-weight:bold">
                <td class="table-dark" colspan="2">KAS BERSIH</td>
                <td class="table-dark" colspan="2">Rp<?php echo number_format($saldo,0,",",".")?></td>

              </tr>
            </table>
        </div>
      </div>
    </section>
  </div>
</section>