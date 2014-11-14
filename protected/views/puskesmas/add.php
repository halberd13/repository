<?php
/* @var $this PuskesmasController */
/* @var $model Puskesmas */
/* @var $form CActiveForm */
?>
<style type="text/css">
      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 25px auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'puskesmas-form',
        'htmlOptions'=> array( 'class' => 'form-signin',),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
        
        ));
echo $form->errorSummary($model, null,null,array('class'=>'label-important')); 
?>

    <h4>Form Penambahan Puskesmas</h3>
        <div class="form-group">
		<?php echo $form->hiddenField($model,'pusk_id',array('value'=>$uuid['uuid()'])); ?>
		<?php echo $form->error($model,'pusk_id'); ?>
	</div>
        <div class="form-group">
		<?php echo $form->labelEx($model,'Kelurahan'); ?>
		<?php echo $form->dropDownList($model,'kel_id', $data ); ?>
		<?php echo $form->error($model,'kel_id'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'Nama Puskesmas'); ?>
		<?php echo $form->textField($model,'pusk_nama',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'pusk_nama'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Kode Puskesmas'); ?>
		<?php echo $form->textField($model,'pusk_kode_puskesmas',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'pusk_kode_puskesmas'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Alamat'); ?>
		<?php echo $form->textField($model,'pusk_alamat',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'pusk_alamat'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Jenis Puskesmas'); ?>
		<?php echo $form->textField($model,'pusk_jenis_puskesmas',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'pusk_jenis_puskesmas'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Lintang'); ?>
		<?php echo $form->textField($model,'pusk_kordinat_x',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'pusk_kordinat_x'); ?>
	</div>
        <div class="form-group">
		<?php echo $form->labelEx($model,'Bujur'); ?>
		<?php echo $form->textField($model,'pusk_kordinat_y',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'pusk_kordinat_y'); ?>
	</div>
        

        <div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array(
                    'class' => 'btn btn-small btn-primary')); ?>
        </div>

<?php $this->endWidget(); ?>
