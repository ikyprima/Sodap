<style type="text/css">
.select2-container {
  z-index:2016;
}
.file-zoom-dialog{
    z-index:2016;
}

</style>
<!-- include the style -->
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/alertify.min.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/themes/default.min.css') ?>"/>
<script src="<?php echo base_url('assets/alertify/alertify.min.js') ?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/mediajs/jquery.media.js') ?>"></script>

<script type="text/javascript">
  $(document).ready(function () {

    ajaxtoken();

    $("#sinkron-angkas").click(function () {
      ajaxtoken();
      var token = localStorage.getItem("token");
      var kdunit  = $('#kdunit').html();
        Pace.restart();
        Pace.track(function () {
          // ajax post idopd dan tahun
          $.ajax ({
            url: base_url+"User/sinkronangkas/",
            type: "POST",
            data: {
              token   : token,
              unit    : kdunit

            },
            dataType: "JSON",
            complete: function(data){
              ajaxtoken();
              var jsonData = JSON.parse(data.responseText);
              var status =jsonData.data[0].status;
              if (status == true){
                // alertify.success('Data Program dan Kegiatan Berhasil Di Sinkronkan');
                var notification = alertify.notify('Data Aliran Kas Berhasil Di Sinkronkan', 'success', 3, function(){
                  //nanti pakai javascript
                  location.reload(true);
                });
              }else{
                alertify.error('Gagal Sinkronkan Data');

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

        });
    });

    $('a.lihat-angkas').on("click",function(){
      //var idprog  = $(this).attr('prog');
      var kdunit  = $('#kdunit').html();
      var nmopd   = $('#nmopd').html();
      var idprog  = $(this).data("prog");
      var nmprog  = $('b.'+idprog).text();
      var id      = $(this).data("id");
      var keg     = $(this).text();
      var html = '';

      ajaxtoken();
      var token = localStorage.getItem("token");
      Pace.restart ();
      Pace.track (function (){

        $.ajax ({
          url: base_url+"User/jsonangkas/"+Math.random(),
          type: "POST",
          data: {
            unitkey : kdunit,
            nmunit  : nmopd,
            idkeg   : id,
            nmkeg   : keg,
            token   : token
          },
          dataType: "JSON",
          complete: function(data){
            ajaxtoken();
            var jsonData = JSON.parse(data.responseText);
            html += ' <div class="row">\
                      <div class="col-md-1 col-sm-1 col-xs-12">\
                      </div>\
                      <div class="col-md-2 col-sm-2 col-xs-12">\
                        <h4 class="text-left text-muted">Program</h4>\
                      </div>\
                      <div class="col-md-1 col-sm-1 col-xs-12">\
                        <h4 class="text-center text-muted">:</h4>\
                      </div>\
                      <div class="col-md-6 col-sm-8 col-xs-12">\
                        <h4 class="text-left text-muted">'+nmprog+'</h4>\
                      </div>\
                      <div class="col-md-2 col-sm-2 col-xs-12">\
                      </div>\
                      </div>\
                      <div class="row">\
                      <div class="col-md-1 col-sm-1 col-xs-12">\
                      </div>\
                      <div class="col-md-2 col-sm-2 col-xs-12">\
                      <h4 class="text-left text-muted">Kegiatan</h4>\
                      </div>\
                      <div class="col-md-1 col-sm-1 col-xs-12">\
                      <h4 class="text-center text-muted">:</h4>\
                      </div>\
                      <div class="col-md-6 col-sm-8 col-xs-12">\
                      <h4 class="text-left text-muted">'+keg+'</h4>\
                      </div>\
                      <div class="col-md-2 col-sm-2 col-xs-12">\
                      </div>\
                      </div>\
                      <hr>';

                      html +='<div id="angkas">\
                              <div class="panel list-group">';

                        for (x in jsonData.data) {
                            for (bulan in jsonData.data[x].bulan) {
                              var i=0;
                              var idbln = jsonData.data[x].bulan[bulan].bln;
                              var nmbln = jsonData.data[x].bulan[bulan].mskbln;
                              var nilai = jsonData.data[x].bulan[bulan].msknilai;
                              html +='<a href="javascript:void(0)" class="list-group-item" data-toggle="collapse" data-target="#'+idbln+'" data-parent="#angkas"> <i class="fa fa-dot-circle-o" style="margin-left:2em ;"></i> <b style="margin-left:1em ;">'+nmbln+'</b> <span class="pull-right"><b>'+nilai+'</b></span></a>'
                              html +='<div id="'+idbln+'" class="sublinks collapse">'
                              html +='<table class="table table-bordered table-condensed " style="font-size: 12px">';
                              html +='<tbody>';
                              for (det in jsonData.data[x].bulan[bulan].det) {
                                var bg = '';
                                var kdrek = jsonData.data[x].bulan[bulan].det[det].kdper;
                                var nmrek = jsonData.data[x].bulan[bulan].det[det].nmper;
                                var nilai = jsonData.data[x].bulan[bulan].det[det].msknilai;
                                i++;
                                if (i % 2 == 0){
                                  bg ='active';
                                }else{
                                  bg ='';
                                }
                                html +='<tr class="'+bg+'" >\
                                          <td style="text-align:center; width: 25%">'+kdrek+'</td>\
                                          <td>'+nmrek+'</td>\
                                          <td style="text-align:right; width: 15%"><span style="margin-right:1em ;">'+nilai+'</span></td>\
                                        </tr>';

                              }
                              html +='</tbody>';
                              html +='</table>';
                              html +='</div>'
                            }
                        }
                      html +='</div>\
                            </div>';


            alertify.alert().destroy();
            alertify.alert()
            .set({
              'resizable':true,
              'movable': false,
              'transition':'zoom',
              'title':'Aliran KAS',
              'labels': {
                ok:'Simpan', cancel:'Batal'
              },
              onok: function(){

              },
              onclose:function(){
                // alertify.message('confirm was closed.')
                ajaxtoken();
              }
            })
            .resizeTo('70%','85%')

            .setContent(html).show();


          },
          error: function(jqXHR, textStatus, errorThrown){
            // console.log(jqXHR.responseText);
            ajaxtoken();
            swal(
              'error',
              'Terjadi Kesalahan, Coba Lagi Nanti / Sinkron Data Terlebih Dahulu',
              'error'
            )
          }
        });






      });



    });
    //batas on ready function
  });


</script>
<section class="content-header">
  <h1>
    SODAP
  <small>Kota Payakumbuh</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#"><i class="fa fa-list"></i> List Program</a></li>
  </ol>
</section>
<section class="content">
  <div class="callout bg-blue">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-md-offset-1">
           <br>
           <p id="kdunit" hidden><?php echo $idopd ?></p>
           <p id="nmopd" hidden><?php echo $nmopd ?></p>
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

    <div class="col-md-3 col-sm-3 col-xs-12">
      <a class="btn btn-block btn-social btn-success btn-flat" id="btn-kembali">
        <i class="fa fa-arrow-left"></i> Kembali
      </a>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12">
      </div>
      <div class="col-md-3 col-sm-3 col-xs-12">

      </div>

      <div class="col-md-3 col-sm-3 col-xs-12">

        <a class="btn btn-block btn-social bg-blue btn-flat" id="sinkron-angkas">
          <i class="fa fa-skyatlas"></i> Sinkron Data
        </a>
      </div>



    </div>
    <br>


<!-- Default box -->

<div class="box box-primary">
  <div class="box-header with-border">
      <i class="fa fa-list"></i>
    <h3 class="box-title">Aliran Kas</h3>


    </div>
    <!-- <div class="box-body no-padding"> -->
    <div class="box-body ">
    <?php

      if(empty($dpa[0])){
        echo 'Silahkan Sinkronkan Data';
      }else{
        echo '<div id="menu">';
        echo '<div class="panel list-group">';
        foreach ($dpa as $key ){
          echo ' <a href="javascript:void(0)" class="list-group-item '.$key['idprog'].'" data-toggle="collapse" data-target="#'.$key['idprog'].'" data-parent="#menu"> <i class="fa fa-chevron-right"></i> <b class="'.$key['idprog'].'">'.$key['nmprog'].'</b> <span class="badge bg-blue pull-right">'.$key['jumkeg'].'</span></a>';
          echo ' <div id="'.$key['idprog'].'" class="sublinks collapse">';
          $i=0;
          foreach ($key['detkeg'] as $xkey ) {
            $i++;
            if ($i % 2 == 0){
              $bg='bg-gray';
            }else{
              $bg='bg-white';
            }
            echo '<a href="javascript:void(0)" class="lihat-angkas list-group-item medium '.$bg.'" data-id='.$xkey['kdkeg'].' data-prog='.$key['idprog'].'  style="margin-left:2em ;">'.$xkey['nmkeg'].'</a>';
          }
            // <a class="list-group-item small"><span class="glyphicon glyphicon-chevron-right"></span> inbox</a>
            // <a class="list-group-item small"><span class="glyphicon glyphicon-chevron-right"></span> sent</a>
           echo '</div>';
        }
      echo '</div>
            </div>';

}

      ?>




    </div>
<!-- /.box-body -->
<div class="box-footer">

</div>
<!-- /.box-footer-->

</div>
<!-- /.box -->

</section>
