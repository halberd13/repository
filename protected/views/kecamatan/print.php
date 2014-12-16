<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery.dataTables.css"/>
<script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.js' type='text/javascript'></script>
<script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.js' type='text/javascript'></script>
<script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.dataTables.min.js' type='text/javascript'></script>

<div class="container-fluid" id="printableArea">
    
<table class="table table-hover" id="page-table" >
        <tr>
            <th colspan="15" style="text-align: center;"><h4>Rincian Informasi Kecamatan</h4></th>
        </tr>
        <tr>
            <th colspan="2" style="max-width: 100px;">Nama Kecamatan</th>
            <th>:</th>
            <th colspan="4" style="max-width: 100px;"><?php echo $data[1];?></th>
            <th rowspan="4" colspan="13"><img id="img-map"/></th>
        </tr>
        <tr>
            <th colspan="2">Alamat</th>
            <th>:</th>
            <th colspan="4" ><?php echo $data[2];?></th>
        </tr>
        <tr>
            <th colspan="2">Lintang</th>
            <th>:</th>
            <th colspan="4" ><?php echo $data[3];?></th>
        </tr>
        <tr>
            <th colspan="2">Bujur</th>
            <th>:</th>
            <th colspan="4"><?php echo $data[4];?></th>
        </tr>
        <tr>
            <th colspan="15" style="text-align: center;"> 
        <h4>Informasi Data Indicator <?php if(isset($_GET['thn'])){echo $_GET['thn'];}else echo date('Y');?></h4>
            </th>
        </tr>
        <?php 
        echo "<tr><td rowspan='2' style='text-align: center;'>No</td>"
        . "<td style='text-align: right;background-color: transparent;'><i>Month</i></td>";
        foreach($listMonth as $key=>$month){
            echo "<th rowspan=2 style='text-align: center;vertical-align: middle;'>".$month."</th>";
        }
        echo "<th rowspan=2 style='text-align: center;vertical-align: middle;'>Satuan</th>";
        echo "</tr>";
        echo "<tr><td style='text-align: left;background-color: transparent;'><i>Indikator</i></td></tr>";
        $x=0;
        $no=1;
        foreach($listCategory as $ctgs){
            echo "<tr><td colspan='15' style='background-color: cornsilk;color: #ff0000;'><b>".$ctgs->ctg_nama."</b></td></tr>";
            
            foreach($listIndicator as $listIndicators){
            
                if($ctgs->ctg_nama == $listIndicators->idc_category){
                    echo "<tr><td>".$no."</td>"
                    . "<th style='background-color: lightsteelblue;'>".$listIndicators->idc_nama."</th>";
                    for($i=0;$i<12;$i++){
                        echo "<td style='text-align: center;'>".$dataIndicator[$x][$i]['dt_value']."</td>";
                    }
                    echo '<td style="text-align: left;">'.$listIndicators->idc_satuan.'</td>';
                    echo "</tr>";
                    $x++;
                    $no++;
                }
            }
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