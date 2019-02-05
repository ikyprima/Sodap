<script type="text/javascript">

  $(document).ready(function() {

  //rizky.initMaterialWizard();

  ajaxtoken();


  $(".btnkak").click(function() {
    // jQuery("#listkegiatan").fadeOut("slow");
    // jQuery("#targetfisik").fadein("slow");
    ajaxtoken();

  /****AGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNG*/ 
   if ($(this).hasClass('lihat')) {
    var row = $(this).closest("tr");    // Find the row
    var idtab = row.find(".idtab").text(); // Find the text
    var kdkegunit = row.find(".id").text(); // Find the text
    var unit = $('#kdunit').html();
    var token = localStorage.getItem("token");
    $.ajax ({
        url: base_url+"User/cekstatkak/"+Math.random(),
        type: "POST",
        data: {
          unitkey : unit,
          idkeg   : kdkegunit,
          token   : token,
          idtab   : idtab
        },
        dataType: "JSON",
        complete: function(data){

          ajaxtoken();
          var jsonData = JSON.parse(data.responseText);

            if(jsonData.uri[0].status==true){
              //KAK Kegiatan Sudah di entri sementra Target belanja Modal Masih belum
              var unit = jsonData.uri[0].unit;
              var kegiatan = jsonData.uri[0].keg;
              var tab = jsonData.uri[0].tab;
              window.location.href = base_url+"User/viewkakppk?unit="+unit+"&keg="+kegiatan+"&tab="+tab;
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
    }else if($(this).hasClass('bmodal')){
      var row = $(this).closest("tr");    // Find the row
      var idtab = row.find(".idtab").text(); // Find the text
      var kdkegunit = row.find(".id").text(); // Find the text
      var unit = $('#kdunit').html();
      var token = localStorage.getItem("token");
      $.ajax ({
          url: base_url+"User/jsoncheckbodal/"+Math.random(),
          type: "POST",
          data: {
            unitkey : unit,
            idkeg   : idtab,
            idtab   : idtab,
            token   : token
          },
          dataType: "JSON",
          complete: function(data){
          console.log(data);
          ajaxtoken();
          var html = "";
          var dethtml = "";
          var jsonData = JSON.parse(data.responseText);
            for (x in jsonData.bljmodal) {
              dethtml = "";
              var rek=jsonData.bljmodal[x].no_rekening;
              var nmrek=jsonData.bljmodal[x].nama_rekening;
              var strrek = rek.replace(/\./g,"-");
              var heading=strrek+'heading';
              html +="<div class='panel panel-default'>\
                    <div class='panel-heading' role='tab' id='"+heading+"'>\
                      <a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#"+strrek+"' aria-expanded='false' aria-controls='"+strrek+"'>\
                        <div class='row'>\
                          <div class='col-md-1 col-sm-1 text-muted' style='text-align: left'></div>\
                          <div class='col-md-3 col-sm-3 text-muted' style='padding-left: 25px'>"+rek+"</div>\
                          <div class='col-md-8 col-sm-8 text-muted' style='padding-left: 25px'>"+nmrek+"</div>\
                        </div>\
                      </a>\
                    </div>\
                      <div id='"+strrek+"' class='panel-collapse collapse' role='tabpanel' aria-labelledby='"+heading+"'>\
                        <div class='panel-body'>\
                          <table class='table table-bordered'>\
                            <thead>\
                              <tr class='active'>\
                                <th>Bulan</th>\
                                <th>Target</th>\
                              </tr>\
                            </thead>\
                            <tfoot>\
                            </tfoot>\
                            <tbody>";
                            var bln = [
                                    "Januari",
                                    "Februari",
                                    "Maret",
                                    "April",
                                    "Mei",
                                    "Juni",
                                    "Juli",
                                    "Agustus",
                                    "September",
                                    "Oktober",
                                    "November",
                                    "Desember"];
                            for (y in jsonData.bljmodal[x].target) {
                              var prog = jsonData.bljmodal[x].target[y]+'%';
                              if (jsonData.bljmodal[x].target[y] == null){
                                  prog = '-';
                              }
                              dethtml +="<tr>\
                                <td>"+bln[y]+"</td>\
                                <td>"+prog+"</td>\
                                </tr>"
                            }
                     html +=dethtml;
                    html +="</tbody>\
                          </table>\
                        </div>\
                      </div>\
                    </div>";
            }
            modaldafkeg({
              buttons: {
                batal: {
                  id    : 'btn-modal-batal',
                  css   : 'btn-info btn-raised btn-flat btn-bitbucket',
                  label : 'Tutup'
                }
              },
              title: 'Target Keuangan',
              namakegiatan : jsonData.nmKegiatan,
              nilai : jsonData.pagu_dana,
              namapptk : jsonData.nama_pptk,
              html : html

            });

           },
          error: function(jqXHR, textStatus, errorThrown){
          console.log(jqXHR);
            swal(
              'error',
              'Terjadi Kesalahan, Coba Lagi Nanti',
              'error'
            )
          }
        });
   }
  /*AGUNAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGG******/
   else{
     var row = $(this).closest("tr");    // Find the row
     var kdkegunit = row.find(".id").text(); // Find the text
     var idtab = row.find(".idtab").text(); // Find the text
     var unit = $('#kdunit').html();
     var token = localStorage.getItem("token");
     $.ajax ({
        url: base_url+"User/cekstatkak/"+Math.random(),
        type: "POST",
        data: {
          unitkey : unit,
          idkeg   : kdkegunit,
          token   : token,
          idtab   : idtab
        },
      dataType: "JSON",
      complete: function(data){

        ajaxtoken();
        var jsonData = JSON.parse(data.responseText);

        if(jsonData.uri[0].status==true && jsonData.uri[0].edit==true ){
        //KAK Kegiatan Sudah di entri sementra Target belanja Modal Masih belum
          var unit = jsonData.uri[0].unit;
          var kegiatan = jsonData.uri[0].keg;
          var tab = jsonData.uri[0].tab;
          window.location.href = base_url+"User/entritblnjmodal?unit="+unit+"&keg="+kegiatan+"&tab="+tab;

        }else if(jsonData.uri[0].status==false && jsonData.uri[0].edit==false ){
          //belum ada KAK maupun target fisik Belanja modal
          var unit = jsonData.uri[0].unit;
          var kegiatan = jsonData.uri[0].keg;
          var tab = jsonData.uri[0].tab;
          window.location.href = base_url+"User/entrikak?unit="+unit+"&keg="+kegiatan+"&tab="+tab;
        }

    },
    error: function(jqXHR, textStatus, errorThrown){
        console.log(jqXHR);
      swal(
        'error',
        'Terjadi Kesalahan, Coba Lagi sNanti',
        'error'
      )
    }
  });
    }

  });



  });

</script>

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



      </div>
      <br>
<!-- Default box -->

<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Lisk Kegiatan</h3>


      </div>
      <div class="box-body">
          <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-left"  width="2%"><b>#</b></th>

                        <th class="col-xs-5 text-left" >Nama Kegiatan</th>
                        <th class="col-xs-3 text-left" >Nama PPTK</th>
                        <th class="col-xs-2 text-right" >Pagu Dana</th>
                        <th class="col-xs-1 text-center" >Status</th>
                        <th class=" td-actions text-center" ></th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                  foreach ($list as $row){
                      $i++;
                      $stat=$row['status'];
                      if($stat=='1'){
                        $status='<span class="label label-success">Sudah Konfirmasi</span>';
                    }else{
                        $status='<span class="label label-danger">Belum Konfirmasi</span>';
                    }
                    /*dari AGUNG----AGUNG----AGUNG----AGUNG----AGUNG----AGUNG----AGUNG----AGUNG*/
                    $statkak = $this->db->get_where('tab_kak',array('idtab_pptk'=>$row['id']));
                    if($statkak->num_rows()>0){
                      // $ada=1; maka tidak bisa lanjut
                      if($statkak->row()->stat_draft==0){
                      /*$ada='<button type="button" class="btnkak lihat btn btn-block btn-primary btn-flat data-toggle="tooltip"
                              title="KAK Sudah Di Entri">Lihat<i class="fa fa-check text-success"></i></button>';*/
                      $ada='<div class="btn-group">
                  <button type="button" class="btn btn-info">Lihat</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a class="btnkak lihat">KAK</a></li>
                    <li><a class="btnkak bmodal">Belanja Modal</a></li>
                  </ul>
                </div>';
                    /*sampai AGUNG----AGUNG----AGUNG----AGUNG----AGUNG----AGUNG----AGUNG----AGUNG*/
                      }else{
                        $ada='<button type="button" class="btnkak btn btn-block btn-primary btn-flat" data-toggle="tooltip"
                              title="Target Fisik Belanja Modal Blm Ada">Entri KAK <i class="fa fa-spinner fa-pulse fa-fw text-danger"></i></button> ';
                      }

                    }else{
                      // $ada=0; lanjut karna belum ada
                      $ada='<button type="button" class="btnkak btn btn-block btn-primary btn-flat" data-toggle="tooltip"
                              title="KAK Kegiatan Belum Ada">Entri KAK <i class="fa fa-hourglass-start text-danger"></i></button>';
                    }

                    echo'<tr>
                    <td>'.$i.'</td>
                    <td class="idtab" style="display:none;">'.$row['id'].'</td>
                    <td class="id" style="display:none;">'.$row['kdkegunit'].'</td>
                    <td class="col-xs-5">'.$row['nmkegunit'].'</td>
                    <td class="col-xs-3">'.$row['idpnspptk'].'</td>
                    <td class="col-xs-2 text-right">'.$this->template->rupiah($row['nilai']).'</td>
                    <td class="col-xs-1 text-center">'.$status.'</td>
                    <td class="td-actions text-center">'.$ada.'</td>
                    </tr>';

                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- +++++++AGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNG -->
<div class="modal fade" id="modaldafkeg" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>


            </div>

            <div class="modal-body">
               <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                              <div class="card-header card-header-icon" data-background-color="blue">
                                    <i class="material-icons">assignment</i>
                                </div>
                              <div class="card-content">
                              <h4 class="card-title modal-title"></h4>
                                <div class="toolbar">


                                </div>
                              <br>
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 text-muted" style="text-align: left">Nama Kegiatan</div>
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: right;width: 5px">:</div>
                                    <div class="col-md-9 col-sm-9 text-muted" style="padding-left: 25px"><p id="namakegiatan"></p></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-2 col-sm-2 text-muted" style="text-align: left">Nilai Kegiatan</div>
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: right;width: 5px">:</div>
                                    <div class="col-md-9 col-sm-9 text-muted" style="padding-left: 25px"><p id="nilai"></p></div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 text-muted" style="text-align: left">Nama PPTK</div>
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: right;width: 5px">:</div>
                                    <div class="col-md-9 col-sm-9 text-muted" style="padding-left: 25px"><p id="namapptk"></p></div>
                                </div>
                                <br>
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

            </div>

            <div class="modal-footer modal-footer-tombol">

            </div>
        </div>
    </div>
</div>
<!-- AGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNG+++++++++ -->
<!-- /.box-body -->
<div class="box-footer">
  Footer
</div>
<!-- /.box-footer-->

</div>
<!-- /.box -->

</section>
