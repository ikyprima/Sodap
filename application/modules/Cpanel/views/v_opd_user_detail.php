  <script>
    $( document ).ready(function() {
        $(".select2").select2();
        ajaxgroup();
       var idunit = localStorage.getItem("id_unit");

   /*Datatable untuk User Per OPD*/
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
 tb_opd_user_detail = $('#tb-opd-user-detail').DataTable({
    initComplete: function() {
      var api = this.api();
      $('#tb-opd-user-detail_filter input')
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
        searchPlaceholder: "Cari ASN..."
    },
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {

      "url": base_url+"Cpanel/jsonuserlist_by/"+idunit,
      "type": "POST"
    },
    columns: [
      {
        "data": "id",
        "orderable": false
      },
      {
        "data": "nip",
      },
      {
        "data": "nama",
      },
      {
        "data": "nama_jabatan",
        "orderable": false
      },
      {
        "data": "nama_eselon",
        "orderable": false,
        "visible": false
         // "targets": 1
      },
      {
        "data": "nama_pangkat",
        "orderable": false,
        "visible": false
      },
      {
        "data": "golongan",
        "orderable": false,
        "visible": false
      },
      {
        "data": "active",
        "orderable": false,
         render : function (data, type, row) {
                     return data == '1' ? '<span class="label label-success">Aktif</span>' : data == '0' ? '<span class="label label-danger">Tidak Aktif</span>' : '<span class="label label-warning">Belum Ada</span>'
        },
        "className" : "text-center"
      },
      {
        "data" : "action",
        "orderable": false,
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
       <a class="btn btn-block btn-danger" id="btn-kembali">
        <i class="fa fa-bank"></i> Struktur Organisasi
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
                                 <h4 class="card-title">List User OPD</h4>
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->

                                    </div>

                                     <div class="material-datatables">
                                      <table id="tb-opd-user-detail" class="table table-striped table-no-bordered table-hover dataTable" cellspacing="0" width="100%" style="width:100%">
                                       <thead class="text-info">
                                                <tr>
                                                    <th>No</th>
                                                    <th>NIP</th>
                                                    <th>Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>Esl</th>
                                                    <th>Pangkat</th>
                                                    <th>Gol</th>
                                                    <th>Akun</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    <th>NIP</th>
                                                    <th>Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>Esl</th>
                                                    <th>Pangkat</th>
                                                    <th>Gol</th>
                                                    <th>Akun</th>
                                                    <th>Aksi</th>
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
            <div class="modal fade" id="passwordmodal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
