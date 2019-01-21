<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends MX_Controller
{
    //function admingeneral= kasubag
    //function general= PPK/PPTK/KADIS/ASISTEN/SEKDA dan WAKO
    public $data;
    public $tahunskr;
    public function __construct()
    {
        parent::__construct();
      //  $this->tahunskr =$this->tahunskr;
        $this->tahunskr ='2019';
        $this->load->model(array('User_model'));
        $this->load->library(array('ion_auth','upload'));
    }

    function gettoken(){
      $arr['data'][]= array(
          'token' => $this->security->get_csrf_hash()
      );
      header('Content-Type: application/json');
      echo json_encode($arr);
    }

    public function index(){
    	if (!$this->ion_auth->logged_in()){
            redirect('Home/login', 'refresh');
        }elseif ($this->ion_auth->is_admin()){
            redirect('Cpanel', 'refresh');
        }elseif ($this->ion_auth->is_walikota()){
            redirect('Cpanel', 'refresh');
        }elseif ($this->ion_auth->is_kasubag()){
            redirect('User/admingeneral', 'refresh');
        }elseif ($this->ion_auth->is_kasubprogram()){
          // redirect('User/admingeneral', 'refresh');

          redirect('User/kasubprogram', 'refresh');
        }else{
            redirect('User/general', 'refresh');
        }
    }

    function kasubprogram(){
      if (!$this->ion_auth->logged_in()){
            redirect('Home/login', 'refresh');
      }elseif (!$this->ion_auth->is_kasubprogram()){
          redirect('User', 'refresh');
      }else{
        $nip=$this->ion_auth->user()->row()->username;
        // $rowunit=$this->User_model->getpns($nip);
        // $idunit=$rowunit->unitkey;
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        $this->data= array(

            'nmopd'     => $namaopd,
            'tahun'     => $this->tahunskr,
            'idopd'     =>  $idopd
        );
        $this->template->load('templatenew','dasboard_kasubprogram',$this->data);
      }

    }

    function admingeneral(){
    	if (!$this->ion_auth->logged_in()){
            redirect('Home/login', 'refresh');
        }elseif ($this->ion_auth->is_admin()){
            redirect('Cpanel', 'refresh');
        }elseif ($this->ion_auth->is_kasubprogram()){
          // redirect('User/admingeneral', 'refresh');
            redirect('User/kasubprogram', 'refresh');
        }elseif ($this->ion_auth->is_kasubag()){
        	// Dari kontroller ini , pertama cek tb_struktur (struktur organisasi) pada OPD atau unit terkait
        	// jika belum ada struktur , entri struktur organisasi terlebih dahulu(penting)
        	// apabila sudah pernah mengentrikan struktur kemudian redirect ke halaman kasubag
            $nip=$this->ion_auth->user()->row()->username;
            // $rowunit=$this->User_model->getpns($nip);
            // $idunit=$rowunit->unitkey;
            $getopd = $this->User_model->getnamaopd($nip);
            $idopd =$getopd->unitkey;
            $namaopd=$getopd->nmunit;
            $this->data= array(

                'nmopd'     => $namaopd,
                'tahun'     => $this->tahunskr,
                'idopd'     =>  $idopd
            );
            $this->template->load('templatenew','dashboard_admin',$this->data);

        }else{
            redirect('User/general', 'refresh');
        }
    }

    // function tessss($opd){
    //   $keg = $this->User_model->getallkegiatan($opd);
    //   $real = $this->User_model->getdatarealisasi_by(2);
    //   echo json_encode($real);
    // }

    function general(){
    	if (!$this->ion_auth->logged_in()){
            redirect('Home/login', 'refresh');
        }elseif ($this->ion_auth->is_admin()){
            redirect('Cpanel', 'refresh');
        }elseif ($this->ion_auth->is_kasubprogram()){
          // redirect('User/admingeneral', 'refresh');
          echo 'kasubag program';
        }elseif ($this->ion_auth->is_kasubag()){
            redirect('User/admingeneral', 'refresh');
        }else{
        	/*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
            $nip=$this->ion_auth->user()->row()->username;
            //echo $nip;
            $struktur = $this->User_model->cekstrukturpns($nip);
            $getopd = $this->User_model->getnamaopd($nip);
            $idopd =$getopd->unitkey;
            $namaopd=$getopd->nmunit;
            if($struktur ){
                $peran=$struktur->peran;
                // echo $peran;exit;
                if($peran=='1'){
                    /*jika peran 1 maka Kadis*/
                    $lskeg = $this->User_model->getdetlistkegiatan_ppk($nip);
                    $unitkeyuser = $this->User_model->getunitkeyppk($nip); // id opd user yg login
                    $idstruktur = $this->User_model->getidstruktur($nip);
                    $data = $this->User_model->getdatappk($unitkeyuser, $nip);
                    $pgthn = $this->User_model->anggaranopd($unitkeyuser)->anggranopd;
                    // var_dump($pgthn);exit;
                    $angkas = $this->User_model->getangkasopdhinggabulanini($unitkeyuser);
                    $realnonmodal = $this->User_model->gettotalrealisasiopd($unitkeyuser,$idstruktur); //total realisasi hingga bulan sebelumnya
                    // var_dump($realnonmodal);exit;
                    $realmodal = $this->User_model->getrealisasi_bModal_opd($unitkeyuser,$idstruktur); //total realisasi hingga bulan sebelumnya
                    $totreal = $realnonmodal + $realmodal;
                    $angkasbulanini = $this->User_model->getangkasOPDbulanini($unitkeyuser) + (($angkas - $this->User_model->getangkasOPDbulanini($unitkeyuser)) - $totreal);
                    $detangkasbulanini = $this->User_model->getdetangkasOPDbulanini($unitkeyuser);
                    $persenrealisasibulanini = ($totreal / $pgthn) * 100;
                    $lspptk = $this->User_model->getnippptkopd($unitkeyuser);

                    // var_dump($lspptk).exit;
                    //echo $this->template->rupiah($pgthn);
                    // var_dump($this->User_model->getdetrealbmodalbiOPD($this->User_model->getidstrukturppk($nip),$unitkeyuser)).exit;
                    //echo json_encode($this->User_model->getdataschedule($nip));
                    $this->data = array(
                        'idopd' => $idopd,
                        'nmopd' => $namaopd,
                        'tahun' => $this->tahunskr,
                        'list' => $lskeg,
                        'pagu_tahun' => $this->template->rupiah($pgthn),
                        'angkas_bulan' => $this->template->rupiah($angkas),
                        'angkas_bulan_ini' => $this->template->rupiah($angkasbulanini),
                        'det_angkas_bulan_ini' => $detangkasbulanini,
                        'det_angkas_satu_tahun' => $this->User_model->getdetangkasOPDsatutahun($unitkeyuser),
                        'persen_realisasi' => round($persenrealisasibulanini, 2) . ' %',
                        'lspptk' => $lspptk,
                        'kegiatan' => $this->User_model->getallkegiatan($unitkeyuser),
                        'data_realisasi' => $this->User_model->getdatarealisasi_by($idstruktur), //data realisasi bulan ini
                        'data_realisasi_hbs' => $this->User_model->getdatarealisasiOPDhbs($nip), //data realisasi hingga bulan sebelumnya
                        'data_angkas_hbs' => $this->User_model->getdetangkasOPDhbs($unitkeyuser), //data angkas hingga bulan sebelumnya
                        'data_schedule' => $this->User_model->getdatascheduleOPD($unitkeyuser), //data schedule satu tahun
                        'data_real_fisik' => $this->User_model->getrealfisikOPD($idstruktur), //data realisasi fisik bulan ini
                        'det_real_bmodalbi' => $this->User_model->getdetrealbmodalbiOPD($this->User_model->getidstrukturppk($nip),$unitkeyuser) //detail realisasi belanja modal bulan ini
                    );
                    $this->template->load('templatenew', 'dashboard_kadis', $this->data);
                }elseif($peran=='2'){
                    /*jika peran 2 maka PPK*/
                    $lskeg = $this->User_model->getdetlistkegiatan_ppk($nip);
                    $unitkeyppk = $this->User_model->getunitkeyppk($nip);
                    $data = $this->User_model->getdatappk($unitkeyppk, $nip);
                    $pgthn = $this->User_model->getpagutahun($nip,$unitkeyppk);
                    $angkas = $this->User_model->getangkashinggabulanini($nip,$unitkeyppk);
                    $totreal = $this->User_model->gettotalrealisasi($nip); //total realisasi hingga bulan sebelumnya
                    $totrealbmodalhbs = $this->User_model->gettotalrealbmodalhbs($this->User_model->getidstrukturppk($nip)); //total realisasi belanja modal hingga bulan sebelumnya
                    $totrealbmodalbi = $this->User_model->gettotalrealbmodalbi($this->User_model->getidstrukturppk($nip)); //total realisasi belanja modal bulan ini
                    $angkasbulanini = $this->User_model->getangkasbulanini($nip,$unitkeyppk) + (($angkas - $this->User_model->getangkasbulanini($nip,$unitkeyppk)) - $totreal - $totrealbmodalhbs);
                    $detangkasbulanini = $this->User_model->getdetangkasbulanini($nip,$unitkeyppk);
                    $realisasibulanini = ($this->User_model->getrealisasibulanini($this->User_model->getidstrukturppk($nip)))+$totrealbmodalbi;
                    $persenrealisasibulanini = ($realisasibulanini / $angkasbulanini) * 100;
                    $lspptk = $this->User_model->getnipstrukturpptk($this->User_model->getidstrukturppk($nip));
                    //var_dump($detangkasbulanini).exit;
                    //echo $this->template->rupiah($pgthn);
                    // var_dump($this->User_model->getdetrealbmodalbi($this->User_model->getidstrukturppk($nip),$unitkeyppk)).exit;
                    //echo json_encode($this->User_model->getdataschedule($nip));
                    $this->data = array(
                        'idopd' => $idopd,
                        'nmopd' => $namaopd,
                        'tahun' => $this->tahunskr,
                        'list' => $lskeg,
                        'pagu_tahun' => $this->template->rupiah($pgthn),
                        'angkas_bulan' => $this->template->rupiah($angkas),
                        'angkas_bulan_ini' => $this->template->rupiah($angkasbulanini),
                        'det_angkas_bulan_ini' => $detangkasbulanini,
                        'det_angkas_satu_tahun' => $this->User_model->getdetangkassatutahun($nip,$unitkeyppk),
                        'realisasi_bulan_ini' => $this->template->rupiah($realisasibulanini),
                        'persen_realisasi' => round($persenrealisasibulanini, 2) . ' %',
                        'lspptk' => $lspptk,
                        'kegiatan' => $this->User_model->getkegiatan($nip),
                        'data_realisasi' => $this->User_model->getdatarealisasi($nip), //data realisasi bulan ini
                        'data_realisasi_hbs' => $this->User_model->getdatarealisasihbs($nip), //data realisasi hingga bulan sebelumnya
                        'data_angkas_hbs' => $this->User_model->getdetangkashbs($nip,$unitkeyppk), //data angkas hingga bulan sebelumnya
                        'data_schedule' => $this->User_model->getdataschedule($nip), //data schedule satu tahun
                        'data_real_fisik' => $this->User_model->getrealfisik($nip), //data realisasi fisik bulan ini
                        'det_real_bmodalbi' => $this->User_model->getdetrealbmodalbi($this->User_model->getidstrukturppk($nip),$unitkeyppk), //detail realisasi belanja modal bulan ini
                    );
                    $this->template->load('templatenew', 'dashboard_ppk', $this->data);

                }
                // elseif($peran=='6'){
                //     /*jika peran 6 maka Sekretaris*/
                //
                //     $lskeg = $this->User_model->getdetlistkegiatan_ppk($nip);
                //     $unitkeyppk = $this->User_model->getunitkeyppk($nip);
                //     // $data = $this->User_model->getdatappk($unitkeyppk, $nip);
                //     $pgthn = $this->User_model->getpagutahun($nip,$unitkeyppk);
                //     $angkas = $this->User_model->getangkashinggabulanini($nip,$unitkeyppk);
                //     $totreal = $this->User_model->gettotalrealisasi($nip); //total realisasi hingga bulan sebelumnya
                //     $angkasbulanini = $this->User_model->getangkasbulanini($nip,$unitkeyppk) + (($angkas - $this->User_model->getangkasbulanini($nip,$unitkeyppk)) - $totreal);
                //     $detangkasbulanini = $this->User_model->getdetangkasbulanini($nip,$unitkeyppk);
                //     $realisasibulanini = $this->User_model->getrealisasibulanini($this->User_model->getidstrukturppk($nip));
                //
                //     $persenrealisasibulanini = ($realisasibulanini / $angkasbulanini) * 100;
                //     $lspptk = $this->User_model->getnipstrukturpptk($this->User_model->getidstrukturppk($nip));
                //
                //     //var_dump($detangkasbulanini).exit;
                //     //echo $this->template->rupiah($pgthn);
                //     //var_dump($this->User_model->getdetangkashbs($nip)).exit;
                //     //echo json_encode($this->User_model->getdataschedule($nip));
                //     $this->data = array(
                //         'idopd' => $idopd,
                //         'nmopd' => $namaopd,
                //         'tahun' => $this->tahunskr,
                //         'list' => $lskeg,
                //         'pagu_tahun' => $this->template->rupiah($pgthn),
                //         'angkas_bulan' => $this->template->rupiah($angkas),
                //         'angkas_bulan_ini' => $this->template->rupiah($angkasbulanini),
                //         'det_angkas_bulan_ini' => $detangkasbulanini,
                //         'det_angkas_satu_tahun' => $this->User_model->getdetangkassatutahun($nip,$unitkeyppk),
                //         'realisasi_bulan_ini' => $this->template->rupiah($realisasibulanini),
                //         'persen_realisasi' => round($persenrealisasibulanini, 2) . ' %',
                //         'lspptk' => $lspptk,
                //         'kegiatan' => $this->User_model->getkegiatan($nip),
                //         'data_realisasi' => $this->User_model->getdatarealisasi($nip), //data realisasi bulan ini
                //         'data_realisasi_hbs' => $this->User_model->getdatarealisasihbs($nip), //data realisasi hingga bulan sebelumnya
                //         'data_angkas_hbs' => $this->User_model->getdetangkashbs($nip,$unitkeyppk), //data angkas hingga bulan sebelumnya
                //         'data_schedule' => $this->User_model->getdataschedule($nip), //data schedule satu tahun
                //         'data_real_fisik' => $this->User_model->getrealfisik($nip), //data realisasi fisik bulan ini
                //         'det_real_bmodalbi' => $this->User_model->getdetrealbmodalbi($this->User_model->getidstrukturppk($nip),$unitkeyppk), //detail realisasi belanja modal bulan ini
                //
                //     );
                //     $this->template->load('templatenew', 'dashboard_sekretaris', $this->data);
                //
                // }
                elseif($peran=='6'){
                    /*jika peran 3 maka PPTK*/
                     $this->data= array(
                        'idopd'     => $idopd,
                        'nmopd'     => $namaopd,
                        'tahun'     => $this->tahunskr,

                    );
                    $this->template->load('templatenew','dashboard_sekretaris',$this->data);
                }
                elseif($peran=='3'){
                    /*jika peran 3 maka PPTK*/
                     $this->data= array(
                        'idopd'     => $idopd,
                        'nmopd'     => $namaopd,
                        'tahun'     => $this->tahunskr,

                    );
                    $this->template->load('templatenew','dashboard_pptk',$this->data);
                }else{

                    /*jika tidak user biasa*/
                    $this->template->load('template','dashboard');
                }
            }else{
                $this->template->load('template','dashboard');
            }


        }
    }

    //kasubagprogram
    function ksubprolistprogram (){
      if (!$this->ion_auth->logged_in()){
            redirect('Home/login', 'refresh');
      }elseif (!$this->ion_auth->is_kasubprogram()){
          redirect('User', 'refresh');
      }else{
        $nip=$this->ion_auth->user()->row()->username;
        // $rowunit=$this->User_model->getpns($nip);
        // $idunit=$rowunit->unitkey;
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        $listprogram =  $this->User_model->ksubpro_listprogram($idopd,$this->tahunskr);
        if(!$listprogram ){
            $prog[]=array();
        }else{
          foreach ($listprogram as $key) {

            $keg= array();
            $idprog =  $key['IDPRGRM'];
            $nmprog =  $key['NMPRGRM'];

            $listkegiatan = $this->User_model->ksubpro_listkegiatan($idopd,$this->tahunskr,$idprog);

            foreach ($listkegiatan->result_array() as $xkey ) {
              $kdkeg = $xkey['kdkegunit'];
              $nmkeg = $xkey['nmkegunit'];
              $nilai = $xkey['nilai'];
              $keg[] = array(
                  'kdkeg'   => $kdkeg,
                  'nmkeg'   => $nmkeg,
                  'nilai'   => $this->template->rupiah($nilai)
              );
            }

            $prog[] = array(
                'idprog'   => $idprog,
                'nmprog'   => $nmprog,
                'jumkeg'   => $listkegiatan->num_rows(),
                'detkeg'   => $keg
            );
          }

        }

        $this->data= array(
            'nmopd'     => $namaopd,
            'tahun'     => $this->tahunskr,
            'idopd'     => $idopd,
            'program'   => $prog
        );

     //echo json_encode($this->data); exit;
      $this->template->load('templatenew','v_kasubpro_program',$this->data);

      }


    }
    function ksubprodpa (){

      if (!$this->ion_auth->logged_in()){
            redirect('Home/login', 'refresh');
      }elseif (!$this->ion_auth->is_kasubprogram()){
          redirect('User', 'refresh');
      }else{
        $nip=$this->ion_auth->user()->row()->username;
        // $rowunit=$this->User_model->getpns($nip);
        // $idunit=$rowunit->unitkey;
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        $listprogramdpa =  $this->User_model->ksubpro_listprogram_dpa($idopd,$this->tahunskr);
        if(!$listprogramdpa ){
            $dpa[]=array();
        }else{

          foreach ($listprogramdpa as $key) {

            $keg= array();
            $idprog =  $key['IDPRGRM'];
            $nmprog =  $key['NMPRGRM'];

            $listkegiatandpa = $this->User_model->ksubpro_listkegiatan_dpa($idopd,$this->tahunskr,$idprog);

            foreach ($listkegiatandpa->result_array() as $xkey ) {
              $kdkeg = $xkey['kdkegunit'];
              $nmkeg = $xkey['nmkegunit'];
              $nilai = $xkey['nilai'];
              $keg[] = array(
                  'kdkeg'   => $kdkeg,
                  'nmkeg'   => $nmkeg,
                  'nilai'   => $this->template->rupiah($nilai)
              );
            }

            $dpa[] = array(
                'idprog'   => $idprog,
                'nmprog'   => $nmprog,
                'jumkeg'   => $listkegiatandpa->num_rows(),
                'detkeg'   => $keg
            );
          }

        }


        $this->data= array(
            'nmopd'     => $namaopd,
            'tahun'     => $this->tahunskr,
            'idopd'     => $idopd,
            'dpa'       => $dpa
        );

     echo json_encode($this->data); exit;
      $this->template->load('templatenew','v_kasubpro_dpa',$this->data);

      }


    }

    function sinkrondpa22(){
      //metode sinkron
      //cek tambahan data baru
      //update semua data
      if (!$this->ion_auth->logged_in()){
            redirect('Home/login', 'refresh');
      }elseif (!$this->ion_auth->is_kasubprogram()){
          redirect('User', 'refresh');
      }else{
       $unit = $this->input->post('unit');
        //$unit = '80_';
        $dpa22 = $this->User_model->sinkrondpa22($this->tahunskr,$unit);
        $data['data'][] = array(

          'status'   =>  $dpa22

        );

         echo json_encode($data);

      }

    }
    //batas kasubagprogram
