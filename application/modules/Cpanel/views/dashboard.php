<script type="text/javascript">
       $(document).ready(function() {
        ajaxtoken();
$('.contentHolder').each(function(){
    $(this).perfectScrollbar();
});
       });

</script>
<div class="content">

                <div class="container-fluid">

                  <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">swap_vertical_circle</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Master</p>
                                    <h3 class="card-title">API</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">

                                            <div class="dropdown pull-left">
                                                        <button type="button" class="btn btn-round btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-external-link"></i> Kelola API
                                                            <span class="caret"></span>
                                                        <div class="ripple-container"></div></button>
                                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                            <li>
                                                                <a href="<?php echo base_url('Cpanel/opd');?>">Master OPD</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo base_url('Cpanel/program');?>">Master Program</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo base_url('Cpanel/kegiatan');?>">Master Kegiatan</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo base_url('Cpanel/anggaran');?>">Master Anggaran</a>
                                                            </li>

                                                        </ul>
                                                    </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header" data-background-color="green">
                                    <i class="material-icons">supervised_user_circle</i>
                                </div>
                                <div class="card-content">
                                    <p class="category">Master</p>
                                    <h3 class="card-title">User</h3>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <!-- <i class="material-icons text-danger">import_export</i> -->
                                        <!-- <i class="fa fa-external-link text-danger"></i>
                                        <a href="#pablo">Kelola Halaman API</a> -->
                                           <div class="dropdown pull-left">
                                                        <button type="button" class="btn btn-round btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-external-link"></i> Kelola User
                                                            <span class="caret"></span>
                                                        <div class="ripple-container"></div></button>
                                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                            <li>
                                                                <a href="#action">Semua Pengguna</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo base_url('Cpanel/opduser');?>">Pengguna Per OPD</a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 ">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="red">
                                    <i class="material-icons">account_balance</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Control Panel</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                           <div class="material-datatables">
                                      <table id="list-opd-entri" class="table table-responsive table-hover" cellspacing="0" width="100%" style="width:100%">
                                       <thead class="text-info">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Unit / OPD</th>
                                                     <th>Status</th>
                                                    <th>Aksi</th>

                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Unit / OPD</th>
                                                     <th>Status</th>
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
                        <div class="col-md-4 ">
                            <div class="card ">
                                <div class="card-header card-header-icon" data-background-color="red">
                                    <i class="material-icons">timeline</i>
                                </div>
                                <div class="card-content ">
                                    <h4 class="card-title">History</h4>
                                    <div class="row contentHolder">
                                        <div class="col-md-12  ">



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>

            </div>
<div class="modal fade" id="dashboardmodal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>

                    <h5 class="modal-title"></h5>
            </div>

            <div class="modal-body">
                <div class="row">
                        <!-- <div class="col-md-2 ">
                            <br>
                            <h3>Detail</h3>
                        </div> -->
                        <div class="col-md-12 ">

                             <div class="card">

                                <div class="card-content">
                                    <p class="hide" id="idopd"></p>
                                     <blockquote>
                                <h4 class="info-text" id="namadinas"></h4>
                                <small id="admin"></small>

                                <br>

                            </blockquote>

                               <!--  <legend>Dokumen Pendukung</legend>
                                <table class="table table-hover">
                                        <thead class="text-warning">
                                          </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>SK-Kominfo 2018</td>

                                                <td>View</td>
                                            </tr>

                                        </tbody>
                                    </table> -->
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">access_time</i>
                                        <span class="label label-info" id="time"></span>
                                        <i class="material-icons">update</i>
                                        <span class="label label-info" id="status"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                </div>
                <p id="list"></p>
            </div>

            <div class="modal-footer modal-footer-tombol">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modaltolak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-small ">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <form class="form-horizontal">
                                        <div class="row">
                                            <label class="col-md-3 label-on-left">Alasan</label>
                                            <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="email" class="form-control">
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>



                                    </form>
                                                        </div>
                                                        <div class="modal-footer text-center">

                                                            <button type="button" class="btn btn-success btn-simple">Tolak</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
