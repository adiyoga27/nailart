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
                        <div class="form-group col-md-12">
                            <label>Akun</label>
                            <select name="akun"  onmousedown="(function(e){ e.preventDefault(); })(event, this)" class="form-control" readonly required>
                                <option value="">-- Pilih Salah Satu --</option>
                                <?php foreach ($akun as $row) { ?>
                                <option <?=  12 == $row->id_akun ? 'selected' : '' ?>
                                    value="<?= $row->id_akun ?>"><?= $row->kode_akun ?> | <?= $row->nama_akun ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- <div class="form-group col-md-6">
                            <label>Invoice</label>
                            <input type="file" name="invoice" <?= isset($data) ? '' : 'required' ?>
                                class="form-control">
                        </div> -->
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
                            <h4>Detail Pemasukan</h4>
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
                                            <td style="display:none;"><input type="number" class="form-control harga table-input harga-field"
                                                    name="harga[]" value="<?php echo $d->harga?>" required /> </td>
                                                    <td><input type="number" class="form-control harga view-harga table-input"
                                                    value="<?php echo number_format($d->harga,0,",",".")?>" readonly required /> </td>
                                            <td><input type="text"
                                                    class="form-control table-input total subtotal-field"
                                                    maxlength="100" readonly name="total[]" value="<?php echo number_format($d->total,0,",",".")?>" required />
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
                                    <br>
                                <div class="row right">
                                    <div class="form-group col-md-9"></div>
                                    <div class="form-group col-md-3">
                                            <label>Total Pembelanjaan</label>
                                            <input type="text" name="totalBayar" value="<?php echo number_format($data->harga,0,",",".")?>"  readonly
                                                class="form-control total-sum-field">
                                    </div>
                                    <div class="form-group col-md-9"></div>
                                    <div class="form-group col-md-3">
                                            <label>Jumlah Pembayaran</label>
                                            <input type="text" name="bayar"   value="<?php echo number_format($data->bayar,0,",",".")?>" 
                                                class="form-control uang">
                                    </div>
                                    <div class="form-group col-md-9"></div>
                                    <div class="form-group col-md-3">
                                            <label>Sisa</label>
                                            <input type="text" name="kembalian"  value="<?php echo number_format($data->kembalian,0,",",".")?>"  readonly
                                                class="form-control sisa">
                                    </div>
                                </div>
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
    $(document).on("change", ".uang", function() {
        var pembayaran = parseFloat($(this).val().replace(/\./g, ''));
        var total = parseFloat($('.total-sum-field').val().replace(/\./g, ''));
        var sisa = pembayaran-total;
        $(".sisa").val(numberWithCommas(sisa));
    });
    $(document).on("change", ".quantity-field", function() {
        var quantity = parseFloat($(this).val());
        var harga = parseFloat($(this).closest(".row-input").find(".harga-field").val());
        if (!isNaN(quantity) && !isNaN(harga)) {
            var subtotal = quantity * harga;
            $(this).closest(".row-input").find(".subtotal-field").val(numberWithCommas(subtotal));
            $(this).closest(".row-input").find(".view-harga").val(numberWithCommas(harga));
        } else {
            // Jika jumlah atau harga tidak valid, kosongkan subtotal
            $(this).closest(".row-input").find(".subtotal-field").val('');
        }

        var totalSum = 0;
        $(".subtotal-field").each(function() {
            var subtotalValue = parseFloat($(this).val().replace(/\./g, ''));
            if (!isNaN(subtotalValue)) {
                totalSum += subtotalValue;
            }
        });

        // Display the total sum
        $(".total-sum-field").val(numberWithCommas(totalSum));
    });
    $(document).on("click", ".remove-row", function(e) {
        e.stopPropagation();
        e.preventDefault();
        var row = $(this).parent().parent().parent().find('.remove-row');
        if (row.length > 1) {
            $(this).parent().parent().remove();
        }
    });
    function numberWithCommas(x) {
        return x.toLocaleString('en-US').replace(/,/g, '.');
    }
    $(document).ready(function() {
        // Event listener for keyup on elements with class 'tanpa_rupiah'
        $('.uang').keyup(function(e) {
            // Call formatRupiah function and update the value of the input field
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