//ini untuk struktur OPD / Unit
    function struktur(){
        if (!$this->ion_auth->is_kasubag()){
            redirect('User', 'refresh');
        }else{
            // cari opd berdasarkan admin yang login dengan parameter NIP yang ada di username pada saat login
            $nip=$this->ion_auth->user()->row()->username;
            $rowunit=$this->User_model->getpns($nip);
            $idunit=$rowunit->unitkey;
            $this->data= array(
                'idopd'     =>  $idunit

            );

            $this->template->load('viewlama/template','v_struktur',$this->data);
        }
    }
/********AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI*/
    function updateStruktur(){
        if (!$this->ion_auth->is_kasubag()){
            redirect('User', 'refresh');
        }else{
            $idstruktur = $this->input->post('idstruktur');
            $nip = $this->input->post('nip');

            $data = array(
                    'nip' => $nip
            );
            $upstrukt=$this->User_model->updatestruktur($data,$idstruktur);

            if($upstrukt){

                $arr['data'][]= array(

                    'status' => true
                );
            }else{
                $arr['data'][]= array(
                    'status' => false
                );
            }
            header('Content-Type: application/json');
                    // minimal PHP 5.2
            echo json_encode($arr);
        }
    }
    function kelola(){
        if (!$this->ion_auth->is_kasubag()){
            redirect('User', 'refresh');
        }else{
            // cari opd berdasarkan admin yang login dengan parameter NIP yang ada di username pada saat login
            $nip=$this->ion_auth->user()->row()->username;
            $rowunit=$this->User_model->getpns($nip);
            $idunit=$rowunit->unitkey;
            $this->data= array(
                    'idopd'     =>  $idunit

                 );

            $this->template->load('templatenew','v_kelola_organisasi',$this->data);
        }
    }
    function jsonkelola_byid()
    {
      $idKelola = $this->input->post('idKelola');

      $this->db->select("*");
      $this->db->from('`v_kelola_opd`');
      $this->db->where('`v_kelola_opd`.`id`', $idKelola);
      $struktur = $this->db->get()->row();
      $this->db->select("*");
      $this->db->from("tab_pns");
      $pns = $this->db->get()->result();
      $data = array('struktur'=> $struktur,
                    'pns' =>$pns
                        );
      echo json_encode($data);
    }
    function jsonstrukturlist_by($opd){
        header('Content-Type: application/json');
        echo $this->User_model->jsonstrukturlist_by($opd);
    }
    /*AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI-AGUNG-SETIA-BUDI*************/
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
        $result=$this->User_model->struktur($opd);
        if($result){
            $arr= $this->buildTree($result);
        }else{
            $arr= $this->buildTree($items);
        }

        $ok=$arr[0];
        header('Content-Type: application/json');
        echo json_encode($ok);
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


