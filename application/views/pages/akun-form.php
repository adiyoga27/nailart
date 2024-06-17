<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
      <div class="box box-danger">
        <form method="post" action="" enctype="multipart/form-data">
        <div class="box-body row">
        <div class="form-group col-md-6">
            <label>Kategori Akun</label>
            <select name="kategori_akun" class="form-control" required>
              
              <option value="">Pilih Salah Satu</option>
              <option <?=isset($data)&&$data->kategori_akun == 'modal' ? 'selected' : ''?> value="modal"> Modal </option>
              <option <?=isset($data)&&$data->kategori_akun == 'pendapatan' ? 'selected' : ''?> value="pendapatan"> Pendapatan </option>
              <option <?=isset($data)&&$data->kategori_akun == 'beban' ? 'selected' : ''?> value="beban"> Beban/Pengeluaran </option>
              <option <?=isset($data)&&$data->kategori_akun == 'prive' ? 'selected' : ''?> value="prive"> Prive </option>
              <option <?=isset($data)&&$data->kategori_akun == 'aset' ? 'selected' : ''?> value="aset"> Aset </option>

            </select>
          </div>
          <div class="form-group col-md-6">
            <label>Tipe Akun</label>
            <select name="tipe_akun" id="tipe_akun" class="form-control" required>
              
              <option value="">Pilih Salah Satu</option>
              <option <?=isset($data)&&$data->tipe_akun == 'aktiva_tetap' ? 'selected' : ''?> value="aktiva_tetap"> Aktiva Tetap </option>
              <option <?=isset($data)&&$data->tipe_akun == 'aktiva_lancar' ? 'selected' : ''?> value="aktiva_lancar"> Aktiva Lancar </option>
              <option <?=isset($data)&&$data->tipe_akun == 'kewajiban' ? 'selected' : ''?> value="kewajiban"> Kewajiban </option>
              <option <?=isset($data)&&$data->tipe_akun == 'modal' ? 'selected' : ''?> value="modal"> Modal </option>
              <option <?=isset($data)&&$data->tipe_akun == 'pendapatan_operasional' ? 'selected' : ''?> value="pendapatan_operasional"> Pendapatan Operasional </option>
              <option <?=isset($data)&&$data->tipe_akun == 'pendapatan_non_operasional' ? 'selected' : ''?> value="pendapatan_non_operasional"> Pendapatan Non Operasional </option>
              <option <?=isset($data)&&$data->tipe_akun == 'beban_operasional' ? 'selected' : ''?> value="beban_operasional"> Beban Operasional </option>
              <option <?=isset($data)&&$data->tipe_akun == 'beban_non_operasional' ? 'selected' : ''?> value="beban_non_operasional"> Beban Non Operasional </option>
              <option <?=isset($data)&&$data->tipe_akun == 'prive' ? 'selected' : ''?> value="prive "> Prive </option>

            </select>
          </div>
          <div class="form-group col-md-1">
            <label>Kode Akun</label>
            <input type="text" name="kode_akun" id="kode_akun" readonly class="form-control" required value="<?=isset($data)?  substr($data->kode_akun,0,100) :''?>">
          </div>
          <!-- <div class="form-group col-md-11">
            <label>Digit Akun</label>
            <input type="text" name="digit_akun" placeholder="Masukan kode akun" class="form-control" required value="<?=isset($data)? substr($data->kode_akun,1,100):''?>">
          </div> -->
          <div class="form-group col-md-6">
            <label>Nama Akun</label>
            <input type="text" name="nama_akun" placeholder="Masukan nama akun" class="form-control" required value="<?=isset($data)?$data->nama_akun:''?>">
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
  $('#tipe_akun').on('change', function() {
    var kode = "";
    var selectedOptionValue = $(this).val();
    console.log('Selected option value:', selectedOptionValue);

    $.ajax({
      url: "/akun/"+selectedOptionValue,  // URL where you want to send the request
      method: 'GET',  // HTTP method (GET, POST, PUT, DELETE, etc.)
      dataType: 'json',  // Expected data type from the server
      success: function(data) {
        // This function will be called if the request succeeds
        console.log('Data received:', data);
        $('#kode_akun').val(data.data);

      },
      error: function(xhr, status, error) {
        // This function will be called if the request fails
        console.error('Error:', status, error);
      }
    });
    // switch (selectedOptionValue) {
    //   case 'aktiva_tetap': kode = 1 
    //     break;
    //   case 'aktiva_lancar': kode = 1 
    //     break;
    //   case 'kewajiban': kode = 2 
    //     break;
    //   case 'modal': kode = 3 
    //     break;
    //   case 'pendapatan_operasional': kode = 4 
    //     break;
    //   case 'pendapatan_non_operasional': kode = 4 
    //     break;
    //   case 'beban_operasional': kode = 5 
    //     break;
    //   case 'beban_non_operasional': kode = 5
    //     break;
    //   case 'prive': kode = 6 
    //     break;
        
    //   default:
    //     break;
    // }
  });
});
</script>