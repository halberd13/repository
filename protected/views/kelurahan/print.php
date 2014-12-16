<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery.dataTables.css"/>
<script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.js' type='text/javascript'></script>
<script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.js' type='text/javascript'></script>
<script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.dataTables.min.js' type='text/javascript'></script>

<div class="container-fluid">
<table  class="table table-striped table-hover" style="min-width: 800px;">
        <tr>
            <th colspan="16" style="text-align: center;"><h4>Rincian Informasi Kelurahan</h4></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: left;">Nama Kecamatan</th>
            <th>:</th>
            <th colspan="4" style="text-align: left;"><?php echo $data[5];?></th>
            <th rowspan="5" colspan="10" style="text-align: center;max-width: 360px;"><img id="img-map"/></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: left;">Nama Kelurahan</th>
            <th>:</th>
            <th colspan="4" style="text-align: left;"><?php echo $data[1];?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: left;">Alamat</th>
            <th>:</th>
            <th colspan="4" style="text-align: left;"><?php echo $data[2];?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: left;">Lintang</th>
            <th>:</th>
            <th colspan="4" style="text-align: left;"><?php echo $data[3];?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: left;">Bujur</th>
            <th>:</th>
            <th colspan="4" style="text-align: left;"><?php echo $data[4];?></th>
        </tr>
        <tr>
            <th colspan="16" style="text-align: center;">
                <h4>Informasi Indicator Kelurahan Tahun <?php if($_GET['thn']!=null){ echo $_GET['thn'];}else echo date('Y');?></h4>
            </th>
        </tr>
                <tr>
                    <td rowspan="2" style="background-color: transparent;" >No</td>
                    <td style="text-align: right;background-color: transparent;" ><i>Month</i></td>
                    <?php 
                    foreach($data[6] as $key=>$bulan){
                       echo '<th rowspan=2 style="text-align: center;vertical-align: middle;">'.$bulan.'</th>'; 
                       
                    }
                    echo "<th rowspan=2 style='text-align: center;vertical-align: middle;'>Satuan</th>";

                    ?>
                </tr>
                <tr>
                    <td style="background-color:  transparent;"><i>Data Indicator</i></td>
                </tr>
                <?php 
                
                    foreach($listCategory as $ctgs){
                        echo "<tr><td colspan='15' style='background-color: cornsilk;color: #ff0000;'><b>".$ctgs->ctg_nama."</b></td></tr>";
                        $no=1;
                        for($i=0;$i<count($headerTableIndicator);$i++){
                            if($ctgs->ctg_nama==$headerTableIndicator[$i]['idc_category']){

                                echo "<tr><td>".$no."</td>"
                                . "<th style='background-color: lightsteelblue;text-align: left;'>".$headerTableIndicator[$i]['idc_nama']."</th>";

                                for($x=0; $x<count($rowInfoKelurahan);$x++){
                                        $rowTahun = substr($rowInfoKelurahan[$x]['dt_periode'],0,-2);
                                        if($headerTableIndicator[$i]['idc_id']==$rowInfoKelurahan[$x]['idc_id']){
                                            if(isset($data[7][0]) && $rowTahun==$data[7][0]){
                                                echo "<td style='text-align: center;'>".$rowInfoKelurahan[$x]['dt_value']."</td>";
                                            }else if($rowTahun==date('Y')){
                                                echo "<td style='text-align: center;'>".$rowInfoKelurahan[$x]['dt_value']."</td>";
                                            }else{
                                                    echo "<td>empty</td>";
                                            }

                                        }

                                }
                                echo "<td><i>".$headerTableIndicator[$i]['idc_satuan']."</i></td>";                                  

                                echo "</tr>";
                                
                            }
                        $no++;
                        }
                    }
                ?>
        <?php if(!Yii::app()->user->isGuest){ ?>
        <tr>
            <th colspan="14">
                <a id="print" class="btn btn-small btn-danger">Print Out</a> 
            </th>
            
        </tr>
        <?php } ?>
</table>
</div>





<script type="text/javascript">
    
var lat = <?php echo $data[3];?>;
var lng = <?php echo $data[4];?>;
var src = 'http://maps.googleapis.com/maps/api/staticmap?&zoom=14&size=400x260&markers=color:red|' + lat + ',' + lng + '&maptype=roadmap';

        
        

    $(document).ready(function (){
        $('#error').hide();
        $('#success').hide();
        $('.modal').hide();
        
        $('#img-map').attr('src', src);
        
        $('#print').click(function (){
            $('#print').css('display', 'none');
            select = $('select').html();
            $('select').replaceWith($('#tahun').val());
                window.print();
            $('#print').css('display', '');
        });
        
    });
    
    function selectTahun(){
        document.getElementById("form-tahun").submit();
    }
    

</script>