//ini Batas untuk struktur OPD / Unit

    /*awal kasubag*/
    function cekstrukturopd(){
        $opd=$this->input->post('idunt');
        $result=$this->User_model->cekstrukturopd($opd);
        if($result){
            $arr['data'][]= array(

                'status' => 'true'
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

    function cekkegiatan(){
      //generate KPA - PPTK
        $nip=$this->ion_auth->user()->row()->username;
        $rowunit=$this->User_model->getpns($nip);
        $idunit=$rowunit->unitkey;
        $result=$this->User_model->cekkegiatan($idunit,$this->tahunskr);
        if($result->row()){
            $arr['data'][]= array(
                'status' => 'true'
                // 'jumrow' => $result->num_rows()
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

    function cekkegiatanentri(){
//list legiatan di dasbord
        $nip=$this->ion_auth->user()->row()->username;
        $rowunit=$this->User_model->getpns($nip);
        $idunit=$rowunit->unitkey;
        $result=$this->User_model->cekkegiatanentri($idunit);
        if($result){
            $arr['data'][]= array(
                'status' => 'true'
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

    function entrikegiatan(){
        if (!$this->ion_auth->logged_in()){
            redirect('Home/login', 'refresh');
        }elseif ($this->ion_auth->is_admin()){
            redirect('Cpanel', 'refresh');
        }elseif ($this->ion_auth->is_kasubag()){

            $nip=$this->ion_auth->user()->row()->username;
            $rowunit=$this->User_model->getpns($nip);
            $idunit=$rowunit->unitkey;
            $pptk =$this->User_model->listpptk($idunit);
            $ppk  =$this->User_model->listppk($idunit);


            $getopd = $this->User_model->getnamaopd($nip);
            $idopd =$getopd->unitkey;
            $namaopd=$getopd->nmunit;

            $listkegiatan=$this->User_model->listkegiatan($idunit);
            if($listkegiatan){
               $this->data= array(
                'idopd'     => $idopd,
                'nmopd'     => $namaopd,
                'tahun'     => $this->tahunskr,
                'list'     =>  $listkegiatan,
                'pptk'     =>  $pptk,
                'ppk'      =>  $ppk
            );

           }
          $getmastersk = $this->User_model->cekkegiatan($idopd,$this->tahunskr);
          if($getmastersk->num_rows()>0){
            redirect('User/listsk','refresh');
          }else{
            $this->template->load('templatenew','v_entrikegiatan',$this->data);
          }


       }else{
        redirect('User/general', 'refresh');
    }
}
function simpanentrikegiatan(){
    if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
        $nip            = $this->ion_auth->user()->row()->username;
        $rowunit        = $this->User_model->getpns($nip);
        $unitkey        = $rowunit->unitkey;
        $tahun          = $this->tahunskr;
        $adminentri     = $nip;
        $tgl_entri      = date('Y/m/d h:i:sa');



        $master=array(
           'tahun'      => $tahun,
           'unitkey'    => $unitkey,
           'admin_entri'=> $adminentri,
           'tgl_entri'  => $tgl_entri
        );

        $getmastersk = $this->User_model->cekkegiatan($unitkey,$this->tahunskr);
        if(!$getmastersk){
          $status=false;
        }elseif($getmastersk->num_rows()>0){
          $status=false;
        }else{
          $result=$this->User_model->simpanentrikegiatan($master);
          if($result){
            $status=true;
          }
        }
        $data['data'][] = array(

          'status'   =>  $status

        );


        echo json_encode($data);

        // $result=$this->User_model->simpanentrikegiatan($master);
        // if($result){
        //     echo json_encode(array("status" => TRUE));
        // }
    }else{
        redirect('User/general', 'refresh');
    }
}

function listsk(){

  if (!$this->ion_auth->logged_in()){
      redirect('Home/login', 'refresh');
  }elseif ($this->ion_auth->is_admin()){
      redirect('Cpanel', 'refresh');
  }elseif ($this->ion_auth->is_kasubag()){
     /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
      $nip=$this->ion_auth->user()->row()->username;
      $getopd = $this->User_model->getnamaopd($nip);
      $idopd  = $getopd->unitkey;
      $namaopd= $getopd->nmunit;

      //$getdetsk    = $this->User_model->get_eska_detail($id_m,$this->tahunskr);
      // 0 = baru masuk dan belum di komfirmasi admin dalbang -> lanjut untuk acc atau tolak
      // 1 = sudah konfirmasi dan ok , kemudian semua user sudah di acc per opd dan per tahun
      // 2 = sudah di lihat tapi belum ada proses(cuma dilihat) -> lanjut untuk acc dan tolak
      // 3 = tolak dan perbaiki tambah catatan (dalbang)
      // 4 = belum entri
      $ceksk = $this->User_model->cekkegiatan($idopd,$this->tahunskr);
      if($ceksk->num_rows()>0){
        $getmastersk = $this->User_model->get_eska_master($idopd,$this->tahunskr)->row();
        $nama_entri_m= $getmastersk->nama;
        $tgl_entri_m = $getmastersk->tgl_entri;
        $stat_m      = $getmastersk->stat;
        $id_m        = $getmastersk->id;

      $dokumen = $this->User_model->get_eska_dokumen($id_m);

      if($stat_m == 0){
        $stat='Belum di Konfirmasi';
      }elseif ($stat_m == 1) {
        $stat = 'Sudah di Konfirmasi';
      }elseif ($stat_m == 2) {
        $stat = 'Sudah di Lihat';
      }elseif ($stat_m == 3) {
        $stat = 'Di Tolak';
      }else{
        $stat = 'Belum Entri';
      }
      $this->data= array(
          'idopd'     => $idopd,
          'nmopd'     =>  $namaopd,
          'tahun'     =>  $this->tahunskr,
          'nama_entri_m' => $nama_entri_m,
          'tgl_entri_m' => $tgl_entri_m,
          'stat_m'    => $stat,
          'id_m'    => $id_m,
          'dokumen' => $dokumen->nama_dokumen,
          'path' => $dokumen->file_path
      );



           $this->template->load('templatenew','v_list_sk',$this->data);
      }else{
          redirect('User/entrikegiatan','refresh');

      }

 //echo json_encode($this->data);
  }else{

    redirect('User', 'refresh');

  }


}
function json_detail_sk($id_m){
    header('Content-Type: application/json');
  //  echo $this->User_model->jsonstrukturlist_by($opd);
    echo $this->User_model->get_eska_detail($id_m,$this->tahunskr);
}

function download_sk($path){
    $file_path = FCPATH . 'assets/dokumen/'.$path;
    force_download($file_path,NULL);
}

function get_sk_kpa_pptk(){
    $id_m=$this->input->post('idm');
    $idkeg=$this->input->post('idkeg');
    $idunit = $this->input->post('idunit');
    $pptk =$this->User_model->listpptk($idunit);
    $ppk  =$this->User_model->listppk($idunit);
    $detail= $this->User_model->get_eska_detail_keg($id_m,$this->tahunskr,$idkeg);
   //  foreach ($rangkasrek as $rkey ) {
   //     $rek[] = array(
   //         'mtgkey'   => $rkey['mtgkey'],
   //         'nilai'    => $rkey['nilai'],
   //         'msknilai' => $this->template->rupiah($rkey['nilai']),
   //         'nmper'    => $rkey['nmper'],
   //         'kdper'    => $rkey['kdper'],
   //         'tahun'    => $rkey['tahun']
   //     );
   // }
    $data['data'][] = array(

      'nmkegunit'   =>   $detail['nmkegunit'],
      'nippptklama' =>   $detail['nippptk'],
      'nipppklama' =>    $detail['nipppk'],
      'pptk'        =>   $pptk,
      'ppk'         =>   $ppk
    );

     echo json_encode($data);
}
function update_det_eska(){
    $id=$this->input->post('id');
    $nippptk=$this->input->post('pptk');
    $nipppk=$this->input->post('ppk');
    $data=array(
                'idpnspptk'    => $nippptk,
                'idpnsppk'    => $nipppk
            );
    $update = $this->User_model->update_eska_kpapptk($id,$data);
    $data['data'][] = array(

      'status'   =>  $update

    );

     echo json_encode($data);

}

function update_dokumen_eska(){
  $namadok = $this->input->post('nmdok');
  $idm = $this->input->post('idm');
  $file    = "file_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
  $config['upload_path'] = './assets/dokumen/'; //path folder iko
  $config['allowed_types'] = 'pdf'; //type yang dapat diakses ikobisa anda sesuaikan
  $config['max_size'] = '3072'; //maksimum besar file 3M
  // $config['max_width']  = '5000'; //lebar maksimum 5000 px
  // $config['max_height']  = '5000'; //tinggi maksimu 5000 px
  $config['file_name'] = $file; //nama yang terupload nantinya smpai iko
  $files = $_FILES;
  $_FILES['userfile']['name']= $files['userfile']['name'];
  $_FILES['userfile']['type']= $files['userfile']['type'];
  $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'];
  $_FILES['userfile']['error']= $files['userfile']['error'];
  $_FILES['userfile']['size']= $files['userfile']['size'];
  $this->upload->initialize($config);
  if ( !$this->upload->do_upload()){
    $stat = false;
    $namo_dokumen = 'no-image.png';
    $msg = $this->upload->display_errors('', '');
  }else{
    $stat = true;
    $fileData = $this->upload->data();
    $msg ='sukses unggah dokumen';
    $namo_dokumen = $fileData['file_name'];
    $dt=array(
        'id_pptk_master' => $idm,
        'nama_dokumen'   => $namadok,
        'file_path'      => $namo_dokumen
    );
    $result=$this->User_model->update_dokumen_eska($dt,$idm);
    if(!$result){
      $stat= false;
    }

  }

  $data['data'][] = array(

    'status'   => $stat,
    'pesan'    => $msg

  );

   echo json_encode($data);

}

//last update
/*Batas kasubag k*/
//new

//------------------------------------------awal pptk---------------------------------------------------//
//------------------------------------------------------------------------------------------------------//

function dafkeg(){

    if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
       /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        if($struktur ){

            $peran=$struktur->peran;
            if($peran=='3'){
              $lskeg = $this->User_model->getlistkegiatan($nip);
                  $this->data= array(
                      'idopd'     => $idopd,
                      'nmopd'     =>  $namaopd,
                      'tahun'     =>  $this->tahunskr,
                      'list'      =>$lskeg
                  );
                  $this->template->load('templatenew','v_dafkeg_pptk',$this->data);
            }else{
                /*jika tidak*/
                redirect('User', 'refresh');
            }

        }else{
          redirect('User', 'refresh');
        }
    }else{
        /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        if($struktur ){

            $peran=$struktur->peran;

            if($peran=='3'){
                /*jika peran 3 maka PPTK*/
                $lskeg = $this->User_model->getlistkegiatan($nip);
                $this->data= array(
                    'idopd'     => $idopd,
                    'nmopd'     =>  $namaopd,
                    'tahun'     =>  $this->tahunskr,
                    'list'      =>$lskeg
                );
                $this->template->load('templatenew','v_dafkeg_pptk',$this->data);


            }else{
                /*jika tidak*/
                redirect('User', 'refresh');
            }
        }else{
          redirect('User', 'refresh');
        }


  }
}
function jsontargetkeu(){
    $idkeg=$this->input->post('idkeg');
    $unitkey=$this->input->post('unitkey');
        //  $idkeg='11142_';
        // $unitkey='80_';
    $nip=$this->ion_auth->user()->row()->username;
    $lskeg = $this->User_model->getdetlistkegiatan($nip,$idkeg);


    $data['header'][] = array(

       'kdkegunit'   =>   $lskeg->kdkegunit,
       'nmkegunit'   =>   $lskeg->nmkegunit,
       'nilai'       =>   $lskeg->nilai,
       'msknilai'    =>   $this->template->rupiah($lskeg->nilai),
       'idpnspptk'   =>   $lskeg->idpnspptk,
       'idpnsppk'    =>   $lskeg->idpnsppk

   );
    $rperbulan = $this->User_model->kegperbulan($idkeg,$unitkey);


    foreach ($rperbulan as $key) {
        $bulan=$key['kd_bulan'];
        $nilai= $key['nilai'];
        $maskingbulan=tglm($bulan);
        $maskingnilai=$this->template->rupiah($nilai);
        $rangkasrek = $this->User_model->angkasrek_by($idkeg,$unitkey,$bulan);
        $rek=array();
        foreach ($rangkasrek as $rkey ) {
           $rek[] = array(
               'mtgkey'   => $rkey['mtgkey'],
               'nilai'    => $rkey['nilai'],
               'msknilai' => $this->template->rupiah($rkey['nilai']),
               'nmper'    => $rkey['nmper'],
               'kdper'    => $rkey['kdper'],
               'tahun'    => $rkey['tahun']
           );
       }
       $data['data'][] = array(
           'bln'      =>  $bulan,
           'mskbln'   =>  $maskingbulan,
           'nl'       =>  $nilai,
           'msknilai' =>  $maskingnilai,
           'rek'      =>  $rek
       );
   }

   echo json_encode($data);
}

function jsontargetfis(){
    $idkeg=$this->input->post('idkeg');
    $unitkey=$this->input->post('unitkey');
         //  $idkeg='11142_';
         // $unitkey='80_';
    $nip=$this->ion_auth->user()->row()->username;
    $lskeg = $this->User_model->getdetlistkegiatan($nip,$idkeg);
    $idtabpptk = $lskeg->id;
    $lskakschedule = $this->User_model->getlistkak_by($idtabpptk);
    if($lskakschedule){
       $arsir=0;
       foreach ($lskakschedule as $key) {
        $arsir+= strlen($key->jan);
        $arsir+= strlen($key->feb);
        $arsir+= strlen($key->mar);
        $arsir+= strlen($key->apr);
        $arsir+= strlen($key->mei);
        $arsir+= strlen($key->jun);
        $arsir+= strlen($key->jul);
        $arsir+= strlen($key->ags);
        $arsir+= strlen($key->sep);
        $arsir+= strlen($key->okt);
        $arsir+= strlen($key->nov);
        $arsir+= strlen($key->des);
    }
    $xar= 100/$arsir;

    //$nlsatuarsir =   round($xar, 3) ;

    $nlsatuarsir =  number_format($xar,2);


    $data['header'][] = array(
        'status' => true,
        'kdkegunit'   =>   $lskeg->kdkegunit,
        'nmkegunit'   =>   $lskeg->nmkegunit,
        'nilai'       =>   $lskeg->nilai,
        'msknilai'    =>   $this->template->rupiah($lskeg->nilai),
        'idpnspptk'   =>   $lskeg->idpnspptk,
        'idpnsppk'    =>   $lskeg->idpnsppk,

    );
    $jan=0;
    $feb=0;
    $mar=0;
    $apr=0;
    $mei=0;
    $jun=0;
    $jul=0;
    $ags=0;
    $sep=0;
    $okt=0;
    $nov=0;
    $des=0;

    foreach ($lskakschedule as $key) {
        $jan+= strlen($key->jan);
        $feb+= strlen($key->feb);
        $mar+= strlen($key->mar);
        $apr+= strlen($key->apr);
        $mei+= strlen($key->mei);
        $jun+= strlen($key->jun);
        $jul+= strlen($key->jul);
        $ags+= strlen($key->ags);
        $sep+= strlen($key->sep);
        $okt+= strlen($key->okt);
        $nov+= strlen($key->nov);
        $des+= strlen($key->des);

    }
    $arraytarget = array(
        $jan,
        $feb,
        $mar,
        $apr,
        $mei,
        $jun,
        $jul,
        $ags,
        $sep,
        $okt,
        $nov,
        $des
    );
    $arraybuln = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember' );
    $x=0;
    $jumtarget=0;
    $xtarget=0;
    for($i = 0; $i < 12; $i++){
      $target =  $arraytarget[$i]*$nlsatuarsir;

      if ($target!=0) {

        $xtarget=$jumtarget+= $target;

      }else{
          $xtarget = 0;
      }

      if($jumtarget > 99 && $jumtarget < 100  ){
          $xtarget=ceil($jumtarget);
      }elseif($jumtarget > 100){
          $xtarget=floor($jumtarget);
      }

      $data['data'][] = array(
          'bln'      =>  $arraybuln[$i],
          'targ'      => $target,
          'jumtarg'   => number_format($xtarget,2)
      );


}
header('Content-Type: application/json');
echo json_encode($data);
}else{

    $data['header'][]= array(
        'status' => false
    );

    header('Content-Type: application/json');
                    // minimal PHP 5.2
    echo json_encode($data);
}

}

function jsonrealisasi(){
    $idkeg=$this->input->post('idkeg');
    $unitkey=$this->input->post('unitkey');
    $idtab=$this->input->post('idtab');
        //  $idkeg='11142_';
        // $unitkey='80_';
    $nip=$this->ion_auth->user()->row()->username;
    $lskeg = $this->User_model->getdetlistkegiatan($nip,$idkeg);


    $data['header'][] = array(

       'kdkegunit'   =>   $lskeg->kdkegunit,
       'nmkegunit'   =>   $lskeg->nmkegunit,
       'nilai'       =>   $lskeg->nilai,
       'msknilai'    =>   $this->template->rupiah($lskeg->nilai),
       'idpnspptk'   =>   $lskeg->idpnspptk,
       'idpnsppk'    =>   $lskeg->idpnsppk

   );
    $rperbulan = $this->User_model->kegperbulan($idkeg,$unitkey);


    foreach ($rperbulan as $key) {
        $bulan=$key['kd_bulan'];
        $nilai= $key['nilai'];
        $maskingbulan=tglm($bulan);
        $maskingnilai=$this->template->rupiah($nilai);
       //  $rangkasrek = $this->User_model->angkasrek_by($idkeg,$unitkey,$bulan);
       //  $rek=array();
       //  foreach ($rangkasrek as $rkey ) {
       //     $rek[] = array(
       //         'mtgkey'   => $rkey['mtgkey'],
       //         'nilai'    => $rkey['nilai'],
       //         'msknilai' => $this->template->rupiah($rkey['nilai']),
       //         'nmper'    => $rkey['nmper'],
       //         'kdper'    => $rkey['kdper'],
       //         'tahun'    => $rkey['tahun']
       //     );
       // }
        $this->db->where('id_tabpptk', $idtab);
        $jumreal = $this->db->get('tab_realisasi');
        if($jumreal->num_rows()==0){
            $pertama=1;
            $adareal=0;
            $totreal=0;
        }else{
            $pertama=0;
            $this->db->where('MONTH(real_bulan)', $bulan);
            $this->db->where('id_tabpptk', $idtab);
            $treal = $this->db->get('tab_realisasi');
            if($treal->num_rows()==0){
                $adareal=0;
                $totreal=0;
            }else{
                $adareal=1;
                // $totreal= $treal->row()->real_keuangan;
                // get id tab_realisasi
                $idmreal= $treal->row()->id;
                // SELECT SUM(`jumlah_harga`) AS jumreal FROM `tab_realisasi_det` WHERE `id_tab_realisasi`='1'
//                 SELECT
//    SUM(tab_realisasi_det.`jumlah_harga`) AS totalreal
// FROM
//     `db_sodap`.`tab_realisasi_det`
//     INNER JOIN `db_sodap`.`tab_realisasi`
//         ON (`tab_realisasi_det`.`id_tab_realisasi` = `tab_realisasi`.`id`) WHERE tab_realisasi.`id_tabpptk`='5';

                $this->db->select('SUM(`jumlah_harga`) AS jumreal');
                $this->db->where('id_tab_realisasi', $idmreal);
                $trealdet = $this->db->get('tab_realisasi_det');
                $totreal= $trealdet->row()->jumreal;
            }
        }
        //realisasi 5.2.3
        // $this->db->where('MONTH(real_bulan)', $bulan);
        // $this->db->select('SUM(`nilai_ktrk`) AS jumrealbm');
        // $this->db->where('id_tab_pptk', $idtab);
        // $jumreal = $this->db->get('tab_realisasi_bmodal');

        $this->db->select('id');
        $this->db->where('id_tab_pptk', $idtab);
        $jumreal = $this->db->get('tab_realisasi_bmodal');
        if($jumreal->num_rows()==0){
            $pertamabm=1;
            $adarealbm=0;
            $totrealbm=0;
        }else{
            $idjumreal= $jumreal->row()->id;
            $this->db->select('SUM(`real_keuangan`) AS jumrealbm');
            $this->db->where('MONTH(real_bulan)', $bulan);
            $this->db->where('id_tab_real_bmodal', $idjumreal);
            $detjumreal = $this->db->get('tab_realisasi_bmodal_det');
            $pertamabm=0;
            $adarealbm=1;
            $totrealbm=$detjumreal->row()->jumrealbm;
        }
        //jumlah totreal keuangan 5.2.2 dan 5.2.3

        $jumtotreal = (int)$totreal+(int)$totrealbm;

       $data['data'][] = array(
            'pertama'  =>  $pertama,
            'adareal'  =>  $adareal,
            'totreal'  =>  $this->template->rupiah($jumtotreal),
            'bln'      =>  $bulan,
            'mskbln'   =>  $maskingbulan,
            'nl'       =>  $nilai,
            'nmnltotreal'=> $totreal,
            'msknilai' =>  $maskingnilai,
            //'rek'      =>  $rek
       );
   }

   echo json_encode($data);
}


function realisasipptk(){

    if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    //}
    // elseif ($this->ion_auth->is_kasubag()){
    //     // redirect('User/admingeneral', 'refresh');
    //     echo 'hoho';
    }else{
        /*ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        if($struktur ){
            $peran=$struktur->peran;

            if($peran=='3'){

                /*jika peran 2 maka PPK*/
                $encryptionMethod = "AES-256-ECB";
                $secretHash = "aS9P0RNoKY9QcmvGDWwcZcjw6OuZKJK2VrR4Hv9UMms=";
                if(!isset($_GET['unit'], $_GET['keg'], $_GET['tab'],$_GET['pr'],$_GET['indexbl'],$_GET['bl'],$_GET['ub'])) {
                  redirect('User/dafkeg', 'refresh');
                }else{
                    $un=$_GET['unit'];
                    $keg=$_GET['keg'];
                    $tab=$_GET['tab'];
                    $pertama=$_GET['pr'];
                    $indexbl=$_GET['indexbl'];
                    $bl =$_GET['bl'];
                    $ubah =$_GET['ub'];
                    if (base64_encode(base64_decode($un)) === $un && base64_encode(base64_decode($keg)) === $keg && base64_encode(base64_decode($tab)) === $tab  ){
                        $unit       =openssl_decrypt($un, $encryptionMethod, $secretHash);
                        $kegiatan   =openssl_decrypt($keg, $encryptionMethod, $secretHash);
                        $idtab      =openssl_decrypt($tab, $encryptionMethod, $secretHash);

                    } else {
                        echo 'Anda Mau Kemana ??';
                        die;
                    }

                    $nip=$this->ion_auth->user()->row()->username;
                    $getopd = $this->User_model->getnamaopd($nip);
                    $idopd =$getopd->unitkey;
                    $namaopd=$getopd->nmunit;
                    if($unit!=$idopd){
                        redirect('User/dafkeg', 'refresh');
                    }else{
                        $arraybuln = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember' );
                        $lskeg = $this->User_model->getdetlistkegiatan_detpptk($nip,$kegiatan);

                        if($ubah==1){

                          // jika ubah = 1 , load data yang akan di ubah
                          //cek ke tab realisasi berdasarkan id tab pptk dan bulan realisasi
                          $this->db->where('MONTH(real_bulan)', $bl);
                          $this->db->where('id_tabpptk', $idtab);
                          $treal = $this->db->get('tab_realisasi');
                          if($treal->num_rows() > 0){
                            //idreal sekarang
                            $idreals= $treal->row_array()['id'];
                            $real_fisik = $treal->row_array()['real_fisik'];
                            $bobot_real = $treal->row_array()['bobot_real'];
                            $permasalahan = $treal->row_array()['permasalahan'];
                            $pert = $treal->row_array()['pertama'];
                          }else{
                            redirect('User/dafkeg', 'refresh');
                          }

                            if($pert==1){
                                  //$header=$this->User_model->getheader_realisasipptk($idopd,$lskeg->kdkeg);
                                  $header=$this->User_model->getheader_realisasipptk_angkas($idopd,$lskeg->kdkeg,$bl);
                                  //cek ke aliran kas
                                  // var_dump($idopd,$lskeg->kdkeg,$bl);exit();
                                  $anggaranopd = $this->User_model->anggaranopd($idopd);
                                  $bobotkeg=$lskeg->nl/$anggaranopd->anggranopd*100;
                                  $this->data= array(
                                      'idopd'     => $idopd,
                                      'idtab'     => $idtab,
                                      'nmopd'     => $namaopd,
                                      'tahun'     => $this->tahunskr,
                                      'prog'      => $lskeg->prog,
                                      'kdkeg'     => $lskeg->kdkeg,
                                      'keg'       => $lskeg->keg,
                                      'nl'        => $lskeg->nl,
                                      'bobot'     => number_format($bobotkeg,2),
                                      'pptk'      => $lskeg->pptk,
                                      'ppk'       => $lskeg->ppk,
                                      'bulan'     => $arraybuln[$indexbl],
                                      'indexbulan'=> $indexbl+1,
                                      'header'    => $header,
                                      'ubah'      => $ubah,
                                      //yang sudah di realisasi dan di edit kembali
                                      'idreals'    =>$idreals,
                                      'real_fisik'    =>$real_fisik,
                                      'bobot_real'    =>$bobot_real,
                                      'permasalahan'    =>$permasalahan

                                );
                                $this->template->load('templatenew','v_realisasi_pptk_m', $this->data);
                            }else{
                              $wherein = array();

                              for($i = 1; $i <= $bl; $i++){
                                $wherein[]=$i;
                              }

                              //cheat
                              //SELECT * FROM angkas WHERE `unitkey`='80_' AND `kdkegunit`!='0_' AND `kdkegunit`='11338_' AND `nilai`!='0' AND `kd_bulan` IN ('1','2','3','4')
                              //cheat
                              $this->db->select('`angkas`.`id`
                              , `angkas`.`unitkey`
                              , `angkas`.`kdkegunit`
                              , `angkas`.`kd_bulan`
                              , sum(`angkas`.`nilai`) AS nilai
                              , `angkas`.`mtgkey`
                              , `matangr`.`kdper`
                              , `matangr`.`nmper`
                              , `angkas`.`tahun`');
                              $this->db->from('angkas');
                              $this->db->join('matangr', '`angkas`.`mtgkey` = `matangr`.`mtgkey`');
                              $this->db->where('unitkey', $idopd);
                              $this->db->where('kdkegunit', $lskeg->kdkeg);
                              $this->db->where('kdkegunit !=', '0_');
                              $this->db->where('nilai !=', '0');
                              $this->db->where_in('kd_bulan', $wherein);
                              $this->db->group_by('`matangr`.`kdper`');
                              $headerlist = $this->db->get()->result_array();
                              //---------------------------------------------------//

                              $wherein_real_m = array();
                              $this->db->select('`id`
                              , `id_tabpptk`
                              , `real_bulan`');
                              $this->db->from('tab_realisasi');
                              $this->db->where('MONTH(real_bulan)!=', $bl);
                              $this->db->where('id_tabpptk', $idtab);
                              $idreal = $this->db->get()->result_array();
                              //$idreal = ambil id realisasi di tab_realisasi yang sudah ada di entri ke tabel
                              //kemudian di tampung ke dalam array $wherein_real_m yang akan digunakan di where_in
                              foreach ($idreal as $x) {

                                $wherein_real_m[]=$x['id'];

                              }

                              //realisasi bulan sebelumnya
                              $this->db->where('id_tabpptk', $idtab);
                              $this->db->where('MONTH(real_bulan)!=', $bl);
                              $this->db->order_by('real_bulan','DESC');
                              $this->db->limit(1);
                              $bulanlalu = $this->db->get('tab_realisasi');
                              $idbl=$bulanlalu->row()->id;
                              $rbbl=$bulanlalu->row()->real_bulan;
                              $pecahawal = explode('-', $rbbl);
                              $thnawal  = $pecahawal[0];
                              $blnawal  = $pecahawal[1];
                              $nmbln    = $arraybuln[(int)$blnawal-1];


                              $anggaranopd = $this->User_model->anggaranopd($idopd);
                              $bobotkeg=$lskeg->nl/$anggaranopd->anggranopd*100;
                              $this->data= array(
                                'idopd'     => $idopd,
                                'idtab'     => $idtab,
                                'nmopd'     => $namaopd,
                                'tahun'     => $this->tahunskr,
                                'prog'      => $lskeg->prog,
                                'kdkeg'     => $lskeg->kdkeg,
                                'keg'       => $lskeg->keg,
                                'nl'        => $lskeg->nl,
                                'bobot'     => number_format($bobotkeg,2),
                                'pptk'      => $lskeg->pptk,
                                'ppk'       => $lskeg->ppk,
                                'bulan'     => $arraybuln[$indexbl],
                                'indexbulan'=> $indexbl+1,
                                'ubah'      => $ubah,
                                //realisasi bulan lalu data id dan nama bulan
                                'idreal'    => $idbl,
                                'bulanlalu' => $nmbln,
                                //-----------------------------------------//
                                'header'    => $headerlist,
                                'idmreal'   => $wherein_real_m,
                                //yang sudah di realisasi dan di edit kembali
                                'idreals'   => $idreals,
                                'real_fisik'    =>$real_fisik,
                                'bobot_real'    =>$bobot_real,
                                'permasalahan'    =>$permasalahan
                              );
                              $this->template->load('templatenew','v_realisasi_pptk_next_m', $this->data);
                            }

                        }else{
                          //entri
                          if($pertama==1){
                              //$header=$this->User_model->getheader_realisasipptk($idopd,$lskeg->kdkeg);
                              $header=$this->User_model->getheader_realisasipptk_angkas($idopd,$lskeg->kdkeg,$bl);

                              //cek ke aliran kas
                              // var_dump($idopd,$lskeg->kdkeg,$bl);exit();
                              $anggaranopd = $this->User_model->anggaranopd($idopd);
                              $bobotkeg=$lskeg->nl/$anggaranopd->anggranopd*100;
                              $this->data= array(
                                  'idopd'     => $idopd,
                                  'idtab'     => $idtab,
                                  'nmopd'     => $namaopd,
                                  'tahun'     => $this->tahunskr,
                                  'prog'      => $lskeg->prog,
                                  'kdkeg'     => $lskeg->kdkeg,
                                  'keg'       => $lskeg->keg,
                                  'nl'        => $lskeg->nl,
                                  'bobot'     => number_format($bobotkeg,2),
                                  'pptk'      => $lskeg->pptk,
                                  'ppk'       => $lskeg->ppk,
                                  'bulan'     => $arraybuln[$indexbl],
                                  'indexbulan'=> $indexbl+1,
                                  'header'    => $header,
                                  'ubah'      => $ubah
                              );




                              $this->template->load('templatenew','v_realisasi_pptk_m', $this->data);
                          }elseif($pertama==0){
                            //jika entrian Bulan selanjutnya bukan yang pertama

                            $wherein = array();

                            for($i = 1; $i <= $bl; $i++){
                              $wherein[]=$i;
                            }

                            //cheat
                            //SELECT * FROM angkas WHERE `unitkey`='80_' AND `kdkegunit`!='0_' AND `kdkegunit`='11338_' AND `nilai`!='0' AND `kd_bulan` IN ('1','2','3','4')
                            //cheat
                            $this->db->select('`angkas`.`id`
                            , `angkas`.`unitkey`
                            , `angkas`.`kdkegunit`

                            , sum(`angkas`.`nilai`) AS nilai
                            ,  `angkas`.`mtgkey`
                            , `matangr`.`kdper`
                            , `matangr`.`nmper`
                            , `angkas`.`tahun`');
                            $this->db->from('angkas');
                            $this->db->join('matangr', '`angkas`.`mtgkey` = `matangr`.`mtgkey`');
                            $this->db->where('unitkey', $idopd);
                            $this->db->where('kdkegunit', $lskeg->kdkeg);
                            $this->db->where('kdkegunit !=', '0_');
                            $this->db->where('nilai !=', '0');
                            $this->db->where_in('kd_bulan', $wherein);
                            $this->db->group_by('`matangr`.`kdper`');
                            $headerlist = $this->db->get()->result_array();
                            // echo json_encode($headerlist);exit;
                            //---------------------------------------------------//
                            $wherein_real_m = array();
                            $this->db->select('`id`
                            , `id_tabpptk`
                            , `real_bulan`');
                            $this->db->from('tab_realisasi');
                            $this->db->where('id_tabpptk', $idtab);
                            $idreal = $this->db->get()->result_array();
                            //$idreal = ambil id realisasi di tab_realisasi yang sudah ada di entri ke tabel
                            //kemudian di tampung ke dalam array $wherein_real_m yang akan digunakan di where_in
                            foreach ($idreal as $x) {

                              $wherein_real_m[]=$x['id'];

                            }

                            //realisasi bulan sebelumnya
                            $this->db->where('id_tabpptk', $idtab);
                            $this->db->order_by('real_bulan','DESC');
                            $this->db->limit(1);
                            $bulanlalu = $this->db->get('tab_realisasi');
                            $idbl=$bulanlalu->row()->id;
                            $rbbl=$bulanlalu->row()->real_bulan;
                            $pecahawal = explode('-', $rbbl);
                            $thnawal  = $pecahawal[0];
                            $blnawal  = $pecahawal[1];
                            $nmbln    = $arraybuln[(int)$blnawal-1];


                            $anggaranopd = $this->User_model->anggaranopd($idopd);
                            $bobotkeg=$lskeg->nl/$anggaranopd->anggranopd*100;
                            $this->data= array(
                              'idopd'     => $idopd,
                              'idtab'     => $idtab,
                              'nmopd'     => $namaopd,
                              'tahun'     => $this->tahunskr,
                              'prog'      => $lskeg->prog,
                              'kdkeg'     => $lskeg->kdkeg,
                              'keg'       => $lskeg->keg,
                              'nl'        => $lskeg->nl,
                              'bobot'     => number_format($bobotkeg,2),
                              'pptk'      => $lskeg->pptk,
                              'ppk'       => $lskeg->ppk,
                              'bulan'     => $arraybuln[$indexbl],
                              'indexbulan'=> $indexbl+1,
                              'ubah'      => $ubah,
                              //realisasi bulan lalu data id dan nama bulan
                              'idreal'    => $idbl,
                              'bulanlalu' => $nmbln,
                              //-----------------------------------------//
                              'header'    => $headerlist,
                              'idmreal'   => $wherein_real_m
                            );

                            $this->template->load('templatenew','v_realisasi_pptk_next_m', $this->data);
                          }else{
                                       $anggaranopd = $this->User_model->anggaranopd($idopd);
                                      $bobotkeg=$lskeg->nl/$anggaranopd->anggranopd*100;
                                       $this->data= array(
                                          'idopd'     => $idopd,
                                          'idtab'     => $idtab,
                                          'nmopd'     => $namaopd,
                                          'tahun'     => $this->tahunskr,
                                          'prog'      => $lskeg->prog,
                                          'kdkeg'     => $lskeg->kdkeg,
                                          'keg'       => $lskeg->keg,
                                          'nl'        => $lskeg->nl,
                                          'bobot'     => number_format($bobotkeg,2),
                                          'pptk'      => $lskeg->pptk,
                                          'ppk'       => $lskeg->ppk,


                                      );

                                      $this->template->load('templatenew','v_realisasi_pptk_list', $this->data);

                                  }
                        }




                    }
                }

            }else{
                /*jika tidak*/
                redirect('User', 'refresh');
            }
        }else{
          redirect('User', 'refresh');
      }


  }
}

function realisasipptklama(){

     if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
        redirect('User/admingeneral', 'refresh');
    }else{
        /*ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        if($struktur ){

            $peran=$struktur->peran;

            if($peran=='3'){

            /*jika peran 2 maka PPK*/
            $encryptionMethod = "AES-256-ECB";
            $secretHash = "aS9P0RNoKY9QcmvGDWwcZcjw6OuZKJK2VrR4Hv9UMms=";
            if(!isset($_GET['unit'], $_GET['keg'], $_GET['tab'])) {

              redirect('User/kakppk', 'refresh');
          }else{
            $un=$_GET['unit'];
            $keg=$_GET['keg'];
            $tab=$_GET['tab'];

            if (base64_encode(base64_decode($un)) === $un && base64_encode(base64_decode($keg)) === $keg && base64_encode(base64_decode($tab)) === $tab  ){
                $unit       =openssl_decrypt($un, $encryptionMethod, $secretHash);
                $kegiatan   =openssl_decrypt($keg, $encryptionMethod, $secretHash);
                $idtab      =openssl_decrypt($tab, $encryptionMethod, $secretHash);

            } else {
                echo 'Anda Mau Kemana ??';
                die;
            }

            $nip=$this->ion_auth->user()->row()->username;
            $getopd = $this->User_model->getnamaopd($nip);
            $idopd =$getopd->unitkey;
            $namaopd=$getopd->nmunit;
            if($unit!=$idopd){
                redirect('User/dafkeg', 'refresh');
            }else{
                $statkak = $this->db->get_where('tab_kak',array('idtab_pptk'=>$idtab,'stat_draft'=>'0'));
                    if($statkak->num_rows()>0){
                        $lskeg = $this->User_model->getdetlistkegiatan_detpptk($nip,$kegiatan);
                         if($lskeg){

                            // $kak = $this->db->get_where('tab_kak',array('idtab_pptk'=>'5'));
                            $idkak=$statkak->row()->id;
                            $dateawal=$statkak->row()->ii_awal_keg;
                            $dateakhir=$statkak->row()->ii_akhir_keg;
                            $bulansekarang =date('n');
                            $pecahawal = explode('-',  $dateawal);
                            $thnawal  = $pecahawal[0];
                            $blnawal  = $pecahawal[1];
                            $pecahakhir = explode('-', $dateakhir);
                            $thnakhir  = $pecahakhir[0];
                            $blnakhir  = $pecahakhir[1];
                            $arraybuln = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember' );
                            $arr = array('jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des' );

                                for($i=(int)$blnawal;$i<=(int)$blnakhir;$i++){
                                    $where =$arr[$i-1].'!=';
                                    $this->db->where('id_tab_kak', $idkak);
                                    $this->db->where($where, '');
                                    $ada = $this->db->get('tab_schedule');
                                    if($ada->num_rows()>0 ){

                                        $this->db->where('MONTH(real_bulan)', $i);
                                        $this->db->where('id_tabpptk', $idtab);
                                        $treal = $this->db->get('tab_realisasi');
                                        if($treal->num_rows()==0){
                                            $this->db->where('id_tabpptk', $idtab);
                                            $jumreal = $this->db->get('tab_realisasi');
                                            if($jumreal->num_rows()==0){
                                                $pertama=1;
                                            }else{
                                                $pertama=0;
                                            }
                                            $geat = $arraybuln[$i-1];

                                           break;
                                        }

                                    }else{
                                            $pertama=2;
                                    }
                                }

                                if($pertama==1){
                                    $header=$this->User_model->getheader_realisasipptk($idopd,$lskeg->kdkeg);
                                    $anggaranopd = $this->User_model->anggaranopd($idopd);
                                    $bobotkeg=$lskeg->nl/$anggaranopd->anggranopd*100;
                                    $this->data= array(
                                        'idopd'     => $idopd,
                                        'idtab'     => $idtab,
                                        'nmopd'     => $namaopd,
                                        'tahun'     => $this->tahunskr,
                                        'prog'      => $lskeg->prog,
                                        'kdkeg'     => $lskeg->kdkeg,
                                        'keg'       => $lskeg->keg,
                                        'nl'        => $lskeg->nl,
                                        'bobot'     => number_format($bobotkeg,2),
                                        'pptk'      => $lskeg->pptk,
                                        'ppk'       => $lskeg->ppk,
                                        'bulan'     => $geat,
                                        'header'    => $header

                                    );
                                    $this->template->load('templatenew','v_realisasi_pptk', $this->data);
                                }elseif($pertama==0){
                                    $this->db->where('id_tabpptk', $idtab);
                                    $this->db->order_by('real_bulan','DESC');
                                    $this->db->limit(1);
                                    $bulanlalu = $this->db->get('tab_realisasi');
                                    $idbl=$bulanlalu->row()->id;
                                    $rbbl=$bulanlalu->row()->real_bulan;
                                    $pecahawal = explode('-', $rbbl);
                                    $thnawal  = $pecahawal[0];
                                    $blnawal  = $pecahawal[1];
                                    $nmbln      = $arraybuln[(int)$blnawal-1];
                                    $header=$this->User_model->getheader_realisasipptk($idopd,$lskeg->kdkeg);
                                    $anggaranopd = $this->User_model->anggaranopd($idopd);
                                    $bobotkeg=$lskeg->nl/$anggaranopd->anggranopd*100;
                                    $this->data= array(
                                        'idopd'     => $idopd,
                                        'idtab'     => $idtab,
                                        'nmopd'     => $namaopd,
                                        'tahun'     => $this->tahunskr,
                                        'prog'      => $lskeg->prog,
                                        'kdkeg'     => $lskeg->kdkeg,
                                        'keg'       => $lskeg->keg,
                                        'nl'        => $lskeg->nl,
                                        'bobot'     => number_format($bobotkeg,2),
                                        'pptk'      => $lskeg->pptk,
                                        'ppk'       => $lskeg->ppk,
                                        'bulan'     => $geat,
                                        'bulanlalu' => $nmbln,
                                        'idreal'    => $idbl,
                                        'header'    => $header

                                    );
                                    $this->template->load('templatenew','v_realisasi_pptk_next', $this->data);


                                }else{
                                     $anggaranopd = $this->User_model->anggaranopd($idopd);
                                    $bobotkeg=$lskeg->nl/$anggaranopd->anggranopd*100;
                                     $this->data= array(
                                        'idopd'     => $idopd,
                                        'idtab'     => $idtab,
                                        'nmopd'     => $namaopd,
                                        'tahun'     => $this->tahunskr,
                                        'prog'      => $lskeg->prog,
                                        'kdkeg'     => $lskeg->kdkeg,
                                        'keg'       => $lskeg->keg,
                                        'nl'        => $lskeg->nl,
                                        'bobot'     => number_format($bobotkeg,2),
                                        'pptk'      => $lskeg->pptk,
                                        'ppk'       => $lskeg->ppk,


                                    );

                                    $this->template->load('templatenew','v_realisasi_pptk_list', $this->data);

                                }

                        }else{
                            redirect('User/dafkeg', 'refresh');
                        }

                    }else{
                         redirect('User/dafkeg', 'refresh');
                    }
            }
        }




            }else{
                /*jika tidak*/
                redirect('User', 'refresh');
            }
        }else{
          redirect('User', 'refresh');
      }


  }
}



function cektabrealisasi(){
    if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }
    // elseif ($this->ion_auth->is_kasubag()){
    //     redirect('User/admingeneral', 'refresh');
    //}
    else{
        /*ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        if($struktur ){

            $peran=$struktur->peran;

            if($peran=='3'){
                /*jika peran 3 maka PPTK*/
                $idtab=$this->input->post('idtab');
                $idkeg=$this->input->post('idkeg');
                $unitkey=$this->input->post('unitkey');
                $encryptionMethod = "AES-256-ECB";
                $secretHash = "aS9P0RNoKY9QcmvGDWwcZcjw6OuZKJK2VrR4Hv9UMms=";
                $it     = openssl_encrypt($idtab, $encryptionMethod, $secretHash);
                $un     = openssl_encrypt($unitkey, $encryptionMethod, $secretHash);
                $kg     = openssl_encrypt($idkeg, $encryptionMethod, $secretHash);
                $tab    = str_replace("+","%2B",$it);
                $unit   =   str_replace("+","%2B",$un);
                $kegiatan=str_replace("+","%2B",$kg);
                $cekstatkak = $this->User_model->cekstatkak($idtab);
                if($cekstatkak->num_rows()>0){
                     if($cekstatkak->row()->stat_draft==0){
                        $statreal = $this->db->get_where('tab_realisasi',array('id_tabpptk'=>$idtab));
                        if($statreal->num_rows()>0){
                            // if($statreal->row()->status==0){
                            //     //jika nol maka sudah di entri
                            //     $data['uri'][] = array(
                            //         'status' => true,
                            //         'edit'  => false,
                            //         'kak'   =>true,
                            //         'tab'   => $tab,
                            //         'unit'   => $unit,
                            //         'keg'    => $kegiatan
                            //     );
                            // }else{
                            //     //jika selain nol maka sudah entri tapi bisa di edit
                            //     $data['uri'][] = array(
                            //     'status' => true,
                            //     'edit'=> true,
                            //     'kak'   =>true,
                            //     'tab'   => $tab,
                            //     'unit'   => $unit,
                            //     'keg'    => $kegiatan
                            //     );
                            // }
                              $data['uri'][] = array(
                                'status' => false,
                                'edit'  => false,
                                'kak'   =>true,
                                'tab'   => $tab,
                                'unit'   => $unit,
                                'keg'    => $kegiatan
                           );
                        }else{
                          // row belum ada (entri Baru)
                           $data['uri'][] = array(
                                'status' => false,
                                'edit'  => false,
                                'kak'   =>true,
                                'tab'   => $tab,
                                'unit'   => $unit,
                                'keg'    => $kegiatan
                           );
                        }
                     }else{
                         $data['uri'][] = array(
                                'status' => true,
                                'edit'  => false,
                                'kak'   =>false

                           );
                     }
                }else{
                     $data['uri'][] = array(
                                'status' => true,
                                'edit'  => false,
                                'kak'   =>false

                           );
                }


                echo json_encode($data);

            }else{
                /*jika tidak*/
                redirect('User', 'refresh');
            }
        }else{
          redirect('User', 'refresh');
      }


  }

}

function simpanrealisasi(){
  if (!$this->ion_auth->logged_in()){
    redirect('Home/login', 'refresh');
}elseif ($this->ion_auth->is_admin()){
    redirect('Cpanel', 'refresh');
}elseif ($this->ion_auth->is_kasubag()){
    redirect('User/admingeneral', 'refresh');
}else{
    /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
    $nip=$this->ion_auth->user()->row()->username;
    $struktur = $this->User_model->cekstrukturpns($nip);
    $getopd = $this->User_model->getnamaopd($nip);
    $idopd =$getopd->unitkey;
    $namaopd=$getopd->nmunit;
    if($struktur ){

        $peran=$struktur->peran;
        $parent= $struktur->parent;

        if($peran=='3'){
            /*jika peran 3 maka PPTK*/

            $arraybuln = array(
                'Januari'   => 1,
                'Februari'  => 2,
                'Maret'     => 3,
                'April'     => 4,
                'Mei'       => 5,
                'Juni'      => 6,
                'Juli'      => 7,
                'Agustus'   => 8,
                'September' => 9,
                'Oktober'   => 10,
                'November'  => 11,
                'Desember'  => 12
            );
            $idubah         = $this->input->post('idubah');
            $pertama        = $this->input->post('pertama');
            $id_tabpptk     = $this->input->post('idtab');
            $bobot_keg      = $this->input->post('botkeg');
            $real_bulan     = $this->input->post('bulan');
            $real_tahun     = $this->input->post('tahun');
            $real_keuangan  = $this->input->post('realkeu');
            $tot_sisa_dana  = $this->input->post('totsdana');
            $real_fisik     = $this->input->post('realfisik');
            $bobot_real     = $this->input->post('realbobot');
            $permasalahan   = $this->input->post('masalah');
            $adminentri     = $nip;
            $tgl_entri      = date('Y/m/d h:i:sa');


            $data=array(
                'id_tabpptk'    => $id_tabpptk,
                'bobot_keg'     => $bobot_keg,
                'real_bulan'    => $real_tahun.'-'.$arraybuln[$real_bulan].'-01',
                // 'real_keuangan' => $real_keuangan,
                // 'tot_sisa_dana' => $tot_sisa_dana,
                'real_fisik'    => $real_fisik,
                'bobot_real'    => $bobot_real,
                'permasalahan'  => $permasalahan,
                'admin_entri'   => $adminentri,
                'tgl_entri'     => $tgl_entri,
                'pertama'       => $pertama,
                'id_struktur'   => $parent

            );

            $result=$this->User_model->simpanrealisasi($data,$idubah);

            if($result){

                $arr['data'][]= array(

                    'status' => true
                );
            }else{
                $arr['data'][]= array(
                    'status' => false
                );
            }
            header('Content-Type: application/json');
                    // minimal PHP 5.2
            echo json_encode($arr);


        }else{
            /*jika tidak*/
            redirect('User', 'refresh');
        }
    }else{
      redirect('User', 'refresh');
  }


}
}

function cekrealbmodal()
{
  //cek realisasi belanja modal

  $idtab      = $this->input->post('idtab');
  $mtgkey     = $this->input->post('mtgkey');
  $indexbulan = $this->input->post('indexbulan');
  // $idtab      = '5';
  // $mtgkey     = '1326_';
  // $indexbulan = '1';
  $arraytarget = array(
      'jan',
      'feb',
      'mar',
      'apr',
      'mei',
      'jun',
      'jul',
      'ags',
      'sep',
      'okt',
      'nov',
      'des'
  );
$query='';
  for($i = 0; $i < $indexbulan; $i++){
    if($i==0){
      $query .= $arraytarget[$i];
    }else {
      $query .= '+'.$arraytarget[$i];
    }
  }
  //   SELECT
  //    jan+feb+mar
  // FROM
  //     `db_sodap`.`tab_schedule_blnj_mdl`
  //     INNER JOIN `db_sodap`.`tab_target_blnj_modal`
  //         ON (`tab_schedule_blnj_mdl`.`id_tab_target` = `tab_target_blnj_modal`.`id`) WHERE `idtab_pptk`='5' AND `mtgkey`='12112_';

  $this->db->select('('.$query.') as tot');
  $this->db->from('tab_schedule_blnj_mdl');
  $this->db->join('tab_target_blnj_modal', '`tab_schedule_blnj_mdl`.`id_tab_target` = `tab_target_blnj_modal`.`id`');
  $this->db->where('idtab_pptk', $idtab);
  $this->db->where('mtgkey', $mtgkey);
  $tottargetfis = $this->db->get()->row_array();


  //select ke tab realisasi belanja modal berdasrkan id_tab_pptk dan mtgkey
  $this->db->select('*');
  $this->db->from('tab_realisasi_bmodal');
  $this->db->where('`tab_realisasi_bmodal`.`id_tab_pptk`', $idtab);
  $this->db->where('`tab_realisasi_bmodal`.`mtgkey`', $mtgkey);
  $this->db->where('`tab_realisasi_bmodal`.`stat`','1');
  $adabmodal=$this->db->get();
  //jika ada realisasi belanja modal sudah ada
  if($adabmodal->num_rows()>0){
    //cek kedetail tab real bmodal
      $idbmodal =  $adabmodal->row()->id;
      $nlktrk   =  $adabmodal->row()->nilai_ktrk;
      $pbj      =  $adabmodal->row()->penyedia_pbj;
      $awlktrk  =  $adabmodal->row()->awal_ktrk;
      $akrktrk  =  $adabmodal->row()->akhir_ktrk;
      $spmk     =  $adabmodal->row()->spmk;
      $noktrk   =  $adabmodal->row()->no_kontrak;
      //kalkulasi realfisik_bljmodal berdasarkan id_tab_real_bmodal
      $this->db->select('SUM(`realfisik_bljmodal`) AS sumary,SUM(`real_keuangan`) AS sumary_keu');
      $this->db->from('tab_realisasi_bmodal_det');
      $this->db->where('`tab_realisasi_bmodal_det`.`id_tab_real_bmodal`', $idbmodal);
      $this->db->where('`tab_realisasi_bmodal_det`.`stat`','1');
      $sumary=$this->db->get()->row();
      if($sumary){
        //jika ada
        $jumrealfis= $sumary->sumary;
        $jumrealkeu= $sumary->sumary_keu;
      }else{
        //jika tidak ada = 0
        $jumrealfis= 0;
        $jumrealkeu= 0;
      }


      //select detail realisasi belanja modal berdasarkan id_tab_real_bmodal dan real_bulan
      $this->db->select('*');
      $this->db->from('tab_realisasi_bmodal_det');
      $this->db->where('`tab_realisasi_bmodal_det`.`id_tab_real_bmodal`', $idbmodal);
      $this->db->where('MONTH(`tab_realisasi_bmodal_det`.`real_bulan`)', $indexbulan);
      $this->db->where('`tab_realisasi_bmodal_det`.`stat`','1');
      $detbmodal=$this->db->get();
      //jika ada
      if($detbmodal->num_rows() > 0){

        //maka update detail realisasi belanja modal
        $arr['data'][]= array(
            'iddet'       => $detbmodal->row()->id,
            'code'        => 4,
            'nilai_ktrk'  => $nlktrk,
            'pbj'         => $pbj,
            'awlktrk'     => $awlktrk,
            'akrktrk'     => $akrktrk,
            'spmk'        => $spmk,
            'noktrk'      => $noktrk,
            'realfisik'   => $jumrealfis, //total semua realisasi fisik
            'jumrealkeu'   => $jumrealkeu, //total semua realisasi fisik
            'realblj'     => $detbmodal->row()->realfisik_bljmodal,
            'realkeublj'   => $detbmodal->row()->real_keuangan,
            'bobotrealblj'=> $detbmodal->row()->bobot_real_bljmodal,
            'idbmodal'    => $idbmodal,
            'targetfis'   => $tottargetfis['tot']
        );


      }else{
        //status 1
        $arr['data'][]= array(

            'code'        => 1,
            'nilai_ktrk'  => $nlktrk,
            'pbj'         => $pbj,
            'awlktrk'     => $awlktrk,
            'akrktrk'     => $akrktrk,
            'spmk'        => $spmk,
            'noktrk'      => $noktrk,
            'realfisik'   => $jumrealfis,
            'jumrealkeu'   => $jumrealkeu,
            'idbmodal'    => $idbmodal,
            'targetfis'   => $tottargetfis['tot']


        );
      }

  }else{
    //code 0
    $arr['data'][]= array(
        'code' => 0,
        'targetfis'   => $tottargetfis['tot']
    );
  }



  //code 0 = belum ada sama sekali entri belnja modal pada kegiatan
  //code 1 = Master sudah ada tetapi detail belum ada (x)
  //code 2 = realisasi sudah 100 persen tidak bisa di tambah (x)
  //code 3 = realisasi belum 100 persen dan masih bisa tambah
  // $arr['data'][]= array(
  //
  //     'code' => 0
  // );
  header('Content-Type: application/json');
  echo json_encode($arr);
  // code...
  // if (!$this->ion_auth->logged_in()){
  //   redirect('Home/login', 'refresh');
  // }elseif ($this->ion_auth->is_admin()){
  //   redirect('Cpanel', 'refresh');
  // }elseif ($this->ion_auth->is_kasubag()){
  //   redirect('User/admingeneral', 'refresh');
  // }else{
  //   $nip=$this->ion_auth->user()->row()->username;
  //   $struktur = $this->User_model->cekstrukturpns($nip);
  //   $getopd = $this->User_model->getnamaopd($nip);
  //   $idopd =$getopd->unitkey;
  //   $namaopd=$getopd->nmunit;
  //   if($struktur ){
  //     $peran=$struktur->peran;
  //     if($peran=='3'){
  //
  //     }else{
  //         /*jika tidak*/
  //         redirect('User', 'refresh');
  //     }
  //   }else{
  //     redirect('User', 'refresh');
  //   }
  //
  //
  // }
}

function simpanrealisasibmodaldet(){


  if (!$this->ion_auth->logged_in()){
    redirect('Home/login', 'refresh');
  }elseif ($this->ion_auth->is_admin()){
    redirect('Cpanel', 'refresh');
  }elseif ($this->ion_auth->is_kasubag()){
    redirect('User/admingeneral', 'refresh');
  }else{
    /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
    $nip=$this->ion_auth->user()->row()->username;
    $struktur = $this->User_model->cekstrukturpns($nip);
    $getopd = $this->User_model->getnamaopd($nip);
    $idopd =$getopd->unitkey;
    $namaopd=$getopd->nmunit;
    if($struktur ){

        $peran=$struktur->peran;

        if($peran=='3'){
            /*jika peran 3 maka PPTK*/

            $arraybuln = array(
                'January'   => 1,
                'February'  => 2,
                'March'     => 3,
                'April'     => 4,
                'May'       => 5,
                'June'      => 6,
                'July'      => 7,
                'August'    => 8,
                'September' => 9,
                'October'   => 10,
                'November'  => 11,
                'December'  => 12
            );

            $arraybulnid = array(
                'Januari'   => 1,
                'Februari'  => 2,
                'Maret'     => 3,
                'April'     => 4,
                'Mei'       => 5,
                'Juni'      => 6,
                'Juli'      => 7,
                'Agustus'   => 8,
                'September' => 9,
                'Oktober'   => 10,
                'November'  => 11,
                'Desember'  => 12
            );


            $adminentri     = $nip;
            $tgl_entri      = date('Y/m/d h:i:sa');

            //detail
            $idtabreal            = $this->input->post('tabbmodal');
            $real_tahun           = $this->input->post('tahun');
            $real_bulan           = $this->input->post('bulan');
            $bobot_bljmodal       = $this->input->post('bobotbljmodal');
            $realfisik_bljmodal   = $this->input->post('realfisikbljmodal');
            $bobot_real_bljmodal  = $this->input->post('realbobotbljmodal');
            $realkeubljmodal      = $this->input->post('realkeubljmodal');



            $detail=array(
                'id_tab_real_bmodal'    => $idtabreal,
                'real_bulan'          => $real_tahun.'-'.$arraybulnid[$real_bulan].'-01',
                'real_keuangan'       => $realkeubljmodal,
                'bobot_bljmodal'      => $bobot_bljmodal,
                'realfisik_bljmodal'  => $realfisik_bljmodal,
                'bobot_real_bljmodal' => $bobot_real_bljmodal,
                'tgl_entri '          => $tgl_entri ,
                'admin_entri  '       => $adminentri


            );
            $result=$this->User_model->simpanrealisasibmodaldet($detail);

            if($result){

                $arr['data'][]= array(

                    'status' => true
                );
            }else{
                $arr['data'][]= array(
                    'status' => false
                );
            }
            header('Content-Type: application/json');
                    // minimal PHP 5.2
            echo json_encode($arr);


        }else{
            /*jika tidak*/
            redirect('User', 'refresh');
        }
    }else{
      redirect('User', 'refresh');
  }


}
}

function ubahrealisasibmodaldet(){
  if(!$this->ion_auth->logged_in()){
    redirect('Home/login', 'refresh');
  }elseif ($this->ion_auth->is_admin()){
    redirect('Cpanel', 'refresh');
  }elseif ($this->ion_auth->is_kasubag()){
    redirect('User/admingeneral', 'refresh');
  }else{
    /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
    $nip=$this->ion_auth->user()->row()->username;
    $struktur = $this->User_model->cekstrukturpns($nip);
    $getopd = $this->User_model->getnamaopd($nip);
    $idopd =$getopd->unitkey;
    $namaopd=$getopd->nmunit;
    if($struktur ){

        $peran=$struktur->peran;

        if($peran=='3'){
            /*jika peran 3 maka PPTK*/





            $adminentri     = $nip;
            $tgl_entri      = date('Y/m/d h:i:sa');

            //detail

            $iddet                = $this->input->post('iddet');
            $bobot_bljmodal       = $this->input->post('bobotbljmodal');
            $realfisik_bljmodal   = $this->input->post('realfisikbljmodal');
            $bobot_real_bljmodal  = $this->input->post('realbobotbljmodal');
            $realkeubljmodal      = $this->input->post('realkeubljmodal');


            $detail=array(
                'real_keuangan'       => $realkeubljmodal,
                'bobot_bljmodal'      => $bobot_bljmodal,
                'realfisik_bljmodal'  => $realfisik_bljmodal,
                'bobot_real_bljmodal' => $bobot_real_bljmodal,
                'tgl_entri '          => $tgl_entri ,
                'admin_entri  '       => $adminentri

            );
            $result=$this->User_model->ubahrealisasibmodaldet($detail,$iddet);

            if($result){
              $idmaster = $this->db->get_where('tab_realisasi_bmodal_det',array('id_tab_real_bmodal'=>$iddet));
              $id=$idmaster->row()->id;
              $tbmaster = $this->db->get_where('tab_realisasi_bmodal',array('id'=>$id));
              $nilaiktrk=$tbmaster->row()->nilai_ktrk;
              $this->db->select('SUM(`real_keuangan`) AS jumrealbm');
              //$this->db->where('MONTH(real_bulan)', $indexbulan);
              $this->db->where('id_tab_real_bmodal', $id);
              $detjumreal = $this->db->get('tab_realisasi_bmodal_det');
              $totnlrealbmodal=$detjumreal->row()->jumrealbm;
              $render=(int)$nilaiktrk - (int)$totnlrealbmodal;
                $arr['data'][]= array(


                    'status' => true,
                    'realkeu' => $totnlrealbmodal,
                    'sisadana' => $render,
                    'render' => $this->template->rupiah($render)
                );
            }else{
                $arr['data'][]= array(
                    'status' => false
                );
            }
            header('Content-Type: application/json');
                    // minimal PHP 5.2
            echo json_encode($arr);


        }else{
            /*jika tidak*/
            redirect('User', 'refresh');
        }
    }else{
      redirect('User', 'refresh');
  }


}
}

function simpanrealisasibmodal(){

  if (!$this->ion_auth->logged_in()){
    redirect('Home/login', 'refresh');
  }elseif ($this->ion_auth->is_admin()){
    redirect('Cpanel', 'refresh');
  }elseif ($this->ion_auth->is_kasubag()){
    redirect('User/admingeneral', 'refresh');
  }else{
    /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
    $nip=$this->ion_auth->user()->row()->username;
    $struktur = $this->User_model->cekstrukturpns($nip);
    $getopd = $this->User_model->getnamaopd($nip);
    $idopd =$getopd->unitkey;
    $namaopd=$getopd->nmunit;
    if($struktur ){

        $peran=$struktur->peran;

        if($peran=='3'){
            /*jika peran 3 maka PPTK*/

            $arraybuln = array(
                'January'   => 1,
                'February'  => 2,
                'March'     => 3,
                'April'     => 4,
                'May'       => 5,
                'June'      => 6,
                'July'      => 7,
                'August'    => 8,
                'September' => 9,
                'October'   => 10,
                'November'  => 11,
                'December'  => 12
            );

            $arraybulnid = array(
                'Januari'   => 1,
                'Februari'  => 2,
                'Maret'     => 3,
                'April'     => 4,
                'Mei'       => 5,
                'Juni'      => 6,
                'Juli'      => 7,
                'Agustus'   => 8,
                'September' => 9,
                'Oktober'   => 10,
                'November'  => 11,
                'Desember'  => 12
            );

            $id_tabpptk     = $this->input->post('idtab');
            $mtgkey         = $this->input->post('mtgkey');
            $nilai_ktrk     = $this->input->post('nilaikontrak');
            $penyedia_pbj   = $this->input->post('pbj');
            $awal_ktrk      = $this->input->post('awalktr');
            $akhir_ktrk     = $this->input->post('akhirktr');
            $spmk           = $this->input->post('spmk');
            $pagubmodalbln  = $this->input->post('pagubmodalbln');
            $no_kontrak     = $this->input->post('nomorkontrak');
            $adminentri     = $nip;
            $tgl_entri      = date('Y/m/d h:i:sa');
            $pecahawal_ktrk = explode(' ', $awal_ktrk);
            $tgl_ktrk   = $pecahawal_ktrk[0];
            $bln_ktrk   = $pecahawal_ktrk[1];
            $thn_ktrk   = $pecahawal_ktrk[2];
            $pecahakhir_ktrk = explode(' ', $akhir_ktrk);
            $tgl_akktrk   = $pecahakhir_ktrk[0];
            $bln_akktrk   = $pecahakhir_ktrk[1];
            $thn_akktrk   = $pecahakhir_ktrk[2];
            $pecahspmk = explode(' ', $spmk);
            $tgl_spmk   = $pecahspmk[0];
            $bln_spmk   = $pecahspmk[1];
            $thn_spmk   = $pecahspmk[2];
            //detail
            $real_tahun           = $this->input->post('tahun');
            $real_bulan           = $this->input->post('bulan');
            $bobot_bljmodal       = $this->input->post('bobotbljmodal');
            $realkeubljmodal      = $this->input->post('realkeubljmodal');
            $realfisik_bljmodal   = $this->input->post('realfisikbljmodal');
            $bobot_real_bljmodal  = $this->input->post('realbobotbljmodal');


            $data=array(
                'real_bulan'    => $real_tahun.'-'.$arraybulnid[$real_bulan].'-01',
                'id_tab_pptk'   => $id_tabpptk,
                'mtgkey'        => $mtgkey,
                'nilai_ktrk'    => $nilai_ktrk,
                'penyedia_pbj'  => $penyedia_pbj,
                'awal_ktrk'     => $thn_ktrk.'-'.$arraybuln[$bln_ktrk].'-'.$tgl_ktrk ,
                'akhir_ktrk'    => $thn_akktrk.'-'.$arraybuln[$bln_akktrk].'-'.$tgl_akktrk ,
                'spmk'          => $thn_spmk.'-'.$arraybuln[$bln_spmk].'-'.$tgl_spmk,
                'no_kontrak'    => $no_kontrak,
                'tgl_entri'     => $tgl_entri,
                'admin_entri'   => $adminentri

            );
            $detail=array(


                'real_bulan'          => $real_tahun.'-'.$arraybulnid[$real_bulan].'-01',
                'bobot_bljmodal'      => $bobot_bljmodal,
                'real_keuangan'       => $realkeubljmodal,
                'realfisik_bljmodal'  => $realfisik_bljmodal,
                'bobot_real_bljmodal' => $bobot_real_bljmodal,
                'tgl_entri '          => $tgl_entri ,
                'admin_entri  '       => $adminentri

            );
            $result=$this->User_model->simpanrealisasibmodal($data,$detail);

            if($result){
            //  $render=(int)$pagubmodalbln - (int)$nilai_ktrk;
              $render=(int)$nilai_ktrk - (int)$realkeubljmodal;

                $arr['data'][]= array(

                    'status' => true,
                    'nilai'=> $nilai_ktrk,
                    'realkeu' => $realkeubljmodal,
                    'render' => $this->template->rupiah($render)

                );
            }else{
                $arr['data'][]= array(
                    'status' => false
                );
            }
            header('Content-Type: application/json');
                    // minimal PHP 5.2
            echo json_encode($arr);


        }else{
            /*jika tidak*/
            redirect('User', 'refresh');
        }
    }else{
      redirect('User', 'refresh');
  }


}
}








function entrirealisasipptk(){
    if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
        redirect('User/admingeneral', 'refresh');
    }else{
    /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        if($struktur ){
            $peran=$struktur->peran;
            if($peran=='3'){
            /*jika peran 3 maka PPTK*/
            $encryptionMethod = "AES-256-ECB";
            $secretHash = "aS9P0RNoKY9QcmvGDWwcZcjw6OuZKJK2VrR4Hv9UMms=";
            if(!isset($_GET['unit'], $_GET['keg'], $_GET['tab'])) {
              redirect('User/kakppk', 'refresh');
            }else{
            $un=$_GET['unit'];
            $keg=$_GET['keg'];
            $tab=$_GET['tab'];
            if (base64_encode(base64_decode($un)) === $un && base64_encode(base64_decode($keg)) === $keg && base64_encode(base64_decode($tab)) === $tab  ){
                $unit       =openssl_decrypt($un, $encryptionMethod, $secretHash);
                $kegiatan   =openssl_decrypt($keg, $encryptionMethod, $secretHash);
                $idtab      =openssl_decrypt($tab, $encryptionMethod, $secretHash);

            } else {
                echo 'Anda Mau Kemana ??';
                die;
            }

            $nip=$this->ion_auth->user()->row()->username;
            $getopd = $this->User_model->getnamaopd($nip);
            $idopd =$getopd->unitkey;
            $namaopd=$getopd->nmunit;
            if($unit!=$idopd){

                redirect('User/kakppk', 'refresh');

            }else{

                $statkak = $this->db->get_where('tab_kak',array('idtab_pptk'=>$idtab));
                    if($statkak->num_rows()>0){
                      // $ada=1; maka tidak bisa lanjut
                     redirect('User/kakppk', 'refresh');

                    }else{
                      $lskeg = $this->User_model->getdetlistkegiatan_detppk($nip,$kegiatan);
                         if($lskeg){
                          $this->data= array(
                            'idopd'     => $idopd,
                            'idtab'     => $idtab,
                            'nmopd'     => $namaopd,
                            'tahun'     => $this->tahunskr,
                            'prog'      => $lskeg->prog,
                            'kdkeg'     => $lskeg->kdkeg,
                            'keg'       => $lskeg->keg,
                            'nl'        => $lskeg->nl,
                            'pptk'      => $lskeg->pptk,
                            'ppk'       => $lskeg->ppk
                        );

                          $this->template->load('templatenew','v_entrikak_ppk', $this->data);
                    }else{
                        redirect('User', 'refresh');
                    }
            }
        }
     }

    }else{
        /*jika tidak*/
        redirect('User', 'refresh');
    }
    }else{
      redirect('User', 'refresh');
    }

    }

}
//------------------------------------------akhir pptk--------------------------------------------------//


//------------------------------------------awal ppk---------------------------------------------------//
//------------------------------------------------------------------------------------------------------//

function kakppk(){
    if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
        redirect('User/admingeneral', 'refresh');
    }else{
        /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        if($struktur ){

            $peran=$struktur->peran;

            if($peran=='2' || $peran='6'){
                /*jika peran 2 maka PPK jika peran 6 maka Sekretaris*/
                $lskeg = $this->User_model->getdetlistkegiatan_ppk($nip);

                $this->data= array(

                    'idopd'     => $idopd,
                    'nmopd'     => $namaopd,
                    'tahun'     => $this->tahunskr,
                    'list'      => $lskeg
                );
                $this->template->load('templatenew','v_dafkeg_ppk',$this->data);


            }else{
                /*jika tidak*/
                redirect('User', 'refresh');
            }
        }else{
          redirect('User', 'refresh');
      }


  }

}
function simpankak(){
  if (!$this->ion_auth->logged_in()){
    redirect('Home/login', 'refresh');
}elseif ($this->ion_auth->is_admin()){
    redirect('Cpanel', 'refresh');
}elseif ($this->ion_auth->is_kasubag()){
    redirect('User/admingeneral', 'refresh');
}else{
    /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
    $nip=$this->ion_auth->user()->row()->username;
    $struktur = $this->User_model->cekstrukturpns($nip);
    $getopd = $this->User_model->getnamaopd($nip);
    $idopd =$getopd->unitkey;
    $namaopd=$getopd->nmunit;
    if($struktur ){

        $peran=$struktur->peran;

        if($peran=='2' || $peran=='6' ){
            /*jika peran 2 maka PPK*/
            $lskeg = $this->User_model->getdetlistkegiatan_ppk($nip);

            $adminentri     = $nip;
            $tgl_entri      = date('Y/m/d h:i:sa');
            $idtab          = $this->input->post('idtab');
            $i_a_ltrblk     = $this->input->post('lb');
            $i_b_1_tujuan   = $this->input->post('tj');
            $i_b_2_sasaran  = $this->input->post('ssr');
            $c_1_input      = $this->input->post('inp');
            $c_2_output     = $this->input->post('otp');
            $c_3_outcome    = $this->input->post('otc');
            $ii_awal_keg    = $this->input->post('awk');
            $ii_akhir_keg   = $this->input->post('akk');
            $pplaksana      = $this->input->post('pplasana');
            $iii_penutup    = $this->input->post('pnt');
            $sc             = $this->input->post('tms');
            $masterkak=array(
                'idtab_pptk' => $idtab,
                'i_a_ltrblk'  =>  $i_a_ltrblk,
                'i_b_1_tujuan'  =>  $i_b_1_tujuan,
                'i_b_2_sasaran' =>  $i_b_2_sasaran,
                'c_1_input' =>  $c_1_input,
                'c_2_output' =>  $c_2_output,
                'c_3_outcome' =>  $c_3_outcome,
                'ii_awal_keg' =>  $ii_awal_keg,
                'ii_akhir_keg' =>  $ii_akhir_keg,
                'iii_proses_pelaksana' => $pplaksana,
                'iii_penutup' =>  $iii_penutup,
                'admin_entri'=> $adminentri,
                'tgl_entri'  => $tgl_entri
            );



            $result=$this->User_model->simpanentrikak($masterkak);

            if($result){

                $arr['data'][]= array(

                    'status' => true
                );
            }else{
                $arr['data'][]= array(
                    'status' => false
                );
            }
            header('Content-Type: application/json');
                    // minimal PHP 5.2
            echo json_encode($arr);


        }else{
            /*jika tidak*/
            redirect('User', 'refresh');
        }
    }else{
      redirect('User', 'refresh');
  }


}
}

