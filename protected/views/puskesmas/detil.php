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


<div class="alert alert-block alert-success" id="success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong> Data has been changed.
</div>
<div class="alert alert-block alert-error" id="error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Failed!</strong> Data failed to change.
</div>
<div class="container-fluid">
    <p class="lead"><h4>Detil Informasi</h4></p>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Nama Kelurahan</th>
            <th>:</th>
            <th><?php echo $data[0];?></th>
            <th rowspan="7" colspan="3"><img id="img-map"/></th>
        </tr>
        <tr>
            <th>Kode Puskesmas</th>
            <th>:</th>
            <th><?php echo $data[1];?></th>
        </tr>
        <tr>
            <th>Nama Puskesmas</th>
            <th>:</th>
            <th><?php echo $data[2];?></th>
        </tr>
        <tr>
            <th>Alamat</th>
            <th>:</th>
            <th><?php echo $data[3];?></th>
        </tr>
        <tr>
            <th>Jenis Pusksesmas</th>
            <th>:</th>
            <th><?php echo $data[4];?></th>
        </tr>
        <tr>
            <th>Lintang</th>
            <th>:</th>
            <th><?php echo $data[5];?></th>
        </tr>
        <tr>
            <th>Bujur</th>
            <th>:</th>
            <th><?php echo $data[6];?></th>
        </tr>
        <tr colspan="5">
            <th rowspan="1" colspan="5">Informasi Tambahan
                <table class="table">
                    <thead id="show-info"></thead>
                </table>
            </th>
        </tr>
        <?php if(!Yii::app()->user->isGuest){ ?>
        <tr>
            <th colspan="4">
                <button class="btn btn-small btn-primary" data-toggle="modal" data-target=".bs-save">Add</button>
                <a target="_blank" class="btn btn-small btn-info" href="<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=puskesmas/print&pusk_id=<?php echo $data[9];?>">Print All</a>
            </th>
            
        </tr>
        <?php } ?>
    </thead>
</table>
</div>

<div class="modal fade bs-save" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Tambah Informasi</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputColumn">Column Name</label>
            <input type="text" class="form-control input-xlarge" id="column" placeholder="Column Name...">
          </div>
          <div class="form-group">
            <label for="exampleInputInformation">Information</label>
            <input type="text" class="form-control input-xlarge" id="information" placeholder="Information Value...">
          </div>
          
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="save" type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-update" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Update Informasi</h4>
      </div>
      <div class="modal-body">
          <div class="form-group" id="form-update"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="do-update" type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">

var lat = <?php echo $data[5];?>;
var lng = <?php echo $data[6];?>;
var src = 'http://maps.googleapis.com/maps/api/staticmap?&zoom=16&size=480x360&markers=color:red|' + lat + ',' + lng + '&maptype=roadmap';

        
        

    $(document).ready(function (){
        $('#error').hide();
        $('#success').hide();
        $('.modal').hide();
        $('#img-map').attr('src', src);
        $("#save").click(function (){
            
            var tColumn = $("#column").val();
            var tInfo = $("#information").val();
                $.post( "<?php echo Yii::app()->homeUrl; ?>/?r=puskesmas/addInformasi", { id: "<?php echo $_GET['pusk_id'];?>" , column : tColumn, info: tInfo })
                    .done(function( data ) {
                        if(data=="1"){
                        $("#success").slideDown(500,function (){
                             $(this).fadeOut(4000, function (){
                                 location.reload();
                             });
                        });
                        }else{
                            $("#error").slideDown(500,function (){
                                 $(this).fadeOut(4000, function (){
                                 });
                            });
                         }
                    });
        });
        
        var dtInfo = [<?php echo json_encode($informasi);?>];
        dtInfo = JSON.parse(dtInfo);
        for(var i=0;i < dtInfo.length;i++){
            $("#show-info").append(
                    "<tr><td>" + dtInfo[i]['column'] + "</td><td>:</td>"
                    + "<td>" + dtInfo[i]['information'] + "</td>"
                    <?php if(!Yii::app()->user->isGuest){ ?>
                    + "<td><div id='" + dtInfo[i]['dt_id'] + "' class='btn btn-mini btn-warning update' title='Edit'><a class='icon-edit'></a></div> " 
                    + " <div id='" + dtInfo[i]['dt_id'] + "' class='btn btn-mini btn-danger delete' title='Delete'><a class='icon-trash'></a></div></td>" 
                    <?php } ?>
                    + "</tr>");
        }
        
        var shData=[];
        $(".update").click(function (){
            $('.bs-update').modal('show');
            $.post( "<?php echo Yii::app()->homeUrl; ?>/?r=puskesmas/updateInformasi", { id : $(this).attr('id') })
                .done(function( data ) {
                   shData = JSON.parse(data);
                   $('#form-update').empty();
                    for(var i=0;i<shData.length;i++){
                       $("#form-update").append(
                                "<input id='dt-id' value='" + shData[i]['dt_id'] + "' type='hidden' class='form-control input-xlarge'>"
                                + "<input id='dt-column' type='text' class='form-control input-xlarge' value=" + shData[i]['column'] + ">"
                                + "<input id='dt-info' type='text' class='form-control input-xlarge' value=" + shData[i]['information'] + ">"
                               );
                        
                   } 
                });  
                
         $('#do-update').click(function (){
            $.post("<?php echo Yii::app()->homeUrl; ?>/?r=puskesmas/updateInformasi", { 
                    update : true ,
                    dt_id  : $('#dt-id').val(),
                    dt_column  : $('#dt-column').val(),
                    dt_information  : $('#dt-info').val()
                })
                .done(function (data){
                    if(data=="1"){
                        $("#success").slideDown(500,function (){
                             $(this).fadeOut(4000, function (){
                                 location.reload();
                             });
                        });
                    }else{
                        $("#error").slideDown(500,function (){
                             $(this).fadeOut(4000, function (){
                             });
                        });
                     }
            });     
        });   
               
            
        });
        $(".delete").click(function (){
            if (!confirm('Anda yakin ingin menghapus data ?'))
            return false;
            $.post("<?php echo Yii::app()->homeUrl; ?>/?r=puskesmas/deleteInformasi", { id: $(this).attr("id") })
                .done(function (data){
                    if(data=="1"){
                        $("#success").slideDown(500,function (){
                             $(this).fadeOut(4000, function (){
                                 location.reload();
                             });
                        });
                    }else{
                        $("#error").slideDown(500,function (){
                             $(this).fadeOut(4000, function (){
                             });
                        });
                     }
                });
        });
        
        
    });
    
    

</script>