<?php
$this->breadcrumbs=array(
	'Categories',
);

$this->menu=array(
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<h1>Categories</h1>

<?php
//$this->widget('zii.widgets.MyCListView', array(
$this->widget('TreeMenu', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
));

?>