/*dari AGUNG----AGUNG----AGUNG----AGUNG----AGUNG----AGUNG----AGUNG----AGUNG*/

function viewkakppk(){
    if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
        redirect('User/admingeneral', 'refresh');
    }else{
        /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        if($struktur ){

            $peran=$struktur->peran;

            if($peran=='2'){
                /*jika peran 2 maka PPK*/

                $encryptionMethod = "AES-256-ECB";
                $secretHash = "aS9P0RNoKY9QcmvGDWwcZcjw6OuZKJK2VrR4Hv9UMms=";
                if(!isset($_GET['unit'], $_GET['keg'], $_GET['tab'])) {

                  redirect('User/kakppk', 'refresh');
                }else{
                    $un=$_GET['unit'];
                    $keg=$_GET['keg'];
                    $tab=$_GET['tab'];
                    if (base64_encode(base64_decode($un)) === $un && base64_encode(base64_decode($keg)) === $keg && base64_encode(base64_decode($tab)) === $tab  ){
                        $unit       =openssl_decrypt($un, $encryptionMethod, $secretHash);
                        $kegiatan   =openssl_decrypt($keg, $encryptionMethod, $secretHash);
                        $idtab      =openssl_decrypt($tab, $encryptionMethod, $secretHash);

                    } else {
                        echo 'Anda Mau Kemana ??';
                        die;
                    }

                    $lskak = $this->User_model->getkak_by($idtab);
                    $schedule = $this->User_model->getSchedule_by($lskak->id);
                    $schedule_blj_modal = $this->User_model->getBljModal_by($idtab);

                    $this->data= array(

                        'idopd'     => $idopd,
                        'nmopd'     => $namaopd,
                        'tahun'     => $this->tahunskr,
                        'list'      => $lskak,
                        'schedule'      => $schedule,
                        'schbelanja'      => $schedule_blj_modal,
                        'idkeg' => $kegiatan,
                        'idtab' => $idtab
                    );
                    $this->template->load('templatenew','v_kak',$this->data);
                }

            }else{
                /*jika tidak*/
                redirect('User', 'refresh');
            }
        }else{
          redirect('User', 'refresh');
      }


  }
}

