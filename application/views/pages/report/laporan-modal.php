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
                <td>Modal Awal</td>
                <td></td>
                <td>Rp<?php echo (number_format($modal,0,',','.') ) ?></td>
              </tr>
              <tr>
                <td>Laba Bersih</td>
                <td>Rp<?php echo ( number_format($pendapatan,0,',','.')) ?></td>
                <td></td>
              </tr>
              <tr>
                <td>Prive</td>
                <td>Rp<?php echo (number_format($prive,0,',','.') ) ?></td>
                <td></td>
              </tr>
              <tr>
                <td>Penambahan Modal</td>
                <td></td>
                <td>Rp<?php echo (number_format($pendapatan-$prive,0,',','.'));?></td>
              </tr>


              <tr style="background-color:darkgrey !important; ; font-weight:bold">
                <td class="table-dark" colspan="2">Modal Akhir <?php echo date('M Y', strtotime($year."-".$month."-01"))?></td>
                <td class="table-dark" colspan="2">Rp<?php echo (number_format($modal + ($pendapatan-$prive),0,',','.'));?></td>
              </tr>
            </table>
        </div>
      </div>
    </section>
  </div>
</section>