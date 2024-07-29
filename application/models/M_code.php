<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_code extends CI_Model {

    public function pemasukan()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_pemasukan,6)) AS kd_max FROM tb_pemasukan");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return 'KR'.$kd;
    }

    public function pemasukan_lain()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_transaksi,6)) AS kd_max FROM tb_pemasukan_lain");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return 'KR-L'.$kd;
    }

    public function pengeluaran()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_pengeluaran,6)) AS kd_max FROM tb_pengeluaran");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return 'DB'.$kd;
    }
    public function hutang()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_pembayaran,6)) AS kd_max FROM tb_hutang_pembayaran");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return 'PH'.$kd;
    }
    
}

/* End of file M_code.php */
/* Location: ./application/models/M_code.php */