<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
      <div class="box box-danger">
        <div class="box-body">
          
          <form method="post" action="">
          <button type="submit" name="button" value="cetak" class="btn btn-primary" ><span class="fa fa-print"></span> Cetak</button><br><br>
          </form>
          
          <table class="table table-bordered table-striped text-center" >
            <thead>
              <th width="1%">No</th>
              <th>Bulan</th>
              <th>Kas Masuk</th>
              <th>Kas Keluar</th>
              <th>Laba/Rugi</th>
            </thead>
            <tbody>
              <?php
              $saldo = 0;
              $no = 1; foreach ($data as $row) { ?>
              <tr>
                <td><?=$no++?></td>
                <td><?=bulan($row->bulan)?></td>
                <td>Rp. <?=number_format($row->kredit_)?></td>
                <td>Rp. <?=number_format($row->debit_)?></td>
                <td>Rp. <?=number_format($row->kredit_ - $row->debit_)?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</section>