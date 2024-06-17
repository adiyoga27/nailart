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
        $data['data'] = $this->data->akun()->result();
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
        $this->db->delete('akun', ['id_akun' => $kode]);
        $this->session->set_flashdata('msg', 'swal("Berhasil!", "Data berhasil dihapus", "success");');
        redirect(base_url('akun'));
    }

    public function getAkun($id) {
        $result = $this->db->select('*')
            ->from('akun')
            ->where('tipe_akun', $id)
            ->order_by('id_akun', 'DESC')
            ->get()->row();
        
        $kode = $result->kode_akun;
        if(!isset($kode)){
            switch ($result->kategori_akun) {
                case 'aset': $kode = 101; 
                  break;
                case 'pendapatan': $kode = 401 ;
                  break;
                case 'beban': $kode = 501 ;
                  break;
                case 'modal': $kode = 301 ;
                  break;
                case 'prive': $kode = 201 ;
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
                'jumlah' => $p['jumlah'],
                'tanggal_transaksi' => $p['tanggal_transaksi'],
                'keterangan' => $p['keterangan'],
                'user' => $this->session->userdata('kode'),
            ];

            $produk = $this->data->produk($data['produk'])->row();

            $jurnal = [
                'user' => $data['user'],
                'akun' => $data['akun'],
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
            $data['title'] = 'Tambah Data Pemasukan Lain-Lain';
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
                $img = $kode;

                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = '*';
                $config['file_name'] = $img;
                $config['overwrite'] = true;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('invoice')) {
                    $error = ['error' => $this->upload->display_errors()];
                    print_r($error);
                    exit();
                    $this->session->set_flashdata('msg', 'swal("Ops!", "Invoice gagal diupload", "error");');
                    redirect(base_url('pemasukan'));
                }

                $upload = $this->upload->data();

                $total = 0;
                for ($i = 0; $i < count($p['id_produk']); $i++) {
                    $total += $p['total'][$i];

                    //Pemasukkan Detail
                    $this->db->insert('pemasukan_detail', [
                        'id_pemasukan' => $kode,
                        'produk' => $p['id_produk'][$i],
                        'harga' => $p['harga'][$i],
                        'qty' => $p['jumlah'][$i],
                        'total' => $p['total'][$i],
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
                $this->db->insert('pemasukan', [
                    'id_pemasukan' => $kode,
                    'akun' => $p['akun'],
                    'harga' => $total,
                    'tanggal_pemasukan' => $p['tanggal_pemasukan'],
                    'keterangan' => $p['keterangan'],
                    'invoice' => $upload['file_name'],
                    
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
                    $total += $p['total'][$i];

                    //Pemasukkan Detail
                    $this->db->insert('pemasukan_detail', [
                        'id_pemasukan' => $p['kode'],
                        'produk' => $p['id_produk'][$i],
                        'harga' => $p['harga'][$i],
                        'qty' => $p['jumlah'][$i],
                        'total' => $p['total'][$i],
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
                    'harga' => $total,
                    'tanggal_pemasukan' => $p['tanggal_pemasukan'],
                    'keterangan' => $p['keterangan'],
                    
                    'customer_nama' => $p['customer_nama'],
                    'customer_phone' => $p['customer_phone'],
                    'user' => $this->session->userdata('kode'),
                ];
                if (isset($p['invoice'])) {
                    $img = $p['kode'];

                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $img;
                    $config['overwrite'] = true;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('invoice')) {
                        $error = ['error' => $this->upload->display_errors()];
                        print_r($error);
                        exit();
                        $this->session->set_flashdata('msg', 'swal("Ops!", "Invoice gagal diupload", "error");');
                        redirect(base_url('pemasukan'));
                    }
                    $upload = $this->upload->data();
                    $data['invoice'] = $upload['file_name'];
                }
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

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = '*';
            $config['file_name'] = $kode;
            $config['overwrite'] = true;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('invoice')) {
                $this->session->set_flashdata('msg', 'swal("Ops!", "Invoice gagal diupload", "error");');
                redirect(base_url('pengeluaran'));
            }

            $upload = $this->upload->data();

            $data = [
                'id_pengeluaran' => $kode,
                'keterangan' => $p['keterangan'],
                'akun' => $p['akun'],
                'jumlah' => $p['harga'],
                'tanggal_pengeluaran' => $p['tanggal_pengeluaran'],
                'invoice' => $upload['file_name'],
                'user' => $this->session->userdata('kode'),
            ];

            $jurnal = [
                'kode_transaksi' => $data['id_pengeluaran'],
                'user' => $data['user'],
                'akun' => $data['akun'],
                'tanggal' => $data['tanggal_pengeluaran'],
                'kredit' => 0,
                'debit' => $data['jumlah'],
                'keterangan' => $data['keterangan'],
            ];

            $this->db->trans_start();
            $this->db->insert('pengeluaran', $data);
            $this->db->insert('jurnal', $jurnal);
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
                'jumlah' => $p['harga'],
                'tanggal_pengeluaran' => $p['tanggal_pengeluaran'],
                'user' => $this->session->userdata('kode'),
            ];

            $jurnal = [
                'user' => $data['user'],
                'akun' => $data['akun'],
                'tanggal' => $data['tanggal_pengeluaran'],
                'kredit' => 0,
                'debit' => $data['jumlah'],
                'keterangan' => $data['keterangan'],
            ];

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = '*';
            $config['file_name'] = $kode;
            $config['overwrite'] = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('invoice')) {
                $upload = $this->upload->data();
                $data['invoice'] = $upload['file_name'];
            }

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
            $data['title'] = 'Tambah Data pengeluaran';
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
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
