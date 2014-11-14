<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
print_r($model);
?>

<table class="table table-striped" id="page-table" >
        <tr>
            <thead>
                <th>No</th>
                <th>Nama User</th>
                <th>Password</th>
                <th>Level</th>
                <th>Last Update</th>
                <th>Actions</th>
            </thead>
        </tr>
        <tbody>
        <?php $i=1;foreach ($model as $val){ ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $val['username'];?></td>
            <td><?php echo $val['password'];?></td>
            <td><?php echo $val['level'];?></td>
            <td><?php echo $val['last_update'];?></td>
            <td><a class='btn btn-mini btn-success btn-xs' title='edit'><i class='icon-pencil'></i></a>&nbsp;&nbsp;&nbsp;
                <a class='btn btn-mini btn-danger delete' title='delete'><i class='icon-trash'></i></a>&nbsp;&nbsp;&nbsp;
            </td>
        <?php $i++;} ?>
        <?php if(!Yii::app()->user->isGuest){ ?>
        </tbody>
        <tr>
            <th colspan="4">
                <button class="btn btn-small btn-primary" data-toggle="modal" data-target=".bs-save">Add</button>
                <a target="_blank" class="btn btn-small btn-info" href="<?php // echo Yii::app()->request->baseUrl;?>/index.php/?r=kecamatan/print&kec_id=<?php // echo $data[0];?>">Print All</a>
            </th>
        </tr>
        <?php } ?>
    
</table>

