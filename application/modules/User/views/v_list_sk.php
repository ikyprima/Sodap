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
<!-- include a theme -->
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/themes/default.min.css') ?>"/>
<!-- include the script -->
<link href="<?php echo base_url('assets/admin/plugins/bootstrap-fileinput-master/css/fileinput.css') ?>" media="all" rel="stylesheet" type="text/css"/>
<!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous"> -->
<link href="<?php echo base_url('assets/admin/plugins/bootstrap-fileinput-master/themes/explorer-fas/theme.css') ?>" media="all" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url('assets/admin/plugins/bootstrap-fileinput-master/js/plugins/sortable.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/bootstrap-fileinput-master/js/fileinput.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/bootstrap-fileinput-master/js/locales/id.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/bootstrap-fileinput-master/themes/fas/theme.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/bootstrap-fileinput-master/themes/fa/theme.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/bootstrap-fileinput-master/themes/explorer-fas/theme.js') ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/alertify/alertify.min.js') ?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/mediajs/jquery.media.js') ?>"></script>

<script type="text/javascript">
  var tb_sk;
    $(document).ready(function () {

      ajaxtoken();
      /*Datatable untuk List SK*/
      $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
        return{
          "iStart": oSettings._iDisplayStart,
          "iEnd": oSettings.fnDisplayEnd(),
          "iLength": oSettings._iDisplayLength,
          "iTotal": oSettings.fnRecordsTotal(),
          "iFilteredTotal": oSettings.fnRecordsDisplay(),
          "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
          "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
      };
      var idm='<?php echo $id_m; ?>';
      var idunit='<?php echo $idopd; ?>';
      tb_sk = $('#tb-sk').DataTable({
        initComplete: function() {
          var api = this.api();
          $('#tb-sk_filter input')
          .off('.DT')
          .on('keyup.DT', function(e) {
            if (e.keyCode == 13) {
              api.search(this.value).draw();
            }
          });
        },
        language: {
          sProcessing: "loading...",
          search: "_INPUT_",
          searchPlaceholder: "Cari Kegiatan..."
        },
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            "url": base_url+"User/json_detail_sk/"+idm,
            "type": "POST"
        },
        columns: [
          {
            "data": "id",

          },
          {
            "data": "kdkegunit",
            "orderable": false,
            "searchable"    : false,
            "visible": false
          },
          {
            "data": "nmkegunit",
          },
          {
            "data": "idpnspptk",
          },
          {
            "data": "idpnsppk",
          },
          {
            "data": "status",
            "orderable": false,
            "searchable"    : false,
            "visible": false,
            render : function (data, type, row) {
              return data == '1' ? '<span class="label label-success">Aktif</span>' : data == '0' ? '<span class="label label-danger">Tidak Aktif</span>' : '<span class="label label-warning">Belum Ada</span>'
            },
            "className" : "text-center"
          },
          {
            "data" : "action",
            "orderable": false,
            "searchable"    : false,
            "className" : "td-actions text-center"
          }
        ],
          //rowsGroup: [0], //ini untuk colspan atau grouping
          // order: [[4, 'asc']],
          displayLength: 50,
          //ini untuk menambahkan kolom no di index 0
          rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
          }
        });

        $('#tb-sk tbody').on( 'click', 'button.edit-sk', function (){
          var row = $(this).closest('tr');
          if ( row.hasClass('child') ) {
            row = row.prev();
          }
        //  ajaxtoken();
          var kolom = tb_sk.row( row ).data();
          var kdkeg = kolom['kdkegunit'];
          var id    = kolom['id'];
          //ajax
          var token = localStorage.getItem("token");
          $.ajax ({
            url: base_url+"User/get_sk_kpa_pptk/"+Math.random(),
            type: "POST",
            data: {
              idunit  : idunit,
              idm     : idm,
              idkeg   : kdkeg,
              token   : token
            },
            dataType: "JSON",
            complete: function(data){

              ajaxtoken();
              var jsonData = JSON.parse(data.responseText);
            //  console.log(jsonData.data[0].ppk);

              var namakegiatan =jsonData.data[0].nmkegunit;
              var html  = '';
              var listpptk = '';
              var listppk = '';
                  html += '<div class="row">\
                   <div class="col-md-1 col-sm-1 col-xs-12">\
                   </div>\
                   <div class="col-md-2 col-sm-2 col-xs-12">\
                    <h4 class="text-left text-muted">Nama Kegiatan</h4>\
                  </div>\
                  <div class="col-md-1 col-sm-1 col-xs-12">\
                   <h4 class="text-center text-muted">:</h4>\
                 </div>\
                 <div class="col-md-6 col-sm-8 col-xs-12">\
                   <h4 class="text-left text-muted">'+namakegiatan+'</h4>\
                 </div>\
                 <div class="col-md-2 col-sm-2 col-xs-12">\
                 </div>\
               </div>\
               <div class="row">\
                <div class="col-md-1 col-sm-1 col-xs-12">\
                </div>\
                <div class="col-md-2 col-sm-2 col-xs-12">\
                 <h4 class="text-left text-muted">Nama PPTK</h4>\
               </div>\
               <div class="col-md-1 col-sm-1 col-xs-12">\
                <h4 class="text-center text-muted">:</h4>\
              </div>\
              <div class="col-md-6 col-sm-8 col-xs-12">\
                  <select class="form-control select2" style="width: 100%;" id="pptk">';
                  var nippptklama= jsonData.data[0].nippptklama;


                  for (x in jsonData.data[0].pptk) {

                        var nip = jsonData.data[0].pptk[x].nip;
                        var nama = jsonData.data[0].pptk[x].nama;
                        if (nippptklama==nip){
                          listpptk +='<option selected="selected" value='+nip+'>'+nama+'</option>';
                        }else{
                          listpptk +='<option value='+nip+'>'+nama+'</option>';
                        }
                    }
                 html +=listpptk;
                html += '</select>\
              </div>\
              <div class="col-md-2 col-sm-2 col-xs-12">\
              </div>\
            </div>\
            <div class="row">\
             <div class="col-md-1 col-sm-1 col-xs-12">\
             </div>\
             <div class="col-md-2 col-sm-2 col-xs-12">\
              <h4 class="text-left text-muted">Nama KPA</h4>\
            </div>\
            <div class="col-md-1 col-sm-1 col-xs-12">\
             <h4 class="text-center text-muted">:</h4>\
           </div>\
           <div class="col-md-6 col-sm-8 col-xs-12">\
           <select class="form-control select2" style="width: 100%;" id="ppk">';
           var nipppklama= jsonData.data[0].nipppklama;


           for (x in jsonData.data[0].ppk) {

                 var nip = jsonData.data[0].ppk[x].nip;
                 var nama = jsonData.data[0].ppk[x].nama;
                 if (nipppklama==nip){
                   listppk +='<option selected="selected" value='+nip+'>'+nama+'</option>';
                 }else{
                   listppk +='<option value='+nip+'>'+nama+'</option>';
                 }
             }
          html +=listppk;

           html +='</select>\
           </div>\
           <div class="col-md-2 col-sm-2 col-xs-12">\
           </div>\
         </div>';
              //console.log( jsonData.data[0].nmkegunit);
              alertify.confirm().destroy();

              alertify.confirm()

              .set({
                'resizable':true,
                'movable': false,
                'transition':'zoom',
                'title':'Ubah PPTK-KPA',
                'labels': {
                  ok:'Simpan', cancel:'Batal'
                },
                onok: function(){
                    ajaxtoken();
                    var token = localStorage.getItem("token");
                    $.ajax ({
                      url: base_url+"User/update_det_eska/"+Math.random(),
                      type: "POST",
                      data: {
                        id      : id,
                        pptk    : $('#pptk').val(),
                        ppk     : $('#ppk').val(),
                        token   : token
                      },
                      dataType: "JSON",
                      complete: function(data){
                        ajaxtoken();
                        var jsonData = JSON.parse(data.responseText);
                        var status =jsonData.data[0].status;
                        if (status == true){
                          alertify.success('Data Berhasil Di Ubah, Silahkan Upload SK Terbaru');
                          tb_sk.ajax.reload();
                        }else{
                          alertify.error('Gagal Ubah Data');

                        }

                      },
                      error: function(jqXHR, textStatus, errorThrown){
                        ajaxtoken();
                        alertify.error('Gagal Ubah Data');
                        // alertify.destroy();
                      }

                    });

                 }
              })
              .resizeTo('70%','50%')
              // .setContent(jsonData.data[0].nmkegunit).show();
              .setContent(html).show();
              $(".select2").select2({
                  placeholder: "* Pilih Nama Pejabat",

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


      $('a.lihat').on("click",function(){
        var pathid =  $(this).data("id");
        // var username = $(this).data("username");
       // alertify.dialog('confirm')
       // .setting({
       //   'transition':'zoom',
       //
       //   'title':'Lihat Dokumen'
       //
       // })
       // .set('resizable',true)
       // .resizeTo('80%','90%')
       // .setContent('<a class="media" href='+base_url+'assets/dokumen/'+pathid+'></a>')
       // .show();
        // alertify.confirm()
        // .set('resizable',true)
        // .resizeTo('80%','70%')
        // .setContent('<h1> Hello World! </h1>').show();
        //alertify.alert('Resized to 100%,250px').set('resizable',true).resizeTo('80%',100);
        // alertify.dialog('confirm')
        // .setting({
        //
        //   'transition':'zoom',
        //
        //   'title':'Lihat Dokumen',
        //   'startMaximized':true
        //
        // })
        // .set('labels', {ok:'Alright!', cancel:'Naa!'})
        //
        // .setContent('<a class="media" href='+base_url+'assets/dokumen/'+pathid+'></a>')
        // .show();
        alertify.alert().destroy();
        alertify.alert()
        .setting({
          'transition':'fade',
          'title':'Lihat Dokumen',
          'autoReset': true

        })
        .set({
            'startMaximized':true,
          })
        .setContent('<a class="media" href='+base_url+'assets/dokumen/'+pathid+'></a>')
        .show();
        $('.media').media({width: '100%', height: 500});
    });

    $('a.ubah-dokumen').on("click",function(){
      var html='';
        html +='<form id="formdokumen" enctype="multipart/form-data" role="form" autocomplete="off">\
              <div class="row">\
                <div class="col-md-2 col-sm-2 col-xs-12">\
                </div>\
                <div class="col-md-8 col-sm-8 col-xs-12">\
                  <div class="form-group">\
                    <label>Nama Dokumen</label>\
                    <input type="text" name="nmdok" id="input" class="form-control" placeholder="* harus isi">\
                  </div>\
                </div>\
                <div class="col-md-2 col-sm-2 col-xs-12">\
                </div>\
              </div>\
              <br>\
              <div class="row">\
              <div class="col-md-2 col-sm-2 col-xs-12">\
              </div>\
              <div class="col-md-8 col-sm-8 col-xs-12">\
              <div class="form-group">\
                  <div class="file-loading">\
                      <input name="userfile" id="file-1" class="file" type="file" data-theme="fa">\
                  </div>\
              </div>\
              </div>\
              <div class="col-md-2 col-sm-2 col-xs-12">\
              </div>\
              </div>\
              </form>';
      alertify.alert().destroy();

      alertify.confirm()

      .set({
        'resizable':true,
        'movable': false,
        'transition':'zoom',
        'title':'Perbaharui Dokumen SK',
        'labels': {
          ok:'Simpan Dokumen', cancel:'Batal'
        },
        onok: function(){
          ajaxtoken();
          var vidFileLength = $("#file-1")[0].files.length;
          var inp = $('#input').val();
          if (inp === '') {
           alertify.error('Silahkan Isi Nama Dokumen');
           return false;
         }else if(vidFileLength === 0){
              alertify.error('Silahkan Pilih Dokumen');
              return false;
          }else{
            var token = localStorage.getItem("token");
            var formData = new FormData($('#formdokumen')[0]);
            formData.append("idm",idm);
            formData.append("token",token);
            $.ajax({
              url: base_url+"User/update_dokumen_eska",
              type: 'POST',
              data: formData,
              mimeType: "multipart/form-data",
              contentType: false,
              cache: false,
              processData: false,
              complete: function(data){
                ajaxtoken();
                var jsonData = JSON.parse(data.responseText);
                var status =jsonData.data[0].status;
                var pesan =jsonData.data[0].pesan;

                if (status == true){
                //  alertify.success(pesan);
                  var notification = alertify.notify(pesan, 'success', 3, function(){
                    //nanti pakai javascript
                    location.reload(true);
                  });
                }else{
                  // alertify.error(pesan);
                  var notification = alertify.notify(pesan, 'error', 3, function(){
                    // console.log('dismissed');
                  });
                  ajaxtoken();
                  return false;
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
          }
        }
      })
      .resizeTo('60%','85%')
      // .setContent(jsonData.data[0].nmkegunit).show();
      .setContent(html).show();
      $("#file-1").fileinput({
       // you must set a valid URL here else you will get an error
          allowedFileExtensions: ['pdf'],
          overwriteInitial: false,
          maxFileSize: 3072,
          maxFilesNum: 1,
          showUpload:true,
          language: 'id',

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

          <a class="btn btn-block btn-social bg-blue btn-flat" >
            <i class="fa fa-history"></i> History Perubahan SK
          </a>
        </div>



      </div>
      <br>


<!-- Default box -->

<div class="box box-primary">
    <div class="box-header with-border">
        <i class="fa fa-list"></i>
      <h3 class="box-title">List SK</h3>


      </div>
      <div class="box-body">

       <div class="row">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
         <h4 class="text-left text-muted">Tanggal Entri</h4>
       </div>
       <div class="col-md-1 col-sm-1 col-xs-12">
        <h4 class="text-center text-muted">:</h4>
      </div>
      <div class="col-md-6 col-sm-8 col-xs-12">
        <h4 class="text-left text-muted"><?php echo $tgl_entri_m ?></h4>
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
      </div>
    </div>
       <div class="row">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
         <h4 class="text-left text-muted">Admin Entri</h4>
       </div>
       <div class="col-md-1 col-sm-1 col-xs-12">
        <h4 class="text-center text-muted">:</h4>
      </div>
      <div class="col-md-6 col-sm-8 col-xs-12">
        <h4 class="text-left text-muted"><?php echo $nama_entri_m ?></h4>
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
      </div>
    </div>
       <div class="row">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
         <h4 class="text-left text-muted">Status</h4>
       </div>
       <div class="col-md-1 col-sm-1 col-xs-12">
        <h4 class="text-center text-muted">:</h4>
      </div>

      <div class="col-md-6 col-sm-8 col-xs-12">
        <h4 class="text-left text-muted"><?php echo $stat_m ?></h4>
      </div>
      <div class="col-md-2 col-sm-2 col-xs-12">
      </div>
    </div>
    <div class="row">
     <div class="col-md-1 col-sm-1 col-xs-12">
     </div>
     <div class="col-md-2 col-sm-2 col-xs-12">
      <h4 class="text-left text-muted">Dokumen</h4>
    </div>
    <div class="col-md-1 col-sm-1 col-xs-12">
     <h4 class="text-center text-muted">:</h4>
   </div>

   <div class="col-md-6 col-sm-8 col-xs-12">
     <ul class="mailbox-attachments clearfix">
       <li>
         <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

         <div class="mailbox-attachment-info">
           <a href="javascript:void(0)" class="lihat mailbox-attachment-name" data-id=<?php echo $path?>><i class="fa fa-paperclip"></i><?php echo ' '.$path?></a>
               <span class="mailbox-attachment-size">
                <?php
                $file_path = FCPATH . 'assets/dokumen/'.$path;
              //  $size      = filesize($file_path);
                echo $this->template->filesize_formatted($file_path);
                echo "<br>";
                echo $dokumen;
                ?>

                 <a href="<?php echo base_url().'User/download_sk/'.$path ?>" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                 <a href="javascript:void(0)" class="ubah-dokumen btn btn-default btn-xs pull-right"><i class="fa fa-pencil"></i></a>

               </span>
         </div>
       </li>



     </ul>
   </div>
   <div class="col-md-2 col-sm-2 col-xs-12">
   </div>
 </div>

    <hr>
          <div class="table-responsive">
            <table class="table table-striped"  id="tb-sk">
                <thead>
                    <tr>
                        <th class="text-left"  width="2%"><b>#</b></th>
                        <th class="col-xs-1 text-left" >Id Kegiatan</th>
                        <th class="col-xs-6 text-left" >Nama Kegiatan</th>
                        <th class="col-xs-2 text-left" >Nama PPTK</th>
                        <th class="col-xs-2 text-left" >Nama KPA</th>
                        <th class="col-xs-1 text-left" >Status</th>
                        <th class="col-xs-1 td-actions text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

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
