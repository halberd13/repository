<div class="alert alert-block alert-success" id="success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong> Data has been changed.
</div>
<div class="alert alert-block alert-error" id="error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Failed!</strong> Data failed to change.
</div> 

<div class="demo-wrapper html5-progress-bar">
    <div class="progress-bar-wrapper">
        <h4>Loading for Input Data Indicator...</h4>
            <progress id="progressbar" value="0" max="100"></progress>
            <span class="progress-value">0%</span>
    </div>
</div>
<div class="col-lg-10">
    <div class="panel panel-default">
        <div class="panel-body">
            <table id="data" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kecamatan</th>
                        <th>Nama Kelurahan</th>
                        <th>Alamat</th>
                        <th>Lintang</th>
                        <th>Bujur</th>
                        <?php if(Yii::app()->user->level!='guest'){ ?>
                        <th class="action" style="text-align: center; width: 100px;">Actions</th>
                        <?php } ?>
                    </tr>
                
                    
                </thead>
                <?php if (Yii::app()->user->level=='admin'){?>
                <tfoot>
                    <th colspan="7">
                        <?php if(!Yii::app()->user->isGuest){ ?>
                            <a class="btn btn-small btn-primary" id="tambah-kelurahan" href="<?php echo Yii::app()->request->baseUrl;?>/index.php?r=kelurahan/add">Tambah Kelurahan</a>
                            
                            <a class="btn btn-small btn-warning" id="btn-list-kebutuhan-data" >List Kebutuhan Data</a>
                        <?php } ?>
                    </th>
                </tfoot>
                <?php } ?>
            </table>
            
        </div>
    </div>
    
</div>

<!-- Modal Add Kebutuhan data -->
<div class="modal fade" id="modal-form-kebutuhan-data" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Form Kebutuhan Data Kelurahan</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputColumn">Nama Data Indicator</label>
            <input type="text" class="form-control input-xlarge" id="column" placeholder="Column Name...">
          </div>
          <div class="form-group">
            <label for="exampleInputColumn">Satuan Data</label>
            <input type="text" class="form-control input-xlarge" id="satuan" placeholder="Satuan Data Name...">
          </div>
          <div class="form-group">
            <label for="exampleInputColumn">Kategori</label>
            <select id="category">
                <?php foreach($listCategory as $lists){
                    echo '<option value="'.$lists->ctg_nama.'">'.$lists->ctg_nama.'</option>';
                }?>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="close-modal-form-kebutuhan-data" data-dismiss="modal">Back</button>
        <button id="save-kebutuhan-data" type="button" class="btn btn-primary" data-dismiss="modal" onclick="runProgress()">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Warning For Delete Kelurahan -->
<div class="modal fade" id="alert">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background:#FBE3E4;  ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" style="color: red">Warning!!!</h4>
      </div>
      <div class="modal-body">
          <p>Jika data <strong>Kelurahan</strong> dihapus, Maka data <strong>Indicator</strong> yang terdaftar dikelurahan ini akan ikut terhapus.<br/>
          <h5>Anda Yakin ingin menghapus data ini ?</h5></p>
          <input type="hidden" id="kel_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal" id="do-delete">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal Update Data kelurahan -->
<div class="modal fade" id="modal-update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Kelurahan</h4>
      </div>
        <form name="Kelurahan" class="form-group" action="<?php echo Yii::app()->request->baseUrl;?>/index.php?r=kelurahan/update" role="form" method="post" enctype="multipart/form-data">
          <div class="modal-body">
              <fieldset>
                    <label>Kecamatan</label>
                    <select id="kec_id" name="Kelurahan[kec_id]"></select>
                    <label>Nama Kelurahan</label>
                    <input type="hidden" name="Kelurahan[kel_id]" id="upd-id">
                    <input type="text" name="Kelurahan[kel_nama]" id="upd-nama">
                    <label>Alamat</label>
                    <input type="text" name="Kelurahan[kel_alamat]" id="upd-alamat">
                    <label>Lintang</label>
                    <input type="text" name="Kelurahan[kel_kordinat_x]" id="upd-x">
                    <label>Bujur</label>
                    <input type="text" name="Kelurahan[kel_kordinat_y]" id="upd-y">
              </fieldset>
          </div>
          <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
          </div>
      </form>
    </div>
  </div>
</div>    
    
