<script type="text/javascript">
  var itemuraian=0;
  var arraybln = [];
  $(document).ready(function () {

    ajaxtoken();
 // initMCE();
 $('.textarea').wysihtml5()

 var date=new Date();
 var year=date.getFullYear();
 var month=date.getMonth();
 var awalbln=0;
 var akhirbln=0;


 var bulan = {'January':'0','February':'1','March':'2','April':'3','May':'4','June':'5','July':'6','August':'7','September':'8','October':'9','November':'10','December':'11'};

 $("#awalkeg").click(function() {
  if (itemuraian > 0){
    swal({
      title: "Penjadwalan Ulang",
      text: "Semua Urain akan di reset!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, Jadwal baru!",
      cancelButtonText: "No, Batal!",
      closeOnConfirm: false,
      closeOnCancel: false
    }, function (isConfirm) {
      if (isConfirm) {
        swal("Sukses!", "Reset Uraian Berhasil, Silahkan Pilih Bulan lagi", "success");
        $("#tbodyid").empty();
        itemuraian=0;
        akhirbln=0;
        arraybln = [];
      } else {

        swal("Batal", "Re Jadwal Batal", "error");

      }
    });
  }
});
 $("#akhirkeg").click(function() {
  if (itemuraian > 0){
    swal({
      title: "Penjadwalan Ulang",
      text: "Semua Urain akan di reset!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, Jadwal baru!",
      cancelButtonText: "No, Batal!",
      closeOnConfirm: false,
      closeOnCancel: false
    }, function (isConfirm) {
      if (isConfirm) {
        swal("Sukses!", "Reset Uraian Berhasil, Silahkan Pilih Bulan lagi", "success");
        $("#tbodyid").empty();
        itemuraian=0;
        akhirbln=0;
        arraybln = [];
      } else {

        swal("Batal", "Re Jadwal Batal", "error");

      }
    });
  }
});
 $('#awalkeg').datepicker({
  format: "MM yyyy",
  language: "id",
  viewMode: "months",
  minViewMode: "months",
  autoclose: true,
  startDate: new Date(year, '0', '01'),
  endDate: new Date(year, '11', '31')
}).on("input change", function (e) {
    // string jadi array

    var namabln =this.value;
    var convert = namabln.split(" ");
    // console.log(awalbln);
    $('#akhirkeg').datepicker('setDate', null);
    $('#akhirkeg').datepicker('destroy');
      //var $dates = $('#from, #to').datepicker();
      itemuraian=0;
      awalbln=0;
      akhirbln=0;
      arraybln = [];
      awalbln = bulan[convert[0]];
      $('#akhirkeg').datepicker({
        format: "MM yyyy",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
        startDate: new Date(year, awalbln, '01'),
        endDate: new Date(year, '11', '31')
      }).on("input change", function (e) {

        var namabln =this.value;
        var convert = namabln.split(" ");
        itemuraian=0;
        akhirbln=0;
        akhirbln = bulan[convert[0]];
        var intawal = parseInt(awalbln, 10);
        var intakhir = parseInt(akhirbln, 10);
        arraybln = [];
        var i=0;
        for (i=intawal; i <= intakhir; i++) {
          arraybln.push(i.toString());
        }
      });
    });

    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();

    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

      var $target = $(e.target);

      if ($target.parent().hasClass('disabled')) {
        return false;
      }
    });

    $(".next-step-lb").click(function (e) {


      // if ($('#ltrblk').val() === '') {
      //       swal(
      //     'info',
      //     'Field Latar Belakang Tidak Boleh Kosong',
      //     'info'
      //     );
      //       return false;
      //   }else if($('#tujuan').val() === ''){
      //     swal(
      //     'info',
      //     'Field tujuan Tidak Boleh Kosong',
      //     'info'
      //     );
      //       return false;
      //   }else if($('#sasaran').val() === ''){
      //     swal(
      //     'info',
      //     'Field sasaran Tidak Boleh Kosong',
      //     'info'
      //     );
      //       return false;
      //   }else{
      //       var $active = $('.wizard .nav-tabs li.active');
      //   $active.next().removeClass('disabled');
      //   nextTab($active);
      //   }
      if ($('#ltrblk').val() === '') {

       swal({
        title: "Info",
        text: "Field Latar Belakang Tidak Boleh Kosong",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#008D4C",
        confirmButtonText: "OK",
        cancelButtonText: "",
        closeOnConfirm: false,
        closeOnCancel: false
      },function(isConfirm){
        if(isConfirm){
         $('html, body').animate({
          scrollTop: $(".latar-blakang").offset().top
        }, 1000);
       }
       swal.close();
     });
       return false;
     }else if($('#tujuan').val() === ''){
      swal({
        title: "Info",
        text: "Field tujuan Tidak Boleh Kosong",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#008D4C",
        confirmButtonText: "OK",
        cancelButtonText: "",
        closeOnConfirm: false,
        closeOnCancel: false
      },function(isConfirm){
        if(isConfirm){
         $('html, body').animate({
          scrollTop: $(".sc-tujuan").offset().top
        }, 1000);
       }
       swal.close();
     });
      return false;
    }else if($('#sasaran').val() === ''){
     swal({
      title: "Info",
      text: "Field sasaran Tidak Boleh Kosong",
      type: "warning",
      showCancelButton: false,
      confirmButtonColor: "#008D4C",
      confirmButtonText: "OK",
      cancelButtonText: "",
      closeOnConfirm: false,
      closeOnCancel: false
    },function(isConfirm){
      if(isConfirm){
       $('html, body').animate({
        scrollTop: $(".sc-sasaran").offset().top
      }, 1000);
     }
     swal.close();
   });

     return false;
   }else{

    $('html, body').animate({
      scrollTop: $(".wizard").offset().top
    }, 1000);
    var $active = $('.wizard .nav-tabs li.active');
    $active.next().removeClass('disabled');
    nextTab($active);
  }




});
    $(".next-step-ik").click(function (e) {

     if ($('#input').val() === '') {
       swal({
        title: "Info",
        text: "Field Masukan Tidak Boleh Kosong",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#008D4C",
        confirmButtonText: "OK",
        cancelButtonText: "",
        closeOnConfirm: false,
        closeOnCancel: false
      },function(isConfirm){
        if(isConfirm){
         $('html, body').animate({
          scrollTop: $(".sc-masukan").offset().top
        }, 1000);
       }
       swal.close();
     });

       return false;
     }else if($('#output').val() === ''){
      swal({
        title: "Info",
        text: "Field Keluaran Tidak Boleh Kosong",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#008D4C",
        confirmButtonText: "OK",
        cancelButtonText: "",
        closeOnConfirm: false,
        closeOnCancel: false
      },function(isConfirm){
        if(isConfirm){
         $('html, body').animate({
          scrollTop: $(".sc-keluaran").offset().top
        }, 1000);
       }
       swal.close();
     });

      return false;
    }else if($('#outcome').val() === ''){
     swal({
      title: "Info",
      text: "Field Hasil Tidak Boleh Kosong",
      type: "warning",
      showCancelButton: false,
      confirmButtonColor: "#008D4C",
      confirmButtonText: "OK",
      cancelButtonText: "",
      closeOnConfirm: false,
      closeOnCancel: false
    },function(isConfirm){
      if(isConfirm){
       $('html, body').animate({
        scrollTop: $(".sc-hasil").offset().top
      }, 1000);
     }
     swal.close();
   });

     return false;
   }else{
    $('html, body').animate({
      scrollTop: $(".wizard").offset().top
    }, 1000);
    var $active = $('.wizard .nav-tabs li.active');
    $active.next().removeClass('disabled');
    nextTab($active);
  }


});

    $(".next-step-pp").click(function (e) {

      if ($('#pplasana').val() === '') {
       swal({
        title: "Info",
        text: "Field Proses Pelaksanaan Tidak Boleh Kosong",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#008D4C",
        confirmButtonText: "OK",
        cancelButtonText: "",
        closeOnConfirm: false,
        closeOnCancel: false
      },function(isConfirm){
        if(isConfirm){
         $('html, body').animate({
          scrollTop: $(".sc-proses-pelaksanaan").offset().top
        }, 1000);
       }
       swal.close();
     });

       return false;
     }else if($('#penutup').val() === ''){
      swal({
        title: "Info",
        text: "Field Penutup Tidak Boleh Kosong",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#008D4C",
        confirmButtonText: "OK",
        cancelButtonText: "",
        closeOnConfirm: false,
        closeOnCancel: false
      },function(isConfirm){
        if(isConfirm){
         $('html, body').animate({
          scrollTop: $(".sc-penutup").offset().top
        }, 1000);
       }
       swal.close();
     });
      return false;
    }else{
     $('html, body').animate({
      scrollTop: $(".wizard").offset().top
    }, 1000);
     var $active = $('.wizard .nav-tabs li.active');
     $active.next().removeClass('disabled');
     nextTab($active);
   }

       // if( itemuraian == '0'){
       //    swal(
       //    'info',
       //    'Time Schedule Tidak Boleh Kosong',
       //    'info'
       //    );
       //      return false;
       //  }else{
       //      var $active = $('.wizard .nav-tabs li.active');
       //  $active.next().removeClass('disabled');
       //  nextTab($active);
       //  }


     });

    $(".prev-step").click(function (e) {

      var $active = $('.wizard .nav-tabs li.active');
      prevTab($active);

    });



    $(".tambah-uraian").click(function() {
      if($("#awalkeg").datepicker("getDate") === null || $("#akhirkeg").datepicker("getDate") === null ) {
        swal(
          'info',
          'Silahkan Pilih awal dan akhir Kegiatan !!!',
          'info'
          );
        return false;
      }else{
        Pace.restart ();
        Pace.track (function (){
          functambahuraian();
        });
      }
    });


  });

