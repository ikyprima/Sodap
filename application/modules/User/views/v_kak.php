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
       <p id="kdunit" hidden><?php echo $idopd ?></p>
       <div class="row">
        <div class="col-md-2 col-sm-2" style="text-align: left">Organisasi</div>
        <div class="col-md-1 col-sm-1" style="text-align: right;width: 5px">:</div>
        <div class="col-md-9 col-sm-9" style="padding-left: 25px"><?php echo $nmopd ?></div>
      </div>
      <br>

      <div class="row">
        <div class="col-md-2 col-sm-2" style="text-align: left">Tahun</div>
        <div class="col-md-1 col-sm-1" style="text-align: right;width: 5px">:</div>
        <div class="col-md-9 col-sm-9" style="padding-left: 25px"><?php echo $tahun ?>

      </div>
    </div>
    <br>



  </div>

</div>

</div>

<div class="row">

  <div class="col-md-3 col-sm-6 col-xs-12">
    <a class="btn btn-block btn-social btn-success btn-flat" id="btn-kembali">
      <i class="fa fa-arrow-left"></i> Kembali
    </a>
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">

  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">


  </div>

<div class="col-md-2 col-sm-7 col-xs-12 pull-right">
     <a class="btn btn-danger btn-social btn-success" target="_blank" href="<?php echo base_url("User/timeschedule/").$idtab; ?>">
                     <i class="fa fa-print"></i> Cetak Time Schedule
    </a>
 </div>

  <div class="col-md-2 col-sm-7 col-xs-12 pull-right">
     <a class="btn btn-danger btn-social btn-success" target="_blank" href="<?php echo base_url("User/lapkak/").$idtab; ?>">
                     <i class="fa fa-print"></i> Cetak KAK
    </a>
 </div>



</div>
<br>
<!-- Default box -->

