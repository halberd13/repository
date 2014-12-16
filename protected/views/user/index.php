<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($error)){echo $error;}
  if(Yii::app()->user->level == 'admin'){?>
        <table class="table table-bordered" id="add-user">
            <tr><th>Form Add New User</th></tr>
            <tr>
                <td style="text-align: left;">
                    <form name="AddUser" class="form-group" action="<?php echo Yii::app()->request->baseUrl;?>/index.php?r=user/add" role="form" method="post" enctype="multipart/form-data">
                      
                            <label>Username <b style="color: red;">*</b></label>
                            <input type="text" name="AddUser[username]" placeholder="type username…">
                            <label>Password <b style="color: red;">*</b></label>
                            <input type="password" name="AddUser[password]" placeholder="type password…">
                            <label>Email <b style="color: red;">*</b></label>
                            <input type="email" name="AddUser[email]" placeholder="type email…">
                            <label>Nomor HP <b style="color: red;">*</b></label>
                            <input type="number" name="AddUser[no_hp]" placeholder="type nomor hp…">
                            <label>Level</label>
                            <select name="AddUser[level]" id="level" onchange="selectLevelAdd()">
                                <option value="admin">Admin</option>
                                <option value="kecamatan">Admin Kecamatan</option>
                                <option value="kelurahan">Admin Kelurahan</option>
                                <option value="guest">User Guest</option>
                            </select>
                            <div id="select-kelurahan">
                                <label>Read/Edit Kelurahan</label>
                                <select name='AddUser[privilege-kelurahan]'>
                                <?php foreach($listKelurahan as $val){
                                    echo '<option value="'.$val->kel_id.'">'.$val->kel_nama.'</option>';
                                }?>
                                </select>
                            </div>
                            <div id="select-kecamatan">
                                <label>Read/Edit Kecamatan</label>
                                <select name='AddUser[privilege-kecamatan]'>
                                <?php foreach($listKecamatan as $val){
                                    echo '<option value="'.$val->kec_id.'">'.$val->kec_nama.'</option>';
                                }?>
                                </select>
                            </div>

                      </div>
                      <div class="modal-footer">
                          <p>(<b style="color: red;">*</b>) Wajib diisi</p>
                          <button type="button" class="btn btn-default" id="btn-close-add-user">Close</button>
                        <button type="submit" class="btn btn-primary">Save & Close</button>
                      </div>
                  </form>
                </td>
            </tr>
        </table>
<?php }?>

    <table id="data" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Level</th>
                <th>Last Update</th>
                 <?php if(Yii::app()->user->level != 'guest'){?>
                <th>Actions</th>
                 <?php } ?>
            </tr>

        </thead>
            <?php $i=1;foreach ($model as $val){ ?>
            <tr>
                <td style="text-align: center;"><?php echo $i;?></td>
                <td><?php echo $val['username'];?></td>
                <td><?php echo $val['email'];?></td>
                <td><?php echo $val['no_hp'];?></td>
                <td><?php echo $val['level'];?></td>
                <td><?php echo $val['last_update'];?></td>
                <?php if(Yii::app()->user->level != 'guest'){?>
                <td>
                    <a class='btn btn-mini btn-success btn-xs' title='edit' onclick="showUpdate('<?php echo $val['user_id'];?>')"><i class='icon-pencil'></i></a>&nbsp;

                    <?php  if(Yii::app()->user->level == 'admin'){?>
                    <a class='btn btn-mini btn-danger' onclick="deleteUser('<?php echo $val['user_id'];?>')" title='delete'><i class='icon-trash'></i></a>
                    <a class='btn btn-mini btn-xs' title='Ubah Password' onclick="changePassword('<?php echo $val['user_id'];?>')"><i class='icon-lock'></i></a>&nbsp;
                    <?php } ?>
                </td>
            <?php } $i++;}?>
            </tr>
            <tfoot>
                <?php if(Yii::app()->user->level == 'admin'){?>
                <tr>
                    <td colspan="7">
                        <button id="btn-add-user" class="btn btn-small btn-primary">Tambah</button>
                    </td>
                </tr>
                <?php } ?>
            </tfoot>
            
    </table>




<div class="modal fade" id="modal-update-user" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Form Update User</h4>
      </div>
        <form name="User" class="form-group" action="<?php echo Yii::app()->request->baseUrl;?>/index.php?r=user/update" role="form" method="post" enctype="multipart/form-data">
          <div class="modal-body">
                  <input type="hidden" name="User[user_id]" id="upd-user_id">
                    <label>Username</label>
                    <input type="text" name="User[username]" id="upd-username">
                    <label>Email</label>
                    <input type="email" name="User[email]" id="upd-email">
                    <label>No HP</label>
                    <input type="text" name="User[no_hp]" id="upd-no_hp">
                    <?php if(Yii::app()->user->level == 'admin'){?>
                        <label>Level</label>
                        <select name="User[level]" id="upd-level" onchange="selectLevel()">
                            <option value="admin">Admin</option>
                            <option value="kecamatan">Admin Kecamatan</option>
                            <option value="kelurahan">Admin Kelurahan</option>
                            <option value="guest">User Guest</option>
                        </select>
                        <fieldset id="upd-select-kelurahan">
                            <label>Read/Edit Kelurahan</label>
                            <select name='User[privilege-kelurahan]'>
                            <?php foreach($listKelurahan as $val){
                                echo '<option value="'.$val->kel_id.'">'.$val->kel_nama.'</option>';
                            }?>
                            </select>
                        </fieldset>
                        <fieldset id="upd-select-kecamatan">
                            <label>Read/Edit Kecamatan</label>
                            <select name='User[privilege-kecamatan]'>
                            <?php foreach($listKecamatan as $val){
                                echo '<option value="'.$val->kec_id.'">'.$val->kec_nama.'</option>';
                            }?>
                            </select>
                        </fieldset>
                    <?php }?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" onke data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
      </form>
    </div>
  </div>
