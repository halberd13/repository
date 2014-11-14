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
	'id'=>'kecamatan-form',
        'htmlOptions'=> array( 'class' => 'form-signin',),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        
        ));
echo $form->errorSummary($model, null,null,array('class'=>'control-group warning')); 

?>

    <h4>Form Penambahan Kecamatan</h3>
	<div class="form-group">
		<?php echo $form->hiddenField($model,'kec_id',array('value'=>$uuid['uuid()'])); ?>
                <?php echo $form->labelEx($model,'Nama Kecamatan'); ?>
		<?php echo $form->textField($model,'kec_nama',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'kec_nama'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Alamat'); ?>
		<?php echo $form->textField($model,'kec_alamat',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'kec_alamat'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Lintang'); ?>
		<?php echo $form->textField($model,'kec_kordinat_x',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'kec_kordinat_x'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'Bujur'); ?>
		<?php echo $form->textField($model,'kec_kordinat_y',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'kec_kordinat_y'); ?>
	</div>

       

        <div class="form-group">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array(
                    'class' => 'btn btn-small btn-primary')); echo "&nbsp;"; 
                echo CHtml::resetButton( 'Reset', array(
                    'class' => 'btn btn-small btn-warning'));
                
                ?>
        </div>

<?php $this->endWidget(); ?>
