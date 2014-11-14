<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="alert alert-block alert-success" id="success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong> Data has been changed. <p id="alert-add-indicator"></p>
</div>
<div class="alert alert-block alert-error" id="error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Failed!</strong> Data failed to change.
</div>
<div class="container-fluid">
   
<table  class="table table-striped table-hover" style="min-width: 800px;">
        <tr>
            <th colspan="14" style="text-align: center;background-color: lightgray"><h3>Rincian Informasi Kelurahan</h3></th>
        </tr>
        <tr>
            <th>Nama Kecamatan</th>
            <th>:</th>
            <th><?php echo $data[5];?></th>
            <th rowspan="5" colspan="10" style="text-align: center;max-width: 260px;"><img id="img-map"/></div></th>
        </tr>
        <tr>
            <th>Nama Kelurahan</th>
            <th>:</th>
            <th><?php echo $data[1];?></th>
        </tr>
        <tr>
            <th>Alamat</th>
            <th>:</th>
            <th><?php echo $data[2];?></th>
        </tr>
        <tr>
            <th>Lintang</th>
            <th>:</th>
            <th><?php echo $data[3];?></th>
        </tr>
        <tr>
            <th>Bujur</th>
            <th>:</th>
            <th><?php echo $data[4];?></th>
        </tr>
        <tr>
            <th colspan="14" style="text-align: center;background-color: lightgray">
                <form id="form-tahun" method="POST" action="<?php echo Yii::app()->homeUrl; ?>/?r=kelurahan/detil&kel_id=<?php echo $_GET['kel_id'];?>">
                <h3>Informasi Indicator Kelurahan Tahun
                    <select name="tahun" onchange="selectTahun()" id="tahun" style="width: auto;" class="form-control">
                        
                    <?php if(isset($data[7])){
                    echo '<option selected value="'.$data[7].'">'.$data[7].'</option>';
                    }else {
                        echo '<option selected value="'.date('Y').'">'.date('Y').'</option>';
                    } 
                    foreach($selectTahun as $thns){
                        echo "<option value='".$thns['tahun']."'>".$thns['tahun']."</option>";
                     }?> 
                    </select>
                </h3>
                </form>
                    
                    
            </th>
        </tr>
        <tr><td id='table-indicator' colspan="14" style="text-align: center;">
            <table id='datatable' class="table table-striped table-hover">
                <tr>
                    <td style="text-align: right;background-color: transparent;"><i>Month</i></td>
                    <?php 
                    foreach($data[6] as $key=>$bulan){
                       echo '<th rowspan=2 style="text-align: center;vertical-align: middle;background-color:lightgreen;">'.$bulan.'</th>'; 
                    }
                    echo '<th rowspan=2 style="text-align: center;vertical-align: middle;background-color:lightgreen;">Total</th>'; 
                    if(Yii::app()->user->level=='admin'){
                        echo "<th rowspan='2' style='vertical-align: middle;background-color:lightgreen;'>actions</th>";
                    }else if(Yii::app()->user->level=='kelurahan' && Yii::app()->user->privilege==$_GET['kel_id']){
                        echo "<th rowspan='2' style='vertical-align: middle;background-color:lightgreen;'>actions</th>";
                    }
                    ?>
                </tr>
                <tr>
                    <td><i>Data Indicator</i></td>
                </tr>
                <?php 
                    for($i=0;$i<count($headerTableIndicator);$i++){
                        $totalRow=0;
                        echo "<tr><th style='background-color: lightsteelblue;'>".$headerTableIndicator[$i]['idc_nama']."</th>";
                            for($x=0; $x<count($rowInfoKelurahan);$x++){
                                $rowTahun = substr($rowInfoKelurahan[$x]['dt_periode'],0,-2);
                                if($headerTableIndicator[$i]['idc_id']==$rowInfoKelurahan[$x]['idc_id']){
                                    if(isset($data[7]) && $rowTahun==$data[7]){
                                        echo "<td style='text-align: center;'>".$rowInfoKelurahan[$x]['dt_value']."</td>";
                                        $totalRow=$totalRow+$rowInfoKelurahan[$x]['dt_value'];
                                    }else if($rowTahun==date('Y')){
                                        echo "<td style='text-align: center;'>".$rowInfoKelurahan[$x]['dt_value']."</td>";
                                        $totalRow=$totalRow+$rowInfoKelurahan[$x]['dt_value'];
                                    }else{
                                            echo "<td>empty</td>";
                                    }
                                    
                                }
                                    
                            }
                            echo "<td style='text-align: left;'>".$totalRow." ".$headerTableIndicator[$i]['idc_satuan']."</td>";
                            $idc_id = $headerTableIndicator[$i]['idc_id'];
                            $idc_nama = $headerTableIndicator[$i]['idc_nama'];
                            if(Yii::app()->user->level=='admin'){
                                if(isset($rowInfoKelurahan[0]['dt_value']) && $rowInfoKelurahan[0]['dt_value']!=null){
                                    echo "<td><button class='btn btn-small btn-success' title='Edit Data' onClick='showModalUpdate(\"$idc_id\",\"$idc_nama \")' >edit</button></td>";
                                }
                            }else if(Yii::app()->user->level=='kelurahan' && Yii::app()->user->privilege==$_GET['kel_id']){
                                if(isset($rowInfoKelurahan[0]['dt_value']) && $rowInfoKelurahan[0]['dt_value']!=null){
                                    echo "<td><button class='btn btn-small btn-success' title='Edit Data' onClick='showModalUpdate(\"$idc_id\",\"$idc_nama \")' >edit</button></td>";
                                }
                            }
                        echo "</tr>";
                    }
                ?>
            </table>
        </td></tr>
        <?php if(!Yii::app()->user->isGuest){ ?>
        <tr>
            <th colspan="4">
                <a target="_blank" class="btn btn-small btn-info" href="<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=kelurahan/print&kel_id=<?php echo $_GET['kel_id'];?>&thn=<?php if(isset($data[7]))echo $data[7];?>">Print All</a>
            </th>
        </tr>
        <?php } ?>
