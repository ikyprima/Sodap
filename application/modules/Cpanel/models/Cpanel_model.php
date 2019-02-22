<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cpanel_model extends CI_Model
{
  public $mopd        = 'daftunit';
  public $mprogram    = 'mpgrm';
  public $mkegiatan   = 'mkegiatan';
  public $manggaran   = 'matangr';
  public $tab_pns     = 'tab_pns';
  function __construct()
  {
      parent::__construct();
  }

  //Tabel Master
  function getopd($thn){
    $this->db->where('unitkey !=', '40_');
    $this->db->where('unitkey !=', '98_');
    $this->db->where('tahun', $thn);
    return $this->db->get('daftunit');
  }

  function getrow_nama_opd($thn,$idopd){
    $this->db->where('unitkey', $idopd);
    $this->db->where('tahun', $thn);
    return $this->db->get('daftunit');
  }
  function get_id_pptk_master($idopd,$thn){
    $this->db->where('unitkey ', $idopd);
    $this->db->where('tahun', $thn);
    return $this->db->get('tab_pptk_master');
  }

  function get_pptk_det($idpptkmaster){
    $this->db->where('id_pptk_master ', $idpptkmaster);
    return $this->db->get('tab_pptk');
  }

  function getjumlahreal($wherein, $idbln){

    // $str=implode (', ', $wherein);
    // $array= "'$str'";
    // //  echo json_encode($str);exit;
    // $this->db->select('totjum_realisaasi('.$array.','.$idbln.') AS jumlah',FALSE);
    // return $this->db->get()->row_array();

        $this->db->select('SUM(`tab_realisasi_det`.`jumlah_harga`)  AS total');
        $this->db->from('tab_realisasi_det');
        $this->db->join('tab_realisasi', '`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`');
        $this->db->join('tab_pptk', '`tab_realisasi`.`id_tabpptk` = `tab_pptk`.`id`');
        $this->db->where_in('`tab_realisasi`.`id_tabpptk`', $wherein);
        $this->db->where('MONTH(`tab_realisasi`.`real_bulan`)', $idbln);
        return $this->db->get();
  }
  function getjumlahrealmodal($wherein, $idbln){
        $this->db->select('SUM(`tab_realisasi_bmodal_det`.`real_keuangan`)  AS total');
        $this->db->from('tab_realisasi_bmodal');
        $this->db->join('tab_pptk', '`tab_realisasi_bmodal`.`id_tab_pptk` = `tab_pptk`.`id`');
        $this->db->join('tab_realisasi_bmodal_det', '`tab_realisasi_bmodal_det`.`id_tab_real_bmodal` = `tab_realisasi_bmodal`.`id`');
        $this->db->where_in('`tab_realisasi_bmodal`.`id_tab_pptk`', $wherein);
        $this->db->where('MONTH(`tab_realisasi_bmodal_det`.`real_bulan`)', $idbln);
        return $this->db->get();
  }

  function getangkasbulan($idopd, $idbln ,$thn){

        $this->db->select('SUM(`angkas`.`nilai`) AS total');
        $this->db->from('angkas');
        $this->db->where('`angkas`.`tahun`', $thn);
        $this->db->where('`angkas`.`kd_bulan`', $idbln);
        $this->db->where('`angkas`.`unitkey`', $idopd);
        $this->db->where('`angkas`.`kdkegunit` !=', '0_');
        return $this->db->get();
  }
  function paguopd($thnsekarang,$blnsekarang,$idopd){
    // ambil aliran kas berdasrkan unitkey (idopd) Saja
  //     SELECT
  //     SUM(`angkas`.`nilai`) AS `pagu_tahun`
  // FROM angkas WHERE `unitkey`='80_' AND `kdkegunit`!='0_' AND `kd_bulan`>='1' AND `kd_bulan`<='12'
  $nilai = array();
  $this->db->select('
  SUM(`angkas`.`nilai`) AS `tahun`');
  $this->db->from('angkas');
  $this->db->where('tahun', $thnsekarang);
  $this->db->where('unitkey', $idopd);
  $this->db->where('kdkegunit!=', '0_');
  $tahun = $this->db->get()->row_array();

  $this->db->select('
  SUM(`angkas`.`nilai`) AS `blnskr`');
  $this->db->from('angkas');
  $this->db->where('tahun', $thnsekarang);
  $this->db->where('unitkey', $idopd);
  $this->db->where('kd_bulan', $blnsekarang);
  $this->db->where('kdkegunit!=', '0_');
  $blnskr = $this->db->get()->row_array();

  $this->db->select('
  SUM(`angkas`.`nilai`) AS `blnsdskr`');
  $this->db->from('angkas');
  $this->db->where('tahun', $thnsekarang);
  $this->db->where('unitkey', $idopd);
  $this->db->where('kd_bulan <=', $blnsekarang);
  $this->db->where('kdkegunit!=', '0_');
  $blnsdskr = $this->db->get()->row_array();

  $nilai[]=array(
    'tahun' => $tahun['tahun'],
    'blnskr'=> $blnskr['blnskr'],
    'blnsdskr'=>$blnsdskr['blnsdskr']
  );

  return $nilai;

  }

  function get_row_pptk_master ($idopd,$thn){
    $this->db->where('unitkey', $idopd);
    $this->db->where('tahun', $thn);
    return $this->db->get('tab_pptk_master');
  }
  function get_list_ppk ($idmaster){

           $this->db->select('
           `tab_pptk`.`id`
           ,`tab_pptk`.`id_pptk_master`
           ,sum(`tab_pptk`.`nilai`) as nilai
           ,`tab_pptk`.`status`
           ,`tab_pptk`.`idpnsppk` as nipppk
           , u1.nama idpnsppk');
           $this->db->from('tab_pptk');
           $this->db->join('tab_pns u1', 'tab_pptk.idpnsppk = u1.nip');
           $this->db->join('tab_pptk_master', 'tab_pptk.id_pptk_master = tab_pptk_master.id');
            $this->db->where('id_pptk_master', $idmaster);
            $this->db->group_by('idpnsppk');
            $this->db->order_by('`tab_pptk`.`idpnsppk`','asc');
            return $this->db->get();

  }
  function getdetlistkegiatan_semuappk($idmaster,$thn){
     $this->db->select('
     `mpgrm`.`IDPRGRM` as idprog
     ,`mpgrm`.`NMPRGRM` as prog
     ,`mkegiatan`.`kdkegunit` as kdkegunit
     ,`mkegiatan`.`nmkegunit` as nmkegunit
     , `tab_pptk`.`nilai`
     , `tab_pptk`.`id`
     , `tab_pptk`.`status`
     ,`tab_pptk`.`idpnspptk` as nippptk
     ,`tab_pptk`.`idpnsppk` as nipppk
     , u2.nama idpnspptk
     , u1.nama idpnsppk');
       $this->db->from('tab_pptk');
       $this->db->join('tab_pns u1', 'tab_pptk.idpnsppk = u1.nip');
       $this->db->join('tab_pns u2', 'tab_pptk.idpnspptk = u2.nip');
       $this->db->join('tab_pptk_master', 'tab_pptk.id_pptk_master = tab_pptk_master.id');
       $this->db->join('daftunit', 'tab_pptk_master.unitkey = daftunit.unitkey');
       $this->db->join('mkegiatan', 'tab_pptk.kdkegunit = mkegiatan.kdkegunit');
       $this->db->join('mpgrm', 'mkegiatan.idprgrm = mpgrm.IDPRGRM');
       $this->db->where('tab_pptk_master.tahun', $thn);
       $this->db->where('tab_pptk_master.id', $idmaster);
       $this->db->where('daftunit.tahun', $thn);
       $this->db->where('mkegiatan.tahun', $thn);

       return $this->db->get()->result_array();
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
     //list Program
     function listprogram($idopd,$thn){
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
     //list kegiatan berdasarkan idopd tahun dan program
     // function listkegiatan($idopd,$thn,$prog){
     //   $this->db->select('dpa22.kdkegunit,mkegiatan.nmkegunit, sum(dpa22.nilai) as nilai');
     //   $this->db->from('dpa22');
     //   $this->db->join('mkegiatan', 'dpa22.kdkegunit = mkegiatan.kdkegunit');
     //   $this->db->join('mpgrm', 'mpgrm.IDPRGRM = mkegiatan.idprgrm');
     //   $this->db->where('dpa22.unitkey', $idopd);
     //   $this->db->where('dpa22.tahun', $thn);
     //   $this->db->where('mpgrm.tahun', $thn);
     //   $this->db->where('mkegiatan.tahun', $thn);
     //   $this->db->where('mkegiatan.idprgrm', $prog);
     //   $this->db->group_by('dpa22.kdkegunit');
     //   return $this->db->get();
     // }
     function listkegiatan($idopd,$thn,$prog){

        $this->db->select('
        `mpgrm`.`IDPRGRM` as idprog
        ,`mpgrm`.`NMPRGRM` as prog
        ,`mkegiatan`.`kdkegunit` as kdkegunit
        ,`mkegiatan`.`nmkegunit` as nmkegunit
        , `tab_pptk`.`nilai`
        , `tab_pptk`.`id`
        , `tab_pptk`.`status`
        ,`tab_pptk`.`idpnspptk` as nippptk
        ,`tab_pptk`.`idpnsppk` as nipppk
        , u2.nama idpnspptk
        , u1.nama idpnsppk');
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
          $this->db->where('daftunit.unitkey', $idopd);
          $this->db->where('mkegiatan.idprgrm', $prog);

          return $this->db->get();
        }

     function paguprogram($thnsekarang,$blnsekarang,$idopd,$idprog){
   //     SELECT
   //     SUM(`angkas`.`nilai`) AS `pagu_tahun`
   // FROM angkas WHERE `unitkey`='80_' AND `kdkegunit`!='0_' AND `kdkegunit`IN('11142_','11_','12_','13_','15_','17_','1841_','18_','19_','1_','29_','2_','36_','40_','51_','64_','6_','7_','8_') AND `kd_bulan`>='1' AND `kd_bulan`<='12'
     $nilai = array();
     $this->db->select('
     SUM(`angkas`.`nilai`) AS `tahun`');
     $this->db->from('angkas');
     $this->db->join('mkegiatan', '`angkas`.`kdkegunit` = `mkegiatan`.`kdkegunit`');
     $this->db->join('mpgrm', '`mkegiatan`.`idprgrm` = `mpgrm`.`IDPRGRM`');
     $this->db->where('angkas.tahun', $thnsekarang);
     $this->db->where('angkas.unitkey', $idopd);
     $this->db->where('angkas.kdkegunit!=', '0_');
     $this->db->where('`mpgrm`.`IDPRGRM`', $idprog);
     $tahun = $this->db->get()->row_array();

     $this->db->select('
     SUM(`angkas`.`nilai`) AS `blnskr`');
     $this->db->from('angkas');
     $this->db->join('mkegiatan', '`angkas`.`kdkegunit` = `mkegiatan`.`kdkegunit`');
     $this->db->join('mpgrm', '`mkegiatan`.`idprgrm` = `mpgrm`.`IDPRGRM`');
     $this->db->where('angkas.tahun', $thnsekarang);
     $this->db->where('angkas.unitkey', $idopd);
     $this->db->where('angkas.kd_bulan', $blnsekarang);
     $this->db->where('angkas.kdkegunit!=', '0_');
     $this->db->where('`mpgrm`.`IDPRGRM`', $idprog);
     $blnskr = $this->db->get()->row_array();

     $this->db->select('
     SUM(`angkas`.`nilai`) AS `blnsdskr`');
     $this->db->from('angkas');
     $this->db->join('mkegiatan', '`angkas`.`kdkegunit` = `mkegiatan`.`kdkegunit`');
     $this->db->join('mpgrm', '`mkegiatan`.`idprgrm` = `mpgrm`.`IDPRGRM`');
     $this->db->where('angkas.tahun', $thnsekarang);
     $this->db->where('angkas.unitkey', $idopd);
     $this->db->where('angkas.kd_bulan <=', $blnsekarang);
     $this->db->where('angkas.kdkegunit!=', '0_');
     $this->db->where('`mpgrm`.`IDPRGRM`', $idprog);
     $blnsdskr = $this->db->get()->row_array();

     $nilai[]=array(
       'tahun' => $tahun['tahun'],
       'blnskr'=> $blnskr['blnskr'],
       'blnsdskr'=>$blnsdskr['blnsdskr']
               );

     return $nilai;

     }
     function realkeu_prog_persen($idprog,$thn,$kdbln,$sd=null){
     // select tab_realisasi MONTH(`tab_realisasi_bmodal`.`real_bulan`)
       $this->db->select('SUM(`tab_realisasi_det`.`jumlah_harga`) AS nilai');
       $this->db->from('`tab_pptk`');
       $this->db->join('tab_pptk_master', '`tab_pptk`.`id_pptk_master` = `tab_pptk_master`.`id`');
       $this->db->join('mkegiatan', '`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`');
       $this->db->join('mpgrm', '`mkegiatan`.`idprgrm` = `mpgrm`.`IDPRGRM`');
       $this->db->join('tab_realisasi', '`tab_realisasi`.`id_tabpptk` = `tab_pptk`.`id`');
       $this->db->join('tab_realisasi_det', '`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`');
       $this->db->where('`mpgrm`.`IDPRGRM`', $idprog);
       if($sd!=null){
         $this->db->where('MONTH(`tab_realisasi`.`real_bulan`) <=', $kdbln);
       }else{
         $this->db->where('MONTH(`tab_realisasi`.`real_bulan`)', $kdbln);
       }
       $this->db->where('YEAR(`tab_realisasi`.`real_bulan`)', $thn);
       return $this->db->get()->row_array();
     }
     function realkeu_prog_bmodal_persen($idprog,$thn,$kdbln,$sd=null){
     // select tab_realisasi MONTH(`tab_realisasi_bmodal`.`real_bulan`)
       $this->db->select('SUM(`tab_realisasi_bmodal_det`.`real_keuangan`) AS nilai');
       $this->db->from('`tab_realisasi_bmodal_det`');
       $this->db->join('tab_realisasi_bmodal', '`tab_realisasi_bmodal_det`.`id_tab_real_bmodal` = `tab_realisasi_bmodal`.`id`');
       $this->db->join('tab_pptk', '`tab_realisasi_bmodal`.`id_tab_pptk` = `tab_pptk`.`id`');
       $this->db->join('tab_pptk_master', '`tab_pptk`.`id_pptk_master` = `tab_pptk_master`.`id`');
       $this->db->join('mkegiatan', '`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`');
       $this->db->join('mpgrm', '`mkegiatan`.`idprgrm` = `mpgrm`.`IDPRGRM`');
       $this->db->where('`mpgrm`.`IDPRGRM`', $idprog);

       if($sd!=null){
         $this->db->where('MONTH(`tab_realisasi_bmodal_det`.`real_bulan`) <=', $kdbln);
       }else{
         $this->db->where('MONTH(`tab_realisasi_bmodal_det`.`real_bulan`)', $kdbln);
       }

       $this->db->where('YEAR(`tab_realisasi_bmodal_det`.`real_bulan`)', $thn);
       return $this->db->get()->row_array();
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
     function tarkeu_ppk($unit,$thn,$kdbln,$kdkeg){
     // select angkas
       $this->db->select('sum(nilai) as nilai');
       $this->db->from('angkas');
       $this->db->where('angkas.tahun', $thn);
       $this->db->where('angkas.unitkey', $unit);
       $this->db->where('angkas.kdkegunit', $kdkeg);
       $this->db->where('angkas.kd_bulan <=', $kdbln);
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
     function realkeu_ppk($idtab,$thn,$kdbln){
     // select tab_realisasi MONTH(`tab_realisasi_bmodal`.`real_bulan`)

       $this->db->select('tab_realisasi.id as id,permasalahan,real_fisik,bobot_real,SUM(`tab_realisasi_det`.`jumlah_harga`) AS nilai , tab_realisasi.stat_teruskan');
       $this->db->from('`tab_realisasi_det`');
       $this->db->join('tab_realisasi', '`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`');
       $this->db->where('tab_realisasi.id_tabpptk', $idtab);

       $this->db->where('MONTH(`tab_realisasi`.`real_bulan`) <=', $kdbln);
      // $this->db->where('MONTH(`tab_realisasi`.`real_bulan`) ', $kdbln);
       $this->db->where('YEAR(`tab_realisasi`.`real_bulan`)', $thn);
       return $this->db->get()->row_array();
     }
     function realkeu_ppk_detailrealisasi($idtab,$thn,$kdbln){
     // select tab_realisasi MONTH(`tab_realisasi_bmodal`.`real_bulan`)

       $this->db->select('tab_realisasi.id as id,permasalahan,real_fisik,bobot_real,SUM(`tab_realisasi_det`.`jumlah_harga`) AS nilai , tab_realisasi.stat_teruskan');
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
      $this->db->where('MONTH(`tab_realisasi_bmodal_det`.`real_bulan`) <=', $kdbln);
       //$this->db->where('MONTH(`tab_realisasi_bmodal_det`.`real_bulan`) ', $kdbln);
       $this->db->where('YEAR(`tab_realisasi_bmodal_det`.`real_bulan`)', $thn);
       return $this->db->get()->row_array();
     }
     function realkeu_ppk_bmodal_detailrealisasi($idtab,$thn,$kdbln){
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
     function getdetlistkegiatan_detpptk($nip,$kdkegunit,$thn){


          $this->db->select('
           `mpgrm`.`IDPRGRM` as idprog
           ,`mpgrm`.`NMPRGRM` as prog
           ,`mkegiatan`.`kdkegunit` as kdkeg
           ,`mkegiatan`.`nmkegunit` as keg
           ,`tab_pptk`.`id` as id
           ,`tab_pptk`.`nilai` as nl
           ,`tab_pptk`.`idpnspptk` as nippptk
           ,`tab_pptk`.`idpnsppk` as nipppk
           ,u2.nama pptk
           ,u1.nama ppk');
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
           return $this->db->get()->row_array();
         }
         function anggaranopd($idopd){
           $this->db->select('SUM(nilai)AS anggranopd');
           $this->db->from('angkas');
           $this->db->where('`angkas`.`kdkegunit` !=', '0_');
            $this->db->where('`angkas`.`unitkey`', $idopd);
           return $this->db->get()->row();
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
        function rowsub_detail($tahun,$unitkey,$kdkegunit,$mtgkey){
          $this->db->select('`dpa221`.`id`
        , `dpa221`.`satuan`
        , `dpa221`.`kdkegunit`
        , `dpa221`.`mtgkey`
        , `matangr`.`kdper`
        , `matangr`.`nmper`
        , `dpa221`.`jumbyek`
        , `dpa221`.`unitkey`
        , `dpa221`.`uraian`
        , `dpa221`.`tarif`
        , `dpa221`.`kdjabar`
        , `dpa221`.`type`
        , `dpa221`.`tahun`');
          $this->db->from('dpa221');
          $this->db->join('matangr', '`dpa221`.`mtgkey` = `matangr`.`mtgkey`');
          $this->db->where('`dpa221`.`tahun`', $tahun);
          $this->db->where('`dpa221`.`unitkey`', $unitkey);
          $this->db->where('`dpa221`.`kdkegunit`', $kdkegunit);
          $this->db->where('`dpa221`.`mtgkey`', $mtgkey);
          return $this->db->get()->result_array();
        }
        function rincirealisasibmodal($idtab,$detmtgkey){
            // select id , id_tab_pptk , nilai_ktrk  where id_tab_pptk dan mtgkey
          $this->db->select('`tab_realisasi_bmodal`.`id`
          ,`tab_realisasi_bmodal`.`id_tab_pptk`
          , `tab_realisasi_bmodal`.`nilai_ktrk`');
          $this->db->from('tab_realisasi_bmodal');
          $this->db->where('id_tab_pptk', $idtab);
          $this->db->where('mtgkey', $detmtgkey);
          return $this->db->get()->row_array();
        }
        function rincirealisasibmodaldet($idrealmodal,$thn,$bln){
            // select id , id_tab_pptk , nilai_ktrk  where id_tab_pptk dan mtgkey
          $this->db->select('`tab_realisasi_bmodal_det`.`id`
          ,`tab_realisasi_bmodal_det`.`real_bulan`
          ,`tab_realisasi_bmodal_det`.`bobot_bljmodal`
          ,`tab_realisasi_bmodal_det`.`real_keuangan`
          ,`tab_realisasi_bmodal_det`.`realfisik_bljmodal`
          , `tab_realisasi_bmodal_det`.`bobot_real_bljmodal`');
          $this->db->from('tab_realisasi_bmodal_det');
          $this->db->where('id_tab_real_bmodal', $idrealmodal);
          $this->db->where('YEAR(`tab_realisasi_bmodal_det`.`real_bulan`)', $thn);
          $this->db->where('MONTH(`tab_realisasi_bmodal_det`.`real_bulan`)', $bln);
          return $this->db->get()->row_array();
        }
        function rincirealisasi($idreal,$detmtgkey,$detid){
          $this->db->select('`tab_sumber_dana`.`id`
          ,`tab_sumber_dana`.`nm_dana`
          , `tab_realisasi_det`.`vol`
          , `tab_realisasi_det`.`harga_satuan`
          , `tab_realisasi_det`.`jumlah_harga`
          , `tab_realisasi_det`.`sisa_dana`');
          $this->db->from('tab_realisasi_det');
          $this->db->join('tab_sumber_dana', '`tab_realisasi_det`.`sumber_dana` = `tab_sumber_dana`.`id`');
          $this->db->where('id_tab_realisasi', $idreal);
          $this->db->where('mtgkey', $detmtgkey);
          $this->db->where('id_dpa', $detid);
          return $this->db->get()->row_array();
        }
  //API
  function adddaftunit($thn){
    $fp = fsockopen("192.168.10.5", 8080, $errno, $errstr, 10);
    //if the socket failed it's offline...
    if (!$fp) {
        $status = false;
    }else{
    $url = 'http://192.168.10.5:8080/daftunit/22384ee59631a5a61ce3386af63c094b/'.$thn;
    $jsondata = file_get_contents($url);
    $obj = json_decode($jsondata, true);


    $data['responcode']=$obj['ResponseCode'];
    $data['data']= array();
    $data['update']= array();
    $list= array();
    foreach ($obj['DATA'] as $row) {
      $unitkey    = $row['UNITKEY'];
      $nmunit     = $row['NMUNIT'];

      $this->db->where('tahun', $thn);
      $this->db->where('unitkey', $unitkey);
      $cek = $this->db->get('daftunit');
        if (!$cek->num_rows()>0){
          $data['data'][] = array(
            "unitkey"  =>  $unitkey,
            "nmunit"   =>  $nmunit ,
            "tahun"    =>  $thn
          );
        }
      $data['update'][] = array(
        "unitkey"  =>  $unitkey,
        "nmunit"   =>  $nmunit,
        "tahun"    =>  $thn
      );
    }

    if(empty($data['data'])){
        $status = true;
    }else{
      $this->db->trans_start();
      $this->db->insert_batch('daftunit', $data['data']);
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
          'nmunit'=>$key['nmunit']
        );
        $this->db->where('tahun', $key['tahun']);
        $this->db->where('unitkey', $key['unitkey']);
        $this->db->update('daftunit',$dataup);
      }

    }
    return $status;
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

  function addmatangr($thn){

    $fp = fsockopen("192.168.10.5", 8080, $errno, $errstr, 10);
    //if the socket failed it's offline...
    if (!$fp) {
        $status = false;
    }else{
    $url = 'http://192.168.10.5:8080/matangr/22384ee59631a5a61ce3386af63c094b/'.$thn;
    $jsondata = file_get_contents($url);
    $obj = json_decode($jsondata, true);
    $data['responcode']=$obj['ResponseCode'];
    $data['data']= array();
    $data['update']= array();
    $list= array();
    foreach ($obj['DATA'] as $row) {

        $nmper    = $row['NMPER'];
        $kdper    = $row['KDPER'];
        $mtgkey   = $row['MTGKEY'];
        $mtglevel = $row['MTGLEVEL'];
        $type     = $row['TYPE'];


      $this->db->where('tahun', $thn);
      $this->db->where('mtgkey', $mtgkey);
      $cek = $this->db->get('matangr');
        if (!$cek->num_rows()>0){
          $data['data'][] = array(
            "mtgkey"    => $mtgkey,
            "kdper"     => $kdper ,
            "nmper"     => $nmper,
            "mtglevel"  => $mtglevel,
            "type"      => $type,
            "tahun"     => $thn
          );
        }
      $data['update'][] = array(
        "mtgkey"    => $mtgkey,
        "kdper"     => $kdper ,
        "nmper"     => $nmper,
        "mtglevel"  => $mtglevel,
        "type"      => $type,
        "tahun"     => $thn
      );
    }

    if(empty($data['data'])){
        $status = true;
    }else{
      $this->db->trans_start();
      $this->db->insert_batch('matangr', $data['data']);
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
          'kdper'   => $key['kdper'],
          'nmper'   => $key['nmper'],
          'mtglevel'=> $key['mtglevel'],
          'type'    => $key['type']

        );
        $this->db->where('tahun', $key['tahun']);
        $this->db->where('mtgkey', $key['mtgkey']);
        $this->db->update('matangr',$dataup);
      }

    }
  return $status;

  }

  function adddpa22($thn,$unit){

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

        $unitkey =  $row['UNITKEY'];
        $kdkegunit = $row['KDKEGUNIT'];
        $mtgkey = $row['MTGKEY'];
        $nilai = $row['NILAI'];


      $this->db->where('tahun', $thn);
      $this->db->where('unitkey', $unitkey);
      $this->db->where('kdkegunit', $kdkegunit);
      $this->db->where('mtgkey', $mtgkey);
      $cek = $this->db->get('dpa22');

        if (!$cek->num_rows()>0){
          $data['data'][] = array(
              "unitkey"   =>$unitkey,
              "kdkegunit" =>$kdkegunit,
              "mtgkey"    =>$mtgkey,
              "nilai"     =>$nilai,
              "tahun"     =>$thn
          );
        }

      $data['update'][] = array(
        "unitkey"   =>$unitkey,
        "kdkegunit" =>$kdkegunit,
        "mtgkey"    =>$mtgkey,
        "nilai"     =>$nilai,
        "tahun"     =>$thn
      );
    }

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
          'nilai'   => $key['nilai'],
        );
        $this->db->where('tahun',$key['tahun'] );
        $this->db->where('unitkey', $key['unitkey'] );
        $this->db->where('kdkegunit',$key['kdkegunit'] );
        $this->db->where('mtgkey', $key['mtgkey'] );
        $this->db->update('dpa22',$dataup);
      }

    }
    return $status;
  }



  function adddpa221($thn,$unit){
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

  function addangkas($thn,$unit){
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

  //batas API ryh


  /*baca*/
    function baca($opd,$tahun){
      $this->db->set('stat', '0');
      $this->db->where('unitkey', $opd);
       $this->db->where('tahun', $tahun);
      return $this->db->update('tab_pptk_master');
    }
    function simpanentrikegiatan($id,$list,$list2){
      $this->db->trans_start();

      $this->db->where('id', $id);
      $this->db->update('tab_pptk_master', $list);

      $this->db->where('id_pptk_master', $id);
      $this->db->update('tab_pptk', $list2);

      $this->db->trans_complete();
      if ($this->db->affected_rows() == '1') {
        return TRUE;
      }else{
            // trans error?
        if ($this->db->trans_status() === FALSE) {
          return 0;
        }
          return 1;
      }
    }
    function detailstatnol($id){

     $this->db->select(' `mkegiatan`.`nmkegunit`
    , `tab_pptk`.`nilai`
    , `tab_pptk`.`idpnsppk`
    , `tab_pptk`.`idpnspptk`
    , `tab_pptk`.`status`');
      $this->db->from('tab_pptk');
      $this->db->join('mkegiatan', '`tab_pptk`.`kdkegunit` = `mkegiatan`.`kdkegunit`');
      $this->db->where('`tab_pptk`.`id_pptk_master`', $id);
       $this->db->order_by('`mkegiatan`.`nmkegunit`', 'ASC');
      return $this->db->get()->result();

    }
    function getppkmaster($opd,$tahun){

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
      return $this->db->get()->row();

    }
  //get nama pns
  function getpns($nip){
      $this->db->where('nip', $nip);
      return $this->db->get($this->tab_pns)->row();
    }
  /*struktur*/
    function struktur($id){
      $this->db->select('tab_struktur.id,parent,tab_struktur.nama as name,tab_pns.nama as title,ikon as className');
      $this->db->from('tab_pns');
      $this->db->join('tab_struktur', 'tab_pns.nip = tab_struktur.nip');
      $this->db->where('tab_struktur.id_unit', $id);


      return $this->db->get()->result_array();
    }

  /*all json Datatables*/
  // function opdentri_baru($thn){
  //
  //   $this->datatables->select('`daftunit`.`unitkey`
  //   , `daftunit`.`nmunit`
  //   , `tab_pptk_master`.`stat`');
  //   $this->datatables->from('`tab_pptk_master`');
  //   $this->datatables->join('`daftunit`', '`tab_pptk_master`.`unitkey` = `daftunit`.`unitkey` and `tab_pptk_master`.`tahun`="'.$thn.'"','right');
  //   $this->datatables->where('`daftunit`.`tahun`', $thn);
  //   $this->db->order_by('`daftunit`.`nmunit`', 'ASC');
  //   $this->datatables->add_column('action', '<button class="entriact btn btn-social btn-fill btn-twitter">
  //                                               <i class="fa fa-recycle"></i> Proses
  //                                           <div class="ripple-container"></div></button>' );
  //
  //   return $this->datatables->generate();
  // }
  function opdentri_baru($thn){

    $this->datatables->select('`daftunit`.`unitkey`
    , `daftunit`.`nmunit`
    , `tab_pptk_master`.`stat`');
    $this->datatables->from('`tab_pptk_master`');
    $this->datatables->join('`daftunit`', '`tab_pptk_master`.`unitkey` = `daftunit`.`unitkey` and `tab_pptk_master`.`tahun`="'.$thn.'"','right');
    $this->datatables->where('`daftunit`.`tahun`', $thn);
    $this->db->order_by('`daftunit`.`nmunit`', 'ASC');
    $this->datatables->add_column('action', '<button class="entriact btn btn-social btn-fill btn-twitter">
                                                <i class="fa fa-recycle"></i> Proses
                                            <div class="ripple-container"></div></button>' );

    return $this->datatables->generate();
  }
  function jsonuserlist_by($opd)
    {
        $this->datatables->select('`tab_pns`.`id`
        , `tab_pns`.`nip`
        , `tab_pns`.`nama`
        , `tab_jabatan`.`nama_jabatan`
        , `tab_eselon`.`nama_eselon`
        , `tab_pangkat`.`nama_pangkat`
        , `tab_pangkat`.`golongan`
        , `users`.`active`');
        $this->datatables->from('`users`');
        $this->datatables->join('`tab_pns`', '`users`.`username` = `tab_pns`.`nip`','right');
        $this->datatables->join('`tab_jabatan`', '`tab_pns`.`id_jabatan` = `tab_jabatan`.`id_jabatan`');
        $this->datatables->join('`tab_eselon`', '`tab_jabatan`.`id_eselon` = `tab_eselon`.`id`');
        $this->datatables->join('`tab_pangkat`', '`tab_pns`.`id_pangkat` = `tab_pangkat`.`id_pangkat`');
        $this->datatables->where('`tab_pns`.`unitkey`', $opd);
        $this->datatables->where('`tab_pns`.`status`', '1');
        $this->datatables->where('`tab_pns`.`asn`', '1');
        $this->db->order_by('`tab_eselon`.`nama_eselon`', 'ASC');
        $this->datatables->add_column('action', '<button class="opduserpass btn btn-danger">Password<div class="ripple-container"></div></button> <button class="opduserinfo btn btn-info">Info<div class="ripple-container"></div></button>' );

        return $this->datatables->generate();


       /* SELECT
    `tab_pns`.`id`
    , `tab_pns`.`nip`
    , `tab_pns`.`nama`
    , `tab_jabatan`.`nama_jabatan`
    , `tab_eselon`.`nama_eselon`
    , `tab_pangkat`.`nama_pangkat`
    , `tab_pangkat`.`golongan`
    , `users`.`active`
FROM
    `users`
    RIGHT JOIN `tab_pns`
        ON (`users`.`username` = `tab_pns`.`nip`)
    INNER JOIN `tab_jabatan`
        ON (`tab_pns`.`id_jabatan` = `tab_jabatan`.`id_jabatan`)
    INNER JOIN `tab_eselon`
        ON (`tab_jabatan`.`id_eselon` = `tab_eselon`.`id`)
    INNER JOIN `tab_pangkat`
        ON (`tab_pns`.`id_pangkat` = `tab_pangkat`.`id_pangkat`);*/
    }
  function jsonuseropd()
    {
        $this->datatables->select('unitkey,nmunit');
        $this->datatables->from($this->mopd);
       $this->datatables->add_column('action', '<button type="button" rel="tooltip" class="btnopduser btn btn-info" data-original-title="" title=""><i class="material-icons">launch</i><div class="ripple-container"></div></button>' );

        return $this->datatables->generate();
    }
   function jsonopd($thn)
    {

        $this->datatables->select('unitkey,nmunit');
        $this->datatables->where('tahun', $thn);
        $this->datatables->from($this->mopd);
        $this->datatables->add_column('action', '<div class="row" >
                                                <div class="col-lg-6 col-md-12 col-sm-6">
                                                    <div class="dropdown" >
                                                        <button href="javascript:void(0)" class="dropdown-toggle btn btn-primary btn-round btn-block"  data-toggle="dropdown">Sinkron
                                                            <b class="caret"></b>
                                                        <div class="ripple-container"></div></button>
                                                        <ul class="dropdown-menu dropdown-menu-left">
                                                            <li class="dropdown-header">DATA SIPKD</li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="sdpa22">DPA 2.2.</a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="sdpa221">DPA 2.2.1.</a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="sangkas">ALIRAN KAS</a>
                                                            </li>



                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-sm-6">
                                                    <div class="dropdown">
                                                        <button href="javascript:void(0)" class="dropdown-toggle btn btn-primary btn-round btn-block" data-toggle="dropdown">Lihat
                                                            <b class="caret"></b>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-left">
                                                            <li class="dropdown-header">DATA OPD</li>
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="ldpa22">DPA 2.2.</a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="ldpa221">DPA 2.2.1.</a>
                                                            </li>
                                                              <li class="divider"></li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="langkas">ALIRAN KAS</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>' );
        return $this->datatables->generate();
    }
    function jsonprogram($thn)
    {
        $this->datatables->select('IDPRGRM,NMPRGRM');
        $this->datatables->where('tahun', $thn);
        $this->datatables->from($this->mprogram);
        $this->datatables->add_column('action', '<button type="button" rel="tooltip" class="btn btn-info" data-original-title="" title=""><i class="material-icons">launch</i><div class="ripple-container"></div></button>' );

        return $this->datatables->generate();
    }
    function jsonkegiatan($thn)
    {
        $this->datatables->select('NMPRGRM,kdkegunit,nmkegunit');
        $this->datatables->where('mkegiatan.tahun', $thn);
        $this->datatables->where('mpgrm.tahun', $thn);
        $this->datatables->from($this->mkegiatan);
        $this->datatables->join('mpgrm', 'mpgrm.IDPRGRM = mkegiatan.idprgrm');

        return $this->datatables->generate();
    }
    function jsonanggaran($thn)
    {
        $this->datatables->select('mtgkey,kdper,nmper,tahun');
        $this->datatables->where('tahun', $thn);
        $this->datatables->from($this->manggaran);



        return $this->datatables->generate();
    }
    function jsonopddpa()
    {
        $this->datatables->select('unitkey,nmunit');
        $this->datatables->from($this->mopd);
       $this->datatables->add_column('action', '<button type="button" rel="tooltip" class="btndpa btn btn-info" data-original-title="" title=""><i class="material-icons">launch</i><div class="ripple-container"></div></button>' );

        return $this->datatables->generate();
    }

    /*Batas All JSON Datatables*/


    function detopd_dpa($thn,$id){
      $this->db->select('dpa22.unitkey,nmunit,dpa22.tahun');
      $this->db->from('dpa22');
      $this->db->join('daftunit', 'dpa22.unitkey = daftunit.unitkey');
      $this->db->where('dpa22.tahun', $thn);
      $this->db->where('dpa22.unitkey', $id);
      $this->db->group_by('unitkey');
      return $this->db->get()->row();
    }
    //$^%&&*_agung
    function detprogram_dpa($thn,$id){
      $this->db->select('dpa22.kdkegunit,mpgrm.IDPRGRM,mpgrm.NMPRGRM, SUM(nilai) AS nilai_prgrm');
      $this->db->from('mkegiatan');
      $this->db->join('mpgrm', 'mkegiatan.idprgrm = mpgrm.IDPRGRM');
      $this->db->join('dpa22', 'dpa22.kdkegunit = mkegiatan.kdkegunit');
      $this->db->where('dpa22.tahun', $thn);
      $this->db->where('dpa22.unitkey', $id);
      $this->db->group_by('mpgrm.IDPRGRM');
      return $this->db->get()->result();


//       SELECT
//     `dpa22`.`kdkegunit`
//     , `mpgrm`.`IDPRGRM`
//     , `mpgrm`.`NMPRGRM`
// FROM
//     `mkegiatan`
//     INNER JOIN `mpgrm`
//         ON (`mkegiatan`.`idprgrm` = `mpgrm`.`IDPRGRM`)
//     INNER JOIN `dpa22`
//         ON (`dpa22`.`kdkegunit` = `mkegiatan`.`kdkegunit`) WHERE `dpa22`.`tahun`='2018' AND `dpa22`.`unitkey`='80_' GROUP BY `mpgrm`.`IDPRGRM`;
    }

    function getkegiatan_by($idopd,$thn,$idprog){
      $this->db->select('dpa22.kdkegunit,mkegiatan.nmkegunit');
      $this->db->from('dpa22');
      $this->db->join('daftunit', 'dpa22.unitkey = daftunit.unitkey');
      $this->db->join('mkegiatan', 'dpa22.kdkegunit = mkegiatan.kdkegunit');
      $this->db->join('mpgrm', 'mkegiatan.idprgrm = mpgrm.IDPRGRM');
      $this->db->where('dpa22.tahun', $thn);
      $this->db->where('dpa22.unitkey', $idopd);
      $this->db->where('mpgrm.IDPRGRM', $idprog);
      $this->db->group_by('dpa22.kdkegunit');
      return $this->db->get()->result();
    }
    function getmasalah_by($idopd,$bln,$idkeg){
      $this->db->select('`tab_realisasi`.`permasalahan`
                        , `mkegiatan`.`nmkegunit` AS `nm_kegiatan`
                        , `tab_realisasi`.`real_bulan`
                        , `tab_pptk`.`kdkegunit`');
      $this->db->from('tab_pptk');
      $this->db->join('tab_pptk_master', '`tab_pptk`.`id_pptk_master` = `tab_pptk_master`.`id`');
      $this->db->join('tab_realisasi', '`tab_realisasi`.`id_tabpptk` = `tab_pptk`.`id`');
      $this->db->join('mkegiatan', '`mkegiatan`.`kdkegunit` = `tab_pptk`.`kdkegunit`');
      $this->db->where('`tab_pptk_master`.`unitkey`', $idopd);
      $this->db->where('MONTH(`tab_realisasi`.`real_bulan`)', $bln);
      $this->db->where('`tab_pptk`.`kdkegunit`', $idkeg);
      return $this->db->get();
    }
    //agungagung!@$%&^!%



  function adddpa21(){
    $thn='2018';
    $json_string = 'http://192.168.10.5:8080/dpa21/22384ee59631a5a61ce3386af63c094b/'.$thn;
		$jsondata = file_get_contents($json_string);
		$obj = json_decode($jsondata, true);
		foreach ($obj['DATA'] as $row) {
			$data[] = array(
	                  "nilai"  =>  $row['NILAI'],
	                  "mtgkey"    =>  $row['MTGKEY'],
					          "unitkey"    =>  $row['UNITKEY'],
                    "tahun" => $thn
	          );
		}
    $this->db->trans_start();
    $this->db->insert_batch('dpa21', $data);
    $this->db->trans_complete();
    return ($this->db->affected_rows()!=1)?false:true;
  }

  function adddpa211(){
    $thn='2018';
    $json_string = 'http://192.168.10.5:8080/dpa211/22384ee59631a5a61ce3386af63c094b/'.$thn;
		$jsondata = file_get_contents($json_string);
		$obj = json_decode($jsondata, true);
		foreach ($obj['DATA'] as $row) {
			$data[] = array(
	                  "satuan"  =>  $row['SATUAN'],
	                  "subtotal"    =>  $row['SUBTOTAL'],
					          "mtgkey"    =>  $row['MTGKEY'],
					          "jumbyek"    =>  $row['JUMBYEK'],
					          "unitkey"    =>  $row['UNITKEY'],
					          "uraian"    =>  $row['URAIAN'],
					          "tarif"    =>  $row['TARIF'],
					          "kdjabar"    =>  $row['KDJABAR'],
					          "type"    =>  $row['TYPE'],
                    "tahun" => $thn
	          );
		}
    $this->db->trans_start();
    $this->db->insert_batch('dpa211', $data);
    $this->db->trans_complete();
    return ($this->db->affected_rows()!=1)?false:true;
  }


  function getdaftunit(){
     $this->db->where('unitkey !=', '40_');
      $this->db->where('unitkey !=', '98_');
    return $this->db->get('daftunit')->result();
  }






  public function jika_prgrm($idprgrm, $nmprgrm){

        $data = $this->db->get_where('mpgrm', array('idprgrm' => $idprgrm, 'nmprgrm' => $nmprgrm))->row();
        return $data;
    }

  public function jika_daftunit($unitkey, $nmunit){

        $data = $this->db->get_where('daftunit', array('unitkey' => $unitkey, 'nmunit' => $nmunit))->row();
        return $data;
    }

  public function jika_kegiatan($nmkegunit, $kdkegunit, $idprgrm){

        $data = $this->db->get_where('mkegiatan', array('nmkegunit' => $namakegunit, 'kdkegunit' => $kdkegunit, 'idprgrm' => $idprgrm))->row();
        return $data;
    }

  public function jika_dpa21($nilai, $mtgkey, $unitkey){

        $data = $this->db->get_where('dpa21', array('nilai' => $nilai, 'mtgkey' => $mtgkey, 'unitkey' => $unitkey))->row();
        return $data;
    }

  public function jika_dpa22($nilai, $kdkegunit, $mtgkey, $unitkey){

        $data = $this->db->get_where('dpa22', array('nilai' => $nilai, 'kdkegunit' => $kdkegunit, 'mtgkey' => $mtgkey, 'unitkey' => $unitkey))->row();
        return $data;
    }
  public function jika_angkas($unitkey, $kdkegunit ,$kd_bulan, $nilai, $mtgkey){

        $data = $this->db->get_where('angkas', array('unitkey' => $unitkey, 'kdkegunit' => $kdkegunit, 'kd_bulan' => $kd_bulan, 'nilai' => $nilai, 'mtgkey' => $mtgkey, 'unitkey' => $unitkey))->row();
        return $data;
    }
  public function jika_dpa221($satuan, $subtotal ,$kdkegunit, $mtgkey, $jumbyek, $unitkey, $uraian, $tarif, $kdjabar, $type){

        $data = $this->db->get_where('dpa221', array('satuan' => $satuan, 'subtotal' => $subtotal, 'kdkegunit' => $kdkegunit, 'mtgkey' => $mtgkey, 'jumbyek' => $jumbyek, 'unitkey' => $unitkey, 'uraian' => $uraian, 'tarif' => $tarif, 'kdjabar' => $kdjabar, 'type' => $type))->row();
        return $data;
    }
  /*********Agung-Agung-Agung-Agung-Agung-Agung-Agung-Agung-*/
  public function getkeuangan_sampai($bln){
     $this->db->select("`angkas`.`id`
                      , `angkas`.`unitkey`
                      , daftunit.`nmunit`
                      , `angkas`.`kdkegunit`
                      , `angkas`.`kd_bulan`
                      , `angkas`.`nilai`
                      , `angkas`.`mtgkey`
                      , `angkas`.`tahun`
                      , SUM(`angkas`.`nilai`) AS pagu_dana
                      , SUM(CASE WHEN `angkas`.kd_bulan <='$bln' THEN nilai ELSE 0 END) AS targetKeu
                      , SUM(CASE WHEN `angkas`.kd_bulan <='$bln' THEN nilai ELSE 0 END) / SUM(`angkas`.`nilai`) * 100 AS persenTarKeu");
      $this->db->from('`angkas`');
      $this->db->join('daftunit', '`angkas`.`unitkey` = `daftunit`.`unitkey`');
      $this->db->where('`angkas`.`kdkegunit` !=', '0_');
       $this->db->group_by('`angkas`.unitkey');
       $this->db->order_by('daftunit.`nmunit`');
      return $this->db->get()->result();
  }
  public function getrealisasikeu(){
    $this->db->select("daftunit.`unitkey`
                      , `daftunit`.`nmunit`
                      , `tab_pptk_master`.id as idpptkmaster
                      , `tab_pptk_master`.*
                      ,SUM(tab_realisasi_det.`jumlah_harga`) AS realisasi_keu");
      $this->db->from('`tab_pptk_master`');
      $this->db->join('daftunit', '`tab_pptk_master`.`unitkey` = `daftunit`.`unitkey`', 'right');
      $this->db->join('tab_pptk', '`tab_pptk`.`id_pptk_master` = `tab_pptk_master`.`id`', 'left');
      $this->db->join('tab_realisasi', '`tab_realisasi`.`id_tabpptk` = `tab_pptk`.`id`', 'left');
      $this->db->join('tab_realisasi_det', '`tab_realisasi`.`id` = `tab_realisasi_det`.`id_tab_realisasi` ', 'left');
      $this->db->where("daftunit.`unitkey` NOT IN ('55_','40_','98_')");
      $this->db->group_by('daftunit.`unitkey`');
      $this->db->order_by('daftunit.`nmunit`');
      return $this->db->get()->result();
  }
  public function getrealisasifis(){
    $this->db->select("SUM(tab_realisasi.`bobot_real`) AS realisasi_fis");
      $this->db->from('`tab_pptk_master`');
      $this->db->join('daftunit', '`tab_pptk_master`.`unitkey` = `daftunit`.`unitkey`', 'right');
      $this->db->join('tab_pptk', '`tab_pptk`.`id_pptk_master` = `tab_pptk_master`.`id`', 'left');
      $this->db->join('tab_realisasi', '`tab_realisasi`.`id_tabpptk` = `tab_pptk`.`id`', 'left');
      $this->db->where("daftunit.`unitkey` NOT IN ('55_','40_','98_')");
      $this->db->group_by('daftunit.`unitkey`');
      $this->db->order_by('daftunit.`nmunit`');
      return $this->db->get()->result();
  }
  public function getfisik($bulan){

      $arrbulan = array('jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des');
      $sum='sum(';
      for($i=0;$i<$bulan;$i++){
        if($i==0)
        $sum.= 'length('.$arrbulan[$i].')';
        else
        $sum.= '+length('.$arrbulan[$i].')';
      }
      $sum.=')';
      // var_dump($sum);exit();
      $this->db->select("daftunit.`unitkey`
                        ,daftunit.`nmunit`
                        ,coalesce(($sum / SUM(LENGTH(jan)+LENGTH(feb)+LENGTH(mar)
                        +LENGTH(apr)+LENGTH(mei)+LENGTH(jun)
                        +LENGTH(jul)+LENGTH(ags)+LENGTH(sep)
                        +LENGTH(okt)+LENGTH(nov)+LENGTH(des)) * 100),'Belum Ada KAK') as targetbulanini
                      ,  `tab_schedule`.*
                        ");
      $this->db->from('tab_schedule');
      $this->db->join('`tab_kak`', '`tab_schedule`.`id_tab_kak` = `tab_kak`.`id`');
      $this->db->join('`tab_pptk`', '`tab_kak`.`idtab_pptk` = `tab_pptk`.`id`');
      $this->db->join('`tab_pptk_master`', '`tab_pptk`.`id_pptk_master` = `tab_pptk_master`.`id`');
      $this->db->join('`daftunit`', 'tab_pptk_master.`unitkey` = `daftunit`.`unitkey`','right');
      $this->db->where("daftunit.`unitkey` NOT IN ('55_','40_','98_')");
      $this->db->group_by('`daftunit`.`unitkey`');

      $this->db->order_by('daftunit.`nmunit`');

      // echo json_encode ($this->db->get()->result()); exit;
      return $this->db->get()->result();

  }
  /*Agung-Agung-Agung-Agung-Agung-Agung-Agung-Agung-************/

  /*///////// Agung 29-11-2018Agung 29-11-2018Agung 29-11-2018Agung 29-11-2018Agung 29-11-2018*/
  //rekap belanja modal per opd
  function getkeuangan_bModal_smpai($bln){
    $this->db->select("
    `daftunit`.`unitkey`
    , `daftunit`.`nmunit`
    , `matangr`.`mtgkey`
    , `matangr`.`nmper`
    , `matangr`.`kdper`
    , `angkas`.`kd_bulan`
    , `angkas`.`nilai`
    , `angkas`.`kdkegunit`
    , SUM(`angkas`.`nilai`) AS pagu_b_modal
    , SUM(CASE WHEN `angkas`.kd_bulan <='$bln' THEN nilai ELSE 0 END) AS targetKeu
    , SUM(CASE WHEN `angkas`.kd_bulan <='$bln' THEN nilai ELSE 0 END) / SUM(`angkas`.`nilai`) * 100 AS persenTarKeu
    ");
    $this->db->from('matangr');
    $this->db->join('`angkas`', '`matangr`.`mtgkey` = `angkas`.`mtgkey`');
    $this->db->join('`daftunit`', '`daftunit`.`unitkey` = `angkas`.`unitkey`');
    $this->db->where("`matangr`.`kdper` LIKE '%5.2.3.%'");
    $this->db->group_by('`daftunit`.`unitkey`');
    $this->db->order_by('daftunit.`nmunit`');
    return $this->db->get()->result();
  }
  function getrealisasi_bModal(){
    $this->db->select("
    daftunit.`unitkey`
      , `daftunit`.`nmunit`
      , `tab_pptk_master`.*
      ,COALESCE((SUM(tab_realisasi_bmodal.`nilai_ktrk`)),0) AS realisasi_keu
      ,COALESCE((SUM(tab_realisasi_bmodal_det.`realfisik_bljmodal`) / COUNT(tab_realisasi_bmodal_det.`realfisik_bljmodal`)),0) AS realisasi_fis
    ");
    $this->db->from('tab_pptk_master');
    $this->db->join('`daftunit`', '`tab_pptk_master`.`unitkey` = `daftunit`.`unitkey`','right');
    $this->db->join('`tab_pptk`', '`tab_pptk`.`id_pptk_master` = `tab_pptk_master`.`id`','left');
    $this->db->join('`tab_realisasi_bmodal`', '`tab_realisasi_bmodal`.`id_tab_pptk` = `tab_pptk`.`id`','left');
    $this->db->join('`tab_realisasi_bmodal_det`', 'tab_realisasi_bmodal_det.id_tab_real_bmodal = tab_realisasi_bmodal.id','left');
    $this->db->where("daftunit.`unitkey` NOT IN ('50_','55_','40_','86_','98_')");
    $this->db->group_by('daftunit.`unitkey`');
    $this->db->order_by('daftunit.`nmunit`');
    return $this->db->get()->result();
  }
  function getrealisasi_bModal_by($idpptkmaster){
    $this->db->select("SUM(tab_realisasi_bmodal.`nilai_ktrk`) AS realisasi_keu

    ");
    $this->db->from('tab_realisasi_bmodal');
    $this->db->join('`tab_pptk`', '`tab_realisasi_bmodal`.`id_tab_pptk` = `tab_pptk`.`id`');
    $this->db->join('`tab_pptk_master`', '`tab_pptk_master`.`id` = `tab_pptk`.`id_pptk_master`');
    $this->db->where("tab_pptk_master.`id`",$idpptkmaster);
    return $this->db->get()->row();
  }
  public function getfisik_bmodal($bulan){

      $arrbulan = array('jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des');
      $sum='(';

      for($i=0;$i<$bulan;$i++){
        if($i==0)
        $sum.= 'sum('.$arrbulan[$i].')';
        else
        $sum.= '+sum('.$arrbulan[$i].')';
      }
      $sum.=')';
      // var_dump($sum);exit();
      $this->db->select("`daftunit`.`unitkey`
                        , `daftunit`.`nmunit`
                        , `tab_schedule_blnj_mdl`.id AS id_schedule
                        , `tab_schedule_blnj_mdl`.`id_tab_target`
                        ,coalesce((($sum /
                        (COALESCE((SUM(jan)),0)+COALESCE((SUM(feb)),0)+COALESCE((SUM(mar)),0)
                        +COALESCE((SUM(apr)),0)+COALESCE((SUM(mei)),0)+COALESCE((SUM(jun)),0)
                        +COALESCE((SUM(jul)),0)+COALESCE((SUM(ags)),0)+COALESCE((SUM(sep)),0)
                        +COALESCE((SUM(okt)),0)+COALESCE((SUM(nov)),0)+COALESCE((SUM(des)),0))) * 100),'0') as targetfis
                        ");
      $this->db->from('tab_pptk');
      $this->db->join('`tab_target_blnj_modal`', '`tab_pptk`.`id` = `tab_target_blnj_modal`.`idtab_pptk`');
      $this->db->join('`tab_schedule_blnj_mdl`', '`tab_schedule_blnj_mdl`.`id_tab_target` = `tab_target_blnj_modal`.`id`');
      $this->db->join('`tab_pptk_master`', '`tab_pptk_master`.`id` = `tab_pptk`.`id_pptk_master`');
      $this->db->join('`daftunit`', '`daftunit`.`unitkey` = `tab_pptk_master`.`unitkey`','right');
      $this->db->where("daftunit.`unitkey` NOT IN ('50_','55_','40_','86_','98_')");
      $this->db->group_by('`daftunit`.`unitkey`');
      $this->db->order_by('daftunit.`nmunit`');
      return $this->db->get()->result();

  }

  public function gettargetkota_now(){
    $this->db->select('SUM(nilai) AS target,kd_bulan');
    $this->db->from('angkas');
    $this->db->where('kd_bulan <= MONTH(NOW())');
    $this->db->group_by('kd_bulan');

    return $this->db->get()->result();
  }
  public function getrealnonmodalkota_now(){
    $this->db->select('SUM(`tab_realisasi_det`.`jumlah_harga`) as realisasi
                      , MONTH(`tab_realisasi`.`real_bulan`) AS bulan');
    $this->db->from('tab_realisasi_det');
    $this->db->join('`tab_realisasi`', '`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`');
    $this->db->where('MONTH(`tab_realisasi`.`real_bulan`) <= MONTH(NOW())');
    $this->db->group_by('bulan');

    return $this->db->get()->result();
  }
  public function getrealmodalkota_now(){
    $this->db->select('SUM(nilai_ktrk) AS realmodal,MONTH(`tab_realisasi_bmodal`.`real_bulan`) as kd_bulan');
    $this->db->from('tab_realisasi_bmodal');
    $this->db->where('MONTH(`tab_realisasi_bmodal`.`real_bulan`) <= MONTH(NOW())');
    $this->db->group_by('kd_bulan');

    return $this->db->get()->result();
  }
  public function getpagukota(){
    $this->db->select('SUM(nilai) AS pagu');
    $this->db->from('angkas');

    return $this->db->get()->row()->pagu;
  }
  /* Agung 29-11-2018Agung 29-11-2018Agung 29-11-2018Agung 29-11-2018Agung 29-11-2018//////////////*/
}
