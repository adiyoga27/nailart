<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	//menampilkan dan memproses login user
	public function index() 
	{
		if ($this->input->post())
        {
            $username 	= $this->input->post('username');
            $password 	= $this->input->post('password');
            $cek 		= $this->db->get_where('user',['username'=>$username,'password'=>md5($password)]);
            //proses cek user
            if ($cek->num_rows() > 0) {
            	$sess 	= $cek->row_array();

            	$data['kode'] 	= $sess['id_user'];
            	$data['nama'] 	= $sess['nama_user'];
            	$data['level'] 	= $sess['level'];
            	$this->session->set_userdata($data);
            	redirect(base_url('dashboard'));
            }
            else
            {

            	$this->session->set_flashdata('msg', 'swal("Ops!", "User tidak ditemukan", "error");');
				redirect(base_url('auth'));
            }
            	
        }
        else
        {
        	$data['title'] = 'Login | Make Nail Studio';
			$this->load->view('pages/login',$data); //load view login
        }
	}
	
	public function logout()
	{
		session_destroy();
		redirect('auth');
	}

	public function registration() 
	{
		if ($p =$this->input->post())
        {
         
         
			try {
				if($this->db->get_where('user',['username'=>$p['username']])->num_rows() > 0){
					$this->session->set_flashdata('msg', 'swal("Ops!", "Username sudah terdaftar", "error");');
                    redirect(base_url('registration'));
					return;
				}
				$this->db->insert('user',[
					'nama_user' => $p['nama_user'],
					'username' 	=> $p['username'],
					'password' => md5($p['password']),
					'email' 	=> $p['email'],
					'alamat' 	=> $p['alamat'],
					'nomor_telfon' => $p['nomor_telfon'],
					'level'     => $p['level'],
				]);
				
				$this->session->set_flashdata('msg', 'swal("Success!", "Anda Berhasil Registrasi Akun", "success");');
				redirect(base_url('auth'));
			} catch (\Throwable $th) {
				//throw $th;
				$this->session->set_flashdata('msg', 'swal("Ops!", "Gagal melakukan registration !!", "error");');
				redirect(base_url('registration'));
			}
			
        }
        else
        {
        	$data['title'] = 'Registrasi | Make Nail Studio';
			$this->load->view('pages/registration',$data); //load view login
        }
	}
	
	public function dashboard() {
			$data['title'] = 'Registrasi | Make Nail Studio';
			$this->load->view('pages/registration',$data); //load view login
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */