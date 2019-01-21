
var tb_opd_user;
var tb_opd_user_detail;
var tb_opd_dpa;


var tb_list_opd_entri;


function myajax()
        {
            if (window.XMLHttpRequest)
                {
                return new XMLHttpRequest();
                }
            if (window.ActiveXObject)
                {
                return new ActiveXObject("Microsoft.XMLHTTP");
                }
                return null;
        }
var ajaxku=myajax();
function ajaxgroup(){
  var url=base_url+"Cpanel/getnama_group/"+Math.random();

  ajaxku.onreadystatechange=ajaxgroupstate;
  ajaxku.open("GET",url,true);
  ajaxku.send(null);
}
function ajaxgroupstate(){
  var data;
  if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
      document.getElementById("idgroup").innerHTML = data;
    }else{
      document.getElementById("idgroup").value = "<option selected>Pilih Group</option>";
    }
  }
}
function ajaxtoken(){
  var url=base_url+"Cpanel/gettoken/"+Math.random();
  ajaxku.onreadystatechange=ajaxtokenstate;
  ajaxku.open("GET",url,true);
  ajaxku.send(null);
}
function ajaxtokenstate(){
  var data;
  if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){

      localStorage.setItem("token", data);
    }else{
      localStorage.setItem("token", "tokentidakvalid");
    }
  }
}

