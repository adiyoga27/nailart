<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
      <div class="box box-danger">
        <form method="post" action="" enctype="multipart/form-data">
        <div class="box-body row">
        <div class="form-group col-md-6">
            <label>Kode Produk</label>
            <input type="text" name="kode_produk" placeholder="Masukan kode produk" class="form-control" required value="<?=isset($data)?$data->kode_produk:''?>">
          </div>
          <div class="form-group col-md-6">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" placeholder="Masukan nama produk" class="form-control" required value="<?=isset($data)?$data->nama_produk:''?>">
          </div>

          <div class="form-group col-md-6">
            <label>Harga</label>
            <input type="text" name="harga" placeholder="Masukan harga produk" class="form-control" required value="<?=isset($data)?$data->harga:''?>">
          </div>

          <div class="form-group col-md-6">
            <label>Keterangan</label>
            <input type="text" name="keterangan" placeholder="Masukan keterangan" class="form-control" required value="<?=isset($data)?$data->keterangan:''?>">
          </div>

        </div>
        <div class="box-footer">
          <a href="<?=$this->agent->referrer()?>" class="btn btn-danger">Kembali</a>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
      </div>
    </section>
  </div>
</section>