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
   
    <table id="table-detil" class="table-detil table-hover" >
        <tr>
            <th colspan="16" style="text-align: center;color: #ff0000;background: transparent;"><h3>Rincian Informasi Kelurahan</h3></th>
        </tr>
        <tr>
            <th style="text-align: left;">Nama Kecamatan</th>
            <th>:</th>
            <th style="text-align: left;"><?php echo $data[5];?></th>
            <th rowspan="5" colspan="5" style="text-align: center;width: 40%;"><img id="img-map"/></div></th>
        </tr>
        <tr>
            <th style="text-align: left;">Nama Kelurahan</th>
            <th>:</th>
            <th style="text-align: left;"><?php echo $data[1];?></th>
        </tr>
        <tr>
            <th style="text-align: left;">Alamat</th>
            <th>:</th>
            <th style="text-align: left;"><?php echo $data[2];?></th>
        </tr>
        <tr>
            <th style="text-align: left;">Lintang</th>
            <th>:</th>
            <th style="text-align: left;"><?php echo $data[3];?></th>
        </tr>
        <tr>
            <th style="text-align: left;">Bujur</th>
            <th>:</th>
            <th style="text-align: left;"><?php echo $data[4];?></th>
        </tr>
        
        <tr>
            <th colspan="16" style="text-align: center;background-color: transparent;">
            <h4 style="color: #ff0000;">Informasi Indicator Kelurahan</h4>
                <form id="form-tahun" method="POST" action="<?php echo Yii::app()->homeUrl; ?>/?r=kelurahan/detil&kel_id=<?php echo $_GET['kel_id'];?>">
                    <h4>
                    Category
                    <select name="category" onchange="selectFilterIndicator()" id="category" style="width: auto;" class="form-control">
                        
                    <?php if(isset($data[7][1])){
                    echo '<option selected value="'.$data[7][1].'">'.$data[7][1].'</option>';
                    }
                    foreach($listCategory as $ctgs){
                        echo "<option value='".$ctgs['ctg_nama']."'>".$ctgs['ctg_nama']."</option>";
                     }?> 
                    </select>
                    Tahun
                    <select name="tahun" onchange="selectFilterIndicator()" id="tahun" style="width: auto;" class="form-control">
                        
                    <?php if(isset($data[7][0])){
                    echo '<option selected value="'.$data[7][0].'">'.$data[7][0].'</option>';
                    }else {
                        echo '<option selected value="'.date('Y').'">'.date('Y').'</option>';
                    } 
                    foreach($selectTahun as $thns){
                        echo "<option value='".$thns['tahun']."'>".$thns['tahun']."</option>";
                     }?> 
                    </select>
                    </h4>
                
                </form>
            </th>
        </tr>
        <tr>
            <td colspan="16" style="text-align: center;background: transparent;">
                <table id='datatable' class="table-striped">
                    <thead>
                        <tr>
                            <td rowspan="2" style="text-align: right;background-color: transparent;">No</td>
                            <td style="text-align: right;background-color: transparent;"><i>Month</i></td>
                            <?php 
                            foreach($data[6] as $key=>$bulan){
                               echo '<th rowspan=2 style="text-align: center;vertical-align: middle;background-color:transparent;">'.$bulan.'</th>'; 
                            }
                            if(Yii::app()->user->level=='admin'){
                                echo "<th rowspan='2' style='vertical-align: middle;background-color:transparent;'>actions</th>";
                            }else if(Yii::app()->user->level=='kelurahan' && Yii::app()->user->privilege==$_GET['kel_id']){
                                echo "<th rowspan='2' style='vertical-align: middle;background-color:transparent;'>actions</th>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <td style="text-align: left;"><i>Data Indicator</i></td>
                        </tr>
                    </thead>
                        <?php 
                            $no=1;
                            for($i=0;$i<count($headerTableIndicator);$i++){
                                echo "<tr><th>".$no."</th>"
                                . "<th style='text-align: left;'>".$headerTableIndicator[$i]['idc_nama']."</th>";
                                    for($x=0; $x<count($rowInfoKelurahan);$x++){
                                        $rowTahun = substr($rowInfoKelurahan[$x]['dt_periode'],0,-2);
                                        if($headerTableIndicator[$i]['idc_id']==$rowInfoKelurahan[$x]['idc_id']){
                                            if(isset($data[7][0]) && $rowTahun==$data[7][0]){
                                                echo "<td style='text-align: center;'><button class='btn btn-default' data-toggle='popover' data-content='<p>".$rowInfoKelurahan[$x]['dt_keterangan']."</p>'>".$rowInfoKelurahan[$x]['dt_value']."</button></td>";
                                                
                                            }else if($rowTahun==date('Y')){
                                                echo "<td style='text-align: center;'><button class='btn btn-default' data-toggle='popover' data-content='<p>".$rowInfoKelurahan[$x]['dt_keterangan']."</p>'>".$rowInfoKelurahan[$x]['dt_value']."</button></td>";
                                                
                                            }else{
                                                    echo "<td>empty</td>";
                                            }
                                        }

                                    }
                                    $idc_id = $headerTableIndicator[$i]['idc_id'];
                                    $idc_nama = $headerTableIndicator[$i]['idc_nama'];
                                    $idc_category = $headerTableIndicator[$i]['idc_category'];
                                    if(Yii::app()->user->level=='admin'){
                                        if(isset($rowInfoKelurahan[0]['dt_value']) && $rowInfoKelurahan[0]['dt_value']!=null){
                                            echo "<td><button class='btn btn-small btn-success' title='Edit Data' onClick='showModalUpdate(\"$idc_id\",\"$idc_nama \",\"$idc_category\")' >edit</button></td>";
                                        }
                                    }else if(Yii::app()->user->level=='kelurahan' && Yii::app()->user->privilege==$_GET['kel_id']){
                                        if(isset($rowInfoKelurahan[0]['dt_value']) && $rowInfoKelurahan[0]['dt_value']!=null){
                                            echo "<td><button class='btn btn-small btn-success' title='Edit Data' onClick='showModalUpdate(\"$idc_id\",\"$idc_nama \",\"$idc_category\")' >edit</button></td>";
                                        }
                                    }
                                echo "</tr>";
                                $no++;
                            }
                        ?>
                    </table>
                </td>
        </tr>
        <tr>
            <th colspan="4" style="text-align: left;">
                <a target="_blank" class="btn btn-large btn-info" href="<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=kelurahan/print&kel_id=<?php echo $_GET['kel_id'];?>&thn=<?php if(isset($data[7][0]))echo $data[7][0];?>">Print All</a>
            </th>
        </tr>
</table>
</div>


<div class="modal fade bs-update" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title title-update">Update Informasi Indicator</h4>
      </div>
      <div class="modal-body" > 
          <table class="table-hover" id='form-update-data-indicator' style="width: 100%;"></table>
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
var src = 'http://maps.googleapis.com/maps/api/staticmap?&zoom=16&size=600x350&markers=color:red|' + lat + ',' + lng + '&maptype=roadmap';
var rc=null;
        

    $(document).ready(function (){
        $('#datatable').dataTable();
        $('#error').hide();
        $('#success').hide();
        $('.modal').hide();
        $('#img-map').attr('src', src);
        $('#progress-bar').hide();
        
        //Do for update each 12 month selected of Indicator 
        $('#do-update').click(function (){
            var tmp_data={};
            var data=[];
            
            for(i=0;i<12;i++){
                    data[i] = [$('#dt-id'+[i]).val(),$('#dt-data'+[i]).val(),$('#dt-periode'+[i]).val(),$('#dt-keterangan'+[i]).val().replace(/\n/g, "<br />")];
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
        
        
        $(function () {
          $('[data-toggle="popover"]').popover({
              placement: 'top',
              html: true,
              container: 'body',
              title : 'Keterangan',
          })
        })
        
    });
    
    
    function showModalUpdate(idc_id, title,ctg_nama){
        var shData=[];
        $('#form-update-data-indicator').empty();
        $('.title-update').empty();
        $('.bs-update').modal('show');
        $('.title-update').append(" " + title);
        $.post( "<?php echo Yii::app()->homeUrl; ?>/?r=kelurahan/updateInformasi", { 
            getShowUpdateDataIndicator : true,
            kel_id : '<?php echo $_GET['kel_id'];?>', 
            idc_id : idc_id,
            ctg_nama : ctg_nama,
            tahun : $('#tahun').val() })
            .done(function( data ) {
               rData = JSON.parse(data);
               
                for(var i=0;i<rData.length;i++){
                   $("#form-update-data-indicator").append(
                        "<tr><td><div class='form-group'>"   
                        + "<input id='idc-id" + [i] +"' value='" + rData[i]['idc_id'] + "' type='hidden'>"
                        + "<input id='dt-id" + [i] +"' value='" + rData[i]['dt_id'] + "' type='hidden'>"
                        + "<input id='kel-id" + [i] +"' value='" + rData[i]['kel_id'] + "' type='hidden'>"
                        +  "<label for='exampleInputInformation'><strong>Periode : Value</strong></label>"
                        + "<input id='dt-periode" + [i] +"' type='text' disabled value='" + rData[i]['dt_periode'] + "'> : "
                        + "<input id='dt-data" + [i] +"' type='text' title='Jumlah Data' value='" + rData[i]['dt_value'] + "'>"
                        +  "<label for='exampleInputInformation'><i>Keterangan</i></label>"
                        + "<textarea  id='dt-keterangan" + [i] +"' class='input-xlarge' title='Keterangan'>" + rData[i]['dt_keterangan'].replace(/\<br \/\>/g, "\n") + "</textarea>"
                        + "</div></td></tr><tr><td style='border-bottom-style:dashed;border-width:2px;'></td></tr>"
                   );
               } 
            });  
        
           
    }
    
    function selectFilterIndicator(){
        document.getElementById("form-tahun").submit();
    }
    
    
    
    

</script>