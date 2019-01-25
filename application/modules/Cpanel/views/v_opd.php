<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/alertify.min.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/themes/default.min.css') ?>"/>
<script src="<?php echo base_url('assets/alertify/alertify.min.js') ?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/mediajs/jquery.media.js') ?>"></script>

<script type="text/javascript">
  var tb_opd;
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


    ajaxtoken();

      tb_opd = $('#tb-opd').DataTable({
        initComplete: function() {
          var api = this.api();
          $('#tb-opd_filter input')
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
            searchPlaceholder: "Cari OPD..."
        },
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {

          "url": base_url+"Cpanel/jsonopd",
          "type": "POST"
        },
        columns: [
          {
            "data": "unitkey",
            "orderable": false
          },
          {
            "data": "nmunit",
          },
          {
            "data" : "action",
            "orderable": false,
            "className" : "td-actions text-center "
          }

        ],
        //rowsGroup: [0], //ini untuk colspan atau grouping
        order: [[1, 'asc']],
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

      $('#tb-opd').on( 'click', 'a.sdpa22', function (){

        var row = $(this).closest('tr');
        if ( row.hasClass('child') ) {
          row = row.prev();
        }
        var kolom = tb_opd.row( row ).data();
        var unitkey = kolom['unitkey'];
        ajaxtoken();
        var token = localStorage.getItem("token");
        Pace.restart ();
        Pace.track (function (){
          // alert('tarik DPA22 '+unitkey);
          $.ajax ({

            url: base_url+"Cpanel/apidpa22/",
            type: "POST",
            data: {
              token   : token,
              unitkey : unitkey
            },
            dataType: "JSON",
            complete: function(data){
              ajaxtoken();
              var jsonData = JSON.parse(data.responseText);
              var status =jsonData.data[0].status;
              if (status == true){
               alertify.success('Data DPA 2.2 Berhasil Di Sinkronkan');
                //var notification = alertify.notify('Data Unit Berhasil Di Sinkronkan', 'success', 3, function(){
                  //nanti pakai javascript
                //    });
                tb_opd.ajax.reload();

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

      $('#tb-opd').on( 'click', 'a.sdpa221', function (){

          var row = $(this).closest('tr');
          if ( row.hasClass('child') ) {
            row = row.prev();
          }
          var kolom = tb_opd.row( row ).data();
          var unitkey = kolom['unitkey'];
          ajaxtoken();
          var token = localStorage.getItem("token");
          Pace.restart ();
          Pace.track (function (){
            // alert('tarik DPA22 '+unitkey);
            $.ajax ({

              url: base_url+"Cpanel/apidpa221/",
              type: "POST",
              data: {
                token   : token,
                unitkey : unitkey
              },
              dataType: "JSON",
              complete: function(data){
                ajaxtoken();
                var jsonData = JSON.parse(data.responseText);
                var status =jsonData.data[0].status;
                if (status == true){
                 alertify.success('Data DPA 2.2 Berhasil Di Sinkronkan');
                  //var notification = alertify.notify('Data Unit Berhasil Di Sinkronkan', 'success', 3, function(){
                    //nanti pakai javascript
                  //    });
                  tb_opd.ajax.reload();

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

      $('#tb-opd').on( 'click', 'a.sangkas', function (){
        var row = $(this).closest('tr');
        if ( row.hasClass('child') ) {
          row = row.prev();
        }
        var kolom = tb_opd.row( row ).data();
        var unitkey = kolom['unitkey'];
        ajaxtoken();
        var token = localStorage.getItem("token");
        Pace.restart ();
        Pace.track (function (){
          // alert('tarik DPA22 '+unitkey);
          $.ajax ({

            url: base_url+"Cpanel/apiangkas/",
            type: "POST",
            data: {
              token   : token,
              unitkey : unitkey
            },
            dataType: "JSON",
            complete: function(data){
              ajaxtoken();
              var jsonData = JSON.parse(data.responseText);
              var status =jsonData.data[0].status;
              if (status == true){
               alertify.success('Data DPA 2.2 Berhasil Di Sinkronkan');
                //var notification = alertify.notify('Data Unit Berhasil Di Sinkronkan', 'success', 3, function(){
                  //nanti pakai javascript
                //    });
                tb_opd.ajax.reload();

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

      $('#tb-opd').on( 'click', 'a.ldpa22', function (){

        var row = $(this).closest('tr');
        if ( row.hasClass('child') ) {
          row = row.prev();
        }
        var kolom = tb_opd.row( row ).data();
        var unitkey = kolom['unitkey'];
        Pace.restart ();
        Pace.track (function (){
          alert('Lihat DPA 22 '+unitkey);
        });

      });

      $('#tb-opd').on( 'click', 'a.ldpa221', function (){

        var row = $(this).closest('tr');
        if ( row.hasClass('child') ) {
          row = row.prev();
        }
        var kolom = tb_opd.row( row ).data();
        var unitkey = kolom['unitkey'];
        Pace.restart ();
        Pace.track (function (){
          alert('Lihat DPA 221 '+unitkey);
        });

      });

      $('#tb-opd').on( 'click', 'a.langkas', function (){

        var row = $(this).closest('tr');
        if ( row.hasClass('child') ) {
          row = row.prev();
        }
        var kolom = tb_opd.row( row ).data();
        var unitkey = kolom['unitkey'];
        Pace.restart ();
        Pace.track (function (){
          alert('Lihat Aliran Kas '+unitkey);
        });

      });

    $("#sinkron-opd").click(function () {
      ajaxtoken();
      var token = localStorage.getItem("token");
        Pace.restart();
        Pace.track(function () {
          // ajax post idopd dan tahun
          $.ajax ({

            url: base_url+"Cpanel/apidaftunit/",
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
               alertify.success('Data Unit Berhasil Di Sinkronkan');
                //var notification = alertify.notify('Data Unit Berhasil Di Sinkronkan', 'success', 3, function(){
                  //nanti pakai javascript
                //    });
                tb_opd.ajax.reload();

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
      <a class="btn btn-block btn-danger" id="sinkron-opd">
        <i class="fa fa-refresh"></i> Sinkron Data
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
                                 <h4 class="card-title">List Master OPD</h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->

                                    </div>
                                    <div class="material-datatables">
                                      <table id="tb-opd" class="table table-striped" >
                                       <thead class="text-info">
                                                <tr>

                                                    <th>No</th>
                                                    <th>Nama Organisasi Perangkat Daerah</th>
                                                    <th  class="td-actions text-center col-sm-4 ">Aksi</th>



                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Organisasi Perangkat Daerah</th>
                                                      <th class="td-actions text-center">Aksi</th>

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
