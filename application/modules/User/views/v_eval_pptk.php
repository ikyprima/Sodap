
<script type="text/javascript">
  $(document).ready(function() {




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
    <h3 class="box-title">Evaluasi Realisasi</h3>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <p class="text-left text-muted">* Perhitungan dari seluruh kegiatan </p>
        <table class="table table-bordered " style="font-size: 12px; '.$style.'">
          <thead >
            <tr class="bg-gray-active color-palette">
              <th rowspan="2" style="vertical-align : middle;text-align:center; ">PAGU TAHUN</th>
              <th colspan="3" style="vertical-align : middle;text-align:center; " >s/d BULAN SEKARANG</th>
              <th colspan="3" style="vertical-align : middle;text-align:center; " >BULAN SEKARANG</th>

            </tr>
            <tr class="bg-gray-active color-palette" >
              <th style="vertical-align : middle;text-align:center; " >ALIRAN KAS</th>
              <th style="vertical-align : middle;text-align:center; " >REALISASI</th>
              <th style="vertical-align : middle;text-align:center; " >PERSENTASE</th>
              <th style="vertical-align : middle;text-align:center; " >ALIRAN KAS</th>
              <th style="vertical-align : middle;text-align:center; " >REALISASI</th>
              <th style="vertical-align : middle;text-align:center; " >PERSENTASE</th>

            </tr>
            <tr class="bg-gray-active color-palette">
              <th style="vertical-align : middle;text-align:center; ">1</th>
              <th style="vertical-align : middle;text-align:center; width: 14%" >2</th>
              <th style="vertical-align : middle;text-align:center; width: 14%" >3</th>
              <th style="vertical-align : middle;text-align:center; width: 14%" >4 = (3 / 2) x 100</th>
              <th style="vertical-align : middle;text-align:center; width: 14%" >5</th>
              <th style="vertical-align : middle;text-align:center; width: 14%" >6</th>
              <th style="vertical-align : middle;text-align:center; width: 14%" >7 = (6 / 5) x 100</th>
            </tr>
            <tr class="bg-blue allSides">
              <th  style="vertical-align : middle;text-align:center;margin"><?php echo $this->template->rupiah($pagu[0]['tahun'])?></th>
              <th style="vertical-align : middle;text-align:center;" ><?php echo $this->template->rupiah($pagu[0]['blnsdskr'])?></th>
              <th style="vertical-align : middle;text-align:center;" ><?php echo $this->template->rupiah($realsd)?></th>
              <th style="vertical-align : middle;text-align:center;" ><?php echo $prsnrealsd.' %'?></th>
              <th style="vertical-align : middle;text-align:center;" ><?php echo $this->template->rupiah($pagu[0]['blnskr'])?></th>
              <th style="vertical-align : middle;text-align:center;" ><?php echo $this->template->rupiah($realbulnskr)?></th>
              <th style="vertical-align : middle;text-align:center;" ><?php echo $prsnrealskr.' %'?></th>
            </tr>
          </thead>
        </table>
      </div>

    </div>

     <hr>


    <?php
    $arraybuln = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember' );

    echo '<div id="menu">';
    echo '<div class="panel list-group">';
    foreach ($data as $i => $val) {

        if ($i==$bulan-1){
            $style = 'margin-left:0.4em;';
            echo '<a href="javascript:void(0)" class="list-group-item active allSides" data-toggle="collapse" data-target="#'.$i.'" data-parent="#menu" > <i class="fa fa-chevron-right"></i> <b>'.$val['nmbln'].'</b> </a>';
        }else{
            $style = '';
            echo '<a href="javascript:void(0)" class="list-group-item" data-toggle="collapse" data-target="#'.$i.'" data-parent="#menu"> <i class="fa fa-chevron-right"></i> <b>'.$val['nmbln'].'</b> </a>';
        }
        echo '<div id="'.$i.'" class="sublinks collapse" >';
        echo '<table class="table table-bordered table-striped table-condensed " style="font-size: 12px; '.$style.'">
                  <thead>
                    <tr>
                			<th rowspan="3" style="vertical-align : middle;text-align:center; width: 2%">No</th>
                			<th rowspan="3" style="vertical-align : middle;text-align:center; ">Kegiatan</th>
                			<th rowspan="3" style="vertical-align : middle;text-align:center; width: 18%">PPTK</th>
                			<th colspan="4" style="vertical-align : middle;text-align:center;">Keuangan s/d Bulan '.$val['nmbln'].'</th>
                			<th colspan="2" style="vertical-align : middle;text-align:center;">Fisik s/d Bulan '.$val['nmbln'].'</th>
                			<th rowspan="3" style="vertical-align : middle;text-align:center; width: 8%;">Status</th>
                			<th rowspan="3" style="vertical-align : middle;text-align:center;width: 7%;">Rincian Realisasi Bulan '.$val['nmbln'].'</th>
    		            </tr>
                		<tr>
                			<th colspan="2" style="vertical-align : middle;text-align:center;" class="danger">Target</th>
                			<th colspan="2" style="vertical-align : middle;text-align:center;" class="info">Realisasi</th>
                			<th  style="vertical-align : middle;text-align:center; width: 5%;" class="danger">Target</th>
                			<th  style="vertical-align : middle;text-align:center; width: 5%;" class="info">Realisasi</th>
                		</tr>
                		<tr>
                			<th style="vertical-align : middle;text-align:center; width: 4%;" class="danger">%</th>
                			<th style="vertical-align : middle;text-align:center; width: 9%;" class="danger">Rp</th>
                			<th style="vertical-align : middle;text-align:center; width: 4%" class="info">%</th>
                			<th style="vertical-align : middle;text-align:center; width: 9%;" class="info">Rp</th>
                      <th style="vertical-align : middle;text-align:center; width: 4%" class="danger">%</th>
                      <th style="vertical-align : middle;text-align:center; width: 4%" class="info">%</th>
                		</tr>
                    </thead>
                    <tbody>';

                    foreach ($val['det'] as $x => $value) {
                      if($value['prstarget']=='0.00'){
                        $capaian ='<span class="badge bg-green pull-right">&nbsp&nbsp&nbsp&nbspBelum Ada&nbsp&nbsp&nbsp&nbsp</span>';
                        $btndis='disabled';
                      }elseif($value['cpaian'] < 80){
                        $capaian ='<span class="badge bg-red pull-right">Belum Tercapai</span>';
                        $btndis='';
                      }else{
                        $capaian ='<span class="badge bg-blue pull-right">Sudah Tercapai</span>';
                        $btndis='';
                      }
                      $x++;
                      echo '<tr>
                        			<td style="vertical-align : middle;">'.$x.'</td>
                              <td style="vertical-align : middle;">'.$value['nmkeg'].'</td>
                              <td style="vertical-align : middle;">'.$value['pptk'].'</td>
                              <td style="vertical-align : middle;text-align:center" class="danger">'.$value['prstarget'].'</td>
                              <td style="vertical-align : middle;text-align:right" class="danger" >'.$value['nltskr'].'</td>
                              <td style="vertical-align : middle;text-align:center" class="info">'.$value['prsreal'].'</td>
                              <td style="vertical-align : middle;text-align:right" class="info">'.$value['realnl'].'</td>
                              <td style="vertical-align : middle;text-align:center" class="danger">'.$value['prstarfis'].'</td>
                              <td style="vertical-align : middle;text-align:center" class="info">'.$value['prsrealfis'].'</td>
                              <td style="vertical-align : middle; text-align:center">'.$capaian.'</td>
                              <td><button class="btn bg-blue margin '.$btndis.'">Detail<div class="ripple-container"></div></button></td>

                    		    </tr>';

                    }
              echo '</tbody>
                    </table>';
        echo '</div>';

    }

    // for ($i=0; $i < 12 ; $i++) {
    //   if ($i==$bulan-1){
    //       $style = 'margin-left:0.4em;';
    //       echo '<a href="javascript:void(0)" class="list-group-item active allSides" data-toggle="collapse" data-target="#'.$i.'" data-parent="#menu" > <i class="fa fa-chevron-right"></i> <b>'.$arraybuln[$i].'</b> </a>';
    //   }else{
    //       $style = '';
    //       echo '<a href="javascript:void(0)" class="list-group-item" data-toggle="collapse" data-target="#'.$i.'" data-parent="#menu"> <i class="fa fa-chevron-right"></i> <b>'.$arraybuln[$i].'</b> </a>';
    //   }
    //
    //     echo '<div id="'.$i.'" class="sublinks collapse" >';
    //     $x=0;
    //     echo '<table class="table table-bordered table-striped table-condensed " style="font-size: 12px; '.$style.'">
    //           <thead>
    //             <tr>
    //         			<th rowspan="3" style="vertical-align : middle;text-align:center; width: 2%">No</th>
    //         			<th rowspan="3" style="vertical-align : middle;text-align:center; ">Kegiatan</th>
    //         			<th rowspan="3" style="vertical-align : middle;text-align:center; width: 18%">PPTK</th>
    //         			<th colspan="4" style="vertical-align : middle;text-align:center;">Keuangan</th>
    //         			<th colspan="2" style="vertical-align : middle;text-align:center;">Fisik</th>
    //         			<th rowspan="3" style="vertical-align : middle;text-align:center; width: 8%;">Status</th>
    //         			<th rowspan="3" style="vertical-align : middle;text-align:center;width: 7%;">Detail</th>
		//             </tr>
    //         		<tr>
    //         			<th colspan="2" style="vertical-align : middle;text-align:center;">Target</th>
    //         			<th colspan="2" style="vertical-align : middle;text-align:center;">Realisasi</th>
    //         			<th rowspan="2" style="vertical-align : middle;text-align:center; width: 7%;">Target</th>
    //         			<th rowspan="2" style="vertical-align : middle;text-align:center; width: 7%;">Realisasi</th>
    //         		</tr>
    //         		<tr>
    //         			<th style="vertical-align : middle;text-align:center; width: 4%;">%</th>
    //         			<th style="vertical-align : middle;text-align:center; width: 8%;">Keuangan</th>
    //         			<th style="vertical-align : middle;text-align:center; width: 4%">%</th>
    //         			<th style="vertical-align : middle;text-align:center; width: 8%;">Keuangan</th>
    //         		</tr>
    //             </thead>
    //             <tbody>';
    //             foreach ($list as $key) {
    //               $x++;
    //               echo '<tr>
    //                 			<td>'.$x.'</td>
    //                       <td>'.$key['nmkegunit'].'</td>
    //                       <td>'.$key['idpnspptk'].'</td>
    //                       <td></td>
    //                       <td style="text-align:right"></td>
    //                       <td></td>
    //                       <td style="text-align:right"></td>
    //                       <td></td>
    //                       <td></td>
    //                       <td></td>
    //                       <td></td>
    //
    //             		    </tr>';
    //
    //             }
    //       echo '</tbody>
    //             </table>';
    //     // foreach ($list as $key) {
    //     //   $x++;
    //     //   if ($x % 2 == 0){
    //     //        $bg='bg-gray';
    //     //      }else{
    //     //        $bg='bg-white';
    //     //      }
    //     //      echo '<a href="javascript:void(0)" class="list-group-item medium '.$bg.'" data-id='.$key['kdkegunit'].'  style="margin-left:2em ;">'.$key['nmkegunit'].'</a>';
    //     // }
    //     echo '</div>';
    // }



  echo '</div>
        </div>';
    ?>
  </div>


  <div class="box-footer">

  </div>
<!-- /.box-footer-->

</div>
<!-- /.box -->

</section>
