<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/alertify.min.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/themes/default.min.css') ?>"/>
<script src="<?php echo base_url('assets/alertify/alertify.min.js') ?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/mediajs/jquery.media.js') ?>"></script>
<script type="text/javascript" >

$(document).ready(function () {
  var tb_anggaran;

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

  tb_anggaran = $('#tb-anggaran').DataTable({

    initComplete: function() {
      var api = this.api();
      $('#tb-anggaran_filter input')
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
        searchPlaceholder: "Cari Nama / kode rek..."
    },
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {

      "url": base_url+"Cpanel/jsonanggaran",
      "type": "POST"
    },
    columns: [
      {
        "data": "mtgkey",
        "orderable": false
      },
      {
        "data": "tahun",
        "visible": false, "targets": 1

      },
      {
        "data": "kdper",
      },
      {
        "data": "nmper",
      }
    ],
    //rowsGroup: [0], //ini untuk colspan atau grouping
    order: [[2, 'asc']],
    displayLength: 50,
    //ini untuk menambahkan kolom no di index 0
    rowCallback: function(row, data, iDisplayIndex) {
      var info = this.fnPagingInfo();
      var page = info.iPage;
      var length = info.iLength;
      var index = page * length + (iDisplayIndex + 1);
      $('td:eq(0)', row).html(index);
    },
    drawCallback: function ( settings ) {
      var api = this.api();
      var rows = api.rows( {page:'current'} ).nodes();
      var last=null;
      api.column(1, {page:'current'} ).data().each( function ( group, i ) {
        if ( last !== group ) {
          $(rows).eq( i ).before(
            '<tr class="group"><td colspan="3"><h4><i class="icon fa fa-th-list"></i> '+group+'</h4></td></tr>'
          );
          last = group;
        }
      } );
    }
  });


$("#sinkron-anggaran").click(function () {
  ajaxtoken();
  var token = localStorage.getItem("token");
    Pace.restart();
    Pace.track(function () {
      // ajax post idopd dan tahun
      $.ajax ({
        url: base_url+"Cpanel/apimatangr/",
        type: "POST",
        data: {
          token   : token,
        },
        dataType: "JSON",
        complete: function(data){
          ajaxtoken();
          var jsonData = JSON.parse(data.responseText);
          var status =jsonData.data[0].status;
          if (status == true){
           alertify.success('Data Anggaran Berhasil Di Sinkronkan');
            //var notification = alertify.notify('Data Unit Berhasil Di Sinkronkan', 'success', 3, function(){
              //nanti pakai javascript
            //    });
            tb_anggaran.ajax.reload();

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

});



</script>
<div class="content">

                <div class="container-fluid">
                   <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <a class="btn btn-block btn-info" id="btn-kembali">
        <i class="fa fa-arrow-left"></i> Kembali
      </a>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <a class="btn btn-block btn-danger" id="sinkron-anggaran">
        <i class="fa fa-refresh"></i> Singkron Data
      </a>
    </div>
  </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="blue">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                 <h4 class="card-title">List Master Anggaran</h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->

                                    </div>
                                    <div class="material-datatables">
                                      <table id="tb-anggaran" class="table table-responsive table-hover" cellspacing="0" width="100%" style="width:100%">
                                       <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tahun</th>
                                                    <th>Kode Rekening</th>
                                                    <th>Nama Rekening</th>


                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tahun</th>
                                                    <th>Kode Rekening</th>
                                                    <th>Nama Rekening</th>
                                                </tr>
                                            </tfoot>
                                      </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="modal fade" id="anggaranmodal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <input type="hidden" id="idcsrf" name="idcsrf" value="" />
                                                <div class="modal-dialog modal-notice">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                                                            <h5 class="modal-title"></h5>
                                                        </div>
                                                        <div class="modal-body">
                                                           <form enctype="multipart/form-data" action="#" id="form-generate" role="form">
                                                <div class="row">

                                                <div class="col-sm-4 col-sm-offset-1">
                                                    <div class="picture-container">
                                                        <div class="picture">
                                                            <img src="../../assets/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title="">

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">screen_lock_landscape</i>
                                                        </span>
                                                        <h4 class="info-text" id="gennip" ></h4>
                                                        <!-- <input type="text" class="form-control" id="gennip" name="nip" placeholder="nama" readonly="true"> -->
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">person</i>
                                                        </span>
                                                        <h4 class="info-text" id="gennama"></h4>
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">assignment</i>
                                                        </span>
                                                        <h4 class="info-text" id="genjabatan"></h4>
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">people</i>
                                                        </span>
                                                      <!--  <select  class="form-control select2" style="width: 100%;" id="idgroup" name="idgroup">
                                                        <option value="">Pilih Group</option>
                                                        </select> -->
                                                        <select class="form-control select2" multiple="multiple" id="idgroup" name="groups[]" data-placeholder="Pilih Group" style="width: 100%;">
                                                          </select>
                                                    </div>

                                                </div>

                                            </div>
                                          </form>
                                                        </div>
                                                        <div class="modal-footer">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
