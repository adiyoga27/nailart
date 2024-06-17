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
        <table class="table table-bordered table-striped" >
            <thead>
             
              <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>Debet</th>
                <th>Kredit</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($data as $value){?>
                  <tr>
                    <td><?=$value['tanggal'] ?></td>
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