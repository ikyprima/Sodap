
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/alertify.min.css') ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/themes/default.min.css') ?>"/>
<script src="<?php echo base_url('assets/alertify/alertify.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/orgchart/css/font-awesome.min.css')?> ">
<link rel="stylesheet" href="<?php echo base_url('assets/orgchart/css/jquery.orgchart.css')?>">
<link rel="stylesheet" href="<?php echo base_url('assets/orgchart/css/style.css')?>">
<link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/nestable/jquery-nestable.css')?>">

<style type="text/css">
  #chart-container { height:  620px; }
  .orgchart { background: #fff; }
  .orgchart td.left, .orgchart td.right, .orgchart td.top { border-color: #aaa; }
  .orgchart td>.down { background-color: #aaa; }
  .orgchart .middle-level .title { background-color: #006699; }
  .orgchart .middle-level .contents { border-color: #006699; }
  .orgchart .product-dept .title { background-color: #009933; }
  .orgchart .product-dept .contents { border-color: #009933; }
  .orgchart .rd-dept .title { background-color: #993366; }
  .orgchart .rd-dept .contents { border-color: #993366; }
  .orgchart .pipeline1 .title { background-color: #996633; }
  .orgchart .pipeline1 .contents { border-color: #996633; }
  .orgchart .frontend1 .title { background-color: #cc0066; }
  .orgchart .frontend1 .contents { border-color: #cc0066; }
</style>


<script type="text/javascript">
  $(document).ready(function () {

    ajaxtoken();
    $("#kelola-struktur").click(function() {
      Pace.restart ();
      Pace.track (function (){
          var konten = '';

        ajaxtoken();
        var token = localStorage.getItem("token");
        var idunit = '<?php echo $idopd ?>';
          $.ajax ({

          url: base_url+"User/jsonstrukturedit/"+idunit,
          type: "GET",

          complete: function(data){
            var jsonData = JSON.parse(data.responseText);
            // console.log(jsonData.id);
            // console.log(jsonData.parent);
            // console.log(jsonData.name);
            // function search(nameKey, myArray){
            //     for (var i=0; i < myArray.length; i++) {
            //         if (myArray[i].name === nameKey) {
            //             return myArray[i];
            //         }
            //     }
            // }

                          konten +=  '<div class="row">  '  +
                          '               <div class="col-md-4">  '  +
                          '                 <div class="row">  '  +
                          '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
                          '                     <h4 class="text-left text-muted">Jabatan</h4>  '  +
                          '                   </div>  '  +
                          '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
                          '                     <h4 class="text-center text-muted">:</h4>  '  +
                          '                   </div>  '  +
                          '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
                          '                     <h4 class="text-left text-muted">next ambil dari tbl jabatan</h4>  '  +
                          '                   </div>  '  +
                          '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
                          '                   </div>  '  +
                          '                 </div>  '  +
                          '                 <div class="row">  '  +
                          '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
                          '                     <h4 class="text-left text-muted">Nama Pegawai</h4>  '  +
                          '                   </div>  '  +
                          '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
                          '                     <h4 class="text-center text-muted">:</h4>  '  +
                          '                   </div>  '  +
                          '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
                          '                     <h4 class="text-left text-muted">next ambil dari tbl jabatan</h4>  '  +
                          '                   </div>  '  +
                          '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
                          '                   </div>  '  +
                          '                 </div>  '  +
                          '                 <div class="row">  '  +
                          '                   <div class="col-md-4 col-sm-4 col-xs-12">  '  +
                          '                     <h4 class="text-left text-muted">Parent</h4>  '  +
                          '                   </div>  '  +
                          '                   <div class="col-md-1 col-sm-1 col-xs-12">  '  +
                          '                     <h4 class="text-center text-muted">:</h4>  '  +
                          '                   </div>  '  +
                          '                   <div class="col-md-6 col-sm-8 col-xs-12">  '  +
                          '                     <h4 class="text-left text-muted">dengan kondisi</h4>  '  +
                          '                   </div>  '  +
                          '                   <div class="col-md-2 col-sm-2 col-xs-12">  '  +
                          '                   </div>  '  +
                          '                 </div>  '  +
                          '                 </div>  '  +
                          '               <div class="col-md-8">  '  +
                          '                 <div class="row">  '  ;
                          konten +='<div class="box box-primary box-solid">  '  +

                                         '     <div class="box-body">  ' ;
                           konten += '   <div class="dd nestable-with-handle" >  '  ;
                           // function create () {
                           //   for (x in jsonData.children) {
                           //     console.log(jsonData.children[x].id);
                           //   }
                           //   konten +='       <ol class="dd-list">  '  +
                           //
                           //   '           <li class="dd-item dd3-item" data-id="'+jsonData.id+'">  '  +
                           //   '               <div class="dd-handle dd3-handle">Drag</div>  '  +
                           //   '               <div class="dd3-content"><span id="label_show'+jsonData.id+'">'+jsonData.name+'</span></div>  '  +
                           //
                           //   '           </li>  '  +
                           //
                           //   '       </ol>  '  ;
                           // };
                             // create();

                          konten +=   '  <div id="struktur"></div>';
                          konten +=   '  </div>  ';
                          konten +=   '  </div>  ';
                          konten +=   '  </div>  ';
                          '                 </div>  '  +
                          '                 </div>  '  +
                          '                 </div> '  ;

                                           alertify.alert().destroy();

                                           alertify.confirm()
                                           .setHeader('Kelola Struktur Organisasi')
                                           .set({
                                             'resizable':true,
                                             'movable': false,
                                             'autoReset': true,
                                             'transition':'zoom',
                                             'labels': {
                                               ok:'Simpan', cancel:'Tutup'
                                             },
                                             'startMaximized':true,

                                             onok: function(){

                                             }
                                           })
                                           .resizeTo('60%','85%')
                                           .setContent(konten).show();
                                   function listify(strarr) {
                                   var l = $("<ol>").addClass("dd-list");
                                   $.each(strarr, function(i, v) {
                                     var c = $("<li>").addClass("dd-item dd3-item"),
                                      // <div class="dd-handle dd3-handle">Drag</div>  '
                                       h = $("<div>").addClass("dd-handle dd3-handle").text('Drag');
                                       i = $("<div>").addClass("dd3-content").text(v["name"]+' [ '+v['title']+' ]');
                                      // h = $("<div>").addClass("dd-handle dd3-handle").text(v["name"]);
                                     l.append(c.append(h,i));
                                     if (!!v["children"])
                                       c.append(listify(v["children"]));
                                   });
                                   return l;
                                 }
                                 var list = listify(jsonData);
                                 $("#struktur").append(list);
                                 $('.dd').nestable();

          },
          error: function(jqXHR, textStatus, errorThrown){
            var notification = alertify.notify('Terjadi Kesalahan, Reload Halaman', 'error', 3, function(){
              //nanti pakai javascript
              ajaxtoken();
                alertify.alert().destroy();
            });
            }
         });


      });

    });

  });

  $(function() {


  //   var datasource = {
  //     'name': 'Lao Lao',
  //     'title': 'general manager',
  //     'office': '白城',
  //     'children': [
  //       { 'name': 'Bo Miao', 'title': 'department manager', 'office': '北京' },
  //       { 'name': 'Su Miao', 'title': 'department manager', 'office': '北戴河',
  //         'children': [
  //           { 'name': 'Tie Hua', 'title': 'senior engineer', 'office': '北戴河' },
  //           { 'name': 'Hei Hei', 'title': 'senior engineer', 'office': '北戴河' }
  //         ]
  //       },
  //       { 'name': 'Yu Jie', 'title': 'department manager', 'office': '长春' },
  //       { 'name': 'Yu Li', 'title': 'department manager', 'office': '长春' },
  //       { 'name': 'Hong Miao', 'title': 'department manager', 'office': '长春' },
  //       { 'name': 'Yu Wei', 'title': 'department manager', 'office': '长春' },
  //       { 'name': 'Chun Miao', 'title': 'department manager', 'office': '长春' },
  //       { 'name': 'Yu Tie', 'title': 'department manager', 'office': '长春' }
  //     ]
  //   };
  //   var nodeTemplate = function(data) {
  //     return `
  //       <span class="office">${data.name}</span>
  //       <div class="title">${data.name}</div>
  //       <div class="contents">${data.title}</div>
  //     `;
  // };
    var nodeTemplate = function(data) {
      return `
        <div class="title">${data.name}</div>
        <div class="contents">${data.title}</div>
      `;
  };
 var idunit = '<?php echo $idopd ?>';
  // $('#chart-container').orgchart({
  //   //'data' : datasource,
  //     'data' : base_url+"User/jsonstruktur/"+idunit,
  //     'nodeTemplate': nodeTemplate
  // });
  var oc = $('#chart-container').orgchart({
    'data' : base_url+"User/jsonstruktur/"+idunit,
    'nodeTemplate': nodeTemplate,
    'pan': true,
    'zoom': true
  });

  oc.$chartContainer.on('touchmove', function(event) {
    event.preventDefault();
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
    <li><a href="#"><i class="fa fa-list"></i> List Program</a></li>
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

        <a class="btn btn-block btn-social bg-blue btn-flat" id="kelola-struktur">
          <i class="fa fa-users"></i> Kelola Struktur
        </a>
      </div>



    </div>
    <br>


<!-- Default box -->
<!-- <div class="ddy nestable-with-handle">

</div> -->
<div class="box box-primary">
  <div class="box-header with-border">
      <i class="fa fa-list"></i>
    <h3 class="box-title">Struktur Organisasi</h3>


    </div>
    <!-- <div class="box-body no-padding"> -->
    <div class="box-body ">
      <div id="chart-container"></div>
    </div>


<!-- /.box-body -->
<div class="box-footer">

</div>
<!-- /.box-footer-->

</div>
<!-- /.box -->

</section>











<!-- <div class="content">

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
      <a href="<?php echo base_url('User/kelola');?>" class="btn btn-block btn-danger" id="btn-singkron-opd">
        <i class="fa fa-refresh"></i> Kelola Organisasi
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
                                 <h4 class="card-title">Struktur OPD</h4>
                                    <div class="toolbar">
                                               Here you can write extra buttons/actions for the toolbar

                                    </div>
                                      <div id="chart-container"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div> -->
            <script type="text/javascript" src="<?php echo base_url('assets/orgchart/js/jquery.orgchart.js')?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/admin/plugins/nestable/jquery.nestable.js')?>"></script>