function nextTab(elem) {
  $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
  $(elem).prev().find('a[data-toggle="tab"]').click();
}





function functambahuraian() {
  var markup="";
  var dethtml="";
  swal({
    title: "Time Schedule",
    text: "Silahkan Masukan Nama Uraian Kegiatan",
    type: "input",
    showCancelButton: true,
    closeOnConfirm: false,
    animation: "slide-from-top",
    inputPlaceholder: "Nama Uraian"
  }, function (inputValue) {
    if (inputValue === false) return false;
    if (inputValue === "") {
      swal.showInputError("Input Nama Uraian Tidak Boleh Kosong"); return false
    }

    swal({

      title: "Sukses",
      text: "Uraian di Tambahkan ke Schedule",
      type: "success",
      showCancelButton: false,
      confirmButtonColor: "#008D4C",
      confirmButtonText: "OK",
      cancelButtonText: "Tidak, Batal!",
      closeOnConfirm: false,
      closeOnCancel: false
    },function(isConfirm){
      if(isConfirm){
        arsiran();
        dethtml = "";
        itemuraian++;
        markup +="<tr class='trow'>";
        markup +="<td style='min-width:2px; font-size: 11px'>"+itemuraian+"</td>\
        <td style='min-width:2px; font-size: 11px'>"+inputValue+"</td>";
        var i;
        var x;
        var y;
        for (i=0; i <= 11; i++) {
          y=0;
          for (x = 0 ; x <= 11; x++) {
            if (arraybln[x] == i ) {
              y=1;
            }
          }
          if (y!=1){
            dethtml +="<td class='"+i+"' style='min-width:2px; font-size: 10px'></td>\
            <td  class='"+i+"' style='min-width:2px; font-size: 10px'></td>\
            <td  class='"+i+"' style='min-width:2px; font-size: 10px'></td>\
            <td  class='"+i+"' style='min-width:2px; font-size: 10px'></td>"
          }else{
            dethtml +="<td class='enable "+i+"' style='min-width:2px; font-size: 10px'><p hidden>"+i+"_1</p></td>\
            <td class='enable "+i+"' style='min-width:2px; font-size: 10px'><p hidden>"+i+"_2</p></td>\
            <td class='enable "+i+"' style='min-width:2px; font-size: 10px'><p hidden>"+i+"_3</p></td>\
            <td class='enable "+i+"' style='min-width:2px; font-size: 10px'><p hidden>"+i+"_4</p></td>"
          }
        }
        markup+=dethtml;
        markup += "</tr>";
        $(".tabel-schedule tbody").append(markup);
        markup="";
        arsiran();
        swal.close();
      }
    });

  });
}