<!-- Modal show kebutuhan data -->
    <div class="modal fade" id="modal-list-kebutuhan-data">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <p>
                <h3>List Data Indicator </h3>
                <a id="btn-show-list-category" style="float: right;" data-dismiss="modal"><strong>List Category</strong></a>
            </p>
            
        </div>
        <div class="modal-body">
            
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Data Indicator</th>
                    <th>Category</th>
                    <th>Satuan</th>
                    <th>Actions</th>
                </tr>
                <?php $i=1;foreach($listIndicator as $dt){
                    echo "<tr>";
                    echo "<td>".$i."</td>";
                    echo "<td>".$dt['idc_nama']."</td>";
                    echo "<td  style='min-width: 100px;'>".$dt['idc_category']."</td>";
                    echo "<td>".$dt['idc_satuan']."</td>";
                    echo "<td style='min-width: 150px;'><a class='btn btn-small btn-warning btn-edit-data-indicator' id='".$dt['idc_id']."' value='".$dt['idc_nama']."' category='".$dt['idc_category']."' satuan='".$dt['idc_satuan']."' data-dismiss='modal'>Edit</a> "
                            . "<a class='btn btn-small btn-danger btn-delete-data-indicator' value='".$dt['idc_id']."' data-dismiss='modal' >delete</a></td>";
                    echo "</tr>";
                $i++;}?>
            </table>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-success" data-dismiss="modal">Close</a>
            <a class="btn btn-primary" id="btn-tambah-kebutuhan-data" data-dismiss="modal" >Add New Indicator</a>
            
        </div>
    </div>

<!-- Modal Edit kebutuhan data -->
    <div class="modal fade" id="modal-edit-kebutuhan-data">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Form Update Data Indicator</h3>
        </div>
        <div class="modal-body">
            <div class="modal-body">
              <div class="form-group">
                <label for="exampleInputColumn">Nama Data Indicator</label>
                <input type="hidden" class="form-control input-xlarge" id="update-id">
                <input type="text" class="form-control input-xlarge" id="update-column" placeholder="Column Name...">
              </div>
              <div class="form-group">
                <label for="exampleInputColumn">Satuan Data</label>
                <input type="text" class="form-control input-xlarge" id="update-satuan" placeholder="Satuan Data Name...">
              </div>
              <div class="form-group">
                <label for="exampleInputColumn">Kategori</label>
                <select id="update-category">
                    <?php foreach($listCategory as $lists){
                        echo '<option value="'.$lists->ctg_nama.'">'.$lists->ctg_nama.'</option>';
                    }?>
                </select>
              </div>
          </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-success btn-close-update-data-indicator" data-dismiss="modal" id="btn-close-update-data-indicator">Back</a>
            <a href="#" class="btn btn-primary" id="btn-save-update-data-indicator" data-dismiss="modal">Save & Close</a>
        </div>
    </div>
    
<!-- Modal Show list category -->    
<div class="modal fade bs-example-modal-sm" id="modal-show-list-category" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>List Category</h3>
    </div>
    <div class="modal-content">
        <div class="modal-body">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Category</th>
                    <th>Last Update</th>
                    <th>Actions</th>
                </tr>
                <?php $i=1;foreach($listCategory as $ctg){
                    echo "<tr>";
                    echo "<td>".$i."</td>";
                    echo "<td>".$ctg['ctg_nama']."</td>";
                    echo "<td>".$ctg['ctg_last_update']."</td>";
                    echo "<td style='min-width: 150px;'><a class='btn btn-small btn-warning btn-edit-category' id='".$ctg['ctg_id']."' name='".$ctg['ctg_nama']."' data-dismiss='modal'>Edit</a> "
                            . "<a class='btn btn-small btn-danger btn-delete-category' id='".$ctg['ctg_id']."' data-dismiss='modal' >delete</a></td>";
                    echo "</tr>";
                $i++;}?>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-success btn-close-update-data-indicator" data-dismiss="modal" id="btn-close-update-data-indicator">Back</a>
        <a href="#" class="btn btn-primary" id="btn-add-new-category" data-dismiss="modal">Add New Category</a>
    </div>
  </div>
</div>


<!-- Modal Add New Category -->
<div class="modal fade bs-example-modal-sm" id="modal-add-new-category" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Form Category</h3>
    </div>
    <form action="<?php echo Yii::app()->request->baseUrl;?>/index.php?r=kelurahan/addCategory" method="POST">
    <div class="modal-content">
        <div class="modal-body">
            <table class="table table-hover">
                <tr>
                    <th>Nama Category</th>
                    <th>:</th>
                    <th><input type="text" class="input-medium" name="ctg_nama"></th>
                </tr>
            </table>
            
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-success btn-close-update-data-indicator" data-dismiss="modal" id="btn-close-update-data-indicator">Back</a>
        <button class="btn btn-primary" type="submit">Save & Close</button>
    </div>
    </form>
  </div>
