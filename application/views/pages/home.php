<section class="content">
  <!-- Main row -->
  <div class="row">

    <section class="col-lg-4 connectedSortable">
      <div class="box box-danger">
        <div class="box-body text-center">
          <h1>Pemasukan Bulan Ini<br> Rp. <?=number_format($this->db->query(" SELECT SUM(kredit) as kredit_ FROM tb_jurnal where month(tanggal) = '".date('m')."' and year(tanggal) = '".date('Y')."'")->row()->kredit_);?> </h1>
          
        </div>
      </div>
    </section>

    <section class="col-lg-4 connectedSortable">
      <div class="box box-danger">
        <div class="box-body text-center">
          <h1>Pengeluaran Bulan Ini<br> Rp. <?=number_format($this->db->query(" SELECT SUM(debit) as debit_ FROM tb_jurnal where month(tanggal) = '".date('m')."' and year(tanggal) = '".date('Y')."'")->row()->debit_);?> </h1>
          
        </div>
      </div>
    </section>

    <section class="col-lg-4 connectedSortable">
      <div class="box box-danger">
        <div class="box-body text-center">
          <h1>Saldo Bulan Ini<br> Rp. <?=number_format($this->db->query(" SELECT SUM(kredit) - SUM(debit) as totals_ FROM tb_jurnal where month(tanggal) = '".date('m')."' and year(tanggal) = '".date('Y')."'")->row()->totals_);?> </h1>
          
        </div>
      </div>
    </section>

    <section class="col-lg-12 connectedSortable">
      <div class="box box-danger">
        <div class="box-body text-center">
          <div id="container"></div>
          
        </div>
      </div>
    </section>
    

  </div>
</section>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>

Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Laba Rugi Tahun <?=date("Y")?>',
        align: 'center'
    },
    xAxis: {
        categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember'],
        crosshair: true,
        accessibility: {
            description: 'Countries'
        }
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        column: {
            borderRadius: '25%'
        }
    },
    tooltip: {
        valueSuffix: ' (1000 MT)'
    },
    series: [
        {
            name: 'Laba/Rugi',
            data: <?=json_encode($grafik,JSON_NUMERIC_CHECK) ?>
        }
    ]
});


</script>