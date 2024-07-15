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
            <input type="text"  placeholder="Masukan harga" class="form-control uang" required value="<?=isset($data) ? number_format($data->jumlah,0,",","."):''?>">
            <input type="hidden" name="harga" placeholder="Masukan harga" class="form-control jumlah" required value="<?=isset($data)?$data->jumlah:''?>">
          </div>
 

          <div class="form-group col-md-12">
            <label>Akun</label>
            <select name="akun" class="form-control" required>
              <option value="">-- Pilih Salah Satu --</option>
              <?php foreach ($akun as $row) { ?>
                <option <?=isset($data)&&$data->akun == $row->id_akun ? 'selected' : '' ?> value="<?=$row->id_akun?>"><?=$row->kode_akun?> | <?=$row->nama_akun?></option>
              <?php } ?>
            </select>
          </div>

          <!-- <div class="form-group col-md-6">
            <label>Invoice</label>
            <input type="file" name="invoice" <?=isset($data) ? '' : 'required'?> class="form-control" >
          </div> -->

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
<script src="<?= base_url('assets/') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
     $(document).ready(function() {
        // Event listener for keyup on elements with class 'tanpa_rupiah'
        $('.uang').keyup(function(e) {
            // Call formatRupiah function and update the value of the input field
            $(".jumlah").val($(this).val().split('.').join(""));
            $(this).val(formatRupiah($(this).val()));
        });
    });
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>