<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data extends CI_Model {

	
	public function user($kode=null)
	{
		$this->db->select('*');
		$this->db->from('user');
		if ($kode) {
			$this->db->where('id_user',$kode);
		}
		else
		{
			$this->db->order_by('id_user','ASC');
		}		
		return $this->db->get();
	}

	public function akun($kode=null)
	{
		$this->db->select('*');
		$this->db->from('akun');

		if ($kode) {
			$this->db->where('id_akun',$kode);
		}
		else
		{
			$this->db->order_by('kode_akun','ASC');
		}		
		return $this->db->get();
	}

	public function tipeAkun()
	{
		$this->db->select('*');
		$this->db->from('akun');
		$this->db->where_in('tipe_akun', ['pendapatan_operasional','beban_operasional','beban_operasional','pendapatan_non_operasional']);
		$this->db->order_by('tipe_akun','DESC');
		$this->db->group_by('tipe_akun');

		
		return $this->db->get();
	}

	public function akunLabaRugi($tipe=null)
	{
		$this->db->select('*');
		$this->db->from('akun');
		$this->db->where_in('kategori_akun', ['pendapatan','beban']);

		if($tipe){
			$this->db->where('tipe_akun', $tipe);
			
		}
		$this->db->order_by('tipe_akun','DESC');
		$this->db->group_by('id_akun');
		return $this->db->get();
	}

	public function labaRugiAmount($kode, $startAt, $endAt)
	{
		return $this->db->select('akun.nama_akun as nama_akun, sum(debit) as debit, sum(kredit) as kredit')
				->from('jurnal')
				->join('akun','akun.id_akun = jurnal.akun')
				->where('tanggal >=',$startAt)
				->where('tanggal <=',$endAt)
				->where('id_akun',$kode)
				->group_by('akun.id_akun')
				->get();
	}

	public function akunAmount($kode, $startAt, $endAt) {
	
		return $this->db->select('akun.nama_akun as nama_akun, sum(debit) as debit, sum(kredit) as kredit')
				->from('jurnal')
				->join('akun','akun.id_akun = jurnal.akun')
				->where('tanggal >=',$startAt)
				->where('tanggal <=',$endAt)
				->where('tipe_akun',$kode)
				->group_by('akun.id_akun')
				->get();
	}

	public function perubahanModal($startDate, $endDate) {
	
		return $this->db->select('akun.kategori_akun as kategori_akun, sum(debit) as debit, sum(kredit) as kredit')
				->from('jurnal')
				->join('akun','akun.id_akun = jurnal.akun')
				->where('tanggal >=',$startDate)
				->where('tanggal <=',$endDate)
				->where_in('kategori_akun', ['modal', 'beban', 'prive', 'pendapatan'])
				->group_by('akun.kategori_akun')
				->get();

		// return $this->akunTotalDebit(12, $startDate, $endDate) + $this->akunTotalDebit(23, $startDate, $endDate) - $this->akunTotalDebit(13, $startDate, $endDate) - $this->akunTotalDebit(24, $startDate, $endDate);

				
	}

	public function akunTotalDebit($id_akun, $startDate, $endDate) {
		return $this->db->select('sum(debit) as total')->from('jurnal')->where('tb_jurnal.tanggal >= ',$startDate)
					->where('tb_jurnal.tanggal <=',$endDate)->where('akun', $id_akun)->group_by('akun')->get()->row()->total + $this->db->select('sum(debit) as total')->from('jurnal')->where('tb_jurnal.tanggal >= ',$startDate)
					->where('tb_jurnal.tanggal <=',$endDate)->where('akun_pengeluaran', $id_akun)->group_by('akun_pengeluaran')->get()->row()->total;
	}
	public function akunTotalKredit($id_akun, $startDate, $endDate) {
		return $this->db->select('sum(kredit) as total')->from('jurnal')->where('tb_jurnal.tanggal >= ',$startDate)
					->where('tb_jurnal.tanggal <=',$endDate)->where('akun', $id_akun)->group_by('akun')->get()->row()->total + $this->db->select('sum(kredit) as total')->from('jurnal')->where('tb_jurnal.tanggal >= ',$startDate)
					->where('tb_jurnal.tanggal <=',$endDate)->where('akun_pengeluaran', $id_akun)->group_by('akun_pengeluaran')->get()->row()->total;
	}

	public function labaDitahan($startDate, $endDate){
		$total = $this->data->akunTotalKredit(12, $startDate, $endDate)+$this->data->akunTotalKredit(23, $startDate, $endDate)- $this->data->akunTotalDebit(13, $startDate, $endDate)-$this->data->akunTotalDebit(24, $startDate, $endDate);
		$total = $total - $this->data->akunTotalDebit(18, $startDate, $endDate) + $this->data->akunTotalKredit(18, $startDate, $endDate);
		return $total;
	}

	public function produk($kode=null)
	{
		$this->db->select('*');
		$this->db->from('produk');
		$this->db->join('user','produk.user = user.id_user');
		if ($kode) {
			$this->db->where('id_produk',$kode);
		}
		else
		{
			$this->db->order_by('id_produk','ASC');
		}		
		return $this->db->get();
	}
	public function details($kode=null)
	{
		$this->db->select('*');
		$this->db->from('pemasukan_detail');
		$this->db->join('produk','produk.id_produk = pemasukan_detail.produk');

		$this->db->where('id_pemasukan',$kode);
		
		return $this->db->get();
	}
	public function pemasukan($kode=null)
	{
		$this->db->select('pemasukan.*,user.nama_user, akun.nama_akun');
		$this->db->from('pemasukan');
		$this->db->join('user','pemasukan.user = user.id_user');
		$this->db->join('akun','pemasukan.akun = akun.id_akun');
		if ($kode) {
			$this->db->where('id_pemasukan',$kode);
		}
		else
		{
			$this->db->order_by('id_pemasukan','ASC');
		}		
		return $this->db->get();
	}

	public function pemasukan_lain($kode=null)
	{
		$this->db->select('*');
		$this->db->from('pemasukan_lain');
		$this->db->join('user','pemasukan_lain.user = user.id_user');
		$this->db->join('akun','pemasukan_lain.akun = akun.id_akun');
		if ($kode) {
			$this->db->where('id_transaksi',$kode);
		}
		else
		{
			$this->db->order_by('id_transaksi','ASC');
		}		
		return $this->db->get();
	}

	public function pengeluaran($kode=null)
	{
		$this->db->select('*');
		$this->db->from('pengeluaran');
		$this->db->join('user','pengeluaran.user = user.id_user');
		$this->db->join('akun','pengeluaran.akun = akun.id_akun');
		if ($kode) {
			$this->db->where('id_pengeluaran',$kode);
		}
		else
		{
			$this->db->order_by('id_pengeluaran','ASC');
		}		
		return $this->db->get();
	}

	public function kas($awal=null,$akhir=null)
	{
		$this->db->select('*');
		$this->db->from('jurnal');
		$this->db->join('user','jurnal.user = user.id_user');
		$this->db->join('akun','jurnal.akun = akun.id_akun');
		if ($awal) {
			$this->db->where('tanggal >=', $awal);
			$this->db->where('tanggal <=', $akhir);
			$this->db->order_by('akun.kode_akun','ASC');
		}
		else
		{
			$this->db->order_by('akun.kode_akun','ASC');
		}		
		return $this->db->get();
	}

	public function hutang()
	{
		$this->db->select('*');
		$this->db->from('pengeluaran');
		$this->db->join('akun','pengeluaran.akun_pengeluaran = akun.id_akun');
		$this->db->where('nama_akun', 'Hutang' );
		return $this->db->get();
	}

	public function pembayaranHutang($kode) {
		$this->db->select('*');
		$this->db->from('hutang_pembayaran');
		$this->db->where('hutang_pembayaran.id_pengeluaran', $kode);
		return $this->db->get();
	}
	public function sisaHutang($kode) {
		$hutang = $this->db->select('jumlah')
					->from('pengeluaran')
					->where('id_pengeluaran', $kode)
					->get()->row()->jumlah;
		$pembayaran = $this->db->select('sum(total) as jumlah')
						->from('hutang_pembayaran')
						->where('id_pengeluaran', $kode)
						->get()->row()->jumlah ;
		return $hutang - $pembayaran ;
	}
	public function jurnal($awal=null,$akhir=null)
	{
		$this->db->select('*,sum(kredit) as kredit_, sum(debit) as debit_');
		$this->db->from('jurnal');
		$this->db->join('user','jurnal.user = user.id_user');
		$this->db->join('akun','jurnal.akun = akun.id_akun');
		if ($awal) {
			$this->db->where('tanggal >=', $awal);
			$this->db->where('tanggal <=', $akhir);
			$this->db->group_by('jurnal.akun');
		}
		else
		{
			$this->db->group_by('jurnal.akun');
			$this->db->order_by('id_jurnal','ASC');
		}		


		return $this->db->get();
	}

	public function neraca($month=null,$year=null)
	{
	
		$this->db->select('*,sum(kredit) as kredit_, sum(debit) as debit_');
		$this->db->from('jurnal');
		$this->db->join('user','jurnal.user = user.id_user');
		$this->db->join('akun','jurnal.akun = akun.id_akun');
		$this->db->where('MONTH(tb_jurnal.tanggal)',$month);
		$this->db->where('YEAR(tb_jurnal.tanggal)',$year);
		$this->db->group_by('jurnal.akun');
			
	

		return $this->db->get();
	}

	public function perubahan_modal()
	{
		$this->db->select('*,sum(kredit) as kredit_, sum(debit) as debit_');
		$this->db->from('jurnal');
		$this->db->join('user','jurnal.user = user.id_user');
		$this->db->join('akun','jurnal.akun = akun.id_akun');
		$this->db->where('akun.kategori_akun','modal');		
		$sqlmodal = $this->db->get()->row();

		$this->db->select('*,sum(kredit) as kredit_, sum(debit) as debit_');
		$this->db->from('jurnal');
		$this->db->join('user','jurnal.user = user.id_user');
		$this->db->join('akun','jurnal.akun = akun.id_akun');
		$this->db->where('akun.kategori_akun','pendapatan');		
		$sqlpendapatan = $this->db->get()->row();

		$this->db->select('*,sum(kredit) as kredit_, sum(debit) as debit_');
		$this->db->from('jurnal');
		$this->db->join('user','jurnal.user = user.id_user');
		$this->db->join('akun','jurnal.akun = akun.id_akun');
		$this->db->where('akun.kategori_akun','beban');		
		$sqlbeban = $this->db->get()->row();

		$this->db->select('*,sum(kredit) as kredit_, sum(debit) as debit_');
		$this->db->from('jurnal');
		$this->db->join('user','jurnal.user = user.id_user');
		$this->db->join('akun','jurnal.akun = akun.id_akun');
		$this->db->where('akun.kategori_akun','prive');		
		$sqlprive = $this->db->get()->row();

		$data = [];

		$data['prive']		= $sqlmodal->kredit_;
		$data['modal']		= $sqlmodal->kredit_;
		$data['lababersih']	= $sqlpendapatan->kredit_ - $sqlbeban->debit_;

		return $data;
	}

	public function labarugi()
	{
		$this->db->select('*,sum(kredit) as kredit_, sum(debit) as debit_, MONTH(tanggal) as bulan');
		$this->db->from('jurnal');
		$this->db->join('user','jurnal.user = user.id_user');
		$this->db->join('akun','jurnal.akun = akun.id_akun');
		$this->db->where('YEAR(tanggal) ', date('Y'));	
		$this->db->group_by('MONTH(tanggal)');	


		return $this->db->get();
	}

	public function grafik()
	{
		$tahun = date('Y');
		$data  = [];
		for ($i=1; $i <= 12 ; $i++) { 
			$sql = $this->db->query(" SELECT SUM(kredit) - SUM(debit) as totals_ FROM tb_jurnal WHERE MONTH(tanggal) = '$i' AND YEAR(tanggal) = '$tahun'  ")->row();

			$data[] = $sql->totals_;
		}

		return $data;
	}

	

}

/* End of file M_data.php */
/* Location: ./application/models/M_data.php */