

<section class="content-header">
  <h1>
    SODAP
    <small>Kota Payakumbuh</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

</ol>
</section>
<section class="content">

    <div class="callout bg-blue">
      <div class="row">
          <div class="col-xs-12 col-md-12 col-md-offset-1">
             <br>
             <?php
             if($ubah==1){
               $idrealb=$idreals;
             }else{
               $idrealb='';
             }
              ?>
              <p id="idubah" hidden><?php echo $ubah ?></p>
              <p id="idreal" hidden><?php echo $idrealb ?></p>
              <p id="kdunit" hidden><?php echo $idopd ?></p>
              <p id="kdkeg" hidden><?php echo $kdkeg ?></p>
              <p id="idtab" hidden><?php echo $idtab ?></p>
              <p id="idtahun" hidden><?php echo $tahun ?></p>
              <p id="indexbulan" hidden><?php echo $indexbulan ?></p>
              <p id="idbulan" hidden><?php echo $bulan ?></p>
             <div class="row">
                <div class="col-md-2 col-sm-2" style="text-align: left">Organisasi</div>
                <div class="col-md-1 col-sm-1" style="text-align: right;width: 5px">:</div>
                <div class="col-md-9 col-sm-9" style="padding-left: 25px"><?php echo $nmopd ?></div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-2 col-sm-2" style="text-align: left">Tahun</div>
                <div class="col-md-1 col-sm-1" style="text-align: right;width: 5px">:</div>
                <div class="col-md-9 col-sm-9" style="padding-left: 25px"><?php echo $tahun ?></div>
        </div>
        <br>



    </div>

</div>

</div>

<div class="row">

      <div class="col-md-3 col-sm-6 col-xs-12">
        <a class="btn btn-block btn-social btn-flat btn-success" id="btn-kembali">
          <i class="fa fa-arrow-left"></i> Kembali
        </a>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">

        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">


        </div>



      </div>
      <br>
<!-- Default box -->

<div class="box box-primary">
  <div class="box-header with-border">
    <i class="fa fa-text-width"></i>
    <?php
    if($ubah==1){
      $textubah='Ubah ';
    }else{
      $textubah='';
    }
    ?>
    <h3 class="box-title">Form <?php echo $textubah;?>Realisasi</h3>
  </div>
  <div class="box-body table-responsive">
    <form id="formrealisasi" enctype="multipart/form-data" role="form" autocomplete="off">

    <div class="row">
      <div class="col-md-2 col-sm-2 col-xs-12">
      </div>
      <div class="col-md-8 col-sm-8 col-xs-12">
        <h2 class="text-center">Realisasi Kegiatan</h2>
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
      </div>
    </div>
    <div class="row">
      <div class="col-md-2 col-sm-2 col-xs-12">
      </div>
      <div class="col-md-8 col-sm-8 col-xs-12">
       <h3 class="text-center"><?php echo $prog ?></h3>

     </div>
     <div class="col-md-2 col-sm-2 col-xs-12">
     </div>
   </div>
   <hr>
   <div class="row">
    <div class="col-md-1 col-sm-1 col-xs-12">
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
     <h4 class="text-left text-muted">Kegiatan</h4>
   </div>
   <div class="col-md-1 col-sm-1 col-xs-12">
    <h4 class="text-center text-muted">:</h4>
  </div>
  <div class="col-md-6 col-sm-8 col-xs-12">
    <h4 class="text-left text-muted"><?php echo $keg ?></h4>
  </div>
  <div class="col-md-2 col-sm-2 col-xs-12">
  </div>
</div>
<div class="row">
  <div class="col-md-1 col-sm-1 col-xs-12">

  </div>
  <div class="col-md-2 col-sm-2 col-xs-12">
   <h4 class="text-left text-muted">Pagu Dana</h4>
 </div>
 <div class="col-md-1 col-sm-1 col-xs-12">
  <h4 class="text-center text-muted">:</h4>
</div>
<div class="col-md-6 col-sm-8 col-xs-12">
 <h4 class="text-left text-muted"><?php echo $this->template->rupiah($nl) ?></h4>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
</div>
</div>
<div class="row">
  <div class="col-md-1 col-sm-1 col-xs-12">
  </div>
  <div class="col-md-2 col-sm-2 col-xs-12">
   <h4 class="text-left text-muted">Bobot Kegiatan</h4>
 </div>
 <div class="col-md-1 col-sm-1 col-xs-12">
  <h4 class="text-center text-muted">:</h4>
</div>
<div class="col-md-6 col-sm-8 col-xs-12">
 <h4 class="text-left text-muted" id="botkeg"><?php echo $bobot ?></h4>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
</div>
</div>
<div class="row">
  <div class="col-md-1 col-sm-1 col-xs-12">
  </div>
  <div class="col-md-2 col-sm-2 col-xs-12">
   <h4 class="text-left text-muted">Nama KPA</h4>
 </div>
 <div class="col-md-1 col-sm-1 col-xs-12">
  <h4 class="text-center text-muted">:</h4>
</div>
<div class="col-md-6 col-sm-8 col-xs-12">
 <h4 class="text-left text-muted"><?php echo $ppk ?></h4>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
</div>
</div>
<div class="row">
  <div class="col-md-1 col-sm-1 col-xs-12">
  </div>
  <div class="col-md-2 col-sm-2 col-xs-12">
   <h4 class="text-left text-muted">Bulan</h4>
 </div>
 <div class="col-md-1 col-sm-1 col-xs-12">
  <h4 class="text-center text-muted">:</h4>
</div>
<div class="col-md-6 col-sm-8 col-xs-12">
 <h4 class="text-left text-muted"><?php echo $bulan ?></h4>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
</div>
</div>
<div class="row">
  <div class="col-md-1 col-sm-1 col-xs-12">
  </div>
  <div class="col-md-2 col-sm-2 col-xs-12">
   <h4 class="text-left text-muted">Pagu Dana s/d Bulan Sekarang</h4>
 </div>
 <div class="col-md-1 col-sm-1 col-xs-12">
  <h4 class="text-center text-muted">:</h4>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
 <h4 class="text-left text-muted"><input type="text" class="form-control "  id="headtotsdana"  readonly style="text-align:left; font-family: Arial, Helvetica, sans-serif; font-size: 18px; font-weight: bold;"></h4>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
</div>
</div>

