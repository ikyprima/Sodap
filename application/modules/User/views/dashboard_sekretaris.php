<script type="text/javascript">
    $(document).ready(function () {
        $("#dashkeg").click(function () {
            Pace.restart();
            Pace.track(function () {
                window.location.href = base_url + "User/kakppk";
            });
        });
        $("#dashevalpptk").click(function () {
            Pace.restart();
            Pace.track(function () {
                window.location.href = base_url + "User/dafevalsekretaris";
            });
        });
        $("#dashrealopd").click(function () {
            Pace.restart();
            Pace.track(function () {
                window.location.href = base_url + "User/evaluasi-semua-sekretaris";
            });
        });
    });

</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        SODAP
        <small>Kota Payakumbuh</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
</section>
<!-- Main content -->
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
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>List</h3>
                    <p>Kegiatan</p>
                </div>
                <div class="icon">
                    <i class="fa ion-android-list"></i>
                </div>
                <a class="btn btn-block btn-social btn-success" id="dashkeg">
                    <i class="fa fa-bars"></i> proses
                </a>
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>Evaluasi</h3>
                    <p>Realisasi Kegiatan PPTK</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a class="btn btn-block btn-social btn-success" id="dashevalpptk">
                    <i class="fa fa-bars"></i> proses
                </a>
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>Evaluasi</h3>
                    <p>Semua Kegiatan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a class="btn btn-block btn-social btn-success" id="dashrealopd">
                    <i class="fa fa-bars"></i> proses
                </a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- <div class="row col-md-12 col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border" style="font-size: 18px">
                <center><strong>Realisasi</strong></center>
            </div>
            <div class="box-body table-responsive">
                <br>
                <div class="row col-md-offset-1 col-md-10 col-sm-10 col-xs-10">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <strong>Pagu Tahun</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?php echo $pagu_tahun; ?>
                    </div>
                </div>
                <div class="row col-md-12">
                    <br>
                </div>
                <div class="row col-md-offset-1 col-md-10 col-sm-10 col-xs-10">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <strong>Angkas sampai bulan ini</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?php echo $angkas_bulan; ?>
                    </div>
                </div>
                <div class="row col-md-12">
                    <br>
                </div>
                <div class="row col-md-offset-1 col-md-10 col-sm-10 col-xs-10">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <strong>Angkas bulan ini</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?php echo $angkas_bulan_ini; ?>
                    </div>
                </div>
                <div class="row col-md-12">
                    <br>
                </div>
                <div class="row col-md-offset-1 col-md-10 col-sm-10 col-xs-10">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <strong>Persentase realisasi bulan ini</strong>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?php echo $persen_realisasi; ?>
                    </div>
                </div>
                <div class="row col-md-12">
                    <br>
                </div>
                <div class="row col-md-12 col-sm-12 col-xs-12">
                    <br>
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
                        <?php $no = 1;
                        foreach ($kegiatan as $keg){
                        foreach ($lspptk as $pptk) {
                            if ($keg['idpnspptk'] == $pptk['nip']) {
                                ?>
                                <tr>
                                    <td style="text-align: center;vertical-align: middle"><?php echo $no; ?></td>
                                    <td style="vertical-align: middle" id="keg<?php echo $keg['kdkegunit'] ?>"><?php echo '<strong>'.$keg['nmkegunit'].'</strong>'; ?></td>
                                    <td style="vertical-align: middle"><?php echo $pptk['nama']; ?></td>
                                    <td style="text-align: center;white-space: nowrap;width: 1%;vertical-align: middle">
                                        <?php
                                        $tb = 0;
                                        foreach ($det_angkas_bulan_ini as $det) {
                                            if ($det['kdkegunit'] == $keg['kdkegunit']) {
                                                $tb += $det['nilai']; //tb : total angkas bulan
                                            }
                                        }
                                        $angkas = 0;
                                        foreach ($data_angkas_hbs as $a) {
                                            if ($a['kdkegunit'] == $keg['kdkegunit']) {
                                                $angkas += $a['total_angkas'];
                                            }
                                        }
                                        $angkastahun = 0;
                                        foreach ($det_angkas_satu_tahun as $dast){
                                            if($dast['kdkegunit']==$keg['kdkegunit']){
                                                $angkastahun += $dast['total_angkas'];
                                            }
                                        }

                                        $target = $tb+$angkas;
                                        $persen = ($target/$angkastahun)*100;
                                        echo $persen;
                                        ?>
                                    </td>
                                    <td style="text-align: right;white-space: nowrap;width: 1%;vertical-align: middle">
                                        <?php
                                        $tb = 0;
                                        foreach ($det_angkas_bulan_ini as $det) {
                                            if ($det['kdkegunit'] == $keg['kdkegunit']) {
                                                $tb += $det['nilai']; //tb : total angkas bulan
                                            }
                                        }
                                        $angkas = 0;
                                        foreach ($data_angkas_hbs as $a) {
                                            if ($a['kdkegunit'] == $keg['kdkegunit']) {
                                                $angkas += $a['total_angkas'];
                                            }
                                        }
                                        $target = $tb+$angkas;
                                        echo $this->template->rupiah($target);
                                        ?>
                                    </td>
                                    <td style="text-align: center;white-space: nowrap;width: 1%;vertical-align: middle">
                                        <?php
                                        $jum = 0;
                                        foreach ($data_realisasi as $d_real) {
                                            if ($d_real['kdkegunit'] == $keg['kdkegunit']) {
                                                $jum += $d_real['jumlah_harga'];
                                            }
                                        }
                                        $tb = 0;
                                        foreach ($det_angkas_bulan_ini as $det) {
                                            if ($det['kdkegunit'] == $keg['kdkegunit']) {
                                                $tb += $det['nilai']; //tb : total angkas bulan
                                            }
                                        }
                                        $trhbs = 0;
                                        foreach ($data_realisasi_hbs as $r) {
                                            if ($r['kdkegunit'] == $keg['kdkegunit']) {
                                                $trhbs += $r['jumlah_harga']; //total realisasi hingga bulan sebelumnya : trhbs
                                            }
                                        }
                                        $angkas = 0;
                                        foreach ($data_angkas_hbs as $a) {
                                            if ($a['kdkegunit'] == $keg['kdkegunit']) {
                                                $angkas += $a['total_angkas'];
                                            }
                                        }
                                        $sisa_angkas_hbs = ($angkas - $trhbs); //sisa angkas hingga bulan sebelumnya
                                        $ta = $sisa_angkas_hbs + $tb;
                                        if($ta!=0)
                                        $persen = round(($jum / $ta) * 100, 2);
                                        echo $persen; ?>
                                    </td>
                                    <td style="text-align: center;white-space: nowrap;width: 1%;vertical-align: middle">
                                        <?php $jum = 0;
                                        foreach ($data_realisasi as $d_real) {
                                            if ($d_real['kdkegunit'] == $keg['kdkegunit']) {
                                                $jum += $d_real['jumlah_harga'];
                                            }
                                        }
                                        $totbmodalbi = 0;
                                        if($det_real_bmodalbi!=0){
                                          foreach ($det_real_bmodalbi as $drbmbi) {
                                            // code...
                                            if($drbmbi['kdkegunit']==$keg['kdkegunit']){
                                              $totbmodalbi+=$drbmbi['nilai_ktrk'];
                                            }
                                          }
                                        }
                                        echo $this->template->rupiah($jum+$totbmodalbi); ?>
                                    </td>
                                    <td style="text-align: center;white-space: nowrap;width: 1%;vertical-align: middle">
                                        <?php
                                        $no_target = '<span class="badge" style="background-color: red">belum ada target</span>';
                                        $total_target = array(0);
                                        $total_target_hbi = array(0);
                                        if($data_schedule!=0){
                                          foreach ($data_schedule as $ds){
                                              for($i=1;$i<=12;$i++){
                                                  if($ds['kdkegunit']==$keg['kdkegunit']){
                                                      $total_target[] += strlen($ds['bulan_'.$i]);
                                                  }
                                              }
                                              for($i=1;$i<=date('m');$i++){
                                                  if($ds['kdkegunit']==$keg['kdkegunit']){
                                                      $total_target_hbi[] += strlen($ds['bulan_'.$i]);
                                                  }
                                              }
                                          }
                                        }
                                        $total = array_sum($total_target);
                                        $target_hbi = array_sum($total_target_hbi);
                                        if($total==0){
                                            $persen_fisik = $no_target;
                                        }else{
                                            $persen_fisik = round(($target_hbi/$total)*100,2).' %';
                                        }
                                        echo $persen_fisik;
                                        ?>
                                    </td>
                                    <td style="text-align: center;white-space: nowrap;width: 1%;vertical-align: middle">
                                        <?php
                                        $real_fisik = 0;
                                        if($data_real_fisik!=0){
                                          foreach ($data_real_fisik as $drf){
                                              if($drf['kdkegunit']==$keg['kdkegunit']){
                                                  $real_fisik+=$drf['bobot_real'];
                                              }
                                          }
                                        }else{

                                        }

                                        echo $real_fisik.' %';
                                            ?>
                                    </td>
                                    <td style="text-align: center;white-space: nowrap;width: 1%;vertical-align: middle">
                                        <?php
                                        $jum = 0;
                                        foreach ($data_realisasi as $d_real) {
                                            if ($d_real['kdkegunit'] == $keg['kdkegunit']) {
                                                $jum += $d_real['jumlah_harga'];
                                            }
                                        }
                                        $tb = 0;
                                        foreach ($det_angkas_bulan_ini as $det) {
                                            if ($det['kdkegunit'] == $keg['kdkegunit']) {
                                                $tb += $det['nilai']; //tb : total angkas bulan
                                            }
                                        }
                                        $trhbs = 0;
                                        foreach ($data_realisasi_hbs as $r) {
                                            if ($r['kdkegunit'] == $keg['kdkegunit']) {
                                                $trhbs += $r['jumlah_harga']; //total realisasi hingga bulan sebelumnya : trhbs
                                            }
                                        }
                                        $angkas = 0;
                                        foreach ($data_angkas_hbs as $a) {
                                            if ($a['kdkegunit'] == $keg['kdkegunit']) {
                                                $angkas += $a['total_angkas'];
                                            }
                                        }
                                        $sisa_angkas_hbs = ($angkas - $trhbs); //sisa angkas hingga bulan sebelumnya
                                        $ta = $sisa_angkas_hbs + $tb;
                                        if($ta!=0)
                                        $persen = ($jum / $ta) * 100;
                                        if($persen>=80){
                                            $status = '<span class="badge" style="background-color: green">tercapai</span>';
                                        }else{
                                            $status = '<span class="badge" style="background-color: red">belum tercapai</span>';
                                        }
                                        echo $status; ?>
                                    </td>
                                    <td style="text-align: center;white-space: nowrap;width: 1%">
                                        <button id="<?php echo $keg['kdkegunit']; ?>"
                                                onclick="detail('<?php echo $keg['kdkegunit']; ?>')"
                                                class="btn btn-primary btn-flat btn-sm btn-social"><i
                                                    class="fa fa-list"></i> detail
                                        </button>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                        <?php $no++;
                        } ?>
                    </table>
                </div>
            </div>
        </div>
    </div> -->
</section>
<!-- include the style -->
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/alertify.min.css') ?>"/>
<!-- include a theme -->
<link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/themes/default.min.css') ?>"/>
<!-- include the script -->
<script src="<?php echo base_url('assets/alertify/alertify.min.js') ?>"></script>
<script type="application/javascript">
    function detail(kdkegunit) {
        $.ajax({
            url: '<?php echo base_url('User/getjsonrealisasi/'); ?>' + kdkegunit,
            type: 'GET',
            success: function (data) {
                if (JSON.parse(data) != 0) {
                    console.log(JSON.parse(data).datar);
                    var tr = '';
                    for (i = 0; i < JSON.parse(data).matangr.length; i++) {
                        tr += '<tr style="background-color: #f7f3f7">' +
                            '<td style="text-align:center;vertical-align: middle"><strong>' + JSON.parse(data).matangr[i].kdper + '</strong></td>' +
                            '<td><strong>' + JSON.parse(data).matangr[i].nmper + '</strong></td>' +
                            '<td></td>' +
                            '<td></td>' +
                            '<td></td>' +
                            '<td></td>' +
                            '<td></td>' +
                            '<td style="text-align:center;vertical-align: middle"><strong>' + JSON.parse(data).matangr[i].sisa_dana + '</strong></td>' +
                            '</tr>';
                        for (j = 0; j < JSON.parse(data).datar.length; j++) {
                            if ((JSON.parse(data).matangr[i].mtgkey) == (JSON.parse(data).datar[j].mtgkey)) {
                                tr += '<tr>' +
                                    '<td></td>' +
                                    '<td style="text-align:left">' + JSON.parse(data).datar[j].urn + '</td>' +
                                    '<td style="text-align:center;vertical-align:middle">' + JSON.parse(data).datar[j].vol + '</td>' +
                                    '<td style="text-align:center;vertical-align:middle">' + JSON.parse(data).datar[j].satuan + '</td>' +
                                    '<td style="text-align:center;vertical-align:middle">' + JSON.parse(data).datar[j].harga_satuan + '</td>' +
                                    '<td style="text-align:center;vertical-align:middle">' + JSON.parse(data).datar[j].jumlah_harga + '</td>' +
                                    '<td style="text-align:center;vertical-align:middle">' + JSON.parse(data).datar[j].nm_dana + '</td>' +
                                    '<td style="text-align:center;vertical-align:middle">' + JSON.parse(data).datar[j].sisa_dana + '</td>' +
                                    '</tr>';
                            }
                        }
                    }
                    var header = document.getElementById('keg' + kdkegunit).innerHTML;
                    var tb = '<table class="table table-bordered table-condensed table-hover" width="100%">\n' +
                        '                        <thead>\n' +
                        '                        <tr>\n' +
                        '                           <td rowspan="3" style="text-align: center;vertical-align: middle;white-space: nowrap;width: 1%"><strong>Kode\n' +
                        '                                    Rekening</strong></td>\n' +
                        '                            <td colspan="5" style="text-align: center;vertical-align: middle"><strong>Realisasi</strong>\n' +
                        '                            </td>\n' +
                        '                            <td rowspan="3"\n' +
                        '                                style="text-align: center;vertical-align: middle;white-space: nowrap;width: 1%"><strong>Sumber\n' +
                        '                                    Dana</strong></td>\n' +
                        '                            <td rowspan="3"\n' +
                        '                                style="text-align: center;vertical-align: middle;white-space: nowrap;width: 1%"><strong>Sisa\n' +
                        '                                    Dana</strong></td>\n' +
                        '                        </tr>\n' +
                        '                        <tr>\n' +
                        '                            <td rowspan="2"\n' +
                        '                                style="text-align: center;vertical-align: middle;white-space: nowrap;width: 1%"><strong>Uraian</strong>\n' +
                        '                            </td>\n' +
                        '                            <td rowspan="2"\n' +
                        '                                style="text-align: center;vertical-align: middle;white-space: nowrap;width: 1%"><strong>Volumes</strong>\n' +
                        '                            </td>\n' +
                        '                            <td rowspan="2"\n' +
                        '                                style="text-align: center;vertical-align: middle;white-space: nowrap;width: 1%"><strong>Satuan</strong>\n' +
                        '                            </td>\n' +
                        '                            <td rowspan="2"\n' +
                        '                                style="text-align: center;vertical-align: middle;white-space: nowrap;width: 1%"><strong>Harga\n' +
                        '                                    Satuan</strong></td>\n' +
                        '                            <td rowspan="2"\n' +
                        '                                style="text-align: center;vertical-align: middle;white-space: nowrap;width: 1%"><strong>Jumlah</strong>\n' +
                        '                            </td>\n' +
                        '                        </tr>\n' +
                        '                        <tr>\n' +
                        '\n' +
                        '                        </tr>\n' +
                        '                        </thead>\n' +
                        '                        <tbody id="tb-data">\n' +
                        '\n' +
                        '                        </tbody>\n' +
                        '                    </table>';
                    alertify.defaults.glossary.title = '<center>Detail Realisasi <strong>' + header + '</strong></center>';
                    alertify.confirm(tb, function () {
                        alertify.success('Telah Dikonfirmasi!')
                    }, function () {
                        alertify.error('Dibatalkan!')
                    }).set({transition: 'zoom'}).maximize().set({
                        labels: {ok: 'Konfirmasi', cancel: 'Batal'},
                        padding: false
                    }).set('defaultFocus', 'cancel');
                    document.getElementById('tb-data').innerHTML = tr;
                } else {
                    var header = document.getElementById('keg' + kdkegunit).innerHTML;
                    alertify.defaults.glossary.title = 'Info!';
                    alertify.alert('<div class="text-red">Belum ada realisasi <strong style="color: #000000" "> Kegiatan ' + header + '!</strong></div>').set({transition: 'zoom'});
                }
            }
        });
    }
</script>
<!-- /.content -->
