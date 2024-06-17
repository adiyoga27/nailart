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
              <tr>
                <th rowspan="2" width="1%">No</th>
                <th rowspan="2">Akun</th>
                <th colspan="2">Saldo</th>
              </tr>
              <tr>
                <th>Debit</th>
                <th>Kredit</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $debit = 0;
              $kredit= 0;
              $no = 1; foreach ($data as $row) {?>
              <tr>
                <td><?=$no++?></td>
                <td style="text-align: left"><?=$row->nama_akun?></td>
                <td>Rp. <?=number_format($row->kategori_akun == 'aset' ? $row->kredit_ : $row->debit_)?></td>
                <td>Rp. <?=number_format($row->kategori_akun == 'aset' ? $row->debit_ : $row->kredit_) ?></td>
              </tr>
              <?php 

              $debit += $row->kategori_akun == 'aset' ? $row->kredit_ : $row->debit_; 
              $kredit+= $row->kategori_akun == 'aset' ? $row->debit_ : $row->kredit_;
              } ?>
              <tr>
                <th colspan="2">Total</th>
                <th>Rp. <?=number_format($debit) ?></th>
                <th>Rp. <?=number_format($kredit) ?></th>

            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</section>