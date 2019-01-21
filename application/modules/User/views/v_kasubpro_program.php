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
    var idunit='<?php echo $idopd; ?>';

    ajaxtoken();

    $("#sinkron-listprogram").click(function () {
      ajaxtoken();
      var token = localStorage.getItem("token");
        Pace.restart();
        Pace.track(function () {
          // ajax post idopd dan tahun
          $.ajax ({

            url: base_url+"User/sinkrondpa22/",
            type: "POST",
            data: {
              token   : token,
              unit    : idunit

            },
            dataType: "JSON",
            complete: function(data){
              ajaxtoken();
              var jsonData = JSON.parse(data.responseText);
              var status =jsonData.data[0].status;
              if (status == true){
                // alertify.success('Data Program dan Kegiatan Berhasil Di Sinkronkan');
                var notification = alertify.notify('Data Program dan Kegiatan Berhasil Di Sinkronkan', 'success', 3, function(){
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

        <a class="btn btn-block btn-social bg-blue btn-flat" id="sinkron-listprogram">
          <i class="fa fa-skyatlas"></i> Sinkron Data
        </a>
      </div>



    </div>
    <br>


<!-- Default box -->

<div class="box box-primary">
  <div class="box-header with-border">
      <i class="fa fa-list"></i>
    <h3 class="box-title">List Program dan Kegiatan</h3>


    </div>
    <!-- <div class="box-body no-padding"> -->
    <div class="box-body ">
    <?php
      // echo '<ul class="list-prog nav nav-pills nav-stacked">';
      //   foreach ($program as $key ) {
      //   echo '<li data-toggle="collapse" data-target="#'.$key['idprog'].'"><a href="javascript:void(0)"><i class="fa fa-chevron-right"></i>'.$key['nmprog'].'<span class="label label-primary pull-right">'.$key['jumkeg'].'</span></a></li>';
      //   echo '<div id="'.$key['idprog'].'" class="panel-collapse collapse">
      //       <div class="box-body">
      //
      //       </div>
      //     </div>';
      //   }
      // echo '</ul>';
      if(empty($program[0])){
        echo 'Silahkan Sinkronkan Data';
      }else{
        echo '<div id="menu">';
        echo '<div class="panel list-group">';
        foreach ($program as $key ){
          echo ' <a href="javascript:void(0)" class="list-group-item" data-toggle="collapse" data-target="#'.$key['idprog'].'" data-parent="#menu"> <i class="fa fa-chevron-right"></i> <b>'.$key['nmprog'].'</b> <span class="badge bg-blue pull-right">'.$key['jumkeg'].'</span></a>';
          echo ' <div id="'.$key['idprog'].'" class="sublinks collapse">';
          $i=0;
          foreach ($key['detkeg'] as $xkey ) {
            $i++;
            if ($i % 2 == 0){
              $bg='bg-gray';
            }else{
              $bg='bg-white';
            }
            echo '<a class="list-group-item medium '.$bg.'" style="margin-left:2em ;">'.$xkey['nmkeg'].'<span class="pull-right" style="margin-right:2em ;">'.$xkey['nilai'].'</span></a>';
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
