<div class="alert alert-block alert-success" id="success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong> Data has been changed.
</div>
<div class="alert alert-block alert-error" id="error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Failed!</strong> Data failed to change.
</div>
<div class="col-lg-10">
    <div class="panel panel-default">
        <div class="panel-body">
            <table id="data" class="table table-bordered table-striped table-hover">
                
                <thead>
                    <tr>    
                        <th>No</th>
                        <th>Nama Kelurahan</th>
                        <th>Kode Puskesmas</th>
                        <th>Nama Puskesmas</th>
                        <th>Alamat</th>
                        <th>Jenis Pusksesmas</th>
<!--                        <th>Lintang</th>
                        <th>Bujur</th>-->
                        <?php if(!Yii::app()->user->isGuest){ ?>
                        <th class="action" style="text-align: center; width: 100px;">actions</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tfoot>
                <th colspan="7">
                        <?php if(!Yii::app()->user->isGuest){ ?>
                            <a class="btn btn-small btn-success btn-xs" href="<?php echo Yii::app()->request->baseUrl;?>/index.php?r=puskesmas/add" data-toggle="tooltip" title="Tooltip on bottom">Tambah</a>
                        <?php } ?>
                    </th>
                </tfoot>
                

            </table>
            
        </div>
    </div>
    
</div>
<!-- This Modal of Update Form -->
<div class="modal fade" id="show-edit-puskesmas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Puskesmas</h4>
      </div>
        <form class="form-group" action="<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=puskesmas/update" name="Puskesmas" role="form" method="post" enctype="multipart/form-data">
          <div class="modal-body">
              <fieldset>
                    <label>Kelurahan</label>
                    <select id="kel_id" name="Puskesmas[kel_id]"></select>
                    <label>Nama Puskesmas</label>
                    <input type="hidden" name="Puskesmas[pusk_id]" id="pusk_id" placeholder="Type something…">
                    <input type="text" name="Puskesmas[pusk_nama]" id="nama" placeholder="Type something…">
                    <label>Puskesmas Kode</label>
                    <input type="text" name="Puskesmas[pusk_kode_puskesmas]" id="kd_pusk" placeholder="Type something…">
                    <label>Alamat</label>
                    <input type="text" name="Puskesmas[pusk_alamat]" id="alamat" placeholder="Type something…">
                    <label>Jenis Puskesmas</label>
                    <input type="text" name="Puskesmas[pusk_jenis_puskesmas]" id="jp" placeholder="Type something…">
                    <label>Lintang</label>
                    <input type="text" name="Puskesmas[pusk_kordinat_x]" id="x" placeholder="Type something…">
                    <label>Bujur</label>
                    <input type="text" name="Puskesmas[pusk_kordinat_y]" id="y" placeholder="Type something…">
                    
                    
               </fieldset>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="Submit">Save changes</button>
          </div>
      </form>
    </div>
  </div>
</div>

<style>
    .center{
        text-align: center;
    }
    .action{
        width: 10px;
    }
</style>

<script type="text/javascript" language="javascript">
    var dtlurah;
    
    $(document).ready(function() {
        $('#error').hide();
        $('#success').hide();
        $('#show-edit-puskesmas').hide();
        $('#data').dataTable({
            "data": <?php echo $model; ?>,
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(2),td:eq(3),td:eq(4)', nRow).addClass("center");
                $('td:eq(4),td:eq(5)', nRow).addClass("action");
            }
        });
        
        
        
        
        
        
                
    });
    
    function confirmDelete(tID){
//        $('.delete').click(function (){
            if (!confirm('Anda yakin ingin menghapus data ?'))
            return false;
            var id = tID;
            var url =  "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=puskesmas/delete";
                $.post(url , { id : id } )
                    .done(function(data){
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
//        });
    }
    
    function showUpdate(tID){
//    $('.btn-update-puskesmas').click(function(){
            $('#show-edit-puskesmas').modal('show');
            $('#kel_id').empty();
            var pusk_id = tID;
            var url = "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=puskesmas/update";
            $.post( url, { id : pusk_id })
                .done(function( data ) {
                    tk = JSON.parse(data);
                    $( "#pusk_id" ).val( tk[0] );
                    $( "#nama" ).val( tk[2] );
                    $( "#kd_pusk" ).val( tk[1] );
                    $( "#alamat" ).val( tk[3] );
                    $( "#jp" ).val( tk[4] );
                    $( "#x" ).val( tk[5] );
                    $( "#y" ).val( tk[6] );
                    selKelurahId = tk[10];
                    dtlurah = tk[11];
                    dtlurah = JSON.parse(dtlurah);
                    
                    for(i=0;i<dtlurah.length;i++){
                        if(selKelurahId==dtlurah[i].id){
                            val = "<option value='" 
                            + dtlurah[i].id + "' selected>" 
                            + dtlurah[i].nama + "</option>"
                        }else{
                            val = "<option value='" 
                            + dtlurah[i].id + "'>" 
                            + dtlurah[i].nama + "</option>"}
                        $("#kel_id").append(val);
                    };
                });    
//        });
    }
    


</script>
