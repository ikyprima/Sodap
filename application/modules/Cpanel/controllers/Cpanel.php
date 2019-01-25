<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cpanel extends MX_Controller {
	public $data;
  public $blnskr;
	public $tahunskr;

	public function __construct()
	{
		parent::__construct();
		$this->blnskr =date('n');
		$this->tahunskr ='2019';
		// $this->blnskr =1;
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
     		echo "<option value='{$k->id}'>{$k->name}</option>";
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
			$realisasifis = $this->Cpanel_model->getfisik($this->blnskr);

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
