<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
      <div class="box box-danger">
        <form method="post" action="" enctype="multipart/form-data">
        <div class="box-body row">
          <div class="form-group col-md-6">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Masukan nama lengkap" class="form-control" required value="<?=isset($data)?$data->nama_user:''?>">
          </div>
          <div class="form-group col-md-6">
            <label>Level User </label>
            <select name="level" class="form-control" required>
              <option value="">Pilih Salah Satu...</option>
              <option <?=isset($data)&&$data->level == 'admin'?'selected':''?> value="admin">Admin</option>
              <option <?=isset($data)&&$data->level == 'pemilik'?'selected':''?> value="pemilik">Pemilik</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>Email</label>
            <input type="text" name="email" placeholder="Masukan email" class="form-control" required value="<?=isset($data)?$data->email:''?>">
          </div>
          <div class="form-group col-md-6">
            <label>Nomor Telfon</label>
            <input type="number" name="nomor_telfon" placeholder="Masukan nomor telfon" class="form-control" required value="<?=isset($data)?$data->nomor_telfon:''?>">
          </div>
          <div class="form-group col-md-12">
            <label>Alamat</label>
            <input type="text" name="alamat" placeholder="Masukan Alamat" class="form-control" required value="<?=isset($data)?$data->alamat:''?>">
          </div>
          <div class="form-group col-md-6">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukan username" class="form-control" required value="<?=isset($data)?$data->username:''?>">
          </div>
          <div class="form-group col-md-6">
            <label>Password</label> <?=isset($data)?'<small><i>*Masukan password jika anda ingin mengubah password yang baru</i></small>':''?>
            <input type="text" name="password"  class="form-control" <?=isset($data)?'placeholder="Masukan password jika ingin mengubah"':'required placeholder="Masukan password"'?>>
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