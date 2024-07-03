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
                <input type="date" max="<?=date('Y-m-d')?>" name="awal" value="<?=isset($awal) ? $awal : ''?>" class="form-control" required>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>Tanggal Akhir</label>
                <input type="date" max="<?=date('Y-m-d')?>" name="akhir" value="<?=isset($akhir) ? $akhir : ''?>" class="form-control" required>
              </div>
            </div>

            <div class="col-md-3">
              <button type="submit" name="button" value="filter" class="btn btn-info" style="margin-top: 23px"><span class="fa fa-refresh"></span> Filter</button>
              <button type="submit" name="button" value="cetak" class="btn btn-primary" style="margin-top: 23px"><span class="fa fa-print"></span> Cetak</button>
            </div>
          </div>
          </form>
          
          <table class="table table-bordered table-striped text-center" >
            <thead>
              <th width="1%">No</th>
              <th>Tanggal</th>
              <th>Keterangan</th>
              <th>Kas Masuk</th>
              <th>Kas Keluar</th>
              <th>Kas Saldo</th>
            </thead>
            <tbody>
              <?php
              $saldo = 0;
              $no = 1; foreach ($data as $row) { $saldo += ($row->kredit - $row->debit); ?>
              <tr>
                <td><?=$no++?></td>
                <td><?=tanggal($row->tanggal)?></td>
                <td style="text-align: left"><?=$row->keterangan?></td>
                <td>Rp. <?=number_format($row->kredit,0, ",",".")?></td>
                <td>Rp. <?=number_format($row->debit,0, ",",".")?></td>
                <td>Rp. <?=number_format($saldo,0, ",",".")?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</section>