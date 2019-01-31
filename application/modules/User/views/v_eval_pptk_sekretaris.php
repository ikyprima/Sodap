<script type="text/javascript">

  $(document).ready(function() {

  //rizky.initMaterialWizard();

  ajaxtoken();




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
      <h3 class="box-title">List Kegiatan</h3>


      </div>
      <div class="box-body">
        <div class="row">
         <div class="col-md-1 col-sm-1 col-xs-12">
         </div>
             <div class="col-md-4 col-sm-4 col-xs-12">
              <h4 class="text-left text-muted">Pagu Tahun</h4>
            </div>
            <div class="col-md-1 col-sm-1 col-xs-12">
             <h4 class="text-center text-muted">:</h4>
           </div>
           <div class="col-md-4 col-sm-4 col-xs-12">
            <h4 class="text-left text-muted"><?php echo $this->template->rupiah($datapagu[0]['tahun'])?></h4>

           </div>
           <div class="col-md-2 col-sm-2 col-xs-12">
           </div>
         </div>
         <div class="row">
          <div class="col-md-1 col-sm-1 col-xs-12">
          </div>
              <div class="col-md-4 col-sm-4 col-xs-12">
               <h4 class="text-left text-muted">Kas Sampai Bulan Sekarang</h4>
             </div>
             <div class="col-md-1 col-sm-1 col-xs-12">
              <h4 class="text-center text-muted">:</h4>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <h4 class="text-left text-muted"><?php echo $this->template->rupiah($datapagu[0]['blnsdskr'])?></h4>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
            </div>
          </div>
          <div class="row">
           <div class="col-md-1 col-sm-1 col-xs-12">
           </div>
               <div class="col-md-4 col-sm-4 col-xs-12">
                <h4 class="text-left text-muted">Kas Bulan Sekarang</h4>
              </div>
              <div class="col-md-1 col-sm-1 col-xs-12">
               <h4 class="text-center text-muted">:</h4>
             </div>
             <div class="col-md-4 col-sm-4 col-xs-12">
                 <h4 class="text-left text-muted"><?php echo $this->template->rupiah($datapagu[0]['blnskr'])?></h4>
             </div>
             <div class="col-md-2 col-sm-2 col-xs-12">
             </div>
           </div>
           <div class="row">
            <div class="col-md-1 col-sm-1 col-xs-12">
            </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                 <h4 class="text-left text-muted">Persentase Realiasi Bulan Sekarang</h4>
               </div>
               <div class="col-md-1 col-sm-1 col-xs-12">
                <h4 class="text-center text-muted">:</h4>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-12">

              </div>
              <div class="col-md-2 col-sm-2 col-xs-12">
              </div>
            </div>
         <hr>
         <br>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
              <tr>
                  <td rowspan="3" style="text-align: center;white-space: nowrap;width: 1%;vertical-align: middle"><strong>No</strong></td>
                  <td rowspan="3" style="vertical-align: middle;text-align: center"><strong>Kegiatan</strong></td>
                  <td rowspan="3" style="text-align: center;vertical-align: middle"><strong>PPTK</strong></td>
                  <td colspan="4" style="text-align: center;white-space: nowrap;width: 1%"><strong>Keuangan</strong></td>
                  <td colspan="2" style="text-align: center;white-space: nowrap;width: 1%"><strong>Fisik</strong></td>
                  <td rowspan="3" style="text-align: center;white-space: nowrap;width: 1%;vertical-align: middle"><strong>Status</strong></td>
                  <td rowspan="3" style="text-align: center;white-space: nowrap;width: 1%;vertical-align: middle"><strong>Detail</strong></td>
              </tr>
              <tr>
                  <td colspan="2" style="text-align: center;white-space: nowrap;width: 1%"><strong>Target</strong></td>
                  <td colspan="2" style="text-align: center;white-space: nowrap;width: 1%"><strong>Realisasi</strong></td>
                  <td rowspan="2" style="text-align: center;white-space: nowrap;width: 1%;vertical-align: middle"><strong>Target</strong></td>
                  <td rowspan="2" style="text-align: center;white-space: nowrap;width: 1%;vertical-align: middle"><strong>Realisasi</strong></td>
              </tr>
              <tr>
                  <td style="text-align: center"><strong>%</strong></td>
                  <td style="text-align: center"><strong>Keuangan</strong></td>
                  <td style="text-align: center"><strong>%</strong></td>
                  <td style="text-align: center"><strong>Keuangan</strong></td>
              </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;
                foreach ($list as $row){
                    $i++;


                  echo'<tr>
                  <td>'.$i.'</td>
                  <td class="idtab" style="display:none;">'.$row['id'].'</td>
                  <td class="id" style="display:none;">'.$row['kdkegunit'].'</td>
                  <td>'.$row['nmkegunit'].'</td>
                  <td >'.$row['idpnspptk'].'</td>

                  </tr>';

              }

              ?>

              </tbody>
        </table>
    </div>
</div>
<!-- +++++++AGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNG -->
<div class="modal fade" id="modaldafkeg" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>


            </div>

            <div class="modal-body">
               <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                              <div class="card-header card-header-icon" data-background-color="blue">
                                    <i class="material-icons">assignment</i>
                                </div>
                              <div class="card-content">
                              <h4 class="card-title modal-title"></h4>
                                <div class="toolbar">


                                </div>
                              <br>
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 text-muted" style="text-align: left">Nama Kegiatan</div>
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: right;width: 5px">:</div>
                                    <div class="col-md-9 col-sm-9 text-muted" style="padding-left: 25px"><p id="namakegiatan"></p></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-2 col-sm-2 text-muted" style="text-align: left">Nilai Kegiatan</div>
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: right;width: 5px">:</div>
                                    <div class="col-md-9 col-sm-9 text-muted" style="padding-left: 25px"><p id="nilai"></p></div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 text-muted" style="text-align: left">Nama PPTK</div>
                                    <div class="col-md-1 col-sm-1 text-muted" style="text-align: right;width: 5px">:</div>
                                    <div class="col-md-9 col-sm-9 text-muted" style="padding-left: 25px"><p id="namapptk"></p></div>
                                </div>
                                <br>
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

            </div>

            <div class="modal-footer modal-footer-tombol">

            </div>
        </div>
    </div>
</div>
<!-- AGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNGAGUNG+++++++++ -->
<!-- /.box-body -->
<div class="box-footer">
  Footer
</div>
<!-- /.box-footer-->

</div>
<!-- /.box -->

</section>