/*Datatable core*/
$(document).ready(function(){
  $(function () {
    //Initialize Select2 Elements

  $(".select2").select2();
});
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
  /*Data table untuk opd*/

 /*Data table untuk Master program*/

 /*Data table untuk kegiatan*/



 /*Data table untuk anggaran*/

  
  /*Data table untuk OPD pada DPA 2.2*/
tb_opd_dpa = $('#tb-opd-dpa').DataTable({
    initComplete: function() {
      var api = this.api();
      $('#tb-opd-dpa_filter input')
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
        searchPlaceholder: "Cari Unit / OPD..."
    },
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {

      "url": base_url+"Cpanel/jsonopddpa",
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
        "className" : "td-actions text-right"
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

/*Datatable untuk User Per OPD*/
 tb_opd_user = $('#tb-opd-user').DataTable({
    initComplete: function() {
      var api = this.api();
      $('#tb-opd-user_filter input')
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

      "url": base_url+"Cpanel/jsonuseropd",
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
        "className" : "td-actions text-right"
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

/*Datatable untuk dashboard */
 tb_list_opd_entri = $('#list-opd-entri').DataTable({
    initComplete: function() {
      var api = this.api();
      $('#list-opd-entri_filter input')
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

      "url": base_url+"Cpanel/jsonopdentribaru",
      "type": "POST"


    },
    columns: [
      {
        "data": "unitkey",
        "orderable": false
      },
      {
        "data": "nmunit",
        "orderable": false
      },
       {
        "data": "stat",
        "orderable": false,
         render : function (data, type, row) {
                     return data == '3' ? '<span class="label label-danger">Ditolak</span>' :data == '2' ? '<span class="label label-info"><i class="fa fa-flag-o"></i> Belum Konfirmasi</span>' : data == '1' ? '<span class="label label-success">Konfirmasi</span>' : data == '0' ? '<span class="label label-info">Belum Konfirmasi</span>' : '<span class="label label-primary">Belum Ada</span>'
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
    order: [[1, 'asc']],
    displayLength: 10,
    //ini untuk menambahkan kolom no di index 0
    rowCallback: function(row, data, iDisplayIndex) {
      var info = this.fnPagingInfo();
      var page = info.iPage;
      var length = info.iLength;
      var index = page * length + (iDisplayIndex + 1);
      $('td:eq(0)', row).html(index);
    }
  });
$('#datepicker').datetimepicker( {

    format: "YYYY",

    icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }

    });
    //!@#$%^&*AgungAGUNGAGUNG
    $('.modal').on('click', '#btn-modal-batal',  function(e){
      $('.modal').modal('hide');
    });
    //AgungAGUNGAGUNG!@#$%^&*()*&^%
});

$('#list-opd-entri').on( 'click', 'button.entriact', function (){
  var row = $(this).closest('tr');
  if ( row.hasClass('child') ) {
    row = row.prev();
  }
  ajaxtoken();
  var kolom = tb_list_opd_entri.row( row ).data();
  Pace.restart ();
  Pace.track (function (){
    var idunit = kolom['unitkey'];
    var stat    = kolom['stat'];
    var namaunit    = kolom['nmunit'];

    if(stat=='0'){
      // 0 = baru masuk dan belum di komfirmasi admin dalbang -> lanjut untuk acc atau tolak
      var token = localStorage.getItem("token");
      $.ajax ({
        url: base_url+"Cpanel/statnol/"+Math.random(),
        type: "POST",
        data: {
          opd : idunit,
          token :token
        },
        dataType: "JSON",
        complete: function(data){
        var jsonData = JSON.parse(data.responseText);
          if (jsonData.data[0].status == "false"){
            swal(
              'info',
              'Terjadi Kesalahan, Coba Lagi Nanti !!!',
              'info'
            );
          return false;
          }else{
            var html = "";
            id    = jsonData.data[0].id;
            opd   = jsonData.data[0].unit;
            thn   = jsonData.data[0].thn;
            nama  = jsonData.data[0].nama;
            time  = jsonData.data[0].time;
            xstat  = jsonData.data[0].stat;
            if(xstat=='0'){
              stat='Belum di Konfirmasi'
            }
            html += "<div class='table-responsive'><table class='table'> <tbody>";
            html += "<tr>\
                    <td></td>\
                    <th class='text-center info'>PPTK</th>\
                    <th class='text-center danger'>PPK</th>\
                    </tr>";
          for (x in jsonData.data[0].detail) {

            keg  =jsonData.data[0].detail[x].keg;
            pptk =jsonData.data[0].detail[x].pptk;
            ppk  =jsonData.data[0].detail[x].ppk;

              html += "<tr>\
                      <th class='text-left'>"+ keg +"</th>\
                      <td class='text-left info'>"+ pptk +"</th>\
                      <td class='text-left danger'>"+ ppk +"</th>\
                      </tr>";
          }
          html += "</tbody> </table> </div>";
            modaldashboard({
              buttons: {
                batal: {
                  id    : 'btn-entri-batal',
                  css   : 'btn-info btn-raised btn-flat btn-bitbucket',
                  label : 'Batal'
                },
                terima: {
                  id    : 'btn-entri-konfirmasi',
                  css   : 'btn-success btn-raised btn-flat btn-bitbucket',
                  label : 'Konfirmasi'
                },
                tolak: {
                  id    : 'btn-entri-tolak',
                  css   : 'btn-danger btn-raised btn-flat btn-bitbucket',
                  label : 'Tolak'
                }
              },
              title: 'Form Konfirmasi',
              id : id,
              opd : opd+' ('+thn+')',
              admin : nama,
              time : time,
              stat : stat,
              html : html

            });
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

    }else if(stat=='1'){
      // 1 = sudah konfirmasi dan ok , kemudian semua user sudah di acc per opd dan per tahun
     swal(
          'info',
          'Sudah Konfirmasi !!!',
          'info'
          );
    }else if(stat=='2'){
      // 2 = sudah di lihat tapi belum ada proses(cuma dilihat) -> lanjut untuk acc dan tolak
   swal(
          'info',
          'Sudah Konfirmasi baca !!!',
          'info'
          );
    }else if(stat=='3'){
      // 3 = tolak dan perbaiki tambah catatan
     swal(
            'info',
            'Ditolak !!!',
            'info'
          );
    }else{
    swal(
            'info',
            'Unit OPD Tekait Belum Entri !!!',
            'info'
          );
    }

  });

});


$('#tb-opd-user').on( 'click', 'button.btnopduser', function (){
  var row = $(this).closest('tr');
  if ( row.hasClass('child') ) {
    row = row.prev();
  }
  var kolom = tb_opd_user.row( row ).data();

  Pace.restart ();
  Pace.track (function (){
   var idunit    = kolom['unitkey'];
   localStorage.setItem("id_unit", idunit);
   ajaxtoken();
   window.location.href = base_url+"Cpanel/listuserperopd/"+idunit;

  });

});
$('#tb-opd-user-detail').on( 'click', 'button.opduserpass', function (){
  var row = $(this).closest('tr');
  if ( row.hasClass('child') ) {
    row = row.prev();
  }
  var kolom = tb_opd_user_detail.row( row ).data();
  Pace.restart ();
  Pace.track (function (){
    ajaxtoken();
    var nip    = kolom['nip'];
    var nama   = kolom['nama'];
    var jabatan  = kolom['nama_jabatan'];
    var stat    = kolom['active'];
    //generete atau reset

    if(stat=='0'){
      modalcpanelopduser({
        buttons: {
          batal: {
            id    : 'btn-generate-batal',
            css   : 'btn-info btn-raised btn-flat btn-bitbucket',
            label : 'Batal'
          },
          resetuser: {
            id    : 'btn-generate-user',
            css   : 'btn-danger btn-raised btn-flat btn-bitbucket',
            label : 'Reset Password'
          },
          aktifuser: {
            id    : 'btn-generate-aktif',
            css   : 'btn-success btn-raised btn-flat btn-bitbucket',
            label : 'Aktifkan User'
          }
        },
        title: 'Reset Password / Aktifkan User',
        gennip: nip,
        gennama: nama,
        genjabatan: jabatan
      });
    }else if(stat=='1'){
      modalcpanelopduser({
        buttons: {
          batal: {
            id    : 'btn-generate-batal',
            css   : 'btn-info btn-raised btn-flat btn-bitbucket',
            label : 'Batal'
          },
          resetuser: {
            id    : 'btn-generate-reset',
            css   : 'btn-danger btn-raised btn-flat btn-bitbucket',
            label : 'Reset Password'
          },
          nonaktifuser: {
            id    : 'btn-generate-nonaktif',
            css   : 'btn-success btn-raised btn-flat btn-bitbucket',
            label : 'Non Aktifkan User'
          }
        },
        title: 'Reset Password / Non Aktifkan User',
        gennip: nip,
        gennama: nama,
        genjabatan: jabatan
      });
  }else{
      modalcpanelopduser({
      buttons: {
         batal: {
          id    : 'btn-generate-batal',
          css   : 'btn-info btn-raised btn-flat btn-bitbucket',
          label : 'Batal'
        },
        genuser: {
          id    : 'btn-generate-user',
          css   : 'btn-danger btn-raised btn-flat btn-bitbucket',
          label : 'Generate User Baru'
        }
      },
      title: 'Generate Username dan Password',
      gennip: nip,
      gennama: nama,
      genjabatan: jabatan
    });
  }
  });
});

$('#tb-opd-user-detail').on( 'click', 'button.opduserinfo', function (){
  var row = $(this).closest('tr');
  if ( row.hasClass('child') ) {
    row = row.prev();
  }
  var kolom = tb_opd_user_detail.row( row ).data();

  Pace.restart ();
  Pace.track (function (){
  var nip    = kolom['nip'];
  alert(nip+" Info");

  });

});

$('#tb-opd-dpa').on( 'click', 'button.btndpa', function (){
  var row = $(this).closest('tr');
  if ( row.hasClass('child') ) {
    row = row.prev();
  }
  var kolom = tb_opd_dpa.row( row ).data();
  ajaxtoken();
  Pace.restart ();
  Pace.track (function (){
    modal({
      buttons: {
        filter: {
          id    : 'btn-filter-dpa',
          css   : 'btn-danger btn-raised btn-flat btn-bitbucket',
          label : 'Filter'
        }
      },
      title: 'Pilih Tahun Anggaran',
      idunit    : kolom['unitkey'],
    });
  });
});

function modal(data) {

  // Set modal title
  $('.modal-title').html(data.title);
  // Clear buttons except Batal
  $('.modal-footer button:not(".btn-default")').remove();
  // Set input values

  $('#idunit').val(data.idunit);
  // Create Butttons
  $.each(data.buttons, function(index, button){
    $('.modal-footer').prepend('<button type="button" id="' + button.id  + '" class="btn ' + button.css + '">' + button.label + '</button>')
  })
  //Show Modal
  $('.modal').modal('show');
}
function modalcpanelopduser(data) {
  /*modal Cpanel/opduser*/
  // Set modal title
  $('.modal-title').html(data.title);
  $('#gennip').html(data.gennip);
  $('#gennama').html(data.gennama);
  $('#genjabatan').html(data.genjabatan);

  // Clear buttons except Cancel
  $('.modal-footer button:not(".btn-default")').remove();

  // Create Butttons
  $.each(data.buttons, function(index, button){
    $('.modal-footer').prepend('<button type="button" id="' + button.id  + '" class="btn ' + button.css + '">' + button.label + '</button>')
  })

  //Show Modal
  $('#passwordmodal').modal('show');

}
function modaldashboard(data) {
  /*modal Cpanel/dashboard*/
  // Set modal title
  $('.modal-title').html(data.title);
  $('#idopd').html(data.id);
  $('#namadinas').html(data.opd);
  $('#admin').html(data.admin);
  $('#time').html(data.time);
  $('#status').html(data.stat);
  $('#list').html(data.html);
  // document.getElementById("listmsn").innerHTML = data.html;
  // Clear buttons except Cancel
  $('.modal-footer-tombol button:not(".btn-default")').remove();

  // Create Butttons
  $.each(data.buttons, function(index, button){
    $('.modal-footer-tombol').prepend('<button type="button" id="' + button.id  + '" class="btn ' + button.css + '">' + button.label + '</button>')
  })

  //Show Modal
  $('#dashboardmodal').modal('show');

}

$('.modal').on('click', '#btn-filter-dpa',  function(e){
  // var idtoken= $('#csrf').val();
  //   alert(csrfHash+"dan"+idtoken);

  if(validator(['datepicker'])) {
  Pace.restart ();
  Pace.track (function (){
    var tahun = $('#datepicker').val();
    var idunit= $('#idunit').val();
    var idtoken= localStorage.getItem("token");
    $.ajax ({
      url: base_url+"Cpanel/cekopddpadetail/"+Math.random(),
      type: "POST",

      data: {
        thn : tahun,
        idunt : idunit,
        token : idtoken


      },
      dataType: "JSON",
      complete: function(data){
        var jsonData = JSON.parse(data.responseText);
        if (jsonData.data[0].status == "false"){
          swal(
            'info',
            'Tidak ada Data di Tahun '+tahun+' !!!',
            'info'
          );
          ajaxtoken();
        }else{
           window.location.href = base_url+"Cpanel/opddpadetail/"+tahun+"/"+idunit;

        }

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
  }
});


$('#dashboardmodal').on('hidden.bs.modal',  function(){
  ajaxtoken();
 tb_list_opd_entri.ajax.reload();
});

$('#dashboardmodal').on('click', '#btn-entri-batal',  function(e){
  Pace.restart ();
  Pace.track (function (){
    $('#dashboardmodal').modal('hide');
    });
});

$('#dashboardmodal').on('click', '#btn-entri-konfirmasi',  function(e){
  ajaxtoken();
  var id=$('#idopd').html();
  swal({
    title: 'Konfirmasi',
    text: "Simpan Kegiatan ?",
    type: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger',
    confirmButtonText: 'Yes, Confirm!',
    buttonsStyling: false
  }).then(function() {
    Pace.restart ();
    Pace.track (function (){
    var token = localStorage.getItem("token");
    $.ajax ({
      url: base_url+"Cpanel/konfirmasientri/"+Math.random(),
      type: "POST",
      data: {
        id : id,
        token :token
      },
      dataType: "JSON",
      success: function(result){
        swal({
          title: 'Tersimpan!',
          text: 'Sukses Konfirmasi.',
          type: 'success',
          confirmButtonClass: "btn btn-success",
          buttonsStyling: false
        }).then(function() {
          /*jika suskser direct ke */
         $('#dashboardmodal').modal('hide');
        });
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
  });
  });
});

$('#dashboardmodal').on('click', '#btn-entri-tolak',  function(e){

  $('#modaltolak').modal('show');

});

$('#passwordmodal').on('click', '#btn-generate-batal',  function(e){
  Pace.restart ();
  Pace.track (function (){
    $('#passwordmodal').modal('hide');
    });
});
$('#passwordmodal').on('click', '#btn-generate-user',  function(e){
  Pace.restart ();
  Pace.track (function (){
    var nip=$('#gennip').html();

    var token = localStorage.getItem("token");
    var formData = new FormData($('#form-generate')[0]);
    //tambah field ke formData
    formData.append("nip",nip);
    formData.append("token",token);
    $.ajax({
      url: base_url+"Cpanel/generateuser",
      type: 'POST',
      data: formData,
      mimeType: "multipart/form-data",
      contentType: false,
      cache: false,
      processData: false,
      success: function(result){
          ajaxtoken();
          $('#passwordmodal').modal('hide');
          tb_opd_user_detail.ajax.reload();
          $('#form-generate')[0].reset();
          $("#idgroup").select2({
            allowClear: true
          });

      },
      error: function(jqXHR, textStatus, errorThrown){
        alert('Error adding / update data');
      }
    });


    });
});
$('#passwordmodal').on('hidden.bs.modal', function () {

})
function hide_notify()
    {
        setTimeout(function() {
                    $('.error').removeClass('alert-success').text('');
                }, 2000);
    }

function validator(elements) {
  var errors = 0;
  $.each(elements, function(index, element){
    if($.trim($('#' + element).val()) == '') errors++;
  });
  if(errors) {
    //$('.error').html('Please insert title and description');
    // $('.error').addClass('alert-danger').text('Pilih Tahun !');

    // hide_notify();
   swal(
            'info',
            'Pilih Tahun !!!',
            'info'
          )
    return false;

  }
    return true;
}


/*Button kembali atau back pada browser*/

$('#btn-kembali').click(function(){

    window.history.back();

});

//add user baru
$('#add-users').click(function(){
  Pace.restart ();
  Pace.track (function (){
      window.location.href = base_url+"Cpanel/create";
    });
});
