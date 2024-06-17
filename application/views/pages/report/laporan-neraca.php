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