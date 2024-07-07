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
        <table class="table table-bordered table-striped" >
            <thead>
             
              <tr >
                <th  style="text-align: center;">Tanggal</th>
                <th  style="text-align: center;">Keterangan</th>
                <th  style="text-align: center;">Kode Akun</th>
                <th  style="text-align: center;">Nama Akun</th>
                <th  style="text-align: center;">Debit</th>
                <th  style="text-align: center;">Kredit</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($data as $value){?>
                  <tr>
                    <td><?php 
                    if($value['tanggal'] == ""){

                    }else{

                      echo date('d F Y', strtotime($value['tanggal'])) ;
                    }
                    
                    ?></td>
                    <td><?=$value['keterangan'] ?></td>
                    <td  style="text-align: center;"><?=$value['kode_akun'] ?></td>
                    <td><?=$value['nama_akun'] ?></td>
                    <td style="text-align: end;"><?=number_format($value['debit'],0,",",".") ?></td>
                    <td style="text-align: end;"><?=number_format($value['kredit'],0,",",".") ?></td>

                  </tr>
                  <?php 
                  $debit+= $value['debit'];
                  $kredit+= $value['kredit'];
                } ?>
            </tbody>
            <tfoot>
                  <tr>
                    <th colspan="4">Total</th>
                    <th style="text-align: end;"><?=number_format($debit,0,",",".")?></th>
                    <th style="text-align: end;"><?=number_format($kredit,0,",",".")?></th>
                  </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </section>
  </div>
</section>