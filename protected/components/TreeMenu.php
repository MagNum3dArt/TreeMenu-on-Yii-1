<?php
Yii::import('zii.widgets.grid');
Yii::import('zii.widgets.CMenu');

class TreeMenu extends CMenu{

    public $encodeLabel = 'false';

    private $img_path = '/assets/2b7a6c91/gridview/';

    public function init(){
        array('id'=>0, 'parent_id'=>0);
        $temp =array(0=>&$items[0]);
        foreach (Category::model()->findAll(array('order'=>'parent_id, id')) as $item){
            $parent = &$temp[$item->parent_id];
            if (!isset($parent['items'])) { $parent['items'] = array(); }
            $parent['items'][$item->id] = array('id'=>$item->id,
                'parent_id'=>$item->parent_id,
                'label'=>$item->title,
                'url'=> Yii::app()->createUrl($item->url),
                'template'=>'<strong>{menu}</strong>   (<a title="Add child" href="index.php?r=category/child&id='.$item->id.'"><i class="fa fa-plus" aria-hidden="true"></i></a>, <a title="View" href="index.php?r=category/view&id='.$item->id.'"><i class="fa fa-search" aria-hidden="true"></i></a>, <a title="Update" href="index.php?r=category/update&id='.$item->id.'"><i class="fa fa-pencil" aria-hidden="true"></i></a>)',
            );

            $temp[$item->id] = &$parent['items'][$item->id];
        }
        $this->items = $items[0]['items'];
        parent::init();
    }
}
//<img src="/assets/2b7a6c91/gridview/view.png" alt="View">