</table>
</div>


<div class="modal fade bs-update" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title title-update">Update Informasi Indicator</h4>
      </div>
      <div class="modal-body">
          <div class="form-group" id="form-update-data-indicator"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="do-update" type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="progress progress-striped active" id="progress-bar">
    <div class="bar" id="bar" style="width: 10%;"></div>
</div>

<script type="text/javascript">
    
var lat = <?php echo $data[3];?>;
var lng = <?php echo $data[4];?>;
var src = 'http://maps.googleapis.com/maps/api/staticmap?&zoom=16&size=380x260&markers=color:red|' + lat + ',' + lng + '&maptype=roadmap';
var rc=null;
        

    $(document).ready(function (){
        $('#error').hide();
        $('#success').hide();
        $('.modal').hide();
        $('#img-map').attr('src', src);
        $('#progress-bar').hide();
        
        $('#do-update').click(function (){
            var tmp_data={};
            var data=[];
            
            for(i=0;i<12;i++){
                data[i] = [$('#dt-id'+[i]).val(),$('#dt-data'+[i]).val(),$('#dt-periode'+[i]).val()];
            }
            
            tmp_data = {
                "kel_id": $('#kel-id'+[0]).val(),
                "idc_id": $('#idc-id'+[0]).val(),
                "data": data
            };
            
            $('#alert-add-indicator').empty();
            $.post("<?php echo Yii::app()->homeUrl; ?>/?r=kelurahan/updateInformasi", { 
                    updateDataIndicator : true,
                    data : JSON.stringify(tmp_data),
                })
            .done(function (data){
                rc=data;
                if(rc=='12'){
                    alert("Data berhasil diupdate");                       
                    location.reload();
                }else{
                    alert(rc + " Data Gagal diupdate"); 
                }
            });
            
            
            
            
        });
        
    });
    
    
    function showModalUpdate(idc_id, title){
        var shData=[];
        $('#form-update-data-indicator').empty();
        $('.title-update').empty();
        $('.bs-update').modal('show');
        $('.title-update').append(" " + title);
        $.post( "<?php echo Yii::app()->homeUrl; ?>/?r=kelurahan/updateInformasi", { 
            getShowUpdateDataIndicator : true,
            kel_id : '<?php echo $_GET['kel_id'];?>', 
            idc_id : idc_id,
            tahun : $('#tahun').val() })
            .done(function( data ) {
               rData = JSON.parse(data);
               
                for(var i=0;i<rData.length;i++){
                   $("#form-update-data-indicator").append(
                        "<input id='idc-id" + [i] +"' value='" + rData[i]['idc_id'] + "' type='hidden'>"
                        + "<input id='dt-id" + [i] +"' value='" + rData[i]['dt_id'] + "' type='hidden'>"
                        + "<input id='kel-id" + [i] +"' value='" + rData[i]['kel_id'] + "' type='hidden'>"
                        +  "<label for='exampleInputInformation'>Periode</label>"
                        + "<input id='dt-periode" + [i] +"' type='text' disabled value='" + rData[i]['dt_periode'] + "'> : "
                        + "<input id='dt-data" + [i] +"' type='text' title='Jumlah Data' value='" + rData[i]['dt_value'] + "'>"
                   );
               } 
            });  
        
           
    }
    
    function selectTahun(){
        document.getElementById("form-tahun").submit();
    }
    
    
    
    

</script>