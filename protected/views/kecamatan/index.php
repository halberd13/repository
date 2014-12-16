<div class="col-lg-10">
    <div class="panel panel-default">
        <div class="panel-body">
            <table id="data" class="table-detil table-striped table-hover">
                <thead>
                    <tr>
                        <th style="max-width: 20px;text-align: center;">No</th>
                        <th>Nama Kecamatan</th>
                        <th>Alamat</th>
                        <th>Lintang</th>
                        <th>Bujur</th>
                        <?php if(Yii::app()->user->level!='guest'){ ?>
                        <th class="action" style="text-align: center; width: 100px;">actions</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tfoot>
                    
                        <?php if(Yii::app()->user->level=='admin'){ 
                            echo "<th colspan='6' style='text-align: left;'>'";
                            echo '<a class="btn btn-small btn-primary btn-xs" style="text-align: left;" id="tambah-kecamatan" href="'.Yii::app()->request->baseUrl.'/index.php?r=kecamatan/add" data-toggle="tooltip" title="Tooltip on bottom">Tambah Kecamatan</a>';
                            echo "</th>";
                            
                        } ?>
                    
                </tfoot>
            </table>
            
        </div>
    </div>
    
</div>
    
<div class="modal fade" id="alert">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background:#FBE3E4;  ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" style="color: red">Warning!!!</h4>
      </div>
      <div class="modal-body">
          <p>Jika data <strong>Kecamatan</strong> dihapus, Maka data <strong>Kelurahan</strong> dan <strong>Puskesmas</strong> yang terdaftar dikecamatan ini akan ikut terhapus.<br/>
          <h5>Anda Yakin ingin menghapus data ini ?</h5></p>
          <input type="hidden" id="kec_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal" id="do-delete">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-update-kecamatan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Kecamatan</h4>
      </div>
        <form name="Kecamatan" class="form-group" action="<?php echo Yii::app()->request->baseUrl;?>/index.php?r=kecamatan/update" role="form" method="post" enctype="multipart/form-data">
          <div class="modal-body">
              <fieldset>
                  <input type="hidden" name="Kecamatan[kec_id]" id="upd-id" placeholder="Type something…">
                    <label>Nama Kecamatan</label>
                    <input type="text" name="Kecamatan[kec_nama]" id="upd-nama" placeholder="Type something…">
                    <label>Alamat</label>
                    <input type="text" name="Kecamatan[kec_alamat]" id="upd-alamat" placeholder="Type something…">
                    <label>Lintang</label>
                    <input type="text" name="Kecamatan[kec_kordinat_x]" id="upd-x" placeholder="Type something…">
                    <label>Bujur</label>
                    <input type="text" name="Kecamatan[kec_kordinat_y]" id="upd-y" placeholder="Type something…">
               </fieldset>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
          </div>
      </form>
    </div>
  </div>
</div>    
    
<script type="text/javascript" language="javascript">
    var kec_id;
    
    $(document).ready(function() {
        $('.modal').hide();
        $('#data').dataTable({
            "data": <?php echo $model; ?>,
        });
        
        $('#do-delete').click(function (){
            var id = $('#kec_id').val();
            var url =  "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=kecamatan/delete"
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
        })
        
        
        
        
        
    });    
    
    function confirmDelete(tID){
//        $('.delete').click(function (){
            var id = tID;
            $('#alert').modal('show');
            $('#kec_id').val(id);
           
    }
    
    function showUpdate(tID){
//    $('.show-update-kecamatan').click(function (){
            
        kec_id = tID;
        var url = "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=kecamatan/update";
        $.post( url, { id : kec_id })
            .done(function( data ) {
                var tData = JSON.parse(data);
                $('#upd-id').val(tData[0]);
                $('#upd-nama').val(tData[1]);
                $('#upd-alamat').val(tData[2]);
                $('#upd-x').val(tData[3]);
                $('#upd-y').val(tData[4]);

            });
        $('#modal-update-kecamatan').modal('show');
//        });
    }
    
   
    
    
    
</script>