// LAPORAN KAK

function lapkak($idtab){

       if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
        redirect('User/admingeneral', 'refresh');
    }
        $this->load->library('mytcpdf');
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        $namappk = $this->User_model->getnamappk($idtab);
        $ttd = $this->User_model->getttdkak($idtab);
        $lskak = $this->User_model->getkak_by($idtab);
        $schedule = $this->User_model->getSchedule_by($lskak->id);
        $schedule_blj_modal = $this->User_model->getBljModal_by($idtab);
//        var_dump($lskak);exit;
        $this->data= array(

                         'idopd'     => $idopd,
                        'nmopd'     => $namaopd,
                        'idtab' => $idtab,
                        'tahun'     => $this->tahunskr,
                        'nama'   => $namappk,
                        'ttd'  => $ttd,
                        'list'      => $lskak



        );
      //    echo json_encode ($this->data);
        $this->load->view('lap_kak',$this->data);

    }
function timeschedule($idtab){

       if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
        redirect('User/admingeneral', 'refresh');
    }
        $this->load->library('mytcpdf');
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;

        $lskak = $this->User_model->getkak_by($idtab);
        $schedule = $this->User_model->getSchedule_by($lskak->id);
        $schedule_blj_modal = $this->User_model->getBljModal_by($idtab);
        $this->data= array(

                         'idopd'     => $idopd,
                        'nmopd'     => $namaopd,
                        'idtab' => $idtab,
                        'tahun'     => $this->tahunskr,
                         'schedule'      => $schedule,
                          'schbelanja'      => $schedule_blj_modal,

                        'list'      => $lskak
        );
        //
        //echo json_encode ($schedule[0]);
      $this->load->view('lap_timeschedule',$this->data);
    }
    //end laporan




