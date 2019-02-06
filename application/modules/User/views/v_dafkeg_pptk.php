<script type="text/javascript">
 $(document).ready(function() {

  ajaxtoken();

  $(".btntk").click(function() {
    ajaxtoken();
    var row = $(this).closest("tr");    // Find the row
    var kdkegunit = row.find(".id").text(); // Find the text
    var unit = $('#kdunit').html();
    var token = localStorage.getItem("token");
    $.ajax ({
      url: base_url+"User/jsontargetkeu/"+Math.random(),
      type: "POST",
      data: {
        unitkey : unit,
        idkeg   : kdkegunit,
        token   : token
      },
      dataType: "JSON",
      complete: function(data){
      ajaxtoken();
      var html = "";
      var dethtml = "";
      var jsonData = JSON.parse(data.responseText);
      for (x in jsonData.data) {
        dethtml = "";
        var bln=jsonData.data[x].mskbln;
        var nl=jsonData.data[x].msknilai;
        var heading=bln+'heading';
          html +="<div class='panel panel-default'>\
                    <div class='panel-heading' role='tab' id='"+heading+"'>\
                      <a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#"+bln+"' aria-expanded='false' aria-controls='"+bln+"'>\
                        <div class='row'>\
                          <div class='col-md-1 col-sm-1 text-muted' style='text-align: left'></div>\
                          <div class='col-md-3 col-sm-3 text-muted' style='padding-left: 25px'>"+bln+"</div>\
                          <div class='col-md-8 col-sm-8 text-muted' style='padding-left: 25px'>"+nl+"</div>\
                        </div>\
                      </a>\
                    </div>\
                      <div id='"+bln+"' class='panel-collapse collapse' role='tabpanel' aria-labelledby='"+heading+"'>\
                        <div class='panel-body'>\
                          <table class='table table-bordered'>\
                            <thead>\
                              <tr class='active'>\
                                <th>Tahun</th>\
                                <th>Kode Rekening</th>\
                                <th>Nama Rekening</th>\
                                <th>Nilai</th>\
                              </tr>\
                            </thead>\
                            <tfoot>\
                            </tfoot>\
                            <tbody>";
                            for (y in jsonData.data[x].rek) {
                              var tahun = jsonData.data[x].rek[y].tahun;
                              var kdrek = jsonData.data[x].rek[y].kdper;
                              var nmrek = jsonData.data[x].rek[y].nmper;
                              var nilai = jsonData.data[x].rek[y].msknilai;
                              dethtml +="<tr>\
                                <td>"+tahun+"</td>\
                                <td>"+kdrek+"</td>\
                                <td>"+nmrek+"</td>\
                                <td>"+nilai+"</td>\
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
              namakegiatan : jsonData.header[0].nmkegunit,
              nilai : jsonData.header[0].msknilai,
              namapptk : jsonData.header[0].idpnspptk,
              namappk : jsonData.header[0].idpnsppk,
              html : html

            });
          },
          error: function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR.responseText);
            swal(
              'error',
              'Terjadi Kesalahan, Coba Lagi Nanti',
              'error'
            )
          }
        });

      });

  $(".btntf").click(function() {

  ajaxtoken();
  var row = $(this).closest("tr");    // Find the row
  var kdkegunit = row.find(".id").text(); // Find the text
  var unit = $('#kdunit').html();
  var token = localStorage.getItem("token");
  $.ajax ({
    url: base_url+"User/jsontargetfis/"+Math.random(),
    type: "POST",
    data: {
      unitkey : unit,
      idkeg   : kdkegunit,
      token   : token
    },
    dataType: "JSON",
    complete: function(data){
    //  console.log(data);
      ajaxtoken();
      var html = "";
      var dethtml = "";
      var jsonData = JSON.parse(data.responseText);
        if (jsonData.header[0].status == false){
        swal(
          'info',
          'Belum Ada Kerangka Acuan Kerja!!!',
          'info'
        );
        ajaxtoken();
         }else{

      for (x in jsonData.data) {
        dethtml = "";
        var bln=jsonData.data[x].bln;
        var nl=jsonData.data[x].targ;
        var jtarget=jsonData.data[x].jumtarg;
        var heading=bln+'heading';
          html +="<div class='panel panel-default'>\
                    <div class='panel-heading' role='tab' id='"+heading+"'>\
                      <a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#"+bln+"' aria-expanded='false' aria-controls='"+bln+"'>\
                        <div class='row'>\
                          <div class='col-md-1 col-sm-1 text-muted' style='text-align: left'></div>\
                          <div class='col-md-3 col-sm-3 text-muted' style='padding-left: 25px'>"+bln+"</div>\
                          <div class='col-md-4 col-sm-4 text-muted' style='padding-left: 25px'>"+nl+"%</div>\
                          <div class='col-md-4 col-sm-4 text-muted' style='padding-left: 25px'>"+jtarget+"%</div>\
                        </div>\
                      </a>\
                    </div>\
                      <div id='"+bln+"' class='panel-collapse collapse' role='tabpanel' aria-labelledby='"+heading+"'>\
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

              title: 'Target Fisik',
              namakegiatan : jsonData.header[0].nmkegunit,
              nilai : jsonData.header[0].msknilai,
              namapptk : jsonData.header[0].idpnspptk,
              namappk : jsonData.header[0].idpnsppk,
              html : html

            });
         }

    },
    error: function(jqXHR, textStatus, errorThrown){
      console.log(jqXHR.responseText);
      swal(
        'error',
        'Terjadi Kesalahan, Coba Lagi Nanti',
        'error'
      )
      ajaxtoken();
    }
  });
});

  $(".btnrl").click(function() {
    ajaxtoken();
    var row = $(this).closest("tr");
    var kdkegunit = row.find(".id").text();
    var idtab = row.find(".idtab").text();
    var unit = $('#kdunit').html();
    var token = localStorage.getItem("token");
    $.ajax ({
      url: base_url+"User/jsonrealisasi/"+Math.random(),
      type: "POST",
      data: {
        unitkey : unit,
        idkeg   : kdkegunit,
        idtab   : idtab,
        token   : token
      },
      dataType: "JSON",
      complete: function(data){
        //awal jsonrealisasi complete
        ajaxtoken();
        var html = "";
        var tbody="";
        var d = new Date();
        var day = d.getDate();
        var mm = d.getMonth()+1;
        var yyyy = d.getFullYear();

        //var skr   =new Date("02"+"/06/"+yyyy);
        var skr   =new Date(mm+"/"+day+"/"+yyyy);
        // console.log(day+'-'+mm+'-'+yyyy);
        // console.log(skr);
        var jsonData = JSON.parse(data.responseText);
        html+="<table class='table table-bordered'>\
                <thead>\
                  <tr class='active'>\
                  <th class='text-left'  width='2%'>No</th>\
                  <th>Tahun</th>\
                  <th>Nilai</th>\
                  <th>Realisasi</th>\
                  </tr>\
                </thead>\
                <tbody>";
                for (x in jsonData.data) {
                  var bl=jsonData.data[x].bln;
                  var bln=jsonData.data[x].mskbln;
                  var nilai=jsonData.data[x].nl;
                  var nl=jsonData.data[x].msknilai;
                  var pertama = jsonData.data[x].pertama;
                  var ada =jsonData.data[x].adareal;
                  var totreal =jsonData.data[x].totreal;
                  var nmnltotreal=jsonData.data[x].nmnltotreal;
                  var no=parseInt(x, 10)+1;
                  var nobln=parseInt(x, 10)+2;
                  var tmb="";
                  var stat="";

                  var batasawl = new Date(no+"/05/"+yyyy);
                  var batasakr = new Date(nobln+"/05/"+yyyy);
                  var batasjn = new Date("2/05/"+yyyy); //batas untuk bulan januari

                  if(mm < no){
                    //dibatasi bulan sekarang (tidak boleh lebih dari bulan sekarang)
                    tmb = "<button class='btn bg-maroon btn-flat disabled'>Realisasi<div class='ripple-container'></div></button>";

                  }else if (no==1){
                    //jika januari
                    if(pertama==1 && nilai==0){
                          //tmb = "ini januari ini pertama dan nilai 0";
                          tmb = "<button class='btn bg-maroon btn-flat disabled'>Tidak Ada Target<div class='ripple-container'></div></button>";

                    }else if(pertama==1 && nilai!=0){

                       // tmb = "ini januari ini pertama dan nilai tidak 0";
                       tmb="<button class='enjanuari btn bg-blue btn-flat'>Entri Realisasi<div class='ripple-container'></div></button>";
                       stat="0";
                    }else{

                        // tmb = "ini januari bukan pertama dan nilai tidak 0 ";
                        // jika sampai tanggal 5 februari masih bisa edit januari
                        if(skr <= batasjn){

                          tmb = "<button class='enjanuari btn bg-blue btn-flat'>Ubah Realisasi <div class='ripple-container'></div></button>";
                          stat="1";
                        }else{
                          tmb = totreal;
                        }
                    }

                  }else{
                     if(pertama==1 && nilai==0){
                        // tmb = "ini bukan januari ini pertama dan nilai 0";
                        //tmb = "-";

                        tmb = "<button class='btn bg-maroon btn-flat disabled'>Tidak Ada Target<div class='ripple-container'></div></button>";

                    }else if(pertama==1 && nilai!=0){
                       //tmb = "ini bukan januari ini pertama dan nilai tidak 0";
                        tmb="<button class='enjanuari btn bg-blue btn-flat'>Entri Realisasi<div class='ripple-container'></div></button>";


                    }else if (pertama!=1 && nilai==0){

                         // tmb = "ini bukan januari bukan pertama dan nilai 0 ";

                         if(skr <= batasawl){
                          // tmb = "tunggu tgl 5";
                           tmb = "<button class='btn bg-maroon btn-flat disabled'>Realisasi<div class='ripple-container'></div></button>";

                         }else if(skr >= batasawl && skr <= batasakr ){
                           //cek nominal
                           //jika nominal 0 maka entri realisasi, jika tidak maka ubah
                           if(nmnltotreal==0){
                             tmb="<button class='enjanuari btn bg-blue btn-flat'>Entri Realisasi<div class='ripple-container'></div></button>";
                             stat="0";
                           }else{
                             tmb = "<button class='enjanuari btn bg-blue btn-flat'>Ubah Realisasi <div class='ripple-container'></div></button>";
                             stat="1";
                           }

                         }else{
                            //tmb = "lebih tgl 5";
                          tmb = totreal;
                         }


                    }else{
                      //misal bulan 4 pada kegiatan 11338_ tabpptk 5
                        //(pertama!=1 && nilai!=0)
                        // tmb="<button class='enjanuari btn bg-blue btn-flat'>Entri Realisasit<div class='ripple-container'></div></button>";
                        if(skr <= batasawl){
                         // tmb = "tunggu tgl 5";
                          tmb = "<button class='btn bg-maroon btn-flat disabled'>Realisasi<div class='ripple-container'></div></button>";

                        }else if(skr >= batasawl && skr <= batasakr ){
                          //cek nominal
                          //jika nominal 0 maka entri realisasi, jika tidak maka ubah
                          if(nmnltotreal==0){
                            tmb="<button class='enjanuari btn bg-blue btn-flat'>Entri Reaalisasi<div class='ripple-container'></div></button>";
                            stat="0";
                            //iko jiko nilai keuangan nol tapi alah ado fisik // harus di fixkan
                          }else{
                            tmb = "<button class='enjanuari btn bg-blue btn-flat'>Ubah Realisasi<div class='ripple-container'></div></button>";
                            stat="1";
                          }

                        }else{
                           //tmb = "lebih tgl 5";
                         tmb = totreal;
                        }
                    }


                    //cek ini yang bulan pertama




                    //Semua Bulan yang sudah berlalu sampai bulan sekarang

                      // if(batas < skr){
                      //   //jika masih tanggal 0-5 maka
                      //   if(ada==1){
                      //      tmb = totreal;
                      //   }else{
                      //        tmb = "0";
                      //   }
                      // }else{

                      //     tmb = "<button class='btnreal btn bg-blue btn-flat'>Realisasi <div class='ripple-container'></div></button>";
                      // }style='display:none;'
                  }
              tbody +="<tr>\
                    <td class='stat' style='display:none;'>"+stat+"</td>\
                    <td class='pertama' style='display:none;'>"+pertama+"</td>\
                    <td class='indexbl' style='display:none;'>"+x+"</td>\
                    <td class='bl' style='display:none;'>"+no+"</td>\
                    <td>"+no+"</td>\
                    <td>"+bln+"</td>\
                    <td>"+nl+"</td>\
                    <td>"+tmb+"</td>\
                  </tr>"
                }
                 html +=tbody;
           html+="</tbody>\
              </table>";


            modaldafkeg({
              buttons: {
                batal: {
                  id    : 'btn-modal-batal',
                  css   : 'btn-info btn-raised btn-flat btn-bitbucket',
                  label : 'Tutup'
                }
              },
              title: 'Realisasi Kegiatan',

              kdkeg : kdkegunit,
              idtab : idtab,
              namakegiatan : jsonData.header[0].nmkegunit,
              nilai : jsonData.header[0].msknilai,
              namapptk : jsonData.header[0].idpnspptk,
              namappk : jsonData.header[0].idpnsppk,
              html : html

            });

           $(".enjanuari").click(function() {

              ajaxtoken();
              var row = $(this).closest("tr");    // Find the row
              var stat = row.find(".stat").text();
              var pertama = row.find(".pertama").text(); // Find the text
              var bl = row.find(".bl").text(); // Find the text
              var indexbl = row.find(".indexbl").text(); // Find the text
              var unit = $('#kdunit').html();
              var kdkegunit = $('#kdkeg').html();
              var idtab =  $('#idtab').html();
              var token = localStorage.getItem("token");
              // alert(unit+' '+kdkegunit+' '+idtab);
              $.ajax ({


                url: base_url+"User/cektabrealisasi/"+token,
                type: "POST",
                data: {
                  unitkey : unit,
                  idkeg   : kdkegunit,
                  token   : token,
                  idtab   : idtab
                },
                dataType: "JSON",
                success: function(result){
                  ajaxtoken();
                  if (result.uri[0].kak == false){
                    swal(
                      'info',
                      'Belum Ada Kerangka Acuan Kerja!!!',
                      'info'
                    );
                  }else{
                    if (result.uri[0].status == false){
                      //jika false maka entri
                      var unit = result.uri[0].unit;
                      var kegiatan = result.uri[0].keg;
                      var tab = result.uri[0].tab;
                      if(stat==0){
                         // jika stat 0 maka entri baru jika 1 maka ubah
                         Pace.restart ();
                         Pace.track (function (){
                           $('#modaldafkeg').modal('hide');
                               window.location.href = base_url+"User/realisasipptk?unit="+unit+"&keg="+kegiatan+"&tab="+tab+"&pr="+pertama+"&indexbl="+indexbl+"&bl="+bl+"&ub="+stat;

                           });



                      }else if(stat==1){
                        Pace.restart ();
                        Pace.track (function (){
                          $('#modaldafkeg').modal('hide');

                              window.location.href = base_url+"User/realisasipptk?unit="+unit+"&keg="+kegiatan+"&tab="+tab+"&pr="+pertama+"&indexbl="+indexbl+"&bl="+bl+"&ub="+stat;

                          });


                      }else{
                        console.log('terjadi Kesalahan');
                      }

                     }else{
                      //jika true maka sudah ada
                      swal(
                        'info',
                        'Target Realisasi Pada Kegiatan Ini Sudah di Entri',
                        'info'
                      )
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



            });



            //akhir jsonrealisasi complete
          },
          error: function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR.responseText);
            swal(
              'error',
              'Terjadi Kesalahan, Coba Lagi Nanti',
              'error'
            )
          }
        });
  });

   $(".btnreal").click(function() {
              ajaxtoken();
              var row = $(this).closest("tr");    // Find the row
              var kdkegunit = row.find(".id").text(); // Find the text
              var idtab = row.find(".idtab").text(); // Find the text
              var unit = $('#kdunit').html();
              var token = localStorage.getItem("token");
              $.ajax ({
                url: base_url+"User/cektabrealisasi/"+token,
                type: "POST",
                data: {
                  unitkey : unit,
                  idkeg   : kdkegunit,
                  token   : token,
                  idtab   : idtab
                },
                dataType: "JSON",
                success: function(result){
                  ajaxtoken();
                  if (result.uri[0].kak == false){
                    swal(
                      'info',
                      'Belum Ada Kerangka Acuan Kerja!!!',
                      'info'
                    );
                  }else{
                    if (result.uri[0].status == false){
                      //jika false maka entri
                      var unit = result.uri[0].unit;
                      var kegiatan = result.uri[0].keg;
                      var tab = result.uri[0].tab;
                      window.location.href = base_url+"User/realisasipptklama?unit="+unit+"&keg="+kegiatan+"&tab="+tab;
                     }else{
                      //jika true maka sudah ada
                      swal(
                        'info',
                        'Target Realisasi Pada Kegiatan Ini Sudah di Entri',
                        'info'
                      )
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
        <i class="fa fa-list"></i>
      <h3 class="box-title">List Kegiatan</h3>


      </div>
      <div class="box-body">
          <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-left"  width="2%"><b>#</b></th>

                        <th class="col-xs-5 text-left" >Nama Kegiatan</th>
                        <th class="col-xs-2 text-right" >Pagu Dana</th>
                        <th class=" td-actions text-center" ></th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                                              //<button class="btnreal btn btn-danger">Realisasi lama<div class="ripple-container"></div></button></td>
                                              $i = 0;
                                              foreach ($list as $row){
                                                  $i++;
                                                  echo'<tr>
                                                    <td>'.$i.'</td>
                                                    <td class="idtab" style="display:none;">'.$row['id'].'</td>
                                                     <td class="id" style="display:none;">'.$row['kdkegunit'].'</td>
                                                    <td class="col-xs-5">'.$row['nmkegunit'].'</td>
                                                    <td class="text-right">'.$this->template->rupiah($row['nilai']).'</td>
                                                    <td class=" td-actions text-center">
                                                     <button class="btntf btn btn-success btn-flat">Target Fisik<div class="ripple-container"></div></button>
                                                    <button class="btntk btn bg-blue btn-flat">Target Keuangan<div class="ripple-container"></div>
                                                    </button>
                                                    <button class="btnrl btn btn-danger btn-flat">Realisasi<div class="ripple-container"></div></button>

                                                    </tr>';

                                            }
                                        ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.box-body -->
<div class="box-footer">

</div>
<!-- /.box-footer-->

</div>
<!-- /.box -->

</section>
<div class="modal fade" id="modaldafkeg" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title"></h4>

            </div>

            <div class="modal-body">
               <div class="row">
                        <div class="col-md-12">
                            <!--<div class="card">-->
                            <!--  <div class="card-header card-header-icon" data-background-color="blue">-->
                            <!--        <i class="material-icons">assignment</i>-->
                            <!--    </div>-->
                            <!--  <div class="card-content">-->

                            <!--    <div class="toolbar">-->


                            <!--    </div>-->
                            <!--  <br>-->


                            <!--    </div>-->
                            <!--</div>-->
                            <br>
                            <p id="kdkeg" hidden></p>
                              <p id="idtab" hidden></p>
                                <div class="row">
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: left">

                                    </div>
                                    <div class="col-md-2 col-sm-2 text-muted" style="text-align: left">Nama Kegiatan</div>
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: right;width: 5px">:</div>
                                    <div class="col-md-8 col-sm-8 text-muted" style="padding-left: 25px"><p id="namakegiatan"></p></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: left">

                                    </div>
                                    <div class="col-md-2 col-sm-2 text-muted" style="text-align: left">Nilai Kegiatan</div>
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: right;width: 5px">:</div>
                                    <div class="col-md-8 col-sm-8 text-muted" style="padding-left: 25px"><p id="nilai"></p></div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: left">

                                    </div>
                                    <div class="col-md-2 col-sm-2 text-muted" style="text-align: left">Nama PPTK</div>
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: right;width: 5px">:</div>
                                    <div class="col-md-8 col-sm-8 text-muted" style="padding-left: 25px"><p id="namapptk"></p></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: left">

                                    </div>
                                    <div class="col-md-2 col-sm-2 text-muted" style="text-align: left">Nama KPA</div>
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: right;width: 5px">:</div>
                                    <div class="col-md-8 col-sm-8 text-muted" style="padding-left: 25px"><p id="namappk"></p></div>
                                </div>

                                <br>

                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                                    </div>
                        </div>

                    </div>

            </div>

            <div class="modal-footer modal-footer-tombol">

            </div>
        </div>
    </div>
</div>
