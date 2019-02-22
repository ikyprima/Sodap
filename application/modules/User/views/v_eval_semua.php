<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/alertify.min.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/themes/default.min.css') ?>"/>
<script src="<?php echo base_url('assets/alertify/alertify.min.js') ?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/mediajs/jquery.media.js') ?>"></script>


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
             <p id="nmopd" hidden><?php echo $nmopd ?></p>
             <p id="thn" hidden><?php echo $tahun ?></p>
             <p id="peran" hidden><?php echo $peran?></p>
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



      </div>
      <br>
<!-- Default box -->

<div class="box box-primary">
  <div class="box-header with-border">
    <i class="fa fa-text-width"></i>
    <h3 class="box-title">Evaluasi Semua Realisasi Kegiatan</h3>
  </div>
  <div class="box-body">
    <?php
    if(empty($data[0])){
        echo '<div class="callout callout-danger">
                <h4><i class="icon fa fa-ban"></i> Maaf !!! Kegiatan Tidak Ada.</h4>
                <p>Surat Keputusan (SK) Kegiatan Anda Tidak Ada</p>
                <p>Silahkan Hubungi Kasubag Umum Kepegawain Anda Kembali</p>
                <p>Terimakasih :)</p>
              </div>';
      }else{ ?>
    <div class="row">
        <div class="table-responsive">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <p class="text-left text-muted">* Perhitungan dari pagu OPD </p>

        <table class="table table-bordered " style="font-size: 12px; '.$style.'">
          <thead >
            <tr class="bg-gray-active color-palette">
              <th rowspan="2" style="vertical-align : middle;text-align:center; ">PAGU TAHUN <?php echo $tahun ?></th>
              <th colspan="3" style="vertical-align : middle;text-align:center; " >REALISASI s/d BULAN SEKARANG</th>
              <th colspan="3" style="vertical-align : middle;text-align:center; " >REALISASI BULAN SEKARANG</th>

            </tr>
            <tr class="bg-gray-active color-palette" >
              <th style="vertical-align : middle;text-align:center; " >ALIRAN KAS</th>
              <th style="vertical-align : middle;text-align:center; " >REALISASI KEUANGAN</th>
              <th style="vertical-align : middle;text-align:center; " >PERSENTASE</th>
              <th style="vertical-align : middle;text-align:center; " >ALIRAN KAS</th>
              <th style="vertical-align : middle;text-align:center; " >REALISASI KEUANGAN</th>
              <th style="vertical-align : middle;text-align:center; " >PERSENTASE</th>

            </tr>
            <tr class="bg-gray-active color-palette">
              <th style="vertical-align : middle;text-align:center; ">1</th>
              <th style="vertical-align : middle;text-align:center; width: 14%" >2</th>
              <th style="vertical-align : middle;text-align:center; width: 14%" >3</th>
              <th style="vertical-align : middle;text-align:center; width: 14%" >4 = (3 / 2) x 100</th>
              <th style="vertical-align : middle;text-align:center; width: 14%" >5</th>
              <th style="vertical-align : middle;text-align:center; width: 14%" >6</th>
              <th style="vertical-align : middle;text-align:center; width: 14%" >7 = (6 / 5) x 100</th>
            </tr>
            <tr class="bg-blue allSides scaled">
              <th  style="vertical-align : middle;text-align:center;margin"><?php echo $this->template->rupiah($pagu[0]['tahun'])?></th>
              <th style="vertical-align : middle;text-align:center;" ><?php echo $this->template->rupiah($pagu[0]['blnsdskr'])?></th>
              <th style="vertical-align : middle;text-align:center;" ><?php echo $this->template->rupiah($realsd)?></th>
              <th style="vertical-align : middle;text-align:center;" ><?php echo $prsnrealsd.' %'?></th>
              <th style="vertical-align : middle;text-align:center;" ><?php echo $this->template->rupiah($pagu[0]['blnskr'])?></th>
              <th style="vertical-align : middle;text-align:center;" ><?php echo $this->template->rupiah($realbulnskr)?></th>
              <th style="vertical-align : middle;text-align:center;" ><?php echo $prsnrealskr.' %'?></th>
            </tr>

          </thead>
        </table>
      </div>
      </div>

    </div>

     <hr>
   <?php
   echo '<div id="menu">';
   echo '<div class="panel list-group">';

     foreach ($data as $i => $val) {


         if ($i==$bulan-1){
             //$style = 'margin-left:0.4em;';
             $style = 'margin-left:0em;';
             echo '<a href="javascript:void(0)" class="list-group-item active allSides scaled" data-toggle="collapse" data-target="#'.$i.'" data-parent="#menu,#menu'.$i.'" > <i class="fa fa-chevron-right"></i> <b>'.$val['nmbln'].'</b> </a>';
         }else{
             $style = '';
             echo '<a href="javascript:void(0)" class="list-group-item" data-toggle="collapse" data-target="#'.$i.'" data-parent="#menu,#menu'.$i.'"> <i class="fa fa-chevron-right"></i> <b>'.$val['nmbln'].'</b> </a>';
         }
         echo '<div id="'.$i.'" class="sublinks collapse" >';
         echo '<div id="menu'.$i.'">';
         echo '<div class="panel list-group">';
         foreach ($val['ppk'] as $x => $nmppk) {
           if ($x % 2 == 0){
             $bg='bg-white';
           }else{
             $bg='bg-white';
           }

           echo '<a href="javascript:void(0)" class="list-group-item medium '.$bg.'" data-toggle="collapse" data-target="#'.$i.$nmppk['nipppk'].'" data-parent="#menu'.$i.'" ><i class="fa fa-dot-circle-o" style="margin-left:2em ;"></i> <b style="margin-left:1em ;">'.$nmppk['nmppk'].'</b></a>';
           echo '<div id="'.$i.$nmppk['nipppk'].'" class="sublinks collapse" >';
           //echo $nmppk['rincian'][0]['realsdppk'];
           ?>
           <div class="row">
               <div class="table-responsive">
             <div class="col-md-12 col-sm-12 col-xs-12">

               <table class="table table-bordered " style="font-size: 12px; '.$style.'">
                 <thead >
                   <tr class="bg-gray-active color-palette">
                     <th rowspan="2" style="vertical-align : middle;text-align:center; ">PAGU TAHUN <span style=" text-transform: uppercase;"><?php echo $tahun ?></span></th>
                     <th colspan="3" style="vertical-align : middle;text-align:center; " >REALISASI s/d BULAN <span style=" text-transform: uppercase;"><?php echo $val['nmbln']?></span></th>
                     <th colspan="3" style="vertical-align : middle;text-align:center; " >REALISASI BULAN <span style=" text-transform: uppercase;"><?php echo $val['nmbln']?></span></th>

                   </tr>
                   <tr class="bg-gray-active color-palette" >
                     <th style="vertical-align : middle;text-align:center; " >ALIRAN KAS</th>
                     <th style="vertical-align : middle;text-align:center; " >REALISASI KEUANGAN</th>
                     <th style="vertical-align : middle;text-align:center; " >PERSENTASE</th>
                     <th style="vertical-align : middle;text-align:center; " >ALIRAN KAS</th>
                     <th style="vertical-align : middle;text-align:center; " >REALISASI KEUANGAN</th>
                     <th style="vertical-align : middle;text-align:center; " >PERSENTASE</th>

                   </tr>
                   <tr class="bg-gray-active color-palette">
                     <th style="vertical-align : middle;text-align:center; ">1</th>
                     <th style="vertical-align : middle;text-align:center; width: 14%" >2</th>
                     <th style="vertical-align : middle;text-align:center; width: 14%" >3</th>
                     <th style="vertical-align : middle;text-align:center; width: 14%" >4 = (3 / 2) x 100</th>
                     <th style="vertical-align : middle;text-align:center; width: 14%" >5</th>
                     <th style="vertical-align : middle;text-align:center; width: 14%" >6</th>
                     <th style="vertical-align : middle;text-align:center; width: 14%" >7 = (6 / 5) x 100</th>
                   </tr>
                    <!-- $nmppk['rincian'][0]['realsdppk'] -->
                   <tr class="bg-green allSides scaled">
                     <th  style="vertical-align : middle;text-align:center;margin"><?php echo $this->template->rupiah($nmppk['rincian'][0]['paguppk'][0]['tahun'])?></th>
                     <th style="vertical-align : middle;text-align:center;" ><?php echo $this->template->rupiah($nmppk['rincian'][0]['paguppk'][0]['blnsdskr'])?></th>
                     <th style="vertical-align : middle;text-align:center;" ><?php echo $this->template->rupiah($nmppk['rincian'][0]['realsdppk'])?></th>
                     <th style="vertical-align : middle;text-align:center;" ><?php echo $nmppk['rincian'][0]['prsnrealsdppk'].' %'?></th>
                     <th style="vertical-align : middle;text-align:center;" ><?php echo $this->template->rupiah($nmppk['rincian'][0]['paguppk'][0]['blnskr'])?></th>
                     <th style="vertical-align : middle;text-align:center;" ><?php echo $this->template->rupiah($nmppk['rincian'][0]['realbulnskrppk'])?></th>
                     <th style="vertical-align : middle;text-align:center;" ><?php echo $nmppk['rincian'][0]['prsnrealskrppk'].' %'?></th>
                   </tr>

                 </thead>
               </table>
               <br>
               <br>
               <hr>
               <p><code>*detail semua kegiatan</code></p>
               <?php
               echo '<table class="table table-bordered table-striped table-condensed " style="font-size: 12px; '.$style.'">
                         <thead class="bg-gray-active color-palette">
                           <tr>
                             <th rowspan="3" style="vertical-align : middle;text-align:center; width: 2%">No</th>
                             <th rowspan="3" style="vertical-align : middle;text-align:center; ">Kegiatan</th>
                             <th rowspan="3" style="vertical-align : middle;text-align:center; width: 18%">PPTK</th>
                             <th colspan="4" style="vertical-align : middle;text-align:center;">Keuangan s/d Bulan '.$val['nmbln'].'</th>
                             <th colspan="2" style="vertical-align : middle;text-align:center;">Fisik s/d Bulan '.$val['nmbln'].'</th>
                             <th rowspan="3" style="vertical-align : middle;text-align:center; width: 8%;">Status</th>
                             <th rowspan="3" style="vertical-align : middle;text-align:center;width: 7%;">Rincian Realisasi Bulan '.$val['nmbln'].'</th>
                           </tr>
                           <tr>
                             <th colspan="2" style="vertical-align : middle;text-align:center;" >Target</th>
                             <th colspan="2" style="vertical-align : middle;text-align:center;" >Realisasi</th>
                             <th  style="vertical-align : middle;text-align:center; width: 5%;" >Target</th>
                             <th  style="vertical-align : middle;text-align:center; width: 5%;" >Realisasi</th>
                           </tr>
                           <tr>
                             <th style="vertical-align : middle;text-align:center; width: 4%;" >%</th>
                             <th style="vertical-align : middle;text-align:center; width: 9%;" >Rp</th>
                             <th style="vertical-align : middle;text-align:center; width: 4%;" >%</th>
                             <th style="vertical-align : middle;text-align:center; width: 9%;" >Rp</th>
                             <th style="vertical-align : middle;text-align:center; width: 4%;" >%</th>
                             <th style="vertical-align : middle;text-align:center; width: 4%;" >%</th>
                           </tr>
                           </thead>
                           <tbody>';
                           foreach ($nmppk['rincian'][0]['datappk'][0]['det'] as $x => $value) {

                             if($value['prstarget']=='0.00'){
                               $capaian ='<span class="badge bg-gray disabled color-palette pull-right">&nbsp&nbsp&nbsp&nbspBelum Ada&nbsp&nbsp&nbsp&nbsp</span>';
                               $btndis='bg-gray disabled color-palette';
                             }elseif($value['cpaian'] < 80){
                               $capaian ='<span class="badge bg-red pull-right">Belum Tercapai</span>';
                               $btndis='btn-detail bg-blue ';
                             }else{
                               $capaian ='<span class="badge bg-blue pull-right">Sudah Tercapai</span>';
                               $btndis='btn-detail bg-blue ';
                             }
                             $x++;
                             //1=KADIS
                             //6=SEKRETARIS
                             if($peran==1){
                               if($value['stat_terskn']==2 || $value['stat_terskn']==3 ){
                                 $alert='<span class="badge bg-blue">'.$x.'</span>';

                               }else{
                                 $alert='<span class="badge bg-red">'.$x.'</span>';
                               }
                             }elseif($peran==6){
                               if($value['stat_terskn']==1 || $value['stat_terskn']==2 || $value['stat_terskn']==3 ){
                                 $alert='<span class="badge bg-blue">'.$x.'</span>';

                               }else{
                                 $alert='<span class="badge bg-red">'.$x.'</span>';
                               }
                             }else {
                                $alert='<span class="badge bg-yellow">'.$x.'</span>';
                             }

                             echo '<tr>
                                     <td style="vertical-align : middle;">'.$alert.'</td>
                                     <td style="vertical-align : middle;">'.$value['nmkeg'].'</td>
                                     <td class="nippptk" style="display:none;">'.$value['nippptk'].'</td>
                                     <td style="vertical-align : middle;">'.$value['pptk'].'</td>
                                     <td style="vertical-align : middle;text-align:center" class="danger">'.$value['prstarget'].'</td>
                                     <td style="vertical-align : middle;text-align:right" class="danger" >'.$value['nltskr'].'</td>
                                     <td style="vertical-align : middle;text-align:center" class="info">'.$value['prsreal'].'</td>
                                     <td style="vertical-align : middle;text-align:right" class="info">'.$value['realnl'].'</td>
                                     <td style="vertical-align : middle;text-align:center" class="danger">'.$value['prstarfis'].'</td>
                                     <td style="vertical-align : middle;text-align:center" class="info">'.$value['prsrealfis'].'</td>
                                     <td style="vertical-align : middle; text-align:center">'.$capaian.'</td>
                                     <td style="vertical-align : middle; text-align:center"><button class="btn margin '.$btndis.'" data-idbln='.$val['kdbln'].' data-nmbln='.$val['nmbln'].' data-kdkeg='.$value['kdkeg'].'>Detail<div class="ripple-container"></div></button></td>

                                   </tr>';

                           }
                      echo '</tbody>
                            </table>';
                ?>
                <hr>
                <br>
                <br>
             </div>
             </div>

           </div>

           <?php
                // foreach ($nmppk['rincian'] as $y => $rincian) {
                //
                //
                //
                // }
           echo '</div>';
         }
         echo '</div>
               </div>';
         echo '</div>';

     }
     echo '</div>
           </div>';

 } ?>

  </div>


  <div class="box-footer">

  </div>
