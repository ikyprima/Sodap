<!-- include the style -->
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/alertify.min.css') ?>"/>
<!-- include a theme -->
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/themes/default.min.css') ?>"/>
<script src="<?php echo base_url('assets/alertify/alertify.min.js') ?>"></script>
<script type="text/javascript">
  var jumlah=0;
  var tblbelanjamodal;


  $(document).ready(function() {

  //rizky.init();
  ajaxtoken();
  $(".select2").select2();
  var bulan = {'January':'0','February':'1','March':'2','April':'3','May':'4','June':'5','July':'6','August':'7','September':'8','October':'9','November':'10','December':'11'};
  var intbulan = {'0':'January','1':'February','2':'March','3':'April','4':'May','5':'June','6':'July','7':'August','8':'September','9':'October','10':'November','11':'December'};
  var awalbln =0;
  var akhirbln=0;
  var kdunit  = $('#kdunit').html();
  var kdkeg   = $('#idkegiatan').html();

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
 tblbelanjamodal = $('#tbl-list-bmodal').DataTable({
// dom: '<"toolbar">frtip',
  bPaginate: true,
   bLengthChange: true,
   bFilter: true,
   bInfo: true,
   bAutoWidth: false,
   initComplete: function() {

     var api = this.api();
     $('#tbl-list-bmodal_filter input')
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
       searchPlaceholder: "Cari Belanja Modal..."
   },

   responsive: true,
   processing: true,
   serverSide: true,
   ajax: {
     "url": base_url+"User/jsonlistbmodal_spesial/"+kdunit+"/"+kdkeg,
     "type": "POST",

   },

   columns: [
     {
       "data": "kdkegunit",
       "orderable": false,
       "searchable": false
     },
     {
       "data": "mtgkey",
       "orderable": false,
       "visible": false,
       "searchable": false
     },
     {
       "data": "kdper",
       "orderable": false,
       "visible": false
     },
     {
       "data": "nmper",
           "visible": false,
            "targets": 3
     },
     {
       "data": "kdjabar",
      //  render : function (data, type, row) {
      //           return '<p>'+data+'</p>'
      // }
       // style="margin-left:4.3em"
     },
     {
       "data": "uraian",
       render : function (data, type, row) {
                return '<p  style="margin-left:1em">'+data+'</p>'
      }
     },
     {
       "data": "ada",
       "orderable": false,
        render : function (data, type, row) {
                 return data == '1' ? '<button type="button" class="btnkak btn btn-block btn-primary btn-flat disabled"data-toggle="tooltip"\
                             title="Target Belanja Modal Sudah Di entri">Entri Target <i class="fa fa-check text-success"></i></button>'  : '<button type="button" class="btnblnjamodal btn btn-block btn-primary btn-flat" data-toggle="tooltip"\
                             title="Target Belanja Modal Belum di Tetapkan">Entri Targget <i class="fa fa-hourglass-start text-danger"></i></button>'
       },
       "className" : "text-center",
       "searchable": false
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
   },
   drawCallback: function ( settings ) {

         var api = this.api();
         var rows = api.rows({
             page: 'current'
         }).nodes();
         var last = null;
         api.column(2, {
             page: 'current'
         }).data().each(function (group, i) {
             if (last !== group) {

                 $(rows).eq(i).before(
                 $("<tr></tr>", {
                     "class": "group",
                     "data-id": group
                 }).append($("<td colspan= 2 ><p style='margin-left:3.4em'>"+group+"</p></td>")).append($("<td></td>", {
                     "id": "e" + group,
                     "class": "namarek",
                     "text": api.row(api.row($(rows).eq(i)).index()).data().nmper,
                     "colspan" : "2"

                 })).prop('outerHTML'));
                 last = group;
             }
             // val = api.row(api.row($(rows).eq(i)).index()).data();
             // $("#e" + val.mtgkey).text(val.mtgkey);

         });
     }
 });

  $('#tbl-list-bmodal').on( 'click', 'button.btnblnjamodal', function (){
  var row = $(this).closest('tr');
  if ( row.hasClass('child') ) {
    row = row.prev();
  }
  var kolom = tblbelanjamodal.row( row ).data();

  Pace.restart ();
  Pace.track (function (){


      var kdkegunit = kolom['kdkegunit'];
      var mtgkey = kolom['mtgkey'];
      var unit = $('#kdunit').html();
      var tabppk = $('#idtabpptk').html();
      var awalthun = $('#tahunawal').html();
      var awalblan = $('#bulanawal').html() ;
      var akhirthn = $('#tahunakhir').html();
      var akhirblan = $('#bulanakhir').html() ;
      var fixawalbulan= parseInt(awalblan,10)-1;
      var fixakhirbulan= parseInt(akhirblan,10)-1;
      var token = localStorage.getItem("token");
       $('#awalkegfisik').datepicker({
        format: "MM yyyy",
        language: "id",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
        startDate: new Date(awalthun, fixawalbulan, '01'),
        endDate: new Date(akhirthn, fixakhirbulan, '01')
      }).on("input change", function (e) {
          // string jadi array

        var namabln =this.value;
        var convert = namabln.split(" ");
        $('#akhirkegfisik').datepicker('setDate', null);
        $('#akhirkegfisik').datepicker('destroy');
        $(".tabel-bulan tbody").empty();
        awalbln=0;
        akhirbln=0;
        awalbln = bulan[convert[0]];

          $('#akhirkegfisik').datepicker({
            format: "MM yyyy",
            viewMode: "months",
            minViewMode: "months",
            autoclose: true,
            startDate: new Date(awalthun, awalbln, '01'),
            endDate: new Date(akhirthn, fixakhirbulan, '01'),

          }).on("input change", function (e) {

            var namabln2 =this.value;
            var convert2 = namabln2.split(" ");

            akhirbln=0;
            akhirbln = bulan[convert2[0]];
            $(".tabel-bulan tbody").empty();
          });
        });
        modaltargetfisik({
              buttons: {

                 simpan: {
                  type : 'submit',
                  id    : 'btn-modal-simpan',
                  css   : 'btn-success btn-raised btn-flat ',
                  label : 'Simpan'
                }
              },
              title: 'Entri Target Fisik',
              mgkey : mtgkey


            });
  });

  });
var tabeluraian;
var kontenuraian;

$('#btn-list-uraian').click(function(){
  kontenuraian = '';
  kontenuraian +=  '<div class="table-responsive">  '  +
 '       <table id="tbl-list-uraian" class="table table-bordered table-striped">  '  +
 '         <thead>  '  +
 '           <tr>  '  +
 '             <th class="text-left"  width="2%"><b>#</b></th>  '  +
 '             <th class="col-xs-3 text-left" >Kode Rekening</th>  '  +
 '             <th class="col-xs-4 text-left" >Nama Rekening</th>  '  +
 '             <th class="col-xs-4 text-left" >Uraian</th>  '  +
 '             <th class=" td-actions text-center" >Aksi</th>  '  +
 '           </tr>  '  +
 '         </thead>  '  +
 '       </table>  '  +
 '  </div>  ' ;
  alertify.alert().destroy();

  alertify.alert()
  .setHeader('List Uraian Kegiatan')
  .set({
    'resizable':true,
    'movable': false,
    'autoReset': true,
    'transition':'zoom',
    'labels': {
      ok:'Simpan', cancel:'Tutup'
    },
    'startMaximized':false,

    onok: function(){

    }
  })
  .resizeTo('80%','84%')
  .setContent(kontenuraian).show();
  tabeluraian = $('#tbl-list-uraian').DataTable({

 // dom: '<"toolbar">frtip',
   bPaginate: true,
    bLengthChange: false,
    bFilter: true,
    bInfo: true,
    bAutoWidth: false,
    initComplete: function() {

      var api = this.api();
      $('#tbl-list-uraian_filter input')
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
        searchPlaceholder: "Cari Kegiatan / Uraian..."
    },

    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {
      "url": base_url+"User/jsonlisturaian_spesial/"+kdunit+"/"+kdkeg,
      "type": "POST",

    },

    columns: [
      {
        "data": "id",
        "orderable": false,
        "searchable": false
      },
      {
        "data": "rekeningfull",

      },
      {
        "data": "nmrek",

      },
      {
        "data": "uraian",

      },
      {
        "data": "action",
        "orderable": false,

        "className" : "text-center",
        "searchable": false
      }

    ],


    //rowsGroup: [0], //ini untuk colspan atau grouping
    // order: [[4, 'asc']],
    displayLength: 5,
    //ini untuk menambahkan kolom no di index 0
    rowCallback: function(row, data, iDisplayIndex) {
      var info = this.fnPagingInfo();
      var page = info.iPage;
      var length = info.iLength;
      var index = page * length + (iDisplayIndex + 1);
      $('td:eq(0)', row).html(index);
    },

  });
  $('#tbl-list-uraian').on( 'click', 'a.tambahmodal', function (){

  var row = $(this).closest('tr');
  if ( row.hasClass('child') ) {
    row = row.prev();
  }
  var kolom = tabeluraian.row( row ).data();
  //kolom['dataname']
  ajaxtoken();
  var token = localStorage.getItem("token");
  var iddpa = kolom['id'];
  Pace.restart ();
  Pace.track (function (){
    $.ajax ({

       url: base_url+"User/tambahmodal/"+Math.random(),
       type: "POST",
       data: {

         token   : token,
         iddpa   : iddpa
       },
     dataType: "JSON",
     complete: function(data){
       ajaxtoken();
       var jsonData = JSON.parse(data.responseText);
       var status =jsonData.data[0].status;
       var ada =jsonData.data[0].ada;
       if (status == false && ada == 1 ){
         // alertify.success('Data Program dan Kegiatan Berhasil Di Sinkronkan');
         var notification = alertify.notify('Uraian sudah ada di list', 'error', 3, function(){
           //nanti pakai javascript

         });
       }else if (status == true && ada == 0) {
         alertify.alert().destroy();
         tblbelanjamodal.ajax.reload();
         // alertify.success('Data Program dan Kegiatan Berhasil Di Sinkronkan');
         // var notification = alertify.notify('Berhasil Tambah List ', 'success', 3, function(){
         //   //nanti pakai javascript
         //
         // });
            alertify.success('Berhasil Tambah List');
       }else{
         alertify.error('Gagal Tambah List Data');

       }

     },
     error: function(jqXHR, textStatus, errorThrown){

       swal(
         'error',
         'Terjadi Kesalahan, Coba Lagi sNanti',
         'error'
       )
     }

    });

  });

  });
});

  $(".btn-generate-fisik").click(function() {
    if($("#awalkegfisik").datepicker("getDate") === null || $("#akhirkegfisik").datepicker("getDate") === null) {
      swal(
        'info',
        'Silahkan Pilih awal dan akhir Kegiatan!!!',
        'info'
        );
      return false;
    }else if($("#metode").val() === "0"){
      swal(
        'info',
        'Silahkan Pilih Metode PELAKSANAAN!!!',
        'info'
        );
      return false;
    }else{
      var intawal = parseInt(awalbln, 10);
      var intakhir = parseInt(akhirbln, 10);
      $(".tabel-bulan tbody").empty();
      var i=0;
      var x=0;
      var markup="";
      for (i=intawal; i <= intakhir; i++) {
        x++
        markup  = "<tr>";
        markup += "<td>";
        markup += x;
        markup += "</td>";
        markup += "<td>";
        markup += intbulan[i];
        markup += "</td>";
        markup += "<td>\
                  <div class='input-group'>\
                  <input type='text' class='numeric form-control' id='"+i+"' name='"+i+"'>\
                  <div class='input-group-addon'>\
                  <i class='fa fa-percent'></i>\
                  </div>\
                  </div></td>";
        markup += "</tr>";
        $(".tabel-bulan tbody").append(markup);
      }

      $(".numeric").inputmask({
        mask: "[999]",
        greedy: false,
        definitions: {
          '*': {
            validator: "[0-9]"
          }
        },
        rightAlign: true
      });

      $(".numeric").focusout(function() {
        findTotal();
        // var newStr=0;
        // var numbers= this.value;
        // newStr = parseInt(numbers.replace(/_/g, ""), 10);
        if(jumlah>100){
          swal(
            'Upss ',
            'Total Target Fisik Harus 100 %!!!',
            'info'
          )
          this.select();
        }
       // jumlah = jumlah > 100 ? swal(
       //      'info',
       //      'Target Fisik Belanja Modal Sudah di Entri',
       //      'info'
       //    ) this.select(): jumlah;
      });
    }
  });

  $('#modal-target').on('hidden.bs.modal',  function(){
    ajaxtoken();
    $('#awalkegfisik').datepicker('setDate', null);
    $('#awalkegfisik').datepicker('destroy');
    $('#akhirkegfisik').datepicker('setDate', null);
    $('#akhirkegfisik').datepicker('destroy');
    $(".tabel-bulan tbody").empty();
    $('#metode').val('0').trigger('change.select2');
    tblbelanjamodal.ajax.reload();

  });
  });
//batas on ready



function findTotal(){
    var arr = $(".numeric");
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    jumlah=tot;

}



$(function () {
  $('#formtargetfisik').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
    }
      var arr = $(".numeric");
      var mt = $("#metode").val();
      findTotal();
      if (arr.length==0){
         swal(
            'Upss ',
            'Silahkan Generate Bulan!!!',
            'info'
          )
      }else if( mt == "0"){
         swal(
            'Upss ',
            'Silahkan Pilih Metode Pelaksanaan!!!',
            'info'
          )
      }else if(jumlah>100 || jumlah<100){
          swal(
            'Upss ',
            'Total Target Fisik Harus 100 %!!!',
            'info'
          )

        }else{
          swal({
        title: "Simpan Entri Target Fisik",
        text: "Pastikan data sudah benar",
        type: "info",
                showCancelButton: true,
                confirmButtonColor: "#367FA9",
                confirmButtonText: "Ya, Simpan",
                cancelButtonText: "Tidak, Batal!",
                closeOnConfirm: false,
                closeOnCancel: false
              }, function (isConfirm) {
                if (isConfirm) {
                  Pace.restart ();
                  Pace.track (function (){
                    var token   = localStorage.getItem("token");
                    var mtgkey  = $('#mtgkey').html();
                    var tabppk  = $('#idtabpptk').html();
                    var formData = new FormData($('#formtargetfisik')[0]);
                    formData.append("token",token);
                    formData.append("mtgkey",mtgkey);
                    formData.append("idtab",tabppk);
                    $.ajax({
                      url: base_url+"User/simpantargetfisik",
                      type: 'POST',
                      data: formData,
                      mimeType: "multipart/form-data",
                      contentType: false,
                      cache: false,
                      processData: false,
                      success: function(result){

                             var jsonData = JSON.parse(result);
                            if (jsonData.data[0].status == false){
                              swal(
                                'info',
                                'Terjadi Kesalahan saat simpan!!!',
                                'info'
                                );
                              ajaxtoken();
                            }else{
                              ajaxtoken();
                              swal({

                                title: "Sukses",
                                text: "Data berhasil disimpan!!!",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonColor: "#008D4C",
                                confirmButtonText: "OK",
                                cancelButtonText: "",
                                closeOnConfirm: false,
                                closeOnCancel: false
                              },function(isConfirm){

                                if(isConfirm){
                                  swal.close();
                                  $('#modal-target').modal('hide');
                                }
                              });

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
                  });
                }else {
                  swal("Batal", "Batal Simpan", "error");
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
       <p id="tahunawal" hidden><?php echo $awaltahun ?></p>
       <p id="bulanawal" hidden><?php echo $blnawal ?></p>
       <p id="tahunakhir" hidden><?php echo $akhirtahun ?></p>
       <p id="bulanakhir" hidden><?php echo $blnakhir ?></p>
       <div class="row">
        <div class="col-md-2 col-sm-2" style="text-align: left">Organisasi Spesial</div>
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
  <a class="btn btn-block btn-social btn-success btn-flat" id="btn-lihat-kak">
      <i class="fa fa-eye"></i> Lihat KAK
    </a>

  </div>



</div>
<br>
<!-- Default box -->

<div class="box">
 <div class="box-header with-border">
  <i class="fa fa-text-width"></i>

  <h3 class="box-title">Form Entri Target Fisik Belanja Modal</h3>
</div>
<div class="box-body">
  <div class="row">
    <div class="col-md-2 col-sm-2 col-xs-12">
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12">
     <h2 class="text-center">Target Fisik Belanja Modal</h2>
   </div>
   <div class="col-md-2 col-sm-2 col-xs-12">
   </div>
 </div>
 <div class="row">
  <div class="col-md-2 col-sm-2 col-xs-12">
  </div>
  <div class="col-md-8 col-sm-8 col-xs-12">
   <h3 class="text-center"><?php echo $prog ?></h3>
 </div>
 <div class="col-md-2 col-sm-2 col-xs-12">
 </div>
</div>
<hr>
<div class="row">
  <div class="col-md-1 col-sm-1 col-xs-12">
  </div>
  <div class="col-md-1 col-sm-1 col-xs-12">
   <h4 class="text-left text-muted">Kegiatan</h4>
 </div>
 <div class="col-md-1 col-sm-1 col-xs-12">
  <h4 class="text-center text-muted">:</h4>
</div>
<div class="col-md-6 col-sm-8 col-xs-12">
  <h4 class="text-left text-muted"><p id="idtabpptk" hidden><?php echo $idtab ?></p></h4>
  <h4 class="text-left text-muted"><p id="idkegiatan" hidden><?php echo $kdkeg ?></p></h4>
  <h4 class="text-left text-muted"><?php echo $keg ?></h4>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
</div>
</div>
<div class="row">
  <div class="col-md-1 col-sm-1 col-xs-12">

  </div>
  <div class="col-md-1 col-sm-1 col-xs-12">
   <h4 class="text-left text-muted">Nilai</h4>
 </div>
 <div class="col-md-1 col-sm-1 col-xs-12">
  <h4 class="text-center text-muted">:</h4>
</div>
<div class="col-md-6 col-sm-8 col-xs-12">
 <h4 class="text-left text-muted"><?php echo $this->template->rupiah($nl) ?></h4>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
</div>
</div>
<div class="row">
  <div class="col-md-1 col-sm-1 col-xs-12">
  </div>
  <div class="col-md-1 col-sm-1 col-xs-12">
   <h4 class="text-left text-muted">PPTK</h4>
 </div>
 <div class="col-md-1 col-sm-1 col-xs-12">
  <h4 class="text-center text-muted">:</h4>
</div>
<div class="col-md-6 col-sm-8 col-xs-12">
 <h4 class="text-left text-muted"><?php echo $pptk ?></h4>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
</div>
</div>
<div class="row">
  <div class="col-md-1 col-sm-1 col-xs-12">
  </div>
  <div class="col-md-1 col-sm-1 col-xs-12">
   <h4 class="text-left text-muted">PPK</h4>
 </div>
 <div class="col-md-1 col-sm-1 col-xs-12">
  <h4 class="text-center text-muted">:</h4>
</div>
<div class="col-md-6 col-sm-8 col-xs-12">
 <h4 class="text-left text-muted"><?php echo $ppk ?></h4>
</div>
<div class="col-md-2 col-sm-2 col-xs-12">
</div>
</div>
<hr>

<div class="box-header ui-sortable-handle" >




    <div class=" pull-left header " >
      <a class="btn btn-social btn-bitbucket btn-flat"  id="btn-list-uraian"><i class="fa fa-file-text-o"></i>List Uraian Kegiatan</a>
  <!-- <a class="btn btn-block btn-social btn-success btn-flat" id="btn-lihat-kak">
      <i class="fa fa-eye"></i> Lihat KAK
    </a> -->
    </div>
  </div>
              <br>
              <br>

  <div class="table-responsive">

    <table id="tbl-list-bmodal" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th class="text-left"  width="2%"><b>#</b></th>
          <th >mtgkey</th>
          <th class="col-xs-2 text-left" >Kode Rekening</th>
          <th class="col-xs-2 text-left" >Kode Rekening</th>
          <th class="col-xs-2 text-left" >Kode Rekening</th>
          <th class="col-xs-8 text-left" >Uraian</th>

          <th class=" td-actions text-center" >Aksi</th>
        </tr>
      </thead>
    </table>
            <!-- <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-left"  width="2%"><b>#</b></th>
                        <th class="col-xs-2 text-left" >Kode Rekening</th>
                        <th class="col-xs-8 text-left" >Nama Rekening</th>
                        <th class=" td-actions text-center" ></th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                  foreach ($blmodal as $row){
                      $i++;
                    $statbm = $this->db->get_where('tab_target_blnj_modal',array('idtab_pptk'=> $idtab,'mtgkey'=>$row['mtgkey']));
                    if($statbm->num_rows()>0){
                      // $ada=1; maka tidak bisa lanjut
                      if($statbm->row()->stat_draft==1){

                      $ada='<button type="button" class="btnkak btn btn-block btn-primary btn-flat disabled"data-toggle="tooltip"
                              title="Target Belanja Modal Sudah Di entri">Entri Target <i class="fa fa-check text-success"></i></button>';
                      }else{
                        $ada='<button type="button" class="btnkak btn btn-block btn-primary btn-flat" data-toggle="tooltip"
                              title="Silahkan Ubah Target Belanja Modal">Ubah Target <i class="fa fa-spinner fa-pulse fa-fw text-danger"></i></button> ';
                      }

                    }else{
                      // $ada=0; lanjut karna belum ada
                      $ada='<button type="button" class="btnblnjamodal btn btn-block btn-primary btn-flat" data-toggle="tooltip"
                              title="Target Belanja Modal Belum di Tetapkan">Entri Targget <i class="fa fa-hourglass-start text-danger"></i></button>';
                    }

                   // style="display:none;"
                    echo'<tr>
                    <td>'.$i.'</td>
                    <td class="kdkegunit" style="display:none;">'.$row['kdkegunit'].'</td>
                    <td class="mtgkey" style="display:none;">'.$row['mtgkey'].'</td>
                    <td class="col-xs-2">'.$row['kdper'].'</td>
                    <td class="col-xs-5">'.$row['nmper'].'</td>

                    <td class="td-actions text-center">'.$ada.'</td>
                    </tr>';

                }
                ?>
            </tbody>
        </table> -->
    </div>


        </div>
        <!-- /.box-body -->
        <div class="box-footer">

          <div class="row">

  <div class="col-md-3 col-sm-6 col-xs-12">

  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">
  </div>
  <div class="col-md-3 col-sm-6 col-xs-12">

  </div>

  <div class="col-md-3 col-sm-6 col-xs-12 button-all">
 <button type="button" class="btn btn-block btn-social btn-flat btn-success btn-selesaikan-tf" data-toggle="tooltip" title="Simpan Semua Target Fisik"><i class="fa  fa-save"></i>Simpan Dan Selesaikan</button>

  </div>



</div>
        </div>
        <!-- /.box-footer-->

      </div>
      <!-- /.box -->

    </section>

<div class="modal fade" id="modal-target" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
           <form id="formtargetfisik" enctype="multipart/form-data" role="form" autocomplete="off">

           <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Info Modal</h4>

                 <p id="mtgkey" hidden></p>

              </div>

            <div class="modal-body">

              <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-12">
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">

                         <div class="form-group">
                           <label class="text-left text-muted" for="metode"><b>METODE PELAKSANAAN</b></label>

                           <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="fa fa-cubes"></i>
                            </div>

                            <select class="form-control select2"  id="metode" name="metode" data-placeholder="Pilih Metode" style="width: 100%;">
                                 <option value="0" selected="selected">Silahkan Pilih Metode</option>
                              <?php
                               $metode= $this->User_model->getnama_metode();
                              foreach ($metode as $k) {
                                  echo "<option value='{$k->id}'>{$k->nama_metode}</option>";
                              }
                              ?>
                          </select>
                          </div>
                          <!-- /.input group -->
                        </div>
                      </div>


                    </div>
              <div class="row">
                      <div class="col-md-1 col-sm-1 col-xs-12">
                      </div>
                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="form-group">
                         <label class="text-left text-muted" for="awalkeg"><b>AWAL KEGIATAN</b></label>

                         <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right datepicker" id="awalkegfisik" name="awalkegfisik">
                        </div>
                        <!-- /.input group -->
                      </div>
                      <!--    <div class="form-group">

                            <label class="text-left text-muted" for="awalkeg"><b>AWAL KEGIATAN</b></label>
                            <input type="text" class="form-control" id="awalkeg" placeholder="Awal Kegiatan">
                          </div> -->
                        </div>


                      </div>
                      <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-12">
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">

                         <div class="form-group">
                           <label class="text-left text-muted" for="awalkeg"><b>AKHIR KEGIATAN</b></label>

                           <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right datepicker" id="akhirkegfisik" name="akhirkegfisik">
                            <span class="input-group-btn">
                          <button type="button" class="btn btn-info btn-flat btn-generate-fisik" >Generate</button>
                        </span>
                          </div>

                          <!-- /.input group -->
                        </div>
                      </div>


                    </div>

                    <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-12">
                        </div>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <table class="table table-bordered tabel-bulan">
                                <thead>
                                  <tr>
                                    <th style="width: 10px">#</th>
                                    <th class="y">Bulan</th>
                                    <th class="col-sm-3 text-center x">Persentase</th>
                                  </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>

                        </div>


                    </div>



            </div>

            <div class="modal-footer modal-footer-tombol">

            </div>
            </form>
        </div>
    </div>
</div>
