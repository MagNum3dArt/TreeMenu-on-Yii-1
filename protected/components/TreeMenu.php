<?php

Yii::import('zii.widgets.CMenu');

class TreeMenu extends CMenu{
    public function init(){
        array('id'=>0, 'parent_id'=>0);
        $temp =array(0=>&$items[0]);
        foreach (Category::model()->findAll(array('order'=>'parent_id, id')) as $item){
            $parent = &$temp[$item->parent_id];
            if (!isset($parent['items'])) { $parent['items'] = array(); }
            $parent['items'][$item->id] = array('id'=>$item->id,
                'parent_id'=>$item->parent_id,
                'label'=>$item->title,
                'url'=> Yii::app()->createUrl($item->url));
            $temp[$item->id] = &$parent['items'][$item->id];
        }
        $this->items = $items[0]['items'];
        parent::init();
    }
}