<!-- /.box-footer-->

</div>
<!-- /.box -->


</section>
<script type="text/javascript">
  $(document).ready(function() {
    ajaxtoken();
    $(".btn-detail").click(function() {
        ajaxtoken();
        var token = localStorage.getItem("token");
        var row = $(this).closest("tr");    //baris tabel
        var nippptk = row.find(".nippptk").text(); // cari value td berdasarkan class <td>
        var thn     = $('#thn').html();
        var peran   = $('#peran').html();
        var bln     = $(this).data("idbln");
        var nmbln   = $(this).data("nmbln");
        var idopd   = $('#kdunit').html();
        var nmopd   = $('#nmopd').html();
        var kdkeg   = $(this).data("kdkeg");

        var html = '';



       Pace.restart ();
       Pace.track (function (){
         var ajaxTime= new Date().getTime();
         $.ajax ({
           url: base_url+"User/json_detail_realisasi/",
           type: "POST",
           data: {
             token   : token,
             thn : thn,
             bln : bln,
             idopd : idopd,
             nmopd : nmopd,
             kdkeg : kdkeg,
             nippptk : nippptk
           },
           dataType: "JSON",
           complete: function(data){
             ajaxtoken();
             var jsonData = JSON.parse(data.responseText);
             var tahun = jsonData.data[0].tahun;
             var bulan = jsonData.data[0].bulan;
             var idtab = jsonData.data[0].idtab;
             var nmkeg = jsonData.data[0].nmkeg;
             var nmpgrm = jsonData.data[0].nmpgrm;
             var nlkeg = jsonData.data[0].nlkeg;
             var bbtkeg = jsonData.data[0].bbtkeg;
             var pptk = jsonData.data[0].pptk;
             var ppk = jsonData.data[0].ppk;
             var nlblnskr = jsonData.data[0].nlblnskr;
             var rlkeu = jsonData.data[0].rlkeu;
             var prrlkeu = jsonData.data[0].prrlkeu;
             var rlfisik = jsonData.data[0].rlfisik;
             var bbtrlfisik = jsonData.data[0].bbtrlfisik;
             var mslh = '';
             if(jsonData.data[0].mslh===null){
               mslh='';
             }else{
               mslh = jsonData.data[0].mslh;
             }
              html +=   '<div class="row">  '  +
              '               <div class="col-md-6">  '  +
              '                 <div class="row">  '  +
              '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">Program</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
              '                     <h4 class="text-center text-muted">:</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">'+nmpgrm+'</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
              '                   </div>  '  +
              '                 </div>  '  +
              '                 <div class="row">  '  +
              '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">Kegiatan</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
              '                     <h4 class="text-center text-muted">:</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">'+nmkeg+'</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
              '                   </div>  '  +
              '                 </div>  '  +
              '                 <div class="row">  '  +
              '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">Pagu Dana Kegiatan</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
              '                     <h4 class="text-center text-muted">:</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">'+nlkeg+'</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
              '                   </div>  '  +
              '                 </div>  '  +
              '                 <div class="row">  '  +
              '     '  +
              '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">Bobot Kegiatan</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
              '                     <h4 class="text-center text-muted">:</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">'+bbtkeg+' %</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
              '                   </div>  '  +
              '                 </div>  '  +
              '                 <div class="row">  '  +
              '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">KPA</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
              '                     <h4 class="text-center text-muted">:</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">'+ppk+'</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
              '                   </div>  '  +
              '                 </div>  '  +
              '                 <div class="row">  '  +
              '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">PPTK</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
              '                     <h4 class="text-center text-muted">:</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">'+pptk+'</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
              '                   </div>  '  +
              '                 </div>  '  +

              '               </div>  '  +
              '               <!-- /.col -->  '  +
              '               <div class="col-md-6">  '  +
              '                 <div class="row">  '  +
              '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">Pagu Bln Sekarang</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
              '                     <h4 class="text-center text-muted">:</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">'+nlblnskr+'</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
              '                   </div>  '  +
              '                 </div>  '  +
              '                 <div class="row">  '  +
              '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">Realisasi Keuangan</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
              '                     <h4 class="text-center text-muted">:</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">'+rlkeu+'</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
              '                   </div>  '  +
              '                 </div>  '  +
              '                 <div class="row">  '  +
              '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">Persentase Realisasi Keuangan</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
              '                     <h4 class="text-center text-muted">:</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">'+prrlkeu+' %</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
              '                   </div>  '  +
              '                 </div>  '  +
              '                 <div class="row">  '  +
              '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">Realisasi Fisik</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
              '                     <h4 class="text-center text-muted">:</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">'+rlfisik+' %</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
              '                   </div>  '  +
              '                 </div>  '  +
              '                 <div class="row">  '  +
              '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">Bobot Realisasi</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
              '                     <h4 class="text-center text-muted">:</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">'+bbtrlfisik+' %</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
              '                   </div>  '  +
              '                 </div>  '  +
              '                 <div class="row">  '  +
              '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">Permasalahan</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
              '                     <h4 class="text-center text-muted">:</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
              '                     <h4 class="text-left text-muted">'+mslh+'</h4>  '  +
              '                   </div>  '  +
              '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
              '                   </div>  '  +
              '                 </div>  '  +
              '     '  +
              '               </div>  '  +
              '               <!-- /.col -->  '  +
              '             </div>  '  +
              '    ' ;

              html +='<hr>';
              html +='<br>';
              html +='<table class="table table-bordered table-condensed " style="font-size: 11px">';
              html +=  '     <thead>  '  +
              '       <tr>  '  +
              '         <th rowspan="3" style="vertical-align : middle;text-align:center; width: 100px">Kode Rekening</th>  '  +
              '         <th rowspan="3" style="vertical-align : middle;text-align:center; width: 160px">Uraian</th>  '  +
              '         <th colspan="4"  style="vertical-align : middle;text-align:center;">ANGGARAN TAHUN SEKARANG</th>  '  +
              '          <th rowspan="3" style="vertical-align : middle;text-align:center; width: 130px">KAS BULAN SEKARANG</th>  '  +

              '         <th colspan="4" style="vertical-align : middle;text-align:center;">REALISASI</th>  '  +
              '     '  +
              '       </tr>  '  +
              '       <tr>  '  +
              '         <th colspan="3" style="vertical-align : middle;text-align:center;">Rincian Perhitungan</th>  '  +
              '         <th rowspan="2" style="vertical-align : middle;text-align:center; width: 120px">Jumlah Pagu / Th</th>  '  +
              '         <th rowspan="2" style="vertical-align : middle;text-align:center; width: 80px">SUMBER DANA</th>  '  +
              '         <th rowspan="2" style="vertical-align : middle;text-align:center;  width: 120px">Volume</th>  '  +
              '         <th rowspan="2" style="vertical-align : middle;text-align:center; width: 130px">Harga Satuan</th>  '  +
              '         <th rowspan="2" style="vertical-align : middle;text-align:center; width: 130px">Jumlah</th>  '  +
              '       </tr>  '  +
              '       <tr>  '  +
              '         <th style="vertical-align : middle;text-align:center; width: 70px">Volume</th>  '  +
              '         <th style="vertical-align : middle;text-align:center; width: 70px">Satuan</th>  '  +
              '         <th style="vertical-align : middle;text-align:center; width: 120px">Harga Satuan</th>  '  +
              '       </tr>  '  +
              '     '  +
              '    </thead>  ' ;
              html +='<tbody>';
                    for (x in jsonData.data[0].det) {
                        var rek = jsonData.data[0].det[x].kdrek;
                        var nmrek = jsonData.data[0].det[x].nmrek;
                        var totjum = jsonData.data[0].det[x].totjum;
                        var totjumreal = jsonData.data[0].det[x].totjumreal;
                        var kasbulan = jsonData.data[0].det[x].mskkas; //kas bulan sekarang

                      html +='<tr class="active">';
                      html+='<td><b>'+rek+'</b></td> '+
                            '<td><b>'+nmrek+'</b></td>'+
                            '<td colspan="9"></td>';
                      html +='</tr>';
                      for (y in jsonData.data[0].det[x].subdet) {

                        var uraian = jsonData.data[0].det[x].subdet[y].uraian;
                        var type = jsonData.data[0].det[x].subdet[y].type;
                        var vol = jsonData.data[0].det[x].subdet[y].vol;
                        var satuan = jsonData.data[0].det[x].subdet[y].satuan;
                        var hargasatuan = jsonData.data[0].det[x].subdet[y].mskharga;
                        var mskjumhar = jsonData.data[0].det[x].subdet[y].mskjumhar;
                        var smbrdana = jsonData.data[0].det[x].subdet[y].rlsbrdana;
                        var rlvol = jsonData.data[0].det[x].subdet[y].rlvol;
                        var mskrlharst = jsonData.data[0].det[x].subdet[y].mskrlharst;
                        var mskrljumhar = jsonData.data[0].det[x].subdet[y].mskrljumhar;
                        var rlnlkontrak = jsonData.data[0].det[x].subdet[y].rlnlkontrak;
                        var realbmodal = jsonData.data[0].det[x].subdet[y].realbmodal;
                        var vrek = rek.substr(0, 6);
                        if(smbrdana==null){
                          var fsmbrdana = '<span class="blink_me text-danger"><b>Belum</b></span>';
                          var frlvol = '<span class="blink_me text-danger"><b>Realisasi</b></span>';
                        }else{
                          var fsmbrdana = smbrdana;
                          var frlvol = rlvol;
                        }
                        if(vrek==='5.2.3.'){
                          if (type =='H'){
                            html +='<tr class="active">';
                            html+='<td></td> '+
                                  '<td>'+uraian+'</td>'+
                                  '<td colspan="9"></td>';
                            html +='</tr>';

                          }else{

                            html +='<tr>';
                            html+='<td></td> '+
                                  '<td ><p style="margin-left:1em;">'+uraian+'</p></td>'+
                                  '<td style="vertical-align : middle;text-align:center;">'+vol+'</td>'+
                                  '<td style="vertical-align : middle;text-align:center;">'+satuan+'</td>'+
                                  '<td style="vertical-align : middle;text-align:right;">'+hargasatuan+'</td>'+
                                  '<td style="vertical-align : middle;text-align:right;">'+mskjumhar+'</td>'+
                                  '<td class="active"></td>'+
                                  '<td class="info" colspan="2"></td>'+

                                  ' <td class="info" style="vertical-align : middle;text-align:right;"><u><b><i>Nilai Kontrak</i></b></u><br>'+rlnlkontrak+'</td>'+
                                  ' <td class="info" style="vertical-align : middle;text-align:right;"><u><b><i>Realisasi</i></b></u><br>'+realbmodal+'</td>';
                            html +='</tr>';
                          }
                        }else{
                          if (type =='H'){
                            html +='<tr class="active">';
                            html+='<td></td> '+
                                  '<td>'+uraian+'</td>'+
                                  '<td colspan="9"></td>';
                            html +='</tr>';

                          }else{

                            html +='<tr>';
                            html+='<td></td> '+
                                  '<td ><p style="margin-left:1em;">'+uraian+'</p></td>'+
                                  '<td style="vertical-align : middle;text-align:center;">'+vol+'</td>'+
                                  '<td style="vertical-align : middle;text-align:center;">'+satuan+'</td>'+
                                  '<td style="vertical-align : middle;text-align:right;">'+hargasatuan+'</td>'+
                                  '<td style="vertical-align : middle;text-align:right;">'+mskjumhar+'</td>'+
                                  '<td class="active"></td>'+
                                  '<td style="vertical-align : middle;text-align:center;">'+fsmbrdana+'</td>'+
                                  '<td style="vertical-align : middle;text-align:center;">'+frlvol+'</td>'+
                                  '<td style="vertical-align : middle;text-align:right;">'+mskrlharst+'</td>'+
                                  '<td style="vertical-align : middle;text-align:right;">'+mskrljumhar+'</td>';
                            html +='</tr>';
                          }
                        }





                      }

                      html +='<tr>'+
                        '<td colspan="5" style="vertical-align : middle;text-align:right"><b>Total Jumlah</b></td>'+
                        '<td style="vertical-align : middle;text-align:right"><b>'+totjum+'</b></td>'+
                        '<td class="active" style="vertical-align : middle;text-align:right"><b>'+kasbulan+'</b></td>'+
                        '<td colspan="3" style="vertical-align : middle;text-align:right"><b>Total Jumlah</b></td>'+
                        '<td style="vertical-align : middle;text-align:right"><b>'+totjumreal+'</b></td>'+
                        '</tr>';

                    }
              html +='</tbody>';
              html +='</table>'
                      alertify.confirm().destroy();
                      alertify.confirm()
                      .setHeader('Rincian Realisasi Bulan '+nmbln)
                      .set({
                        'resizable':false,
                        'movable': false,
                        'autoReset': true,
                        'transition':'fade',
                        // 'title': ,
                        'labels': {
                          ok:'Konfirmasi', cancel:'Tutup'
                        },
                        'startMaximized':true,

                        onok: function(){
                          ajaxtoken();
                          var htmlmslh = '';
                          var token = localStorage.getItem("token");

                          $.ajax ({
                            url: base_url+"User/json_cek_detail_tab_realisasi_ppk/",
                            type: "POST",
                            data: {

                              token   : token,
                              idtab   : idtab,
                              thn     : tahun,
                              bln     : bulan

                            },
                            dataType: "JSON",
                            complete: function(data){
                              var jsonData2 = JSON.parse(data.responseText);
                              var status = jsonData2.data[0].status;
                              // var teruskan = jsonData2.data[0].teruskan;
                              var intteruskan = jsonData2.data[0].intteruskan;
                              if(peran == 6){
                                //6 = Sekretaris
                                if(status==false){
                                  var notification = alertify.notify('Belum Ada Realisasi', 'error', 2, function(){
                                    //nanti pakai javascript
                                    ajaxtoken();
                                  });

                                }else if (intteruskan == 3) {
                                  var notification = alertify.notify('Sudah di Evaluasi Atasan', 'error', 2, function(){
                                    //nanti pakai javascript
                                    ajaxtoken();
                                  });
                                }else if(intteruskan==2) {
                                  var notification = alertify.notify('Realisasi Sudah Di Teruskan', 'error', 2, function(){
                                    //nanti pakai javascript
                                    ajaxtoken();
                                  });
                                }else if(intteruskan == 1){
                                  ajaxtoken();
                                    htmlmslh +=   '<div class="box box-success box-solid">  '  +
                                                   '     <div class="box-header with-border ">  '  +
                                                   '       <i class="fa fa-check-square-o"></i>  '  +
                                                   '       <h3 class="box-title">Evaluasi Realisasi</h3>  '  +
                                                   '     </div>  '  +
                                                   '     <div class="box-body">  '  +
                                                   '  <div class="form-group">  '  +
                                                   '  <label>Permasalahan </label>  <br> '  +
                                                   '  <textarea class="textarea" id="mslh" name="mslh"  placeholder="Silahkan di Isi Jika Ada Masalah" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">'+mslh+'</textarea>  '  +
                                                   '  <p class="text-muted">*Silahkan di tambahkan jika perlu</p></label>'+
                                                   '  </div>'+
                                                   '     </div>  '  +
                                                   '     <div class="box-footer">  '  +
                                                   '   <div class="row">  '  +
                                                    '         <div class="col-md-3 col-sm-6 col-xs-12">  '  +
                                                    '         </div>  '  +
                                                    '         <div class="col-md-3 col-sm-6 col-xs-12">  '  +
                                                    '           </div>  '  +
                                                    '           <div class="col-md-3 col-sm-6 col-xs-12">   '  +
                                                    '           </div>  '  +
                                                    '           <div class="col-md-3 col-sm-6 col-xs-12">  '  +
                                                    '             <a class="btn btn-block btn-social btn-success btn-flat" id="btn-konfirmasi">  '  +
                                                    '               <i class="fa fa-send"></i> TERUSKAN  '  +
                                                    '             </a>  '  +
                                                    '           </div>  '  +
                                                    '        </div>  '+
                                                   '     </div>  '  +
                                                   '  </div>  ' ;

                                    alertify.alert().destroy();
                                    alertify.alert()
                                    .setHeader('Konfirmasi dan Teruskan Realisasi Bulan '+nmbln)
                                    .set({
                                        'resizable':true,
                                        'label':'Konfirmasi',
                                        'autoReset': true,
                                        'transition':'fade',
                                        // 'closableByDimmer': false,
                                        'frameless':true,

                                         onok: function(){
                                           var notification = alertify.notify('Belum Konfirmasi !!', 'error', 2, function(){
                                             //nanti pakai javascript
                                             ajaxtoken();
                                           });
                                        }
                                    })
                                    .resizeTo('60%','76%')
                                    .setContent(htmlmslh)
                                    .show();

                                    $('.textarea').wysihtml5();
                                    $("#btn-konfirmasi").click(function() {


                                       var vmslh = $('#mslh').val() ;
                                       ajaxtoken();
                                       var token = localStorage.getItem("token");
                                       $.ajax ({
                                       url: base_url+"User/simpan_teruskan_ppk/",
                                       type: "POST",
                                       data: {
                                         token   : token,
                                         idtab   : idtab,
                                         thn     : tahun,
                                         bln     : bulan,
                                         mslh    : vmslh,
                                         stat    : 2

                                       },
                                       dataType: "JSON",
                                       complete: function(data){
                                         var jsonDataupdate = JSON.parse(data.responseText);
                                         var statusupdate = jsonDataupdate.data[0].status;
                                           alertify.alert().destroy();
                                         if(statusupdate==false){
                                           var notification = alertify.notify('Terjadi Kesalahan, Reload Halaman', 'error', 3, function(){
                                             //nanti pakai javascript
                                             ajaxtoken();

                                           });
                                         }else{
                                           var notification = alertify.notify('Berhasil di teruskan', 'success', 2, function(){
                                             //nanti pakai javascript
                                             ajaxtoken();

                                           });
                                         }

                                       },
                                       error: function(jqXHR, textStatus, errorThrown){
                                         var notification = alertify.notify('Terjadi Kesalahan, Reload Halaman', 'error', 3, function(){
                                           //nanti pakai javascript
                                           ajaxtoken();
                                             alertify.alert().destroy();
                                         });
                                         }
                                      });

                                    });

                                }else if(intteruskan == 0){
                                  var notification = alertify.notify('Belum di Evaluasi KPA', 'error', 3, function(){
                                    //nanti pakai javascript
                                    ajaxtoken();

                                  });
                                }else{
                                  var notification = alertify.notify('Ups terjadi Kesalahan', 'error', 2, function(){
                                    //nanti pakai javascript
                                    ajaxtoken();
                                  });

                                }
                              }else{
                                //1 Kadis
                                // cek peran di log, jika ragu
                                if(status==false){
                                  var notification = alertify.notify('Belum Ada Realisasi', 'error', 2, function(){
                                    //nanti pakai javascript
                                    ajaxtoken();
                                  });

                                }else if (intteruskan == 3) {
                                  var notification = alertify.notify('Realisasi Sudah Di Teruskan', 'success', 2, function(){
                                    //nanti pakai javascript
                                    ajaxtoken();
                                  });
                                }else if(intteruskan==2) {
                                  ajaxtoken();
                                  htmlmslh +=   '<div class="box box-success box-solid">  '  +
                                                   '     <div class="box-header with-border ">  '  +
                                                   '       <i class="fa fa-check-square-o"></i>  '  +
                                                   '       <h3 class="box-title">Evaluasi Realisasi</h3>  '  +
                                                   '     </div>  '  +
                                                   '     <div class="box-body">  '  +
                                                   '  <div class="form-group">  '  +
                                                   '  <label>Permasalahan </label>  <br> '  +
                                                   '  <textarea class="textarea" id="mslh" name="mslh"  placeholder="Silahkan di Isi Jika Ada Masalah" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">'+mslh+'</textarea>  '  +
                                                   '  <p class="text-muted">*Silahkan di tambahkan jika perlu</p></label>'+
                                                   '  </div>'+
                                                   '     </div>  '  +
                                                   '     <div class="box-footer">  '  +
                                                   '   <div class="row">  '  +
                                                    '         <div class="col-md-3 col-sm-6 col-xs-12">  '  +
                                                    '         </div>  '  +
                                                    '         <div class="col-md-3 col-sm-6 col-xs-12">  '  +
                                                    '           </div>  '  +
                                                    '           <div class="col-md-3 col-sm-6 col-xs-12">   '  +
                                                    '           </div>  '  +
                                                    '           <div class="col-md-3 col-sm-6 col-xs-12">  '  +
                                                    '             <a class="btn btn-block btn-social btn-success btn-flat" id="btn-konfirmasi">  '  +
                                                    '               <i class="fa fa-send"></i> TERUSKAN  '  +
                                                    '             </a>  '  +
                                                    '           </div>  '  +
                                                    '        </div>  '+
                                                   '     </div>  '  +
                                                   '  </div>  ' ;

                                    alertify.alert().destroy();
                                    alertify.alert()
                                    .setHeader('Konfirmasi dan Teruskan Realisasi Bulan '+nmbln)
                                    .set({
                                        'resizable':true,
                                        'label':'Konfirmasi',
                                        'autoReset': true,
                                        'transition':'fade',
                                        // 'closableByDimmer': false,
                                        'frameless':true,

                                         onok: function(){
                                           var notification = alertify.notify('Belum Konfirmasi !!', 'error', 2, function(){
                                             //nanti pakai javascript
                                             ajaxtoken();
                                           });
                                        }
                                    })
                                    .resizeTo('60%','76%')
                                    .setContent(htmlmslh)
                                    .show();

                                    $('.textarea').wysihtml5();
                                    $("#btn-konfirmasi").click(function() {


                                       var vmslh = $('#mslh').val() ;
                                       ajaxtoken();
                                       var token = localStorage.getItem("token");
                                       $.ajax ({
                                       url: base_url+"User/simpan_teruskan_ppk/",
                                       type: "POST",
                                       data: {
                                         token   : token,
                                         idtab   : idtab,
                                         thn     : tahun,
                                         bln     : bulan,
                                         mslh    : vmslh,
                                         stat    : 3

                                       },
                                       dataType: "JSON",
                                       complete: function(data){
                                         var jsonDataupdate = JSON.parse(data.responseText);
                                         var statusupdate = jsonDataupdate.data[0].status;
                                           alertify.alert().destroy();
                                         if(statusupdate==false){
                                           var notification = alertify.notify('Terjadi Kesalahan, Reload Halaman', 'error', 3, function(){
                                             //nanti pakai javascript
                                             ajaxtoken();

                                           });
                                         }else{
                                           var notification = alertify.notify('Berhasil di teruskan', 'success', 2, function(){
                                             //nanti pakai javascript
                                             ajaxtoken();

                                           });
                                         }

                                       },
                                       error: function(jqXHR, textStatus, errorThrown){
                                         var notification = alertify.notify('Terjadi Kesalahan, Reload Halaman', 'error', 3, function(){
                                           //nanti pakai javascript
                                           ajaxtoken();
                                             alertify.alert().destroy();
                                         });
                                         }
                                      });

                                    });
                                }else if(intteruskan == 1){


                                    var notification = alertify.notify('Belum di Evaluasi Sekretaris', 'error', 3, function(){
                                      //nanti pakai javascript
                                      ajaxtoken();

                                    });
                                }else if(intteruskan == 0){
                                  var notification = alertify.notify('Belum di Evaluasi KPA', 'error', 3, function(){
                                    //nanti pakai javascript
                                    ajaxtoken();

                                  });
                                }else{
                                  var notification = alertify.notify('Ups terjadi Kesalahan', 'error', 2, function(){
                                    //nanti pakai javascript
                                    ajaxtoken();
                                  });

                                }
                              }


                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                swal(
                                  'error',
                                  'Terjadi Kesalahan, Coba Lagi Nanti',
                                  'error'
                                )
                              }
                           });

                            return false;
                        },
                        onclose:function(){
                          // alertify.message('confirm was closed.')
                          ajaxtoken();
                        }
                      })
                      .setContent(html).show();
           },
           error: function(jqXHR, textStatus, errorThrown){
               swal(
                 'error',
                 'Terjadi Kesalahan, Coba Lagi Nanti',
                 'error'
               )
             }
          }).done(function () {
              var totalTime = new Date().getTime()-ajaxTime;
              // Here I want to get the how long it took to load some.php and use it further
              console.log(totalTime);
          });




       });
    });
  });
</script>
