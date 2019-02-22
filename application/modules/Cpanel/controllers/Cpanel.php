<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cpanel extends MX_Controller {
	public $data;
  public $bulanskr;
	public $tahunskr;
	public $blnskr;

	public function __construct()
	{
		parent::__construct();
		$this->bulanskr =date('n');
		//$this->tahunskr ='2019';
		$this->tahunskr =date('Y');
		 $this->blnskr =date('n');
		$this->load->model(array('Cpanel_model'));
		$this->load->library(array('ion_auth', 'form_validation'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin()) {
			// echo $this->blnskr;exit;
			$this->template->load('template','dashboard');
		} elseif($this->ion_auth->is_walikota()){
			$this->template->load('template','dashboard_pimpinan');
		}else {
			redirect('Home', 'refresh');
		}

	}

function laporan_bulanan_opd(){
	if (!$this->ion_auth->logged_in()) {
			redirect('Home/login', 'refresh');
	}	elseif (!$this->ion_auth->is_admin()) {
			redirect('Home', 'refresh');
	} else {
			$arraybuln = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember' );
			$arrbln 	= array('jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des' );
			$listopd 	= $this->Cpanel_model->getopd($this->tahunskr);
		//	echo json_encode($listopd->result_array());exit;
			$listbulan = array();
			for ($i=0; $i < count($arraybuln) ; $i++) {
				$opd=array();
				$kdbln=$i+1;
				foreach ($listopd->result_array() as $key => $valopd) {
					$thn	=$valopd['tahun'];
					$idopd=$valopd['unitkey'];
					$nmopd=$valopd['nmunit'];
					$stfinish = $valopd['stat_finish'];
					//get id pptk_master berdasarkan unit_key


					$getidpptkmaster=$this->Cpanel_model->get_row_pptk_master($idopd,$thn);
					$wherein = array();
					if($getidpptkmaster->num_rows() > 0){
						//cari total realisasi per opd
						$idpptkmaster = $getidpptkmaster->row_array()['id'];
						$getpptkdet = $this->Cpanel_model->get_pptk_det($idpptkmaster);
						foreach ($getpptkdet->result_array() as $key => $valpptkdet) {
							$wherein[]=$valpptkdet['id'];
						}
						//belanja langsung
						 $getjumlah = $this->Cpanel_model->getjumlahreal($wherein,$kdbln);
						 if(isset($getjumlah->row_array()['total'])){
							$jumreal=$getjumlah->row_array()['total'];
						 }else{
							 $jumreal=0;
						 }
						 //belanja modal
						 $getjumlahrealmodal = $this->Cpanel_model->getjumlahrealmodal($wherein,$kdbln);
						 if(isset($getjumlahrealmodal->row_array()['total'])){
							$jumrealmodal=$getjumlahrealmodal->row_array()['total'];
						 }else{
							 $jumrealmodal=0;
						 }
						 $totalreal = $jumreal + $jumrealmodal;
						 //get anggaran kas
						 $getangkas = $this->Cpanel_model->getangkasbulan($idopd,$kdbln,$this->tahunskr);
						 if(isset($getangkas->row_array()['total'])){
							$jumangkas=$getangkas->row_array()['total'];
						 }else{
							 $jumangkas=0;
						 }

						 if($totalreal > 0){
							 $persen = number_format($totalreal/$jumangkas*100,2);
						 }else{
							 $persen = 0;
						 }
						 $stat=1;

					}else{
						$stat=0;
						$totalreal = 0;
						$jumangkas = 0;
						$persen = 0;
					}
					// $x='';
					// foreach ($wherein as $key => $value) {
					// 	$x .= $key;
					// }
					$opd[]=array(
						'thn'		=> $thn,
						'idopd' => $idopd,
						'nmopd' => $nmopd,
						'stfinish'=>$stfinish,
						'angkas' => $jumangkas,
						'real'	=> $totalreal,
						'prsn'	=> $persen,
						'stat'	=> $stat //stat SK ada atau tidak//status finish dan sudah selesai harus di buatkan , lihat dari kas 1 = real kas s/d sekarang

					);
				}

				$listbulan[]=array(
					'kdbln' => $kdbln,
					'nmbln' => $arraybuln[$i],
					'opd'		=> $opd
				);
			}
			$this->data= array(
					'tahun'     => $this->tahunskr,
					'bulan'     => $this->bulanskr,
					'listbulan' => $listbulan
			);
			 //echo json_encode($this->data);exit;
			$this->template->load('templatenew','v_lapor_bulanan',$this->data);
	}
}

function uri_lihat_laporan_opd(){
	if (!$this->ion_auth->logged_in()) {
			redirect('Home/login', 'refresh');
	}	elseif (!$this->ion_auth->is_admin()) {
			redirect('Home', 'refresh');
	} else {
		$varthn		=$this->input->post('thn');
		$varbln		=$this->input->post('bln');
		$varidopd	=$this->input->post('idopd');
		$method = "AES-256-ECB";
		$key = "yqB6gHWfslCoYKWuAcOkqWbBRGqXqMA0UdNxQyqG9Iw=";

		$thn     = openssl_encrypt($varthn, $method, $key);
		$bln     = openssl_encrypt($varbln, $method, $key);
		$idopd   = openssl_encrypt($varidopd, $method, $key);
		$data['uri'][] = array(
			'thn'   => str_replace("+","%2B",$thn),
			'bln'   => str_replace("+","%2B",$bln),
			'idopd' => str_replace("+","%2B",$idopd)
 		);
		echo json_encode($data);
	}
}

function lihat_laporan_bulanan_opd(){
	if (!$this->ion_auth->logged_in()) {
			redirect('Home/login', 'refresh');
	}	elseif (!$this->ion_auth->is_admin()) {
			redirect('Home', 'refresh');
	} else {
		$arraybuln = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember' );
		$arrbln = array('jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des' );
		$method = "AES-256-ECB";
		$key 		= "yqB6gHWfslCoYKWuAcOkqWbBRGqXqMA0UdNxQyqG9Iw=";
		if(!isset($_GET['thn'], $_GET['bln'], $_GET['unt'])) {
			redirect('Cpanel', 'refresh');
		}else{
			$varthn		=$_GET['thn'];
			$varbln		=$_GET['bln'];
			$varidopd	=$_GET['unt'];
			$varfns	=$_GET['fns'];
			if (base64_encode(base64_decode($varthn)) === $varthn && base64_encode(base64_decode($varbln)) === $varbln && base64_encode(base64_decode($varidopd)) === $varidopd  ){
					$thn   =openssl_decrypt($varthn, $method, $key);
					$bln   =openssl_decrypt($varbln, $method, $key);
					$idopd =openssl_decrypt($varidopd, $method, $key);
					$nmopd = $this->Cpanel_model->getrow_nama_opd($this->tahunskr,$idopd)->row_array()['nmunit'];
					$modelpptkmaster= $this->Cpanel_model->get_row_pptk_master($idopd,$this->tahunskr);
					if($modelpptkmaster->num_rows() == 0){

							$data[]=array();
							$datapagu [] =array(
								'tahun' => 0,
								'blnskr'=> 0,
								'blnsdskr'=>0
							);
							$realsd=0;
							$prsnreal=0;
							 $prog[]=array();
					}else{
						  $datapagu=$this->Cpanel_model->paguopd($thn,$bln,$idopd);
							$idtabmasterpptk=$modelpptkmaster->row_array()['id'];
							$modellstppk= $this->Cpanel_model->get_list_ppk($idtabmasterpptk); //ambil list ppk berdasrkan id master
							$listppk = $modellstppk->result_array();
							$lskegsemua  = $this->Cpanel_model->getdetlistkegiatan_semuappk($idtabmasterpptk,$thn);
							$wherein = array(); // ini untuk where in
							foreach ($lskegsemua as $key => $value) {
									$wherein[]=$value['id'];
									$arrkdkegunit[]= $value['kdkegunit'];
							}
							$modelprsnreal = $this->Cpanel_model->realkeu_ppk_persen($wherein,$thn,$bln);
							$modelprsnlrealbmodal = $this->Cpanel_model->realkeu_ppk_bmodal_persen($wherein,$thn,$bln);
							$prsnreal = $modelprsnreal['nilai'] + $modelprsnlrealbmodal['nilai']; //nilai untuk mencari persen bulan sekarang

							$modelrealsd = $this->Cpanel_model->realkeu_ppk_persen($wherein,$thn,$bln,1);
							$modelrealbmodalsd = $this->Cpanel_model->realkeu_ppk_bmodal_persen($wherein,$thn,$bln,1);
							$realsd =  $modelrealsd['nilai'] + $modelrealbmodalsd['nilai'];  //nilai untuk mencari persen sampai dengan bulan sekarang
							//ambil program di opd
							$listprogram =  $this->Cpanel_model->listprogram($idopd,$thn);
							$prog= array();

							if(!$listprogram ){
			            $prog[]=array();
									$datapaguprogram [] =array(
										'tahun' => 0,
										'blnskr'=> 0,
										'blnsdskr'=>0
														);
			        }else{
								foreach ($listprogram as $key) {


									$rincian=array();
									$idprog =  $key['IDPRGRM'];
									$nmprog =  $key['NMPRGRM'];
									//nilai pagu per Program
									$datapaguprogram=$this->Cpanel_model->paguprogram($thn,$bln,$idopd,$idprog);
									//cari realisasi keuangan berdasarkan id program , bln tahn
									$modelprsnrealppk = $this->Cpanel_model->realkeu_prog_persen($idprog,$thn,$bln);
									$modelprsnlrealbmodalppk = $this->Cpanel_model->realkeu_prog_bmodal_persen($idprog,$thn,$bln);

									$prsnrealprog = $modelprsnrealppk['nilai'] + $modelprsnlrealbmodalppk['nilai']; //nilai untuk mencari persen bulan sekarang

									$modelrealsdppk = $this->Cpanel_model->realkeu_prog_persen($idprog,$thn,$bln,1);
									$modelrealbmodalsdppk = $this->Cpanel_model->realkeu_prog_bmodal_persen($idprog,$thn,$bln,1);
									$realsdprog =  $modelrealsdppk['nilai'] + $modelrealbmodalsdppk['nilai'];  //nilai untuk mencari persen sampai dengan bulan sekarang



									$lskegppk = $this->Cpanel_model->listkegiatan($idopd,$thn,$idprog);

									// foreach ($listkegiatan->result_array() as $xkey ) {
									// 	$kdkeg = $xkey['kdkegunit'];
									// 	$nmkeg = $xkey['nmkegunit'];
									// 	$nilai = $xkey['nilai'];
									// 	$keg[] = array(
									// 			'kdkeg'   => $kdkeg,
									// 			'nmkeg'   => $nmkeg,
									// 			'nilai'   => $this->template->rupiah($nilai)
									// 	);
									// }
									//
									$totalKeg=array();
									$totalreal=array();
									$totalrealfis=array();
									$tottarfis =array();
								  $detppk=array();
									if(!$lskegppk->result_array() ){
											$detppk[]=array();
											$datapaguppk [] =array(
												'tahun' => 0,
												'blnskr'=> 0,
												'blnsdskr'=>0
																);
											$realsdppk =0;
											$prsnrealppk =0;
									}else{

										$arrkdkegunitppk = array(); // ini untuk where in
										$whereinppk = array(); // ini untuk where in
										foreach ($lskegppk->result_array() as $key => $value) {
											$whereinppk[]=$value['id'];
											$arrkdkegunitppk[]= $value['kdkegunit'];
										}
										$datapaguppk=$this->Cpanel_model->pagupptk( $thn,$bln,$idopd,$arrkdkegunitppk);
										$modelprsnrealppk = $this->Cpanel_model->realkeu_ppk_persen($whereinppk,$thn,$bln);
										$modelprsnlrealbmodalppk = $this->Cpanel_model->realkeu_ppk_bmodal_persen($whereinppk,$thn,$bln);
										$prsnrealppk = $modelprsnrealppk['nilai'] + $modelprsnlrealbmodalppk['nilai']; //nilai untuk mencari persen bulan sekarang

										$modelrealsdppk = $this->Cpanel_model->realkeu_ppk_persen($whereinppk,$thn,$bln,1);
										$modelrealbmodalsdppk = $this->Cpanel_model->realkeu_ppk_bmodal_persen($whereinppk,$thn,$bln,1);
										$realsdppk =  $modelrealsdppk['nilai'] + $modelrealbmodalsdppk['nilai'];  //nilai untuk mencari persen sampai dengan bulan sekarang

										foreach ($lskegppk->result_array() as $key ) {

											$kdkeg = $key['kdkegunit'];
											$idtab = $key['id'];



											//----------------------------target-----------------------------------------------------// disini beda dengan yang evaluasi_semua_sekretaris tambahkan parameter <= pada bulan model
											$modeltarkeu = $this->Cpanel_model->tarkeu_ppk($idopd,$thn,$bln,$kdkeg);
											$nlskr    = $modeltarkeu['nilai']; //nilai kegiatan perbulan dari aliran kas
											if(!array_key_exists($kdkeg,$totalKeg)){
												$totalKeg[$kdkeg] = $nlskr;
											}else{
												$totalKeg[$kdkeg] += $nlskr;
											}
											$nltotbln = $totalKeg[$kdkeg]; //jumlah total nilai kegiatan perbulan sampai dengan bulan berjalan

											$modeltarkeuthn = $this->Cpanel_model->tarkeu_ppk_thn($idopd,$thn,$kdkeg);
											$nltotthn = $modeltarkeuthn['nilai']; //jumlah total nilai kegiatan pertahun
											//---------------------------------------------------------------------------------------//
											//---------------------------realisasi---------------------------------------------------//
											$modelnlreal = $this->Cpanel_model->realkeu_ppk($idtab,$thn,$bln);
											$modelnlrealbmodal = $this->Cpanel_model->realkeu_ppk_bmodal($idtab,$thn,$bln);

											if(isset($modelnlreal['nilai'])){
												$nlreal=$modelnlreal['nilai'];
											}else{
												$nlreal =0;
											}

											if(isset($modelnlrealbmodal['nilai'])){
												$nlrealbmodal=$modelnlrealbmodal['nilai'];
											}else{
												$nlrealbmodal =0;
											}

											$fixnlreal = $nlreal + $nlrealbmodal;

											if(!array_key_exists($kdkeg,$totalreal)){
												$totalreal[$kdkeg] = $fixnlreal;
											}else{
												$totalreal[$kdkeg] += $fixnlreal;
											}
												$nlrealbln = $totalreal[$kdkeg];
												//cari bobot realisasi fisik


												if(isset($modelnlreal['bobot_real'])){
													$botreal=$modelnlreal['bobot_real'];
												}else{
													$botreal =0;
												}
												if(!array_key_exists($kdkeg,$totalrealfis)){
													$totalrealfis[$kdkeg] = $botreal;
												}else{
													$totalrealfis[$kdkeg] += $botreal;
												}
												$bobotrealfis =   $totalrealfis[$kdkeg] ;
											//---------------------------------------------------------------------------------------//
												if ($nltotbln > 0) {
													$capaian = number_format($nlrealbln/$nltotbln*100,2);
												}else{
													$capaian =  number_format(0,2);
												}

												if ($nltotthn > 0) {
													$persenreal = number_format($nlrealbln/$nltotthn*100,2);
												}else{
													$persenreal =  number_format(0,2);
												}
												//---------------------------------fisik------------------------------------------------//

												$modelfistarget=$this->Cpanel_model->tarfis_ppk($idtab);
												$arsir=0;

												foreach ($modelfistarget as $fiskey => $vlfis) {
													$arsir+= strlen($vlfis['jan']);
													$arsir+= strlen($vlfis['feb']);
													$arsir+= strlen($vlfis['mar']);
													$arsir+= strlen($vlfis['apr']);
													$arsir+= strlen($vlfis['mei']);
													$arsir+= strlen($vlfis['jun']);
													$arsir+= strlen($vlfis['jul']);
													$arsir+= strlen($vlfis['ags']);
													$arsir+= strlen($vlfis['sep']);
													$arsir+= strlen($vlfis['okt']);
													$arsir+= strlen($vlfis['nov']);
													$arsir+= strlen($vlfis['des']);
												}

												if ($arsir > 0) {
													$nilaiperarsir = number_format(100/$arsir,2);
												}else{
													$nilaiperarsir =  number_format(0,2);
												}
												$arsirbln=0;
												for ($i=0; $i < $bln ; $i++) {
													foreach ($modelfistarget as $xfiskey => $xvlfis) {
															if(isset($xvlfis[$arrbln[$i]])){
																$arsirbln += strlen($xvlfis[$arrbln[$i]]);
															}else{
																$arsirbln +=0;
															}

													}
												}

												$blnarsir = 0;
												if ($arsirbln > 0) {
													$blnarsir = number_format($arsirbln*$nilaiperarsir,2);
												}else{
													$blnarsir =  number_format(0,2);
												}

												if(!array_key_exists($kdkeg,$tottarfis)){
													$tottarfis[$kdkeg] = $arsirbln;
												}else{
													$tottarfis[$kdkeg] += $arsirbln;
												}
												$fixtottarfis1 = $tottarfis[$kdkeg];
												if ($fixtottarfis1 > 0) {
													$fixtottarfis = number_format($fixtottarfis1*$nilaiperarsir,2);
												}else{
													$fixtottarfis =  number_format(0,2);
												}

												if($fixtottarfis > 99 && $fixtottarfis < 100  ){
														$fixtottarfis=number_format (ceil($fixtottarfis),2);
												}elseif($fixtottarfis > 100){
														$fixtottarfis=number_format (floor($fixtottarfis),2);
												}
												if(isset($modelnlreal['stat_teruskan'])){
													$statteruskan=$modelnlreal['stat_teruskan'];
												}else{
													$statteruskan =0;
												}

												//---------------------------------------------------------------------------------------//
											$detppk[]=array(
												'kdkeg'     => $kdkeg,
												'nmprgrm'     => $key['prog'],
												'nmkeg'     => $key['nmkegunit'],
												'ppk'       => $key['idpnsppk'],
												'nipppk'    => $key['nipppk'],
												'nippptk'   => $key['nippptk'],
												'pptk'      => $key['idpnspptk'],
												'nlskr'     => $nlskr,
												'nltskr'    => $this->template->nominal($nltotbln),
												'nlthn'     => $nltotthn,
												'prstarget' => number_format($nltotbln/$nltotthn*100,2),
												'realnl'    => $this->template->nominal($nlrealbln),
												'prsreal'   => $persenreal,
												'cpaian'    => $capaian,
												'blnarsir'  => $blnarsir,
												'prstarfis' => $fixtottarfis,
												'prsrealfis'=>number_format($bobotrealfis,2),
												'stat_terskn'=> $statteruskan

											);
										}


									}





									if($realsdprog > 0){
										$prsnrealsdprog= number_format($realsdprog/$datapaguprogram[0]['blnsdskr']*100,2);
									}else{
										$prsnrealsdprog= number_format(0,2);
									}
									if($prsnrealprog > 0 ){
										$prsnrealskrprog = number_format($prsnrealprog/$datapaguprogram[0]['blnskr']*100,2);
									}else{
										$prsnrealskrprog = number_format(0,2);
									}

									$rincian[]=array(
										'paguprogram'  		=> $datapaguprogram,
										'realsdprog'    		=> $realsdprog,
										'prsnrealsdprog'		=> $prsnrealsdprog,
										'realbulnskrprog' 	=> $prsnrealprog,
										'prsnrealskrprog'  => $prsnrealskrprog,
										'keg'      				=> $detppk
									);

									$prog[] = array(
									  'idprog'   => $idprog,
									  'nmprog'   => $nmprog,
									  'jumkeg'   => $lskegppk->num_rows(),
									  'rincian'   => $rincian
									);
							}
						}


					}
					if($realsd > 0){
						$prsnrealsd= number_format($realsd/$datapagu[0]['blnsdskr']*100,2);
					}else{
						$prsnrealsd= number_format(0,2);
					}
					if($prsnreal > 0 ){
						$prsnrealskr = number_format($prsnreal/$datapagu[0]['blnskr']*100,2);
					}else{
						$prsnrealskr = number_format(0,2);
					}

					$this->data= array(
							'tahun'    	 	=> $this->tahunskr,
							'idbln'				=> $bln,
							'bulan'     	=> $arraybuln[$bln-1],
							'idopd'     	=> $idopd,
							'nmopd'     	=> $nmopd,
							'fns'     	=> $varfns,
							'pagu'      	=> $datapagu,
							'realsd'    	=> $realsd,
							'prsnrealsd'	=> $prsnrealsd,
							'realbulnskr' => $prsnreal,
							'prsnrealskr' => $prsnrealskr,
							'program'     => $prog

					);

				//	echo json_encode($this->data);exit;
					$this->template->load('templatenew','v_lapor_bulanan_lihat',$this->data);

			} else {
					echo 'Anda Mau Kemana ??';
					die;
			}

		}
	}
}
function json_detail_realisasi(){

  // json yang hanya bisa dari aplikasi bukan public
  $nip          = $this->input->post('nippptk'); //nip pptk
  $posttahun    = $this->input->post('thn');
  $postbulan    = $this->input->post('bln');
  $postidopd    = $this->input->post('idopd');
  $postnmopd    = $this->input->post('nmopd');
  $postkdkeg    = $this->input->post('kdkeg');
  //
  // $nip          = '198207082010011011'; //nip pptk
  // $posttahun    = '2019';
  // $postbulan    = '5';
  // $postidopd    = '80_';
  // $postnmopd    = 'DINAS KOMUNIKASI DAN INFORMATIKA';
  // $postkdkeg    = '12933_';

  $modellskeg   = $this->Cpanel_model->getdetlistkegiatan_detpptk($nip,$postkdkeg,$posttahun);

  $idtab        = $modellskeg['id'];
  $kdpgrm       = $modellskeg['idprog'];
  $nmpgrm       = $modellskeg['prog'];
  $kdkeg        = $modellskeg['kdkeg'];
  $nmkeg        = $modellskeg['keg'];
  $nlkeg        = $modellskeg['nl'];
  $ppk          = $modellskeg['ppk'];
  $pptk         = $modellskeg['pptk'];
  $anggaranopd  = $this->Cpanel_model->anggaranopd($postidopd);
  $paguopd      = $anggaranopd->anggranopd;
  $bbtkeg       = number_format($nlkeg/$paguopd*100,2);
  $modeltarkeu  = $this->Cpanel_model->tarkeu_ppk($postidopd,$posttahun,$postbulan,$kdkeg); // cek angkas perbulan
  $nlblnskr     = $modeltarkeu['nilai']; //nilai aliran kas bulan sekarang
  //---------------------------realisasi---------------------------------------------------//
  $modelnlreal = $this->Cpanel_model->realkeu_ppk_detailrealisasi($idtab,$posttahun,$postbulan);
  $modelnlrealbmodal = $this->Cpanel_model->realkeu_ppk_bmodal_detailrealisasi($idtab,$posttahun,$postbulan);
  $rlkeu = $modelnlreal['nilai'] + $modelnlrealbmodal['nilai'];

  // echo json_encode($rlkeu);exit;
  if($rlkeu > 0){
    $prrlkeu = number_format($rlkeu/$nlblnskr * 100,2);
  }else{
    $prrlkeu = 0;
  }
  $idreal = $modelnlreal['id'];
  $rlfisik = $modelnlreal['real_fisik'];
  $bbtrlfisik = $modelnlreal['bobot_real'];
  $mslh = $modelnlreal['permasalahan'];


    $det = array();
    $rowheader=$this->Cpanel_model->getheader_realisasipptk_angkas($postidopd,$kdkeg,$postbulan,$posttahun);
    foreach ($rowheader as $key => $rw) {
        $id         = $rw['id'];
        $unitkey    = $rw['unitkey'];
        $kdkegunit  = $rw['kdkegunit'];
        $mtgkey     = $rw['mtgkey'];
        $kdper      = $rw['kdper'];
        $nmper      = $rw['nmper'];
        $nilai      = $rw['nilai'];
        $tahun      = $rw['tahun'];
        $subdet = array();
        $rowsubheader = $this->Cpanel_model->rowsub_detail($tahun,$postidopd,$kdkeg,$mtgkey);
        $totjum       = 0;
        $totjumreal   = 0;

      foreach ($rowsubheader as $key => $rws) {
        $detid        = $rws['id'];
        $dettahun     = $rws['tahun'];
        $detunitkey   = $rws['unitkey'];
        $detkdkegunit = $rws['kdkegunit'];
        $detmtgkey    = $rws['mtgkey'];
        $detkdrek   = $rws['kdper'];
        $deturaianx   = str_replace("-","",$rws['uraian']);
        $deturaian    = str_replace("  ","",$deturaianx);
        $detsatuan    = $rws['satuan'];
        $dettarif     = $rws['tarif'];
        $detjumbyek   = $rws['jumbyek'];
        $detkdjabar   = $rws['kdjabar'];
        $dettype      = $rws['type'];
        $jumhar = $dettarif * $detjumbyek;
        $totjum += $jumhar;

        $varkdrek = substr($detkdrek,0,6); // variable sementara untuk menentukan 5.2.3 atau tidak
        // jika 5.2.3 atau belanja modal
        if($varkdrek=='5.2.3.'){
          //ambil realisasi data berdasarkan anak rincian

          $rincianrealbmodal = $this->Cpanel_model->rincirealisasibmodal($idtab,$detmtgkey);
          $idrealmodal        = $rincianrealbmodal['id'];
          $idtabpptkrealmodal = $rincianrealbmodal['id_tab_pptk'];
          $nlktrkrealmodal    = $rincianrealbmodal['nilai_ktrk'];
          $rincianrealbmodaldet = $this->Cpanel_model->rincirealisasibmodaldet($idrealmodal,$posttahun,$postbulan);
          $realbmodal         =$rincianrealbmodaldet['real_keuangan'];
          // select id , id_tab_pptk , nilai_ktrk  where id_tab_pptk dan mtgkey

          $subdet[]=array(
            'uraian'    =>$deturaian,
            'satuan'    =>$detsatuan,
            'harga'     =>$dettarif,
            'mskharga'  =>$this->template->nominal($dettarif), //masking nilai
            'vol'       =>$detjumbyek,
            'jumhar'    =>$jumhar,
            'mskjumhar' =>$this->template->nominal($jumhar), //masking jumlah harga
            'type'      =>$dettype,
            'rlnlkontrak' => $this->template->nominal($nlktrkrealmodal), //realisasi belanja modal (nilai kontrak)
            'realbmodal' => $this->template->nominal($realbmodal)

          );

          $totjumreal += $rincianrealbmodaldet['real_keuangan'];
        }else{
          //ambil realisasi data berdasarkan anak rincian

          $rincianreal = $this->Cpanel_model->rincirealisasi($idreal,$detmtgkey,$detid);

          $subdet[]=array(
            'uraian'    =>$deturaian,
            'satuan'    =>$detsatuan,
            'harga'     =>$dettarif,
            'mskharga'  =>$this->template->nominal($dettarif), //masking nilai
            'vol'       =>$detjumbyek,
            'jumhar'    =>$jumhar,
            'mskjumhar' =>$this->template->nominal($jumhar), //masking jumlah harga
            'type'      =>$dettype,
            'rlsbrdana' =>$rincianreal['nm_dana'],
            'rlvol'     =>$rincianreal['vol'],
            'rlharst'   =>$rincianreal['harga_satuan'],
            'mskrlharst'=>$this->template->nominal($rincianreal['harga_satuan']),
            'rljumhar'  =>$rincianreal['jumlah_harga'],
            'mskrljumhar'=>$this->template->nominal($rincianreal['jumlah_harga']),
            'rlssdn'  =>$rincianreal['sisa_dana']
          );

          $totjumreal += $rincianreal['jumlah_harga'];
        }


      }
      $det[]=array(

        'kdrek'     => $kdper,
        'nmrek'     => $nmper,
        'kas'       => $nilai,
        'mskkas'    => $this->template->nominal($nilai),
        'totjum'    => $this->template->nominal($totjum),
        'totjumreal'=> $this->template->nominal($totjumreal),
        'subdet'    => $subdet


      );


    }
    $data['data'][]= array(
      'tahun'     => $posttahun,//tahun
      'bulan'     => $postbulan,//bulan
      'idopd'     => $postidopd, //idunit(opd)
      'nmopd'     => $postnmopd, //namaunit
      'paguopd'   => $paguopd, //jatah opd
      'kdpgrm'    => $kdpgrm,//kodeprogram
      'nmpgrm'    => $nmpgrm,//namaprogram
      'kdkeg'     => $kdkeg,//kodekegiatan
      'nmkeg'     => $nmkeg,//namakegiatan
      'nlkeg'     => $this->template->rupiah($nlkeg),//nilaikegiatan
      'bbtkeg'    => number_format($bbtkeg,2),//bobotkegiatan = (nilaikegiatan/paguopd) * 100
      'idtab'     => $idtab,
      'ppk'       => $ppk,//namapptkatauKPA
      'pptk'      => $pptk,//namapptk
      'nlblnskr'  => $this->template->rupiah($nlblnskr),//nilai pagu bulan sekarang
      'rlkeu'     => $this->template->rupiah($rlkeu), //realisasi keuangan kegiatan bulan sekarang termasuk belanja modal
      'prrlkeu'   => $prrlkeu,//persentase realisasi keuangan bulan sekarang di banding nilai pagu bulan sekarang = (rlkeu/nlblnskr) * 100
      'rlfisik'   => number_format($rlfisik,2), //realisasi fisik kegiatan bulan sekarang, hanya realfisik yang di etri manual pada saat realisasi , pada saat entri sudah termasuk hitungan real fisik belanja modal(dalam hitungan persen)
      'bbtrlfisik'=> number_format($bbtrlfisik,2),//hitungan dari rlfisik pada saat entri
      'mslh'      => $mslh,//permasalahan dari realisasi , ex misal tidak dapat merealisasikan kegiatan dengan alasan tertentu
      'det'       => $det
  );
   echo json_encode($data);
}



	// !@#$%^&* 09-12-2018Agung09-12-2018Agung09-12-2018Agung09-12-2018Agung
	public function dashboardpimpinan()
	{

			$this->template->load('template','dashboard_pimpinan');



	}
	// 09-12-2018Agung09-12-2018Agung09-12-2018Agung09-12-2018Agung !@#$%^&*
	function user(){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin()) {
			$this->template->load('template','muser');
		} else {
			redirect('Home', 'refresh');
		}

	}
	function gettoken(){
    	echo $this->security->get_csrf_hash();
	}

	function struktur(){

		$this->template->load('template','v_struktur');

	}
	function buildTree(array $elements, $parentId = 0) {
	    $branch = array();
		    foreach ($elements as $element) {
		        if ($element['parent'] == $parentId) {
		            $children = $this->buildTree($elements, $element['id']);
		            if ($children) {
		                $element['children'] = $children;
		            }
		            $branch[] = $element;
		        }
		    }
	    return $branch;
	}

	function jsonstruktur($opd){

		$items = [
		    0 => [
		        'id' => 1,
		        'parent' => 0,
		        'name' => 'Struktur',
		        'title' => 'Belum Ada'
		    ],

		    1 => [
		        'id' => 2,
		        'parent' => 1,
		        'name' => 'Struktur',
		        'title' => 'Belum Ada'
		    ],

		    2 => [
		        'id' => 3,
		        'parent' => 1,
		        'name' => 'Struktur',
		        'title' => 'Belum Ada'
		    ]
		];
		$result=$this->Cpanel_model->struktur($opd);
		if($result){
			$arr= $this->buildTree($result);
		}else{
			$arr= $this->buildTree($items);
		}

		$ok=$arr[0];
    	header('Content-Type: application/json');
    	echo json_encode($ok);
	}

	function jsonstruktura(){

		 // $menu = $this->db->get_where('menu', array('is_parent' => 0,'is_active'=>1));
   //          foreach ($menu->result() as $m) {
   //              // chek ada sub menu
   //              $submenu = $this->db->get_where('menu',array('is_parent'=>$m->id,'is_active'=>1));
   //              if($submenu->num_rows()>0){
   //              // tampilkan submenu
   //                	echo "<li class='treeview'>
   //                                  ".anchor('#',  "<i class='$m->icon'></i>".strtoupper($m->name).' <i class="fa fa-angle-left pull-right"></i>')."
   //                                      <ul class='treeview-menu'>";
   //                  foreach ($submenu->result() as $s){
   //                      echo "<li>" . anchor($s->link, "<i class='$s->icon'></i> <span>" . strtoupper($s->name)) . "</span></li>";
   //                  }
   //                                 echo"</ul>
   //                                  </li>";
   //              }else{
   //                  echo "<li>" . anchor($m->link, "<i class='$m->icon'></i> <span>" . strtoupper($m->name)) . "</span></li>";
   //              }
   //          }



		$arr= array(
		        'name' => 'Kadis',
		        'title' => 'Ruslayeti',
		        'children'=>[
		         	array(
		        		'name' => 'Kabid E-Gov',
		        		'title' => 'Armein Busra',
		         		'children'=>[]
        			),
        			array(
		        		'name' => 'Kabid Humas',
		        		'title' => 'Irwan',
		         		'children'=>[]
        			)
                ]
        	);

			// $arr=array(
		 //        'name' => 'Kadis',
		 //        'title' => 'Ruslayeti',

   //      	);

    	header('Content-Type: application/json');
    	// minimal PHP 5.2
    	echo json_encode($arr);

	}


	/*opd*/
	function jsonopd(){

    	header('Content-Type: application/json');
    	echo $this->Cpanel_model->jsonopd($this->tahunskr);
  	}

	function opd(){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin()) {
			$this->template->load('template','v_opd');
		} else {
			redirect('Home', 'refresh');
		}

	}

	/*Program*/
	function jsonprogram(){
    	header('Content-Type: application/json');
    	echo $this->Cpanel_model->jsonprogram($this->tahunskr);
  	}
	function program(){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin()) {
			$this->template->load('template','v_program');
		} else {
			redirect('Home', 'refresh');
		}

	}
	/*Kegiatan*/
	function jsonkegiatan(){
    	header('Content-Type: application/json');
    	echo $this->Cpanel_model->jsonkegiatan($this->tahunskr);
  	}
	function kegiatan(){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin()) {
			$this->template->load('template','v_kegiatan');
		} else {
			redirect('Home', 'refresh');
		}

	}
	/*Anggaran*/
	function jsonanggaran(){
    	header('Content-Type: application/json');
    	echo $this->Cpanel_model->jsonanggaran($this->tahunskr);
  	}
	function anggaran(){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin()) {
			$this->template->load('template','v_anggaran');
		} else {
			redirect('Home', 'refresh');
		}

	}
	/*opd DPA 2.2*/
	function jsonopddpa(){
    	header('Content-Type: application/json');
    	echo $this->Cpanel_model->jsonopddpa();
  	}
	function opddpa(){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin()) {
			$this->template->load('template','v_opd_dpa22');
		} else {
			redirect('Home', 'refresh');
		}

	}
	function cekopddpadetail(){
		$thn=$this->input->post('thn');
		$opd=$this->input->post('idunt');
	    $result=$this->Cpanel_model->detopd_dpa($thn,$opd);
    	if($result){
    		$arr['data'][]= array(
		        'status' => 'true',
		        'idunit' => $result->unitkey,
		        'nmunit' => $result->nmunit,
		        'tahun'	 => $result->tahun
        	);
    	}else{
      		$arr['data'][]= array(
        		'status' => 'false'
        	);
    	}
    	header('Content-Type: application/json');
    	// minimal PHP 5.2
    	echo json_encode($arr);
    }

	function opddpadetail($th,$id){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin()) {

			$opd= $this->Cpanel_model->detopd_dpa($th,$id);
			$program= $this->Cpanel_model->detprogram_dpa($th,$id);
			$this->data= array(
					'idopd'		=>  $id,
					'opd' 		=> 	$opd->nmunit,
          'thn' 		=>	$opd->tahun,
          'program' =>	$program
      );
		//	echo json_encode($this->data);
			$this->template->load('template','v_detail_dpa22',$this->data);
		} else {
			redirect('Home', 'refresh');
		}

	}

	/*User Per OPD*/
	function jsonuseropd(){
    	header('Content-Type: application/json');
    	echo $this->Cpanel_model->jsonuseropd();
  	}
	function opduser(){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin()) {
			$this->template->load('template','v_opd_user');
		} else {
			redirect('Home', 'refresh');
		}

	}

	function jsonuserlist_by($opd){
    	header('Content-Type: application/json');
    	echo $this->Cpanel_model->jsonuserlist_by($opd);
  	}
 //  	function jsonmastergroup(){
 //    	header('Content-Type: application/json');
 //    	$group= $this->ion_auth->groups()->result();

 //    	if ($group){
	// 	foreach($group as $row)
	// 	{
	// 		// ['data'][]
	// 		$arr['data'][]= array(

	// 			'id'			=>$row->id,
	// 			'name'			=>$row->name,
	// 			'description'	=>$row->description

	// 		);
	// 	}
	// 	echo json_encode($arr);
	// }else{
	// 	$arr['data'][]= array(

	// 			'status'	=>'false',
	// 			'message' 	=>'tidak ada data'
	// 		);
	// 	echo json_encode($arr);
	// }
 //    	// minimal PHP 5.2


 //  	}
  	public function getnama_group(){
    	$group= $this->ion_auth->groups()->result();

    	foreach ($group as $k) {
     		echo "<option value='{$k->id}'>{$k->description}</option>";
   		}
  	}

	function listuserperopd(){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin()) {
			$this->template->load('template','v_opd_user_detail');
		} else {
			redirect('Home', 'refresh');
		}

	}


	function generateuser(){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin()) {

			$postnip = $this->input->post('nip');
			$pns = $this->Cpanel_model->getpns($postnip);
			$username	= $pns->nip;
			$nama		= $pns->nama;
      $email 		= $pns->nip."@mail.com";
      $password 	= $pns->nip;
      $group_ids 	= $this->input->post('groups');
      $additional_data = array(
	       	'first_name' => $nama,
      		);

      		$this->ion_auth->register($username, $password, $email, $additional_data, $group_ids);

		} else {
			redirect('Home', 'refresh');
		}
	}

	function jsonopdentribaru(){
		$tahun          = $this->tahunskr;
    	header('Content-Type: application/json');
    	echo $this->Cpanel_model->opdentri_baru($tahun);
  	}

	function statnol(){

		$opd=$this->input->post('opd');
		//$opd='80_';
		$tahun    	= $this->tahunskr;
		$result			= $this->Cpanel_model->getppkmaster($opd,$tahun);
		$id 				= $result->id;
		$thn 				= $result->tahun;
		$unit 			= $result->nmunit;
		$nip 				= $result->nip;
		$nama 			= $result->nama;
	  $time		 		= $result->tgl_entri;
	 	$stat 			= $result->stat;
    	if($result){
    		$det=$this->Cpanel_model->detailstatnol($id);
    		foreach($det as $row){
    			$nipppk = $row->idpnsppk;
    			$nippptk = $row->idpnspptk;
    			$ppk 	= $this->Cpanel_model->getpns($nipppk);
					$pptk 	= $this->Cpanel_model->getpns($nippptk);
					$nmppk 	= $ppk->nama;
					$nmpptk = $pptk->nama;
					$detail[]= array(
						'keg'			=>$row->nmkegunit,
						'nl'			=>$row->nilai,
						'pptk'		=>$nmpptk,
						'ppk'			=>$nmppk,
						'stat'		=>$row->status
				);
			}
    	$this->Cpanel_model->baca($opd,$tahun);
    		$arr['data'][]= array(
		        'status' => 'true',
		        'id' => $id,
		        'thn' => $thn,
						'unit' => $unit,
						'nip' => $nip,
						'nama' => $nama,
			   		'time'=>$time,
			  		'stat'=>$stat,
			  		'detail'=>$detail
        	);
    	}else{
      		$arr['data'][]= array(
        		'status' => 'false'
        	);
    	}
    	header('Content-Type: application/json');
    	// minimal PHP 5.2
    	echo json_encode($arr);
    }


    function konfirmasientri(){

        if (!$this->ion_auth->logged_in()){
            redirect('Home/login', 'refresh');
        }elseif ($this->ion_auth->is_admin()){
           	$id = $this->input->post('id');
          	$admin = $this->ion_auth->user()->row()->username;
          	$tgl_entri      = date('Y/m/d h:i:sa');

            $list=array(
               'stat'      			=> '1',
               'admin_konfirmasi' 	=> $admin,
               'tgl_konfirmasi'  	=> $tgl_entri
            );

            $list2=array(
               'status'      		=> '1'
            );


            $result=$this->Cpanel_model->simpanentrikegiatan($id,$list,$list2);
            if($result){
                echo json_encode(array("status" => TRUE));
            }
        }else{
            redirect('User/general', 'refresh');
        }
    }

	/*API Dari Keuangan*/
	function tessum(){
		 $this->db->select('nilai');
      	$this->db->from('angkas');

      $tes= $this->db->get()->result();
      $nl=0;
      foreach ($tes as $key ) {

      	$nl+=$key->nilai;
      }
      echo $nl;
	}
	function tesarray(){
	$json_string = 'http://192.168.10.5:8080/angkas/22384ee59631a5a61ce3386af63c094b/2018/43_';
    $jsondata = file_get_contents($json_string);
    $obj = json_decode($jsondata, true);
    $data = array();
    foreach ($obj['DATA'] as $row) {
      $data[] = array(

          "kdkegunit"   =>  $row['KDKEGUNIT'],
          "nilai"    	=>  $row['NILAI'],


            );
    }
		$array = array(
        array('id' => 693, 'quantity' => 40),
        array('id' => 697, 'quantity' => 10),
        array('id' => 693, 'quantity' => 20),
        array('id' => 705, 'quantity' => 40),
        );

		$result = array();

		foreach($data as $k => $v) {
		    $id = $v['kdkegunit'];
		    $result[0][] = $v['nilai'];
		}

		$new = array();
		foreach($result as $key => $value) {
		    $new[] = array(
		    	'id' => $key,
		    	'quanity' => array_sum($value));
		}
		echo '<pre>';
		print_r($new);
	}