function arsiran(){
  var isMouseDown = false,
  isHighlighted;
  $("#tb-uraian td.enable")
  .mousedown(function () {
    isMouseDown = true;
    $(this).toggleClass("highlighted");
    isHighlighted = $(this).hasClass("highlighted");
      return false; // prevent text selection
    })
  .mouseover(function () {
    if (isMouseDown) {
      $(this).toggleClass("highlighted", isHighlighted);
    }
  })
  .bind("selectstart", function () {
    return false;
  })
  $(document)
  .mouseup(function () {
    isMouseDown = false;
  });
}
$(function () {
  $('#kakform').submit(function (e, params) {


    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();
    }
    if ($('#ltrblk').val() === '') {
      swal(
        'info',
        'Field Latar Belakang Tidak Boleh Kosong',
        'info'
        );
      return false;
    }else if($('#tujuan').val() === ''){
      swal(
        'info',
        'Field tujuan Tidak Boleh Kosong',
        'info'
        );
      return false;
    }else if($('#sasaran').val() === ''){
      swal(
        'info',
        'Field sasaran Tidak Boleh Kosong',
        'info'
        );
      return false;
    }else if($('#input').val() === ''){
      swal(
        'info',
        'Field Masukan Tidak Boleh Kosong',
        'info'
        );
      return false;
    }else if($('#output').val() === ''){
      swal(
        'info',
        'Field Keluaran Tidak Boleh Kosong',
        'info'
        );
      return false;
    }else if($('#outcome').val() === ''){
      swal(
        'info',
        'Field Hasil Tidak Boleh Kosong',
        'info'
        );
      return false;
    }else if($('#pplasana').val() === ''){
      swal(
        'info',
        'Field Proses Pelaksanaan Tidak Boleh Kosong',
        'info'
        );
      return false;
    }else if($('#penutup').val() === ''){
      swal(
        'info',
        'Field Penutup Tidak Boleh Kosong',
        'info'
        );
      return false;
    }else if( itemuraian == '0'){
      swal(
        'info',
        'Time Schedule Tidak Boleh Kosong',
        'info'
        );
      return false;
    }else{

     swal({
      title: "Simpan Entri KAK",
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
        var table = $("table tbody");
        var myArray = new Array();
        table.find('tr').each(function (i) {
          var list={};
          var uraian='';
          var light=[];
          var $td = $(this).find('td'),
          uraian = $td.eq(1).text();
          list['uraian'] = [];
          list['0'] = [];
          list['1'] = [];
          list['2'] = [];
          list['3'] = [];
          list['4'] = [];
          list['5'] = [];
          list['6'] = [];
          list['7'] = [];
          list['8'] = [];
          list['9'] = [];
          list['10'] = [];
          list['11'] = [];
          list['uraian'].push(uraian);
          $(this).find('td.highlighted').each(function (x) {
            light.push($(this).text());
          });
          var result = {};
          for (var i = 0; i < light.length; i++){
            if (light[i].indexOf('_') < 0){
              console.log("No prefix detected in '" + light[i] + "'.");
              continue;
            }
            var prefix = light[i].split('_')[0];
            if (!result[prefix])
              result[prefix] = [];
            list[prefix].push(light[i].split('_')[1]);
          }
          myArray.push(list);
        });
        var date1 = $('#awalkeg').datepicker('getDate'),
        day1  = date1.getDate(),
        month1 = date1.getMonth() + 1,
        year1 =  date1.getFullYear();
        var date2 = $('#akhirkeg').datepicker('getDate'),
        day2  = date2.getDate(),
        month2 = date2.getMonth() + 1,
        year2 =  date2.getFullYear();
        var idtab = $('#idtabpptk').html();
        var idopd = $('#kdunit').html();
        var idkeg = $('#idkegiatan').html();
        var token = localStorage.getItem("token");
        var lb = $('#ltrblk').val() ;
        var tj = $('#tujuan').val() ;
        var ssr = $('#sasaran').val();
        var inp = $('#input').val();
        var otp = $('#output').val();
        var otc = $('#outcome').val();
        var awk = year1+"-"+month1+"-"+day1;
        var akk = year2+"-"+month2+"-"+day2;
        var pplasana = $('#pplasana').val();
        var pnt = $('#penutup').val();
        $.ajax({
          url: base_url+"User/simpankak",
          type: "POST",
          data: {
            token : token,
            idtab : idtab,
            lb : lb,
            tj : tj,
            ssr : ssr,
            inp : inp,
            otp : otp,
            otc : otc,
            awk : awk,
            akk : akk,
            pplasana : pplasana,
            pnt : pnt,
            tms : myArray
          },
          dataType: "JSON",
          success: function(result){
            var resstatus =result.data[0].status;
            console.log(resstatus);
            if (result.data[0].status == false){
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
                text: "Data KAK berhasil disimpan!!!",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#008D4C",
                confirmButtonText: "OK",
                cancelButtonText: "",
                closeOnConfirm: false,
                closeOnCancel: false
              },function(isConfirm){

                if(isConfirm){
                  Pace.restart ();
                  Pace.track (function (){
                  var token = localStorage.getItem("token");
                  $.ajax({
                    url: base_url+"User/cekblnjamdal",
                    type: "POST",
                    data: {
                      token : token,
                      idopd : idopd,
                      idtab : idtab,
                      idkeg : idkeg
                    },
                    dataType: "JSON",
                    success: function(result){
                      if (result.uri[0].status == true){
                        ///setelah cek entri target belanja modal
                          var unit = result.uri[0].unit;
                          var kegiatan = result.uri[0].keg;
                          var tab = result.uri[0].tab;
                          window.location.href = base_url+"User/entritblnjmodal?unit="+unit+"&keg="+kegiatan+"&tab="+tab;

                      }else{
                        window.location.href = base_url+"User/list-kegiatan-kpa";
                      }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                      console.log(jqXHR.responseText);
                      console.log(errorThrown);
                      ajaxtoken();
                      swal(
                        'Terjadi Kesalahan ',
                        'Saat Mengambil Data Belanja Modal, Coba Lagi Nanti',
                        'error'
                        )
                    }
                  });
                  });


                }
              });

            }
          },
          error: function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR.responseText);
            console.log(errorThrown);

            ajaxtoken();
            swal(
              'error',
              'Terjadi Kesalahan, Coba Lagi Nanti',
              'error'
              )
          }
        });
      });



} else {

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
  <i class="fa fa-text-width"></i>

  <h3 class="box-title">Form Entri KAK</h3>
</div>
<div class="box-body">
  <div class="row">
    <div class="col-md-2 col-sm-2 col-xs-12">
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12">
     <h2 class="text-center">KERANGKA ACUAN KERJA</h2>
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

<div class="wizard">
  <div class="wizard-inner">
    <div class="connecting-line"></div>
    <ul class="nav nav-tabs" role="tablist">

      <li role="presentation" class="active">
        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="PENDAHULUAN">
          <span class="round-tab">
            <i class="fa fa-file-word-o"></i>
          </span>
        </a>
      </li>

      <li role="presentation" class="disabled">
        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="INDIKATOR KINERJA">
          <span class="round-tab">
            <i class="fa fa-line-chart"></i>
          </span>
        </a>
      </li>
      <li role="presentation" class="disabled">
        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="PROSES PELAKSANAAN">
          <span class="round-tab">
            <i class="fa fa-calendar-check-o"></i>
          </span>
        </a>
      </li>

      <li role="presentation" class="disabled">
        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="PENUTUP">
          <span class="round-tab">
            <i class="glyphicon glyphicon-ok"></i>
          </span>
        </a>
      </li>
    </ul>
  </div>

  <form role="form" id="kakform" autocomplete="off">
    <div class="tab-content">
      <div class="tab-pane active" role="tabpanel" id="step1">
        <div class="row latar-blakang">
          <div class="col-md-1 col-sm-1 col-xs-12">
          </div>
          <div class="col-md-5 col-sm-5 col-xs-12">
           <h4 class="text-left text-muted"><b>I. PENDAHULUAN</b></h4>

         </div>


       </div>
       <div class="row ">
        <div class="col-md-1 col-sm-1 col-xs-12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
         <h5 class="text-left text-muted">&nbsp&nbsp&nbsp&nbsp&nbsp<b>A. LATAR BELAKANG</b></h5>

       </div>
     </div>
     <div class="row">
      <div class="col-md-1 col-sm-1 col-xs-12">
      </div>
      <div class="col-md-10 col-sm-10 col-xs-12">
                            <!--  <textarea id="ltrblk">

                            </textarea> -->
                            <!--  <textarea id="ltrblk" name="ltrblk" rows="15" cols="80" style="width: 80%" class="tinymce"></textarea> -->
                            <textarea class="textarea" id="ltrblk" name="ltrblk"  placeholder="Isikan Latar Belakang *harus"
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-1 col-sm-1 col-xs-12">
                          </div>
                          <div class="col-md-3 col-sm-3 col-xs-12">
                           <h5 class="text-left text-muted">&nbsp&nbsp&nbsp&nbsp&nbsp<b>B. TUJUAN DAN SASARAN</b></h5>

                         </div>
                       </div>
                       <div class="row sc-tujuan">
                        <div class="col-md-1 col-sm-1 col-xs-12">
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                         <h5 class="text-left text-muted">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>1. TUJUAN</b></h5>

                       </div>
                     </div>
                     <div class="row">
                      <div class="col-md-1 col-sm-1 col-xs-12">
                      </div>
                      <div class="col-md-10 col-sm-10 col-xs-12">
                            <!--  <textarea id="tujuan">

                            </textarea> -->
                            <!-- <textarea id="tujuan" name="tujuan" rows="15" cols="80" style="width: 80%" class="tinymce"></textarea> -->
                            <textarea class="textarea" id="tujuan" name="tujuan"  placeholder="Isikan Tujuan *harus"
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                          </div>
                        </div>
                        <div class="row sc-sasaran">
                          <div class="col-md-1 col-sm-1 col-xs-12">
                          </div>
                          <div class="col-md-2 col-sm-2 col-xs-12">
                           <h5 class="text-left text-muted">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>2. SASARAN</b></h5>

                         </div>
                       </div>
                       <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-12">
                        </div>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                             <!-- <textarea id="sasaran">

                             </textarea> -->
                             <!-- <textarea id="sasaran" name="sasaran" rows="15" cols="80" style="width: 80%" class="tinymce"></textarea> -->
                             <textarea class="textarea" id="sasaran" name="sasaran"  placeholder="Isikan Sasaran *harus"
                             style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                           </div>
                         </div>
                         <br>
                         <!-- <ul class="list-inline pull-right">
                          <li><button type="button" class="btn btn-primary ">Lanjut</button></li>
                        </ul> -->
                        <div class="row">
                          <div class="col-md-1 col-sm-6 col-xs-12">
                            </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">

                              </div>
                              <div class="col-md-2 col-sm-6 col-xs-12">
                                </div>
                                <div class="col-md-2 col-sm-6 col-xs-12">

                                </div>

                                <div class="col-md-3 col-sm-6 col-xs-12">

                                  <a class="btn btn-block btn-primary btn-flat next-step-lb" >
                                   Lanjut  <i class="fa fa-arrow-right"></i>
                                  </a>
                                </div>
                                <div class="col-md-1 col-sm-6 col-xs-12">
                                  </div>



                        </div>
                      </div>
                      <div class="tab-pane" role="tabpanel" id="step2">
                       <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-12">
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                         <h5 class="text-left text-muted">&nbsp&nbsp&nbsp&nbsp&nbsp<b>C. INDIKATOR KINERJA</b></h5>

                       </div>
                     </div>
                     <div class="row sc-masukan">
                      <div class="col-md-1 col-sm-1 col-xs-12">
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-12">
                       <h5 class="text-left text-muted">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>1. INPUT (MASUKAN)</b></h5>

                     </div>
                   </div>
                   <div class="row">
                    <div class="col-md-1 col-sm-1 col-xs-12">
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                            <!--  <textarea id="input">

                            </textarea> -->
                            <!--  <textarea id="input" name="input" rows="15" cols="80" style="width: 80%" class="tinymce"></textarea> -->
                            <textarea class="textarea" id="input" name="input"  placeholder="Isikan Masukan *harus"
                            style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                          </div>
                        </div>
                        <div class="row sc-keluaran">
                          <div class="col-md-1 col-sm-1 col-xs-12">
                          </div>
                          <div class="col-md-3 col-sm-3 col-xs-12">
                           <h5 class="text-left text-muted">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>2. OUTPUT (KELUARAN)</b></h5>

                         </div>
                       </div>
                       <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-12">
                        </div>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                             <!-- <textarea id="output">

                             </textarea> -->
                             <!--  <textarea id="output" name="output" rows="15" cols="80" style="width: 80%" class="tinymce"></textarea> -->
                             <textarea class="textarea" id="output" name="output"  placeholder="Isikan Keluaran *harus"
                             style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                           </div>
                         </div>
                         <div class="row sc-hasil">
                          <div class="col-md-1 col-sm-1 col-xs-12">
                          </div>
                          <div class="col-md-3 col-sm-3 col-xs-12">
                           <h5 class="text-left text-muted">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>2. OUTCOME (HASIL)</b></h5>

                         </div>
                       </div>
                       <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-12">
                        </div>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <!--    <textarea id="outcome">

                          </textarea> -->
                          <!-- <textarea id="outcome" name="outcome" rows="15" cols="80" style="width: 80%" class="tinymce"></textarea> -->
                          <textarea class="textarea" id="outcome" name="outcome"  placeholder="Isikan Hasil *harus"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                      </div>
                      <br>
                      <!-- <ul class="list-inline pull-right">
                        <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>
                        <li><button type="button" class="btn btn-primary next-step-ik">Lanjut</button></li>
                      </ul> -->
                      <div class="row">
                        <div class="col-md-1 col-sm-6 col-xs-12">
                          </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <a class="btn btn-block btn-warning btn-flat prev-step" >
                               <i class="fa fa-arrow-left"></i> Kembali
                              </a>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                              </div>
                              <div class="col-md-2 col-sm-6 col-xs-12">

                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">

                                <a class="btn btn-block btn-primary btn-flat next-step-ik" >
                                 Lanjut  <i class="fa fa-arrow-right"></i>
                                </a>
                              </div>
                              <div class="col-md-1 col-sm-6 col-xs-12">
                                </div>



                      </div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                      <div class="row sc-proses-pelaksanaan">
                        <div class="col-md-1 col-sm-1 col-xs-12">
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                         <h4 class="text-left text-muted"><b>II. PROSES PELAKSANAAN</b></h4>

                       </div>


                     </div>
                     <div class="row">
                      <div class="col-md-1 col-sm-1 col-xs-12">
                      </div>
                      <div class="col-md-10 col-sm-10 col-xs-12">


                       <!--  <textarea id="pplasana" name="pplasana" rows="15" cols="80" style="width: 80%" class="tinymce"></textarea> -->
                       <textarea class="textarea" id="pplasana" name="pplasana"  placeholder="Isikan Proses Pelaksanaan *harus"
                       style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                     </div>
                   </div>
                   <div class="row sc-penutup">
                    <div class="col-md-1 col-sm-1 col-xs-12">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                     <h5 class="text-left text-muted">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b>III. PENUTUP</b></h5>

                   </div>
                 </div>
                 <div class="row">
                  <div class="col-md-1 col-sm-1 col-xs-12">
                  </div>
                  <div class="col-md-10 col-sm-10 col-xs-12">
                           <!--   <textarea id="penutup">

                           </textarea> -->
                           <!-- <textarea id="penutup" name="penutup" rows="15" cols="80" style="width: 80%" class="tinymce"></textarea> -->
                           <textarea class="textarea" id="penutup" name="penutup"  placeholder="Isikan Penutup *harus"
                           style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                         </div>
                       </div>

                       <br>

                       <!-- <ul class="list-inline pull-right">
                        <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>

                        <li><button type="button" class="btn btn-primary btn-info-full next-step-pp">Lanjut</button></li>
                      </ul> -->
                      <div class="row">
                        <div class="col-md-1 col-sm-6 col-xs-12">
                          </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <a class="btn btn-block btn-warning btn-flat prev-step" >
                               <i class="fa fa-arrow-left"></i> Kembali
                              </a>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                              </div>
                              <div class="col-md-2 col-sm-6 col-xs-12">

                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">

                                <a class="btn btn-block btn-primary btn-flat next-step-pp" >
                                 Lanjut  <i class="fa fa-arrow-right"></i>
                                </a>
                              </div>
                              <div class="col-md-1 col-sm-6 col-xs-12">
                                </div>



                      </div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
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
                          <input type="text" class="form-control pull-right datepicker" id="awalkeg" name="awalkeg">
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
                            <input type="text" class="form-control pull-right datepicker" id="akhirkeg" name="akhirkeg">
                          </div>
                          <!-- /.input group -->
                        </div>
                      </div>


                    </div>
                    <br>
                    <div class="row">

                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-primary">
                          <div class="box-header">
                            <i class="fa fa-clock-o"></i>

                            <h3 class="box-title">Time Schedule Kegiatan</h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                              <button type="button" class="btn btn-info btn-sm tambah-uraian"  data-toggle="tooltip"
                              title="Tambah Uraian">
                              <i class="fa fa-plus"></i></button>

                            </div>
                            <!-- /. tools -->
                          </div>
                          <div class="box-body no-padding">
                           <div class="table-responsive">
                            <table class="table table-bordered tabel-schedule" style="width: 100%" id="tb-uraian">
                              <thead>
                                <tr>

                                  <th rowspan="2" style="vertical-align : middle;text-align:center;">#</th>
                                  <th rowspan="2" class='text-center' style="vertical-align : middle;width: 20%">&nbsp&nbsp&nbsp&nbsp&nbspNama&nbspUraian&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                                  <th colspan="4" class='text-center ' style="width: 4%">Januari</th>
                                  <th colspan="4" class='text-center 'style="width: 4%">Februari</th>
                                  <th colspan="4" class='text-center' style="width: 4%">Maret</th>
                                  <th colspan="4" class='text-center' style="width: 4%">April</th>
                                  <th colspan="4" class='text-center ' style="width: 4%">Mei</th>
                                  <th colspan="4" class='text-center ' style="width: 4%">Juni</th>
                                  <th colspan="4" class='text-center ' style="width: 4%">Juli</th>
                                  <th colspan="4" class='text-center ' style="width: 4%">Agustus</th>
                                  <th colspan="4" class='text-center ' style="width: 4%">September</th>
                                  <th colspan="4" class='text-center ' style="width: 4%">Oktober</th>
                                  <th colspan="4" class='text-center ' style="width: 4%">November</th>
                                  <th colspan="4" class='text-center ' style="width: 4%">Desember</th>

                                </tr>
                                <tr>

                                  <th style="min-width:2px; font-size: 10px">1</th>
                                  <th style="min-width:2px; font-size: 10px">2</th>
                                  <th style="min-width:2px; font-size: 10px">3</th>
                                  <th style="min-width:2px; font-size: 10px">4</th>
                                  <th style="min-width:2px; font-size: 10px">1</th>
                                  <th style="min-width:2px; font-size: 10px">2</th>
                                  <th style="min-width:2px; font-size: 10px">3</th>
                                  <th style="min-width:2px; font-size: 10px">4</th>
                                  <th style="min-width:2px; font-size: 10px">1</th>
                                  <th style="min-width:2px; font-size: 10px">2</th>
                                  <th style="min-width:2px; font-size: 10px">3</th>
                                  <th style="min-width:2px; font-size: 10px">4</th>
                                  <th style="min-width:2px; font-size: 10px">1</th>
                                  <th style="min-width:2px; font-size: 10px">2</th>
                                  <th style="min-width:2px; font-size: 10px">3</th>
                                  <th style="min-width:2px; font-size: 10px">4</th>
                                  <th style="min-width:2px; font-size: 10px">1</th>
                                  <th style="min-width:2px; font-size: 10px">2</th>
                                  <th style="min-width:2px; font-size: 10px">3</th>
                                  <th style="min-width:2px; font-size: 10px">4</th>
                                  <th style="min-width:2px; font-size: 10px">1</th>
                                  <th style="min-width:2px; font-size: 10px">2</th>
                                  <th style="min-width:2px; font-size: 10px">3</th>
                                  <th style="min-width:2px; font-size: 10px">4</th>
                                  <th style="min-width:2px; font-size: 10px">1</th>
                                  <th style="min-width:2px; font-size: 10px">2</th>
                                  <th style="min-width:2px; font-size: 10px">3</th>
                                  <th style="min-width:2px; font-size: 10px">4</th>
                                  <th style="min-width:2px; font-size: 10px">1</th>
                                  <th style="min-width:2px; font-size: 10px">2</th>
                                  <th style="min-width:2px; font-size: 10px">3</th>
                                  <th style="min-width:2px; font-size: 10px">4</th>
                                  <th style="min-width:2px; font-size: 10px">1</th>
                                  <th style="min-width:2px; font-size: 10px">2</th>
                                  <th style="min-width:2px; font-size: 10px">3</th>
                                  <th style="min-width:2px; font-size: 10px">4</th>
                                  <th style="min-width:2px; font-size: 10px">1</th>
                                  <th style="min-width:2px; font-size: 10px">2</th>
                                  <th style="min-width:2px; font-size: 10px">3</th>
                                  <th style="min-width:2px; font-size: 10px">4</th>
                                  <th style="min-width:2px; font-size: 10px">1</th>
                                  <th style="min-width:2px; font-size: 10px">2</th>
                                  <th style="min-width:2px; font-size: 10px">3</th>
                                  <th style="min-width:2px; font-size: 10px">4</th>
                                  <th style="min-width:2px; font-size: 10px">1</th>
                                  <th style="min-width:2px; font-size: 10px">2</th>
                                  <th style="min-width:2px; font-size: 10px">3</th>
                                  <th style="min-width:2px; font-size: 10px">4</th>

                                </tr>
                              </thead>
                              <tbody id="tbodyid">
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="box-footer clearfix">

                        </div>
                      </div>

                    </div>


                  </div>
                  <br>
                  <!-- <ul class="list-inline pull-right">
                    <li><button type="button" class="btn btn-default prev-step">Kembali</button></li>

                    <li><button type="submit" class="btn btn-primary btn-info-full next-step-pp">Simpan</button></li>
                  </ul> -->
                  <div class="row">

                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <a class="btn btn-block btn-warning btn-flat prev-step" >
                           <i class="fa fa-arrow-left"></i> Kembali
                          </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          </div>
                          <div class="col-md-3 col-sm-6 col-xs-12">

                          </div>

                          <div class="col-md-3 col-sm-6 col-xs-12">

                            <!-- <a class="btn btn-block btn-primary btn-flat next-step-pp" >
                             Lanjut  <i class="fa fa-arrow-right"></i>
                            </a> -->
                            <button type="submit" class="btn btn-block btn-primary btn-flat next-step-pp">Simpan <i class="fa fa-save"></i></button>
                          </div>




                  </div>
                </div>

                <div class="clearfix"></div>
              </div>

            </form>
          </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->

      </div>
      <!-- /.box -->

    </section>
