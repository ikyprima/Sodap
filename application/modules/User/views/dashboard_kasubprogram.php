<script type="text/javascript">
    $(document).ready(function () {
        $("#ksubpro-listprogram").click(function () {
            Pace.restart();
            Pace.track(function () {
                window.location.href = base_url + "User/ksubprolistprogram";
            });
        });
        $("#ksubpro-dpa").click(function () {
            Pace.restart();
            Pace.track(function () {
              window.location.href = base_url + "User/ksubprodpa";
            });
        });
        $("#ksubpro-angkas").click(function () {
            Pace.restart();
            Pace.track(function () {
              window.location.href = base_url + "User/ksubproangkas";
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
                    <h3>Semua</h3>
                    <p>Program dan Kegiatan</p>
                </div>
                <div class="icon">
                    <i class="fa ion-ios-paper"></i>
                </div>
                <a class="btn btn-block btn-social btn-success" id="ksubpro-listprogram">
                    <i class="fa fa-bars"></i> proses
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>DPA</h3>
                    <p>Dokumen Pelaksanaan Anggaran </p>
                </div>
                <div class="icon">
                    <i class="fa  ion-document-text"></i>
                </div>
                <a class="btn btn-block btn-social btn-success" id="ksubpro-dpa">
                    <i class="fa fa-bars"></i> proses
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>Aliran KAS</h3>
                    <p>Lihat Aliran KAS</p>

                </div>
                <div class="icon">
                    <i class="fa ion-clipboard"></i>
                </div>
                <a class="btn btn-block btn-social btn-success" id="ksubpro-angkas">
                    <i class="fa fa-bars"></i> proses
                </a>
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->

    </div>

</section>


<!-- /.content -->
