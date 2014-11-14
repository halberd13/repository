<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/jquery.dataTables.css"/>
<script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.js' type='text/javascript'></script>
<script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.js' type='text/javascript'></script>
<script src='<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.dataTables.min.js' type='text/javascript'></script>


<table id='datatable' class="table table-hover table-striped">
    <tr><td colspan="8" style="text-align: center;background-color: darksalmon"><h4>Informasi Data Indicator Jakarta Utara <?php echo $namaBulan.' '.$_GET['thn']?></h4></td></tr>
    <?php 
    echo "<tr><td style='background-color:transparent;text-align: right;'><i>kecamatan</i></td>";
        foreach($listKecamatan as $val){
            echo "<td rowspan=2 style='vertical-align:middle;background-color:#DDFFAA;'><b>".$val['kec_nama'].'</b></td>';
        }
        echo "<td rowspan=2 style='text-align: center;vertical-align:middle;background-color:#DDFFAA;'><b>Total</b></td>";
    echo '</tr>';
    echo '<tr><td style="background-color:transparent;"><i>indikator</i></td></tr>';
    $i=0;
    
    foreach($namaIndicator as $lists){
        echo '<tr><td style="background-color:mediumaquamarine;">'.$lists['idc_nama'].'</td>';
        $total=0;
        $satuan=null;
        foreach($dataIndicator[$i] as $row){
            if($row['idc_nama']==$lists['idc_nama']){
               echo "<td style='text-align: center;'>".$row['dt_value'].'</td>';
               $total=$total+$row['dt_value'];
               $satuan=$row['idc_satuan'];
            }
        }
        echo "<td style='text-align: left;'>".$total.' '.$satuan."</td>";
        echo '</tr>';
     $i++;}?>
        <tr>
            <th colspan="4">
                <a class="btn btn-small btn-danger" id="print">Print Out</a>
            </th>
            
        </tr>
<script type="text/javascript" language="javascript">
    $(document).ready(function (){
        $('#print').click(function (){
            $('#print').css('display', 'none');
            window.print();
            $('#print').css('display', '');
        });
        
        
        
        
    });


    
    
</script>