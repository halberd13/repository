<div class="container-fluid" id="printableArea">    
<table class="table table-striped table-hover" id="page-table" >
        <tr>
            <th colspan="14" style="text-align: center;background-color: lightgray"><h4>Rincian Informasi Kecamatan</h4></th>
        </tr>
        <tr>
            <th colspan="2" style="max-width: 100px;">Nama Kecamatan</th>
            <th>:</th>
            <th colspan="4" style="max-width: 100px;"><?php echo $data[1];?></th>
            <th rowspan="4" colspan="13" style="text-align: center;"><img id="img-map"/></th>
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
            <th colspan="14" style="text-align: center;background-color: lightgrey;"> 
            <form id="form-tahun" method="POST" action="<?php echo Yii::app()->homeUrl; ?>/?r=kecamatan/detil&kec_id=<?php echo $_GET['kec_id'];?>">
            <h3>Informasi Data Indicator 
                <select name="tahun" onchange="selectTahun()" id="tahun" style="width: auto;" class="form-control">
                   <?php 
                        if(isset($data[6])){
                            echo '<option selected value="'.$data[6].'">'.$data[6].'</option>';
                        } 
                        foreach($selectTahun as $thns){
                            echo "<option value='".$thns['tahun']."'>".$thns['tahun']."</option>";
                        }
                    ?> 
                </select>
            </h3>
            </form>
            </th>
        </tr>
        <?php 
        echo "<tr><td rowspan=2>No</td>"
        . "<td style='text-align: right;background-color: transparent;'><i>Month</i></td>";
        foreach($listMonth as $key=>$month){
            echo "<th rowspan=2 style='text-align: center;vertical-align: middle;background-color:lightgreen;'>".$month."</th>";
        }
        
        echo "</tr>";
        echo "<tr><td style='text-align: left;background-color: transparent;'><i>Indikator</i></td></tr>";
        $x=0;
        $no=1;
        foreach($listIndicator as $listIndicators){
            echo "<tr><td>".$no."</td>"
            . "<th style='background-color: lightsteelblue;'>".$listIndicators->idc_nama."</th>";
            
            for($i=0;$i<12;$i++){
                echo "<td style='text-align: center;'>".$dataIndicator[$x][$i]['dt_value']."</td>";
            }
            echo "</tr>";
        $x++;
        $no++;
        }
            
        
        if(!Yii::app()->user->isGuest){ ?>
        <tr>
            <th colspan="14" >
                <a target="_blank" class="btn btn-small btn-info" href="<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=kecamatan/print&kec_id=<?php echo $_GET['kec_id'];?>&thn=<?php echo $data[6];?>">Print All</a>
            </th>
            
        </tr>
        <?php } ?>
        
        
    
</table>

</div>


            
<script type="text/javascript">
var namaPrint = "<?php echo $data[1];?>";    
var lat = <?php echo $data[3];?>;
var lng = <?php echo $data[4];?>;

var src = 'http://maps.googleapis.com/maps/api/staticmap?&zoom=14&size=380x350&markers=color:red|' + lat + ',' + lng + '&maptype=roadmap';

    $(document).ready(function (){
        $('#img-map').attr('src', src);
        
    });
    
    function selectTahun(){
        document.getElementById("form-tahun").submit();
    }

</script>