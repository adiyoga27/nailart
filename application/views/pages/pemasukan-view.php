<style>
    input[readonly] {
  background-color: white !important;
}

select {

  background: white !important;
}

    </style>
<section class="content">
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <form method="post" action="" enctype="multipart/form-data">
            <section class="col-lg-12 connectedSortable">
                <div class="box box-danger">
                    <div class="box-body row">
                        <div class="form-group col-md-6">
                            <label>Kode Transaksi</label>
                            <input readonly type="text" readonly name="kode" class="form-control" required
                                value="<?= isset($data) ? $data->id_pemasukan : $this->kode->pemasukan() ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tanggal</label>
                            <input  readonly type="date" name="tanggal_pemasukan" max="<?= date('Y-m-d') ?>"
                                class="form-control" required
                                value="<?= isset($data) ? $data->tanggal_pemasukan : '' ?>">
                        </div>
                      
                        <div class="form-group col-md-12">
                            <label>Akun</label>
                            <select disabled name="akun" class="form-control" required>
                                <option value="">-- Pilih Salah Satu --</option>
                                <?php foreach ($akun as $row) { ?>
                                <option <?= isset($data) && $data->akun == $row->id_akun ? 'selected' : '' ?>
                                    value="<?= $row->id_akun ?>"><?= $row->kode_akun ?> | <?= $row->nama_akun ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                      
                        <div class="form-group col-md-12">
                            <label>Keterangan</label>
                            <input readonly type="text" name="keterangan" class="form-control" required
                                value="<?= isset($data) ? $data->keterangan : '' ?>">
                        </div>

                        <div class="form-group col-md-12">
                            <label>Invoice</label>
                            <br>
                           <a href="<?php echo base_url('uploads/'.$data->invoice)?>" target="_blank"> <img src="<?php echo base_url('uploads/'.$data->invoice)?>" width="30%"></a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="col-lg-12 connectedSortable">
                <div class="box box-danger">
                    <div class="box-body row">
                        <div class="form-group col-md-12">
                            <h4>Data Produk</h4>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-highlight">
                                    <thead class="text-center">
                                        <th width="30%">Nama Produk</th>
                                        <th width="10%">Kuantitas</th>
                                        <th width="30%">Harga</th>
                                        <th width="10%">Subtotal</th>
                                    </thead>
                                    <tbody class="input-warp">
                                        <?php 

                                        foreach ($details as $d) {?>                                        
                                        <tr class="row-input">
                                            <td><select  disabled class="form-control deskripsi table-input item select-field"
                                                    style="width: 350px" aria-placeholder="Search Nama Barang. . ."
                                                    name="id_produk[]" value="" autocomplete='false' required />
                                                <option value="">Silahkan Pilih Produk</option>
                                                <?php foreach ($produk as $row) { ?>
                                                <option
                                                    <?= isset($data) && $d->produk == $row->id_produk ? 'selected' : '' ?>
                                                    value="<?= $row->id_produk ?>"><?= $row->nama_produk ?></option>
                                                <?php } ?>
                                                </select>
                                            </td>
                                            <td><input readonly type="number"
                                                    class="form-control table-input jumlah quantity-field"
                                                    min="1" step="any" name="jumlah[]" value="<?php echo $d->qty?>"
                                                    autocomplete='false' required />
                                            </td>
                                            <td><input readonly type="text" class="form-control harga table-input harga-field"
                                                    name="harga[]" value="<?php echo 'Rp'.number_format($d->harga,0,",",".")?>" required /> </td>
                                            <td><input readonly type="text"
                                                    class="form-control table-input total subtotal-field"
                                                    maxlength="100" name="total[]" value="<?php echo 'Rp'.number_format($d->total,0,",",".")?>" required />
                                            </td>
                                         
                                        </tr>
                                        <?php 

                                        }

                                        ?>
                                    </tbody>
                                </table>
                              
                            </div>
                        </div>
                    </div>
                 
        </form>
    </div>
    </div>
</section>
<script>
    $('b[role="presentation"]').hide();
</script>