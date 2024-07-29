<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title"><?=$title?></h3>
    
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped text-center" id="tabel">
            <thead>
              <th width="1%">No</th>
              <th>Tanggal</th>
              <th>Keterangan</th>
              <th>Hutang</th>
              <th>Status</th>
              <th>Aksi</th>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($data as $row) { ?>
              <tr>
                <td><?=$no++?></td>
                <td><?=tanggal($row->tanggal_pengeluaran)?></td>
                <td style="text-align: left"><?=$row->keterangan?></td>
                <td style="text-align: left">Rp<?=number_format($row->jumlah,0, ",",".")?></td>
                <td>
                  <?php if ($row->status) {?>
                    <span class="label label-success">Lunas</span>
                  <?php } else {?>
                    <span class="label label-danger">Belum Lunas</span>
                  <?php }?>
                </td>
                <td>
                  
                  <a href="<?=base_url('hutang/bayar/'.$row->id_pengeluaran)?>" class="btn btn-info btn-sm"><span class="fa fa-money"></span></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</section>