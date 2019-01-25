<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/alertify.min.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/themes/default.min.css') ?>"/>
<script src="<?php echo base_url('assets/alertify/alertify.min.js') ?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/mediajs/jquery.media.js') ?>"></script>


<script type="text/javascript" >

var tb_kegiatan;
$(document).ready(function () {

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

  tb_kegiatan = $('#tb-kegiatan').DataTable({

    initComplete: function() {
      var api = this.api();
      $('#tb-kegiatan_filter input')
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
        searchPlaceholder: "Cari Program / kegiatan..."
    },
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {

      "url": base_url+"Cpanel/jsonkegiatan",
      "type": "POST"
    },
    columns: [
      {
        "data": "kdkegunit",
        "orderable": false
      },
      {
        "data": "NMPRGRM",
        "visible": false, "targets": 1

      },
      {
        "data": "nmkegunit",
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

$("#sinkron-kegiatan").click(function () {
  ajaxtoken();
  var token = localStorage.getItem("token");
    Pace.restart();
    Pace.track(function () {
      // ajax post idopd dan tahun
      $.ajax ({
        url: base_url+"Cpanel/apimkegiatan/",
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
           alertify.success('Data Kegiatan Berhasil Di Sinkronkan');
            //var notification = alertify.notify('Data Unit Berhasil Di Sinkronkan', 'success', 3, function(){
              //nanti pakai javascript
            //    });
            tb_kegiatan.ajax.reload();

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
      <a class="btn btn-block btn-danger" id="sinkron-kegiatan">
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
                                 <h4 class="card-title">List Master Kegiatan</h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->

                                    </div>
                                    <div class="material-datatables">
                                      <table id="tb-kegiatan" class="table table-responsive table-hover" cellspacing="0" width="100%" style="width:100%">
                                       <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Program</th>
                                                    <th>Nama Kegiatan</th>


                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Program</th>
                                                    <th>Nama Kegiatan</th>

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
