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
                            <input type="text" readonly name="kode" class="form-control" required
                                value="<?= isset($data) ? $data->id_pemasukan : $this->kode->pemasukan() ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal_pemasukan" max="<?= date('Y-m-d') ?>"
                                class="form-control" required
                                value="<?= isset($data) ? $data->tanggal_pemasukan : '' ?>">
                        </div>
                        <!-- <div class="form-group col-md-12">
                            <label>Produk</label>
                            <select <?= isset($data) ? 'name="produk"' : 'multiple="multiple" name="produk[]"' ?>
                                class="form-control <?= isset($data) ? '' : 'select2' ?>" required>
                                <?php foreach ($produk as $row) { ?>
                                <option <?= isset($data) && $data->produk == $row->id_produk ? 'selected' : '' ?>
                                    value="<?= $row->id_produk ?>"><?= $row->nama_produk ?> | Rp.
                                    <?= number_format($row->harga) ?></option>
                                <?php } ?>
                            </select>
                            <?= isset($data) ? '' : '<small><i>Anda bisa menambahkan lebih dari 1 produk</i></small>' ?>
                        </div> -->
                        <!--  -->
                        <div class="form-group col-md-6">
                            <label>Akun</label>
                            <select name="akun" class="form-control" required>
                                <option value="">-- Pilih Salah Satu --</option>
                                <?php foreach ($akun as $row) { ?>
                                <option <?= isset($data) && $data->akun == $row->id_akun ? 'selected' : '' ?>
                                    value="<?= $row->id_akun ?>"><?= $row->kode_akun ?> | <?= $row->nama_akun ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Invoice</label>
                            <input type="file" name="invoice" <?= isset($data) ? '' : 'required' ?>
                                class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Nama</label>
                            <input type="text" name="customer_nama" value="<?=  isset($data) ? $data->customer_nama : '' ?>"
                                class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Telepon</label>
                            <input type="text" name="customer_phone" value="<?=  isset($data) ? $data->customer_phone : '' ?>"
                                class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" required
                                value="<?= isset($data) ? $data->keterangan : '' ?>">
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
                                        <th>Action</th>
                                    </thead>
                                    <tbody class="input-warp">
                                        <?php 

                                        foreach ($details as $d) {?>                                        
                                        <tr class="row-input">
                                            <td><select class="form-control deskripsi table-input item select-field"
                                                    style="width: 350px" aria-placeholder="Search Nama Barang. . ."
                                                    name="id_produk[]" value="" autocomplete='false' required />
                                                <option value="">Silahkan Pilih Produk</option>
                                                <?php foreach ($produk as $row) { ?>
                                                <option
                                                    <?= isset($data) && $d->produk == $row->id_produk ? 'selected' : '' ?>
                                                    value="<?= $row->id_produk ?>"><?= $row->nama_produk ?></option>
                                                <?php } ?>
                                                <select>
                                            </td>
                                            <td><input type="number"
                                                    class="form-control table-input jumlah quantity-field"
                                                    min="1" step="any" name="jumlah[]" value="<?php echo $d->qty?>"
                                                    autocomplete='false' required />
                                            </td>
                                            <td><input type="number" class="form-control harga table-input harga-field"
                                                    name="harga[]" value="<?php echo $d->harga?>" required /> </td>
                                            <td><input type="text"
                                                    class="form-control table-input total subtotal-field"
                                                    maxlength="100" name="total[]" value="<?php echo $d->total?>" required />
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-danger remove-row">-</a>
                                            </td>
                                        </tr>
                                        <?php 

                                        }

                                        ?>
                                    </tbody>
                                </table>
                                <a class="btn btn-sm btn-success btn_tambah"><i class="zmdi zmdi-plus"></i>+ Tambah
                                    Produk</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="<?= $this->agent->referrer() ?>" class="btn btn-danger">Kembali</a>
                        <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
                        <button id="save" role="button" href="javascript:void(0)"
                            class="btn btn-primary btn-ok submit">Simpan</button>
                    </div>
        </form>
    </div>
    </div>
</section>
<script src="<?= base_url('assets/') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).on("click", ".btn_tambah", function(e) {
        e.stopPropagation();
        e.preventDefault();

        var row = $(this).parent().find(".row-input").eq(0).clone().show();
        row.find('[select]').val('');
        row.find('[type=text]').val('');
        row.find('[type=number]').val('');
        $(this).parent().find(".input-warp").append(row);
        row.find('select').val(null).trigger('change');
    });

    $(document).on("change", ".select-field", function() {
        var selectedValue = $(this).val();
        var row = $(this).closest(".row-input");

        // Fetch hargaData from an API
        $.ajax({
            url: '/api/product/' + selectedValue,
            method: 'GET',
            dataType: 'json',
            success: function(response) {

                // Set the harga value in the corresponding row
                row.find(".harga").val(response.data.harga);

            },
            error: function(xhr, status, error) {
                console.error("Error fetching data from API:", error);
            }
        });

    });
    $(document).on("change", ".quantity-field", function() {
        var quantity = parseFloat($(this).val());
        var harga = parseFloat($(this).closest(".row-input").find(".harga-field").val());
        if (!isNaN(quantity) && !isNaN(harga)) {
            var subtotal = quantity * harga;
            $(this).closest(".row-input").find(".subtotal-field").val(subtotal);
        } else {
            // Jika jumlah atau harga tidak valid, kosongkan subtotal
            $(this).closest(".row-input").find(".subtotal-field").val('');
        }
    });
    $(document).on("click", ".remove-row", function(e) {
        e.stopPropagation();
        e.preventDefault();
        var row = $(this).parent().parent().parent().find('.remove-row');
        if (row.length > 1) {
            $(this).parent().parent().remove();
        }
    });
</script>