</div>

<!-- Modal Edit Category -->
<div class="modal fade bs-example-modal-sm" id="modal-edit-category">
  <div class="modal-dialog modal-sm">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Form Category</h3>
    </div>
    <form action="<?php echo Yii::app()->request->baseUrl;?>/index.php?r=kelurahan/updateCategory" method="POST">
    <div class="modal-content">
        <div class="modal-body">
            <table class="table table-hover">
                <tr>
                <input type="hidden" class="input-medium" name="upd-ctg_id" id="upd-ctg_id">
                    <th>Nama Category</th>
                    <th>:</th>
                    <th><input type="text" class="input-medium" name="upd-ctg_name" id="upd-ctg_name"></th>
                </tr>
            </table>
            
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-success btn-close-update-data-indicator" data-dismiss="modal" id="btn-close-update-data-indicator">Back</a>
        <button class="btn btn-primary" type="submit">Save & Close</button>
    </div>
    </form>
  </div>
</div>

<script type="text/javascript" language="javascript">
    var kec_id;
    var rNamaIndicator;
    

       
    $(document).ready(function() {
        $('#data').dataTable({
            "data": <?php echo $model; ?>,
            "deferRender": true
        });
        $('.html5-progress-bar').hide();
        $('#modal-kebutuhan-data').hide();
        $('#error').hide();
        $('#success').hide();
        $('#modal-update').hide();
        $('#alert').hide();
        $('.modal').hide();
        
        $('#btn-add-new-category').click(function (){
            $('#modal-add-new-category').modal('show');
        });
        
        $('#btn-show-list-category').click(function (){
            $('#modal-show-list-category').modal('show');
        });
        
        $('#btn-list-kebutuhan-data').click(function (){
            $('#modal-list-kebutuhan-data').modal('show');
        });
        $('#btn-tambah-kebutuhan-data').click(function (){
            $('#modal-form-kebutuhan-data').modal('show');
        });
        $('#close-modal-form-kebutuhan-data').click(function (){
            $('#modal-list-kebutuhan-data').modal('show');
        })
        
        $('.btn-edit-category').click(function (){
            rCtgID = $(this).attr('id');
            rCtgName = $(this).attr('name');
            $('#upd-ctg_id').val(rCtgID);
            $('#upd-ctg_name').val(rCtgName);
            $('#modal-edit-category').modal('show');
        })
        
        
        $('.btn-edit-data-indicator').click(function (){
            rIDIndicator = $(this).attr('id');
            rNamaIndicator = $(this).attr('value');
            rCategory = $(this).attr('category');
            rSatuan = $(this).attr('satuan');
            $('#update-id').val(rIDIndicator);
            $('#update-column').val(rNamaIndicator);
            $('#update-satuan').val(rSatuan);
            $('#update-category').append("<option selected value='"+rCategory+"'>"+rCategory+"</option>");
            $('#modal-edit-kebutuhan-data').modal('show');
        });
        $('.btn-close-update-data-indicator').click(function (){
            $('#modal-list-kebutuhan-data').modal('show');
        })
        
        $("#save-kebutuhan-data").click(function (){
            var tColumn = $("#column").val();
            var tSatuan = $("#satuan").val();
            var tCategory = $("#category").val();
                $.post( "<?php echo Yii::app()->homeUrl; ?>/?r=kelurahan/addInformasi", {
                    addIndicator : true,
                    namaIndicator : tColumn,
                    satuan : tSatuan,
                    category : tCategory
                })
                    .done(function( data ) {
                        if(data!=null){
                            alert( data )
                            location.reload();
                        }else{
                            alert("Data gagal diproses");
                        }
                    });
        });
        
        $('#btn-save-update-data-indicator').click(function (){
            var tIDIndicator = $("#update-id").val();
            var tNama = $("#update-column").val();
            var tSatuan = $("#update-satuan").val();
            var tCategory = $("#update-category").val();
            var ajaxTime= new Date().getTime();
            var request= $.ajax( {
                url : "<?php echo Yii::app()->homeUrl; ?>/?r=kelurahan/updateInformasi", 
                data : {
                        updateIndicator : true,
                        idc_id : tIDIndicator,
                        nama : tNama,
                        satuan : tSatuan,
                        category : tCategory
                },
                dataType: 'JSON'});
                request.done(function( data ) {
                    if(data==1){
                        $("#success").slideDown(500);
                        location.reload();
                    }else{
                        $("#error").slideDown(500);
                    }
                });
                request.fail(function (jqXHR, textStatus ){
                    alert(textStatus);
                    $("#error").slideDown(500).delay( 2000 ).fadeOut(500);
                });
        })
        
        
        $('#do-delete').click(function (){
            var id = $('#kel_id').val();
            var url =  "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=kelurahan/delete"
                $.post(url , { id : id } )
                    .done(function(data){
                        if(data==1){
                            $("#success").slideDown(500).delay( 2000 ).slideUp(500);
                             location.reload();
                        }else{
                            $("#error").slideDown(500).delay( 2000 ).fadeOut(500);
                        }
                        
                    });
        })
        
        //Action Delete Category
        $('.btn-delete-category').click(function (){
            if (!confirm('Anda yakin ingin menghapus data ini ?'))
            return false;
            rctg_id = $(this).attr('id');
            var url =  "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=kelurahan/deleteCategory"
                $.post(url , { deleteCategory : true ,ctg_id : rctg_id } )
                    .done(function(data){
                        if(data==1){
                            $("#success").slideDown(500).delay( 2000 ).slideUp(500);
                            alert("Data berhasil dihapus");
                             location.reload();
                        }else{
                            alert("Data gagal dihapus");
                            $("#error").slideDown(500).delay( 2000 ).fadeOut(500);
                        }
                        
                    });
        })
        
         //Action Delete Data Indicator
        $('.btn-delete-data-indicator').click(function (){
            if (!confirm('Menghapus Data ini akan mengakibatkan \n'
                          + 'data indicator disetiap kelurahan akan ikut terhapus\n'
                           + 'Anda yakin ingin menghapus data ini ?'))
            return false;
            idc_id = $(this).attr('value');
            var url =  "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=kelurahan/deleteInformasi"
                $.post(url , { deleteInformasi : true ,idc_id : idc_id } )
                    .done(function(data){
                        if(data==1){
                            $("#success").slideDown(500).delay( 2000 ).slideUp(500);
                             location.reload();
                        }else{
                            $("#error").slideDown(500).delay( 2000 ).fadeOut(500);
                        }
                        
                    });
        })
        
        
        
        
       //Check Status Update kelurahan
           var rc = "<?php if(isset($_GET['rc'])){echo $_GET['rc'];}?>";
           if(rc=="00"){
               alert("Data Berhasil Di Update");
           }else if(rc=="05"){
               alert("Data Gagal Di Update");
           }
        
        
    });    
    
    function confirmDelete(tID){
        var id = tID;
        $('#alert').modal('show');
        $('#kel_id').val(id);
    }

    function showUpdate(tID){   
        kec_id = tID;
        var url = "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=kelurahan/update";
        jQuery.post( url, { id : kec_id })
            .done(function( data ) {
                var tData = JSON.parse(data);
                $('#upd-id').val(tData[0]);
                $('#upd-nama').val(tData[1]);
                $('#upd-alamat').val(tData[2]);
                $('#upd-x').val(tData[3]);
                $('#upd-y').val(tData[4]);
                idkec = tData[5];
                kecamatan = JSON.parse(tData[6]);
                $("#kec_id").empty();
                for(i=0;i<kecamatan.length;i++){
                    if(idkec==kecamatan[i].id){
                        val = "<option value='" 
                        + kecamatan[i].id + "' selected>" 
                        + kecamatan[i].nama + "</option>"
                    }else{
                        val = "<option value='" 
                        + kecamatan[i].id + "'>" 
                        + kecamatan[i].nama + "</option>"}
                    $("#kec_id").append(val);
                };
            });
            $('#modal-update').modal('show');
    };
    
  
    
    
    
    function runProgress(){
        $('.html5-progress-bar').show();
        $('.col-lg-10').css('display', 'none');
        var progressbar = $('#progressbar'),
                max = progressbar.attr('max'),
                time = (1000/max)*12,	
        value = progressbar.val();

        var loading = function() {
            value += 1;
            addValue = progressbar.val(value);

            $('.progress-value').html(value + '%');

            if (value == max) {
                clearInterval(animate);
                $("#error").slideDown(500);
//                location.reload();
            }
        };

        var animate = setInterval(function() {
            loading();
        }, time);
    }

    
</script>