    <div align="right" style="margin-right: 10px;">
        <form name="form-kelurahan" id="form-param-chart-kelurahan" method="POST" action="<?php echo Yii::app()->homeUrl; ?>/?r=statistik&req=one">
            <h5>Pilih Kelurahan <select id="select-kelurahan" name="kel_id" onchange="getChart()">
            <?php 
            if(isset($select)){
                echo '<option selected value="'.$select[0].'">'.$select[1].'</option>';
            }
            for($i=0;$i<count($listKelurahan);$i++){
                echo '<option value="'.$listKelurahan[$i]['kel_id'].'">'.$listKelurahan[$i]['kel_nama'].'</option>';
            }?>
        </select>
        Category
        <select id="select-category" onchange="getChart()" name="category" style="width: auto;">
            <?php if(isset($select)){
                echo '<option selected value="'.$select[2].'">'.$select[2].'</option>';
            }?>
                <option value="Sosial">Sosial</option>
                <option value="Kesehatan">Kesehatan</option>
                <option value="Pemberdayaan Masyarakat dan Perempuan">Pemberdayaan Masyarakat dan Perempuan</option>
        </select>
        Tahun 
        <select id="select-tahun" onchange="getChart()" name="tahun" style="width: auto;">
            <?php if(isset($select[3])){
                echo '<option selected value="'.$select[3].'">'.$select[3].'</option>';
            }
            foreach($selectTahun as $thns){
                echo "<option value='".$thns['tahun']."'>".$thns['tahun']."</option>";
             }?>  
        </select>
        </h5>
        </form>
        
        <!-- Form for highchart all kelurahan -->
        <form name="form-all-kelurahan" id="form-param-chart-all-kelurahan" method="POST" action="<?php echo Yii::app()->homeUrl; ?>/?r=statistik&req=all">
            <h5>
            Category
            <select id="select-category" onchange="getChartAll()" name="category" style="width: auto;">
                <?php if(isset($select)){
                    echo '<option selected value="'.$select[2].'">'.$select[2].'</option>';
                }?>
                    <option value="Sosial">Sosial</option>
                    <option value="Kesehatan">Kesehatan</option>
                    <option value="Pemberdayaan Masyarakat dan Perempuan">Pemberdayaan Masyarakat dan Perempuan</option>
            </select>
            Tahun 
            <select id="select-tahun" name="tahun" onchange="getChartAll()" style="width: auto;">
                <?php if(isset($select)){
                    echo '<option selected value="'.$select[3].'">'.$select[3].'</option>';
                }
                foreach($selectTahun as $thns){
                    echo "<option value='".$thns['tahun']."'>".$thns['tahun']."</option>";
                 }?>  
            </select>
            Bulan
            <select id="select-bulan" name="bulan" onchange="getChartAll()" style="width: auto;">
                <?php 
                if(isset($select[4])){
                    echo '<option selected value="'.$select[4][0].'">'.$select[4][1].'</option>';
                }
                
                    foreach($category_bulan as $key=>$bulan){?>
                    <option value="<?php echo $key;?>"><?php echo $bulan;?></option>
                    <?php }?>
            </select>
            </h5>
        </form>
        <div class="btn-group" data-toggle="buttons-checkbox">
            <button type="button" class="btn btn-primary" id="show-all-kelurahan">Show All Kelurahan</button>
        </div>
    </div>
    <div id="statistik-kelurahan" class="box-chart"></div>
    <div id="statistik-all-kelurahan" class="box-chart3"></div>
    

<script type="text/javascript">
    $(document).ready(function (){
        selectKelurahan = $('#select-kelurahan option:selected').text();
        selectTahun = $('#select-tahun option:selected').text();
        selectCategory = $('#select-category option:selected').text();
        selectBulan = $('#select-bulan option:selected').text();
        if(<?php if(isset($_GET['req'])&& $_GET['req']=='all'){echo 1;}else{ echo 2;}?>==1){
            $('#statistik-kelurahan').hide();
            $('#form-param-chart-kelurahan').hide();
        }else{
            $('#statistik-all-kelurahan').hide();
            $('#form-param-chart-all-kelurahan').hide();
        }
        $('#show-all-kelurahan').click(function (){
            $('#statistik-kelurahan').slideToggle();
            $('#form-param-chart-kelurahan').slideToggle();
            $('#statistik-all-kelurahan').slideToggle();
            $('#form-param-chart-all-kelurahan').slideToggle();
        });
        
    });
    
    
    $(function () {
            $('#statistik-all-kelurahan').highcharts({
                title: {
                    text: '<strong>Statistik Data Indikator Kelurahan Jakarta Utara</strong>',
                    x: -20 //center
                },
                subtitle: {
                    text: 'Source: jakut.com',
                    x: -20
                },
                xAxis: {
                    categories: <?php echo $category_kel;?>,
                    labels: {
                        rotation: -40
                    }
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
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: <?php echo $series_kel;?>
            });
        });
        
    
    
    $(function () {
        $('#statistik-kelurahan').highcharts({
            chart: {
                type: 'column',
                backgroundColor:'rgba(255, 255, 255, 0.1)'
            },
            title: {
                text: '<strong>Statistik Data Kelurahan '+selectKelurahan+' Tahun '+selectTahun + 
                        '<br/>'+ 'Kategori Data ' + selectCategory + '</strong>'
            },
            subtitle: {
                text: 'Source: jakut.com'
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b> {point.y} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: <?php echo $series;?>
        });
    });

    function getChart(){
        document.getElementById('form-param-chart-kelurahan').submit();
    }
    function getChartAll(){
        document.getElementById('form-param-chart-all-kelurahan').submit();
    }

</script>