function jsoncheckbodal(){
    $idkeg=$this->input->post('idkeg');
    $unitkey=$this->input->post('unitkey');
    $idtabpptk=$this->input->post('idtab');

    $bmodal = $this->User_model->getBljModal_by($idtabpptk);
    $kak = $this->User_model->getkak_by($idtabpptk);

    $rek = array();
    $nmrek = array();
    $target = array();
    $arrTarget = array();
    foreach ($bmodal as $key) {
        $rek = $key->no_rekening;
        $nmrek = $key->nama_rekening;
        $target = array(
                    $key->jan,
                    $key->feb,
                    $key->mar,
                    $key->apr,
                    $key->mei,
                    $key->jun,
                    $key->jul,
                    $key->ags,
                    $key->sep,
                    $key->okt,
                    $key->nov,
                    $key->des
                    );
        $arrTarget[]= array(
                        'no_rekening' =>$rek,
                        'nama_rekening' =>$nmrek,
                        'target' =>$target
                        );
    }
    $status = false;
    if($bmodal){
        $status = true;
    }
    $data = array(
        'status' => $status,
        'nmKegiatan' => $kak->kegiatan,
        'pagu_dana' => $kak->pagu_dana,
        'nama_pptk' => $kak->nama_pptk,
        'bljmodal' => $arrTarget
    );
    echo json_encode($data);
}
/*sampai AGUNG----AGUNG----AGUNG----AGUNG----AGUNG----AGUNG----AGUNG----AGUNG*/
function simpantargetfisik(){
  if (!$this->ion_auth->logged_in()){
    redirect('Home/login', 'refresh');
}elseif ($this->ion_auth->is_admin()){
    redirect('Cpanel', 'refresh');
}elseif ($this->ion_auth->is_kasubag()){
    redirect('User/admingeneral', 'refresh');
}else{
    /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
    $nip=$this->ion_auth->user()->row()->username;
    $struktur = $this->User_model->cekstrukturpns($nip);
    $getopd = $this->User_model->getnamaopd($nip);
    $idopd =$getopd->unitkey;
    $namaopd=$getopd->nmunit;
    if($struktur ){

        $peran=$struktur->peran;

        if($peran=='2'){
            /*jika peran 2 maka PPK*/

            $idtab_pptk = $this->input->post('idtab');
            $id_mtde_plk= $this->input->post('metode');
            $mtgkey     = $this->input->post('mtgkey');
            $adminentri = $nip;
            $tgl_entri  = date('Y/m/d h:i:sa');
            $stat_draft = 1;

            $jan        = $this->input->post('0');
            $feb        = $this->input->post('1');
            $mar        = $this->input->post('2');
            $apr        = $this->input->post('3');
            $mei        = $this->input->post('4');
            $jun        = $this->input->post('5');
            $jul        = $this->input->post('6');
            $ags        = $this->input->post('7');
            $sep        = $this->input->post('8');
            $okt        = $this->input->post('9');
            $nov        = $this->input->post('10');
            $des        = $this->input->post('11');

            $data=array(
                'idtab_pptk'    => $idtab_pptk,
                'id_mtde_plk'   => $id_mtde_plk,
                'mtgkey'        => $mtgkey,
                'admin_entri'   => $adminentri,
                'tgl_entri'     => $tgl_entri,
                'stat_draft'    => $stat_draft
            );

            $detail=array(
                'jan'   => $jan,
                'feb'   => $feb,
                'mar'   => $mar,
                'apr'   => $apr,
                'mei'   => $mei,
                'jun'   => $jun,
                'jul'   => $jul,
                'ags'   => $ags,
                'sep'   => $sep,
                'okt'   => $okt,
                'nov'   => $nov,
                'des'   => $des
            );
            $result=$this->User_model->simpantargetfisik($data , $detail);

            if($result){

                $arr['data'][]= array(

                    'status' => true
                );
            }else{
                $arr['data'][]= array(
                    'status' => false
                );
            }
            header('Content-Type: application/json');
                    // minimal PHP 5.2
            echo json_encode($arr);


        }else{
            /*jika tidak*/
            redirect('User', 'refresh');
        }
    }else{
      redirect('User', 'refresh');
  }


}
}

function selesaikantargetfisik(){
  if (!$this->ion_auth->logged_in()){
    redirect('Home/login', 'refresh');
}elseif ($this->ion_auth->is_admin()){
    redirect('Cpanel', 'refresh');
}elseif ($this->ion_auth->is_kasubag()){
    redirect('User/admingeneral', 'refresh');
}else{
    /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
    $nip=$this->ion_auth->user()->row()->username;
    $struktur = $this->User_model->cekstrukturpns($nip);
    $getopd = $this->User_model->getnamaopd($nip);
    $idopd =$getopd->unitkey;
    $namaopd=$getopd->nmunit;
    if($struktur ){

        $peran=$struktur->peran;

        if($peran=='2'){
            /*jika peran 2 maka PPK*/

            $idtab_pptk = $this->input->post('tabppk');

            $tgl_updt  = date('Y/m/d h:i:sa');
            $data=array(
                        'stat_draft'    => 0,
                        'tgl_update'    => $tgl_updt
                    );

            $updatedraft=$this->User_model->updraft($data,$idtab_pptk);

            if($updatedraft){

                $arr['data'][]= array(

                    'status' => true
                );
            }else{
                $arr['data'][]= array(
                    'status' => false
                );
            }
            header('Content-Type: application/json');
                    // minimal PHP 5.2
            echo json_encode($arr);


        }else{
            /*jika tidak*/
            redirect('User', 'refresh');
        }
    }else{
      redirect('User', 'refresh');
  }


}
}


function jsondetkegppk(){
    $idkeg=$this->input->post('idkeg');
    $unitkey=$this->input->post('unitkey');
         //  $idkeg='11142_';
         // $unitkey='80_';
    $nip=$this->ion_auth->user()->row()->username;
    $lskeg = $this->User_model->getdetlistkegiatan_detppk($nip,$idkeg);
    $data['header'][] = array(
       'kdkegunit'   =>   $lskeg->kdkegunit,
       'nmkegunit'   =>   $lskeg->nmkegunit,
       'nilai'       =>   $lskeg->nilai,
       'msknilai'    =>   $this->template->rupiah($lskeg->nilai),
       'idpnspptk'   =>   $lskeg->idpnspptk,
       'idpnsppk'    =>   $lskeg->idpnsppk
   );
    echo json_encode($data);
}

function cekstatkak(){
     if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
        redirect('User/admingeneral', 'refresh');
    }else{
        /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        if($struktur ){

            $peran=$struktur->peran;

            if($peran=='2' || $peran=='6'){
                /*jika peran 2 maka PPK*/
                $idtab=$this->input->post('idtab');
                $idkeg=$this->input->post('idkeg');
                $unitkey=$this->input->post('unitkey');
                $encryptionMethod = "AES-256-ECB";
                $secretHash = "aS9P0RNoKY9QcmvGDWwcZcjw6OuZKJK2VrR4Hv9UMms=";
                $it     = openssl_encrypt($idtab, $encryptionMethod, $secretHash);
                $un     = openssl_encrypt($unitkey, $encryptionMethod, $secretHash);
                $kg     = openssl_encrypt($idkeg, $encryptionMethod, $secretHash);
                $tab    = str_replace("+","%2B",$it);
                $unit   =   str_replace("+","%2B",$un);
                $kegiatan=str_replace("+","%2B",$kg);
                $statkak = $this->db->get_where('tab_kak',array('idtab_pptk'=>$idtab));
                    if($statkak->num_rows()>0){
                      // $ada=1; maka tidak bisa lanjut
                      if($statkak->row()->stat_draft==0){
                          $data['uri'][] = array(
                                'status' => true,
                                'edit'  => false,
                                'tab'   => $tab,
                                'unit'   => $unit,
                                'keg'    => $kegiatan
                           );
                      }else{
                          $data['uri'][] = array(
                            'status' => true,
                            'edit'=> true,
                            'tab'   => $tab,
                            'unit'   => $unit,
                            'keg'    => $kegiatan
                       );

                      }

                    }else{
                      // $ada=0; lanjut karna belum ada
                       $data['uri'][] = array(
                            'status' => false,
                            'edit'  => false,
                            'tab'   => $tab,
                            'unit'   => $unit,
                            'keg'    => $kegiatan
                       );
                    }

                echo json_encode($data);

            }else{
                /*jika tidak*/
                redirect('User', 'refresh');
            }
        }else{
          redirect('User', 'refresh');
      }


  }

}
function cekblnjamdal(){
     if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
        redirect('User/admingeneral', 'refresh');
    }else{
        /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        if($struktur ){

            $peran=$struktur->peran;

            if($peran=='2' || $peran=='6' ){
                /*jika peran 2 maka PPK*/
                $unitkey    =$this->input->post('idopd');
                $idkeg      =$this->input->post('idkeg');
                $idtab      =$this->input->post('idtab');
                $encryptionMethod = "AES-256-ECB";
                $secretHash = "aS9P0RNoKY9QcmvGDWwcZcjw6OuZKJK2VrR4Hv9UMms=";
                $it         = openssl_encrypt($idtab, $encryptionMethod, $secretHash);
                $un         = openssl_encrypt($unitkey, $encryptionMethod, $secretHash);
                $kg         = openssl_encrypt($idkeg, $encryptionMethod, $secretHash);
                $tab        = str_replace("+","%2B",$it);
                $unit       = str_replace("+","%2B",$un);
                $kegiatan   = str_replace("+","%2B",$kg);

                $blnjamodal = $this->User_model->cekblnjamodal($unitkey,$idkeg);

                if($blnjamodal->num_rows()>0){
                    //update ke draft tab_kak
                      // $ada=1; maka tidak bisa lanjut
                    $data=array(
                        'stat_draft'        => 1
                    );
                    $updatedraft=$this->User_model->updraft($data,$idtab);

                    $data['uri'][] = array(
                            'status' => true,
                            'tab'    => $tab,
                            'unit'   => $unit,
                            'keg'    => $kegiatan
                       );
                    }else{
                        $data['uri'][] = array(
                            'status' => false,
                            'tab'    => $tab,
                            'unit'   => $unit,
                            'keg'    => $kegiatan
                       );
                    }


                echo json_encode($data);

            }else{
                /*jika tidak*/
                redirect('User', 'refresh');
            }
        }else{
          redirect('User', 'refresh');
      }


  }

}

function entrikak(){
    if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
        redirect('User/admingeneral', 'refresh');
    }else{
    /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
    $nip=$this->ion_auth->user()->row()->username;
    $struktur = $this->User_model->cekstrukturpns($nip);
    $getopd = $this->User_model->getnamaopd($nip);
    $idopd =$getopd->unitkey;
    $namaopd=$getopd->nmunit;
    if($struktur ){
        $peran=$struktur->peran;
        if($peran=='2' || $peran=='6'){
            /*jika peran 2 maka PPK*/
            $encryptionMethod = "AES-256-ECB";
            $secretHash = "aS9P0RNoKY9QcmvGDWwcZcjw6OuZKJK2VrR4Hv9UMms=";
            if(!isset($_GET['unit'], $_GET['keg'], $_GET['tab'])) {

              redirect('User/kakppk', 'refresh');
          }else{
            $un=$_GET['unit'];
            $keg=$_GET['keg'];
            $tab=$_GET['tab'];
            if (base64_encode(base64_decode($un)) === $un && base64_encode(base64_decode($keg)) === $keg && base64_encode(base64_decode($tab)) === $tab  ){
                $unit       =openssl_decrypt($un, $encryptionMethod, $secretHash);
                $kegiatan   =openssl_decrypt($keg, $encryptionMethod, $secretHash);
                $idtab      =openssl_decrypt($tab, $encryptionMethod, $secretHash);

            } else {
                echo 'Anda Mau Kemana ??';
                die;
            }

            $nip=$this->ion_auth->user()->row()->username;
            $getopd = $this->User_model->getnamaopd($nip);
            $idopd =$getopd->unitkey;
            $namaopd=$getopd->nmunit;
            if($unit!=$idopd){

                redirect('User/kakppk', 'refresh');

            }else{

                $statkak = $this->db->get_where('tab_kak',array('idtab_pptk'=>$idtab));
                    if($statkak->num_rows()>0){
                      // $ada=1; maka tidak bisa lanjut
                     redirect('User/kakppk', 'refresh');

                    }else{
                      $lskeg = $this->User_model->getdetlistkegiatan_detppk($nip,$kegiatan);
                         if($lskeg){
                          $this->data= array(
                            'idopd'     => $idopd,
                            'idtab'     => $idtab,
                            'nmopd'     => $namaopd,
                            'tahun'     => $this->tahunskr,
                            'prog'      => $lskeg->prog,
                            'kdkeg'     => $lskeg->kdkeg,
                            'keg'       => $lskeg->keg,
                            'nl'        => $lskeg->nl,
                            'pptk'      => $lskeg->pptk,
                            'ppk'       => $lskeg->ppk
                        );

                          $this->template->load('templatenew','v_entrikak_ppk', $this->data);
                    }else{
                        redirect('User', 'refresh');
                    }
            }
     }
 }

}else{
    /*jika tidak*/
    redirect('User', 'refresh');
}
}else{
  redirect('User', 'refresh');
}

}

}


