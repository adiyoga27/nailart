<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title"><?=$title?></h3>
          <!-- tools box -->
          <div class="pull-right box-tools">
            <a href="<?=base_url('pemasukan-lain/add')?>" class="btn btn-primary btn-sm" ><i class="fa fa-plus"></i> Tambah Data</a>
          </div><!-- /. tools -->
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped text-center" id="tabel">
            <thead>
              <th width="1%">No</th>
              <th>Tanggal</th>
              <th>Keterangan</th>
              <th>Nominal</th> 
              <th>User</th>
              <th>Aksi</th>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($data as $row) { ?>
              <tr>
                <td><?=$no++?></td>
                <td><?=tanggal($row->tanggal_transaksi)?></td>
                <td style="text-align: left"><?=$row->keterangan?></td>
                <td style="text-align: right">Rp<?=number_format($row->jumlah,0, ",",".")?></td>
                <td style="text-align: left"><?=$row->nama_user?></td>
                <td>

                  <a href="<?=base_url('pemasukan-lain/edit/'.$row->id_transaksi)?>" class="btn btn-info btn-sm"><span class="fa fa-edit"></span></a>
                  <a onclick="return confirm('apakah anda yakin ingin menghapus data tersebut ?')" href="<?=base_url('pemasukan-lain/delete/'.$row->id_transaksi)?>" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
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