//API
	function apidaftunit(){
		$result=$this->Cpanel_model->adddaftunit($this->tahunskr);
		$data['data'][] = array(

			'status'   =>  $result

		);

		 echo json_encode($data);



	}
	function apiprgrm(){

		$result=$this->Cpanel_model->addprgrm($this->tahunskr);
		$data['data'][] = array(

			'status'   =>  $result

		);

		 echo json_encode($data);

	}

	function apimkegiatan(){

		$result=$this->Cpanel_model->addmkegiatan($this->tahunskr);
		$data['data'][] = array(

 			'status'   =>  $result

 		);

 		 echo json_encode($data);

	}

	function apimatangr(){
		$result=$this->Cpanel_model->addmatangr($this->tahunskr);
		$data['data'][] = array(

			'status'   =>  $result

		);

		 echo json_encode($data);

	}

	function apidpa22(){
		$unit = $this->input->post('unitkey');

		$result=$this->Cpanel_model->adddpa22($this->tahunskr,$unit);
		$data['data'][] = array(

			'status'   =>  $result

		);

		 echo json_encode($data);

	}

	function apidpa221(){

		$unit = $this->input->post('unitkey');
		$result=		$this->Cpanel_model->adddpa221($this->tahunskr,$unit);
		$data['data'][] = array(

			'status'   =>  $result

		);

		 echo json_encode($data);

	}

	function apiangkas(){
		$unit = $this->input->post('unitkey');
		$result=		$this->Cpanel_model->addangkas($this->tahunskr,$unit);
		$data['data'][] = array(
			'status'   =>  $result
		);
		 echo json_encode($data);
	}

	function apidpa21(){
		$result=$this->Cpanel_model->adddpa21();
	  echo $result;

	}

	function apidpa211(){
		$result=$this->Cpanel_model->adddpa211();
	  echo $result;

	}

	function angkas(){
		$result=$this->Cpanel_model->angkas();
	  echo $result;

	}


	/*********Agung-Agung-Agung-Agung-Agung-Agung-Agung-Agung-*/
	function raporOpd(){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin() || $this->ion_auth->is_walikota() ) {

			$datakeuangan = $this->Cpanel_model->getkeuangan_sampai($this->blnskr);
			$realisasikeu = $this->Cpanel_model->getrealisasikeu();
			$realfisik = $this->Cpanel_model->getrealisasifis();
			//$realisasifis = $this->Cpanel_model->getfisik($this->blnskr);
			$realisasifis = $this->Cpanel_model->getfisik(1);

			// echo json_encode($realisasifis);exit;
			// var_dump($realisasikeu);exit;
			foreach ($datakeuangan as $key => $value) {

				$realisasibmodal = $this->Cpanel_model->getrealisasi_bModal_by($realisasikeu[$key]->idpptkmaster)->realisasi_keu;
				$nilairealisasi = $realisasikeu[$key]->realisasi_keu + $realisasibmodal;
				//nilai realisasi sampai bulan sekarang
				$datakeuangan[$key]->realisasi_keu = $nilairealisasi;
				//persentase realisasi sampai bulan sekarang
				$persentasiReal= $realisasikeu[$key]->realisasi_keu / $datakeuangan[$key]->pagu_dana *100;
				$datakeuangan[$key]->persentasiReal = number_format($persentasiReal,2);
				//persentase target fisik sampai bulan sekarang
				$persenTarFis = $realisasifis[$key]->targetbulanini;
				if($persenTarFis!='Belum Ada KAK')
				$datakeuangan[$key]->target_fis = number_format($persenTarFis,2)."%";
				else
				$datakeuangan[$key]->target_fis = $persenTarFis;

				//persentase realisasi fisik sampai bulan sekarang
				$persenRealFis = $realfisik[$key]->realisasi_fis;
				$datakeuangan[$key]->realisasi_fis =$persenRealFis ;
				//nilairaporopd
				$nilai = ($persentasiReal * 100) / $datakeuangan[$key]->persenTarKeu;
				$datakeuangan[$key]->nilairapor = $nilai;
			}
			$data['data'] = $datakeuangan;
			$this->template->load('template','v_rapor_bulanan',$data);
		} else {
			redirect('Home', 'refresh');
		}
	}
	/*Agung-Agung-Agung-Agung-Agung-Agung-Agung-Agung-************/

	/*///////// Agung 29-11-2018Agung 29-11-2018Agung 29-11-2018Agung 29-11-2018Agung 29-11-2018*/
	function rekapBmodalOpd(){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin() || $this->ion_auth->is_walikota()) {

			$datakeuangan = $this->Cpanel_model->getkeuangan_bModal_smpai($this->blnskr);
			$realisasi = $this->Cpanel_model->getrealisasi_bModal();
			$fisik = $this->Cpanel_model->getfisik_bmodal($this->blnskr);
			foreach ($datakeuangan as $key => $value) {
				//nilai realisasi sampai bulan sekarang
				$datakeuangan[$key]->realisasi_keu = $realisasi[$key]->realisasi_keu;
				//persentase realisasi sampai bulan sekarang
				$persentasiReal= $realisasi[$key]->realisasi_keu / $datakeuangan[$key]->pagu_b_modal *100;
				$datakeuangan[$key]->persentasiReal = number_format($persentasiReal,2);
				//persentase target fisik sampai bulan sekarang
				$persenTarFis = $fisik[$key]->targetfis;
				$datakeuangan[$key]->target_fis = number_format($persenTarFis,2);
				//persentase realisasi fisik sampai bulan sekarang
				$persenRealFis = $realisasi[$key]->realisasi_fis;
				$datakeuangan[$key]->realisasi_fis =$persenRealFis ;
				//nilairaporopd
				$nilai = 0;
				if($datakeuangan[$key]->persenTarKeu != 0){
					$nilai = ($persentasiReal * 100) / $datakeuangan[$key]->persenTarKeu;
				}

				$datakeuangan[$key]->nilairapor = $nilai;
			}
			$data['data'] = $datakeuangan;
			$this->template->load('template','v_rekap_bmodal',$data);

		} else {
			redirect('Home', 'refresh');
		}
	}
	function opddetailprgrm($th,$id){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin()) {

			$opd= $this->Cpanel_model->detopd_dpa($th,$id);
			$program= $this->Cpanel_model->detprogram_dpa($th,$id);
			$this->data= array(
										'idopd'		=>  $id,
										'opd' 		=> 	$opd->nmunit,
                  	'thn' 		=>	$opd->tahun,
                  	'program' 	=>	$program
                 );

			$this->template->load('template','v_detail_program_opd',$this->data);
		} else {
			redirect('Home', 'refresh');
		}

	}
	function opddetailbmodal($th,$id){

		if (!$this->ion_auth->logged_in()) {
				// redirect them to the login page
				redirect('Home/login', 'refresh');
		}	elseif ($this->ion_auth->is_admin()) {

			$opd= $this->Cpanel_model->detopd_dpa($th,$id);
			$program= $this->Cpanel_model->detprogram_dpa($th,$id);
			$this->data= array(
										'idopd'		=>  $id,
										'opd' 		=> 	$opd->nmunit,
                  	'thn' 		=>	$opd->tahun,
                  	'program' 	=>	$program
                 );

			$this->template->load('template','v_detail_program_bmodal',$this->data);
		} else {
			redirect('Home', 'refresh');
		}

	}

	/* Agung 29-11-2018Agung 29-11-2018Agung 29-11-2018Agung 29-11-2018Agung 29-11-2018//////////////*/
	/* #####Agung Rabu,5-Des-2018--Agung Rabu,5-Des-2018--Agung Rabu,5-Des-2018*/
	function jsonmasalah(){
		$tahun = $this->input->post('tahun');
		$bulan = $this->input->post('bulan');
		$unitkey = $this->input->post('unitkey');

		$arrdata= array();
		$program= $this->Cpanel_model->detprogram_dpa($tahun,$unitkey);
		foreach ($program as $key => $value) {
			$idprog = $value->IDPRGRM;
			$keg = $this->Cpanel_model->getkegiatan_by($unitkey,$tahun,$idprog);
			$program[$key]->keg = $keg;
			foreach ($keg as $keykeg => $valkeg) {
				$idkeg = $valkeg->kdkegunit;
				$mslh = $this->Cpanel_model->getmasalah_by($unitkey,$bulan,$idkeg);
				$data = $mslh->row();
				if(($mslh->num_rows()) == 0 ){
					$keg[$keykeg]->masalah = 'Belum ada realisasi';
				}else{
					if( $data->permasalahan!='')
					$keg[$keykeg]->masalah = $data->permasalahan;
					else
					$keg[$keykeg]->masalah = 'Tidak Ada Masalah';

				}
			}
		}
		echo json_encode($program);
	}
	function jsonkota(){
		// echo $this->blnskr;exit;
		// $bulan = $this->input->post('bulan');
		$pagu = $this->Cpanel_model->getpagukota();
		$target = $this->Cpanel_model->gettargetkota_now();
		$realnonmodal = $this->Cpanel_model->getrealnonmodalkota_now();
		$realmodal = $this->Cpanel_model->getrealmodalkota_now();
		$data = array();
		$ntarget = 0;
		$realisasi = 0;
		foreach ($target as $key => $val) {
			 $ntarget += $target[$key]->target;
			if(array_key_exists($key,$realnonmodal)){
				$nrealnonmodal = $realnonmodal[$key]->realisasi;
			}else{
				$nrealnonmodal = 0;
			}
			if(array_key_exists($key,$realmodal)){
				$nrealmodal = $realmodal[$key]->realmodal;
			}else{
				$nrealmodal = 0;
			}
			$realisasi += $nrealnonmodal + $nrealmodal;
			$persentar = ($ntarget * 100)/$pagu;
			$persenreal = ($realisasi * 100)/$pagu;
			$data[]=array(
					'kd_bulan' => $key+1,
					'target' => $this->template->rupiah($ntarget),
					'persentar' => number_format($persentar,2),
					'realisasi' => $this->template->rupiah($realisasi),
					'persenreal' => number_format($persenreal,2)
			);
		}
		echo json_encode($data);
	}
	/* Agung Rabu,5-Des-2018--Agung Rabu,5-Des-2018--Agung Rabu,5-Des-2018############*/
}
