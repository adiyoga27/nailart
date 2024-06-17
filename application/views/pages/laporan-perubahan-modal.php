<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
      <div class="box box-danger">
        <div class="box-body">
          
          <form method="post" action="">
          <button type="submit" name="button" value="cetak" class="btn btn-primary" ><span class="fa fa-print"></span> Cetak</button><br><br>
          </form>
          
          <table class="table table-bordered table-striped text-center" >
            <tbody>
              <tr>
                <td style="text-align: left">Modal</td>
                <td style="text-align: right">Rp. <?=number_format($data['modal'])?></td>
              </tr>

              <tr>
                <td style="text-align: left">Laba Bersih</td>
                <td style="text-align: right">Rp. <?=number_format($data['lababersih'])?></td>
              </tr>

              <tr style="border-bottom: 1px solid black">
                <td style="text-align: left; border-bottom: 1px solid black">Prive</td>
                <td style="text-align: right; border-bottom: 1px solid black">Rp. <?=number_format($data['prive'])?></td>

              </tr>

              <tr>
                <td style="text-align: left"><b>Modal Akhir</b></td>
                <td style="text-align: right"><b>Rp. <?=number_format($data['modal'] + $data['lababersih'] - $data['prive'])?></b></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</section>