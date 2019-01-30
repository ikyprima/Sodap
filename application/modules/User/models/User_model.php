<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    public $tab_pns   = 'tab_pns';
    public function __construct()
    {
        parent::__construct();

    }
  //bagian kasubagprogram

  function ksubpro_listprogram($idopd,$thn){
    $this->db->select('mpgrm.IDPRGRM, mpgrm.NMPRGRM');
    $this->db->from('dpa22');
    $this->db->join('mkegiatan', 'dpa22.kdkegunit = mkegiatan.kdkegunit');
    $this->db->join('mpgrm', 'mpgrm.IDPRGRM = mkegiatan.idprgrm');
    $this->db->where('dpa22.unitkey', $idopd);
    $this->db->where('dpa22.tahun', $thn);
    $this->db->where('mpgrm.tahun', $thn);
    $this->db->where('mkegiatan.tahun', $thn);
    $this->db->group_by('mpgrm.IDPRGRM');
    return $this->db->get()->result_array();
  }

  function ksubpro_listkegiatan($idopd,$thn,$prog){
    $this->db->select('dpa22.kdkegunit,mkegiatan.nmkegunit, sum(dpa22.nilai) as nilai');
    $this->db->from('dpa22');
    $this->db->join('mkegiatan', 'dpa22.kdkegunit = mkegiatan.kdkegunit');
    $this->db->join('mpgrm', 'mpgrm.IDPRGRM = mkegiatan.idprgrm');
    $this->db->where('dpa22.unitkey', $idopd);
    $this->db->where('dpa22.tahun', $thn);
    $this->db->where('mpgrm.tahun', $thn);
    $this->db->where('mkegiatan.tahun', $thn);
    $this->db->where('mkegiatan.idprgrm', $prog);
    $this->db->group_by('dpa22.kdkegunit');
    return $this->db->get();
  }



  function addprgrm($thn){
        $fp = fsockopen("192.168.10.5", 8080, $errno, $errstr, 10);
        //if the socket failed it's offline...
        if (!$fp) {
            $status = false;
        }else{
        $url = 'http://192.168.10.5:8080/mpgrm/22384ee59631a5a61ce3386af63c094b/'.$thn;
        $jsondata = file_get_contents($url);
        $obj = json_decode($jsondata, true);


        $data['responcode']=$obj['ResponseCode'];
        $data['data']= array();
        $data['update']= array();
        $list= array();
        foreach ($obj['DATA'] as $row) {
          $idpgrm    = $row['IDPRGRM'];
          $nmprogram = $row['NMPRGRM'];

          $this->db->where('tahun', $thn);
          $this->db->where('IDPRGRM', $idpgrm);
          $cek = $this->db->get('mpgrm');
            if (!$cek->num_rows()>0){
              $data['data'][] = array(
                "IDPRGRM"  =>  $idpgrm,
                "NMPRGRM"  =>  $nmprogram,
                "tahun"    =>  $thn
              );
            }
          $data['update'][] = array(
            "idpgrm"  =>  $idpgrm,
            "nmpgrm"   =>  $nmprogram,
            "tahun"    =>  $thn
          );
        }

        if(empty($data['data'])){
            $status = true;
        }else{
          $this->db->trans_start();
          $this->db->insert_batch('mpgrm', $data['data']);
          $this->db->trans_complete();

          if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $status = false;
          }else{
            $this->db->trans_commit();
            $status = true;
          }
        }

          foreach ($data['update'] as $x => $key ) {
            $dataup=array(
              'NMPRGRM'=>$key['nmpgrm']
            );
            $this->db->where('tahun', $key['tahun']);
            $this->db->where('IDPRGRM', $key['idpgrm']);
            $this->db->update('mpgrm',$dataup);
          }

        }
          return $status;
  }

  function addmkegiatan($thn){

    $fp = fsockopen("192.168.10.5", 8080, $errno, $errstr, 10);
    //if the socket failed it's offline...
    if (!$fp) {
          $status = false;
    }else{
    $url = 'http://192.168.10.5:8080/mkegiatan/22384ee59631a5a61ce3386af63c094b/'.$thn;
    $jsondata = file_get_contents($url);
    $obj = json_decode($jsondata, true);
    $data['responcode']=$obj['ResponseCode'];
    $data['data']= array();
    $data['update']= array();
    $list= array();
    foreach ($obj['DATA'] as $row) {
      $idprgrm    = $row['IDPRGRM'];
      $kdkegunit  = $row['KDKEGUNIT'];
      $nmkegunit  = $row['NMKEGUNIT'];

      $this->db->where('tahun', $thn);
      $this->db->where('idprgrm', $idprgrm);
      $this->db->where('kdkegunit', $kdkegunit);
      $cek = $this->db->get('mkegiatan');
        if (!$cek->num_rows()>0){
          $data['data'][] = array(
            "idprgrm"    => $idprgrm,
            "kdkegunit"  => $kdkegunit,
            "nmkegunit"  => $nmkegunit,
            "tahun"      => $thn
          );
        }
      $data['update'][] = array(
        "idprgrm"    => $idprgrm,
        "kdkegunit"  => $kdkegunit,
        "nmkegunit"  => $nmkegunit,
        "tahun"      => $thn
      );
    }

    if(empty($data['data'])){
        $status = true;
    }else{
      $this->db->trans_start();
      $this->db->insert_batch('mkegiatan', $data['data']);
      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
        $status = false;
      }else{
        $this->db->trans_commit();
        $status = true;
      }
    }

      foreach ($data['update'] as $x => $key ) {
        $dataup=array(
          'nmkegunit'=>$key['nmkegunit']
        );
        $this->db->where('tahun', $key['tahun']);
        $this->db->where('idprgrm', $key['idprgrm']);
        $this->db->where('kdkegunit', $key['kdkegunit']);
        $this->db->update('mkegiatan',$dataup);
      }

    }
    return $status;
  }

  function sinkrondpa22($thn,$unit){

    // http://192.168.10.5:8080/dpa22/token/tahun/unitkey/kdkegunit
    // http://192.168.10.5:8080/dpa22/22384ee59631a5a61ce3386af63c094b/2018/80_/11_
    $fp = fsockopen("192.168.10.5", 8080, $errno, $errstr, 10);
    //if the socket failed it's offline...
    if (!$fp) {
            $status = false;
    }else{



    $url = 'http://192.168.10.5:8080/dpa22/22384ee59631a5a61ce3386af63c094b/'.$thn.'/'.$unit;
    $jsondata = file_get_contents($url);
    $obj = json_decode($jsondata, true);


    $data['responcode']=$obj['ResponseCode'];
    $data['data']= array();
    $data['update']= array();
    $list= array();
    foreach ($obj['DATA'] as $row) {
          $nilai    = $row['NILAI'];
          $kdkeg    = $row['KDKEGUNIT'];
          $mtgkey   = $row['MTGKEY'];
          $unitkey  = $row['UNITKEY'];

          $this->db->where('tahun', $thn);
          $this->db->where('unitkey', $unit);
          $this->db->where('kdkegunit', $kdkeg);
          $this->db->where('mtgkey', $mtgkey);
          $cek = $this->db->get('dpa22');
      if (!$cek->num_rows()>0){
        $data['data'][] = array(
          "nilai"       =>  $nilai,
          "kdkegunit"   =>  $kdkeg ,
          "mtgkey"      =>  $mtgkey ,
          "unitkey"     =>  $unitkey ,
          "tahun"       =>  $thn
        );
      }
      $data['update'][] = array(
        "nilai"       =>  $nilai,
        "kdkegunit"   =>  $kdkeg ,
        "mtgkey"      =>  $mtgkey ,
        "unitkey"     =>  $unitkey ,
        "tahun"       =>  $thn
      );

    }

    // $dataa = array(
    //    array(
    //      'tahun' => '2018',
    //      'mtgkey' => '1132_' ,
    //      'nilai' => '888'
    //    ),
    //    array(
    //       'tahun' => '2018',
    //       'mtgkey' => '1093_' ,
    //       'nilai' => '777'
    //
    //    )
    // );
    // $this->db->update_batch('dpa22', $dataa, 'mtgkey, tahun');
    //update batch kantau
  //  echo json_encode($data['update']);



    if(empty($data['data'])){
        $status = true;
    }else{
      $this->db->trans_start();
      $this->db->insert_batch('dpa22', $data['data']);
      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
        $status = false;
      }else{
        $this->db->trans_commit();
        $status = true;
      }
    }

        foreach ($data['update'] as $x => $key ) {
          $dataup=array(
              'nilai'=>$key['nilai']
          );
          $this->db->where('tahun', $key['tahun']);
          $this->db->where('unitkey', $key['unitkey']);
          $this->db->where('kdkegunit', $key['kdkegunit']);
          $this->db->where('mtgkey', $key['mtgkey']);
          $this->db->update('dpa22',$dataup);

        }



    }
    return $status;
  }
  function sinkrondpa221($thn,$unit){

    $fp = fsockopen("192.168.10.5", 8080, $errno, $errstr, 10);
    //if the socket failed it's offline...
    if (!$fp) {
        $status = false;
    }else{
    $url = 'http://192.168.10.5:8080/dpa221/22384ee59631a5a61ce3386af63c094b/'.$thn.'/'.$unit;
    $jsondata = file_get_contents($url);
    $obj = json_decode($jsondata, true);
    $data['responcode']=$obj['ResponseCode'];
    $data['data']= array();
    $data['update']= array();
    $list= array();
    foreach ($obj['DATA'] as $row) {
      //$row['SUBTOTAL'] tidak di  deklarasikan
        $satuan    =  $row['SATUAN'];
        $kdkegunit =  $row['KDKEGUNIT'];
        $mtgkey    =  $row['MTGKEY'];
        $jumbyek   =  $row['JUMBYEK'];
        $unitkey   =  $row['UNITKEY'];
        $uraian    =  $row['URAIAN'];
        $tarif     =  $row['TARIF'];
        $kdjabar   =  $row['KDJABAR'];
        $type      =  $row['TYPE'];

      $this->db->where('tahun', $thn);
      $this->db->where('unitkey', $unitkey);
      $this->db->where('kdkegunit', $kdkegunit);
      $this->db->where('mtgkey', $mtgkey);
      $this->db->where('type', $type);
      $this->db->where('kdjabar', $kdjabar);
      $cek = $this->db->get('dpa221');

        if (!$cek->num_rows()>0){
          $data['data'][] = array(
             "satuan"    =>  $satuan,
             "kdkegunit" =>  $kdkegunit,
             "mtgkey"    =>  $mtgkey,
             "jumbyek"   =>  $jumbyek,
             "unitkey"   =>  $unitkey,
             "uraian"    =>  $uraian,
             "tarif"     =>  $tarif,
             "kdjabar"   =>  $kdjabar,
             "type"      =>  $type,
             "tahun"     =>  $thn
          );
        }

      $data['update'][] = array(
        "satuan"    =>  $satuan,
        "kdkegunit" =>  $kdkegunit,
        "mtgkey"    =>  $mtgkey,
        "jumbyek"   =>  $jumbyek,
        "unitkey"   =>  $unitkey,
        "uraian"    =>  $uraian,
        "tarif"     =>  $tarif,
        "kdjabar"   =>  $kdjabar,
        "type"      =>  $type,
        "tahun"     =>  $thn
      );
    }

    if(empty($data['data'])){
        $status = true;
    }else{
      $this->db->trans_start();
      $this->db->insert_batch('dpa221', $data['data']);
      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
        $status = false;
      }else{
        $this->db->trans_commit();
        $status = true;
      }
    }

      foreach ($data['update'] as $x => $key ) {

        $dataup=array(
          'jumbyek'  => $key['jumbyek'],
          'satuan'   => $key['satuan'],
          'tarif'    => $key['tarif'],
          'uraian'   => $key['uraian']
        );

          $this->db->where('tahun', $key['tahun']);
          $this->db->where('unitkey', $key['unitkey']);
          $this->db->where('kdkegunit', $key['kdkegunit']);
          $this->db->where('mtgkey', $key['mtgkey']);
          $this->db->where('type', $key['type']);
          $this->db->where('kdjabar', $key['kdjabar']);
          $this->db->update('dpa221',$dataup);
        }
      }
    return $status;
  }


  function ksubpro_listprogram_dpa($idopd,$thn){
    $this->db->select('mpgrm.IDPRGRM, mpgrm.NMPRGRM');
    $this->db->from('dpa221');
    $this->db->join('mkegiatan', 'dpa221.kdkegunit = mkegiatan.kdkegunit');
    $this->db->join('mpgrm', 'mpgrm.IDPRGRM = mkegiatan.idprgrm');
    $this->db->where('dpa221.unitkey', $idopd);
    $this->db->where('dpa221.tahun', $thn);
    $this->db->group_by('mpgrm.IDPRGRM');
    return $this->db->get()->result_array();
  }
  function ksubpro_listkegiatan_dpa($idopd,$thn,$prog){
    $this->db->select('dpa221.kdkegunit,mkegiatan.nmkegunit,SUM(`dpa221`.`jumbyek` *`dpa221`.`tarif`) as nilai');
    $this->db->from('dpa221');
    $this->db->join('mkegiatan', 'dpa221.kdkegunit = mkegiatan.kdkegunit');
    $this->db->join('mpgrm', 'mpgrm.IDPRGRM = mkegiatan.idprgrm');
    $this->db->where('dpa221.unitkey', $idopd);
    $this->db->where('dpa221.tahun', $thn);
    $this->db->where('mkegiatan.idprgrm', $prog);
    $this->db->group_by('dpa221.kdkegunit');
    return $this->db->get();
  }

  function lv1($unit,$kdkegunit,$thn){
    $this->db->select('sum(`dpa22`.`nilai`) as jml ,SUBSTRING(`matangr`.`kdper`,1,4) AS rek');
    $this->db->from('dpa22');
    $this->db->join('matangr', '`dpa22`.`mtgkey` = `matangr`.`mtgkey`');
    $this->db->where('`dpa22`.`unitkey`', $unit);
    $this->db->where('`dpa22`.`kdkegunit`', $kdkegunit);
    $this->db->where('`dpa22`.`tahun`', $thn);
    $this->db->where('`matangr`.`tahun`', $thn);
    $this->db->group_by('SUBSTRING(`kdper`,1,4)');
    return $this->db->get()->row_array();
  }

  function mtglv($kdrek,$thn){
    $this->db->select('kdper,nmper');
    $this->db->from('matangr');
    $this->db->where('kdper', $kdrek);
    $this->db->where('tahun', $thn);
    return $this->db->get()->row_array();
  }

  function lv2($unit,$kdkegunit,$thn){
    $this->db->select('sum(`dpa22`.`nilai`) as jml, SUBSTRING(`matangr`.`kdper`,1,6) AS rek');
    $this->db->from('dpa22');
    $this->db->join('matangr', '`dpa22`.`mtgkey` = `matangr`.`mtgkey`');
    $this->db->where('`dpa22`.`unitkey`', $unit);
    $this->db->where('`dpa22`.`kdkegunit`', $kdkegunit);
    $this->db->where('`dpa22`.`tahun`', $thn);
    $this->db->where('`matangr`.`tahun`', $thn);
    $this->db->group_by('SUBSTRING(`kdper`,1,6)');
    $this->db->order_by('`matangr`.`kdper`','asc');
    return $this->db->get()->result_array();

  }

  function lv3($unit,$kdkegunit,$thn,$rek){
    $this->db->select('sum(`dpa22`.`nilai`) as jml,SUBSTRING(`matangr`.`kdper`,1,9) AS rek');
    $this->db->from('dpa22');
    $this->db->join('matangr', '`dpa22`.`mtgkey` = `matangr`.`mtgkey`');
    $this->db->where('`dpa22`.`unitkey`', $unit);
    $this->db->where('`dpa22`.`kdkegunit`', $kdkegunit);
    $this->db->where('`dpa22`.`tahun`', $thn);
    $this->db->where('`matangr`.`tahun`', $thn);
    // $this->db->where('`matangr`.`kdper`', 'SUBSTRING('..',1,9)');
    $this->db->like('`matangr`.`kdper`', $rek, 'both');
    $this->db->group_by('SUBSTRING(`kdper`,1,9)');
    $this->db->order_by('`matangr`.`kdper`','asc');
    return $this->db->get()->result_array();
  }

  function jsondpa22($unit,$kdkegunit,$thn,$rek){
    $this->db->select('`dpa22`.`id`
    , `dpa22`.`unitkey`
    , `dpa22`.`kdkegunit`
    , `dpa22`.`mtgkey`
    , `dpa22`.`nilai`
    , `dpa22`.`tahun`
    , `matangr`.`kdper`
    , `matangr`.`nmper`
    , `matangr`.`type`
    , `matangr`.`mtglevel`');
    $this->db->from('dpa22');
    $this->db->join('matangr', '`dpa22`.`mtgkey` = `matangr`.`mtgkey`');
    $this->db->where('`dpa22`.`unitkey`', $unit);
    $this->db->where('`dpa22`.`kdkegunit`', $kdkegunit);
    $this->db->where('`dpa22`.`tahun`', $thn);
    $this->db->where('`matangr`.`tahun`', $thn);
    $this->db->like('`matangr`.`kdper`', $rek, 'both');
    $this->db->order_by('`matangr`.`kdper`','asc');
    return $this->db->get()->result_array();

  }
  function jsondpa221($unit,$kdkegunit,$mtgkey,$thn){

    $this->db->where('`dpa221`.`tahun`', $thn);
    $this->db->where('`dpa221`.`unitkey`', $unit);
    $this->db->where('`dpa221`.`kdkegunit`', $kdkegunit);
    $this->db->where('`dpa221`.`mtgkey`', $mtgkey);
    return $this->db->get('dpa221')->result_array();

  }

  function sinkronangkas($thn,$unit){

  $fp = fsockopen("192.168.10.5", 8080, $errno, $errstr, 10);
  //if the socket failed it's offline...
  if (!$fp) {
      $status = false;
  }else{
  $url = 'http://192.168.10.5:8080/angkas/22384ee59631a5a61ce3386af63c094b/'.$thn.'/'.$unit;
  $jsondata = file_get_contents($url);
  $obj = json_decode($jsondata, true);
  $data['responcode']=$obj['ResponseCode'];
  $data['data']= array();
  $data['update']= array();
  $list= array();
  foreach ($obj['DATA'] as $row) {
    $unitkey   = $row['UNITKEY'];
    $kdkegunit = $row['KDKEGUNIT'];
    $kd_bulan  = $row['KD_BULAN'];
    $nilai     = $row['NILAI'];
    $mtgkey    = $row['MTGKEY'];

    $this->db->where('tahun', $thn);
    $this->db->where('unitkey', $unitkey);
    $this->db->where('kdkegunit', $kdkegunit);
    $this->db->where('mtgkey', $mtgkey);
    $this->db->where('kd_bulan', $kd_bulan );
    $cek = $this->db->get('angkas');

      if (!$cek->num_rows()>0){
        $data['data'][] = array(
          "unitkey"     =>  $unitkey,
          "kdkegunit"   =>  $kdkegunit,
          "kd_bulan"    =>  $kd_bulan ,
          "nilai"       =>  $nilai,
          "mtgkey"      =>  $mtgkey,
          "tahun"       =>  $thn
        );
      }

    $data['update'][] = array(
      "unitkey"     =>  $unitkey,
      "kdkegunit"   =>  $kdkegunit,
      "kd_bulan"    =>  $kd_bulan ,
      "nilai"       =>  $nilai,
      "mtgkey"      =>  $mtgkey,
      "tahun"       =>  $thn
    );
  }

  if(empty($data['data'])){
      $status = true;
  }else{
    $this->db->trans_start();
    $this->db->insert_batch('angkas', $data['data']);
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE){
      $this->db->trans_rollback();
      $status = false;
    }else{
      $this->db->trans_commit();
      $status = true;
    }
  }

    foreach ($data['update'] as $x => $key ) {


      $dataup=array(

        'nilai'      => $key['nilai']
      );

      $this->db->where('tahun',$key['tahun'] );
      $this->db->where('unitkey', $key['unitkey'] );
      $this->db->where('kdkegunit',$key['kdkegunit'] );
      $this->db->where('mtgkey', $key['mtgkey'] );
      $this->db->where('kd_bulan', $key['kd_bulan'] );
      $this->db->update('angkas',$dataup);
    }

  }
  return $status;

  }

  //akhir kasubagprogram


    function cekstrukturopd($opd){
      $this->db->where('id_unit', $opd);
      return $this->db->get('tab_struktur')->row();
    }

    function cekstrukturpns($nip){
      $this->db->where('nip', $nip);
      return $this->db->get('tab_struktur')->row();
    }

    function cekkegiatan($opd,$thn){
      $this->db->where('tahun', $thn);
      $this->db->where('unitkey', $opd);
      return $this->db->get('tab_pptk_master');
    }

    function cekkegiatanentri($opd){
      $this->db->where('unitkey', $opd);
      $this->db->where('stat', '1');
      return $this->db->get('tab_pptk_master')->row();
    }

    function struktur($opd){
      $this->db->select('tab_struktur.id,parent,tab_struktur.nama as name,tab_pns.nama as title,ikon as className');
      $this->db->from('tab_pns');
      $this->db->join('tab_struktur', 'tab_pns.nip = tab_struktur.nip');
      $this->db->where('tab_struktur.id_unit', $opd);


      return $this->db->get()->result_array();
    }
