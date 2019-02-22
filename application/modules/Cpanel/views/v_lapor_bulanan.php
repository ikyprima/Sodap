<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/alertify.min.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/themes/default.min.css') ?>"/>
<script src="<?php echo base_url('assets/alertify/alertify.min.js') ?>"></script>
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
    <i class="fa  fa-check-square-o"></i>
    <h3 class="box-title">Laporan Bulanan</h3>
  </div>
   <p id="thn" hidden><?php echo $tahun ?></p>
  <div class="box-body">
    <?php
    echo '<div id="menu">';
    echo '<div class="panel list-group">';
     foreach ($listbulan as $i => $valbln) {
       $kdbln = $i+1 ;
       if ($i==$bulan-1){
           //$style = 'margin-left:0.4em;';
           $style = 'margin-left:0em;';
           echo '<a href="javascript:void(0)" class="list-group-item active allSides scaled" data-toggle="collapse" data-target="#'.$i.'" data-parent="#menu" > <i class="fa fa-chevron-right"></i> <b>'.$valbln['nmbln'].'</b> </a>';
       }else{
           $style = '';
           echo '<a href="javascript:void(0)" class="list-group-item" data-toggle="collapse" data-target="#'.$i.'" data-parent="#menu"> <i class="fa fa-chevron-right"></i> <b>'.$valbln['nmbln'].'</b> </a>';
       }
       echo '<div id="'.$i.'" class="sublinks collapse" >';

       foreach ($valbln['opd'] as $x => $valopd) {

         if($valopd['angkas']==0 && $valopd['real']==0 && $valopd['stat']==0   ){
            $capaian ='<span class="badge bg-orange color-palette pull-right" style="margin-left:2em ;">&nbsp&nbsp&nbsp&nbspBelum Ada&nbsp&nbsp&nbsp&nbsp</span>';
         }elseif($valopd['angkas']==0 && $valopd['real']==0 && $valopd['stat']==1   ){
             $capaian ='<span class="badge bg-green color-palette pull-right" style="margin-left:2em ;">&nbspTidak Ada Kas&nbsp</span>';
          }elseif ($valopd['prsn'] < 80 ) {
            $capaian ='<span class="badge bg-red pull-right" style="margin-left:2em ;">Belum Tercapai</span>';
         }elseif ($valopd['prsn'] > 80 && $valopd['prsn'] <= 100) {
             $capaian ='<span class="badge bg-blue pull-right" style="margin-left:2em ;">Sudah Tercapai</span>';
         }

         if ($x % 2 == 0){
           $bg='bg-gray color-palette';
         }else{
           $bg='bg-white';
         }
         echo '<a href="javascript:void(0)" class="detail-laporan list-group-item medium '.$bg.'"  data-bln='.$kdbln.' data-idopd='.$valopd['idopd'].' data-finish='.$valopd['stfinish'].'><i class="fa fa-dot-circle-o" style="margin-left:2em ;"></i> <b style="margin-left:1em ;">'.$valopd['nmopd'].'</b>'.$capaian.'</a>';

       }

       echo '</div>';
     }
    echo '</div>';
    echo '</div>';
    ?>
  </div>

  <div class="box-footer">

  </div>

</div>

</section>
<script type="text/javascript">
  $(document).ready(function () {
          ajaxtoken();
        $('a.detail-laporan').on("click",function(){
          //var idprog  = $(this).attr('prog');
          ajaxtoken();
          var token = localStorage.getItem("token");
          var thn     = $('#thn').html();
          var bln  = $(this).data("bln");
          var finish  = $(this).data("finish");
          var idopd   = $(this).data("idopd");
          Pace.restart ();
          Pace.track (function (){
            $.ajax ({
              url: base_url+"Cpanel/uri-lihat-laporan-opd/",
              type: "POST",
              data: {
                token   : token,
                thn     : thn,
                bln     : bln,
                idopd   : idopd
              },
              dataType: "JSON",
              complete: function(data){
              ajaxtoken();
              var jsonData = JSON.parse(data.responseText);
              var thn = jsonData.uri[0].thn;
              var bln = jsonData.uri[0].bln;
              var idopd = jsonData.uri[0].idopd;
              Pace.restart ();
              Pace.track (function (){
                $('#modaldafkeg').modal('hide');
                    window.location.href = base_url+"Cpanel/lihat-laporan-bulanan-opd?thn="+thn+"&bln="+bln+"&unt="+idopd+"&fns="+finish;

                });


              },
              error: function(jqXHR, textStatus, errorThrown){
                swal(
                  'error',
                  'Terjadi Kesalahan, Coba Lagi Nanti',
                  'error'
                )
              }
            });
          });

        });

  });

</script>
