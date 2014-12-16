
<table class="table-detil table-hover">
        <tr>
            <th colspan="14" style="text-align: center;background: transparent;color: #ff0000;"><h3>Rincian Informasi Kecamatan</h3></th>
        </tr>
        <tr>
            <th colspan="2" style="max-width: 30%;text-align: left;">Nama Kecamatan</th>
            <th>:</th>
            <th colspan="4" style="max-width: 30%;text-align: left;"><?php echo $data[1];?></th>
            <th rowspan="4" colspan="13" style="text-align: center;width: 40%;"><img id="img-map"/></th>
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
            <th colspan="14" style="text-align: center;background-color: transparent;"> 
            <form id="form-tahun" method="POST" action="<?php echo Yii::app()->homeUrl; ?>/?r=kecamatan/detil&kec_id=<?php echo $_GET['kec_id'];?>">
                <h4 style="color: #ff0000;">Informasi Data Indicator</h4>
                <h4>Category
                <select name="ctg_nama" onchange="selectFilterIndicator()" id="category" style="width: auto;" class="form-control">
                   <?php 
                        if(isset($data[6][1])){
                            echo '<option selected value="'.$data[6][1].'">'.$data[6][1].'</option>';
                        }
                        foreach($listCategory as $ctgs){
                            echo "<option value='".$ctgs->ctg_nama."'>".$ctgs->ctg_nama."</option>";
                        }
                    ?> 
                </select>
                    Tahun
                <select name="tahun" onchange="selectFilterIndicator()" id="tahun" style="width: auto;" class="form-control">
                   <?php 
                        if(isset($data[6][0])){
                            echo '<option selected value="'.$data[6][0].'">'.$data[6][0].'</option>';
                        } 
                        foreach($selectTahun as $thns){
                            echo "<option value='".$thns['tahun']."'>".$thns['tahun']."</option>";
                        }
                    ?> 
                </select>
            </h4>
            </form>
            </th>
        </tr>
        <tr><td colspan="14" style="text-align: center;background-color: transparent;">
        <table id="table-kecamatan" class="table-striped" >
        <?php 
        echo "<thead><tr><td rowspan=2>No</td>"
        . "<td style='text-align: right;background-color: transparent;'><i>Month</i></td>";
        foreach($listMonth as $key=>$month){
            echo "<th rowspan=2 style='text-align: center;vertical-align: middle;background: transparent;'>".$month."</th>";
        }
        
        echo "</tr>";
        echo "<tr><td style='text-align: left;background: transparent;'><i>Indikator</i></td></tr>";
        echo "</thead>";
        $x=0;
        $no=1;
        foreach($listIndicator as $listIndicators){
            echo "<tr><td>".$no."</td>"
            . "<th style='text-align: left;'>".$listIndicators->idc_nama."</th>";
            for($i=0;$i<12;$i++){
                if(isset($dataIndicator[$x][$i]['dt_value'])){
                    if($listIndicators->idc_category==$dataIndicator[$x][$i]['idc_category']){
                        echo "<td style='text-align: center;'>".$dataIndicator[$x][$i]['dt_value']."</td>";
                    }
                }
            }
            echo "</tr>";
        $x++;
        $no++;
        }
        
        echo "</table></td></tr>";
        
        if(!Yii::app()->user->isGuest){ ?>
        <tfoot>    
            <tr>
                <th colspan="14" style="text-align: left;" >
                    <a target="_blank" class="btn btn-large btn-info" href="<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=kecamatan/print&kec_id=<?php echo $_GET['kec_id'];?>&thn=<?php echo $data[6][0];?>">Print All</a>
                </th>

            </tr>
        </tfoot>
        <?php } ?>
        
        
    
</table>

</div>


            
<script type="text/javascript">
var namaPrint = "<?php echo $data[1];?>";    
var lat = <?php echo $data[3];?>;
var lng = <?php echo $data[4];?>;

var src = 'http://maps.googleapis.com/maps/api/staticmap?&zoom=14&size=600x350&markers=color:red|' + lat + ',' + lng + '&maptype=roadmap';

    $(document).ready(function (){
        $('#table-kecamatan').dataTable();
        $('#img-map').attr('src', src);
        
    });
    
    function selectFilterIndicator(){
        document.getElementById("form-tahun").submit();
    }

</script>