<div class="box box-primary">
  <div class="box-header with-border">
    <i class="fa fa-text-width"></i>

    <h3 class="box-title">Detail KAK</h3>
  </div>
  <div class="box-body">
    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
          <h2 class="text-center">KERANGKA ACUAN KERJA</h2>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
        </div>
     </div>
     <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
        <h3 class="text-center"><?php echo $list->program ?></h3>
        <h3 class="text-center">Kegiatan <?php echo $list->kegiatan ?></h3>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
        </div>
      </div>
      <hr>
      <div class="row">
          <div class="col-md-1 col-sm-1 col-xs-12">
          </div>
          <div class="col-md-5 col-sm-5 col-xs-12">
           <h4 class="text-left"><b>I. PENDAHULUAN</b></h4>

         </div>


       </div>
       <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
         <h5 class="text-left" style="margin-left: 20px"><b>A. LATAR BELAKANG</b></h5>

       </div>
      </div>
      <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-10 col-sm-2 col-xs-12">
         <h5 class="text-justify" style="margin-left: 35px"><?php echo $list->i_a_ltrblk ?></h5>

       </div>
      </div>
      <div class="row">
          <div class="col-md-1 col-sm-1 col-xs-12">
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
           <h5 class="text-left" style="margin-left: 20px"><b>B. TUJUAN DAN SASARAN</b></h5>

         </div>
       </div>
       <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
         <h5 class="text-left" style="margin-left: 40px"><b>1. TUJUAN</b></h5>

        </div>
       </div>
       <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-10 col-sm-2 col-xs-12">
         <h5 class="text-justify" style="margin-left: 55px"><?php echo $list->i_b_1_tujuan ?></h5>

       </div>
      </div>
      <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
         <h5 class="text-left" style="margin-left: 40px"><b>2. Sasaran</b></h5>

        </div>
       </div>
       <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-10 col-sm-2 col-xs-12">
         <h5 class="text-justify" style="margin-left: 55px"><?php echo $list->i_b_2_sasaran ?></h5>

       </div>
      </div>
      <div class="row">
          <div class="col-md-1 col-sm-1 col-xs-12">
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
           <h5 class="text-left " style="margin-left: 20px"><b>C. Indikator Kinerja</b></h5>

         </div>
       </div>
       <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
         <h5 class="text-left" style="margin-left: 40px"><b>1. Input (Masukan)</b></h5>

        </div>
       </div>
       <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-10 col-sm-2 col-xs-12">
         <h5 class="text-justify" style="margin-left: 55px"><?php echo $list->c_1_input ?></h5>

       </div>
      </div>
      <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
         <h5 class="text-left" style="margin-left: 40px"><b>2. Output (Keluaran)</b></h5>

        </div>
       </div>
       <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-10 col-sm-2 col-xs-12">
         <h5 class="text-justify" style="margin-left: 55px"><?php echo $list->c_2_output ?></h5>

       </div>
      </div>
      <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
         <h5 class="text-left" style="margin-left: 40px"><b>3. Outcomes (Hasil) </b></h5>

        </div>
       </div>
       <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-10 col-sm-2 col-xs-12">
         <h5 class="text-justify" style="margin-left: 55px"><?php echo $list->c_3_outcome ?></h5>

       </div>
      </div>
      <div class="row">
          <div class="col-md-1 col-sm-1 col-xs-12">
          </div>
          <div class="col-md-5 col-sm-5 col-xs-12">
           <h4 class="text-left"><b>II. PROSES PELAKSANAAN KEGIATAN</b></h4>

         </div>
       </div>
     <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
         <h5 class="text-left" style="margin-left: 20px"><?php echo $list->iii_proses_pelaksana ?></h5>
       </div>
      </div>
      <div class="row">
          <div class="col-md-1 col-sm-1 col-xs-12">
          </div>
          <div class="col-md-5 col-sm-5 col-xs-12">
           <h4 class="text-left"><b>III. PENUTUP</b></h4>

         </div>
       </div>
     <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
         <h5 class="text-left" style="margin-left: 20px"><?php echo $list->iii_penutup ?></h5>
       </div>
      </div>


    <div class="box box-info">
        <div class="box-header">
          <i class="fa fa-clock-o"></i>

          <h3 class="box-title">Time Schedule Kegiatan</h3>
          <!-- tools box -->

          <!-- /. tools -->
        </div>
        <div class="box-body">
         <div class="table-responsive">
          <table class="table table-bordered tabel-schedule" style="width: 100%" id="tb-uraian">
            <thead>
              <tr>

                <th rowspan="2" style="vertical-align : middle;text-align:center;">#</th>
                <th rowspan="2" class='text-center' style="vertical-align : middle;width: 20%">&nbsp&nbsp&nbsp&nbsp&nbspNama&nbspUraian&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                <th colspan="4" class='text-center ' style="width: 4%">Januari</th>
                <th colspan="4" class='text-center 'style="width: 4%">Februari</th>
                <th colspan="4" class='text-center' style="width: 4%">Maret</th>
                <th colspan="4" class='text-center' style="width: 4%">April</th>
                <th colspan="4" class='text-center ' style="width: 4%">Mei</th>
                <th colspan="4" class='text-center ' style="width: 4%">Juni</th>
                <th colspan="4" class='text-center ' style="width: 4%">Juli</th>
                <th colspan="4" class='text-center ' style="width: 4%">Agustus</th>
                <th colspan="4" class='text-center ' style="width: 4%">September</th>
                <th colspan="4" class='text-center ' style="width: 4%">Oktober</th>
                <th colspan="4" class='text-center ' style="width: 4%">November</th>
                <th colspan="4" class='text-center ' style="width: 4%">Desember</th>

              </tr>
              <tr>

                <th style="min-width:2px; font-size: 10px">1</th>
                <th style="min-width:2px; font-size: 10px">2</th>
                <th style="min-width:2px; font-size: 10px">3</th>
                <th style="min-width:2px; font-size: 10px">4</th>
                <th style="min-width:2px; font-size: 10px">1</th>
                <th style="min-width:2px; font-size: 10px">2</th>
                <th style="min-width:2px; font-size: 10px">3</th>
                <th style="min-width:2px; font-size: 10px">4</th>
                <th style="min-width:2px; font-size: 10px">1</th>
                <th style="min-width:2px; font-size: 10px">2</th>
                <th style="min-width:2px; font-size: 10px">3</th>
                <th style="min-width:2px; font-size: 10px">4</th>
                <th style="min-width:2px; font-size: 10px">1</th>
                <th style="min-width:2px; font-size: 10px">2</th>
                <th style="min-width:2px; font-size: 10px">3</th>
                <th style="min-width:2px; font-size: 10px">4</th>
                <th style="min-width:2px; font-size: 10px">1</th>
                <th style="min-width:2px; font-size: 10px">2</th>
                <th style="min-width:2px; font-size: 10px">3</th>
                <th style="min-width:2px; font-size: 10px">4</th>
                <th style="min-width:2px; font-size: 10px">1</th>
                <th style="min-width:2px; font-size: 10px">2</th>
                <th style="min-width:2px; font-size: 10px">3</th>
                <th style="min-width:2px; font-size: 10px">4</th>
                <th style="min-width:2px; font-size: 10px">1</th>
                <th style="min-width:2px; font-size: 10px">2</th>
                <th style="min-width:2px; font-size: 10px">3</th>
                <th style="min-width:2px; font-size: 10px">4</th>
                <th style="min-width:2px; font-size: 10px">1</th>
                <th style="min-width:2px; font-size: 10px">2</th>
                <th style="min-width:2px; font-size: 10px">3</th>
                <th style="min-width:2px; font-size: 10px">4</th>
                <th style="min-width:2px; font-size: 10px">1</th>
                <th style="min-width:2px; font-size: 10px">2</th>
                <th style="min-width:2px; font-size: 10px">3</th>
                <th style="min-width:2px; font-size: 10px">4</th>
                <th style="min-width:2px; font-size: 10px">1</th>
                <th style="min-width:2px; font-size: 10px">2</th>
                <th style="min-width:2px; font-size: 10px">3</th>
                <th style="min-width:2px; font-size: 10px">4</th>
                <th style="min-width:2px; font-size: 10px">1</th>
                <th style="min-width:2px; font-size: 10px">2</th>
                <th style="min-width:2px; font-size: 10px">3</th>
                <th style="min-width:2px; font-size: 10px">4</th>
                <th style="min-width:2px; font-size: 10px">1</th>
                <th style="min-width:2px; font-size: 10px">2</th>
                <th style="min-width:2px; font-size: 10px">3</th>
                <th style="min-width:2px; font-size: 10px">4</th>

              </tr>
            </thead>
            <tbody id="tbodyid">

              <?php
                $x=1;
                foreach ($schedule as $key) {
                  ?>
                    <tr>
                        <td style="min-width:2px; font-size: 11px"><?php echo $x++ ?></td>
                        <td style="min-width:2px; font-size: 11px"><?php echo $key->uraian_keg?></td>
                        <?php

                          $bulan = array(
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
                          foreach ($bulan as $key ) {
                            $arrblnke= array();

                            $isi = str_split($key);
                              foreach ($isi as $dataisi) {
                              $arrblnke[$dataisi]=$dataisi;
                            }
                            for($i=0;$i<4;$i++){
                                if(array_key_exists($i+1, $arrblnke))
                                    echo "<td class='enable highlighted' style='min-width:2px; font-size: 10px'><p hidden=''></p></td>";
                                else
                                  echo "<td class='enable' style='min-width:2px; font-size: 10px'><p hidden=''></p></td>";
                            }
                          }

                          // $jan =str_split($key->jan);
                          // $arrbln=array();

                          // var_dump($arrjan);exit;
                          //     for($i=0;$i<4;$i++){

                          //   echo "<td class='enable 7 highlighted' style='min-width:2px; font-size: 10px'><p hidden=''></p></td>";


                        ?>
                    </tr>
                  <?php
                }
              ?>
            </tbody>
          </table>
        </div>

      <div class="box-footer clearfix">

      </div>
    </div>

  </div>









</div>
<!-- /.box -->
</div>
