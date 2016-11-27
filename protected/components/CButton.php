<?php
/**
 * Created by PhpStorm.
 * User: xtorx
 * Date: 26.11.2016
 * Time: 10:27
 */

Yii::import('zii.widgets.grid.CButtonColumn');

class CButton extends CButtonColumn{
    /**
     * @var string the template that is used to render the content in each data cell.
     * These tokens are recognized: {view}, {update}, {child} and {delete}. If the {@link buttons} property
     * defines additional buttons, their IDs are also recognized here. For example, if a button named 'preview'
     * is declared in {@link buttons}, we can use the token '{preview}' here to specify where to display the button.
     */
    public $template='{child} {view} {update} {delete}';
    /**
     * @var string the label for the child creation button. Defaults to "View".
     * Note that the label will not be HTML-encoded when rendering.
     */
    public $childButtonLabel;
    /**
     * @var string the image URL for the update button. If not set, an integrated image will be used.
     * You may set this property to be false to render a text link instead.
     */
    public $childButtonImageUrl;
    /**
     * @var string a PHP expression that is evaluated for every update button and whose result is used
     * as the URL for the update button. In this expression, you can use the following variables:
     * <ul>
     *   <li><code>$row</code> the row number (zero-based)</li>
     *   <li><code>$data</code> the data model for the row</li>
     *   <li><code>$this</code> the column object</li>
     * </ul>
     * The PHP expression will be evaluated using {@link evaluateExpression}.
     *
     * A PHP expression can be any PHP code that has a value. To learn more about what an expression is,
     * please refer to the {@link http://www.php.net/manual/en/language.expressions.php php manual}.
     */
    public $childButtonUrl='Yii::app()->controller->createUrl("child",array("id"=>$data->primaryKey))';
    /**
     * @var array the HTML options for the update button tag.
     */
    public $childButtonOptions=array('class'=>'child');


    /**
     * Initializes the default buttons (view, update and delete).
     */
    protected function initDefaultButtons()
    {
        if($this->childButtonLabel===null)
            $this->childButtonLabel=Yii::t('zii','Child');
        if($this->viewButtonLabel===null)
            $this->viewButtonLabel=Yii::t('zii','View');
        if($this->updateButtonLabel===null)
            $this->updateButtonLabel=Yii::t('zii','Update');
        if($this->deleteButtonLabel===null)
            $this->deleteButtonLabel=Yii::t('zii','Delete');
        if($this->childButtonImageUrl===null)
            $this->childButtonImageUrl=$this->grid->baseScriptUrl.'/update.png';
        if($this->viewButtonImageUrl===null)
            $this->viewButtonImageUrl=$this->grid->baseScriptUrl.'/view.png';
        if($this->updateButtonImageUrl===null)
            $this->updateButtonImageUrl=$this->grid->baseScriptUrl.'/update.png';
        if($this->deleteButtonImageUrl===null)
            $this->deleteButtonImageUrl=$this->grid->baseScriptUrl.'/delete.png';
        if($this->deleteConfirmation===null)
            $this->deleteConfirmation=Yii::t('zii','Are you sure you want to delete this item?');

        foreach(array('view','update','delete', 'child') as $id)
        {
            $button=array(
                'label'=>$this->{$id.'ButtonLabel'},
                'url'=>$this->{$id.'ButtonUrl'},
                'imageUrl'=>$this->{$id.'ButtonImageUrl'},
                'options'=>$this->{$id.'ButtonOptions'},
            );
            if(isset($this->buttons[$id]))
                $this->buttons[$id]=array_merge($button,$this->buttons[$id]);
            else
                $this->buttons[$id]=$button;
        }

        if(!isset($this->buttons['delete']['click']))
        {
            if(is_string($this->deleteConfirmation))
                $confirmation="if(!confirm(".CJavaScript::encode($this->deleteConfirmation).")) return false;";
            else
                $confirmation='';

            if(Yii::app()->request->enableCsrfValidation)
            {
                $csrfTokenName = Yii::app()->request->csrfTokenName;
                $csrfToken = Yii::app()->request->csrfToken;
                $csrf = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
            }
            else
                $csrf = '';

            if($this->afterDelete===null)
                $this->afterDelete='function(){}';

            $this->buttons['delete']['click']=<<<EOD
function() {
	$confirmation
	var th = this,
		afterDelete = $this->afterDelete;
	jQuery('#{$this->grid->id}').yiiGridView('update', {
		type: 'POST',
		url: jQuery(this).attr('href'),$csrf
		success: function(data) {
			jQuery('#{$this->grid->id}').yiiGridView('update');
			afterDelete(th, true, data);
		},
		error: function(XHR) {
			return afterDelete(th, false, XHR);
		}
	});
	return false;
}
EOD;
        }
    }

}