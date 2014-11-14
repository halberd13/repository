<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery.dataTables.css"/>
<script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.js' type='text/javascript'></script>
<script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.js' type='text/javascript'></script>
<script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.dataTables.min.js' type='text/javascript'></script>

<div class="container-fluid" id="printableArea">
    
<table class="table table-striped table-hover" id="page-table" >
        <tr>
            <th colspan="14" style="text-align: center;"><h4>Rincian Informasi Kecamatan</h4></th>
        </tr>
        <tr>
            <th style="max-width: 100px;">Nama Kecamatan</th>
            <th>:</th>
            <th colspan="4" style="max-width: 100px;"><?php echo $data[1];?></th>
            <th rowspan="4" colspan="13"><img id="img-map"/></th>
        </tr>
        <tr>
            <th>Alamat</th>
            <th>:</th>
            <th colspan="4" ><?php echo $data[2];?></th>
        </tr>
        <tr>
            <th>Lintang</th>
            <th>:</th>
            <th colspan="4" ><?php echo $data[3];?></th>
        </tr>
        <tr>
            <th>Bujur</th>
            <th>:</th>
            <th colspan="4"><?php echo $data[4];?></th>
        </tr>
        <tr>
            <th colspan="14" style="text-align: center;"> 
                Informasi Data Indicator <?php $_GET['thn'];?>
            </th>
        </tr>
        <?php 
        echo "<tr><td style='text-align: right;background-color: transparent;'><i>Month</i></td>";
        foreach($listMonth as $key=>$month){
            echo "<th rowspan=2 style='text-align: center;vertical-align: middle;background-color:lightgreen;'>".$month."</th>";
        }
        echo "<th rowspan=2 style='text-align: center;vertical-align: middle;background-color:lightgreen;'>Total</th>";
        echo "</tr>";
        echo "<tr><td style='text-align: right;background-color: transparent;'><i>Indikator</i></td></tr>";
        $x=0;
        foreach($listIndicator as $listIndicators){
            echo "<tr><th style='background-color: lightsteelblue;'>".$listIndicators->idc_nama."</th>";
            $total=0;
            
            for($i=0;$i<12;$i++){
                echo "<td style='text-align: center;'>".$dataIndicator[$x][$i]['dt_value']."</td>";
                $total=$total+$dataIndicator[$x][$i]['dt_value']; 
            }
            echo '<td style="text-align: left;">'.$total.' '.$listIndicators->idc_satuan.'</td>';
            echo "</tr>";
        $x++;
        }?>
        <tr>
            <th colspan="4">
                <a class="btn btn-small btn-danger" id="print">Print Out</a>
            </th>
            
        </tr>
        
        
    
</table>

</div>


            
<script type="text/javascript">
var namaPrint = "<?php echo $data[1];?>";    
var lat = <?php echo $data[3];?>;
var lng = <?php echo $data[4];?>;

var src = 'http://maps.googleapis.com/maps/api/staticmap?&zoom=16&size=380x260&markers=color:red|' + lat + ',' + lng + '&maptype=roadmap';
    $(document).ready(function (){
        $('#img-map').attr('src', src);
        
        $('#print').click(function (){
            $('#print').css('display', 'none');
            window.print();
            $('#print').css('display', '');
        });
        
        
        
        
    });
    
    

</script>