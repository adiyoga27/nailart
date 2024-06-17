<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Make Nail Studio</title>
    <link rel="shortcut icon" type="image/jpg" href="https://png.pngtree.com/png-clipart/20230819/original/pngtree-pie-chart-finance-report-icon-picture-image_8064418.png"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/skins/_all-skins.min.css">
  </head>
  
  <body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
      <div class="content-wrapper">
        <div class="container">
          <section class="content">
            <div class="login-box">
              <div class="login-logo">
                <h3>Sistem Informasi Keuangan<br>Make Nail Studio</h3> 
              </div>
              <div class="login-box-body">
                <p class="login-box-msg">Silahkan Registrati data User</p>
                <form action="" method="post">
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Masukan nama user" required name="nama_user" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Masukan email user..." required name="email" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Masukan nomor telp user..." required name="nomor_telfon" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Masukan alamat user..." required name="alamat" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                  <select class="form-control" name="level" required>
                    <option value="">Pilih Level</option>
                    <option value="admin">Admin</option>
                    <option value="pemilik">Pemilik</option>
                  </select>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Masukan username" required name="username" required> 
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" required name="password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
           
                 
                  <div class="row">
                    <div class="col-xs-12">
                      <button type="submit" class="btn btn-danger btn-block btn-flat">Daftar</button>
                    </div>
                  </div>
                </form>
                <br>
                <center>&copy; <?=date('Y')?> Sistem Informasi Keuangan Make Nail Studio</center>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>


    <script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?=base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/fastclick/fastclick.min.js"></script>
    <script src="<?=base_url()?>assets/dist/js/app.min.js"></script>
    <script src="<?=base_url()?>assets/dist/js/demo.js"></script>
    <script src="<?=base_url('assets/')?>alert.js"></script>
    <?php echo "<script>".$this->session->flashdata('msg')."</script>"?>
  </body>
</html>
