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
    <thead>
              <th width="1%">No</th>
              <th>Tanggal</th>
              <th>Keterangan</th>
              <th>Kas Masuk</th>
              <th>Kas Keluar</th>
            </thead>
            <tbody>
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
                <td>Rp. <?=number_format($row->kredit)?></td>
                <td>Rp. <?=number_format($row->debit)?></td>
              </tr>
              <?php } ?>
            </tbody>
            <tfoot>
                  <tr>
                    <th colspan="3">Total</th>
                    <th style="text-align: end;">Rp. <?=number_format($kredit,0,",",".")?></th>
                    <th style="text-align: end;">Rp. <?=number_format($debit,0,",",".")?></th>
                  </tr>
                  <tr>
                    <th colspan="3">Total Kas Bersih</th>
                    <th  colspan="2" style="text-align: center;">Rp. <?=number_format($saldo,0,",",".")?></th>
                  </tr>
            </tfoot>
            </table>
        </div>
      </div>
    </section>
  </div>
</section>