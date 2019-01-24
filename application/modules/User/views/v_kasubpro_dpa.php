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

    $("#sinkron-dpa").click(function () {
      ajaxtoken();
      var token = localStorage.getItem("token");
      var kdunit  = $('#kdunit').html();
        Pace.restart();
        Pace.track(function () {
          // ajax post idopd dan tahun
          $.ajax ({
            url: base_url+"User/sinkrondpa221/",
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
                var notification = alertify.notify('Data DPA Berhasil Di Sinkronkan', 'success', 3, function(){
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

    $('a.lihat-dpa').on("click",function(){
      //var idprog  = $(this).attr('prog');
      var kdunit  = $('#kdunit').html();
      var nmopd   = $('#nmopd').html();
      var idprog  = $(this).data("prog");
      var nmprog  = $('b.'+idprog).text();
      var id      = $(this).data("id");
      var keg     = $(this).text();
      var html = '';
      var dethtml = '';
      ajaxtoken();
      var token = localStorage.getItem("token");
      Pace.restart ();
      Pace.track (function (){

        $.ajax ({
          url: base_url+"User/jsondpa/"+Math.random(),
          type: "POST",
          data: {
            unitkey : kdunit,
            nmunit  : nmopd,
            idkeg   : id,
            token   : token
          },
          dataType: "JSON",
          complete: function(data){
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
                      <hr>\
                      <table class="table table-bordered table-condensed " style="font-size: 12px">\
                      <thead>\
                        <tr>\
                              <th rowspan="2" style="vertical-align : middle;text-align:center; width: 10%" >Kode Rekening</th>\
                              <th rowspan="2" style="vertical-align : middle;text-align:center; width: 40%" >Uraian</th>\
                              <th colspan="3" style="vertical-align : middle;text-align:center;" >Rincian Perhitungan</th>\
                              <th rowspan="2" style="vertical-align : middle;text-align:center; width: 15%" >Jumlah</th>\
                            </tr>\
                            <tr>\
                              <th style="vertical-align : middle;text-align:center; width: 10%" >Volume</th>\
                              <th style="vertical-align : middle;text-align:center; width: 10%" >Satuan</th>\
                              <th style="vertical-align : middle;text-align:center;width: 15%" >Harga Satuan</th>\
                            </tr>\
                            <tr>\
                              <th style="vertical-align : middle;text-align:center;" >1</th>\
                              <th style="vertical-align : middle;text-align:center;" >2</th>\
                              <th style="vertical-align : middle;text-align:center;" >3</th>\
                              <th style="vertical-align : middle;text-align:center;" >4</th>\
                              <th style="vertical-align : middle;text-align:center;" >5</th>\
                              <th style="vertical-align : middle;text-align:center;" >6 = (3 x 5)</th>\
                            </tr>\
                      </thead>\
                      <tbody>';
            for (x in jsonData.data) {
                for (i in jsonData.data[x].lv1) {
                  var reklv1 = jsonData.data[x].lv1[i].rek;
                  var urlv1 = jsonData.data[x].lv1[i].nmrek;
                  var jhlv1 = jsonData.data[x].lv1[i].jml;
                    html +='<tr>\
                  			<td><b>'+reklv1+'</b></td>\
                  			<td><b>'+urlv1+'</b></td>\
                  			<td></td>\
                  			<td></td>\
                  			<td></td>\
                  			<td style="text-align:right"><b>'+jhlv1+'</b></td>\
                  		</tr>';
                      for (ii in jsonData.data[x].lv1[i].lv2) {
                        var reklv2 = jsonData.data[x].lv1[i].lv2[ii].rek;
                        var urlv2 = jsonData.data[x].lv1[i].lv2[ii].nmrek;
                        var jhlv2 = jsonData.data[x].lv1[i].lv2[ii].jml;
                          html +='<tr>\
                        			<td><b>'+reklv2+'</b></td>\
                        			<td><b>'+urlv2+'</b></td>\
                        			<td></td>\
                        			<td></td>\
                        			<td></td>\
                        			<td style="text-align:right"><b>'+jhlv2+'</b></td>\
                        		</tr>';
                            for (iii in jsonData.data[x].lv1[i].lv2[ii].lv3) {
                              var reklv3 = jsonData.data[x].lv1[i].lv2[ii].lv3[iii].rek;
                              var urlv3 = jsonData.data[x].lv1[i].lv2[ii].lv3[iii].nmrek;
                              var jhlv3 = jsonData.data[x].lv1[i].lv2[ii].lv3[iii].jml;
                                html +='<tr>\
                              			<td><b>'+reklv3+'</b></td>\
                              			<td><b>'+urlv3+'</b></td>\
                              			<td></td>\
                              			<td></td>\
                              			<td></td>\
                              			<td style="text-align:right"><b>'+jhlv3+'</b></td>\
                              		</tr>';
                                  for (iv in jsonData.data[x].lv1[i].lv2[ii].lv3[iii].det) {
                                    var reklv4 = jsonData.data[x].lv1[i].lv2[ii].lv3[iii].det[iv].kr;
                                    var urlv4 = jsonData.data[x].lv1[i].lv2[ii].lv3[iii].det[iv].nr;
                                    var nllv4 = jsonData.data[x].lv1[i].lv2[ii].lv3[iii].det[iv].nl;
                                      html +='<tr>\
                                    			<td>'+reklv4+'</td>\
                                    			<td>'+urlv4+'</td>\
                                    			<td></td>\
                                    			<td></td>\
                                    			<td></td>\
                                    			<td style="text-align:right">'+nllv4+'</td>\
                                    		</tr>';
                                        for (v in jsonData.data[x].lv1[i].lv2[ii].lv3[iii].det[iv].rc) {

                                          var urlv5 = jsonData.data[x].lv1[i].lv2[ii].lv3[iii].det[iv].rc[v].ur;
                                          var vllv5 = jsonData.data[x].lv1[i].lv2[ii].lv3[iii].det[iv].rc[v].vl;
                                          var stlv5 = jsonData.data[x].lv1[i].lv2[ii].lv3[iii].det[iv].rc[v].st;
                                          var hslv5 = jsonData.data[x].lv1[i].lv2[ii].lv3[iii].det[iv].rc[v].hs;
                                          var jhlv5 = jsonData.data[x].lv1[i].lv2[ii].lv3[iii].det[iv].rc[v].jh;
                                          var tplv5 = jsonData.data[x].lv1[i].lv2[ii].lv3[iii].det[iv].rc[v].tp;

                                          if(tplv5=='H'){
                                            html +='<tr>\
                                                <td></td>\
                                                <td ><i style="margin-left:1em ;">'+urlv5+'</i></td>\
                                                <td style="text-align:center"></td>\
                                                <td style="text-align:center"></td>\
                                                <td style="text-align:right"></td>\
                                                <td style="text-align:right"></td>\
                                              </tr>';
                                          }else{
                                            html +='<tr>\
                                                <td></td>\
                                                <td ><i style="margin-left:1.5em ;">'+urlv5+'</i></td>\
                                                <td style="text-align:center">'+vllv5+'</td>\
                                                <td style="text-align:center">'+stlv5+'</td>\
                                                <td style="text-align:right">'+hslv5+'</td>\
                                                <td style="text-align:right">'+jhlv5+'</td>\
                                              </tr>';
                                          }

                                        }
                                  }
                            }
                      }
                }

                html += '</tbody>\
                </table>';
            }
            alertify.confirm().destroy();
            alertify.confirm()
            .set({
              'resizable':false,
              'movable': false,
              'autoReset': true,
              'transition':'fade',
              'title':'Dokumen Pelaksanaan Anggaran ',
              'labels': {
                ok:'Cetak', cancel:'Batal'
              },
                'startMaximized':true,
              onok: function(){

              },
              onclose:function(){
                // alertify.message('confirm was closed.')
                ajaxtoken();
              }
            })
            .setContent(html).show();

          },
          error: function(jqXHR, textStatus, errorThrown){
            // console.log(jqXHR.responseText);
            ajaxtoken();
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

        <a class="btn btn-block btn-social bg-blue btn-flat" id="sinkron-dpa">
          <i class="fa fa-skyatlas"></i> Sinkron Data
        </a>
      </div>



    </div>
    <br>


<!-- Default box -->

<div class="box box-primary">
  <div class="box-header with-border">
      <i class="fa fa-list"></i>
    <h3 class="box-title">Dokumen Pelaksanaan Anggaran</h3>


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
            echo '<a href="javascript:void(0)" class="lihat-dpa list-group-item medium '.$bg.'" data-id='.$xkey['kdkeg'].' data-prog='.$key['idprog'].'  style="margin-left:2em ;">'.$xkey['nmkeg'].'</a>';
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
