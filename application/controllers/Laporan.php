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
	
		$startDate = date('Y-m-d');
		$endDate = date('Y-m-d');
		if ($this->input->post('button') == 'filter' ||  $this->input->post('button') == 'cetak' ) {

			$startDate	= $this->input->post('startDate') ?? $startDate;
			$endDate	= $this->input->post('endDate')  ?? $endDate;
		
			
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
						->where('tb_jurnal.tanggal >=',$startDate)
						->where('tb_jurnal.tanggal <=',$endDate)
						// ->where_in('akun.kategori_akun', ['beban', 'prive', 'pendapatan','aset'])
						// ->where_not_in('tb_jurnal.akun_pengeluaran',[29])
						->where_in('tb_jurnal.akun_pengeluaran',[11, 23, 15])
						->order_by('jurnal.tanggal', 'asc')
						->order_by('jurnal.id_jurnal','ASC')

						->get()->result();
					
			$data['data']	= $results;
			$data['title'] 	= 'Laporan Arus Kas';
			$data['side'] 	= 'kas';
			$data['page'] 	= 'pages/report/laporan-kas';
			$data['startDate'] = $startDate;
			$data['endDate'] = $endDate;
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
        $this->refreshHutang();

		$startDate = date('Y-m-d');
		$endDate = date('Y-m-d');
		if ($this->input->post('button') == 'filter' ||  $this->input->post('button') == 'cetak' ) {

			$startDate	= $this->input->post('startDate') ?? $startDate;
			$endDate	= $this->input->post('endDate')  ?? $endDate;
		
			
		}
		$jurnals = $this->db->from('jurnal')
						->join('akun','jurnal.akun = akun.id_akun')
						->where('tb_jurnal.tanggal >=',$startDate)
						->where('tb_jurnal.tanggal <=',$endDate)
						->where('tb_jurnal.status <=',1)
						->order_by('tb_jurnal.tanggal','ASC')
						->order_by('tb_jurnal.id_jurnal','ASC')

						->get()->result();
					
						$previousDate = null;
						foreach ($jurnals as $value) {
							$akunPengeluaran = $this->db->from('akun')->where('id_akun', $value->akun_pengeluaran)->get()->row();
						
							// if($previousDate == null || $value->tanggal != $previousDate){
								$tanggal = $value->tanggal;
							// $previousDate = $value->tanggal;
							// }else{
							// 	$tanggal = "";
							// }
							 if($akunPengeluaran->kode_akun == 102){
								$results[] = array(
									'tanggal' => $tanggal,
									'keterangan' => "Piutang",
									'kode_akun' => $akunPengeluaran->kode_akun,
									'nama_akun' => $akunPengeluaran->nama_akun,
									'debit' => $value->debit,
									'kredit' =>0,
								);
							}

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
							if($akunPengeluaran->kode_akun == 201){
								$results[] = array(
									'tanggal' => $value->kredit>0 ? "" :$tanggal,
									'keterangan' => $value->keterangan,
									'kode_akun' => $value->kode_akun,
									'nama_akun' => $value->nama_akun,
									'debit' =>  $value->debit,
									'kredit' => $value->kredit,
								);
							}else if($akunPengeluaran->kode_akun == 102){
								$results[] = array(
									'tanggal' => $value->debit>0 ? "" :$tanggal,
									'keterangan' => $value->keterangan,
									'kode_akun' => $value->kode_akun,
									'nama_akun' => $value->nama_akun,
									'debit' =>  $value->kredit,
									'kredit' => $value->debit,
								);
							}else{
								if($akunPengeluaran->kode_akun > 401 && $akunPengeluaran->kode_akun <= 499){
									$results[] = array(
										'tanggal' => $value->kredit>0 ? "" :$tanggal,
										'keterangan' => $value->keterangan,
										'kode_akun' => $akunPengeluaran->kode_akun,
										'nama_akun' => $akunPengeluaran->nama_akun,
										'debit' =>  $value->debit,
										'kredit' => $value->kredit,
									);
								}else{
									$results[] = array(
										'tanggal' => $value->kredit>0 ? "" :$tanggal,
										'keterangan' => $value->keterangan,
										'kode_akun' => $value->kode_akun,
										'nama_akun' => $value->nama_akun,
										'debit' =>  $value->debit,
										'kredit' => $value->kredit,
									);
								}
								
							}
							if($akunPengeluaran->kode_akun == 201){
								$results[] = array(
									'tanggal' => "",
									'keterangan' => "Hutang",
									'kode_akun' => $akunPengeluaran->kode_akun,
									'nama_akun' => $akunPengeluaran->nama_akun,
									'kredit' => $value->debit,
									'debit' =>0,
								);
							}
							if($akunPengeluaran->kode_akun != 201 & $akunPengeluaran->kode_akun != 102 ){
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
						}
						$data['startDate'] = $startDate;
						$data['endDate'] = $endDate;
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

		$startDate = date('Y-m-d');
		$endDate = date('Y-m-d');
		if ($this->input->post('button') == 'filter' ||  $this->input->post('button') == 'cetak' ) {

			$startDate	= $this->input->post('startDate') ?? $startDate;
			$endDate	= $this->input->post('endDate')  ?? $endDate;
		
			
		}
		
		

			$categories = ['pendapatan', 'beban'];
			$t = 0;

			foreach ($categories as $c) {
				$res = $result = [];
				$akuns = $this->db
						->select('jurnal.akun, akun.tipe_akun, akun.nama_akun, sum(debit) as debit, sum(kredit) as kredit')
						->from('akun')
						->join('jurnal', 'akun.id_akun = jurnal.akun')
						->where('kategori_akun', $c)
						->where('tb_jurnal.tanggal >= ',$startDate)
						->where('tb_jurnal.tanggal <=',$endDate)
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
				if($c == 'beban'){
					$bebans =  $this->db
					->select('sum(debit) as debit, sum(kredit) as kredit, kode_transaksi')
					->from('jurnal')
					->where('tb_jurnal.tanggal >= ',$startDate)
					->where('tb_jurnal.tanggal <=',$endDate)
					->where('tb_jurnal.akun', 28)
					->group_by('jurnal.akun')
					->get()->result();
					foreach ($bebans as $b) {
						$cek = $this->db->select('sum(total) as total')->from('hutang_pembayaran')->where('id_pengeluaran', $b->kode_transaksi)->group_by('id_pengeluaran')->get()->row()->total;
						if($cek >= 0){

							$t = $t + $cek; 
						}
					}
					// $res[] = array(
					// 	'akun' => 'Perlengkapan',
					// 	'debit' => $t,
					// 	'kredit' => $beban->kredit,
					// );
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
	
			$data = [
				array(
					'kategori' => 'Pendapatan',
					'content' => array(
						array(
							'title' => 'pendapatan_operasional',
							'content' => array(
                                array(
                                    'akun' => 'Pendapatan',
                                    'debit' => 0,
                                    'kredit' => $this->data->akunTotalKredit('12', $startDate, $endDate),
								),
								array(
                                    'akun' => 'Pendapatan Lain-lain',
                                    'debit' => 0,
                                    'kredit' => $this->data->akunTotalKredit('23', $startDate, $endDate),
								)
							)
						)
					)
				),
				array(
					'kategori' => 'Beban',
                    'content' => array(
                        array(
                            'title' => 'beban_operasional',
                            'content' => array(
                                array(
                                    'akun' => 'Beban Gaji',
                                    'debit' => $this->data->akunTotalDebit('13', $startDate, $endDate),
                                    'kredit' => 0,
                                ),
                                array(
                                    'akun' => 'Beban Listrik',
                                    'debit' => $this->data->akunTotalDebit('24', $startDate, $endDate),
                                    'kredit' => 0,
                                )
                            )
                        )
                    )
				)

								];
	
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
			$data['startDate'] = $startDate;
						$data['endDate'] = $endDate;
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
		$startDate = date('Y-m-d');
		$endDate = date('Y-m-d');
		if ($this->input->post('button') == 'filter' ||  $this->input->post('button') == 'cetak' ) {

			$startDate	= $this->input->post('startDate') ?? $startDate;
			$endDate	= $this->input->post('endDate')  ?? $endDate;
		
			
		}
$hutangs = $this->db
->from('jurnal')
->where('tb_jurnal.tanggal >=',$startDate)
->where('tb_jurnal.tanggal <=',$endDate)						
->where_in('tb_jurnal.akun_pengeluaran', [29])
->get()->result();  
$hutang = 0;
$pl = 0;
foreach ($hutangs as $h) {
	$kodetrx = $h->kode_transaksi;

	$pelunasan = $this->db->select('sum(total) as total')
				->from('hutang_pembayaran')
				->where('id_pengeluaran', $kodetrx)
				->get()->row()->total;
				$hutang = $hutang + ($h->debit - $pelunasan);
				$pl = $pl + $pelunasan;
}

		$result = array(
			'kas' => ($this->db->select('(sum(kredit) - sum(debit)) as kas')
						->from('jurnal')
						->where('tb_jurnal.tanggal >=',$startDate)
						->where('tb_jurnal.tanggal <=',$endDate)
						->where_in('tb_jurnal.akun_pengeluaran', [11, 23])
						->get()->row()->kas) + $this->data->akunTotalKredit(15, $startDate, $endDate) ?? 0,
			'hutang' =>  $this->db->select('sum(debit) as total')->from('jurnal')->where('tb_jurnal.tanggal >= ',$startDate)
							->where('tb_jurnal.tanggal <=',$endDate)->where('akun', 31)->where('status',0)->group_by('akun')->get()->row()->total,
			'perlengkapan' =>  $this->db->select('sum(debit) as total')->from('jurnal')->where('tb_jurnal.tanggal >= ',$startDate)
			->where('tb_jurnal.tanggal <=',$endDate)->where('akun', 31)->where('status',1)->group_by('akun')->get()->row()->total,
			'modal' =>$this->data->akunTotalKredit(15, $startDate, $endDate) ?? 0,
			'ditahan' => $this->data->labaDitahan($startDate, $endDate)?? 0
		);
		$data['startDate']	= $startDate;
		$data['endDate']	= $endDate;
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
		
		$startDate = date('Y-m-d');
		$endDate = date('Y-m-d');
		if ($this->input->post('button') == 'filter' ||  $this->input->post('button') == 'cetak' ) {

			$startDate	= $this->input->post('startDate') ?? $startDate;
			$endDate	= $this->input->post('endDate')  ?? $endDate;
		
			
		}
		// $result = $this->data->perubahanModal($startDate,$endDate)->result();

			$result = [
				'modal' => $this->data->akunTotalKredit(15, $startDate, $endDate),
				'pendapatan' => $this->data->akunTotalKredit(12, $startDate, $endDate)+$this->data->akunTotalKredit(23, $startDate, $endDate)- $this->data->akunTotalDebit(13, $startDate, $endDate)-$this->data->akunTotalDebit(24, $startDate, $endDate),
				'prive' => $this->data->akunTotalDebit(18, $startDate, $endDate) + $this->data->akunTotalKredit(18, $startDate, $endDate)
			];

			$data['data']	= $result;
			$data['title'] 	= 'Laporan Perubahan Modal';
			$data['side'] 	= 'perubahan-modal';
			$data['page'] 	= 'pages/report/laporan-modal';
			$data['startDate'] = $startDate;
			$data['endDate'] = $endDate;

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
				'status' => $status
			], ['kode_transaksi' => $row->id_pengeluaran]);
	
			$cek = $this->db->select('*')->from('hutang_pembayaran')->where('id_pengeluaran', $row->id_pengeluaran)->get()->result();
			foreach ($cek as $c) {
				$this->db->update('jurnal', [
					'status' => $status
				], ['kode_transaksi' => $c->id_pembayaran]);
			}
	  
		 }
	}
}

/* End of file Laporan.php */
/* Location: ./application/controllers/Laporan.php */