<hr>
<table class="table table-bordered table-condensed " style="font-size: 11px">
  <thead>
    <tr>
      <th rowspan="3" style="vertical-align : middle;text-align:center; width: 100px">Kode Rekening</th>
      <th rowspan="3" style="vertical-align : middle;text-align:center; width: 160px">Uraian</th>
      <th colspan="4"  style="vertical-align : middle;text-align:center;">ANGGARAN TAHUN SEKARANG</th>
       <th rowspan="3" style="vertical-align : middle;text-align:center; width: 130px">BULAN SEKARANG</th>
      <th rowspan="3" style="vertical-align : middle;text-align:center; width: 80px">SUMBER DANA</th>
      <th colspan="3" style="vertical-align : middle;text-align:center;">REALISASI</th>
      <th rowspan="3" style="vertical-align : middle;text-align:center; width: 130px">SISA DANA / th</th>

    </tr>
    <tr>
      <th colspan="3" style="vertical-align : middle;text-align:center;">Rincian Perhitungan</th>
      <th rowspan="2" style="vertical-align : middle;text-align:center; width: 120px">Jumlah Pagu / Th</th>
      <th rowspan="2" style="vertical-align : middle;text-align:center;  width: 120px">Volume</th>
      <th rowspan="2" style="vertical-align : middle;text-align:center; width: 130px">Harga Satuan</th>
      <th rowspan="2" style="vertical-align : middle;text-align:center; width: 130px">Jumlah</th>
    </tr>
    <tr>
      <th style="vertical-align : middle;text-align:center; width: 70px">Volume</th>
      <th style="vertical-align : middle;text-align:center; width: 70px">Satuan</th>
      <th style="vertical-align : middle;text-align:center; width: 120px">Harga Satuan</th>
    </tr>

  </thead>

                <tbody>
                     <?php
                     if($ubah==1){
                       foreach ($header as $hrow){
                        $unitkey=$hrow['unitkey'];
                        $kdkegunit=$hrow['kdkegunit'];
                        $mtgkey=$hrow['mtgkey'];
                        $jkrek=substr($hrow['kdper'],0,6);
                        $clasrek=str_replace(".","-",$hrow['kdper']);
                        if($jkrek=='5.2.3.'){

                        $class='danger';

                        $this->db->select('
                        ,SUM(`dpa221`.`jumbyek` *`dpa221`.`tarif`) as nilai');
                        $this->db->from('dpa221');
                        $this->db->where('`dpa221`.`tahun`', $tahun);
                        $this->db->where('`dpa221`.`unitkey`', $idopd);
                        $this->db->where('`dpa221`.`kdkegunit`', $kdkeg);
                        $this->db->where('`dpa221`.`mtgkey`', $mtgkey);
                        $nltahun=$this->db->get()->row();
                        //cek realisasi belanja modal ke tabel tab_realisasi_bmodal
                        //SELECT * FROM `tab_realisasi_bmodal` WHERE id_tab_pptk = '5' AND mtgkey='1326_'
                        $nilaibmodal = $this->db->get_where('tab_realisasi_bmodal',array('id_tab_pptk'=>$idtab,'mtgkey'=>$mtgkey));
                        if($nilaibmodal->num_rows()>0){
                          $nlrealbmodal = $nilaibmodal->row()->nilai_ktrk;
                        }else{
                          $nlrealbmodal = 0;
                        }


                        echo'<tr class ="'.$class.'">

                        <td class="unit" style="display:none;">'.$hrow['unitkey'].'</td>
                        <td class="keg" style="display:none;">'.$hrow['kdkegunit'].'</td>
                        <td class="mtgkey" style="display:none;">'.$hrow['mtgkey'].'</td>
                        <td class="rekheader"><b>'.$hrow['kdper'].'</b></td>
                        <td class="nmrekheader"><b>'.$hrow['nmper'].'</b></td>
                        <td colspan="3"></td>
                        <td style="text-align:right"><b>'.$this->template->rupiah($nltahun->nilai).'</b></td>

                        <td class="totpagubln'.$clasrek.'" style="display:none;">'.$hrow['nilai'].'</td>
                        <td style="display:none;"><input type="text" class="form-control pg'.$clasrek.'"  readonly value='.$hrow['nilai'].'></td>
                        <td style="text-align:right"><b>'.$this->template->rupiah($hrow['nilai']).'</b></td>
                        <td style="display:none;"><input type="text" class="form-control headtotsd "  readonly value='.$hrow['nilai'].'></td>
                        <td style="display:none;"><input type="text" class="form-control nsisadana sisadana'.$clasrek.'"  readonly value='.$hrow['nilai'].'></td>
                        <td style="vertical-align : middle;text-align:center;"><u><b><i>Nilai Kontrak</i></b></u></td>
                        <td style="vertical-align : middle;text-align:center;"><input type="text" class="form-control hr real5-2-3 harga-rek'.$clasrek.'" readonly name="jumperrek[]"  style="font-size: 11px" value='.$nlrealbmodal.'></td>
                        <td style="vertical-align : middle;text-align:center;"><u><b><i>Total Realisasi</i></b></u></td>
                        <td ></td>

                        <td style="vertical-align : middle;text-align:center;"><button type="button" class="btnrealfisik btn bg-blue btn-flat bm'.$clasrek.'">Realisasi<div class="ripple-container"></div></button></td>
                        </tr>';

                          $this->db->where('`dpa221`.`tahun`', $tahun);
                          $this->db->where('`dpa221`.`unitkey`', $unitkey);
                          $this->db->where('`dpa221`.`kdkegunit`', $kdkegunit);
                          $this->db->where('`dpa221`.`mtgkey`', $mtgkey);
                          $detail=$this->db->get('dpa221')->result_array();
                          foreach ($detail as $row){
                            $jumyek=$row['jumbyek'];
                            $tarif=$row['tarif'];
                            $total=$jumyek*$tarif;
                            $jkrek=substr($hrow['kdper'],0,6);
                            if($jkrek=='5.2.3.'){
                              $class='warning';
                            }else{
                               $class='';
                            }
                            echo'<tr class ="'.$class.'">
                             <td class="totpagubln'.$clasrek.'" style="display:none;">'.$hrow['nilai'].'</td>
                                <td><input type="hidden" class="form-control exrek" readonly name="exkdrek[]"  value='.$hrow['kdper'].'></td>
                                <td style="display:none;"><input type="hidden" class="form-control" readonly name="iddpa[]"  value='.$row['id'].'></td>
                                <td class="tarif" style="display:none;">'.$tarif.'</td>
                                <td class"text-muted">'.$row['uraian'].'</td>
                                <td class="jumy" style="display:none;">'.$jumyek.'</td>
                                <td class="totpagu" style="display:none;">'.$total.'</td>
                                <td class"text-muted" style="text-align:right">'.$jumyek.'</td>
                                <td class"text-muted" style="text-align:center">'.$row['satuan'].'</td>
                                <td class"text-muted" style="text-align:right">'.$this->template->rupiah($tarif) .'</td>
                                <td class"text-muted" style="text-align:right">'.$this->template->rupiah($total) .'</td>
                                <td class="totjum" style="display:none;">'.$total.'</td>
                               <td colspan="6"></td>
                            </tr>';
                          }
                        }else{
                          //selain 5.2.3
                          $class='active';
                          $this->db->select('
                          ,SUM(`dpa221`.`jumbyek` *`dpa221`.`tarif`) as nilai');
                          $this->db->from('dpa221');
                          $this->db->where('`dpa221`.`tahun`', $tahun);
                          $this->db->where('`dpa221`.`unitkey`', $idopd);
                          $this->db->where('`dpa221`.`kdkegunit`', $kdkeg);
                          $this->db->where('`dpa221`.`mtgkey`', $mtgkey);
                          $nltahun=$this->db->get()->row();

                          echo'<tr class ="'.$class.'">

                        <td class="unit" style="display:none;">'.$hrow['unitkey'].'</td>
                        <td class="keg" style="display:none;">'.$hrow['kdkegunit'].'</td>
                        <td class="mtgkey" style="display:none;">'.$hrow['mtgkey'].'</td>
                        <td><b>'.$hrow['kdper'].'</b></td>
                        <td><b>'.$hrow['nmper'].'</b></td>
                        <td colspan="4"></td>

                        <td class="totpagubln'.$clasrek.'" style="display:none;">'.$hrow['nilai'].'</td>
                        <td style="display:none;"><input type="text" class="form-control pg'.$clasrek.'"  readonly value='.$hrow['nilai'].'></td>
                        <td style="text-align:right"></td>
                        <td style="display:none;"><input type="text" class="form-control headtotsd "  readonly value='.$hrow['nilai'].'></td>
                          <td colspan="4"></td>

                        <td ></td>
                        </tr>';

                          $this->db->where('`dpa221`.`tahun`', $tahun);
                          $this->db->where('`dpa221`.`unitkey`', $unitkey);
                          $this->db->where('`dpa221`.`kdkegunit`', $kdkegunit);
                          $this->db->where('`dpa221`.`mtgkey`', $mtgkey);
                          $detail=$this->db->get('dpa221')->result_array();
                          $tottt=0;
                          foreach ($detail as $row){
                            $detid        = $row['id'];
                            $dettahun     = $row['tahun'];
                            $detunitkey   = $row['unitkey'];
                            $detkdkegunit = $row['kdkegunit'];
                            $detmtgkey    = $row['mtgkey'];
                            $deturaianx   = str_replace("-","",$row['uraian']);
                            $deturaian    = str_replace("  ","",$deturaianx);
                            $detsatuan    = $row['satuan'];
                            $dettarif     = $row['tarif'];
                            $detjumbyek   = $row['jumbyek'];
                            $detkdjabar   = $row['kdjabar'];
                            $dettype      = $row['type'];

                            $jumyek=$row['jumbyek'];
                            $tarif=$row['tarif'];
                            $total=$jumyek*$tarif;
                            $jkrek=substr($hrow['kdper'],0,6);
                            if($jkrek=='5.2.3.'){
                              $class='warning';
                            }else{
                               $class='';
                            }
                            //detail realisasi yang sudah di entri dan akan di edit
                            $this->db->select('`tab_sumber_dana`.`id`
                            ,`tab_sumber_dana`.`nm_dana`
                            , `tab_realisasi_det`.`vol`
                            , `tab_realisasi_det`.`harga_satuan`
                            , `tab_realisasi_det`.`jumlah_harga`
                            , `tab_realisasi_det`.`sisa_dana`');
                            $this->db->from('tab_realisasi_det');
                            $this->db->join('tab_sumber_dana', '`tab_realisasi_det`.`sumber_dana` = `tab_sumber_dana`.`id`');
                            $this->db->where('id_tab_realisasi', $idreals);
                            $this->db->where('mtgkey', $detmtgkey);
                            $this->db->where('id_dpa', $detid);
                            $rowbulanlalu = $this->db->get()->row_array();
                            //print_r($rowbulanlalu);
                            //ini aneh tidak bisa row() seperti biasa harus row_array /sajam untuk iko se
                            $bliddana=$rowbulanlalu['id'];
                            $blnmdana=$rowbulanlalu['nm_dana'];
                            $blvol=$rowbulanlalu['vol'];
                            $blhs = $rowbulanlalu['harga_satuan'];
                            $bljh = $rowbulanlalu['jumlah_harga'];
                            $tottt+=$bljh;
                            $blsd = $rowbulanlalu['sisa_dana'];

                            echo'<tr class ="'.$class.'">
                                <td class="totpagubln'.$clasrek.'" style="display:none;">'.$hrow['nilai'].'</td>
                                <td style="display:none;"><input type="hidden" class="form-control" readonly name="detpgblnskr[]"  value='.$hrow['nilai'].'></td>
                                <td><input type="hidden" class="form-control rek" readonly name="kdrek[]"  value='.$hrow['kdper'].'></td>
                                <td style="display:none;"><input type="hidden" class="form-control" readonly name="iddpa[]"  value='.$row['id'].'></td>
                                <td style="display:none;"><input type="hidden" class="form-control" readonly name="mtgkey[]"  value='.$mtgkey.'></td>
                                <td class="tarif" style="display:none;">'.$tarif.'</td>
                                <td class"text-muted">'.$row['uraian'].'</td>
                                <td class="jumy" style="display:none;">'.$jumyek.'</td>
                                <td class="totpagu" style="display:none;">'.$total.'</td>
                                <td class"text-muted" style="text-align:right">'.$jumyek.'</td>
                                <td class"text-muted" style="text-align:center">'.$row['satuan'].'</td>
                                <td class"text-muted" style="text-align:right">'.$this->template->rupiah($tarif) .'</td>
                                <td class"text-muted" style="text-align:right">'.$this->template->rupiah($total) .'</td>
                                 <td class="totjum" style="display:none;">'.$total.'</td>
                                 <td class="active"></td>
                                <td >  <select class="form-control select2" name="sumberdn[]" style="font-size: 11px;width: 100%;">';
                                 $sdana= $this->User_model->sumberdana();
                                foreach ($sdana as $k) {
                                  if($k['id']==$bliddana){
                                     echo "<option selected='selected' value='{$k['id']}'>{$k['nm_dana']}</option>";
                                  }else{
                                    echo "<option value='{$k['id']}'>{$k['nm_dana']}</option>";
                                  }
                                }

                                echo'</select></td>
                                <td><div class="input-group spinner" data-trigger="spinner">
                                  <input type="text" class="form-control text-center vl" style="font-size: 11px" value="'.$blvol.'" name="volume[]" data-rule="quantity">
                                  <div class="input-group-addon">
                                    <a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-caret-up"></i></a>
                                    <a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-caret-down"></i></a>
                                  </div>
                                </div></td>

                                  <td><input type="text" class="form-control harga-satuan" name="hrsatuan[]" value="'.$blhs.'" style="font-size: 11px;"></td>
                                  <td><input type="text" class="form-control harga-jumlah '.$clasrek.'" readonly name="jum[]" value="'.$bljh.'" style="font-size: 11px;"></td>
                                  <td><input type="text" class="form-control sisadana" readonly name="sisadn[]"value='.$blsd.' style="font-size: 11px;"></td>
                            </tr>';
                          }
                          $hsilsudah=(int)$hrow['nilai']-(int)$tottt;
                          echo"<tr>
                            <td colspan='5' style='vertical-align : middle;text-align:right'><b>Total Jumlah</b></td>
                            <td style='vertical-align : middle;text-align:right'><b>".$this->template->rupiah($nltahun->nilai)."</b></td>
                            <td class='active' style='vertical-align : middle;text-align:right'><b>".$this->template->rupiah($hrow['nilai'])."</b></td>
                            <td style='display:none;'><input type='text' class='form-control nsisadana sisadana".$clasrek."'  readonly value=".$hsilsudah."></td>
                            <td colspan='3' style='vertical-align : middle; text-align:right'></td>
                            <td style='vertical-align : middle;text-align:center;'><input type='text' class='form-control hr harga-rek".$clasrek."' style='font-size: 11px;' value='".$tottt."' readonly name='jumperrek[]'></td>

                            <td></td>
                            </tr>";
                        }


                        }

                     }else{

                       foreach ($header as $hrow){
                        $id       =$hrow['id'];
                        $unitkey  =$hrow['unitkey'];
                        $kdkegunit=$hrow['kdkegunit'];
                        $nilai    =$hrow['nilai'];
                        $mtgkey   =$hrow['mtgkey'];
                        $kdper    =$hrow['kdper'];
                        $nmper    =$hrow['nmper'];
                        $tahun    =$hrow['tahun'];
                        $jkrek=substr($hrow['kdper'],0,6);
                        $clasrek=str_replace(".","-",$hrow['kdper']);
                        if($jkrek=='5.2.3.'){

                        $class='danger';

                        $this->db->select('
                        ,SUM(`dpa221`.`jumbyek` *`dpa221`.`tarif`) as nilai');
                        $this->db->from('dpa221');
                        $this->db->where('`dpa221`.`tahun`', $tahun);
                        $this->db->where('`dpa221`.`unitkey`', $idopd);
                        $this->db->where('`dpa221`.`kdkegunit`', $kdkeg);
                        $this->db->where('`dpa221`.`mtgkey`', $mtgkey);
                        $nltahun=$this->db->get()->row();
                        //cek realisasi belanja modal ke tabel tab_realisasi_bmodal
                        //SELECT * FROM `tab_realisasi_bmodal` WHERE id_tab_pptk = '5' AND mtgkey='1326_'
                        $nilaibmodal = $this->db->get_where('tab_realisasi_bmodal',array('id_tab_pptk'=>$idtab,'mtgkey'=>$mtgkey));
                        if($nilaibmodal->num_rows()>0){
                          $idnilaimodal = $nilaibmodal->row()->id;
                          $this->db->select('SUM(`real_keuangan`) AS jumrealbm');
                          //$this->db->where('MONTH(real_bulan)', $indexbulan);
                          $this->db->where('id_tab_real_bmodal', $idnilaimodal);
                          $detjumreal = $this->db->get('tab_realisasi_bmodal_det');
                          $totnlrealbmodal=$detjumreal->row()->jumrealbm;
                          $nlrealbmodal = $nilaibmodal->row()->nilai_ktrk;

                         // $nlrealbmodal =$totrealbm;
                         $bmsisablnskr =(int)$nlrealbmodal - (int)$totnlrealbmodal;
                          // $nlrealbmodal = $nilaibmodal->row()->nilai_ktrk;
                        }else{
                          // $nlrealbmodal = 0;
                          $nlrealbmodal = 0;
                          $totnlrealbmodal= 0;
                           $bmsisablnskr = (int)$nilai;
                        }


                        echo'<tr class ="'.$class.'">

                        <td class="unit" style="display:none;">'.$hrow['unitkey'].'</td>
                        <td class="keg" style="display:none;">'.$hrow['kdkegunit'].'</td>
                        <td class="mtgkey" style="display:none;">'.$hrow['mtgkey'].'</td>
                        <td class="rekheader"><b>'.$hrow['kdper'].'</b></td>
                        <td class="nmrekheader"><b>'.$hrow['nmper'].'</b></td>
                        <td colspan="3"></td>
                        <td style="text-align:right"><b>'.$this->template->rupiah($nltahun->nilai).'</b></td>

                        <td class="totpagubln'.$clasrek.'" style="display:none;">'.$hrow['nilai'].'</td>
                        <td style="display:none;"><input type="text" class="form-control pg'.$clasrek.'"  readonly value='.$hrow['nilai'].'></td>
                        <td style="text-align:right"><b>'.$this->template->rupiah($bmsisablnskr).'</b></td>
                        <td style="display:none;"><input type="text" class="form-control headtotsd "  readonly value='.$hrow['nilai'].'></td>
                        <td style="display:none;"><input type="text" class="form-control nsisadana sisadana'.$clasrek.'"  readonly value='.$hrow['nilai'].'></td>
                        <td style="vertical-align : middle;text-align:center;"><u><b><i>Nilai Kontrak</i></b></u></td>
                        <td style="vertical-align : middle;text-align:center;"><input type="text" class="format-rupiah form-control" readonly name="jumperrek[]" style="font-size: 11px" value='.$nlrealbmodal.'></td>
                        <td style="vertical-align : middle;text-align:center;"><u><b><i>Total Realisasi</i></b></u></td>
                        <td style="vertical-align : middle;text-align:center;"><input type="text" class="format-rupiah form-control hr real5-2-3 harga-rek'.$clasrek.'" readonly value='.$totnlrealbmodal.' id="totnlrealbmodal'.$clasrek.'" style="font-size: 11px"></td>

                        <td style="vertical-align : middle;text-align:center;"><button type="button" class="btnrealfisik btn bg-blue btn-flat bm'.$clasrek.'">Realisasi<div class="ripple-container"></div></button></td>
                        </tr>';

                          $this->db->where('`dpa221`.`tahun`', $tahun);
                          $this->db->where('`dpa221`.`unitkey`', $unitkey);
                          $this->db->where('`dpa221`.`kdkegunit`', $kdkegunit);
                          $this->db->where('`dpa221`.`mtgkey`', $mtgkey);
                          $detail=$this->db->get('dpa221')->result_array();
                          foreach ($detail as $row){
                            $jumyek=$row['jumbyek'];
                            $tarif=$row['tarif'];
                            $total=$jumyek*$tarif;
                            $jkrek=substr($hrow['kdper'],0,6);
                            if($jkrek=='5.2.3.'){
                              $class='warning';
                            }else{
                               $class='';
                            }
                            echo'<tr class ="'.$class.'">
                             <td class="totpagubln'.$clasrek.'" style="display:none;">'.$hrow['nilai'].'</td>
                                <td><input type="hidden" class="form-control exrek" readonly name="exkdrek[]"  value='.$hrow['kdper'].'></td>
                                <td style="display:none;"><input type="hidden" class="form-control" readonly name="iddpa[]"  value='.$row['id'].'></td>
                                <td class="tarif" style="display:none;">'.$tarif.'</td>
                                <td class"text-muted">'.$row['uraian'].'</td>
                                <td class="jumy" style="display:none;">'.$jumyek.'</td>
                                <td class="totpagu" style="display:none;">'.$total.'</td>
                                <td class"text-muted" style="text-align:right">'.$jumyek.'</td>
                                <td class"text-muted" style="text-align:center">'.$row['satuan'].'</td>
                                <td class"text-muted" style="text-align:right">'.$this->template->rupiah($tarif) .'</td>
                                <td class"text-muted" style="text-align:right">'.$this->template->rupiah($total) .'</td>
                                <td class="totjum" style="display:none;">'.$total.'</td>
                               <td colspan="6"></td>
                            </tr>';
                          }
                        }else{
                          //selain 5.2.3
                          $class='active';
                          $this->db->select('
                          ,SUM(`dpa221`.`jumbyek` *`dpa221`.`tarif`) as nilai');
                          $this->db->from('dpa221');
                          $this->db->where('`dpa221`.`tahun`', $tahun);
                          $this->db->where('`dpa221`.`unitkey`', $idopd);
                          $this->db->where('`dpa221`.`kdkegunit`', $kdkeg);
                          $this->db->where('`dpa221`.`mtgkey`', $mtgkey);
                          $nltahun=$this->db->get()->row();

                          echo'<tr class ="'.$class.'">

                        <td class="unit" style="display:none;">'.$hrow['unitkey'].'</td>
                        <td class="keg" style="display:none;">'.$hrow['kdkegunit'].'</td>
                        <td class="mtgkey" style="display:none;">'.$hrow['mtgkey'].'</td>
                        <td><b>'.$hrow['kdper'].'</b></td>
                        <td><b>'.$hrow['nmper'].'</b></td>
                        <td colspan="3"></td>
                        <td style="text-align:right"></td>
                        <td class="totpagubln'.$clasrek.'" style="display:none;">'.$hrow['nilai'].'</td>
                        <td style="display:none;"><input type="text" class="form-control pg'.$clasrek.'"  readonly value='.$hrow['nilai'].'></td>
                        <td style="text-align:right"></td>
                        <td style="display:none;"><input type="text" class="form-control headtotsd "  readonly value='.$hrow['nilai'].'></td>

                        <td colspan="4"></td>

                        <td ></td>
                        </tr>';

                          $this->db->where('`dpa221`.`tahun`', $tahun);
                          $this->db->where('`dpa221`.`unitkey`', $unitkey);
                          $this->db->where('`dpa221`.`kdkegunit`', $kdkegunit);
                          $this->db->where('`dpa221`.`mtgkey`', $mtgkey);
                          $detail=$this->db->get('dpa221')->result_array();
                          foreach ($detail as $row){
                            $jumyek=$row['jumbyek'];
                            $tarif=$row['tarif'];
                            $total=$jumyek*$tarif;
                            $jkrek=substr($hrow['kdper'],0,6);
                            if($jkrek=='5.2.3.'){
                              $class='warning';
                            }else{
                               $class='';
                            }
                            echo'<tr class ="'.$class.'">
                                <td class="totpagubln'.$clasrek.'" style="display:none;">'.$hrow['nilai'].'</td>
                                <td style="display:none;"><input type="hidden" class="form-control" readonly name="detpgblnskr[]"  value='.$hrow['nilai'].'></td>
                                <td><input type="hidden" class="form-control rek" readonly name="kdrek[]"  value='.$hrow['kdper'].'></td>
                                <td style="display:none;"><input type="hidden" class="form-control" readonly name="iddpa[]"  value='.$row['id'].'></td>
                                <td style="display:none;"><input type="hidden" class="form-control" readonly name="mtgkey[]"  value='.$mtgkey.'></td>
                                <td class="tarif" style="display:none;">'.$tarif.'</td>
                                <td class"text-muted">'.$row['uraian'].'</td>
                                <td class="jumy" style="display:none;">'.$jumyek.'</td>
                                <td class="totpagu" style="display:none;">'.$total.'</td>
                                <td class"text-muted" style="text-align:right">'.$jumyek.'</td>
                                <td class"text-muted" style="text-align:center">'.$row['satuan'].'</td>
                                <td class"text-muted" style="text-align:right">'.$this->template->rupiah($tarif) .'</td>
                                <td class"text-muted" style="text-align:right">'.$this->template->rupiah($total) .'</td>
                                 <td class="totjum" style="display:none;">'.$total.'</td>
                                 <td class="active"></td>
                                <td >  <select class="form-control select2" name="sumberdn[]" style="font-size: 11px;width: 100%;">';
                                 $sdana= $this->User_model->sumberdana();
                                foreach ($sdana as $k) {
                                  if($k['id']==1){
                                     echo "<option selected='selected' value='{$k['id']}'>{$k['nm_dana']}</option>";
                                  }else{
                                    echo "<option value='{$k['id']}'>{$k['nm_dana']}</option>";
                                  }
                                }

                                echo'</select></td>
                                <td><div class="input-group spinner" data-trigger="spinner">
                                  <input type="text" class="form-control text-center vl" style="font-size: 11px" value="0" name="volume[]" data-rule="quantity">
                                  <div class="input-group-addon">
                                    <a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-caret-up"></i></a>
                                    <a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-caret-down"></i></a>
                                  </div>
                                </div></td>

                                  <td><input type="text" class="form-control harga-satuan" name="hrsatuan[]" style="font-size: 11px;"></td>
                                  <td><input type="text" class="form-control harga-jumlah '.$clasrek.'" readonly name="jum[]" style="font-size: 11px;"></td>
                                  <td><input type="text" class="form-control sisadana" readonly name="sisadn[]"value='.$total.' style="font-size: 11px;"></td>
                            </tr>';
                          }
                          echo"<tr>
                            <td colspan='5' style='vertical-align : middle;text-align:right'><b>Total Jumlah</b></td>
                            <td style='vertical-align : middle;text-align:right'><b>".$this->template->rupiah($nltahun->nilai)."</b></td>
                            <td class='active' style='vertical-align : middle;text-align:right'><b>".$this->template->rupiah($hrow['nilai'])."</b></td>
                            <td style='display:none;'><input type='text' class='form-control nsisadana sisadana".$clasrek."'  readonly value=".$hrow['nilai']."></td>


                            <td colspan='3' style='vertical-align : middle; text-align:right'></td>
                            <td style='vertical-align : middle;text-align:center;'><input type='text' class='form-control hr harga-rek".$clasrek."' style='font-size: 11px;' readonly name='jumperrek[]'></td>

                            <td></td>
                            </tr>";
                        }


                        }
                     }

                     ?>




              </tbody>
            </table>
    </div>
    <br>

<!-- /.box-body -->

<!-- <div class="box-footer">
  Footer
</div> -->
<!-- /.box-footer-->

</div>
<!-- /.box -->
<div class="box box-primary">
  <div class="box-header with-border">

  </div>
  <div class="box-body">
 <div class="row">
    <div class="col-md-1 col-sm-1 col-xs-12">
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
     <h4 class="text-left text-muted">Realisasi Keuangan</h4>
   </div>
   <div class="col-md-1 col-sm-1 col-xs-12">
    <h4 class="text-center text-muted">:</h4>
  </div>
  <div class="col-md-3 col-sm-3 col-xs-12">
    <h4 class="text-left text-muted"><input type="text" class="form-control totkeu" id="realkeu"  readonly style="text-align:right"></h4>
  </div>
  <div class="col-md-2 col-sm-2 col-xs-12">
  </div>
</div>
<div class="row">
    <div class="col-md-1 col-sm-1 col-xs-12">
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
     <h4 class="text-left text-muted">Total Sisa Dana Bulan Sekarang</h4>
   </div>
   <div class="col-md-1 col-sm-1 col-xs-12">
    <h4 class="text-center text-muted">:</h4>
  </div>
  <div class="col-md-3 col-sm-3 col-xs-12">
    <h4 class="text-left text-muted"><input type="text" class="form-control totsisadana" id="totsdana"  readonly style="text-align:right"></h4>
  </div>
  <div class="col-md-2 col-sm-2 col-xs-12">
  </div>
</div>
<div class="row">
    <div class="col-md-1 col-sm-1 col-xs-12">
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
     <h4 class="text-left text-muted">Realisasi Fisik</h4>
   </div>
   <div class="col-md-1 col-sm-1 col-xs-12">
    <h4 class="text-center text-muted">:</h4>
  </div>
  <?php
if($ubah==1){

  $rf = $real_fisik;
  $br   =$bobot_real;
  $per =$permasalahan;

}else{
  $rf = '';
  $br   = '';
  $per ='';
}
  ?>
   <div class="col-md-3 col-sm-3 col-xs-12">
    <div class="input-group">
                  <input type="text" class="realfisik form-control" id="realfisik" value="<?php echo $rf ?>" >
                  <div class="input-group-addon">
                  <i class="fa fa-percent"></i>
                  </div>
    </div>

  </div>
  <div class="col-md-2 col-sm-2 col-xs-12">
  </div>
</div>
<div class="row">
    <div class="col-md-1 col-sm-1 col-xs-12">
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
     <h4 class="text-left text-muted">Bobot Realisasi</h4>
   </div>
   <div class="col-md-1 col-sm-1 col-xs-12">
    <h4 class="text-center text-muted">:</h4>
  </div>
   <div class="col-md-3 col-sm-3 col-xs-12">
     <div class="input-group">
                  <input type="text" class="realbobot form-control" id="realbobot"  style="text-align: right;" readonly value="<?php echo $br ?>">
                  <div class="input-group-addon">
                  <i class="fa fa-percent"></i>
                  </div>
                  </div>

  </div>
  <div class="col-md-2 col-sm-2 col-xs-12">
  </div>
</div>
<div class="row">
    <div class="col-md-1 col-sm-1 col-xs-12">
    </div>
    <div class="col-md-2 col-sm-2 col-xs-12">
     <h4 class="text-left text-muted">Permasalahan</h4>
   </div>
   <div class="col-md-1 col-sm-1 col-xs-12">
    <h4 class="text-center text-muted">:</h4>
  </div>
  <div class="col-md-7 col-sm-7 col-xs-12">
    <textarea class="textarea" id="masalah" name="masalah"  placeholder="Jika Ada Permasalahan"
                       style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"> <?php echo $per ?></textarea>
  </div>
  <div class="col-md-2 col-sm-2 col-xs-12">
  </div>
</div>
  </div>
  <div class="box-footer">
      <div class="row">

  <div class="col-md-3 col-sm-6 col-xs-12">

  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">

  </div>
  <?php
  if($ubah==1){
    $textsimpan='Ubah Realisasi';
  }else{
    $textsimpan='Simpan Realisasi';
  }
  ?>
  <div class="col-md-3 col-sm-6 col-xs-12 button-all">
 <button type="submit" class="btn btn-block btn-social btn-flat btn-success" data-toggle="tooltip" title="Simpan Semua Target Fisik"><i class="fa  fa-save"></i><?php echo $textsimpan?></button>

  </div>



  </div>
  </div>
  </div>
 </form>
</section>
<div class="modal fade" id="modalrealisasi" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <form id="formrealisasibljmodal" enctype="multipart/form-data" role="form" autocomplete="off">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
        <h4 class="modal-title"> </h4>
      </div>

      <div class="modal-body">


        <div class="row">
          <div class="col-md-12">
            <p id="iddet" hidden></p>
            <p id="code" hidden></p>
            <p id="idbmodal" hidden></p>
            <p id="realfissudah" hidden></p>
            <p id="realfisedit" hidden></p>
            <p id="realkeusudah" hidden></p>
            <p id="realkeuedit" hidden ></p>
            <!-- <p id="rek"></p> -->
            <p id="pagubmodalbln" hidden></p>
            <p id="mtgkey" hidden></p>
            <p id="pagukegiatan" hidden><?php echo $nl; ?></p>
             <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted">Rekening</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <h4 class="text-left text-muted"><p id="rekbmodal"></p></h4>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
              <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted">Nama Rekening</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-5 col-sm-5 col-xs-12">
                  <h4 class="text-left text-muted"><p id="nmrekbmodal"></p></h4>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
           <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted">Nilai Kontrak</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <h4 class="text-left text-muted"><input type="text" class="form-control" id="nilaikontrak"  style="text-align:right"></h4>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>

              <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted">Pelaksana / Penyedia PBJ</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <h4 class="text-left text-muted"><input type="text" class="form-control "  id="pbj" name="pbj" style="text-align:left"></h4>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
              <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted">Awal Kontrak</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right datepicker" id="awalktr" name="awalktr">
                        </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
              <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted">Akhir Kontrak</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right datepicker" id="akhirktr" name="akhirktr">
                        </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
              <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted">SPMK/SPP</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                   <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right datepicker" id="spmk" name="spmk">
                        </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
              <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted">Nomor Kontrak</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <h4 class="text-left text-muted"><input type="text" class="form-control "  id="nomorkontrak" name="nomorkontrak" style="text-align:left"></h4>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
              <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted">Bobot Belanja Modal</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <div class="input-group">
                                <input type="text" class=" form-control" id="bobotbljmodal"  name="bobotbljmodal" style="text-align: right;" readonly>
                                <div class="input-group-addon">
                                <i class="fa fa-percent"></i>
                                </div>
                                </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
              <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted">Target Fisik s/d Bulan Sekarang</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <div class="input-group">
                                <input type="text" class=" form-control" id="totargetfisik"  name="totargetfisik" style="text-align: right;" readonly>
                                <div class="input-group-addon">
                                <i class="fa fa-percent"></i>
                                </div>
                                </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
              <div class="row realfissudah2 " >
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted">Total Realisasi Fisik s/d Bulan Sekarang</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">

                  <div class="input-group">
                                <input type="text" class=" form-control" id="realfissudah2"  name="realfissudah2" style="text-align: right;" readonly>
                                <div class="input-group-addon">
                                <i class="fa fa-percent"></i>
                                </div>
                                </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
              <div class="row realkeusudah2" >
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted">Total Realisasi Keuangan s/d Bulan Sekarang</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">


                                <input type="text" class=" form-control" id="realkeusudah2"  name="realkeusudah2" style="text-align: right;" readonly>

                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
              <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">

                   <h4 class="text-left text-muted" id="texttrkbm">Tambahan Realisasi Keuangan</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">

                                <input type="text" class=" form-control" id="realkeubljmodal" name="realkeubljmodal"  style="text-align: right;" >
                                <!-- <div class="input-group-addon">
                                <i class="fa fa-percent"></i>
                                </div> -->

                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
              <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-12">
              </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted" id="texttrfbm">Tambahan Realisasi Fisik</h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <div class="input-group">
                                <input type="text" class=" form-control" id="realfisikbljmodal" name="realfisikbljmodal"  style="text-align: right;" >
                                <div class="input-group-addon">
                                <i class="fa fa-percent"></i>
                                </div>
                                </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>
              <div class="row">
                  <div class="col-md-1 col-sm-1 col-xs-12">
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                   <h4 class="text-left text-muted">Bobot Realisasi </h4>
                 </div>
                 <div class="col-md-1 col-sm-1 col-xs-12">
                  <h4 class="text-center text-muted">:</h4>
                </div>
                 <div class="col-md-4 col-sm-4 col-xs-12">
                   <div class="input-group">
                                <input type="text" class="form-control" id="realbobotbljmodal" name="realbobotbljmodal" style="text-align: right;" readonly>
                                <div class="input-group-addon">
                                <i class="fa fa-percent"></i>
                                </div>
                                </div>

                </div>
                <div class="col-md-2 col-sm-2 col-xs-12">
                </div>
              </div>


          </div>
       </div>

      </div>

      <div class="modal-footer modal-footer-tombol">

      </div>
      </form>
    </div>
  </div>
</div>



<script src="<?php echo base_url('assets/admin/plugins/input-mask/jquery.inputmask.bundle.js')?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/jquery-spinner/dist/js/jquery.spinner.js')?>"></script>

<script type="text/javascript">

  $(document).ready(function() {
    var bln =0;
    var thn =0;
    var tgl =0;
    ajaxtoken();
    totkeu();
    totsisadana();
    headtotsd();
    $(".select2").select2();
    $('.textarea').wysihtml5()
    $('.harga-satuan').inputmask("numeric",{
      radixPoint: ",",
      groupSeparator: ".",
      digits: 2,
      autoGroup: true,
      prefix: 'Rp ', //No Space, this will truncate the first character
      rightAlign: false,
      autoUnmask : true,
      oncleared: function () {
        self.Value('0');
      }
    });


    $('.harga-jumlah').inputmask("numeric",{
      radixPoint: ",",
      groupSeparator: ".",
      digits: 2,
      autoGroup: true,
      prefix: 'Rp ', //No Space, this will truncate the first character
      rightAlign: false,
      autoUnmask : true,
      oncleared: function () {
        self.Value('0');
      }
    });

    $('.sisadana').inputmask("numeric",{
      radixPoint: ",",
      groupSeparator: ".",
      digits: 2,
      autoGroup: true,
      prefix: 'Rp ', //No Space, this will truncate the first character
      rightAlign: false,
      autoUnmask : true,
      oncleared: function () {
        self.Value('0');
      }
    });

     $('.totkeu').inputmask("numeric",{
      radixPoint: ",",
      groupSeparator: ".",
      digits: 2,
      autoGroup: true,
      prefix: 'Rp ', //No Space, this will truncate the first character
      rightAlign: false,
      autoUnmask : true,
      oncleared: function () {
        self.Value('0');
      }
    });

      $('.totsisadana').inputmask("numeric",{
      radixPoint: ",",
      groupSeparator: ".",
      digits: 2,
      autoGroup: true,
      prefix: 'Rp ', //No Space, this will truncate the first character
      rightAlign: false,
      autoUnmask : true,
      oncleared: function () {
        self.Value('0');
      }
    });
    $('#nilaikontrak').inputmask("numeric",{
    radixPoint: ",",
    groupSeparator: ".",
    digits: 2,
    autoGroup: true,
    prefix: 'Rp ', //No Space, this will truncate the first character
    rightAlign: false,
    autoUnmask : true,
    oncleared: function () {
      self.Value('0');
    }
  });
  $('#realkeubljmodal').inputmask("numeric",{
  radixPoint: ",",
  groupSeparator: ".",
  digits: 2,
  autoGroup: true,
  prefix: 'Rp ', //No Space, this will truncate the first character
  rightAlign: false,
  autoUnmask : true,
  oncleared: function () {
    self.Value('0');
  }
});
  $('#realkeusudah2').inputmask("numeric",{
  radixPoint: ",",
  groupSeparator: ".",
  digits: 2,
  autoGroup: true,
  prefix: 'Rp ', //No Space, this will truncate the first character
  rightAlign: false,
  autoUnmask : true,
  oncleared: function () {
    self.Value('0');
  }
});
  $('#headtotsdana').inputmask("numeric",{
  radixPoint: ",",
  groupSeparator: ".",
  digits: 2,
  autoGroup: true,
  prefix: 'Rp ', //No Space, this will truncate the first character
  rightAlign: false,
  autoUnmask : true,
  oncleared: function () {
    self.Value('0');
  }
});

     $(".realfisik").inputmask({

       mask: "[999]",
       greedy: false,
       definitions: {
         '*': {
           validator: "[0-9]"
         }
       },
       rightAlign: true
      });

      $('.format-rupiah').inputmask("numeric",{
        radixPoint: ",",
        groupSeparator: ".",
        digits: 2,
        autoGroup: true,
        prefix: 'Rp ', //No Space, this will truncate the first character
        rightAlign: false,
        autoUnmask : true,
        oncleared: function () {
          self.Value('0');
        }
      });

      // $("#nilaikontrak").focusout(function() {
   $("#nilaikontrak").on('input change',function (e) {
        var pagu=$('#pagubmodalbln').html();
        var val= this.value;
        // newStr = parseInt(numbers.replace(/_/g, ""), 10);
        // console.log(val +'-'+ pagu);
        if(parseInt(val,10) > parseInt(pagu,10)){
          swal(
            'Upss ',
            'Total Melebihi Pagu',
            'info'
          )
          $("#nilaikontrak").val(0);

          return false;
        }
       // jumlah = jumlah > 100 ? swal(
       //      'info',
       //      'Target Fisik Belanja Modal Sudah di Entri',
       //      'info'
       //    ) this.select(): jumlah;
      });

  // $('#nilaikontrak').on('input change', function(e) {
  //
  // // console.log(pagumodal);
  //   if(this.value > $('#pagubmodalbln').html()){
  //     swal(
  //        'Ups',
  //        'Melebihi Pagu Belanja Modal',
  //        'info'
  //      );
  //     self.Value(0);
  //      return false;
  //   }
  // });

     $(".realfisik").on('input change',function (e) {
      var x=parseInt($(".realfisik").val());
      var botkeg=$('#botkeg').html();
      if (x>100){
         swal(
            'Ups',
            'Tidak Lebih Dari 100 %, ya :)',
            'info'
          );
         $(".realfisik").val('');
           $(".realbobot").val(0);
         return false;
      }else{




        var bobtreal=x/100*botkeg;



        if(isNaN(bobtreal)){
          $(".realbobot").val(0);
        }else{
          $(".realbobot").val( bobtreal.toFixed(3));
        }


      }
     });

     $("#realkeubljmodal").on('input change',function (e) {
          var pagu=$('#nilaikontrak').val();
          var val= this.value;


          // newStr = parseInt(numbers.replace(/_/g, ""), 10);

          if(pagu==0){
            swal(
              'Upss ',
              'Silahkan Entri Nilai Kontrak',
              'info'
            )
           $("#realkeubljmodal").val(0);
           return false;
         }else if(parseInt(val,10) > parseInt(pagu,10)){
            swal(
              'Upss ',
              'Total Melebihi Nilai Kontrak',
              'info'
            )
            $("#realkeubljmodal").val(0);

            return false;
          }
         // jumlah = jumlah > 100 ? swal(
         //      'info',
         //      'Target Fisik Belanja Modal Sudah di Entri',
         //      'info'
         //    ) this.select(): jumlah;
        });

     $("#realfisikbljmodal").on('input change',function (e) {

       var status =  $('#code').html();
       if (status != 4){
         var x = parseInt($("#realfisikbljmodal").val());
         var y = parseInt($('#realfissudah').html());
         var xy= x+y;
         var botblj=$('#bobotbljmodal').val();
         if (xy>100){
            swal(
               'Ups',
               'Tidak Lebih Dari 100 %, ya :)',
               'info'
             );
            $("#realfisikbljmodal").val('');
              $("#realbobotbljmodal").val(0);
            return false;
         }else{

           var bobtreal=x/100*botblj;

           if(isNaN(bobtreal)){
             $("#realbobotbljmodal").val(0);
           }else{
             $("#realbobotbljmodal").val( bobtreal.toFixed(3));
           }


         }
       }else{
         var x = parseInt($("#realfisikbljmodal").val());
         var y = parseInt($('#realfissudah').html());
         var z = parseInt($('#realfisedit').html());
         var yz= y-z;
         var xyz= x+yz;
         var botblj=$('#bobotbljmodal').val();
         if (xyz>100){
            swal(
               'Ups',
               'Tidak Lebih Dari 100 %, ya :)',
               'info'
             );
            $("#realfisikbljmodal").val('');
              $("#realbobotbljmodal").val(0);
            return false;
         }else{

           var bobtreal=x/100*botblj;

           if(isNaN(bobtreal)){
             $("#realbobotbljmodal").val(0);
           }else{
             $("#realbobotbljmodal").val( bobtreal.toFixed(3));
           }


         }
       }
     });

    $('.spinner').spinner('changed', function(e, newVal) {
       // alert(newVal);
        var row = $(this).closest("tr");    // Find the row
        var vol = row.find(".vl").val();

        var res = row.find(".rek").val();
        var rek = res.replace(/\./g, "-");
        var hs = row.find(".harga-satuan").val(); // Find the text
        var jumlah =hs.replace(",", ".")*vol;
        var jumyek = row.find(".jumy").text();
        var totjum = row.find(".totjum").text();
        var totpagu =  row.find(".totpagu").text();
        var totpagubln =  row.find(".totpagubln"+rek).text();
        if(parseInt(vol, 10)===0){
          row.find(".vl").val(0);
          row.find(".harga-satuan").val(0);
          var vol = row.find(".vl").val();
          var hs  = row.find(".harga-satuan").val();
          var jumlah =hs.replace(",", ".")*vol;
          var sisa= parseInt(totjum, 10) - parseInt(jumlah, 10);
          row.find(".harga-jumlah").val(jumlah);
          row.find(".sisadana").val(sisa);
          totperrek(rek);
          totkeu();
          totsisadana();
        }else if(parseInt(vol, 10) > parseInt(jumyek, 10)){
          swal(
            'info',
            'Volume Melebihi Yang di Tetapkan!!!',
            'info'
          );
          row.find(".vl").val(0);
          row.find(".harga-satuan").val(0);
          var vol = row.find(".vl").val();
          var hs  = row.find(".harga-satuan").val();
          var jumlah =hs.replace(",", ".")*vol;
          var sisa= parseInt(totjum, 10) - parseInt(jumlah, 10);
          row.find(".harga-jumlah").val(jumlah);
          row.find(".sisadana").val(sisa);
          totperrek(rek);
          totkeu();
          totsisadana();
        }
        if(parseInt(jumlah, 10) > parseInt(totpagu, 10) ) {
            swal(
              'info',
              'Total Jumlah Melebihi Pagu!!!',
              'info'
            );


            row.find(".sisadana").val(totpagu);
            row.find(".harga-satuan").val(0);
            row.find(".harga-jumlah").val(0);
              totperrek(rek);
              totkeu();
              totsisadana();
             return false;
        }else{
          var sisa= parseInt(totjum, 10) - parseInt(jumlah, 10)

          row.find(".sisadana").val(sisa);
          row.find(".harga-jumlah").val(jumlah);
           var tot = totperrek(rek);
            if(tot > totpagubln){
               swal(
              'info',
              'Total Jumlah Melebihi Pagu Bulan Sekarang!!!',
              'info'
            );
                row.find(".sisadana").val(totpagu);
                row.find(".harga-satuan").val(0);
                row.find(".harga-jumlah").val(0);
              totperrek(rek);
              totkeu();
              totsisadana();
             return false;
            }

           totkeu();
           totsisadana();
        }


    });

    $('.harga-satuan').on('input change', function(e, newVal) {
       // alert(newVal);
        var row = $(this).closest("tr");    // Find the row
        var vol = row.find(".vl").val();
        var res = row.find(".rek").val();

        var rek = res.replace(/\./g, "-");
        var hs = row.find(".harga-satuan").val(); // Find the text
        var jumlah =hs.replace(",", ".");
        var tarif = row.find(".tarif").text();
        var totpagu =  row.find(".totpagu").text();
        var totpagubln =  row.find(".totpagubln"+rek).text();

        var totjumsd = row.find(".totjum").text();
        if(parseInt(jumlah, 10) > parseInt(tarif, 10)){
          swal(
            'info',
            'Harga Melebihi Harga Yang di Tetapkan!!!',
            'info'
          );
            var sisa= parseInt(totjumsd, 10) - parseInt(totjum, 10)

              row.find(".sisadana").val(totpagu);
          row.find(".harga-satuan").val(0);
          row.find(".harga-jumlah").val(0);
          totperrek(rek);

           totkeu();
           totsisadana();
          return false;
        }else if(parseInt(vol, 10)===0)
        {
          swal(
            'info',
            'Silahkan Isi Volume!!!',
            'info'
          );
            var sisa= parseInt(totjumsd, 10) - parseInt(totjum, 10)

          row.find(".sisadana").val(totpagu);
          row.find(".harga-satuan").val(0);
          row.find(".harga-jumlah").val(0);
           totperrek(rek);

           totkeu();
           totsisadana();
          return false;
        }
        else{
          var totjum=jumlah*vol;

          if(parseInt(totjum, 10) > parseInt(totpagu, 10)){
            swal(
              'info',
              'Total Jumlah Melebihi Pagu!!!',
              'info'
            );
              var sisa= parseInt(totjumsd, 10) - parseInt(totjum, 10)

              row.find(".sisadana").val(totpagu);
              row.find(".harga-satuan").val(0);
              row.find(".harga-jumlah").val(0);
              totperrek(rek);

              totkeu();
              totsisadana();

              return false;
           }else{
             var sisa= parseInt(totjumsd, 10) - parseInt(totjum, 10)

              row.find(".sisadana").val(sisa);
             row.find(".harga-jumlah").val(totjum);
             var tot = totperrek(rek);
              if(tot > totpagubln){
                 swal(
                'info',
                'Total Jumlah Melebihi Pagu Bulan Sekarang!!!',
                'info'
              );
                  row.find(".sisadana").val(totpagu);
                  row.find(".harga-satuan").val(0);
                  row.find(".harga-jumlah").val(0);
                totperrek(rek);
                totkeu();
                totsisadana();
               return false;
              }
             totkeu();
             totsisadana();
           }
        }

    });
    $(".btnrealfisik").click(function() {
      var bulan = {
        'January':'0','February':'1',
        'March':'2','April':'3','May':'4',
        'June':'5','July':'6','August':'7',
        'September':'8','October':'9',
        'November':'10','December':'11'};

        var row = $(this).closest("tr");    // Find the row
        var res = row.find(".rekheader").text();
        var rek = res.replace(/\./g, "-");
        var nmrek = row.find(".nmrekheader").text();
        var mtgkey = row.find(".mtgkey").text();
        var totpagubln =  row.find(".totpagubln"+rek).text();
        var indexbln = $('#indexbulan').html();
        var idtab = $('#idtab').html();

        $.ajax({
          url: base_url+"User/cekrealbmodal/"+Math.random(),
          type: "POST",
          data: {

            idtab   : idtab,
            mtgkey  : mtgkey,
            indexbulan : indexbln
          },
          dataType: "JSON",
          success: function(result){
              //jika code = 0 maka entri baru
              if (result.data[0].code == 0){
                $('#awalktr').datepicker({
                  format: "dd MM yyyy",
                  language: "id",
                  autoclose: true
                }).on("input change", function (e) {
                var namabln =this.value;
                var convert = namabln.split(" ");
                tgl = convert[0];
                bln = bulan[convert[1]];
                thn = convert[2];
                // console.log(tgl +'-'+ bln +'-'+thn);
                $('#akhirktr').datepicker('setDate', null);
                $('#akhirktr').datepicker('destroy');
                $('#akhirktr').datepicker({
                  format: "dd MM yyyy",
                  autoclose: true,
                  startDate: new Date(thn,bln,tgl),
                }).on("input change", function (e) {
                  var namabln2 =this.value;
                  var convert2 = namabln2.split(" ");
                  var tgl2 = convert2[0];
                  var bln2 = bulan[convert2[1]];
                  var thn2 = convert2[2];
                  $('#spmk').datepicker('setDate', null);
                  $('#spmk').datepicker('destroy');
                  $('#spmk').datepicker({
                    format: "dd MM yyyy",
                    autoclose: true,
                    startDate: new Date(thn,bln,tgl),
                    endDate: new Date(thn2,bln2,tgl2)
                  });
                });
              });
                modalrealisasi({
                      buttons: {
                        batal: {
                          id    : 'btn-modal-tutup',
                          type  : 'button',
                          css   : 'btn-danger btn-raised btn-flat ',
                          label : 'Tutup'
                        },
                        simpan: {
                          id    : 'btn-modal-simpan',
                          type  : 'submit',
                          css   : 'btn-info btn-raised btn-flat btn-bitbucket',
                          label : 'Simpan'
                        }
                      },
                      title: 'Realiasasi Belanja Modal',
                      rek:res,
                      nmrek:nmrek,
                      mtgkey:mtgkey,
                      paguprbln:totpagubln,
                      status : result.data[0].code,
                      tottarfis :result.data[0].targetfis


                    });
              }else if(result.data[0].code == 1){
                  //code 1 = Master sudah ada tetapi detail belum ada
                  $('#awalktr').datepicker({
                   format: "dd MM yyyy",
                   language: "id",
                   autoclose: true

                 }).on("input change", function (e) {

                   var namabln =this.value;
                   var convert = namabln.split(" ");

                   tgl = convert[0];
                   bln = bulan[convert[1]];
                   thn = convert[2];
                   // console.log(tgl +'-'+ bln +'-'+thn);
                   $('#akhirktr').datepicker('setDate', null);
                   $('#akhirktr').datepicker('destroy');
                   $('#akhirktr').datepicker({
                       format: "dd MM yyyy",

                       autoclose: true,
                       startDate: new Date(thn,bln,tgl),


                     }).on("input change", function (e) {
                       var namabln2 =this.value;
                       var convert2 = namabln2.split(" ");
                       var tgl2 = convert2[0];
                       var bln2 = bulan[convert2[1]];
                       var thn2 = convert2[2];
                       $('#spmk').datepicker('setDate', null);
                       $('#spmk').datepicker('destroy');
                       $('#spmk').datepicker({
                           format: "dd MM yyyy",
                           autoclose: true,
                           startDate: new Date(thn,bln,tgl)



                         });


                     });
                   });
                  var jumreal = result.data[0].realfisik;
                   if (jumreal < 100){
                     modalrealisasi({
                           buttons: {
                             batal: {
                               id    : 'btn-modal-tutup',
                               type  : 'button',
                               css   : 'btn-danger btn-raised btn-flat ',
                               label : 'Tutup'
                             },
                             simpan: {
                               id    : 'btn-modal-simpan',
                               type  : 'submit',
                               css   : 'btn-info btn-raised btn-flat btn-bitbucket',
                               label : 'Simpan'
                             }
                           },
                           title: 'Realiasasi Belanja Modal',
                           rek:res,
                           nmrek:nmrek,
                           mtgkey:mtgkey,
                           paguprbln:totpagubln,
                           nlktrk:result.data[0].nilai_ktrk,
                           pbj:result.data[0].pbj,
                           awlktrk : result.data[0].awlktrk,
                           akrktrk : result.data[0].akrktrk,
                           spmk    : result.data[0].spmk,
                           noktrk  : result.data[0].noktrk,
                           status : result.data[0].code,
                           tottarfis :result.data[0].targetfis,
                           realfisik : result.data[0].realfisik,
                           realkeu:result.data[0].jumrealkeu,
                           idbmodal : result.data[0].idbmodal
                         });
                   }else{
                       swal({
                         title: 'Info',
                         text: 'Realisasi Belanja Modal Sudah 100%',
                         type: 'info',
                         confirmButtonClass: "btn btn-danger",
                         buttonsStyling: false
                       })
                   }

              }
              // else if(result.data[0].code == 2){
              //   swal({
              //     title: 'Info',
              //     text: 'Realisasi Belanja Modal Sudah 100%',
              //     type: 'info',
              //     confirmButtonClass: "btn btn-danger",
              //     buttonsStyling: false
              //   })
              // }
              else if(result.data[0].code == 4){
                //code 4 = realisasi masih bisa di edit
                $('#awalktr').datepicker({
                 format: "dd MM yyyy",
                 language: "id",
                 autoclose: true

               }).on("input change", function (e) {

                 var namabln =this.value;
                 var convert = namabln.split(" ");

                 tgl = convert[0];
                 bln = bulan[convert[1]];
                 thn = convert[2];
                 // console.log(tgl +'-'+ bln +'-'+thn);
                 $('#akhirktr').datepicker('setDate', null);
                 $('#akhirktr').datepicker('destroy');
                 $('#akhirktr').datepicker({
                     format: "dd MM yyyy",

                     autoclose: true,
                     startDate: new Date(thn,bln,tgl),


                   }).on("input change", function (e) {
                     var namabln2 =this.value;
                     var convert2 = namabln2.split(" ");
                     var tgl2 = convert2[0];
                     var bln2 = bulan[convert2[1]];
                     var thn2 = convert2[2];
                     $('#spmk').datepicker('setDate', null);
                     $('#spmk').datepicker('destroy');
                     $('#spmk').datepicker({
                         format: "dd MM yyyy",
                         autoclose: true,
                         startDate: new Date(thn,bln,tgl),
                         // endDate: new Date(thn2,bln2,tgl2)


                       });


                   });
                 });
                modalrealisasi({

                      buttons: {
                        batal: {
                          id    : 'btn-modal-tutup',
                          type  : 'button',
                          css   : 'btn-danger btn-raised btn-flat ',
                          label : 'Tutup'
                        },
                        simpan: {
                          id    : 'btn-modal-simpan',
                          type  : 'submit',
                          css   : 'btn-info btn-raised btn-flat btn-bitbucket',
                          label : 'Simpan'
                        }
                      },
                      title: 'Ubah Realisasi Belanja Modal Bulan Sekarang',
                      rek:res,
                      nmrek:nmrek,
                      mtgkey:mtgkey,
                      paguprbln:totpagubln,
                      nlktrk:result.data[0].nilai_ktrk,
                      pbj:result.data[0].pbj,
                      awlktrk : result.data[0].awlktrk,
                      akrktrk : result.data[0].akrktrk,
                      spmk    : result.data[0].spmk,
                      noktrk  : result.data[0].noktrk,
                      realbj  : result.data[0].realblj,
                      bbtbj   :result.data[0].bobotrealblj,
                      status  : result.data[0].code,
                      realfisik : result.data[0].realfisik,
                       realkeu:result.data[0].jumrealkeu,
                      idbmodal : result.data[0].idbmodal,
                      iddet : result.data[0].iddet,
                      tottarfis :result.data[0].targetfis,
                      realkeublj : result.data[0].realkeublj

                    });
              }
              // else{
              //   //code 3 = realisasi belum 100 persen dan masih bisa tambah
              //   modalrealisasi({
              //
              //         buttons: {
              //           batal: {
              //             id    : 'btn-modal-tutup',
              //             type  : 'button',
              //             css   : 'btn-danger btn-raised btn-flat ',
              //             label : 'Tutup'
              //           },
              //           simpan: {
              //             id    : 'btn-modal-simpan',
              //             type  : 'submit',
              //             css   : 'btn-info btn-raised btn-flat btn-bitbucket',
              //             label : 'Simpan'
              //           }
              //         },
              //         title: 'Realiasasi Belanja Modal3',
              //         rek:res,
              //         nmrek:nmrek,
              //         mtgkey:mtgkey,
              //         paguprbln:totpagubln,
              //         nlktrk:result.data[0].nilai_ktrk,
              //         pbj:result.data[0].pbj,
              //         awlktrk : result.data[0].awlktrk,
              //         akrktrk : result.data[0].akrktrk,
              //         spmk    : result.data[0].spmk,
              //         noktrk  : result.data[0].noktrk,
              //         status : result.data[0].code,
              //         realfisik : result.data[0].realfisik,
              //         idbmodal : result.data[0].idbmodal
              //
              //       });
              //
              // }

              // if (jsonData.data[0].status == false){
              //
              // }else{
              //
              // }
          },
          error: function(jqXHR, textStatus, errorThrown){

            swal({
              title: 'Kesalahan !!',
              text: 'Reload Lagi',
              type: 'error',
              confirmButtonClass: "btn btn-danger",
              buttonsStyling: false
            })
              ajaxtoken();
          }
        });




           //  $('#awalktr').datepicker({
           //   format: "dd MM yyyy",
           //   language: "id",
           //   autoclose: true
           //
           // }).on("input change", function (e) {
           //
           //   var namabln =this.value;
           //   var convert = namabln.split(" ");
           //
           //   tgl = convert[0];
           //   bln = bulan[convert[1]];
           //   thn = convert[2];
           //   // console.log(tgl +'-'+ bln +'-'+thn);
           //   $('#akhirktr').datepicker('setDate', null);
           //   $('#akhirktr').datepicker('destroy');
           //   $('#akhirktr').datepicker({
           //       format: "dd MM yyyy",
           //
           //       autoclose: true,
           //       startDate: new Date(thn,bln,tgl),
           //
           //
           //     }).on("input change", function (e) {
           //       var namabln2 =this.value;
           //       var convert2 = namabln2.split(" ");
           //       var tgl2 = convert2[0];
           //       var bln2 = bulan[convert2[1]];
           //       var thn2 = convert2[2];
           //       $('#spmk').datepicker('setDate', null);
           //       $('#spmk').datepicker('destroy');
           //       $('#spmk').datepicker({
           //           format: "dd MM yyyy",
           //           autoclose: true,
           //           startDate: new Date(thn,bln,tgl),
           //           endDate: new Date(thn2,bln2,tgl2)
           //
           //         });
           //
           //     });
           //   });

    });

  });
function totperrek(rek){
     var arr = $("."+rek);
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    //console.log(tot);
    var pagubulan =  $(".pg"+rek).val();
    var hs= parseInt(pagubulan)-tot;

    $(".harga-rek"+rek).val(tot);
    $(".sisadana"+rek).val(hs);


     return tot;

}
function totkeu(){
    var arr = $(".harga-jumlah");
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    var arrx = $(".real5-2-3");
    var tot523=0;
    for(var i=0;i<arrx.length;i++){
        if(parseInt(arrx[i].value))
             tot523 += parseInt(arrx[i].value);
    }


    $(".totkeu").val(parseInt(tot, 10) + parseInt(tot523, 10));

}

function headtotsd(){
    var arr = $(".headtotsd");
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }

    $("#headtotsdana").val(parseInt(tot, 10) );

}
function totsisadana(){
    var arr = $(".nsisadana");
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    var arrx = $(".real5-2-3");
    var tot523=0;
    for(var i=0;i<arrx.length;i++){
        if(parseInt(arrx[i].value))
             tot523 += parseInt(arrx[i].value);
    }

      $(".totsisadana").val(parseInt(tot, 10) - parseInt(tot523, 10));

}

$(function () {
  $('#formrealisasibljmodal').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
    }
    ajaxtoken();
    var status =  $('#code').html();
    var iddet =  $('#iddet').html();
    var rekbmodal= $('#rekbmodal').html();
    var rek = rekbmodal.replace(/\./g, "-");
    if(status==0){
      swal({
        title: "Simpan Realisasi Belanja Modal",
        text: "Pastikan data sudah benar",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#367FA9",
        confirmButtonText: "Ya, Simpan",
        cancelButtonText: "Tidak, Batal!",
        closeOnConfirm: false,
        closeOnCancel: false
       }, function (isConfirm) {
        if (isConfirm) {
          Pace.restart ();
          Pace.track (function (){
          var token   = localStorage.getItem("token");
          var tab     = $('#idtab').html();
          var mtgkey  = $('#mtgkey').html();
          var bulan   = $('#idbulan').html();
          var tahun   = $('#idtahun').html();
          var nilaikontrak   = $('#nilaikontrak').val();
          var realkeubljmodal  = $('#realkeubljmodal').val();
          var formData = new FormData($('#formrealisasibljmodal')[0]);
          formData.append("token",token);
          formData.append("tahun",tahun);
          formData.append("bulan",bulan);
          formData.append("idtab",tab);
          formData.append("mtgkey",mtgkey);
          formData.append("nilaikontrak",nilaikontrak);
          formData.append("realkeubljmodal",realkeubljmodal);
          $.ajax({
            url: base_url+"User/simpanrealisasibmodal",
            type: 'POST',
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success: function(result){

              var jsonData = JSON.parse(result);

                if (jsonData.data[0].status == false){
                  swal(
                    'info',
                    'Terjadi Kesalahan saat simpan!!!',
                    'info'
                  );
                  ajaxtoken();
                }else{

                  ajaxtoken();
                  var nlktrk = jsonData.data[0].nilai;
                  var realkeu = jsonData.data[0].realkeu;
                  var render = jsonData.data[0].render;
                  swal({
                    title: "Sukses",
                    text: "Data berhasil disimpan!!!",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#008D4C",
                    confirmButtonText: "OK",
                    cancelButtonText: "",
                    closeOnConfirm: false,
                    closeOnCancel: false
                  },function(isConfirm){
                    if(isConfirm){
                      swal.close();

                      $('#modalrealisasi').modal('hide');
                      $(".harga-rek"+rek).val(nlktrk);
                        $("#totnlrealbmodal"+rek).val(realkeu);
                      totkeu();
                      totsisadana();
                    }
                  });
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
              swal({
                title: 'Kesalahan !!',
                text: 'Gagal Simpan Data',
                type: 'error',
                confirmButtonClass: "btn btn-danger",
                buttonsStyling: false
              })
            }
          });
          });
        } else {
          swal("Batal", "Batal Simpan", "error");
        }
      });
    }else if(status==4){
      swal({
        title: "Ubah Realisasi Belanja Modal Bulan Sekarang",
        text: "Pastikan data sudah benar",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#367FA9",
        confirmButtonText: "Ya, Ubah",
        cancelButtonText: "Tidak, Batal!",
        closeOnConfirm: false,
        closeOnCancel: false
       }, function (isConfirm) {
        if (isConfirm) {
          Pace.restart ();
          Pace.track (function (){
          var token   = localStorage.getItem("token");
          var iddet     = $('#iddet').html();
          var realkeubljmodal  = $('#realkeubljmodal').val();

          var formData = new FormData($('#formrealisasibljmodal')[0]);
          formData.append("token",token);
          formData.append("iddet",iddet);
          formData.append("realkeubljmodal",realkeubljmodal);

          $.ajax({
            url: base_url+"User/ubahrealisasibmodaldet",
            type: 'POST',
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success: function(result){

              var jsonData = JSON.parse(result);

                if (jsonData.data[0].status == false){
                  swal(
                    'info',
                    'Terjadi Kesalahan Saat Ubah!!!',
                    'info'
                  );
                  ajaxtoken();
                }else{
                  ajaxtoken();
                  swal({
                    title: "Sukses",
                    text: "Data berhasil diubah!!!",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#008D4C",
                    confirmButtonText: "OK",
                    cancelButtonText: "",
                    closeOnConfirm: false,
                    closeOnCancel: false
                  },function(isConfirm){
                    if(isConfirm){
                      swal.close();
                           $('#modalrealisasi').modal('hide');
                    }
                  });
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
              swal({
                title: 'Kesalahan !!',
                text: 'Gagal Simpan Data',
                type: 'error',
                confirmButtonClass: "btn btn-danger",
                buttonsStyling: false
              })
            }
          });
          });
        } else {
          swal("Batal", "Batal Simpan", "error");
        }
      });
    }else{
      swal({
        title: "Tambah Belanja Modal",
        text: "Pastikan data sudah benar",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#367FA9",
        confirmButtonText: "Ya, Simpan",
        cancelButtonText: "Tidak, Batal!",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          Pace.restart ();
          Pace.track (function (){
          var token   = localStorage.getItem("token");
          var tabbmodal     = status;
          var bulan   = $('#idbulan').html();
          var tahun   = $('#idtahun').html();
          var formData = new FormData($('#formrealisasibljmodal')[0]);
          formData.append("token",token);
          formData.append("tabbmodal",tabbmodal);
          formData.append("tahun",tahun);
          formData.append("bulan",bulan);

          $.ajax({
            url: base_url+"User/simpanrealisasibmodaldet",
            type: 'POST',
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success: function(result){

              var jsonData = JSON.parse(result);

                if (jsonData.data[0].status == false){
                  swal(
                    'info',
                    'Terjadi Kesalahan saat simpan!!!',
                    'info'
                  );
                  ajaxtoken();
                }else{
                  ajaxtoken();
                  swal({
                    title: "Sukses",
                    text: "Data berhasil disimpan!!!",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#008D4C",
                    confirmButtonText: "OK",
                    cancelButtonText: "",
                    closeOnConfirm: false,
                    closeOnCancel: false
                  },function(isConfirm){
                    if(isConfirm){
                      swal.close();
                           $('#modalrealisasi').modal('hide');
                    }
                  });
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
              swal({
                title: 'Kesalahan !!',
                text: 'Gagal Simpan Data',
                type: 'error',
                confirmButtonClass: "btn btn-danger",
                buttonsStyling: false
              })
            }
          });
          });
        } else {
          swal("Batal", "Batal Simpan", "error");
        }
      });
    }

    });

  $('#formrealisasi').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
    }
    if ($('#realfisik').val() === '') {

          swal(
        'info',
        'Field Realisasi Fisik Tidak Boleh Kosong',
        'info'
        );
          return false;
      }else{

        swal({
          title: "Simpan Realisasi",
          text: "Pastikan data sudah benar",
          type: "info",
          showCancelButton: true,
          confirmButtonColor: "#367FA9",
          confirmButtonText: "Ya, Simpan",
          cancelButtonText: "Tidak, Batal!",
          closeOnConfirm: false,
          closeOnCancel: false
        }, function (isConfirm) {

          if (isConfirm) {
            Pace.restart ();
            Pace.track (function (){
            var token   = localStorage.getItem("token");
            var idubah =$('#idubah').html();
            var idreal =$('#idreal').html();
            var pertama =1;
            var tab     = $('#idtab').html();
            var botkeg  = $('#botkeg').html();
            var bulan   = $('#idbulan').html();
            var tahun   = $('#idtahun').html();

            var realkeu   = $('#realkeu').val();
            var totsdana   = $('#totsdana').val();
            var realfisik   = $('#realfisik').val();
            var realbobot   = $('#realbobot').val();
            var formData = new FormData($('#formrealisasi')[0]);
            formData.append("token",token);
            formData.append("pertama",pertama);
            formData.append("idubah",idubah);
            formData.append("idreal",idreal);
            formData.append("idtab",tab);
            formData.append("botkeg",botkeg);
            formData.append("bulan",bulan);
            formData.append("tahun",tahun);
            formData.append("realkeu",realkeu);
            formData.append("totsdana",totsdana);
            formData.append("realfisik",realfisik);
            formData.append("realbobot",realbobot);
            $.ajax({
              url: base_url+"User/simpanrealisasi",
              type: 'POST',
              data: formData,
              mimeType: "multipart/form-data",
              contentType: false,
              cache: false,
              processData: false,
              success: function(result){
                    console.log(result);
                var jsonData = JSON.parse(result);

                  if (jsonData.data[0].status == false){
                    swal(
                      'info',
                      'Terjadi Kesalahan saat simpan!!!',
                      'info'
                    );
                    ajaxtoken();
                  }else{
                    ajaxtoken();
                    swal({
                      title: "Sukses",
                      text: "Data berhasil disimpan!!!",
                      type: "success",
                      showCancelButton: false,
                      confirmButtonColor: "#008D4C",
                      confirmButtonText: "OK",
                      cancelButtonText: "",
                      closeOnConfirm: false,
                      closeOnCancel: false
                    },function(isConfirm){
                      if(isConfirm){
                        swal.close();
                           window.location.href = base_url+"User/dafkeg/";
                      }
                    });
                  }
              },
              error: function(jqXHR, textStatus, errorThrown){
                swal({
                  title: 'Kesalahan !!',
                  text: 'Gagal Simpan Data',
                  type: 'error',
                  confirmButtonClass: "btn btn-danger",
                  buttonsStyling: false
                })
              }
            });
            });
          } else {
            swal("Batal", "Batal Simpan", "error");
          }
        });

      }

  });


});
</script>