function jsonlistbmodal($unit,$kegiatan){
    header('Content-Type: application/json');
    echo $this->User_model->jsonlistbmodal($unit,$kegiatan);
}

function entritblnjmodal(){
    if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
        redirect('User/admingeneral', 'refresh');
    }else{
    /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
    $nip=$this->ion_auth->user()->row()->username;
    $struktur = $this->User_model->cekstrukturpns($nip);
    $getopd = $this->User_model->getnamaopd($nip);
    $idopd =$getopd->unitkey;
    $namaopd=$getopd->nmunit;
    if($struktur ){
        $peran=$struktur->peran;
        if($peran=='2'){
            /*jika peran 2 maka PPK*/
            $encryptionMethod = "AES-256-ECB";
            $secretHash = "aS9P0RNoKY9QcmvGDWwcZcjw6OuZKJK2VrR4Hv9UMms=";
            if(!isset($_GET['unit'], $_GET['keg'], $_GET['tab'])) {

              redirect('User/kakppk', 'refresh');
          }else{
            $un=$_GET['unit'];
            $keg=$_GET['keg'];
            $tab=$_GET['tab'];

            if (base64_encode(base64_decode($un)) === $un && base64_encode(base64_decode($keg)) === $keg && base64_encode(base64_decode($tab)) === $tab  ){
                $unit       =openssl_decrypt($un, $encryptionMethod, $secretHash);
                $kegiatan   =openssl_decrypt($keg, $encryptionMethod, $secretHash);
                $idtab      =openssl_decrypt($tab, $encryptionMethod, $secretHash);

            } else {
                echo 'Anda Mau Kemana ??';
                die;
            }

            $nip=$this->ion_auth->user()->row()->username;
            $getopd = $this->User_model->getnamaopd($nip);
            $idopd =$getopd->unitkey;
            $namaopd=$getopd->nmunit;
            if($unit!=$idopd){
                redirect('User/kakppk', 'refresh');
            }else{
                $blnjamodal = $this->User_model->cekblnjamodal($unit,$kegiatan);
                if($blnjamodal->num_rows()>0){
                    //amankan dari copy paste link salah yang tidak ada belanja modal
                    $statkak = $this->db->get_where('tab_kak',array('idtab_pptk'=>$idtab,'stat_draft'=>'1'));
                    if($statkak->num_rows()>0){
                        $lskeg = $this->User_model->getdetlistkegiatan_detppk($nip,$kegiatan);
                        // cari belanja modal dengan 5.2.3.
                        $pecahawal = explode('-', $statkak->row()->ii_awal_keg);
                        $thnawal  = $pecahawal[0];
                        $blnawal  = $pecahawal[1];
                        $pecahakhir = explode('-', $statkak->row()->ii_akhir_keg);
                        $thnakhir  = $pecahakhir[0];
                        $blnakhir  = $pecahakhir[1];
                         if($lskeg){
                            $this->data= array(
                                'idopd'     => $idopd,
                                'idtab'     => $idtab,
                                'nmopd'     => $namaopd,
                                'tahun'     => $this->tahunskr,
                                'prog'      => $lskeg->prog,
                                'kdkeg'     => $lskeg->kdkeg,
                                'keg'       => $lskeg->keg,
                                'nl'        => $lskeg->nl,
                                'pptk'      => $lskeg->pptk,
                                'ppk'       => $lskeg->ppk,
                                'awaltahun' => $thnawal,
                                'blnawal'   => $blnawal,
                                'akhirtahun' => $thnakhir,
                                'blnakhir'   => $blnakhir,
                                'blmodal'   => $blnjamodal->result_array()
                            );
                            $this->template->load('templatenew','v_entribmodal_ppk', $this->data);
                        }else{
                            redirect('User/kakppk', 'refresh');
                        }
                    }else{
                         redirect('User/kakppk', 'refresh');
                    }


                }else{
                    redirect('User/kakppk', 'refresh');
                }
            }
        }

}else{
    /*jika tidak*/
    redirect('User', 'refresh');
}
}else{
  redirect('User', 'refresh');
}

}

}


function cektargetfisik(){
    // '80_'
    // '11338_'
        $kdunit  = $this->input->post('kdunit');
        $kdkeg   = $this->input->post('kdkeg');
        $result=$this->User_model->cektargetfisik($kdunit,$kdkeg);
        $data= array();
        foreach ($result as $key ) {
                $ada=$key->ada;
               array_push($data,$ada);
        }
        if (in_array('0', $data, true)) {
              $arr['data'][]= array(
                'status' => false
            );
        }else{
             $arr['data'][]= array(
                'status' => true
            );
        }

        header('Content-Type: application/json');
        // minimal PHP 5.2
        echo json_encode($arr);
    }



//------------------------------------------akhir ppk--------------------------------------------------//


//------------------------------------------awal sekreataris -------------------------------------------//
function dafkegsekretaris(){


    if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
       /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
        redirect('User/admingeneral', 'refresh');

    }else{
        /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        $getopd = $this->User_model->getnamaopd($nip);
        $idopd =$getopd->unitkey;
        $namaopd=$getopd->nmunit;
        if($struktur ){

            $peran=$struktur->peran;

            if($peran=='6'){
                /*jika peran 6 maka Sekretaris*/
                $arridtabpptk = array();
                $arrkdkegunit = array();


                $thnsekarang= $this->tahunskr;
                $blnsekarang=  date('n');
              //$blnsekarang=  2;
                $lskeg = $this->User_model->getdetlistkegiatan_ppk($nip);
                if($lskeg){
                  foreach ($lskeg as $key) {

                      $arridtabpptk[]= $key['id'];
                      $arrkdkegunit[]= $key['kdkegunit'];
                  }
                  //nilai pagu
                  $datapagu=$this->User_model->pagupptksekretaris($thnsekarang,$blnsekarang,$idopd,$arrkdkegunit);
                  // output nilai Pagu ----->>> echo json_encode($datapagu[0]['tahun']);
                  //nilai persentase
                  // $persentase =

                }


                $this->data= array(
                    'idopd'     => $idopd,
                    'nmopd'     => $namaopd,
                    'tahun'     => $thnsekarang,
                    'list'      => $lskeg,
                    'blnskr'    => $blnsekarang,
                    'datapagu'  => $datapagu
                );
                // echo json_encode($datapagu[0]['tahun']);
                 //echo json_encode($lskeg);
                $this->template->load('templatenew','v_dafkeg_pptk_sekretaris',$this->data);

            }else{
                /*jika tidak*/
                redirect('User', 'refresh');
            }
        }else{
          redirect('User', 'refresh');
        }


  }
}


//------------------------------------------akhir sekreataris-------------------------------------------//

//batas new




function daftarkegiatan(){

    if (!$this->ion_auth->logged_in()){
        redirect('Home/login', 'refresh');
    }elseif ($this->ion_auth->is_admin()){
        redirect('Cpanel', 'refresh');
    }elseif ($this->ion_auth->is_kasubag()){
        redirect('User/admingeneral', 'refresh');
    }else{

        $kosong[]=array(
            'id'        =>"0",
            'idpnspptk' =>"0",
            'kdkegunit' =>"s",
            'namakeg'   => "Tidak ada ada ",
            'nilai'     => "0"

        );
        /*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
        $nip=$this->ion_auth->user()->row()->username;
        $struktur = $this->User_model->cekstrukturpns($nip);
        if($struktur ){
            $peran=$struktur->peran;
            if($peran=='3'){
                /*jika peran 3 maka PPTK*/
                $datakegiatan =$this->User_model->daftarkegiatan($nip);
                if($datakegiatan){
                    $this->data= array(
                        'list'     =>  $datakegiatan
                    );
                    $this->template->load('template','v_daftarkegiatan',$this->data);
                }else{
                    $this->data= array(
                        'list'     =>  $kosong
                    );
                    $this->template->load('template','v_daftarkegiatan',$this->data);
                        // echo json_encode($kosong);
                }

            }else{
                /*jika tidak user biasa*/
                $this->template->load('template','dashboard');
            }
        }else{
            $this->template->load('template','dashboard');
        }


    }
}


function tes(){
    $x=0;
    for($i = 0; $i < 12; $i++){
        echo    $x++;



    }
}
function detail($id){

 $nip=$this->ion_auth->user()->row()->username;
 $rowunit=$this->User_model->getpns($nip);
 $idunit=$rowunit->unitkey;
 $data['namappk']=$this->User_model->getnamapns($id);

     /*$x=0;
        for($i = 0; $i < 12; $i++){
       $data= $this->User_model->vuang.$i+1;($id);
   }*/
   $data['jan']= $this->User_model->vuang1 ($id);
   $data['feb']= $this->User_model->vuang2 ($id);
   $data['mar']= $this->User_model->vuang3 ($id);
   $data['apr']= $this->User_model->vuang4 ($id);
   $data['mei']= $this->User_model->vuang5 ($id);
   $data['jun']= $this->User_model->vuang6 ($id);
   $data['jul']= $this->User_model->vuang7 ($id);
   $data['agus']= $this->User_model->vuang8 ($id);
   $data['sep']= $this->User_model->vuang9 ($id);
   $data['oct']= $this->User_model->vuang10 ($id);
   $data['nov']= $this->User_model->vuang11 ($id);
   $data['des']= $this->User_model->vuang12 ($id);

   $row = $this->User_model->getdetail($id, $nip);
   if ($row) {
    $data['data'] = array(
       'id' => $row->id,
       'nmkegunit' => $row->nmkegunit,
       'namaunit' => $row->namaunit,
       'tahun' => $row->tahun,
       'nilai' => $row->nilai
   );

    $this->template->load('template', 'v_keuangan', $data);
             //echo json_encode($data) ;
} else {
    redirect('User/general', 'refresh');
}

}

function fisik($id){

 $nip=$this->ion_auth->user()->row()->username;
 $rowunit=$this->User_model->getpns($nip);
 $idunit=$rowunit->unitkey;
 $getnama=$this->User_model->getnamapns($id);
 $nama=$getnama->nama;

 $row = $this->User_model->getdetail($id, $nip);

 if ($row) {
    $data = array(
       'id' => $row->id,
       'nmkegunit' => $row->nmkegunit,
       'namaunit' => $row->namaunit,
       'tahun' => $row->tahun,
       'nilai' => $row->nilai,
       'namappk' => $nama
   );

    $this->template->load('template', 'v_targetfisik', $data);
} else {
    redirect('User/general', 'refresh');
}

}

function simpanfisik(){
        /*if (!$this->ion_auth->logged_in()){
            redirect('Home/login', 'refresh');
        }elseif ($this->ion_auth->is_admin()){
            redirect('Cpanel', 'refresh');
        }elseif ($this->ion_auth->is_kasi()){
            $nip            = $this->ion_auth->user()->row()->username;
            $rowunit        = $this->User_model->getpns($nip);
            $unitkey        = $rowunit->unitkey;
            $adminentri     = $nip;

            $fisik=array(
               'kdkegunit'   => $kdkegunit,
               'kd_bulan'    => $this->input->post('1'),
               'kd_bulan'    => $this->input->post('2'),
               'kd_bulan'    => $this->input->post('3'),
               'kd_bulan'    => $this->input->post('4'),
               'kd_bulan'    => $this->input->post('5'),
               'kd_bulan'    => $this->input->post('6'),
               'kd_bulan'    => $this->input->post('7'),
               'kd_bulan'    => $this->input->post('8'),
               'kd_bulan'    => $this->input->post('9'),
               'kd_bulan'    => $this->input->post('10'),
               'kd_bulan'    => $this->input->post('11'),
               'kd_bulan'    => $this->input->post('12'),
               'targetfisik' => $targetfisik,
               'unitkey'     => $unitkey,
               'pnspptk'     => $pnspptk
            );
            $result=$this->User_model->simpanfisik($fisik);
            if($result){
                echo json_encode(array("status" => TRUE));
            }
        }else{
            redirect('User/general', 'refresh');
        }   */
        echo  $this->input->post('1');
        echo  $this->input->post('2');
        echo  $this->input->post('3');
        echo  $this->input->post('4');
        echo  $this->input->post('5');
        echo  $this->input->post('6');
        echo  $this->input->post('7');
        echo  $this->input->post('8');
        echo  $this->input->post('9');
        echo  $this->input->post('10');
        echo  $this->input->post('11');
        echo  $this->input->post('12');
    }




    function realisasi($id){

     $nip=$this->ion_auth->user()->row()->username;
     $rowunit=$this->User_model->getpns($nip);
     $idunit=$rowunit->unitkey;
     $row = $this->User_model->getdetail($id, $nip);

     if ($row) {
        $data = array(
           'id' => $row->id,
           'nmkegunit' => $row->nmkegunit,
           'namaunit' => $row->namaunit,
           'tahun' => $row->tahun,
                //'idpnsppk' => $row->idpnsppk,
           'nilai' => $row->nilai
       );

        $this->template->load('template', 'v_realisasi', $data);
    } else {
        redirect('User/general', 'refresh');
    }

}

//akhir pptk
function logout()
{
    $this->data['title'] = "Logout";
        // log the user out
    $logout = $this->ion_auth->logout();
        // redirect them to the login page
    $this->session->set_flashdata('message', $this->ion_auth->messages());
    redirect('Kasi', 'refresh');
}


