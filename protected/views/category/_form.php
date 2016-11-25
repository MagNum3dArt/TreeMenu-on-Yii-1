<div class="form">

<?php

//use app.models.Category;

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,

));

$categories =  Category::model()->findAll();
$select_parent =[];
// if default value for parent drop down list not the root value, please add default value before '0'=>'root'
$first = ['0'=>'root'];
foreach ($categories as $category) {
	if (!isset($first[$category->id])){
		if($category->parent_id==0 || isset($select_parent[$category->parent_id]) || isset($first[$category->parent_id])){
			$select_parent[$category->id]=$category->title;
		}
	}

}
$select_parent = $first + $select_parent;
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model,'parent_id',$select_parent
//			,array('empty' => '(Select a Parent)')
		); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->