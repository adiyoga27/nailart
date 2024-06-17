<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
      <div class="box box-danger">
        <form method="post" action="" enctype="multipart/form-data">
        <div class="box-body row">

        <div class="form-group col-md-6">
            <label>Kode Transaksi</label>
            <input type="text" readonly name="kode"  class="form-control" required value="<?=$this->kode->pengeluaran()?>">
          </div>
          <div class="form-group col-md-6">
            <label>Tanggal</label>
            <input type="date" name="tanggal_pengeluaran" max="<?=date('Y-m-d')?>" class="form-control" required value="<?=isset($data)?$data->tanggal_pengeluaran:''?>">
          </div>
          <div class="form-group col-md-6">
            <label>Keterangan</label>
            <input type="text" name="keterangan" placeholder="Masukan keterangan pengeluaran" class="form-control" required value="<?=isset($data)?$data->keterangan:''?>">
          </div>
     
          <div class="form-group col-md-6">
            <label>Jumlah</label>
            <input type="number" name="harga" placeholder="Masukan harga" class="form-control" required value="<?=isset($data)?$data->jumlah:''?>">
          </div>
 

          <div class="form-group col-md-6">
            <label>Akun</label>
            <select name="akun" class="form-control" required>
              <option value="">-- Pilih Salah Satu --</option>
              <?php foreach ($akun as $row) { ?>
                <option <?=isset($data)&&$data->akun == $row->id_akun ? 'selected' : '' ?> value="<?=$row->id_akun?>"><?=$row->kode_akun?> | <?=$row->nama_akun?></option>
              <?php } ?>
            </select>
          </div>

          <div class="form-group col-md-6">
            <label>Invoice</label>
            <input type="file" name="invoice" <?=isset($data) ? '' : 'required'?> class="form-control" >
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