//<--function created by ragaa
    function getjsonrealisasi($kdkegunit)
    {
        //echo $kdbulan;

        //$kdbulan = date('m');
        $nip=$this->ion_auth->user()->row()->username;
        $unitkeyppk = $this->User_model->getunitkeyppk($nip);
        $data = $this->User_model->rincianrealisasi($kdkegunit);
        $databmodal = $this->User_model->getmatangrbmodal($kdkegunit);
        $idstrukturppk = $this->User_model->getidstrukturppk($nip);
        $jsondata = array();
        if($data!=0&&$databmodal!=0){
            $matangr = $this->User_model->getmatangr($kdkegunit);
            $realbmodal = $this->User_model->getrealbmodal($kdkegunit);
            $angkasbmodal = $this->User_model->getangkasbmodal($kdkegunit,$unitkeyppk);
            foreach ($matangr as $m){
                $datamatangr[] = array(
                    'kdper' => $m['kdper'],
                    'nmper' => $m['nmper'],
                    'mtgkey' => $m['mtgkey'],
                    'sisa_dana' => $this->template->rupiah($m['sisa_dana'])
                );
            }
            foreach ($data as $d){
                $jsondata[] = array(
                    'id_tab_realisasi' => $d['id_tab_realisasi'],
                    'id_struktur' => $d['id_struktur'],
                    'mtgkey' => $d['mtgkey'],
                    'nmper' => $d['nmper'],
                    'kdper' => $d['kdper'],
                    'real_bulan' => $d['real_bulan'],
                    'bobot_real' => $d['bobot_real'],
                    'tgl_entri' => $d['tgl_entri'],
                    'nm_dana' => $d['nm_dana'],
                    'harga_satuan' => $this->template->rupiah($d['harga_satuan']),
                    'jumlah_harga' => $this->template->rupiah($d['jumlah_harga']),
                    'sisa_dana' => $this->template->rupiah($d['sisa_dana']),
                    'vol' => $d['vol'],
                    'satuan' => $d['satuan'],
                    'urn' => $d['uraian']

                );
            }

            foreach ($realbmodal as $rbm) {
              // code...
              $jsondatabmodal[] = array(
                'id_tab_realisasi_bmodal' => $rbm['id_tab_realisasi_bmodal'],
                'id_struktur' => $rbm['id_struktur'],
                'mtgkey' => $rbm['mtgkey'],
                'urn' => $rbm['uraian'],
                'satuan' => $rbm['satuan'],
                'vol' => $rbm['vol'],
                'harga_satuan' => $this->template->rupiah($rbm['harga_satuan']),
                'jumlah_harga' => $this->template->rupiah($rbm['jumlah_harga']),

              );
            }
            foreach ($angkasbmodal as $abm ) {
              // code...
              $jsonangkasbmodal[] = array(
                'nilai' => $abm['nilai'],
                'mtgkey' => $abm['mtgkey'],

              );
            }
            for($i=0;$i<count($databmodal);$i++){
              $totalnilaiangkas=0;
              for($j=0;$j<count($jsonangkasbmodal);$j++){
                if($databmodal[$i]['mtgkey']==$jsonangkasbmodal[$j]['mtgkey']){
                  $totalnilaiangkas+=$jsonangkasbmodal[$j]['nilai'];
              }
            }
            $jsonmatangrbmodal[] = array(
              'kdper' => $databmodal[$i]['kdper'],
              'nmper' => $databmodal[$i]['nmper'],
              'mtgkey' => $databmodal[$i]['mtgkey'],
              'total' => $totalnilaiangkas,
            );
            }
            for($i=0;$i<count($jsonmatangrbmodal);$i++) {
              // code...
              $jumlahharga=0;
              for($j=0;$j<count($realbmodal);$j++){
                if($jsonmatangrbmodal[$i]['mtgkey']==$realbmodal[$j]['mtgkey']){
                  $jumlahharga+=$realbmodal[$j]['jumlah_harga'];
                }
              }
              $fixmatangrbmodal[]=array(
                'kdper' => $jsonmatangrbmodal[$i]['kdper'],
                'nmper' => $jsonmatangrbmodal[$i]['nmper'],
                'mtgkey' => $jsonmatangrbmodal[$i]['mtgkey'],
                'sisa_dana' => $this->template->rupiah($jsonmatangrbmodal[$i]['total']-$jumlahharga),
              );
            }


            $json = array(
                'matangr' => $datamatangr,
                'matangrbmodal' => $fixmatangrbmodal,
                'datar' => $jsondata,
                'datarbmodal' => $jsondatabmodal,
                'angkasbmodal' => $jsonangkasbmodal,
                'idstrukturppk' => $idstrukturppk

            );
            echo json_encode($json);
        }elseif ($data!=0&&$databmodal==0){
            $matangr = $this->User_model->getmatangr($kdkegunit);
            foreach ($matangr as $m){
                $datamatangr[] = array(
                    'kdper' => $m['kdper'],
                    'nmper' => $m['nmper'],
                    'mtgkey' => $m['mtgkey'],
                    'sisa_dana' => $this->template->rupiah($m['sisa_dana'])
                );
            }
            foreach ($data as $d){
                $jsondata[] = array(
                  'id_tab_realisasi' => $d['id_tab_realisasi'],
                  'id_struktur' => $d['id_struktur'],
                    'mtgkey' => $d['mtgkey'],
                    'nmper' => $d['nmper'],
                    'kdper' => $d['kdper'],
                    'real_bulan' => $d['real_bulan'],
                    'bobot_real' => $d['bobot_real'],
                    'tgl_entri' => $d['tgl_entri'],
                    'nm_dana' => $d['nm_dana'],
                    'harga_satuan' => $this->template->rupiah($d['harga_satuan']),
                    'jumlah_harga' => $this->template->rupiah($d['jumlah_harga']),
                    'sisa_dana' => $this->template->rupiah($d['sisa_dana']),
                    'vol' => $d['vol'],
                    'satuan' => $d['satuan'],
                    'urn' => $d['uraian']

                );
            }
            $json = array(
                'matangr' => $datamatangr,
                'matangrbmodal' => 0,
                'datar' => $jsondata,
                'datarbmodal' => 0,
                'angkasbmodal' => 0,
                'idstrukturppk' => $idstrukturppk

            );
            echo json_encode($json);
        }elseif($data==0&&$databmodal!=0){
          $realbmodal = $this->User_model->getrealbmodal($kdkegunit);
          $angkasbmodal = $this->User_model->getangkasbmodal($kdkegunit,$unitkeyppk);
          foreach ($realbmodal as $rbm) {
            // code...
            $jsondatabmodal[] = array(
              'id_tab_realisasi_bmodal' => $rbm['id_tab_realisasi_bmodal'],
              'id_struktur' => $rbm['id_struktur'],
              'mtgkey' => $rbm['mtgkey'],
              'urn' => $rbm['uraian'],
              'satuan' => $rbm['satuan'],
              'vol' => $rbm['vol'],
              'harga_satuan' => $this->template->rupiah($rbm['harga_satuan']),
              'jumlah_harga' => $this->template->rupiah($rbm['jumlah_harga']),

            );
          }
          foreach ($angkasbmodal as $abm ) {
            // code...
            $jsonangkasbmodal[] = array(
              'nilai' => $abm['nilai'],
              'mtgkey' => $abm['mtgkey'],

            );
          }
          for($i=0;$i<count($databmodal);$i++){
            $totalnilaiangkas=0;
            for($j=0;$j<count($jsonangkasbmodal);$j++){
              if($databmodal[$i]['mtgkey']==$jsonangkasbmodal[$j]['mtgkey']){
                $totalnilaiangkas+=$jsonangkasbmodal[$j]['nilai'];
            }
          }
          $jsonmatangrbmodal[] = array(
            'kdper' => $databmodal[$i]['kdper'],
            'nmper' => $databmodal[$i]['nmper'],
            'mtgkey' => $databmodal[$i]['mtgkey'],
            'total' => $totalnilaiangkas,
          );
          }
          for($i=0;$i<count($jsonmatangrbmodal);$i++) {
            // code...
            $jumlahharga=0;
            for($j=0;$j<count($realbmodal);$j++){
              if($jsonmatangrbmodal[$i]['mtgkey']==$realbmodal[$j]['mtgkey']){
                $jumlahharga+=$realbmodal[$j]['jumlah_harga'];
              }
            }
            $fixmatangrbmodal[]=array(
              'kdper' => $jsonmatangrbmodal[$i]['kdper'],
              'nmper' => $jsonmatangrbmodal[$i]['nmper'],
              'mtgkey' => $jsonmatangrbmodal[$i]['mtgkey'],
              'sisa_dana' => $this->template->rupiah($jsonmatangrbmodal[$i]['total']-$jumlahharga),
            );
          }

            $json = array(
                'matangr' => 0,
                'matangrbmodal' => $fixmatangrbmodal,
                'datar' => 0,
                'datarbmodal' => $jsondatabmodal,
                'angkasbmodal' => $jsonangkasbmodal,
                'idstrukturppk' => $idstrukturppk

            );
            echo json_encode($json);
        }else{
            echo json_encode($data);
        }
    }


    public function update_id_struktur()
    {
      $nip=$this->ion_auth->user()->row()->username;
      $parent = $this->User_model->getidparent($this->User_model->getidstrukturppk($nip));
      $idstruktur = $this->input->post('idstruktur');
      $idstrukturbmodal = $this->input->post('idstrukturbmodal');
      $idstrukturppk = $this->input->post('idstrukturppk');
      if($idstruktur==$idstrukturppk && $idstrukturbmodal==$idstrukturppk){
        $id = $this->input->post('id');
        $idbmodal = $this->input->post('idbmodal');

        $value = array(
          'id_struktur' => $parent
        );

        $valuebmodal = array(
          'id_struktur' => $parent
        );

        $where = array(
          'id' => $id
        );
        $wherebmodal = array(
          'id' => $idbmodal
        );
        $table = 'tab_realisasi';
        $tablebmodal = 'tab_realisasi_bmodal';

        $this->User_model->update_id_struktur($value,$where,$table);
        $this->User_model->update_id_struktur($valuebmodal,$wherebmodal,$tablebmodal);

      }elseif($idstruktur==$idstrukturppk && $idstrukturbmodal!=$idstrukturppk){

        $id = $this->input->post('id');

        $value = array(
          'id_struktur' => $parent
        );

        $where = array(
          'id' => $id
        );

        $table = 'tab_realisasi';

        $this->User_model->update_id_struktur($value,$where,$table);

      }elseif($idstruktur!=$idstrukturppk && $idstrukturbmodal==$idstrukturppk){
        $idbmodal = $this->input->post('idbmodal');

        $valuebmodal = array(
          'id_struktur' => $parent
        );

        $wherebmodal = array(
          'id' => $idbmodal
        );
        $tablebmodal = 'tab_realisasi_bmodal';

        $this->User_model->update_id_struktur($valuebmodal,$wherebmodal,$tablebmodal);
      }else{
        //do nothing
      }

    }
    //function created by ragaa -->

    //-->
    //AGUNG
    function dafallkeg(){
      if (!$this->ion_auth->logged_in()){
            redirect('Home/login', 'refresh');
        }elseif ($this->ion_auth->is_admin()){
            redirect('Cpanel', 'refresh');
        }elseif ($this->ion_auth->is_kasubag()){
            redirect('User/admingeneral', 'refresh');
        }else{
        	/*Dari function ini akan di cek ke tabel struktur apakah user tersebut KADIS/PPK/PPTK */
            $nip=$this->ion_auth->user()->row()->username;
            //echo $nip;
            $struktur = $this->User_model->cekstrukturpns($nip);
            $getopd = $this->User_model->getnamaopd($nip);
            $idopd =$getopd->unitkey;
            $namaopd=$getopd->nmunit;
            if($struktur ){
                $peran=$struktur->peran;
                // echo $peran;exit;
                if($peran=='1' || $peran=='6'){
                    /*jika peran 1 maka kadis jika peran 6 maka Sekretaris*/
                    $lskeg = $this->User_model->getdetlistkegiatan_ppk($nip);
                    $unitkeyuser = $this->User_model->getunitkeyppk($nip); // id opd user yg login
                    $idstruktur = $this->User_model->getidstruktur($nip);
                    // $data = $this->User_model->getdatappk($unitkeyuser, $nip);
                    $pgthn = $this->User_model->anggaranopd($unitkeyuser)->anggranopd;
                    // var_dump($pgthn);exit;
                    $angkas = $this->User_model->getangkasopdhinggabulanini($unitkeyuser);
                    $realnonmodal = $this->User_model->gettotalrealisasiopd($unitkeyuser,$idstruktur); //total realisasi hingga bulan sebelumnya
                    $realmodal = $this->User_model->getrealisasi_bModal_opd($unitkeyuser,$idstruktur); //total realisasi hingga bulan sebelumnya
                    $totreal = $realnonmodal + $realmodal;
                    // var_dump($totreal);exit;
                    $angkasbulanini = $this->User_model->getangkasOPDbulanini($unitkeyuser) + (($angkas - $this->User_model->getangkasOPDbulanini($unitkeyuser)) - $totreal);
                    $detangkasbulanini = $this->User_model->getdetangkasOPDbulanini($unitkeyuser);
                    $persenrealisasibulanini = ($totreal / $pgthn) * 100;
                    $lspptk = $this->User_model->getnippptkopd($unitkeyuser);

                    // var_dump($lspptk).exit;
                    //echo $this->template->rupiah($pgthn);
                    // var_dump($this->User_model->getdetrealbmodalbiOPD($this->User_model->getidstrukturppk($nip),$unitkeyuser)).exit;
                    //echo json_encode($this->User_model->getdataschedule($nip));
                    $this->data = array(
                        'idopd' => $idopd,
                        'nmopd' => $namaopd,
                        'tahun' => $this->tahunskr,
                        'list' => $lskeg,
                        'pagu_tahun' => $this->template->rupiah($pgthn),
                        'angkas_bulan' => $this->template->rupiah($angkas),
                        'angkas_bulan_ini' => $this->template->rupiah($angkasbulanini),
                        'det_angkas_bulan_ini' => $detangkasbulanini,
                        'det_angkas_satu_tahun' => $this->User_model->getdetangkasOPDsatutahun($unitkeyuser),
                        'persen_realisasi' => round($persenrealisasibulanini, 2) . ' %',
                        'lspptk' => $lspptk,
                        'kegiatan' => $this->User_model->getallkegiatan($unitkeyuser),
                        'data_realisasi' => $this->User_model->getdatarealisasi_by($idstruktur), //data realisasi bulan ini
                        'data_realisasi_hbs' => $this->User_model->getdatarealisasiOPDhbs($nip), //data realisasi hingga bulan sebelumnya
                        'data_angkas_hbs' => $this->User_model->getdetangkasOPDhbs($unitkeyuser), //data angkas hingga bulan sebelumnya
                        'data_schedule' => $this->User_model->getdatascheduleOPD($unitkeyuser), //data schedule satu tahun
                        'data_real_fisik' => $this->User_model->getrealfisikOPD($idstruktur), //data realisasi fisik bulan ini
                        'det_real_bmodalbi' => $this->User_model->getdetrealbmodalbiOPD($this->User_model->getidstrukturppk($nip),$unitkeyuser) //detail realisasi belanja modal bulan ini
                    );
                    $this->template->load('templatenew', 'v_all_kegiatan_opd', $this->data);


                }else{

                    /*jika tidak user biasa*/
                    $this->template->load('template','dashboard');
                }
            }else{
                $this->template->load('template','dashboard');
            }


        }
    }
    //Agung

    //all tes
    //put your kode di atas tes
    function enckeytes(){


        $textToEncrypt = "Risma Yunia Harnika";
    $encryptionMethod = "AES-256-ECB";  // AES is used by the U.S. gov't to encrypt top secret documents.
    $secretHash = "aS9P0RNoKY9QcmvGDWwcZcjw6OuZKJK2VrR4Hv9UMms=";

    //To encrypt
    $encryptedMessage = openssl_encrypt($textToEncrypt, $encryptionMethod, $secretHash);

    //To Decrypt
    $decryptedMessage = openssl_decrypt($encryptedMessage, $encryptionMethod, $secretHash);

    //Result
    echo "Encrypted: $encryptedMessage<br>Decrypted: $decryptedMessage";
        // $tes= urlencode(base64_encode("user-data"));


        // $decode = base64_decode(urldecode($tes));
        // echo "Encrypted: $tes<br>Decrypted: $decode";
    }
    function tesgetbulankegiatan2(){
           $kak = $this->db->get_where('tab_kak',array('idtab_pptk'=>'1'));
           $idkak=$kak->row()->id;
           $dateawal=$kak->row()->ii_awal_keg;
           $dateakhir=$kak->row()->ii_akhir_keg;
           $bulansekarang =date('M');
            $pecahawal = explode('-',  $dateawal);
            $thnawal  = $pecahawal[0];
            $blnawal  = $pecahawal[1];
            $pecahakhir = explode('-', $dateakhir);
            $thnakhir  = $pecahakhir[0];
            $blnakhir  = $pecahakhir[1];

           //echo (int)$blnawal.' - '. (int)$blnakhir;
            $arr = array('jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des' );

           for($i=(int)$blnawal;$i<=(int)$blnakhir;$i++)
            {

                $where =$arr[$i-1].'!=';
                $ada = $this->db->get_where('tab_schedule',array('id_tab_kak'=>$idkak, $where => ''));
                 if($ada->num_rows()>0){
                   $x='ada';
                 }else{
                   $x='tidak ada';
                 }


            }
           // echo json_encode($arrbulan);

    }

    function tesgetbulankegiatan1(){
            $kak = $this->db->get_where('tab_kak',array('idtab_pptk'=>'5'));
            $idkak=$kak->row()->id;
            $dateawal=$kak->row()->ii_awal_keg;
            $dateakhir=$kak->row()->ii_akhir_keg;
            $bulansekarang =date('n');
            $pecahawal = explode('-',  $dateawal);
            $thnawal  = $pecahawal[0];
            $blnawal  = $pecahawal[1];
            $pecahakhir = explode('-', $dateakhir);
            $thnakhir  = $pecahakhir[0];
            $blnakhir  = $pecahakhir[1];

           //echo (int)$blnawal.' - '. (int)$blnakhir;
            $arr = array('jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des' );
           $arrbulan = array();
           for($i=(int)$blnawal;$i<=(int)$blnakhir;$i++)
            {

                $where =$arr[$i-1].'!=';
                $this->db->where('id_tab_kak', $idkak);
                $this->db->where($where, '');
                $ada = $this->db->get('tab_schedule');
                if($ada->num_rows()>0 ){

                    $this->db->where('MONTH(real_bulan)', $i);
                    $this->db->where('id_tabpptk', '5');
                    $treal = $this->db->get('tab_realisasi');
                    if($treal->num_rows()==0){
                        $this->db->where('id_tabpptk', '5');
                        $jumreal = $this->db->get('tab_realisasi');
                        if($jumreal->num_rows()==0){
                            $pertama=1;
                        }else{
                            $pertama=0;
                        }
                        $geat = $arr[$i-1];
                        echo 'entri '.$geat.' dan ini '. $pertama;
                       break;
                    }

                }


                // $arrbulan[$bulansekarang][$arr[$i-1]][]= array(
                //     'bulan' => $arr[$i-1],
                //     'status' => $x
                // );
                //   $arrbulan[$arr[$i-1]][]= array(
                //     'bulan' => $arr[$i-1],
                //     'sch' => $x,
                //     'real'=> $y
                // );

            }
            //echo json_encode($arrbulan);

    }
    function tesbreak(){
        $arr = array('one', 'two', 'three', 'four', 'stop', 'five');
    foreach ($arr as $val) {
        if ($val == 'stop') {
            break;    /* You could also write 'break 1;' here. */
        }
        echo "$val<br />\n";
    }
    }
    function testgl(){

            // $date1 = date_create('2007-03-24');
            // $date2 = date_create('2009-06-26');
            // $interval = date_diff($date1, $date2);
            // echo $interval->y . " years, " . $interval->m." months, ".$interval->d." days ";
            //-------------
    //         $mm= $_REQUEST['month'];
    // $yy= $_REQUEST['year'];
      $mm= '10';
      $yy= '2018';
      $startdate=date($yy."-".$mm."-01") ;
      $current_date=date('Y-m-t');
      $ld= cal_days_in_month(CAL_GREGORIAN, $mm, $yy);
      $lastday=$yy.'-'.$mm.'-'.$ld;
      $start_date = date('Y-m-d', strtotime($startdate));
      $end_date = date('Y-m-d', strtotime($lastday));
      $end_date1 = date('Y-m-d', strtotime($lastday." + 6 days"));
      $count_week=0;
      $week_array = array();

      for($date = $start_date; $date <= $end_date1; $date = date('Y-m-d', strtotime($date. ' + 7 days')))
      {
        $getarray= $this->getWeekDates($date, $start_date, $end_date);
        echo "<br>";
        $week_array[]=$getarray;
        echo "\n";
        $count_week++;

    }

    // its give the number of week for the given month and year
    echo $count_week;
    //print_r($week_array);



    for($i=0;$i<$count_week;$i++)
    {
        $start= $week_array[$i]['ssdate'];
        echo "--";

        $week_array[$i]['eedate'];
        echo "<br>";
    }

    }
    function tescurency(){
       $var = str_replace("Rp ","","Rp 44.000");
       echo str_replace(".","",$var);
    //     $actual = $formatter->formatCurrency(20000, 'EUR') . PHP_EOL;
    // $output = preg_replace( '/[^0-9,"."]/', '', $actual );
    // echo $actual;
    }
    function getWeekDates($date, $start_date, $end_date)
    {
        $week =  date('W', strtotime($date));
        $year =  date('Y', strtotime($date));
        $from = date("Y-m-d", strtotime("{$year}-W{$week}+1"));
        if($from < $start_date) $from = $start_date;

        $to = date("Y-m-d", strtotime("{$year}-W{$week}-6"));
        if($to > $end_date) $to = $end_date;

        $array1 = array(
            "ssdate" => $from,
            "eedate" => $to,
        );

        return $array1;

       // echo "Start Date-->".$from."End Date -->".$to;
    }

    function testgl2(){
       echo $this->getWeeks("2018-11-01", "sunday");
    }
    function getWeeks($date, $rollover)
    {
        $cut = substr($date, 0, 8);
        $daylen = 86400;

        $timestamp = strtotime($date);
        $first = strtotime($cut . "00");
        $elapsed = ($timestamp - $first) / $daylen;

        $weeks = 1;

        for ($i = 1; $i <= $elapsed; $i++)
        {
            $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp = strtotime($dayfind);

            $day = strtolower(date("l", $daytimestamp));

            if($day == strtolower($rollover))  $weeks ++;
        }

        return $weeks;
    }
}
