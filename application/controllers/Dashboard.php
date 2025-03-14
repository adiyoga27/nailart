<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //pengkodisian jika user yang mengakses dashboar belum login
        if (empty($this->session->userdata('kode'))) {
            $this->session->set_flashdata('msg', 'swal("Ops!", "Anda belum login", "info");');
            redirect(base_url('auth'));
        }
    }

    //jika halaman tidak ditemukan
    public function error()
    {
        $this->session->set_flashdata('msg', 'swal("Ops!", "Halaman tidak di temukan", "error");');
        redirect(base_url('dashboard'));
    }

    //halaman awal
    public function index()
    {
        if ( function_exists( 'date_default_timezone_set' ) ) {
            date_default_timezone_set('Asia/Makassar');
        }
        $pbi = $this->data->akunTotalKredit(12, date('Y-m-01'), date('Y-m-d'));
        $plbi = $this->data->akunTotalKredit(23, date('Y-m-01'), date('Y-m-d'));
        $pengeluaranBI = $this->data->akunTotalDebit(13, date('Y-m-01'), date('Y-m-d')) - $this->data->akunTotalDebit(24, date('Y-m-01'), date('Y-m-d'));
        
        $data['data'] = array(
            'pemasukan_bulan_ini' => $pbi,
            'pemasukan_lainnya_bulan_ini' => $plbi,
            'pengeluaran_bulan_ini' => $pengeluaranBI,
            'saldo' => ($pbi+$plbi)+$pengeluaranBI,
        );
        $data['grafik'] = $this->data->grafik();
        $data['title'] = 'Dashboard';
        $data['side'] = 'dashboard';
        $data['page'] = 'pages/home';
        $this->load->view('template', $data);
    }

    // CURD USER
    public function user()
    {
        $data['data'] = $this->data->user()->result();
        $data['title'] = 'Data User';
        $data['side'] = 'user';
        $data['page'] = 'pages/user';
        $this->load->view('template', $data);
    }
    public function add_user()
    {
        if ($p = $this->input->post()) {
            $data = [
                'nama_user' => $p['nama'],
                'username' => $p['username'],
                'email' => $p['email'],
                'alamat' => $p['alamat'],
                'level' => $p['level'],
                'nomor_telfon' => $p['nomor_telfon'],
                'password' => md5($p['password']),
            ];
            $this->db->insert('user', $data);
            $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil disimpan", "success");');
            redirect(base_url('user'));
        } else {
            $data['title'] = 'Tambah Data User';
            $data['side'] = 'user';
            $data['page'] = 'pages/user-form';
            $this->load->view('template', $data);
        }
    }
    public function edit_user($kode)
    {
        if ($p = $this->input->post()) {
            $data = [
                'nama_user' => $p['nama'],
                'username' => $p['username'],
                'email' => $p['email'],
                'alamat' => $p['alamat'],
                'level' => $p['level'],
                'nomor_telfon' => $p['nomor_telfon'],
            ];
            if ($p['password'] != '' and $p['password'] != null) {
                $data['password'] = md5($p['password']);
            }
            $this->db->update('user', $data, ['id_user' => $kode]);
            $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil diubah", "success");');
            redirect(base_url('user'));
        } else {
            $data['data'] = $this->data->user($kode)->row();
            $data['title'] = 'Update Data User';
            $data['side'] = 'user';
            $data['page'] = 'pages/user-form';
            $this->load->view('template', $data);
        }
    }
    public function delete_user($kode)
    {
        $this->db->delete('user', ['id_user' => $kode]);
        $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil dihapus", "success");');
        redirect(base_url('user'));
    }

    // CURD AKUN
    public function akun()
    {

       $results= $this->data->akun()->result();
       foreach ($results as $value) {
            $saldo = $this->db->query(" SELECT SUM(kredit) - SUM(debit) as total_ FROM tb_jurnal where akun = '".$value->id_akun."'")->row()->total_;
            if($saldo < 0){
                $saldo = $saldo * -1;
            }

            if($value->kode_akun == 101){
                $saldo = $this->db->query(" SELECT  SUM(kredit-debit) as total_ FROM tb_jurnal")->row()->total_;
            }
            $akuns[] = [
                'id_akun' => $value->id_akun,
                'kode_akun' => $value->kode_akun,
                'nama_akun' => $value->nama_akun,
                'kategori_akun' => $value->kategori_akun,
                'tipe_akun' => $value->tipe_akun,
                'saldo' => $saldo ?? 0,
            ];

       }
                   
        $data['data'] = $akuns;
        $data['title'] = 'Data Akun';
        $data['side'] = 'akun';
        $data['page'] = 'pages/akun';
        $this->load->view('template', $data);
    }

    public function add_akun()
    {
        if ($p = $this->input->post()) {
        
            $data = [
                'kode_akun' => $p['kode_akun'],
                'nama_akun' => $p['nama_akun'],
                'kategori_akun' => $p['kategori_akun'],
                'tipe_akun' => $p['tipe_akun'],
            ];
            $this->db->insert('akun', $data);
            $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil disimpan", "success");');
            redirect(base_url('akun'));
        } else {
            $data['title'] = 'Tambah Data akun';
            $data['side'] = 'akun';
            $data['page'] = 'pages/akun-form';
            $this->load->view('template', $data);
        }
    }

    public function edit_akun($kode)
    {
        if ($p = $this->input->post()) {
            $data = [
                'kode_akun' => $p['kode_akun'],
                'nama_akun' => $p['nama_akun'],
                'kategori_akun' => $p['kategori_akun'],
                'tipe_akun' => $p['tipe_akun'],

            ];
            $this->db->update('akun', $data, ['id_akun' => $kode]);
            $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil diubah", "success");');
            redirect(base_url('akun'));
        } else {
            $data['data'] = $this->data->akun($kode)->row();
            $data['title'] = 'Update Data Akun';
            $data['side'] = 'akun';
            $data['page'] = 'pages/akun-form';
            $this->load->view('template', $data);
        }
    }

    public function delete_akun($kode)
    {
        try {
            //code...
            $this->db->delete('akun', ['id_akun' => $kode]);
            $this->db->delete('tb_jurnal', ['akun' => $kode]);
            $this->db->delete('tb_pemasukan_lain', ['akun' => $kode]);
    
            $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil dihapus", "success");');
             redirect(base_url('akun'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAkun($id) {
        $result = $this->db->select('*')
            ->from('akun')
            ->where('kategori_akun', $id)
            ->order_by('id_akun', 'DESC')
            ->get()->row();
        
        $kode = $result->kode_akun;
        if(!isset($kode)){
            switch ($result->kategori_akun) {
                case 'aset': $kode = 101; 
                  break;
                case 'pendapatan': $kode = 201 ;
                  break;
                case 'pendapatan': $kode = 401 ;
                  break;
                case 'beban': $kode = 501 ;
                  break;
                case 'modal': $kode = 301 ;
                  break;
                case 'prive': $kode = 601 ;
                  break;
                default:
                $kode = 601 ;
                  break;
              }
        }else{
            $kode = $kode + 1;
        }
        echo json_encode([
            'status' => true,
            'message' => 'succcess',
            'data' => $kode
        ]);
        exit;
    }

    public function produk()
    {
        $data['data'] = $this->data->produk()->result();
        $data['title'] = 'Data Produk';
        $data['side'] = 'produk';
        $data['page'] = 'pages/produk';
        $this->load->view('template', $data);
    }

    public function add_produk()
    {
        if ($p = $this->input->post()) {
            $data = [
                'kode_produk' => $p['kode_produk'],
                'nama_produk' => $p['nama_produk'],
                'keterangan' => $p['keterangan'],
                'harga' => $p['harga'],
                'user' => $this->session->userdata('kode'),
            ];
            $this->db->insert('produk', $data);
            $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil disimpan", "success");');
            redirect(base_url('produk'));
        } else {
            $data['title'] = 'Tambah Data Produk';
            $data['side'] = 'produk';
            $data['page'] = 'pages/produk-form';
            $this->load->view('template', $data);
        }
    }

    public function edit_produk($kode)
    {
        if ($p = $this->input->post()) {
            $data = [
                'kode_produk' => $p['kode_produk'],

                'nama_produk' => $p['nama_produk'],
                'keterangan' => $p['keterangan'],
                'harga' => $p['harga'],
                'user' => $this->session->userdata('kode'),
            ];
            $this->db->update('produk', $data, ['id_produk' => $kode]);
            $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil diubah", "success");');
            redirect(base_url('produk'));
        } else {
            $data['data'] = $this->data->produk($kode)->row();
            $data['title'] = 'Update Data Produk';
            $data['side'] = 'produk';
            $data['page'] = 'pages/produk-form';
            $this->load->view('template', $data);
        }
    }

    public function getProduct($productID)
    {
        echo json_encode([
            'status' => true,
            'data' => $this->data->produk($productID)->row(),
        ]);
        return;
    }

    public function delete_produk($kode)
    {
        $this->db->delete('produk', ['id_produk' => $kode]);
        $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil dihapus", "success");');
        redirect(base_url('produk'));
    }

    // CURD PEMASUKAN LAIN
    public function pemasukan_lain()
    {
        $data['data'] = $this->data->pemasukan_lain()->result();
        $data['title'] = 'Data Pemasukan Lain-Lain';
        $data['side'] = 'pemasukan-lain';
        $data['page'] = 'pages/pemasukan-lain';
        $this->load->view('template', $data);
    }

    public function add_pemasukan_lain()
    {
        if ($p = $this->input->post()) {
            $kode = $p['kode'];

            $data = [
                'id_transaksi' => $kode,
                'akun' => $p['akun'],
                'akun_pengeluaran' => $p['akun_pengeluaran'],

                'jumlah' => $p['jumlah'],
                'tanggal_transaksi' => $p['tanggal_transaksi'],
                'keterangan' => $p['keterangan'],
                'user' => $this->session->userdata('kode'),
            ];

            $produk = $this->data->produk($data['produk'])->row();

            $jurnal = [
                'kode_transaksi' => $data['id_transaksi'],
                'user' => $data['user'],
                'akun' => $data['akun'],
                'akun_pengeluaran' => $p['akun_pengeluaran'],
                'tanggal' => $data['tanggal_transaksi'],
                'debit' => 0,
                'kredit' => $data['jumlah'],
                'keterangan' => 'Pemasukan dari ' . $data['keterangan'],
            ];

            $this->db->trans_start();
            $this->db->insert('pemasukan_lain', $data);
            $this->db->insert('jurnal', $jurnal);
            $this->db->trans_complete();
            $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil disimpan", "success");');
            redirect(base_url('pemasukan-lain'));
        } else {
            $data['akun'] = $this->data->akun()->result();
            $data['produk'] = $this->data->produk()->result();
            $data['title'] = 'Tambah Data Pemasukan Lain-Lain';
            $data['side'] = 'pemasukan-lain';
            $data['page'] = 'pages/pemasukan-lain-form';
            $this->load->view('template', $data);
        }
    }

    public function edit_pemasukan_lain($kode)
    {
        if ($p = $this->input->post()) {
            $data = [
                'akun' => $p['akun'],
                'akun_pengeluaran' => $p['akun_pengeluaran'],

                'jumlah' => $p['jumlah'],
                'tanggal_transaksi' => $p['tanggal_transaksi'],
                'keterangan' => $p['keterangan'],
                'user' => $this->session->userdata('kode'),
            ];

            $produk = $this->data->produk($data['produk'])->row();

            $jurnal = [
                'user' => $data['user'],
                'akun' => $data['akun'],
                'akun_pengeluaran' => $p['akun_pengeluaran'],

                'tanggal' => $data['tanggal_transaksi'],
                'debit' => 0,
                'kredit' => $data['jumlah'],
                'keterangan' => 'Pemasukan dari ' . $data['keterangan'],
            ];

            $this->db->trans_start();
            $this->db->update('pemasukan_lain', $data, ['id_transaksi' => $kode]);
            $this->db->update('jurnal', $jurnal, ['kode_transaksi' => $kode]);
            $this->db->trans_complete();
            $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil diubah", "success");');
            redirect(base_url('pemasukan-lain'));
        } else {
            $data['akun'] = $this->data->akun()->result();
            $data['data'] = $this->data->pemasukan_lain($kode)->row();
            $data['title'] = 'Update Data Pemasukan Lain-Lain';
            $data['side'] = 'pemasukan-lain';
            $data['page'] = 'pages/pemasukan-lain-form';
            $this->load->view('template', $data);
        }
    }

    public function delete_pemasukan_lain($kode)
    {
        $this->db->trans_start();
        $this->db->delete('pemasukan_lain', ['id_transaksi' => $kode]);
        $this->db->delete('jurnal', ['kode_transaksi' => $kode]);
        $this->db->trans_complete();

        $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil dihapus", "success");');
        redirect(base_url('pemasukan-lain'));
    }

    // CURD PEMASUKAN
    public function pemasukan()
    {
        $data['data'] = $this->data->pemasukan()->result();
        $data['title'] = 'Data Pemasukan';
        $data['side'] = 'pemasukan';
        $data['page'] = 'pages/pemasukan';
        $this->load->view('template', $data);
    }

    public function add_pemasukan()
    {
        if ($p = $this->input->post()) {
            try {
                $this->db->trans_start();
                $kode = $p['kode'];
                if($this->db->get_where('pemasukan', ['id_pemasukan' => $p['kode']])->num_rows() > 0){
                    $kode = $this->kode->pemasukan();
                }
                // $img = $kode;

                // $config['upload_path'] = './uploads/';
                // $config['allowed_types'] = '*';
                // $config['file_name'] = $img;
                // $config['overwrite'] = true;

                // $this->load->library('upload', $config);

                // if (!$this->upload->do_upload('invoice')) {
                //     $error = ['error' => $this->upload->display_errors()];
                //     print_r($error);
                //     exit();
                //     $this->session->set_flashdata('msg', 'swal("Ops!", "Invoice gagal diupload", "error");');
                //     redirect(base_url('pemasukan'));
                // }

                // $upload = $this->upload->data();

                $total = 0;
                for ($i = 0; $i < count($p['id_produk']); $i++) {
                    $total += str_replace('.', '',$p['total'][$i]);

                    //Pemasukkan Detail
                    $this->db->insert('pemasukan_detail', [
                        'id_pemasukan' => $kode,
                        'produk' => $p['id_produk'][$i],
                        'harga' => str_replace('.', '',$p['harga'][$i]),
                        'qty' => $p['jumlah'][$i],
                        'total' => str_replace('.', '',$p['total'][$i]),
                    ]);
                    // $produk = $this->data->produk($p['id_produk'][$i])->row();

                 
                }
                   // Pemasukkan Jurnal
                $this->db->insert('jurnal', [
                    'kode_transaksi' => $kode,
                    'user' => $this->session->userdata('kode'),
                    'akun' => 11,
                    'akun_pengeluaran' => $p['akun'],
                    'tanggal' => $p['tanggal_pemasukan'],
                    'debit' => 0,
                    'kredit' => $total,
                    'keterangan' => 'Pendapatan TRX ' . $kode,
                ]);
                $this->db->insert('pemasukan', [
                    'id_pemasukan' => $kode,
                    'akun' => 11,
                    'harga' => str_replace('.', '',$total),
                    'tanggal_pemasukan' => $p['tanggal_pemasukan'],
                    'keterangan' => $p['keterangan'],
                    // 'invoice' => $upload['file_name'],
                    'bayar' => str_replace('.', '',$p['bayar']),
                    'kembalian' => str_replace('.', '',$p['kembalian']),
                    'customer_nama' => $p['customer_nama'],
                    'customer_phone' => $p['customer_phone'],
                    'user' => $this->session->userdata('kode'),
                ]);

                $this->db->trans_complete();

                $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil disimpan", "success");');
                redirect(base_url('pemasukan/view/'.$kode));
            } catch (\Throwable $th) {
                $this->session->set_flashdata('msg', 'swal("Error!", "Gagal Menyimpan", "error");');
                redirect(base_url('pemasukan'));
            }
        } else {
            $data['akun'] = $this->data->akun()->result();
            $data['produk'] = $this->data->produk()->result();
            $data['title'] = 'Tambah Data Pemasukan';
            $data['side'] = 'pemasukan';
            $data['page'] = 'pages/pemasukan-form';
            $this->load->view('template', $data);
        }
    }

    public function edit_pemasukan($kode)
    {
        if ($p = $this->input->post()) {
            try {
                $this->db->trans_start();

                $this->db->delete('pemasukan_detail', ['id_pemasukan' => $kode]);
                $this->db->delete('jurnal', ['kode_transaksi' => $kode]);

                $total = 0;
                for ($i = 0; $i < count($p['id_produk']); $i++) {
                    $total += str_replace('.', '',$p['total'][$i]);

                    //Pemasukkan Detail
                    $this->db->insert('pemasukan_detail', [
                        'id_pemasukan' => $p['kode'],
                        'produk' => $p['id_produk'][$i],
                        'harga' => str_replace('.', '',$p['harga'][$i]),
                        'qty' => $p['jumlah'][$i],
                        'total' => str_replace('.', '',$p['total'][$i]),
                    ]);
                    $produk = $this->data->produk($p['id_produk'][$i])->row();

                
                }
                    // Pemasukkan Jurnal
                    $this->db->insert('jurnal', [
                        'kode_transaksi' => $kode,
                        'user' => $this->session->userdata('kode'),
                        'akun' => $p['akun'],
                        'tanggal' => $p['tanggal_pemasukan'],
                        'debit' => 0,
                        'kredit' => $total,
                        'keterangan' => 'Pendapatan TRX ' . $kode,
                    ]);
                $data = [
                    'id_pemasukan' => $p['kode'],
                    'akun' => $p['akun'],
                    'harga' => str_replace('.', '',$total),
                    'tanggal_pemasukan' => $p['tanggal_pemasukan'],
                    'keterangan' => $p['keterangan'],
                    'bayar' => str_replace('.', '',$p['bayar']),
                    'kembalian' => str_replace('.', '',$p['kembalian']),
                    'customer_nama' => $p['customer_nama'],
                    'customer_phone' => $p['customer_phone'],
                    'user' => $this->session->userdata('kode'),
                ];
                // if (isset($p['invoice'])) {
                //     $img = $p['kode'];

                //     $config['upload_path'] = './uploads/';
                //     $config['allowed_types'] = '*';
                //     $config['file_name'] = $img;
                //     $config['overwrite'] = true;

                //     $this->load->library('upload', $config);

                //     if (!$this->upload->do_upload('invoice')) {
                //         $error = ['error' => $this->upload->display_errors()];
                //         print_r($error);
                //         exit();
                //         $this->session->set_flashdata('msg', 'swal("Ops!", "Invoice gagal diupload", "error");');
                //         redirect(base_url('pemasukan'));
                //     }
                //     $upload = $this->upload->data();
                //     $data['invoice'] = $upload['file_name'];
                // }
                $this->db->update('pemasukan', $data, [
					'id_pemasukan' => $kode,
				]);

                $this->db->trans_complete();

                $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil diubah", "success");');
                redirect(base_url('pemasukan'));
            } catch (\Throwable $th) {
                $this->session->set_flashdata('msg', 'swal("Error!", "Gagal Merubah Data", "error");');
                redirect(base_url('pemasukan'));
            }
        } else {
            $data['data'] = $this->data->pemasukan($kode)->row();
            $data['akun'] = $this->data->akun()->result();
            $data['produk'] = $this->data->produk()->result();
            $data['details'] = $this->data->details($kode)->result();
            $data['title'] = 'Update Data Pemasukan';
            $data['side'] = 'pemasukan';
            $data['page'] = 'pages/pemasukan-edit';

            $this->load->view('template', $data);
        }
    }

	public function view_pemasukan($kode)
    {
		$data['data'] = $this->data->pemasukan($kode)->row();
		$data['akun'] = $this->data->akun()->result();
		$data['produk'] = $this->data->produk()->result();

        $details = $this->db->from('tb_pemasukan_detail')
                    ->join('tb_pemasukan', 'tb_pemasukan.id_pemasukan = tb_pemasukan_detail.id_pemasukan')
                    ->join('tb_produk', 'tb_produk.id_produk = tb_pemasukan_detail.produk')
                    ->where('tb_pemasukan.id_pemasukan', $kode)
                    ->get()->result();

           


		$data['details'] = $details;
		$data['title'] = 'View Data Pemasukan';
		$data['side'] = 'pemasukan';
		$data['page'] = 'pages/invoicing';

		$this->load->view('template', $data);
	}

    public function delete_pemasukan($kode)
    {
        $this->db->trans_start();
        $this->db->delete('pemasukan', ['id_pemasukan' => $kode]);
        $this->db->delete('jurnal', ['kode_transaksi' => $kode]);
        $this->db->delete('pemasukan_detail', ['id_pemasukan' => $kode]);
        $this->db->trans_complete();

        $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil dihapus", "success");');
        redirect(base_url('pemasukan'));
    }

    // CURD PENGELUARAN
    public function pengeluaran()
    {
        $data['data'] = $this->data->pengeluaran()->result();
        $data['title'] = 'Data Pengeluaran';
        $data['side'] = 'pengeluaran';
        $data['page'] = 'pages/pengeluaran';
        $this->load->view('template', $data);
    }

    public function add_pengeluaran()
    {
        if ($p = $this->input->post()) {
            $kode = $this->kode->pengeluaran();

            // $config['upload_path'] = './uploads/';
            // $config['allowed_types'] = '*';
            // $config['file_name'] = $kode;
            // $config['overwrite'] = true;

            // $this->load->library('upload', $config);

            // if (!$this->upload->do_upload('invoice')) {
            //     $this->session->set_flashdata('msg', 'swal("Ops!", "Invoice gagal diupload", "error");');
            //     redirect(base_url('pengeluaran'));
            // }

            // $upload = $this->upload->data();

            $data = [
                'id_pengeluaran' => $kode,
                'keterangan' => $p['keterangan'],
                'akun' => $p['akun'],
                'akun_pengeluaran' => $p['akun_pengeluaran'],
                'jumlah' => $p['harga'],
                'tanggal_pengeluaran' => $p['tanggal_pengeluaran'],
                // 'invoice' => $upload['file_name'],
                'user' => $this->session->userdata('kode'),
            ];

            $jurnal = [
                'kode_transaksi' => $data['id_pengeluaran'],
                'user' => $data['user'],
                'akun' => $data['akun'],
                'akun_pengeluaran' => $p['akun_pengeluaran'],

                'tanggal' => $data['tanggal_pengeluaran'],
                'kredit' => 0,
                'debit' => $data['jumlah'],
                'keterangan' => $data['keterangan'],
            ];

            $this->db->trans_start();
            $this->db->insert('jurnal', $jurnal);
            $this->db->insert('pengeluaran', $data);
      
            $this->db->trans_complete();
            $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil disimpan", "success");');
            redirect(base_url('pengeluaran'));
        } else {
            $data['akun'] = $this->data->akun()->result();
            $data['produk'] = $this->data->produk()->result();
            $data['title'] = 'Tambah Data pengeluaran';
            $data['side'] = 'pengeluaran';
            $data['page'] = 'pages/pengeluaran-form';
            $this->load->view('template', $data);
        }
    }

    public function edit_pengeluaran($kode)
    {
        if ($p = $this->input->post()) {
            $data = [
                'keterangan' => $p['keterangan'],
                'akun' => $p['akun'],
                'akun_pengeluaran' => $p['akun_pengeluaran'],
                'jumlah' => $p['harga'],
                'tanggal_pengeluaran' => $p['tanggal_pengeluaran'],
                'user' => $this->session->userdata('kode'),
            ];

            $jurnal = [
                'user' => $data['user'],
                'akun' => $data['akun'],
                'akun_pengeluaran' => $p['akun_pengeluaran'],
                'tanggal' => $data['tanggal_pengeluaran'],
                'kredit' => 0,
                'debit' => $data['jumlah'],
                'keterangan' => $data['keterangan'],
            ];

            // $config['upload_path'] = './uploads/';
            // $config['allowed_types'] = '*';
            // $config['file_name'] = $kode;
            // $config['overwrite'] = true;

            // $this->load->library('upload', $config);

            // if ($this->upload->do_upload('invoice')) {
            //     $upload = $this->upload->data();
            //     $data['invoice'] = $upload['file_name'];
            // }

            $this->db->trans_start();
            $this->db->update('pengeluaran', $data, ['id_pengeluaran' => $kode]);
            $this->db->update('jurnal', $jurnal, ['kode_transaksi' => $kode]);


            $this->db->trans_complete();
            $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil disimpan", "success");');
            redirect(base_url('pengeluaran'));
        } else {
            $data['data'] = $this->data->pengeluaran($kode)->row();
            $data['akun'] = $this->data->akun()->result();
            $data['produk'] = $this->data->produk()->result();
            $data['title'] = 'Update Data Pengeluaran';
            $data['side'] = 'pengeluaran';
            $data['page'] = 'pages/pengeluaran-form';
            $this->load->view('template', $data);
        }
    }
    public function delete_pengeluaran($kode)
    {
        $this->db->trans_start();
        $this->db->delete('pengeluaran', ['id_pengeluaran' => $kode]);
        $this->db->delete('jurnal', ['kode_transaksi' => $kode]);
        $this->db->trans_complete();

        $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil dihapus", "success");');
        redirect(base_url('pengeluaran'));
    }

    // CURD hutang
    public function hutang()
    {
        $this->refreshHutang();

        $data['data'] = $this->data->hutang()->result();
        $data['title'] = 'Data Hutang';
        $data['side'] = 'hutang';
        $data['page'] = 'pages/hutang';
        $this->load->view('template', $data);
    }

    public function pembayaran_hutang($kode)
    {
        $data['akun'] = $this->data->akun()->result();
        $data['datenow'] = date("Y-m-d");
        $data['sisahutang'] = number_format($this->data->sisaHutang($kode), 0, ",",".");
        $data['kode'] = $kode;
        $data['data'] = $this->data->pembayaranHutang($kode)->result();
        $data['title'] = 'Data Pembayaran Hutang';
        $data['side'] = 'pembayaran';
        $data['page'] = 'pages/pembayaran-hutang';
        $this->load->view('template', $data);
    }
    public function add_bayar_hutang($id_pengeluaran)
    {

        $this->refreshHutang();

            $kode = $this->kode->hutang();
            $p = $this->input->post();
          
            $data = [
                'id_pembayaran' => $kode,
                'keterangan' => $p['keterangan'],
                'akun' => $p['akun'],
                'total' => $p['total'],
                'tanggal' => $p['tanggal'],
                // 'invoice' => $upload['file_name'],
                'id_pengeluaran' => $p['id_pengeluaran'],
                'user' => $this->session->userdata('kode'),
            ];
            if( $p['total'] > $this->data->sisaHutang($p['id_pengeluaran'])){
                $this->session->set_flashdata('msg', 'swal("Gagal!", "Pembayaran tidak boleh lebih dari hutang !!!", "error");');
                redirect(base_url('hutang/bayar')."/".$data['id_pengeluaran']);
            }
            $jurnal = [
                'kode_transaksi' => $data['id_pembayaran'],
                'user' => $data['user'],
                'akun' => 29,
                'akun_pengeluaran' => $p['akun'],

                'tanggal' => $data['tanggal'],
                'kredit' => 0,
                'debit' => $data['total'],
                'keterangan' => $data['keterangan'],
            ];

            $this->db->trans_start();
            $this->db->insert('jurnal', $jurnal);
            $this->db->insert('hutang_pembayaran', $data);
      
            $this->db->trans_complete();
            $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil disimpan", "success");');
            redirect(base_url('hutang/bayar')."/".$data['id_pengeluaran']);
      
    }
    public function delete_pembayaran($kode)
    {
        $this->db->trans_start();
        $this->db->delete('hutang_pembayaran', ['id_pembayaran' => $kode]);
        $this->db->delete('jurnal', ['kode_transaksi' => $kode]);
        $this->db->trans_complete();

        $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil dihapus", "success");');

        redirect($_SERVER['HTTP_REFERER']);
    }
    public function laporan()
    {
        if ($p = $this->input->post()) {
            $awal = $this->input->post('awal');
            $akhir = $this->input->post('akhir');

            $sql = $this->db->where('DATE(antrian_waktu) >=', $awal)->where('DATE(antrian_waktu) <=', $akhir)->get('antrian')->result();
            $this->load->library('Pdf');

            $pdf = new FPDF('P', 'mm', 'A4');
            $pdf->AddPage();

            $pdf->SetTitle('Laporan Antrian');

            $pdf->SetFont('times', 'B', 16);
            $pdf->Cell(190, 6, 'ASTRA BMW SERPONG', 0, 1, 'C');
            $pdf->SetFont('times', '', 10);
            $pdf->Cell(190, 4, 'Astra Biz Center No. 11A Jl. BSD Raya Utama BSD City. Kab.Tangerang Banten 15331', 0, 1, 'C');
            $pdf->Cell(190, 4, 'Telp. +62 896-7581-2872', 0, 1, 'C');
            $pdf->SetLineWidth(1);
            $pdf->Line(5, 27, 200, 27);
            $pdf->SetLineWidth(0);
            $pdf->Line(5, 28, 200, 28);

            $pdf->ln(7);

            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(190, 5, 'LAPORAN DATA ANTRIAN', 0, 1, 'C');
            $pdf->SetFont('times', '', 10);
            $pdf->Cell(190, 5, 'Periode ' . tanggal($awal) . ' s/d ' . tanggal($akhir), 0, 1, 'C');
            $pdf->ln();

            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(10, 7, 'NO', 1, 0, 'C');
            $pdf->Cell(40, 7, 'NO POLISI', 1, 0, 'C');
            $pdf->Cell(60, 7, 'MODEL', 1, 0, 'C');
            $pdf->Cell(40, 7, 'WIP', 1, 0, 'C');
            $pdf->Cell(40, 7, 'VIN', 1, 1, 'C');

            $pdf->SetFont('times', '', 10);
            $no = 1;
            foreach ($sql as $s) {
                $pdf->Cell(10, 7, $no++, 1, 0, 'C');
                $pdf->Cell(40, 7, $s->antrian_nopol, 1, 0, 'C');
                $pdf->Cell(60, 7, $s->antrian_model, 1, 0, 'L');
                $pdf->Cell(40, 7, $s->antrian_nowip, 1, 0, 'C');
                $pdf->Cell(40, 7, $s->antrian_vin, 1, 1, 'C');
            }

            $pdf->Output('Laporan Antrian', 'I');
        } else {
            $data['karu'] = $this->db->get_where('user', ['user_level' => 'KR'])->result();
            $data['mekanik'] = $this->db->get_where('user', ['user_level' => 'MK'])->result();
            $data['title'] = 'Laporan';
            $data['side'] = 'laporan';
            $data['page'] = 'pages/laporan';
            $this->load->view('template', $data);
        }
    }
    
function refreshHutang() {
    $job = $this->db->select('*')->from('pengeluaran')
            ->join('akun','pengeluaran.akun_pengeluaran = akun.id_akun')
            ->where('nama_akun', 'Hutang' )->get()->result();
    foreach($job as $row){
     $num = $this->db
             ->select('SUM(total) as total')
             ->from('hutang_pembayaran')
             ->where('id_pengeluaran', $row->id_pengeluaran)->get()->row()->total;
             $status = 0;
         if($num >= $row->jumlah){
               $status = 1;
         }
        $this->db->update('pengeluaran', [
            'status' => $status
        ], ['id_pengeluaran' => $row->id_pengeluaran]);
        $this->db->update('jurnal', [
            'status' => !$status
        ], ['kode_transaksi' => $row->id_pengeluaran]);

        $cek = $this->db->select('*')->from('hutang_pembayaran')->where('id_pengeluaran', $row->id_pengeluaran)->get()->result();
        foreach ($cek as $c) {
            $this->db->update('jurnal', [
                'status' => !$status
            ], ['kode_transaksi' => $c->id_pembayaran]);
        }
  
     }
}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