/********AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI*/
    function jsonstrukturlist_by($opd)
    {
      $this->datatables->select("*");
      $this->datatables->from('`v_kelola_opd`');
      $this->datatables->where('`v_kelola_opd`.`id_unit`', $opd);
      $this->datatables->add_column('action', '<button class="opdeditkelola btn btn-info">Edit<div class="ripple-container"></div></button>' );
      return $this->datatables->generate();
    }
    function updatestruktur($data,$id)
    {

        $this->db->where('id', $id);
        $upstrukt = $this->db->update('tab_struktur', $data);
        if($upstrukt)
          return true;
        else
          return false;
    }
    function getidstruktur($nip){
      $this->db->select('*');
      $this->db->from('tab_struktur');
      $this->db->where('tab_struktur.nip', $nip);


      return $this->db->get()->row()->id;
    }
    /*AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI*************/
	function getpns($nip){
      $this->db->where('nip', $nip);
      return $this->db->get($this->tab_pns)->row();
    }
//--------------------------------------------------------------------------------------------------------------//
	//pptk
  //#ryh
  function getnamaopd($nip){
    $this->db->select('`daftunit`.`unitkey`,`daftunit`.`nmunit`');
    $this->db->from('`tab_pns`');
    $this->db->join('daftunit', '`tab_pns`.`unitkey` = `daftunit`.`unitkey`');
    $this->db->where('nip', $nip);
    return $this->db->get()->row();
  }


    function getlistkegiatan($nip,$thn){

     $this->db->select('
      `tab_pptk`.`id`
    ,`mkegiatan`.`kdkegunit`
    ,`mkegiatan`.`nmkegunit`
    , `tab_pptk`.`nilai`
    , u2.nama idpnspptk
    , u1.nama idpnsppk');
      $this->db->from('tab_pptk');
      $this->db->join('tab_pns u1', 'tab_pptk.idpnsppk = u1.nip');
      $this->db->join('tab_pns u2', 'tab_pptk.idpnspptk = u2.nip');
      $this->db->join('tab_pptk_master', 'tab_pptk.id_pptk_master = tab_pptk_master.id');
      $this->db->join('daftunit', 'tab_pptk_master.unitkey = daftunit.unitkey');
      $this->db->join('mkegiatan', 'tab_pptk.kdkegunit = mkegiatan.kdkegunit');
      $this->db->where('tab_pptk_master.tahun', $thn);
      $this->db->where('daftunit.tahun', $thn);
      $this->db->where('mkegiatan.tahun', $thn);
      $this->db->where('tab_pptk.idpnspptk', $nip);
      return $this->db->get()->result_array();
    }
    function getdetlistkegiatan($nip,$kdkegunit,$thn){

     $this->db->select('
    `tab_pptk`.`id`
    ,`mkegiatan`.`kdkegunit`
    ,`mkegiatan`.`nmkegunit`
    , `tab_pptk`.`nilai`
    , u2.nama idpnspptk
    , u1.nama idpnsppk');
      $this->db->from('tab_pptk');
      $this->db->join('tab_pns u1', 'tab_pptk.idpnsppk = u1.nip');
      $this->db->join('tab_pns u2', 'tab_pptk.idpnspptk = u2.nip');
      $this->db->join('tab_pptk_master', 'tab_pptk.id_pptk_master = tab_pptk_master.id');
      $this->db->join('daftunit', 'tab_pptk_master.unitkey = daftunit.unitkey');
      $this->db->join('mkegiatan', 'tab_pptk.kdkegunit = mkegiatan.kdkegunit');
      $this->db->where('tab_pptk_master.tahun', $thn);
      $this->db->where('daftunit.tahun', $thn);
      $this->db->where('mkegiatan.tahun', $thn);
      $this->db->where('tab_pptk.idpnspptk', $nip);
      $this->db->where('tab_pptk.kdkegunit', $kdkegunit);
      return $this->db->get()->row();
    }
    function getdetlistkegiatan_detpptk($nip,$kdkegunit,$thn){

     $this->db->select('
      `mpgrm`.`NMPRGRM` as prog
    ,`mkegiatan`.`kdkegunit` as kdkeg
    ,`mkegiatan`.`nmkegunit` as keg
    ,`tab_pptk`.`nilai` as nl
    , u2.nama pptk
    , u1.nama ppk');
      $this->db->from('tab_pptk');
      $this->db->join('tab_pns u1', 'tab_pptk.idpnsppk = u1.nip');
      $this->db->join('tab_pns u2', 'tab_pptk.idpnspptk = u2.nip');
      $this->db->join('tab_pptk_master', 'tab_pptk.id_pptk_master = tab_pptk_master.id');
      $this->db->join('daftunit', 'tab_pptk_master.unitkey = daftunit.unitkey');
      $this->db->join('mkegiatan', 'tab_pptk.kdkegunit = mkegiatan.kdkegunit');
      $this->db->join('mpgrm', 'mkegiatan.idprgrm = mpgrm.IDPRGRM');
      $this->db->where('tab_pptk_master.tahun', $thn);
      $this->db->where('daftunit.tahun', $thn);
      $this->db->where('mkegiatan.tahun', $thn);
      $this->db->where('mpgrm.tahun', $thn);
      $this->db->where('tab_pptk.idpnspptk', $nip);
      $this->db->where('tab_pptk.kdkegunit', $kdkegunit);
      return $this->db->get()->row();
    }

     function getheader_realisasipptk($unit,$kdkegunit,$thn){

     $this->db->select('
       `dpa221`.`kdkegunit`
      , `dpa221`.`mtgkey`
      , `dpa221`.`unitkey`
      ,`matangr`.`kdper`
      , `matangr`.`nmper`
      ,SUM(`dpa221`.`jumbyek` *`dpa221`.`tarif`) as nilai');
      $this->db->from('dpa221');
      $this->db->join('matangr', '`dpa221`.`mtgkey` = `matangr`.`mtgkey`');
      $this->db->where('`dpa221`.`tahun`', $thn);
      $this->db->where('`dpa221`.`unitkey`', $unit);
      $this->db->where('`dpa221`.`kdkegunit`', $kdkegunit);
      $this->db->group_by('`matangr`.`kdper`');
      return $this->db->get()->result_array();
    }
     function getheader_realisasipptk_angkas($unit,$kdkegunit,$bulan,$thn){

     $this->db->select('
      `angkas`.`id`
      ,`angkas`.`unitkey`
      ,`angkas`.`kdkegunit`
      , `angkas`.`mtgkey`
      , `matangr`.`kdper`
      , `matangr`.`nmper`
      , `angkas`.`nilai`
      , `angkas`.`tahun`');
      $this->db->from('angkas');
      $this->db->join('matangr', '`angkas`.`mtgkey` = `matangr`.`mtgkey`');
      $this->db->where('`angkas`.`tahun`', $thn);
      $this->db->where('`angkas`.`unitkey`', $unit);
      $this->db->where('`angkas`.`kdkegunit`', $kdkegunit);
      $this->db->where('`angkas`.`kd_bulan`', $bulan);
      $this->db->order_by('`matangr`.`kdper`','asc');
      return $this->db->get()->result_array();
    }

      function anggaranopd($idopd){
        $this->db->select('SUM(nilai)AS anggranopd');
        $this->db->from('angkas');
        $this->db->where('`angkas`.`kdkegunit` !=', '0_');
         $this->db->where('`angkas`.`unitkey`', $idopd);
        return $this->db->get()->row();
      }
       function sumberdana(){

        return $this->db->get('tab_sumber_dana')->result_array();
      }
    function getlistkak_by($idtabpptk){
     $this->db->select('`tab_schedule`.*');
      $this->db->from('tab_schedule');
      $this->db->join('tab_kak', '`tab_schedule`.`id_tab_kak` = `tab_kak`.`id`');
      $this->db->where('`tab_kak`.`idtab_pptk`', $idtabpptk);
      return $this->db->get()->result();
    }

    /*Dari agung*/
    function getkak_by($idtabpptk){
     $this->db->select('`tab_kak`.*
                        , `mkegiatan`.`nmkegunit` AS kegiatan
                        , `mpgrm`.`NMPRGRM` AS program
                        , `tab_pptk`.`nilai` AS pagu_dana
                        , `tab_pns`.`nama` AS nama_pptk
                        ');
      $this->db->from('tab_pptk');
      $this->db->join('tab_kak', '`tab_pptk`.`id` = `tab_kak`.`idtab_pptk`');
      $this->db->join('mkegiatan', '`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`');
      $this->db->join('mpgrm', '`mkegiatan`.`idprgrm` = `mpgrm`.`IDPRGRM`');
      $this->db->join('`tab_pns`', '`tab_pptk`.`idpnspptk` = `tab_pns`.`nip`');
      $this->db->where('`tab_kak`.`idtab_pptk`', $idtabpptk);
      return $this->db->get()->row();
    }

    function getSchedule_by($idkak){
     $this->db->select('`tab_schedule`.*');
      $this->db->from('tab_schedule');
      $this->db->join('tab_kak', '`tab_schedule`.`id_tab_kak` = `tab_kak`.`id`');
      $this->db->where('`tab_schedule`.`id_tab_kak`', $idkak);
      return $this->db->get()->result();
    }

    function getBljModal_by($idtabpptk){

     $this->db->select('`tab_schedule_blnj_mdl`.*
                        , `matangr`.`kdper` AS `no_rekening`
                        , `matangr`.`nmper` AS `nama_rekening`');
     $this->db->from('`tab_schedule_blnj_mdl`');
     $this->db->join('`tab_target_blnj_modal`', '`tab_schedule_blnj_mdl`.`id_tab_target` = `tab_target_blnj_modal`.`id`');
     $this->db->join('`tab_metode_pelaksanaan`', '`tab_metode_pelaksanaan`.`id` = `tab_target_blnj_modal`.`id_mtde_plk`');
     $this->db->join('`matangr`', '`tab_target_blnj_modal`.`mtgkey` = `matangr`.`mtgkey`');
     $this->db->where('`tab_target_blnj_modal`.`idtab_pptk`',$idtabpptk);
      return $this->db->get()->result();

    }
function getttdkak($idtabpptk){
     $this->db->select('`tab_kak`.*
                         , `tab_kak`.`id` AS id
                         ,`tab_pptk_master`.`unitkey` AS unit
             ,`tab_struktur`.`peran` as peran
             , `tab_pns`.`nama` AS nama
             , `tab_pns`.`nip` AS nip
                        ');
      $this->db->from('tab_pptk');
      $this->db->join('tab_kak', '`tab_pptk`.`id` = `tab_kak`.`idtab_pptk`');
    $this->db->join('`tab_pptk_master`', '`tab_pptk`.`id_pptk_master` = `tab_pptk_master`.`id`');
     $this->db->join('`tab_struktur` ', '`tab_pptk_master`.`unitkey` = `tab_struktur`.`id_unit`');
      $this->db->join('`tab_pns`', '`tab_struktur`.`nip` = `tab_pns`.`nip`');
    $this->db->where('`tab_struktur`.`peran`', 1);
      $this->db->where('`tab_kak`.`idtab_pptk`', $idtabpptk);
      return $this->db->get()->row();
    }
    /*Sampai agung*/

     function kegperbulan($idkeg,$unitkey,$thn){

      $this->db->select('kd_bulan,SUM(`nilai`) as nilai');
      $this->db->from('angkas');
      $this->db->where('angkas.tahun', $thn);
      $this->db->where('angkas.kdkegunit', $idkeg);
      $this->db->where('angkas.unitkey', $unitkey);
      $this->db->group_by('angkas.kd_bulan');
      $this->db->order_by('angkas.kd_bulan','asc');
      return $this->db->get()->result_array();
     }

      function angkasrek_by($idkeg,$unitkey,$bulan,$thn){

      $this->db->select('
        `angkas`.`mtgkey`
      , `angkas`.`nilai`
      , `matangr`.`nmper`
      , `matangr`.`kdper`
      , `matangr`.`tahun`');
      $this->db->from('angkas');
      $this->db->join('matangr', 'angkas.mtgkey = matangr.mtgkey');
      $this->db->where('angkas.tahun', $thn);
      $this->db->where('matangr.tahun', $thn);
      $this->db->where('angkas.kdkegunit', $idkeg);
      $this->db->where('angkas.unitkey', $unitkey);
      $this->db->where('angkas.kd_bulan', $bulan);
      $this->db->order_by('matangr.kdper','asc');
      return $this->db->get()->result_array();
      }

      function cekstatkak($tab){
        $this->db->where('idtab_pptk', $tab);
        return $this->db->get('tab_kak');
      }

    function simpanrealisasi($data,$idubah){

        if($idubah==1){
            $idreal = $this->input->post('idreal');
            $this->db->trans_start();
            $this->db->where('id', $idreal);
            $this->db->update('tab_realisasi', $data);

            $iddpa     = $this->input->post('iddpa');
            $mtgkey     = $this->input->post('mtgkey');
            $kdrek      = $this->input->post('kdrek');
            $sumberdana = $this->input->post('sumberdn');
            $volume     = $this->input->post('volume');
            $hrsatuan   = $this->input->post('hrsatuan');
            $jum        = $this->input->post('jum');
            $sisadn     = $this->input->post('sisadn');
            $detpgblnskr     = $this->input->post('detpgblnskr');
            $list=array();
            for($i=0; $i < count ($kdrek); $i++){
              $var1 = str_replace("Rp ","",$hrsatuan[$i]);
              $var2 = str_replace("Rp ","",$jum[$i]);
              $var3 = str_replace("Rp ","",$sisadn[$i]);
            //jika jumlah tidak sama dengan 0 dan hrsatuan =0 maka reset jumlah ke 0
            if($volume[$i]!=0 && $var1==0){
              $vol=0;

            }else{
              $vol=$volume[$i];


            }
              $list[$i]=array(

                'id_dpa'          => $iddpa[$i],
                'mtgkey'          => $mtgkey[$i],
                'kd_rek'          => $kdrek[$i],
                'sumber_dana'     => $sumberdana[$i],
                'vol'             => $vol,
                'harga_satuan'    => str_replace(".","",$var1),
                'jumlah_harga'    => str_replace(".","",$var2),
                'sisa_dana'       => str_replace(".","",$var3),
                'pagu_perbln'     => $detpgblnskr[$i]
              );
            }
            $this->db->where('id_tab_realisasi', $idreal);
            $this->db->update_batch('tab_realisasi_det', $list,'id_dpa');
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE){
              $this->db->trans_rollback();
              return FALSE;
            }else{
              $this->db->trans_commit();
              return TRUE;
            }

        }else{

          $this->db->trans_start();
          $this->db->insert('tab_realisasi', $data);
          $id_master  = $this->db->insert_id();
          $iddpa     = $this->input->post('iddpa');
          $mtgkey     = $this->input->post('mtgkey');
          $kdrek      = $this->input->post('kdrek');
          $sumberdana = $this->input->post('sumberdn');
          $volume     = $this->input->post('volume');
          $hrsatuan   = $this->input->post('hrsatuan');
          $jum        = $this->input->post('jum');
          $sisadn     = $this->input->post('sisadn');
          $detpgblnskr     = $this->input->post('detpgblnskr');
          $list=array();
          for($i=0; $i < count ($kdrek); $i++){
            $var1 = str_replace("Rp ","",$hrsatuan[$i]);
            $var2 = str_replace("Rp ","",$jum[$i]);
            $var3 = str_replace("Rp ","",$sisadn[$i]);
          //jika jumlah tidak sama dengan 0 dan hrsatuan =0 maka reset jumlah ke 0
          if($volume[$i]!=0 && $var1==0){
            $vol=0;

          }else{
            $vol=$volume[$i];


          }
            $list[$i]=array(
              'id_tab_realisasi'=> $id_master,
              'id_dpa'          => $iddpa[$i],
              'mtgkey'          => $mtgkey[$i],
              'kd_rek'          => $kdrek[$i],
              'sumber_dana'     => $sumberdana[$i],
              'vol'             => $vol,
              'harga_satuan'    => str_replace(".","",$var1),
              'jumlah_harga'    => str_replace(".","",$var2),
              'sisa_dana'       => str_replace(".","",$var3),
              'pagu_perbln'     => $detpgblnskr[$i]
            );
          }

          $this->db->insert_batch('tab_realisasi_det', $list);

          $this->db->trans_complete();

          if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
          }else{
            $this->db->trans_commit();
            return TRUE;
          }

        }

      }

      function simpanrealisasibmodal($data,$detail){
          $this->db->trans_start();
          $this->db->insert('tab_realisasi_bmodal', $data);
          $id_master = $this->db->insert_id();
          $detail["id_tab_real_bmodal"] = $id_master;
          $this->db->insert('tab_realisasi_bmodal_det', $detail);
          $this->db->trans_complete();

          if ($this->db->trans_status() === FALSE)
          {
            $this->db->trans_rollback();
            return FALSE;
          }
          else
          {
            $this->db->trans_commit();
            return TRUE;
          }
        }
        function simpanrealisasibmodaldet($detail){
            $this->db->trans_start();

            $this->db->insert('tab_realisasi_bmodal_det', $detail);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE)
            {
              $this->db->trans_rollback();
              return FALSE;
            }
            else
            {
              $this->db->trans_commit();
              return TRUE;
            }
          }
          function ubahrealisasibmodaldet($detail,$iddet)
          {
            $this->db->where('id', $iddet);
            $updetbljmodal = $this->db->update('tab_realisasi_bmodal_det', $detail);
            if($updetbljmodal)
              return true;
            else
              return false;


          }

//akhir pptk
//-------------------------------------------------------------------------------------------------//

//-------------------------------------------------------------------------------------------------//
//ppk
//#ryh
function tarkeu_ppk($unit,$thn,$kdbln,$kdkeg){
// select angkas
  $this->db->select('sum(nilai) as nilai');
  $this->db->from('angkas');
  $this->db->where('angkas.tahun', $thn);
  $this->db->where('angkas.unitkey', $unit);
  $this->db->where('angkas.kdkegunit', $kdkeg);
  $this->db->where('angkas.kd_bulan', $kdbln);
  $this->db->where('angkas.kdkegunit!=', '0_');
  $this->db->group_by('angkas.kdkegunit');
  return $this->db->get()->row_array();
}
function tarkeu_ppk_thn($unit,$thn,$kdkeg){
// select angkas
  $this->db->select('sum(nilai) as nilai');
  $this->db->from('angkas');
  $this->db->where('angkas.tahun', $thn);
  $this->db->where('angkas.unitkey', $unit);
  $this->db->where('angkas.kdkegunit', $kdkeg);
  $this->db->where('angkas.kdkegunit!=', '0_');
  $this->db->group_by('angkas.kdkegunit');
  return $this->db->get()->row_array();
}
function realkeu_ppk_persen($wherein,$thn,$kdbln,$sd=null){
// select tab_realisasi MONTH(`tab_realisasi_bmodal`.`real_bulan`)
  $this->db->select('SUM(`tab_realisasi_det`.`jumlah_harga`) AS nilai');
  $this->db->from('`tab_realisasi_det`');
  $this->db->join('tab_realisasi', '`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`');
  $this->db->where_in('tab_realisasi.id_tabpptk', $wherein);
  if($sd!=null){
    $this->db->where('MONTH(`tab_realisasi`.`real_bulan`) <=', $kdbln);
  }else{
    $this->db->where('MONTH(`tab_realisasi`.`real_bulan`)', $kdbln);
  }
  $this->db->where('YEAR(`tab_realisasi`.`real_bulan`)', $thn);
  return $this->db->get()->row_array();
}
function realkeu_ppk_bmodal_persen($wherein,$thn,$kdbln,$sd=null){
// select tab_realisasi MONTH(`tab_realisasi_bmodal`.`real_bulan`)
  $this->db->select('SUM(`tab_realisasi_bmodal_det`.`real_keuangan`) AS nilai');
  $this->db->from('`tab_realisasi_bmodal_det`');
  $this->db->join('tab_realisasi_bmodal', '`tab_realisasi_bmodal_det`.`id_tab_real_bmodal` = `tab_realisasi_bmodal`.`id`');
  $this->db->where_in('tab_realisasi_bmodal.id_tab_pptk', $wherein);
  if($sd!=null){
    $this->db->where('MONTH(`tab_realisasi_bmodal_det`.`real_bulan`) <=', $kdbln);
  }else{
    $this->db->where('MONTH(`tab_realisasi_bmodal_det`.`real_bulan`)', $kdbln);
  }

  $this->db->where('YEAR(`tab_realisasi_bmodal_det`.`real_bulan`)', $thn);
  return $this->db->get()->row_array();
}
function realkeu_ppk($idtab,$thn,$kdbln){
// select tab_realisasi MONTH(`tab_realisasi_bmodal`.`real_bulan`)

  $this->db->select('bobot_real,SUM(`tab_realisasi_det`.`jumlah_harga`) AS nilai');
  $this->db->from('`tab_realisasi_det`');
  $this->db->join('tab_realisasi', '`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`');
  $this->db->where('tab_realisasi.id_tabpptk', $idtab);

  $this->db->where('MONTH(`tab_realisasi`.`real_bulan`)', $kdbln);
  $this->db->where('YEAR(`tab_realisasi`.`real_bulan`)', $thn);
  return $this->db->get()->row_array();
}
function realkeu_ppk_bmodal($idtab,$thn,$kdbln){
// select tab_realisasi MONTH(`tab_realisasi_bmodal`.`real_bulan`)
  $this->db->select('SUM(`tab_realisasi_bmodal_det`.`real_keuangan`) AS nilai');
  $this->db->from('`tab_realisasi_bmodal_det`');
  $this->db->join('tab_realisasi_bmodal', '`tab_realisasi_bmodal_det`.`id_tab_real_bmodal` = `tab_realisasi_bmodal`.`id`');
  $this->db->where('tab_realisasi_bmodal.id_tab_pptk', $idtab);
  $this->db->where('MONTH(`tab_realisasi_bmodal_det`.`real_bulan`)', $kdbln);
  $this->db->where('YEAR(`tab_realisasi_bmodal_det`.`real_bulan`)', $thn);
  return $this->db->get()->row_array();
}
function tarfis_ppk($idtabpptk){
  $this->db->select('*');
  $this->db->from('tab_schedule');
  $this->db->join('tab_kak', '`tab_schedule`.`id_tab_kak` = `tab_kak`.`id`');
  $this->db->where('`tab_kak`.`idtab_pptk`', $idtabpptk);

  return $this->db->get()->result_array();
}
 function getdetlistkegiatan_ppk($nip,$thn){

    $this->db->select('
    `mkegiatan`.`kdkegunit` as kdkegunit
    ,`mkegiatan`.`nmkegunit` as nmkegunit
    , `tab_pptk`.`nilai`
    , `tab_pptk`.`id`
    , `tab_pptk`.`status`
    , u2.nama idpnspptk
    , u1.nama idpnsppk');
      $this->db->from('tab_pptk');
      $this->db->join('tab_pns u1', 'tab_pptk.idpnsppk = u1.nip');
      $this->db->join('tab_pns u2', 'tab_pptk.idpnspptk = u2.nip');
      $this->db->join('tab_pptk_master', 'tab_pptk.id_pptk_master = tab_pptk_master.id');
      $this->db->join('daftunit', 'tab_pptk_master.unitkey = daftunit.unitkey');
      $this->db->join('mkegiatan', 'tab_pptk.kdkegunit = mkegiatan.kdkegunit');
      $this->db->where('tab_pptk_master.tahun', $thn);
      $this->db->where('daftunit.tahun', $thn);
      $this->db->where('mkegiatan.tahun', $thn);
      $this->db->where('tab_pptk.idpnsppk', $nip);

      return $this->db->get()->result_array();
    }
function getdetlistkegiatan_detppk($nip,$kdkegunit,$thn){

     $this->db->select('
      `mpgrm`.`NMPRGRM` as prog
    ,`mkegiatan`.`kdkegunit` as kdkeg
    ,`mkegiatan`.`nmkegunit` as keg
    ,`tab_pptk`.`nilai` as nl
    , u2.nama pptk
    , u1.nama ppk');
      $this->db->from('tab_pptk');
      $this->db->join('tab_pns u1', 'tab_pptk.idpnsppk = u1.nip');
      $this->db->join('tab_pns u2', 'tab_pptk.idpnspptk = u2.nip');
      $this->db->join('tab_pptk_master', 'tab_pptk.id_pptk_master = tab_pptk_master.id');
      $this->db->join('daftunit', 'tab_pptk_master.unitkey = daftunit.unitkey');
      $this->db->join('mkegiatan', 'tab_pptk.kdkegunit = mkegiatan.kdkegunit');
      $this->db->join('mpgrm', 'mkegiatan.idprgrm = mpgrm.IDPRGRM');
      $this->db->where('tab_pptk_master.tahun', $thn);
      $this->db->where('daftunit.tahun', $thn);
      $this->db->where('mkegiatan.tahun', $thn);
      $this->db->where('mpgrm.tahun', $thn);
      $this->db->where('tab_pptk.idpnsppk', $nip);
      $this->db->where('tab_pptk.kdkegunit', $kdkegunit);
      return $this->db->get()->row();
    }

 function updraft($data,$idtab)
    {
        $this->db->where('idtab_pptk', $idtab);
        $this->db->update('tab_kak', $data);
        return TRUE;
    }
    function pagupptk($thnsekarang,$blnsekarang,$idopd,$arrkdkegunit){
  //     SELECT
  //     SUM(`angkas`.`nilai`) AS `pagu_tahun`
  // FROM angkas WHERE `unitkey`='80_' AND `kdkegunit`!='0_' AND `kdkegunit`IN('11142_','11_','12_','13_','15_','17_','1841_','18_','19_','1_','29_','2_','36_','40_','51_','64_','6_','7_','8_') AND `kd_bulan`>='1' AND `kd_bulan`<='12'
    $nilai = array();
    $this->db->select('
    SUM(`angkas`.`nilai`) AS `tahun`');
    $this->db->from('angkas');
    $this->db->where('tahun', $thnsekarang);
    $this->db->where('unitkey', $idopd);
    $this->db->where('kdkegunit!=', '0_');
    $this->db->where_in('kdkegunit', $arrkdkegunit);
    $tahun = $this->db->get()->row_array();

    $this->db->select('
    SUM(`angkas`.`nilai`) AS `blnskr`');
    $this->db->from('angkas');
    $this->db->where('tahun', $thnsekarang);
    $this->db->where('unitkey', $idopd);
    $this->db->where('kd_bulan', $blnsekarang);
    $this->db->where('kdkegunit!=', '0_');
    $this->db->where_in('kdkegunit', $arrkdkegunit);
    $blnskr = $this->db->get()->row_array();

    $this->db->select('
    SUM(`angkas`.`nilai`) AS `blnsdskr`');
    $this->db->from('angkas');
    $this->db->where('tahun', $thnsekarang);
    $this->db->where('unitkey', $idopd);
    $this->db->where('kd_bulan <=', $blnsekarang);
    $this->db->where('kdkegunit!=', '0_');
    $this->db->where_in('kdkegunit', $arrkdkegunit);
    $blnsdskr = $this->db->get()->row_array();

    $nilai[]=array(
      'tahun' => $tahun['tahun'],
      'blnskr'=> $blnskr['blnskr'],
      'blnsdskr'=>$blnsdskr['blnsdskr']
              );

    return $nilai;

    }
//akhir ppk
//-------------------------------------------------------------------------------------------------//










//!ryh


// function daftarkegiatan($idp){

//         $this->db->select('tab_pptk.id,tab_pptk.idpnspptk,mkegiatan.kdkegunit,mkegiatan.nmkegunit as namakeg,tab_pptk.nilai');
//         $this->db->from('tab_pptk');
//         $this->db->join('mkegiatan', 'tab_pptk.kdkegunit = mkegiatan.kdkegunit');
//         $this->db->where('tab_pptk.idpnspptk', $idp);
//         $this->db->where('status', 1);

//         return $this->db->get()->result_array();
//   }


// function getnamakeg($unitkey)
//     {
//         $query = $this->db->select("*")->from("mkegiatan")->where('kdkegunit',$unitkey)->get();
//         $data = $query->result_array();
//     return $data[0];
//     }

//  function getdetail($id)
//     {
//         $this->db->where('id', $id)->where('status', 1);

//         return $this->db->get('v_pptk')->row();
//     }
// function getnamapns($id){
//       $this->db->select("nama")->where('id', $id);
//      return $this->db->get('v_namappk')->row();
//     }

   //akhirpptk
	//Kasubag ryh
	function listkegiatan($idunit,$thn){
		$this->db->select('dpa22.unitkey,mkegiatan.kdkegunit,mkegiatan.nmkegunit as namakeg,SUM(dpa22.nilai) as nilai');
      	$this->db->from('dpa22');
      	$this->db->join('mkegiatan', 'dpa22.kdkegunit = mkegiatan.kdkegunit');
      	$this->db->join('daftunit', 'dpa22.unitkey = daftunit.unitkey');
        $this->db->where('daftunit.tahun', $thn);
        $this->db->where('mkegiatan.tahun', $thn);
        $this->db->where('dpa22.tahun', $thn);
      	$this->db->where('dpa22.unitkey', $idunit);
      	$this->db->group_by('dpa22.kdkegunit');
        $this->db->order_by('dpa22.kdkegunit');
      	return $this->db->get()->result();
	}
	function listpptk($idunit){
		/*peran=3 untuk pptk*/
		$this->db->select('tab_pns.nip,tab_pns.nama');
      	$this->db->from('tab_struktur');
      	$this->db->join('tab_pns', 'tab_struktur.nip = tab_pns.nip');
      	$this->db->where('tab_struktur.peran', '3');
      	$this->db->where('tab_struktur.id_unit', $idunit);
      	return $this->db->get()->result();

	}

  function listppk($idunit){

		/*peran=2 untuk ppk*/
		$this->db->select('tab_pns.nip,tab_pns.nama');
      	$this->db->from('tab_struktur');
      	$this->db->join('tab_pns', 'tab_struktur.nip = tab_pns.nip');
      	$this->db->where('tab_struktur.id_unit', $idunit);
        $this->db->where('tab_struktur.peran', '2');
        $this->db->or_where('tab_struktur.peran', '6');

      	return $this->db->get()->result();
	}



  function simpanentrikegiatan($master){

    $this->db->trans_start();
    $this->db->insert('tab_pptk_master', $master);
    $id_master = $this->db->insert_id();
    $kdkegunit      = $this->input->post('nmkdkeg');
    $nilai          = $this->input->post('nilai');
    $idpnspptk      = $this->input->post('nmpptk');
    $idpnsppk       = $this->input->post('nmppk');
    $nmfile         = $this->input->post('namadokumen');


    $list=array();
      for($i=0; $i < count ($kdkegunit); $i++){
        $list[$i]=array(
          'id_pptk_master'=> $id_master,
          'kdkegunit'     => $kdkegunit[$i],
          'nilai'         => $nilai[$i],
          'idpnspptk'     => $idpnspptk[$i],
          'idpnsppk'      => $idpnsppk[$i]
        );
      }

    $this->db->insert_batch('tab_pptk', $list);

    $file = "file_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
    $config['upload_path'] = './assets/dokumen/'; //path folder iko
    $config['allowed_types'] = 'pdf|doc|docx|xlsx|xls'; //type yang dapat diakses ikobisa anda sesuaikan
    $config['max_size'] = '3072'; //maksimum besar file 3M
    // $config['max_width']  = '5000'; //lebar maksimum 5000 px
    // $config['max_height']  = '5000'; //tinggi maksimu 5000 px
    $config['file_name'] = $file; //nama yang terupload nantinya smpai iko
    $files = $_FILES;
    $listdokumen=array();
    for($i=0; $i < count ($nmfile); $i++){
      $_FILES['userfile']['name']= $files['userfile']['name'][$i];
      $_FILES['userfile']['type']= $files['userfile']['type'][$i];
      $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
      $_FILES['userfile']['error']= $files['userfile']['error'][$i];
      $_FILES['userfile']['size']= $files['userfile']['size'][$i];
      $this->upload->initialize($config);
      //$this->upload->do_upload();
          if ( !$this->upload->do_upload()){
              $namo_dokumen = 'no-image.png';
          }else{
              $fileData = $this->upload->data();
              $namo_dokumen = $fileData['file_name'];
          }
          $listdokumen[$i]=array(
            'id_pptk_master'  => $id_master,
            'nama_dokumen'    => $nmfile[$i],
            'file_path'    => $namo_dokumen,
          );


    }
  $this->db->insert_batch('tab_upload_sk', $listdokumen);
    $this->db->trans_complete();
        if ($this->db->affected_rows() == '1') {
        return TRUE;
        }
        else {
            // trans error?
            if ($this->db->trans_status() === FALSE) {
                return 0;
            }
                return 1;
        }
  }

  function get_eska_master($opd,$tahun){
//  = function getppkmaster di Cpanel_model
    $this->db->select('`daftunit`.`nmunit`
    , `tab_pptk_master`.`id`
    , `tab_pptk_master`.`tahun`
    , `tab_pns`.`nip`
    , `tab_pns`.`nama`
    , `tab_pptk_master`.`tgl_entri`
    , `tab_pptk_master`.`stat`');
    $this->db->from('tab_pptk_master');
    $this->db->join('daftunit', '`tab_pptk_master`.`unitkey` = `daftunit`.`unitkey`');
    $this->db->join('tab_pns', '`tab_pptk_master`.`admin_entri` = `tab_pns`.`nip`');
    $this->db->where('`tab_pptk_master`.`unitkey`', $opd);
    $this->db->where('`tab_pptk_master`.`tahun`', $tahun);
    return $this->db->get();

  }
  function get_eska_detail($id,$tahun){
//  = function getppkmaster di Cpanel_model

    $this->datatables->select('`tab_pptk`.`id` as id
    ,`mkegiatan`.`kdkegunit` as kdkegunit
    ,`mkegiatan`.`nmkegunit` as nmkegunit
    , u2.nama as idpnspptk
    , u1.nama as idpnsppk
    ,`tab_pptk`.`status` as status ');
    $this->datatables->from('`tab_pptk`');
    $this->datatables->join('tab_pns u1', 'tab_pptk.idpnsppk = u1.nip');
    $this->datatables->join('tab_pns u2', 'tab_pptk.idpnspptk = u2.nip');
    $this->datatables->join('tab_pptk_master', 'tab_pptk.id_pptk_master = tab_pptk_master.id');
    $this->datatables->join('mkegiatan', 'tab_pptk.kdkegunit = mkegiatan.kdkegunit');
    $this->datatables->where('tab_pptk.id_pptk_master', $id);
    $this->datatables->where('tab_pptk_master.tahun', $tahun);
    $this->datatables->add_column('action', '<button class="edit-sk btn bg-orange margin">Ubah<div class="ripple-container"></div></button>' );
    return $this->datatables->generate();


    // $this->db->select('`tab_pptk`.`id`
    // ,`mkegiatan`.`kdkegunit`
    // ,`mkegiatan`.`nmkegunit`
    // ,`tab_pptk`.`status`
    // , u2.nama idpnspptk
    // , u1.nama idpnsppk');
    //
    // $this->db->from('tab_pptk');
    // $this->db->join('tab_pns u1', 'tab_pptk.idpnsppk = u1.nip');
    // $this->db->join('tab_pns u2', 'tab_pptk.idpnspptk = u2.nip');
    // $this->db->join('tab_pptk_master', 'tab_pptk.id_pptk_master = tab_pptk_master.id');
    // $this->db->join('mkegiatan', 'tab_pptk.kdkegunit = mkegiatan.kdkegunit');
    // $this->db->where('tab_pptk.id_pptk_master', $id);
    // $this->db->where('tab_pptk_master.tahun', $tahun);
    // return $this->db->get()->result_array();

  }
  function get_eska_detail_keg($id,$tahun,$idkeg){

//  = function getppkmaster di Cpanel_model

    $this->db->select('`tab_pptk`.`id`
    ,`mkegiatan`.`kdkegunit`
    ,`mkegiatan`.`nmkegunit`
    ,`tab_pptk`.`status`
    , u2.nip nippptk
    , u2.nama idpnspptk
    , u1.nip nipppk
    , u1.nama idpnsppk');

    $this->db->from('tab_pptk');
    $this->db->join('tab_pns u1', 'tab_pptk.idpnsppk = u1.nip');
    $this->db->join('tab_pns u2', 'tab_pptk.idpnspptk = u2.nip');
    $this->db->join('tab_pptk_master', 'tab_pptk.id_pptk_master = tab_pptk_master.id');
    $this->db->join('mkegiatan', 'tab_pptk.kdkegunit = mkegiatan.kdkegunit');
    $this->db->where('tab_pptk.id_pptk_master', $id);
    $this->db->where('tab_pptk_master.tahun', $tahun);
    $this->db->where('tab_pptk.kdkegunit', $idkeg);
    return $this->db->get()->row_array();

  }
  function get_eska_dokumen($id_m){
    $this->db->where('id_pptk_master', $id_m);
    $this->db->order_by('id','DESC');
    $this->db->limit(1);
    return $this->db->get('tab_upload_sk')->row();
  }

  function update_eska_kpapptk($id,$data)
  {
      $this->db->where('id', $id);
      $upeska = $this->db->update('tab_pptk', $data);
      if($upeska)
        return true;
      else
        return false;
  }

  function update_dokumen_eska($dt,$idm)
  {
    $this->db->trans_start();
    $this->db->insert('tab_upload_sk', $dt);
    $data=array(
                'stat_ubah'    => 1
            );
    $this->db->where('id', $idm);
    $upeska = $this->db->update('tab_pptk_master', $data);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE){
      $this->db->trans_rollback();
      return false;
    }else{
      $this->db->trans_commit();

      return true;
    }

  }

  //end kasubag


//untuk laporan tcpdf
   function getnamappk($idtabpptk){
     $this->db->select('`tab_kak`.*
                         , `tab_kak`.`id` AS id
                         , `tab_pptk`.`idpnsppk` AS idppk
             , `tab_pns`.`nama` AS nama
                        ');
      $this->db->from('tab_pptk');
      $this->db->join('tab_kak', '`tab_pptk`.`id` = `tab_kak`.`idtab_pptk`');
      $this->db->join('`tab_pns`', '`tab_pptk`.`idpnsppk` = `tab_pns`.`nip`');
      $this->db->where('`tab_kak`.`idtab_pptk`', $idtabpptk);
      return $this->db->get()->row();
    }

//// endddddd




function simpanentrikak($masterkak){
    $this->db->trans_start();
    $this->db->insert('tab_kak', $masterkak);
    $id_master = $this->db->insert_id();
    $sc = $this->input->post('tms');
    $list=array();
     for($i=0; $i < count ($sc); $i++){
       $januari='';
       if(array_key_exists('0', $sc[$i])){
         $jan= count($sc[$i]['0']);
         for($x=0; $x < $jan ; $x++){
          $januari.=$sc[$i]['0'][$x];
        }
      }

      $februari='';
      if(array_key_exists('1', $sc[$i])){
       $feb= count($sc[$i]['1']);
       for($x=0; $x < $feb ; $x++){
        $februari.=$sc[$i]['1'][$x];
       }
      }

    $maret='';
    if(array_key_exists('2', $sc[$i])){
     $mar= count($sc[$i]['2']);
     for($x=0; $x < $mar ; $x++){
      $maret.=$sc[$i]['2'][$x];
      }
    }

    $april='';
    if(array_key_exists('3', $sc[$i])){
     $apr= count($sc[$i]['3']);
     for($x=0; $x < $apr ; $x++){
      $april.=$sc[$i]['3'][$x];
      }
    }

    $may='';
    if(array_key_exists('4', $sc[$i])){
     $mei= count($sc[$i]['4']);
     for($x=0; $x < $mei ; $x++){
      $may.=$sc[$i]['4'][$x];
      }
    }

    $juni='';
    if(array_key_exists('5', $sc[$i])){
     $jun= count($sc[$i]['5']);
     for($x=0; $x < $jun ; $x++){
      $juni.=$sc[$i]['5'][$x];
      }
    }

    $juli='';
    if(array_key_exists('6', $sc[$i])){
     $jul= count($sc[$i]['6']);
     for($x=0; $x < $jul ; $x++){
      $juli.=$sc[$i]['6'][$x];
      }
    }

    $agustus='';
    if(array_key_exists('7', $sc[$i])){
     $ags= count($sc[$i]['7']);
     for($x=0; $x < $ags ; $x++){
      $agustus.=$sc[$i]['7'][$x];
      }
    }

    $september='';
    if(array_key_exists('8', $sc[$i])){
     $sep= count($sc[$i]['8']);
     for($x=0; $x < $sep ; $x++){
      $september.=$sc[$i]['8'][$x];
      }
    }

    $oktober='';
    if(array_key_exists('9', $sc[$i])){
     $okt= count($sc[$i]['9']);
     for($x=0; $x < $okt ; $x++){
      $oktober.=$sc[$i]['9'][$x];
      }
    }

    $november='';
    if(array_key_exists('10', $sc[$i])){
     $nov= count($sc[$i]['10']);
     for($x=0; $x < $nov ; $x++){
      $november.=$sc[$i]['10'][$x];
      }
    }

    $desember='';
    if(array_key_exists('11', $sc[$i])){
     $des= count($sc[$i]['11']);
     for($x=0; $x < $des ; $x++){
      $desember.=$sc[$i]['11'][$x];
      }
    }

      $list[$i]=array(
       'uraian_keg' => $sc[$i]['uraian']['0'],
       'id_tab_kak' => $id_master,
       'jan'      => $januari,
       'feb'      => $februari,
       'mar'      => $maret,
       'apr'      => $april,
       'mei'      => $may,
       'jun'      => $juni,
       'jul'      => $juli,
       'ags'      => $agustus,
       'sep'      => $september,
       'okt'      => $oktober,
       'nov'      => $november,
       'des'      => $desember
      );
  }

    $this->db->insert_batch('tab_schedule', $list);
    $this->db->trans_complete();
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        else {
            // trans error?
            if ($this->db->trans_status() === FALSE) {
                return 0;
            }
                return 1;
        }
  }
  function simpantargetfisik($data, $detail){
    $this->db->trans_start();
    $this->db->insert('tab_target_blnj_modal', $data);
    $id_master = $this->db->insert_id();
    $detail["id_tab_target"] = $id_master;
    $this->db->insert('tab_schedule_blnj_mdl', $detail);
    $this->db->trans_complete();
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        else {
            // trans error?
            if ($this->db->trans_status() === FALSE) {
                return 0;
            }
                return 1;
        }
  }
    function cekblnjamodal($unitkey,$idkeg,$thn){

        $this->db->select('`angkas`.`kdkegunit`
        , `matangr`.`mtgkey`
        , `matangr`.`kdper`
        , `matangr`.`nmper`');
        $this->db->from('angkas');
        $this->db->join('matangr', '`angkas`.`mtgkey` = `matangr`.`mtgkey`');
        $this->db->where('`angkas`.`unitkey`', $unitkey);
        $this->db->where('`angkas`.`kdkegunit`', $idkeg);
        $this->db->where('`angkas`.`tahun`', $thn);
        $this->db->where('`matangr`.`tahun`', $thn);
        $this->db->like('`matangr`.`kdper`', '5.2.3.', 'both');
        $this->db->group_by('`matangr`.`mtgkey`');
        return $this->db->get();
    }

    function getnama_metode(){
      return $this->db->get('tab_metode_pelaksanaan')->result();
    }

    function jsonlistbmodal($unit,$kegiatan,$thn){
      $this->datatables->select('`angkas`.`kdkegunit` as kdkegunit
        , `matangr`.`mtgkey` as mtgkey
        , `matangr`.`kdper` as kdper
        , `matangr`.`nmper` as nmper
        , (`tab_target_blnj_modal`.`idtab_pptk` IS NOT NULL) AS ada');
      $this->datatables->from('`angkas`');
      $this->datatables->join('`matangr`', '`angkas`.`mtgkey` = `matangr`.`mtgkey`');
      $this->datatables->join('`tab_target_blnj_modal`', '`tab_target_blnj_modal`.`mtgkey` = `matangr`.`mtgkey`','LEFT');
      $this->datatables->where('`angkas`.`unitkey`', $unit);
      $this->datatables->where('`angkas`.`kdkegunit`', $kegiatan);
      $this->datatables->where('`angkas`.`tahun`', $thn);
      $this->datatables->where('`matangr`.`tahun`', $thn);
      // $this->datatables->where('`tab_target_blnj_modal`.`tahun`', $thn);
      $this->datatables->like('`matangr`.`kdper`', '5.2.3.', 'both');
      $this->datatables->group_by('`matangr`.`mtgkey`');

        return $this->datatables->generate();
    }
     function cektargetfisik($unit,$kegiatan){
      $this->db->select('`angkas`.`kdkegunit` as kdkegunit
        , `matangr`.`mtgkey` as mtgkey
        , `matangr`.`kdper` as kdper
        , `matangr`.`nmper` as nmper
        , (`tab_target_blnj_modal`.`idtab_pptk` IS NOT NULL) AS ada');
      $this->db->from('`angkas`');
      $this->db->join('`matangr`', '`angkas`.`mtgkey` = `matangr`.`mtgkey`');
      $this->db->join('`tab_target_blnj_modal`', '`tab_target_blnj_modal`.`mtgkey` = `matangr`.`mtgkey`','LEFT');
      $this->db->where('`angkas`.`unitkey`', $unit);
      $this->db->where('`angkas`.`kdkegunit`', $kegiatan);

      $this->db->like('`matangr`.`kdper`', '5.2.3.', 'both');
      $this->db->group_by('`matangr`.`mtgkey`');
      // $this->datatables->add_column('action', '<button class="opduserpass btn btn-danger">Password<div class="ripple-container"></div></button> <button class="opduserinfo btn btn-info">Info<div class="ripple-container"></div></button>' );
       return $this->db->get()->result();
    }
    // function jsonlistbmodal($unit,$kegiatan){
    //   $this->datatables->select('kdkegunit,mtgkey,kdper,nmper,ada');
    //   $this->datatables->where('`unitkey`', $unit);
    //   $this->datatables->where('`kdkegunit`', $kegiatan);
    //   $this->datatables->from('v_belanja_modal');
    //   $this->datatables->add_column('action', '<button class="opduserpass btn btn-danger">Password<div class="ripple-container"></div></button> <button class="opduserinfo btn btn-info">Info<div class="ripple-container"></div></button>' );
    //     return $this->datatables->generate();
    // }

    //<--query untuk mendapatkan unitkey ppk
    function getunitkeyppk($nip)
    {
        $this->db->select('unitkey');
        $this->db->where('nip',$nip);
        $this->db->from('tab_pns');
        $result = $this->db->get()->row();
        return $result->unitkey;
    }
    //end query untuk mendapatkan unitkey ppk-->

    //<--query untuk mendapatkan id struktur ppk
    function getidstrukturppk($nip)
    {
        $this->db->select('id');
        $this->db->where('nip',$nip);
        $this->db->from('tab_struktur');
        $result = $this->db->get()->row();
        return $result->id;
    }
    //end query untuk mendapatkan id struktur ppk-->

    //<--query untuk mendapatkan id struktur ppk
    function getidparent($idstrukturppk)
    {
        $this->db->select('parent');
        $this->db->where('id',$idstrukturppk);
        $this->db->from('tab_struktur');
        $result = $this->db->get()->row();
        return $result->parent;
    }
    //end query untuk mendapatkan id struktur ppk-->

    //<--query untuk mendapatkan nip struktur pptk
    function getnipstrukturpptk($parent)
    {
        $query = 'SELECT
        `tab_pns`.`nip`
        , `tab_pns`.`nama`
        FROM
        `tab_struktur`
        INNER JOIN `tab_pns`
            ON (`tab_struktur`.`nip` = `tab_pns`.`nip`) WHERE `tab_struktur`.`parent`='.$parent;
        $result = $this->db->query($query)->result_array();
        return $result;
    }
    //agung
    function getnippptkopd($unitkey)
    {
        $query = 'SELECT
        `tab_pns`.`nip`
         , pns2.`nama` AS nama_kpa
        , `tab_pns`.`nama` AS nama_pptk

        FROM
        `tab_struktur`
        INNER JOIN `tab_pns`
            ON (`tab_struktur`.`nip` = `tab_pns`.`nip`)
      	INNER JOIN `tab_struktur` ts2
      	ON (ts2.`id` = `tab_struktur`.`parent`)
      	INNER JOIN `tab_pns` pns2
      	ON (ts2.`nip` = `pns2`.`nip`)
             WHERE `tab_struktur`.`peran`= 3 AND `tab_struktur`.`id_unit` = "'.$unitkey.'"';
        $result = $this->db->query($query)->result_array();
        return $result;
    }
    //end agung
    //end query untuk mendapatkan nip struktur ppk-->

    //<--query untuk mendapatkan data dpa221, tab_pptk, matangr, mkegiatan ppk
    function getdatappk($unitkey,$nipppk)
    {
        $query = 'SELECT
    `tab_pptk`.`idpnsppk`
    , `tab_pptk`.`idpnspptk`
    , `mkegiatan`.`kdkegunit`
    , `mkegiatan`.`nmkegunit`
    , `matangr`.`mtgkey`
    , `matangr`.`nmper`
    , `dpa221`.`id` AS `dpa221_id`
    , `dpa221`.`satuan`
    , `dpa221`.`jumbyek`
    , `dpa221`.`uraian`
    , `dpa221`.`tarif`
    , `angkas`.`id` AS `angkas_id`
    , `angkas`.`kd_bulan`
    , `angkas`.`nilai`
    , `angkas`.`tahun`
FROM
    `dpa221`
    INNER JOIN `matangr`
        ON (`dpa221`.`mtgkey` = `matangr`.`mtgkey`)
    INNER JOIN `mkegiatan`
        ON (`dpa221`.`kdkegunit` = `mkegiatan`.`kdkegunit`)
    INNER JOIN `angkas`
        ON (`matangr`.`mtgkey` = `angkas`.`mtgkey`)
    INNER JOIN `tab_pptk`
        ON (`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`) AND (`angkas`.`kdkegunit` = `mkegiatan`.`kdkegunit`) WHERE `dpa221`.`unitkey` ="'.$unitkey.'" AND `tab_pptk`.`idpnsppk`="'.$nipppk.'" AND `angkas`.`tahun`=YEAR(NOW())';
        return $this->db->query($query)->result_array();
    }
    //end query untuk mendapatkan data dpa221, tab_pptk, matangr, mkegiatan ppk-->

    //<--query untuk mendapatkan data pagu tahun
    function getpagutahun($nipppk,$unitkey)
    {

        $query = 'SELECT
    SUM(`angkas`.`nilai`) AS `pagu_tahun`
FROM
    `tab_pptk`
    INNER JOIN `angkas`
        ON (`tab_pptk`.`kdkegunit` = `angkas`.`kdkegunit`) WHERE `tab_pptk`.`idpnsppk`='.$nipppk.' AND `angkas`.`tahun` = YEAR(NOW()) AND `angkas`.`unitkey`="'.$unitkey.'"';

        return $this->db->query($query)->row()->pagu_tahun;
    }
    //end query untuk mendapatkan data pagu tahun-->

    //<--query untuk mendapatkan data angkas hingga bulan ini
    function getangkashinggabulanini($nipppk,$unitkey)
    {

        $query = 'SELECT
    SUM(`angkas`.`nilai`) AS `angkas_bulan`
FROM
    `tab_pptk`
    INNER JOIN `angkas`
        ON (`tab_pptk`.`kdkegunit` = `angkas`.`kdkegunit`) WHERE `tab_pptk`.`idpnsppk`='.$nipppk.' AND `angkas`.`kd_bulan` <= MONTH(NOW()) AND `angkas`.`tahun` = YEAR(NOW()) AND `angkas`.`unitkey`="'.$unitkey.'"';


        return $this->db->query($query)->row()->angkas_bulan;
    }
    //end query untuk mendapatkan data angkas hingga bulan ini-->
    //<--query untuk mendapatkan data angkas hingga bulan ini satu opd agung
    function getangkasopdhinggabulanini($unitkey)
    {
      $this->db->select('SUM(nilai)AS angkas_bulan');
      $this->db->from('angkas');
      $this->db->where('`angkas`.`kdkegunit` !=', '0_');
       $this->db->where('`angkas`.`unitkey`', $unitkey);
       $this->db->where('`angkas`.`kd_bulan` <= MONTH(NOW())');
       $this->db->where('`angkas`.`tahun` = YEAR(NOW())');

        return $this->db->get()->row()->angkas_bulan;
    }
    //end query untuk mendapatkan data angkas hingga bulan ini satu opdd-->

    //<--query untuk mendapatkan data angkas bulan ini
    function getangkasbulanini($nipppk,$unitkey)
    {

        $query = 'SELECT
    SUM(`angkas`.`nilai`) AS `angkas_bulan`
FROM
    `tab_pptk`
    INNER JOIN `angkas`
        ON (`tab_pptk`.`kdkegunit` = `angkas`.`kdkegunit`) WHERE `tab_pptk`.`idpnsppk`='.$nipppk.' AND `angkas`.`kd_bulan` = MONTH(NOW()) AND `angkas`.`tahun` = YEAR(NOW()) AND `angkas`.`unitkey`="'.$unitkey.'"';
        return $this->db->query($query)->row()->angkas_bulan;
    }
    //agung
    function getangkasOPDbulanini($unitkey)
    {

        $query = 'SELECT
    SUM(`angkas`.`nilai`) AS `angkas_bulan`
FROM
    `angkas`
         WHERE `angkas`.`unitkey`="'.$unitkey.'" AND `angkas`.`kdkegunit`!="0_" AND `angkas`.`kd_bulan` = MONTH(NOW()) AND `angkas`.`tahun` = YEAR(NOW())';

        return $this->db->query($query)->row()->angkas_bulan;
    }
    //sampaiagung
    //end query untuk mendapatkan data angkas bulan ini-->

    //<--query untuk mendapatkan detail data angkas bulan ini
    function getdetangkasbulanini($nipppk,$unitkey)
    {
        $query = 'SELECT
    `angkas`.`nilai`,
    `angkas`.`kdkegunit`
FROM
    `tab_pptk`
    INNER JOIN `angkas`
        ON (`tab_pptk`.`kdkegunit` = `angkas`.`kdkegunit`) WHERE `tab_pptk`.`idpnsppk`='.$nipppk.' AND `angkas`.`kd_bulan` = MONTH(NOW()) AND `angkas`.`tahun` = YEAR(NOW()) AND `angkas`.`unitkey`="'.$unitkey.'"';
        return $this->db->query($query)->result_array();
    }
    //agung
    function getdetangkasOPDbulanini($unitkey)
    {
        $query = 'SELECT
    `angkas`.`nilai`,
    `angkas`.`kdkegunit`
FROM
    `angkas`
      WHERE `angkas`.`unitkey`="'.$unitkey.'" AND `angkas`.`kdkegunit`!="0_" AND `angkas`.`kd_bulan` = MONTH(NOW()) AND `angkas`.`tahun` = YEAR(NOW())';
        return $this->db->query($query)->result_array();
    }
    //end agung
    //end query untuk mendapatkan detail data angkas bulan ini-->

    //<--query untuk mendapatkan data realisasi bulan ini
    function getrealisasibulanini($idppk)
    {
        $query = 'SELECT
    SUM(`tab_realisasi_det`.`jumlah_harga`) AS `realisasi`
FROM
    `tab_realisasi_det`
    INNER JOIN `tab_realisasi`
        ON (`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`)
    INNER JOIN `tab_struktur`
        ON (`tab_struktur`.`nip` = `tab_realisasi`.`admin_entri`) WHERE `tab_struktur`.`parent`='.$idppk.' AND MONTH(`tab_realisasi`.`real_bulan`)=MONTH(NOW()) AND YEAR(`tab_realisasi`.`real_bulan`)=YEAR(NOW())';
        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->row()->realisasi;
        }else{
            return 0;
        }
    }
    //end query untuk mendapatkan data realisasi bulan ini-->

    //<--query untuk mendapatkan detail realisasi belanja modal bulan ini
    function getdetrealbmodalbi($idstrukturppk,$unitkey)
    {
        $query = 'SELECT
    `tab_realisasi_bmodal`.`nilai_ktrk`
    , `dpa221`.`mtgkey`
    , `dpa221`.`kdkegunit`
FROM
    `tab_realisasi_bmodal`
    INNER JOIN `tab_struktur`
        ON (`tab_realisasi_bmodal`.`admin_entri` = `tab_struktur`.`nip`)
    INNER JOIN `dpa221`
        ON (`dpa221`.`mtgkey` = `tab_realisasi_bmodal`.`mtgkey`)
        WHERE `tab_struktur`.`parent`='.$idstrukturppk.' AND `dpa221`.`unitkey`="'.$unitkey.'" AND MONTH(`tab_realisasi_bmodal`.`real_bulan`)=MONTH(NOW()) AND YEAR(`tab_realisasi_bmodal`.`real_bulan`)=YEAR(NOW());';
        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }
    //end query untuk mendapatkan detail realisasi belanja modal bulan ini-->
    //<--query untuk mendapatkan detail realisasi belanja modal bulan ini
    function getdetrealbmodalbiOPD($idstrukturppk,$unitkey)
    {
        $query = 'SELECT
    `tab_realisasi_bmodal`.`nilai_ktrk`
    , `dpa221`.`mtgkey`
    , `dpa221`.`kdkegunit`
    FROM
    `tab_realisasi_bmodal`
    INNER JOIN `tab_struktur`
        ON (`tab_realisasi_bmodal`.`admin_entri` = `tab_struktur`.`nip`)
    INNER JOIN `dpa221`
        ON (`dpa221`.`mtgkey` = `tab_realisasi_bmodal`.`mtgkey`)
        WHERE `tab_realisasi_bmodal`.`id_struktur`='.$idstrukturppk.' AND `dpa221`.`unitkey`="'.$unitkey.'" AND MONTH(`tab_realisasi_bmodal`.`real_bulan`)=MONTH(NOW()) AND YEAR(`tab_realisasi_bmodal`.`real_bulan`)=YEAR(NOW());';
        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }
    //end query untuk mendapatkan detail realisasi belanja modal bulan ini-->
    //<--query untuk mendapatkan data kegiatan pptk
    function getkegiatan($nipppk)
    {
        $query = 'SELECT
`mkegiatan`.`nmkegunit`,
`mkegiatan`.`kdkegunit`,
`tab_pptk`.`idpnspptk`
FROM
`tab_pptk`
INNER JOIN `mkegiatan`
ON (`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`) WHERE `tab_pptk`.`idpnsppk`='.$nipppk.' AND `mkegiatan`.`tahun`=YEAR(NOW())';
        return $this->db->query($query)->result_array();
    }
    //end query untuk mendapatkan data kegiatan pptk-->
    //<--query untuk mendapatkan data semua kegiatan per opd : AgungAgungAgung
    function getallkegiatan($opd)
    {
        $query = "SELECT
        `mkegiatan`.`nmkegunit`,
        `mkegiatan`.`kdkegunit`,
        `tab_pptk`.`idpnspptk`
        FROM
        `tab_pptk`
        INNER JOIN `mkegiatan`
        ON (`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`)
        INNER JOIN `tab_pptk_master`
        ON (`tab_pptk`.`id_pptk_master` = `tab_pptk_master`.`id`)
        WHERE `tab_pptk_master`.`unitkey`='$opd'";
        // return $this->db->query($query)->result_array();
        return $this->db->query($query)->result_array();

    }
    //end query untuk mendapatkan data semua kegiatan per opd AgungAgungAgung-->
    //<--query untuk mendapatkan data realisasi bulan ini pptk
    function getdatarealisasi($nipppk)
    {
        $query = 'SELECT
    `tab_realisasi_det`.`jumlah_harga`
    , `mkegiatan`.`kdkegunit`
    , `mkegiatan`.`nmkegunit`
FROM
    `tab_realisasi_det`
    INNER JOIN `tab_realisasi`
        ON (`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`)
    INNER JOIN `dpa221`
        ON (`dpa221`.`id` = `tab_realisasi_det`.`id_dpa`)
    INNER JOIN `mkegiatan`
        ON (`mkegiatan`.`kdkegunit` = `dpa221`.`kdkegunit`)
    INNER JOIN `tab_pptk`
        ON (`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`) WHERE `tab_pptk`.`idpnsppk`='.$nipppk.' AND MONTH(`tab_realisasi`.`real_bulan`)=MONTH(NOW()) AND YEAR(`tab_realisasi`.`real_bulan`)=YEAR(NOW())';
        return $this->db->query($query)->result_array();
    }
    //end query untuk mendapatkan data realisasi bulan ini pptk-->
    //<--query untuk mendapatkan data realisasi bulan ini per idstruktur
    function getdatarealisasi_by($idstruktur)
    {
        $query = 'SELECT
    `tab_realisasi_det`.`jumlah_harga`
    , `mkegiatan`.`kdkegunit`
    , `mkegiatan`.`nmkegunit`
FROM
    `tab_realisasi_det`
    INNER JOIN `tab_realisasi`
        ON (`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`)
    INNER JOIN `dpa221`
        ON (`dpa221`.`id` = `tab_realisasi_det`.`id_dpa`)
    INNER JOIN `mkegiatan`
        ON (`mkegiatan`.`kdkegunit` = `dpa221`.`kdkegunit`)
    INNER JOIN `tab_pptk`
        ON (`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`) WHERE `tab_realisasi`.`id_struktur`='.$idstruktur.' AND MONTH(`tab_realisasi`.`real_bulan`) ="'.date('m').'"';
        return $this->db->query($query)->result_array();
    }
    //end query untuk mendapatkan data realisasi bulan ini pptk-->

    //<--query untuk mendapatkan data realisasi hingga bulan sebelumnya
    function getdatarealisasihbs($nipppk)
    {
        $query = 'SELECT
    `tab_realisasi_det`.`jumlah_harga`
    , `mkegiatan`.`kdkegunit`
    , `mkegiatan`.`nmkegunit`
FROM
    `tab_realisasi_det`
    INNER JOIN `tab_realisasi`
        ON (`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`)
    INNER JOIN `dpa221`
        ON (`dpa221`.`id` = `tab_realisasi_det`.`id_dpa`)
    INNER JOIN `mkegiatan`
        ON (`mkegiatan`.`kdkegunit` = `dpa221`.`kdkegunit`)
    INNER JOIN `tab_pptk`
        ON (`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`) WHERE `tab_pptk`.`idpnsppk`='.$nipppk.' AND MONTH(`tab_realisasi`.`real_bulan`)<MONTH(NOW()) AND YEAR(`tab_realisasi`.`real_bulan`)=YEAR(NOW())';
        return $this->db->query($query)->result_array();
    }
    //Agung get data realisasi se opd
    function getdatarealisasiOPDhbs($id_struktur)
    {
        $query = 'SELECT
    `tab_realisasi_det`.`jumlah_harga`
    , `mkegiatan`.`kdkegunit`
    , `mkegiatan`.`nmkegunit`
FROM
    `tab_realisasi_det`
    INNER JOIN `tab_realisasi`
        ON (`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`)
    INNER JOIN `dpa221`
        ON (`dpa221`.`id` = `tab_realisasi_det`.`id_dpa`)
    INNER JOIN `mkegiatan`
        ON (`mkegiatan`.`kdkegunit` = `dpa221`.`kdkegunit`)
    WHERE `tab_realisasi`.`id_struktur`='.$id_struktur.' AND MONTH(`tab_realisasi`.`real_bulan`) <"'.date('m').'"';
        return $this->db->query($query)->result_array();
    }
    // End OF Agung get data realisasi se opd
    //end query untuk mendapatkan data realisasi hingga bulan sebelumnya-->

    //<--query untuk mendapatkan data realisasi hingga bulan ini
    function gettotalrealisasi($nipppk)
    {
        $query = 'SELECT
    SUM(`tab_realisasi_det`.`jumlah_harga`) as `total_realisasi`
FROM
    `tab_realisasi_det`
    INNER JOIN `tab_realisasi`
        ON (`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`)
    INNER JOIN `dpa221`
        ON (`dpa221`.`id` = `tab_realisasi_det`.`id_dpa`)
    INNER JOIN `mkegiatan`
        ON (`mkegiatan`.`kdkegunit` = `dpa221`.`kdkegunit`)
    INNER JOIN `tab_pptk`
        ON (`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`) WHERE `tab_pptk`.`idpnsppk`='.$nipppk.' AND MONTH(`tab_realisasi`.`real_bulan`)<MONTH(NOW()) AND YEAR(`tab_realisasi`.`real_bulan`)=YEAR(NOW())';

        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->row()->total_realisasi;
        }else{
            return 0;
        }
    }
    function gettotalrealisasiopd($unitkey,$idstruktur){
      $this->db->select("daftunit.`unitkey`
                      , `daftunit`.`nmunit`
                      , `tab_pptk_master`.id as idpptkmaster
                      , `tab_pptk_master`.*
                      ,sum(tab_realisasi_det.`jumlah_harga`) as realisasi_keu");
      $this->db->from('`tab_pptk_master`');
      $this->db->join('daftunit', '`tab_pptk_master`.`unitkey` = `daftunit`.`unitkey`');
      $this->db->join('tab_pptk', '`tab_pptk`.`id_pptk_master` = `tab_pptk_master`.`id`');
      $this->db->join('tab_realisasi', '`tab_realisasi`.`id_tabpptk` = `tab_pptk`.`id`');
      $this->db->join('tab_realisasi_det', '`tab_realisasi`.`id` = `tab_realisasi_det`.`id_tab_realisasi`');
      $this->db->where("daftunit.`unitkey`",$unitkey);
      $this->db->where("tab_realisasi.`id_struktur`",$idstruktur);
      $this->db->where("MONTH(tab_realisasi.`real_bulan`) = MONTH(NOW())");
      $real = $this->db->get();
      if($real->num_rows()!=0){
        return $real->row()->realisasi_keu;
      }else{
        return 0;
      }
    }
    function getrealisasi_bModal_opd($unitkey,$idstruktur){
      $this->db->select("
      daftunit.`unitkey`
        , `daftunit`.`nmunit`
        , `tab_pptk_master`.*
        ,COALESCE((SUM(tab_realisasi_bmodal.`nilai_ktrk`)),0) AS realisasi_mdl
        ,COALESCE((SUM(tab_realisasi_bmodal_det.`realfisik_bljmodal`) / COUNT(tab_realisasi_bmodal_det.`realfisik_bljmodal`)),0) AS realisasi_fis
      ");
      $this->db->from('tab_pptk_master');
      $this->db->join('`daftunit`', '`tab_pptk_master`.`unitkey` = `daftunit`.`unitkey`','right');
      $this->db->join('`tab_pptk`', '`tab_pptk`.`id_pptk_master` = `tab_pptk_master`.`id`','left');
      $this->db->join('`tab_realisasi_bmodal`', '`tab_realisasi_bmodal`.`id_tab_pptk` = `tab_pptk`.`id`','left');
      $this->db->join('`tab_realisasi_bmodal_det`', 'tab_realisasi_bmodal_det.id_tab_real_bmodal = tab_realisasi_bmodal.id','left');
      $this->db->where("daftunit.`unitkey`",$unitkey);
      $this->db->where("tab_realisasi_bmodal.`id_struktur`",$idstruktur);
      $realmodal = $this->db->get();
      if($realmodal->num_rows()!=0){
        return $realmodal->row()->realisasi_mdl;
      }else{
        return 0;
      }
    }
    //end query untuk mendapatkan data realisasi hingga bulan ini-->

    //<--query untuk mendapatkan detail angkas hingga bulan sebelumnya
    function getdetangkashbs($nipppk,$unitkey)
    {
        $query = 'SELECT
    `angkas`.`kd_bulan`
    , `angkas`.`kdkegunit`
    , SUM(`angkas`.`nilai`) AS `total_angkas`
FROM
    `angkas`
    INNER JOIN `mkegiatan`
        ON (`angkas`.`kdkegunit` = `mkegiatan`.`kdkegunit`)
    INNER JOIN `tab_pptk`
        ON (`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`) WHERE `tab_pptk`.`idpnsppk` = '.$nipppk.' AND `angkas`.`kd_bulan`<MONTH(NOW()) AND `angkas`.`tahun`=YEAR(NOW()) AND `angkas`.`unitkey`="'.$unitkey.'" GROUP BY `angkas`.`kdkegunit`;';

        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }
    //Dari Agung
    function getdetangkasOPDhbs($unitkey)
    {
        $query = 'SELECT
    `angkas`.`kd_bulan`
    , `angkas`.`kdkegunit`
    , SUM(`angkas`.`nilai`) AS `total_angkas`
FROM
    `angkas`
    INNER JOIN `mkegiatan`
        ON (`angkas`.`kdkegunit` = `mkegiatan`.`kdkegunit`)
     WHERE `angkas`.`unitkey` = "'.$unitkey.'" AND `angkas`.`kd_bulan`<MONTH(NOW()) GROUP BY `angkas`.`kdkegunit`;';

        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }
    //Sampai
    //end query untuk mendapatkan detail angkas hingga bulan sebelumnya-->

    //<--query untuk mendapatkan rincian realisasi
    function rincianrealisasi($kdkegunit)
    {
        $query = 'SELECT
    `matangr`.`mtgkey`
    , `matangr`.`nmper`
    , `matangr`.`kdper`
    , `tab_realisasi`.`id` AS `id_tab_realisasi`
    , `tab_realisasi`.`id_struktur`
    , `tab_realisasi`.`real_bulan`
    , `tab_realisasi`.`tgl_entri`
    , `tab_realisasi`.`bobot_real`
    , `tab_sumber_dana`.`nm_dana`
    , `tab_realisasi_det`.`harga_satuan`
    , `tab_realisasi_det`.`jumlah_harga`
    , `tab_realisasi_det`.`sisa_dana`
    , `tab_realisasi_det`.`vol`
    , `dpa221`.`satuan`
    , `dpa221`.`uraian`
FROM
    `tab_realisasi`
    INNER JOIN `tab_realisasi_det`
        ON (`tab_realisasi`.`id` = `tab_realisasi_det`.`id_tab_realisasi`)
    INNER JOIN `dpa221`
        ON (`tab_realisasi_det`.`id_dpa` = `dpa221`.`id`)
    INNER JOIN `matangr`
        ON (`dpa221`.`mtgkey` = `matangr`.`mtgkey`)
    INNER JOIN `mkegiatan`
        ON (`dpa221`.`kdkegunit` = `mkegiatan`.`kdkegunit`)
    INNER JOIN `tab_sumber_dana`
        ON (`tab_sumber_dana`.`id` = `tab_realisasi_det`.`sumber_dana`)
        WHERE `mkegiatan`.`kdkegunit` = "'.$kdkegunit.'" AND MONTH(`tab_realisasi`.`real_bulan`)=MONTH(NOW()) AND YEAR(`tab_realisasi`.`real_bulan`)=YEAR(NOW())';

        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }
    //end query untuk mendapatkan rincian realisasi-->

    //<--query untuk mendapatkan data mata anggaran
    function getmatangr($kdkegunit)
    {
        $query = 'SELECT
    `matangr`.`kdper`
    , `matangr`.`nmper`
    , `matangr`.`mtgkey`
    , SUM(`tab_realisasi_det`.`sisa_dana`) AS `sisa_dana`
FROM
    `matangr`
    INNER JOIN `dpa221`
        ON (`matangr`.`mtgkey` = `dpa221`.`mtgkey`)
    INNER JOIN `tab_realisasi_det`
        ON (`dpa221`.`id` = `tab_realisasi_det`.`id_dpa`)
    INNER JOIN `tab_realisasi`
        ON (`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`)
        WHERE `dpa221`.`kdkegunit`= "'.$kdkegunit.'" AND MONTH(`tab_realisasi`.`real_bulan`)=MONTH(NOW()) AND YEAR(`tab_realisasi`.`real_bulan`)=YEAR(NOW()) GROUP BY `matangr`.`kdper`';

        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }
    //end query untuk mendapatkan data mata anggaran-->

    //<--query untuk mendapatkan data mata anggaran belanja modal
    function getmatangrbmodal($kdkegunit)
    {
        $query = 'SELECT
    `matangr`.`kdper`
    , `matangr`.`nmper`
    , `matangr`.`mtgkey`
FROM
    `tab_realisasi_bmodal_det`
    INNER JOIN `tab_realisasi_bmodal`
        ON (`tab_realisasi_bmodal_det`.`id_tab_real_bmodal` = `tab_realisasi_bmodal`.`id`)
    INNER JOIN `matangr`
        ON (`tab_realisasi_bmodal`.`mtgkey` = `matangr`.`mtgkey`)
    INNER JOIN `dpa221`
        ON (`dpa221`.`mtgkey` = `matangr`.`mtgkey`)
        WHERE `dpa221`.`kdkegunit`= "'.$kdkegunit.'" AND MONTH(`tab_realisasi_bmodal`.`real_bulan`)=MONTH(NOW()) AND YEAR(`tab_realisasi_bmodal`.`real_bulan`)=YEAR(NOW()) GROUP BY `matangr`.`kdper`';

        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }
    //end query untuk mendapatkan data mata anggaran belanja modal-->

    //<--query untuk mendapatkan detail angkas untuk satu tahun
    function getdetangkassatutahun($nipppk,$unitkey)
    {
        $query = 'SELECT
    `angkas`.`kd_bulan`
    , `angkas`.`kdkegunit`
    , SUM(`angkas`.`nilai`) AS `total_angkas`
FROM
    `angkas`
    INNER JOIN `mkegiatan`
        ON (`angkas`.`kdkegunit` = `mkegiatan`.`kdkegunit`)
    INNER JOIN `tab_pptk`


        ON (`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`) WHERE `tab_pptk`.`idpnsppk` = '.$nipppk.' AND `angkas`.`tahun`=YEAR(NOW()) AND `angkas`.`unitkey`="'.$unitkey.'" GROUP BY `angkas`.`kdkegunit`;';



        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }
    function getdetangkasOPDsatutahun($unitkey)
    {
        $query = 'SELECT
    `angkas`.`kd_bulan`
    , `angkas`.`kdkegunit`
    , SUM(`angkas`.`nilai`) AS `total_angkas`
FROM
    `angkas`
    INNER JOIN `mkegiatan`
        ON (`angkas`.`kdkegunit` = `mkegiatan`.`kdkegunit`)
     WHERE `angkas`.`unitkey` = "'.$unitkey.'" AND `angkas`.`tahun`=YEAR(NOW()) GROUP BY `angkas`.`kdkegunit`;';

        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }
    //end query untuk mendapatkan detail angkas untuk satu tahun-->

    //<--query untuk mendapatkan data schedule satu tahun
    function getdataschedule($nipppk)
    {
        $query = 'SELECT
    `tab_pptk`.`kdkegunit`
    , `tab_schedule`.`id_tab_kak`
    , `tab_schedule`.`jan` AS `bulan_1`
    , `tab_schedule`.`feb` AS `bulan_2`
    , `tab_schedule`.`mar` AS `bulan_3`
    , `tab_schedule`.`apr` AS `bulan_4`
    , `tab_schedule`.`mei` AS `bulan_5`
    , `tab_schedule`.`jun` AS `bulan_6`
    , `tab_schedule`.`jul` AS `bulan_7`
    , `tab_schedule`.`ags` AS `bulan_8`
    , `tab_schedule`.`sep` AS `bulan_9`
    , `tab_schedule`.`okt` AS `bulan_10`
    , `tab_schedule`.`nov` AS `bulan_11`
    , `tab_schedule`.`des` AS `bulan_12`
FROM
    `tab_kak`
    INNER JOIN `tab_pptk`
        ON (`tab_kak`.`idtab_pptk` = `tab_pptk`.`id`)
    INNER JOIN `mkegiatan`
        ON (`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`)
    INNER JOIN `tab_schedule`
        ON (`tab_schedule`.`id_tab_kak` = `tab_kak`.`id`)
        WHERE `tab_pptk`.`idpnsppk`='.$nipppk.' AND `mkegiatan`.`tahun`=YEAR(NOW())';

        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }
    //Agung Get Schedule kegiatan  masing masin pptk per opdd
    function getdatascheduleOPD($unitkey)
    {
        $query = 'SELECT
    `tab_pptk`.`kdkegunit`
    , `tab_schedule`.`id_tab_kak`
    , `tab_schedule`.`jan` AS `bulan_1`
    , `tab_schedule`.`feb` AS `bulan_2`
    , `tab_schedule`.`mar` AS `bulan_3`
    , `tab_schedule`.`apr` AS `bulan_4`
    , `tab_schedule`.`mei` AS `bulan_5`
    , `tab_schedule`.`jun` AS `bulan_6`
    , `tab_schedule`.`jul` AS `bulan_7`
    , `tab_schedule`.`ags` AS `bulan_8`
    , `tab_schedule`.`sep` AS `bulan_9`
    , `tab_schedule`.`okt` AS `bulan_10`
    , `tab_schedule`.`nov` AS `bulan_11`
    , `tab_schedule`.`des` AS `bulan_12`
FROM
    `tab_kak`
    INNER JOIN `tab_pptk`
        ON (`tab_kak`.`idtab_pptk` = `tab_pptk`.`id`)
    INNER JOIN `tab_pptk_master`
        ON (`tab_pptk`.`id_pptk_master` = `tab_pptk_master`.`id`)
    INNER JOIN `mkegiatan`
        ON (`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`)
    INNER JOIN `tab_schedule`
        ON (`tab_schedule`.`id_tab_kak` = `tab_kak`.`id`)
        WHERE `tab_pptk_master`.`unitkey`="'.$unitkey.'" AND `mkegiatan`.`tahun`=YEAR(NOW())';

        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }
    ////Agung Get Schedule kegiatan  masing masin pptk per opdd
    //end query untuk mendapatkan data schedule satu tahun-->

    //<--query untuk mendapatkan data realisasi fisik bulan ini
    function getrealfisik($nipppk)
    {
        $query = 'SELECT
    `mkegiatan`.`kdkegunit`
    , `tab_realisasi`.`bobot_real`
FROM
    `tab_pptk`
    INNER JOIN `mkegiatan`
        ON (`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`)
    INNER JOIN `tab_realisasi`
        ON (`tab_realisasi`.`id_tabpptk` = `tab_pptk`.`id`)
        WHERE `tab_pptk`.`idpnsppk`='.$nipppk.' AND `mkegiatan`.`tahun`=YEAR(NOW()) AND MONTH(`tab_realisasi`.`real_bulan`)=MONTH(NOW()) AND YEAR(`tab_realisasi`.`real_bulan`)=YEAR(NOW())';

        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }
    //end query untuk mendapatkan data realisasi fisik bulan ini-->

    //<--query untuk mendapatkan data realisasi fisik bulan ini PEr satu OPD : Agung
    function getrealfisikOPD($id_struktur)
    {
        $query = 'SELECT
    `mkegiatan`.`kdkegunit`
    , `tab_realisasi`.`bobot_real`
FROM
    `tab_pptk`
    INNER JOIN `mkegiatan`
        ON (`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`)
    INNER JOIN `tab_realisasi`
        ON (`tab_realisasi`.`id_tabpptk` = `tab_pptk`.`id`)
        WHERE `tab_realisasi`.`id_struktur`='.$id_struktur.' AND `mkegiatan`.`tahun`=YEAR(NOW()) AND MONTH(`tab_realisasi`.`real_bulan`)=MONTH(NOW())';

    }
    //<--query untuk mendapatkan data realisasi belanja modal bulan ini
    function getrealbmodal($kdkegunit)
    {
        $query = 'SELECT
    `matangr`.`mtgkey`
    , `dpa221`.`uraian`
    , `dpa221`.`satuan`
    , `dpa221`.`jumbyek` AS `vol`
    , `tab_realisasi_bmodal`.`id` AS `id_tab_realisasi_bmodal`
    , `tab_realisasi_bmodal`.`id_struktur`
    , `tab_realisasi_bmodal`.`nilai_ktrk` AS `harga_satuan`
    , `tab_realisasi_bmodal`.`nilai_ktrk` AS `jumlah_harga`
FROM
    `tab_realisasi_bmodal_det`
    INNER JOIN `tab_realisasi_bmodal`
        ON (`tab_realisasi_bmodal_det`.`id_tab_real_bmodal` = `tab_realisasi_bmodal`.`id`)
    INNER JOIN `matangr`
        ON (`tab_realisasi_bmodal`.`mtgkey` = `matangr`.`mtgkey`)
    INNER JOIN `dpa221`
        ON (`dpa221`.`mtgkey` = `matangr`.`mtgkey`)
        WHERE `dpa221`.`kdkegunit`="'.$kdkegunit.'" AND MONTH(`tab_realisasi_bmodal`.`real_bulan`)=MONTH(NOW()) AND YEAR(`tab_realisasi_bmodal`.`real_bulan`)=YEAR(NOW())';

        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }
    //end query untuk mendapatkan data realisasi belanja modal bulan ini-->

    //<--query untuk mendapatkan seluruh data realisasi belanja modal hingga bulan sebelumnya
    function gettotalrealbmodalhbs($idstrukturppk)
    {
        $query = 'SELECT
    SUM(`tab_realisasi_bmodal`.`nilai_ktrk`) AS `total_real_bmodal`
FROM
    `tab_realisasi_bmodal`
    INNER JOIN `tab_struktur`
        ON (`tab_realisasi_bmodal`.`admin_entri` = `tab_struktur`.`nip`)
        WHERE `tab_struktur`.`parent`='.$idstrukturppk.' AND MONTH(`tab_realisasi_bmodal`.`real_bulan`)<MONTH(NOW()) AND YEAR(`tab_realisasi_bmodal`.`real_bulan`)=YEAR(NOW());';

        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->row()->total_real_bmodal;
        }else{
            return 0;
        }
    }
    //end query untuk mendapatkan seluruh data realisasi belanja modal hingga bulan sebelumnya-->

    //<--query untuk mendapatkan seluruh data realisasi belanja modal bulan ini
    function gettotalrealbmodalbi($idstrukturppk)
    {
        $query = 'SELECT
    SUM(`tab_realisasi_bmodal`.`nilai_ktrk`) AS `total_real_bmodal`
FROM
    `tab_realisasi_bmodal`
    INNER JOIN `tab_struktur`
        ON (`tab_realisasi_bmodal`.`admin_entri` = `tab_struktur`.`nip`)
        WHERE `tab_struktur`.`parent`='.$idstrukturppk.' AND MONTH(`tab_realisasi_bmodal`.`real_bulan`)=MONTH(NOW()) AND YEAR(`tab_realisasi_bmodal`.`real_bulan`)=YEAR(NOW());';

        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->row()->total_real_bmodal;
        }else{
            return 0;
        }
    }
    //end query untuk mendapatkan seluruh data realisasi belanja modal bulan ini-->

    //<--query untuk mendapatkan data angkas untuk belanja modal
    function getangkasbmodal($kdkegunit,$unitkey)
    {
        $query = 'SELECT
            `nilai`,`mtgkey`
            FROM
    `angkas`
    WHERE `angkas`.`kdkegunit`="'.$kdkegunit.'" AND `angkas`.`tahun`=YEAR(NOW()) AND `angkas`.`unitkey`="'.$unitkey.'"';


        if($this->db->query($query)->num_rows()!=0){
            return $this->db->query($query)->result_array();
        }else{
            return 0;
        }
    }

    //end query untuk mendapatkan data realisasi fisik bulan ini PEr satu OPD : Agung-->


    //ryh Sekretaris
    function pagupptksekretaris($thnsekarang,$blnsekarang,$idopd,$arrkdkegunit){
  //     SELECT
  //     SUM(`angkas`.`nilai`) AS `pagu_tahun`
  // FROM angkas WHERE `unitkey`='80_' AND `kdkegunit`!='0_' AND `kdkegunit`IN('11142_','11_','12_','13_','15_','17_','1841_','18_','19_','1_','29_','2_','36_','40_','51_','64_','6_','7_','8_') AND `kd_bulan`>='1' AND `kd_bulan`<='12'
    $nilai = array();
    $this->db->select('
    SUM(`angkas`.`nilai`) AS `tahun`');
    $this->db->from('angkas');
    $this->db->where('tahun', $thnsekarang);
    $this->db->where('unitkey', $idopd);
    $this->db->where('kdkegunit!=', '0_');
    $this->db->where_in('kdkegunit', $arrkdkegunit);
    $tahun = $this->db->get()->row_array();

    $this->db->select('
    SUM(`angkas`.`nilai`) AS `blnskr`');
    $this->db->from('angkas');
    $this->db->where('tahun', $thnsekarang);
    $this->db->where('unitkey', $idopd);
    $this->db->where('kd_bulan', $blnsekarang);
    $this->db->where('kdkegunit!=', '0_');
    $this->db->where_in('kdkegunit', $arrkdkegunit);
    $blnskr = $this->db->get()->row_array();

    $this->db->select('
    SUM(`angkas`.`nilai`) AS `blnsdskr`');
    $this->db->from('angkas');
    $this->db->where('tahun', $thnsekarang);
    $this->db->where('unitkey', $idopd);
    $this->db->where('kd_bulan <=', $blnsekarang);
    $this->db->where('kdkegunit!=', '0_');
    $this->db->where_in('kdkegunit', $arrkdkegunit);
    $blnsdskr = $this->db->get()->row_array();

    $nilai[]=array(
      'tahun' => $tahun['tahun'],
      'blnskr'=> $blnskr['blnskr'],
      'blnsdskr'=>$blnsdskr['blnsdskr']
              );

    return $nilai;

    }

    //end query untuk mendapatkan data angkas untuk belanja modal-->


    function update_id_struktur($value,$where,$table)
    {
      $this->db->set($value);
      $this->db->where($where);
      if($this->db->update($table)){
        return true;
      }else{
        return false;
      }
    }
}
