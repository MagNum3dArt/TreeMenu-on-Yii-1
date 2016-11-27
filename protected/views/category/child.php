<?php
/**
 *
 * @var CategoryController $this
 * @var \Category $model
 */

$this->breadcrumbs=array(
    'Categories'=>array('index'),
    'Add Child',
);

$this->menu=array(
    array('label'=>'List Category', 'url'=>array('index')),
    array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

    <h1>Add Child</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>