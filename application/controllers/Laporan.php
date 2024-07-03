<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
	} 

	public function arus_kas()
	{
		$month = date('m');
		$year = date('Y');
		if ($this->input->post('button') == 'filter' ) {

			$month	= $this->input->post('month') ?? $month;
			$year	= $this->input->post('year')  ?? $year;
		

		}
		
		
			// $akuns = $this->data->tipeAkun()->result();
			// foreach ($akuns as $akun) { 
			// 	$res = [];
			// 	$resAmounts = $this->data->akunAmount($akun->tipe_akun, $startAt, $endAt )->result();
				
			
			// 	foreach ($resAmounts as $v) {
				
			// 		$res[] = array(
			// 			'akun' => $v->nama_akun,
			// 			'debit' => $v->debit,
			// 			'kredit' => $v->kredit,
			// 		);
			// 	}
			// 	$result[] = array(
			// 		'title' => $akun->tipe_akun,
			// 		'content' => $res,
				
			// 	);
			// }
			$results = $this->db->from('jurnal')
						->join('akun','jurnal.akun = akun.id_akun')
						->where('MONTH(tb_jurnal.tanggal)',$month)
						->where('YEAR(tb_jurnal.tanggal)',$year)
						->where_in('akun.kategori_akun', ['beban', 'prive', 'pendapatan'])
						->order_by('jurnal.tanggal', 'asc')
						->order_by('jurnal.id_jurnal','ASC')

						->get()->result();
					
			$data['data']	= $results;
			$data['title'] 	= 'Laporan Arus Kas';
			$data['side'] 	= 'kas';
			$data['page'] 	= 'pages/report/laporan-kas';
			$data['month'] = $month;
						$data['year'] = $year;
			if ($this->input->post('button') == 'cetak' ) {
				ob_start();
				$this->load->view('pages/export/export-kas', $data);
				$html = ob_get_contents();
				ob_end_clean();
					
				require './assets/plugins/html2pdf/autoload.php';
				
				$pdf = new Spipu\Html2Pdf\Html2Pdf('P','A4','en');
				$pdf->WriteHTML($html);
				$pdf->Output('Laporan Arus Kas.pdf', 'D');
			}else{
				
				$this->load->view('template',$data);
			}
			

	}

	public function jurnal()
	{
		$month = date('m');
		$year = date('Y');
		if ($this->input->post('button') == 'filter' ) {

			$month	= $this->input->post('month') ?? $month;
			$year	= $this->input->post('year')  ?? $year;
		

		}
		$jurnals = $this->db->from('jurnal')
						->join('akun','jurnal.akun = akun.id_akun')
						->where('MONTH(tb_jurnal.tanggal)',$month)
						->where('YEAR(tb_jurnal.tanggal)',$year)
						->order_by('tb_jurnal.tanggal','ASC')
						->order_by('tb_jurnal.id_jurnal','ASC')

						->get()->result();

						$previousDate = null;
						foreach ($jurnals as $value) {
							// if($previousDate == null || $value->tanggal != $previousDate){
								$tanggal = $value->tanggal;
							// $previousDate = $value->tanggal;
							// }else{
							// 	$tanggal = "";
							// }
							if($value->kredit>0){
								$results[] = array(
									'tanggal' => $tanggal,
									'keterangan' => "Kas",
									'kode_akun' => '101',
									'nama_akun' => "Kas",
									'debit' => $value->kredit,
									'kredit' =>0,
								);
							}
							$results[] = array(
								'tanggal' => $value->kredit>0 ? "" :$tanggal,
								'keterangan' => $value->keterangan,
								'kode_akun' => $value->kode_akun,
								'nama_akun' => $value->nama_akun,
								'debit' => $value->debit,
								'kredit' => $value->kredit,
							);

							if($value->debit>0){
								$results[] = array(
									'tanggal' => "",
									'keterangan' => "Kas",
									'kode_akun' => '101',
									'nama_akun' => "Kas",
									'debit' => 0,
									'kredit' => $value->debit,
								);
							}
						}
						$data['month'] = $month;
						$data['year'] = $year;
						$data['data']	= $results;
						$data['title'] 	= 'Laporan Jurnal Umum';
						$data['side'] 	= 'jurnal';
						$data['page'] 	= 'pages/report/laporan-jurnal';
					if ($this->input->post('button') == 'cetak' ) {

						ob_start();
						$this->load->view('pages/export/export-jurnal', $data);
						$html = ob_get_contents();
						ob_end_clean();
							
						require './assets/plugins/html2pdf/autoload.php';
						
						$pdf = new Spipu\Html2Pdf\Html2Pdf('P','A4','en');
						$pdf->WriteHTML($html);
						$pdf->Output('Laporan Jurnal Umum.pdf', 'D');

					}else{

						$this->load->view('template',$data);
					}

			

	}

	public function labarugi()
	{

		$month = date('m');
		$year = date('Y');
		if ($this->input->post('button') == 'filter' ) {

			$month	= $this->input->post('month') ?? $month;
			$year	= $this->input->post('year')  ?? $year;
		

		}
		
		

			$categories = ['pendapatan', 'beban'];
			foreach ($categories as $c) {
				$res = $result = [];
				$akuns = $this->db
						->select('jurnal.akun, akun.tipe_akun, akun.nama_akun, sum(debit) as debit, sum(kredit) as kredit')
						->from('akun')
						->join('jurnal', 'akun.id_akun = jurnal.akun')
						->where('kategori_akun', $c)
						->where('MONTH(tb_jurnal.tanggal)',$month)
						->where('YEAR(tb_jurnal.tanggal)',$year)
						->group_by('jurnal.akun')
						->order_by('kode_akun', 'asc')
						->get()->result();

				
				foreach ($akuns as $v) {
					$res[] = array(
						'akun' => $v->nama_akun,
						'debit' => $v->debit,
						'kredit' => $v->kredit,
					);
					
				}
				$result[] = array(
					'title' => $v->tipe_akun,
					'content' => $res,
				
				);
				$data[] = array(
					'kategori' => $c,
					'content' => $result,
				
				);
			}
	
			
			// foreach ($akuns as $akun) { 
			// 	$res = $result =[];
			// 	$tipes = $this->data->akunLabaRugi($akun->tipe_akun)->result();
			// 	foreach ($tipes as $t) { 

			// 		$resAmounts = $this->data->labaRugiAmount($t->id_akun, $startAt, $endAt )->result();
					
			// 		foreach ($resAmounts as $v) {
					
			// 			$res[] = array(
			// 				'akun' => $v->nama_akun,
			// 				'debit' => $v->debit,
			// 				'kredit' => $v->kredit,
			// 			);
			// 		}
			// 		$result[] = array(
			// 			'title' => $t->tipe_akun,
			// 			'content' => $res,
					
			// 		);
			// 	}
			// 	$data[] = array(
			// 		'kategori' => $akun->kategori_akun,
			// 		'content' => $result,
				
			// 	);
			// }
			$data['data']	= $data;
			$data['title'] 	= 'Laporan Laba Rugi';
			$data['side'] 	= 'labarugi';
			$data['page'] 	= 'pages/report/laporan-labarugi';
			$data['month'] = $month;
						$data['year'] = $year;
			if ($this->input->post('button') == 'cetak' ) {
				ob_start();
				$this->load->view('pages/export/export-labarugi', $data);
				$html = ob_get_contents();
				ob_end_clean();
					
				require './assets/plugins/html2pdf/autoload.php';
				
				$pdf = new Spipu\Html2Pdf\Html2Pdf('P','A4','en');
				$pdf->WriteHTML($html);
				$pdf->Output('Laporan Laba Rugi Tahun '.date('Y').'.pdf', 'D');
			}else{
				
				$this->load->view('template',$data);
			}

	}

	public function neraca()
	{
		$month = date('m');
		$year = date('Y');
		
		if ($this->input->post('button') == 'filter' ) {

			$month = $this->input->post('month') ?? $month;
			$year = $this->input->post('year') ?? $year;
		}

		$dateBefore = date('Y-m-t', strtotime($year."-".$month."-01"));

		$result = array(
			'kas' => $this->db->select('(sum(kredit) - sum(debit)) as kas')
						->from('jurnal')
						->where('MONTH(tb_jurnal.tanggal)',$month)
						->where('YEAR(tb_jurnal.tanggal)',$year)
						->get()->row()->kas ?? 0,
			'modal' => $this->db->select('(sum(kredit) - sum(debit)) as modal')
						->from('jurnal')
						->join('akun', 'jurnal.akun = akun.id_akun')
						->where('kategori_akun','modal')
						->where('MONTH(tb_jurnal.tanggal)',$month)
						->where('YEAR(tb_jurnal.tanggal)',$year)
						->get()->row()->modal ?? 0,
			'ditahan' => $this->db->select('(sum(kredit) - sum(debit)) as ditahan')
						->from('jurnal')
						->join('akun', 'jurnal.akun = akun.id_akun')
						->where_in('kategori_akun',['pendapatan', 'beban', 'prive'])
						->where('MONTH(tb_jurnal.tanggal)',$month)
						->where('YEAR(tb_jurnal.tanggal)',$year)
						->get()->row()->ditahan ?? 0
		);
		$data['month']	= $month;
		$data['year']	= $year;
		$data['data']	= $result; 
		$data['title'] 	= 'Laporan Neraca';
		$data['side'] 	= 'neraca';
		$data['page'] 	= 'pages/report/laporan-neraca';
			if ($this->input->post('button') == 'cetak' ) {
					
						$data['data'] = $result;
						ob_start();
						$this->load->view('pages/export/export-neraca', $data);
						$html = ob_get_contents();
						ob_end_clean();
							
						require './assets/plugins/html2pdf/autoload.php';
						
						$pdf = new Spipu\Html2Pdf\Html2Pdf('P','A4','en');
						$pdf->WriteHTML($html);
						$pdf->Output('Laporan Neraca '.'.pdf', 'D');
					
				}

		
			$this->load->view('template',$data);

	}

	public function perubahan_modal()
	{
		
		$month = date('m');
		$year = date('Y');
		if ($this->input->post('button') == 'filter' ) {
			$month = $this->input->post('month');
			$year = $this->input->post('year');
		}
		$result = $this->data->perubahanModal($month,$year)->result();

			$data['data']	= $result;
			$data['title'] 	= 'Laporan Perubahan Modal';
			$data['side'] 	= 'perubahan-modal';
			$data['page'] 	= 'pages/report/laporan-modal';
			$data['month'] = $month;
			$data['year'] = $year;

			if ($this->input->post('button') == 'cetak' ) {
				ob_start();
				$this->load->view('pages/export/export-modal', $data);
				$html = ob_get_contents();
				ob_end_clean();
					
				require './assets/plugins/html2pdf/autoload.php';
				
				$pdf = new Spipu\Html2Pdf\Html2Pdf('P','A4','en');
				$pdf->WriteHTML($html);
				$pdf->Output('Laporan Perubahan Modal.pdf', 'D');
			}else{
				
				$this->load->view('template',$data);
			}

		

	}

	public function perubahan_modal_cetak($awal,$akhir)
	{

        $pdf = new FPDF('P', 'mm','A4');
        $pdf->AddPage();
        $pdf->Settitle('Laporan perubahan modal');

        $pdf->SetFont('TIMES','B',13);
        $pdf->Cell(0,5,'LAPORAN PERUBAHAN MODAL',0,1,'C');
        $pdf->Cell(0,5,'MAKE NAIL STUDIO',0,1,'C');
        

		$pdf->ln(10);

		$pdf->SetFont('TIMES','',11);

		$data = $this->data->perubahan_modal();

		$pdf->Cell(120,5,'Modal',0,0,'L');
		$pdf->Cell(60,5,'Rp. '. number_format($data['modal']),0,1,'R');

		$pdf->Cell(120,5,'Laba Bersih',0,0,'L');
		$pdf->Cell(60,5,'Rp. '. number_format($data['lababersih']),0,1,'R');

		$pdf->Cell(120,5,'Prive',0,0,'L');
		$pdf->Cell(60,5,'Rp. '. number_format($data['prive']),0,1,'R');

		$pdf->Line(10,46,190,46);
		$pdf->ln();
		$pdf->SetFont('TIMES','B',11);

		$pdf->Cell(120,5,'Modal Akhir',0,0,'L');
		$pdf->Cell(60,5,'Rp. '. number_format($data['modal'] + $data['lababersih'] - $data['prive']),0,1,'R');

		$pdf->SetFont('TIMES','B',11);
		// $pdf->Cell(155,5,'TOTAL',1,0,'C');
		// $pdf->Cell(60,5,'Rp. '. number_format($debit),1,0,'R');
		// $pdf->Cell(60,5,'Rp. '. number_format($kredit),1,1,'R');

        $pdf->Output();
	
	}

	public function neraca_cetak($awal,$akhir)
	{

        $pdf = new FPDF('L', 'mm','A4');
        $pdf->AddPage();
        $pdf->Settitle('Laporan Jurnal Umum');

        $pdf->SetFont('TIMES','B',13);
        $pdf->Cell(0,5,'LAPORAN NERACA',0,1,'C');
        $pdf->Cell(0,5,'MAKE NAIL STUDIO',0,1,'C');
        

		$pdf->ln(10);

		$pdf->SetFont('TIMES','B',11);
		$pdf->Cell(10,5,'No',1,0,'C');
		$pdf->Cell(145,5,'Akun',1,0,'C');
		$pdf->Cell(60,5,'Saldo Debit',1,0,'C');
		$pdf->Cell(60,5,'Saldo Kredit',1,1,'C');

		$pdf->SetFont('TIMES','',11);

		$sql = $this->data->jurnal($awal,$akhir)->result();

		$no 	= 1;
		$debit 	= 0;
        $kredit = 0;
		foreach ($sql as $l) {

			$pdf->Cell(10,5,$no++,1,0,'C');
			$pdf->Cell(145,5,$l->nama_akun,1,0,'L');
			$pdf->Cell(60,5,'Rp. '. number_format($l->kategori_akun == 'aset' ? $l->kredit_ : $l->debit_),1,0,'R');
			$pdf->Cell(60,5,'Rp. '. number_format($l->kategori_akun == 'aset' ? $l->debit_ : $l->kredit_),1,1,'R');

			$debit += $l->kategori_akun == 'aset' ? $l->kredit_ : $l->debit_; 
            $kredit+= $l->kategori_akun == 'aset' ? $l->debit_ : $l->kredit_;
		}

		$pdf->SetFont('TIMES','B',11);
		$pdf->Cell(155,5,'TOTAL',1,0,'C');
		$pdf->Cell(60,5,'Rp. '. number_format($debit),1,0,'R');
		$pdf->Cell(60,5,'Rp. '. number_format($kredit),1,1,'R');

        $pdf->Output();
	
	}

	public function arus_kas_cetak($awal,$akhir)
	{

        $pdf = new FPDF('L', 'mm','A4');
        $pdf->AddPage();
        $pdf->Settitle('Laporan Arus Kas');

        $pdf->SetFont('TIMES','B',13);
        $pdf->Cell(0,5,'LAPORAN ARUS KASa',0,1,'C');
        $pdf->Cell(0,5,'MAKE NAIL STUDIO',0,1,'C');
        

		$pdf->ln(10);


		$pdf->SetFont('TIMES','',11);


		$akuns = $this->data->tipeAkun()->result();
		foreach ($akuns as $akun) { 
			$res = [];
			$resAmounts = $this->data->akunAmount($akun->id_akun, $awal, $akhir )->result();
			
		
			foreach ($resAmounts as $v) {
			
				$res[] = array(
					'akun' => $v->nama_akun,
					'debit' => $v->debit,
					'kredit' => $v->kredit,
				);
			}
			$result[] = array(
				'title' => $akun->tipe_akun,
				'content' => $res,
			);
		}



		$no 	= 1;
		$saldo  = 0;
		foreach ($result as $c) {

			$pdf->Multicell(200,5,$c['title'],1,'L');
			 foreach($c['content'] as $r ) {
				if($c['kredit']>0){
					$saldo += $r['kredit'];
				}else{
					$saldo -= $r['debit'];
				}
				$pdf->Cell(200,5,$r['akun'],1,0,'L');
				$pdf->Cell(200,5,"Rp".number_format($c['debit'] > 0 ? $c['debit'] : $c['kredit'],0,",","."),1,0,'L');

			}

			// $pdf->Cell(30,5,tanggal($l->tanggal),1,0,'C');
			// $pdf->Cell(100,5,$l->keterangan,1,0,'L');
			// $pdf->Cell(45,5,'Rp. '. number_format($l->kredit),1,0,'R');
			// $pdf->Cell(45,5,'Rp. '. number_format($l->debit),1,0,'R');
			// $pdf->Cell(45,5,'Rp. '. number_format($saldo),1,1,'R');
		}

        $pdf->Output();
	
	}

	public function jurnal_cetak($awal,$akhir)
	{

        $pdf = new FPDF('L', 'mm','A4');
        $pdf->AddPage();
        $pdf->Settitle('Laporan Jurnal Umum');

        $pdf->SetFont('TIMES','B',13);
        $pdf->Cell(0,5,'LAPORAN JURNAL UMUM',0,1,'C');
        $pdf->Cell(0,5,'MAKE NAIL STUDIO',0,1,'C');
        

		$pdf->ln(10);

		$pdf->SetFont('TIMES','B',11);
		$pdf->Cell(10,5,'No',1,0,'C');
		$pdf->Cell(100,5,'Akun',1,0,'C');
		$pdf->Cell(60,5,'Kas Masuk',1,0,'C');
		$pdf->Cell(60,5,'Kas Keluar',1,1,'C');

		$pdf->SetFont('TIMES','',11);

		$sql = $this->data->jurnal($awal,$akhir)->result();

		$no 	= 1;
		$saldo  = 0;
		foreach ($sql as $l) {

			$pdf->Cell(10,5,$no++,1,0,'C');
			$pdf->Cell(100,5,$l->nama_akun,1,0,'L');
			$pdf->Cell(60,5,'Rp. '. number_format($l->kredit_),1,0,'R');
			$pdf->Cell(60,5,'Rp. '. number_format($l->debit_),1,1,'R');
		}

        $pdf->Output();
	
	}

	public function labarugi_cetak()
	{

        $pdf = new FPDF('L', 'mm','A4');
        $pdf->AddPage();
        $pdf->Settitle('Laporan Laba Rugi Tahun '.date('Y'));

        $pdf->SetFont('TIMES','B',13);
        $pdf->Cell(0,5,'LAPORAN LABA RUGI TAHUN '.date('Y'),0,1,'C');
        $pdf->Cell(0,5,'MAKE NAIL STUDIO',0,1,'C');
        

		$pdf->ln(10);

		$pdf->SetFont('TIMES','B',11);
		$pdf->Cell(10,5,'No',1,0,'C');
		$pdf->Cell(80,5,'Bulan',1,0,'C');
		$pdf->Cell(60,5,'Kas Masuk',1,0,'C');
		$pdf->Cell(60,5,'Kas Keluar',1,0,'C');
		$pdf->Cell(60,5,'Laba/Rugi',1,1,'C');

		$pdf->SetFont('TIMES','',11);

		$sql = $this->data->labarugi()->result();

		$no 	= 1;
		$saldo  = 0;
		foreach ($sql as $l) {

			$pdf->Cell(10,5,$no++,1,0,'C');
			$pdf->Cell(80,5,bulan($l->bulan),1,0,'L');
			$pdf->Cell(60,5,'Rp. '. number_format($l->kredit_),1,0,'R');
			$pdf->Cell(60,5,'Rp. '. number_format($l->debit_),1,0,'R');
			$pdf->Cell(60,5,'Rp. '. number_format($l->kredit_ - $l->debit_),1,1,'R');
		}

        $pdf->Output();
	
	}

	
}

/* End of file Laporan.php */
/* Location: ./application/controllers/Laporan.php */