<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$title?> | Make Nail Studio</title>
    <link rel="shortcut icon" type="image/jpg" href="https://png.pngtree.com/png-clipart/20230819/original/pngtree-pie-chart-finance-report-icon-picture-image_8064418.png"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?=base_url('assets/')?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?=base_url('assets/')?>plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?=base_url('assets/')?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?=base_url('assets/')?>dist/css/skins/_all-skins.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  </head>
  <body class="hold-transition skin-red sidebar-mini" >
    <div class="wrapper" >

      <header class="main-header" > 
        <a href="#!" class="logo">
          <span class="logo-mini"></span>
          <span class="logo-lg">Make Nail Studio</span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs"><?=ucwords($this->session->userdata('nama'))?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="user-header">
                    <img src="https://www.tenforums.com/attachments/user-accounts-family-safety/322690d1615743307-user-account-image-log-user.png" class="img-circle" alt="User Image">
                    <p>
                      <?=ucwords($this->session->userdata('nama'))?>
                      <small><?=ucwords($this->session->userdata('level'))?></small>
                    </p>
                  </li>
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="<?=base_url('auth/logout')?>" onclick="return confirm('apakah anda yakin ingin keluar dari sistem ?')" class="btn btn-danger">Logout</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <aside class="main-sidebar" >
        <section class="sidebar" >
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

            <li class="<?=$side == 'dashboard' ? 'active':''?>">
              <a href="<?=base_url('dashboard')?>">
                <i class="fa fa-home"></i> <span>Dashboard</span> 
              </a>
            </li>

            <?php if ($this->session->userdata('level') == 'pemilik') { ?>
            <li class="<?=$side == 'user' ? 'active':''?>">
              <a href="<?=base_url('user')?>">
                <i class="fa fa-users"></i> <span>User</span> 
              </a>
            </li>
            <?php } ?>

            <?php if ($this->session->userdata('level') == 'admin') { ?>

            <li class="<?=$side == 'akun' ? 'active':''?>">
              <a href="<?=base_url('akun')?>">
                <i class="fa fa-bank"></i> <span>Akun</span> 
              </a>
            </li>

            <li class="<?=$side == 'produk' ? 'active':''?>">
              <a href="<?=base_url('produk')?>">
                <i class="fa fa-list"></i> <span>Produk</span> 
              </a>
            </li>



            <li class="<?=$side == 'pemasukan' ? 'active':''?>">
              <a href="<?=base_url('pemasukan')?>">
                <i class="fa fa-angle-double-left"></i> <span>Pemasukan</span> 
              </a>
            </li>

            <li class="<?=$side == 'pemasukan-lain' ? 'active':''?>">
              <a href="<?=base_url('pemasukan-lain')?>">
                <i class="fa fa-angle-double-left"></i> <span>Pemasukan Lainnya</span> 
              </a>
            </li>

            <li class="<?=$side == 'pengeluaran' ? 'active':''?>">
              <a href="<?=base_url('pengeluaran')?>">
                <i class="fa fa-angle-double-right"></i> <span>Pengeluaran</span> 
              </a>
            </li>
        
            <?php } ?>
            <li class="<?=$side == 'jurnal' ? 'active':''?>">
              <a href="<?=base_url('laporan/jurnal')?>">
                <i class="fa fa-angle-double-right"></i> <span>Jurnal Umum</span> 
              </a>
            </li>
            <li class="treeview <?=$side == 'kas' ? 'active' : ''?> 
                                <?=$side == 'labarugi' ? 'active' : ''?>
                                <?=$side == 'perubahan-modal' ? 'active' : ''?>
                                <?=$side == 'neraca' ? 'active' : ''?>

                                ">
              <a href="#">
                <i class="fa fa-print"></i> <span>Laporan</span>
              </a>
              <ul class="treeview-menu">
                <li class="<?=$side == 'kas' ? 'active' : ''?>"><a href="<?=base_url('laporan/arus_kas')?>"><i class="fa fa-circle-o"></i> Laporan Arus Kas</a></li>
                <!-- <li class="<?=$side == 'jurnal' ? 'active' : ''?>"><a href="<?=base_url('laporan/jurnal')?>"><i class="fa fa-circle-o"></i> Laporan Jurnal Umum</a></li> -->
                <li class="<?=$side == 'labarugi' ? 'active' : ''?>"><a href="<?=base_url('laporan/labarugi')?>"><i class="fa fa-circle-o"></i> Laporan Laba Rugi</a></li>
                <li class="<?=$side == 'perubahan-modal' ? 'active' : ''?>"><a href="<?=base_url('laporan/perubahan_modal')?>"><i class="fa fa-circle-o"></i> Laporan Perubahan Modal</a></li>
                <li class="<?=$side == 'neraca' ? 'active' : ''?>"><a href="<?=base_url('laporan/neraca')?>"><i class="fa fa-circle-o"></i> Laporan Neraca</a></li>
              </ul>
            </li>


            <li >
              <a onclick="return confirm('apakah anda yakin ?')" href="<?=base_url('auth/logout')?>">
                <i class="fa fa-sign-out text-danger"></i> <span>Logout</span> 
              </a>
            </li>
          </ul>
        </section>
      </aside>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            <?=ucwords($title)?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard')?>"><i class="fa fa-home"></i> Home</a></li>
            <li class="active"><?=ucwords($title)?></li>
          </ol>
        </section>

        <?php $this->load->view($page)?>

      </div>
      <footer class="main-footer text-center hide-on-print">
        Copyright &copy; <?=date('Y')?> <strong>Sistem Informasi Keuangan Make Nail Studio</strong>. All rights reserved.
      </footer>
      <div class="control-sidebar-bg"></div>
    </div>


    <script src="<?=base_url('assets/')?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?=base_url('assets/')?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=base_url('assets/')?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url('assets/')?>plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?=base_url('assets/')?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=base_url('assets/')?>plugins/fastclick/fastclick.min.js"></script>
    <script src="<?=base_url('assets/')?>dist/js/app.min.js"></script>
    <script src="<?=base_url('assets/')?>dist/js/demo.js"></script>
    

    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?=base_url('assets/')?>alert.js"></script>
    <?php echo "<script>".$this->session->flashdata('msg')."</script>"?>
    <script>
      $(function () {
         $('.select2').select2();
         $( ".selecmax" ).select2( {
            // theme: "bootstrap",
            placeholder: "Pilih aset...",
            // maximumSelectionLength: 2,
            containerCssClass: ':all:'
          } );
        $('[data-toggle="tooltip"]').tooltip()
        $("#tabel").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
  </body>
</html>
