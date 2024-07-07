<style>
    input[readonly] {
        background-color: white !important;
    }

    select {

        background: white !important;
    }
    
</style>
<style media="print">
    /* Hide specific elements */
    .hide-on-print {
        display: none;
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
                        <div class="container-fluid">

                            <div class="row" style="margin-right: 20px; margin-left:20px">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="invoice-title">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                    <h4 class="float-end font-size-16">MAKE NAIL STUDIO</h4>


                                                    </div>
                                                    <div class="col-md-6" style="text-align:end">
                                                        <h4 class="float-end font-size-16">Order # <?=$data->id_pemasukan?></h4>

                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <address>
                                                            <strong>Customer:</strong><br>
                                                            <?=$data->customer_nama?><br>
                                                            <?=$data->customer_phone?><br>
                                                        </address>
                                                    </div>
                                                    <div class="col-sm-6 text-sm-end" style="text-align:end">
                                                        <address>
                                                            <strong>Order Date:</strong><br>
                                                            <?php echo date('d F Y', strtotime($data->tanggal_pemasukan))?><br>
                                                        </address>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12  text-sm-start">
                                                        <address>
                                                            <strong>Keterangan:</strong><br>
                                                            <?php echo $data->keterangan?>
                                                        </address>
                                                    </div>

                                                </div>
                                                <div class="py-2 mt-3 text-sm-end">
                                                    <h3 class="font-size-15 fw-bold">Data Pembelian</h3>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 70px;">No.</th>
                                                                <th>Barang</th>
                                                                <th>Harga</th>
                                                                <th>Jumlah</th>
                                                                <th class="text-end">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                <?php 
                                $i = 1;
                            foreach ($details as $key => $value) {
                                # code...
?>
                                                            <tr>
                                                                <td><?=$i++?></td>
                                                                <td><?=$value->nama_produk?></td>
                                                                <td><?=$value->harga?></td>
                                                                <td><?=$value->qty?></td>
                                                                <td class="text-end"><?=number_format($value->total, 0,",",".")?></td>
                                                            </tr>

<?php
$total += $value->total;
                            }
?>
                                                            <tr>
                                                                <td colspan="4" class="border-0 text-end">
                                                                    <strong>Total</strong>
                                                                </td>
                                                                <td class="border-0 text-end">
                                                                    <h4 class="m-0">Rp<?=number_format($total, 0,",",".")?></h4>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" class="border-0 text-end">
                                                                    <strong>Pembayaran</strong>
                                                                </td>
                                                                <td class="border-0 text-end">
                                                                    <h4 class="m-0">Rp<?=number_format($value->bayar, 0,",",".")?></h4>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" class="border-0 text-end">
                                                                    <strong>Sisa</strong>
                                                                </td>
                                                                <td class="border-0 text-end">
                                                                    <h4 class="m-0">Rp<?=number_format($value->kembalian, 0,",",".")?></h4>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="d-print-none">
                                                    <div class="float-end">
                                                        <a href="<?php echo base_url('pemasukan')?>"
                                                            class="btn btn-primary waves-effect waves-light hide-on-print"><i
                                                                class="fa fa-home"></i> | Back</a>
                                                        <a href="javascript:window.print()"
                                                            class="btn btn-success w-md  waves-effect waves-light me-1 hide-on-print"><i
                                                                class="fa fa-print"></i> | Cetak</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                    </div>
            </section>


        </form>
    </div>
    </div>
</section>
<script>
    $('b[role="presentation"]').hide();
</script>
