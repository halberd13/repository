<div align="right" style="margin-right: 10px;"> 
<!-- Form for highchart all kelurahan -->
        <form name="form-all-kelurahan" id="form-param-chart-jakut" method="POST" action="<?php echo Yii::app()->homeUrl; ?>/?r=jakut">
            <h5>
            Category 
            <select id="select-tahun" name="category" onchange="getChart()" style="width: auto;">
                <?php 
                foreach($category as $categorys){
                    if(isset($select[2]) && $categorys->idc_category==$select[2]){
                        echo '<option selected value="'.$select[2].'">'.$select[2].'</option>';
                    }else{
                        echo '<option value="'.$categorys->idc_category.'">'.$categorys->idc_category.'</option>';
                    }
                }
                ?>
            </select>
            Tahun 
            <select id="select-tahun" name="tahun" onchange="getChart()" style="width: auto;">
                <?php if(isset($select)){
                    echo '<option selected value="'.$select[0].'">'.$select[0].'</option>';
                } 
                foreach($selectTahun as $thns){
                    echo "<option value='".$thns['tahun']."'>".$thns['tahun']."</option>";
                 }?>    
                    
            </select>
            Bulan
            <select id="select-bulan" name="bulan" onchange="getChart()" style="width: auto;">
                <?php 
                if(isset($select)){
                    echo '<option selected value="'.$select[1][0].'">'.$select[1][1].'</option>';
                }
                
                    foreach($category_bulan as $key=>$bulan){
                         echo "<option value='".$key."'>".$bulan."</option>";
                    }
                ?>
            </select>
            </h5>
        </form>
</div>
<div id="jakut" class="box-chart" ></div>


<table class="table table-hover table-striped">
    <tr><td colspan="100%" style="text-align: center;background: transparent;color: #cd0a0a;"><h4><marquee behavior=”scroll”>Informasi Data Indicator Jakarta Utara <?php if(isset($select[0])){ echo $select[0];}else { echo date('D, d M Y');}?></marquee></h4></td></tr>

        <?php 
        echo "<tr><td rowspan=2>No</td>"
        . "<td style='background-color:transparent;text-align: right;'><i>kecamatan</i></td>";
            foreach($listKecamatan as $val){
                echo "<td rowspan=2 style='vertical-align:middle;background-color:#DDFFAA;'><b>".$val['kec_nama'].'</b></td>';
            }

        echo '</tr>';
        echo '<tr><td style="background-color:transparent;"><i>indikator</i></td></tr>';
        $i=0;
        $no=1;
    foreach($namaIndicator as $lists){
        echo '<tr><td>'.$no.'</td>'
        . '<td style="background-color:mediumaquamarine;">'.$lists['idc_nama'].'</td>';
        foreach($dataIndicator[$i] as $row){
            if($row['idc_nama']==$lists['idc_nama']){
               echo "<td style='text-align: center;'>".$row['dt_value'].'</td>';
            }
        }
        echo '</tr>';
     $i++;$no++;}?>
    
    <?php if(!Yii::app()->user->isGuest){ ?>
    <tfoot>
        <tr>
            <th colspan="100%" style="text-align: left;background-color:transparent;">
                <a target="_blank" class="btn btn-small btn-primary" href="<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=jakut/print&thn=<?php if(isset($select[0])){ echo $select[0];}else { echo date('Y');}?>&bln=<?php echo $select[1][0];?>">Print All</a>
            </th>
            
        </tr>
    </tfoot>
        <?php } ?>
</table>

<script type="text/javascript" language="javascript">
    $(document).ready(function (){
        $('#datatable').dataTable();
        
    });
    function getChart(){
        document.getElementById('form-param-chart-jakut').submit();
    }
    $(function () {
        // Create the chart
        $('#jakut').highcharts({
            chart: {
                type : 'column',
                backgroundColor:'rgba(255, 255, 255, 0.1)',
            },
            title: {
                text: 'Data Statistik Jakarta Utara Tahun '+ <?php if(isset($select[0])){ echo $select[0];}else {echo date('Y');}?>
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                    title: {
                        text: 'Jumlah'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
            legend: {
                enabled: false
            },
            
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: <?php echo $series;?>,
            drilldown: {
                series: <?php echo $drilldown;?>
            }
        });
    });


    
    
</script>