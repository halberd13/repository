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
                        <?php if(!Yii::app()->user->isGuest){ ?>
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
                <option value="Sosial">Sosial</option>
                <option value="Kesehatan">Kesehatan</option>
                <option value="Pemberdayaan Masyarakat dan Perempuan">Pemberdayaan Masyarakat dan Perempuan</option>
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
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" id="submit" class="btn btn-primary">Save changes</button>
          </div>
      </form>
    </div>
  </div>
</div>    
    
    <div class="modal fade" id="modal-list-kebutuhan-data">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>List Data Indicator</h3>
        </div>
        <div class="modal-body">
            <table class="table table-hover">
                <tr>
                    <th>
                        No
                    </th>
                    <th>
                        Data Indicator
                    </th>
                    <th>
                        Category
                    </th>
                    <th>
                        Satuan
                    </th>
                    <th>
                        Actions
                    </th>
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
                    <option value="Sosial">Sosial</option>
                    <option value="Kesehatan">Kesehatan</option>
                    <option value="Pemberdayaan Masyarakat dan Perempuan">Pemberdayaan Masyarakat dan Perempuan</option>
                </select>
              </div>
          </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-success btn-close-update-data-indicator" data-dismiss="modal" id="btn-close-update-data-indicator">Back</a>
            <a href="#" class="btn btn-primary" id="btn-save-update-data-indicator" data-dismiss="modal">Save & Close</a>
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
        $('#btn-list-kebutuhan-data').click(function (){
            $('#modal-list-kebutuhan-data').modal('show');
        });
        $('#btn-tambah-kebutuhan-data').click(function (){
            $('#modal-form-kebutuhan-data').modal('show');
        });
        $('#close-modal-form-kebutuhan-data').click(function (){
            $('#modal-list-kebutuhan-data').modal('show');
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
                        if(data!='0'){
                            alert("Data Indicator di " +data + " Kelurahan yang terdaftar, berhasil ditambahkan")
                            $("#success").slideDown(400);
                             location.reload();
                        }else{
                            $("#error").slideDown(500).fadeOut(500);
                        }
                    });
        });
        
        $('#btn-save-update-data-indicator').click(function (){
            var tIDIndicator = $("#update-id").val();
            var tNama = $("#update-column").val();
            var tSatuan = $("#update-satuan").val();
            var tCategory = $("#update-category").val();
                $.post( "<?php echo Yii::app()->homeUrl; ?>/?r=kelurahan/updateInformasi", {
                    updateIndicator : true,
                    idc_id : tIDIndicator,
                    nama : tNama,
                    satuan : tSatuan,
                    category : tCategory
                })
                .done(function( data ) {
                    if(data==1){
                        $("#success").slideDown(500).delay( 2000 ).fadeOut(500);
                        location.reload();
                    }else{
                        $("#error").slideDown(500).delay( 2000 ).fadeOut(500);
                    }
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
            }
        };

        var animate = setInterval(function() {
            loading();
        }, time);
    }

    
</script>