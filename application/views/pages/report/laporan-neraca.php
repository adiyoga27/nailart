<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
      <div class="box box-danger">
        <div class="box-body">
          
          <form method="post" action="">
          <div class="row">
          <div class="col-md-3">
              <div class="form-group">
                <label>Tgl Mulai</label>
                <input class="form-control" type="date" name="startDate" value="<?php echo $startDate?>" required>
               
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Tgl Selesai</label>
                <input class="form-control" type="date" name="endDate" value="<?php echo $endDate?>" required>
               
              </div>
            </div>

            <div class="col-md-3">
              <button type="submit" name="button" value="filter" class="btn btn-info" style="margin-top: 23px"><span class="fa fa-refresh"></span> Filter</button>
              <button type="submit" name="button" value="cetak" class="btn btn-primary" style="margin-top: 23px"><span class="fa fa-print"></span> Cetak</button>
            </div>
          </div>
          </form>
           
        
        </div>
      </div>
    </section>

    <section class="col-lg-12 connectedSortable">
      <div class="box box-danger">
        <div class="box-body">
        <table class="table table-bordered table-striped" >
            <thead>
              <tr>
                <th colspan="2"  style="text-align: center !important;">Aktiva</th>
                <th colspan="2"  style="text-align: center !important;">Pasiva</th>
              </tr>
             
            </thead>
            <tbody>
              <tr  style="font-weight: bold;">
                <td colspan="2">Aktiva Lancar</td>
                <td  colspan="2">Kewajiban</td>
              </tr>
              <tr>
                <td>Kas</td>
                <td>Rp<?=number_format($data['kas'],0,",",".")?></td>
                <td>Hutang</td>
                <td>Rp<?=number_format($data['hutang'],0,",",".")?></td>
              </tr>
              <tr  style="font-weight: bold;">
                <td colspan="2">Aktiva Tetap</td>
                <td  colspan="2">Modal</td>
              </tr>
              <tr>
                <td>Perlengkapan</td>
                <td>Rp<?=number_format($data['perlengkapan'],0,",",".")?></td>
                <td>Modal Awal</td>
                <td>Rp<?=number_format($data['modal'],0,",",".")?></td>
              </tr>
              <td colspan="2"></td>
                <td>Laba Ditahan</td>
                <td>Rp<?=number_format($data['ditahan'],0,",",".")?></td>
              </tr>
              <tr  style="font-weight: bold;">
              
              <td>Total Aktiva</td>
              <td>Rp<?=number_format($data['kas']+$data['perlengkapan'],0,",",".")?></td>
              <td>Total Pasiva</td>
              <td>Rp<?=number_format($data['modal'] + $data['ditahan'] + $data['hutang'],0,",",".")?></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</section>