</div>  

<div class="modal fade" id="modal-update-user-password" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Form Update User Password</h4>
      </div>
        <form name="UserPassword" class="form-group" action="<?php echo Yii::app()->request->baseUrl;?>/index.php?r=user/update" role="form" method="post" enctype="multipart/form-data">
          <div class="modal-body">
                    <label>New Password</label>
                    <input type="hidden" name="user_id" id="pwd-user_id" value="">
                    <input type="password" name="new_password" id="new_password">
                    <label>Retype New Password</label>
                    <input type="password" name="r_new_password" id="r_new_password">
          </div>
          <div class="modal-footer">
              <button type="button" data-dismiss="modal" class="btn btn-warning">Close</button>
              <button type="button" id="btn-save-change-password" data-dismiss="modal" class="btn btn-primary">Save & Close</button>
          </div>
      </form>
    </div>
  </div>
</div> 


        



<script type="text/javascript" language="javascript">
    $(document).ready(function (){
       $('#modal-update-user').hide(); 
       $('#add-user').hide(); 
       $('#data').dataTable();  
       $('#select-kelurahan').hide();
       $('#select-kecamatan').hide();
       $('#upd-select-kelurahan').hide();
       $('#upd-select-kecamatan').hide();
       $('#modal-update-new-password').hide();
       $('#modal-update-user-password').hide();
       
       
       //validate old password
       $('#btn-save-change-password').click(function (){
           if(checkPassword()){
               user_id = $('#pwd-user_id').val();
               new_password = $('#new_password').val();
               var url =  "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=user/changePassword"
                    $.post(url , { changePassword : true ,user_id : user_id, new_password : new_password } )
                        .done(function(data){
                            if(data==1){
                             alert("Password berhasil diupdate");
                             location.reload();
                            }else{
                                alert("Password gagal diupdate");
                            }
                        });
            }else {
                return false;
            }
               
           
       });
       
       //for add field on modal add user
       $('#btn-add-user').click(function (){
           $('#add-user').slideToggle(); 
       })
       $('#btn-close-add-user').click(function (){
           $('#add-user').slideUp();
       });
       
    });
    
    //for check same password 
    function checkPassword(){
       pass1=$('#new_password').val();
       pass2=$('#r_new_password').val();
       if(pass1!=pass2){
           alert("Password tidak sama, silahkan isi dengan benar !");
           return false;
       }else{
           return true;
       }
      
    }
    
    function selectLevel(){
        $('#upd-select-kelurahan').slideUp();
        $('#upd-select-kecamatan').slideUp();
        tSelectedUpd = $('#upd-level').val();
        if(tSelectedUpd=='kelurahan'){
             $('#upd-select-kelurahan').slideDown();       
        }else if(tSelectedUpd=='kecamatan'){
            $('#upd-select-kelurahan').slideDown();
        }
    }  
    function showUpdate(tID){
            var id = tID;
            var url = "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=user/update";
            $.post( url, { id : id })
                .done(function( data ) {
                    var tData = JSON.parse(data);
                    $('#upd-user_id').val(tData[0]);
                    $('#upd-username').val(tData[1]);
                    $('#upd-email').val(tData[2]);
                    $('#upd-no_hp').val(tData[3]);
                });
            $('#modal-update-user').modal('show');
            
    }
    
    
    function selectLevelAdd(){
        $('#select-kelurahan').slideUp();
        $('#select-kecamatan').slideUp();
        tSelected = $('#level').val();
        
        if(tSelected=='kelurahan'){
             $('#select-kelurahan').slideDown();       
        }else if(tSelected=='kecamatan'){
            $('#select-kecamatan').slideDown();
        }
    }
    
    
    function changePassword(user_id){
        $('#pwd-user_id').val(user_id);
        $('#new_password').val("");            
        $('#r_new_password').val("");            
        $('#modal-update-user-password').modal('show');            
    }
    
    function deleteUser(user_id){
        if (!confirm('Anda yakin ingin menghapus data ini ?'))
            return false;
        var url =  "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=user/delete"
                $.post(url , { deleteUser : true ,user_id : user_id } )
                    .done(function(data){
                        if(data==1){
                             location.reload();
                        }
                    });
    }
    
    
    var rc = <?php if(isset($_GET['rc'])){echo $_GET['rc'];}else echo "null";?>;
    if(rc=='01'){
        alert('Password tidak sama');
        location.href = "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=user";
    }else if(rc=='88'){
        alert('Data gagal ditambahkan, Silahkan periksa kembali');
        location.href = "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=user";
    }else if(rc=='00'){
        alert('Data berhasil diupdate');
        location.href = "<?php echo Yii::app()->request->baseUrl;?>/index.php/?r=user";
    } 
</script>