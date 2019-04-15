<?php

class MyLinkPager extends CLinkPager
{
	public $header = '';
    public $prevPageLabel = '&laquo; назад';
    public $nextPageLabel = 'далее &raquo;';
	public $maxButtonCount = 7;
	public $htmlOptions = array(
        'class'=>'mypager'
    );

	public function __construct($owner=null)
	{
		$this->cssFile = Yii::app()->request->getBaseUrl(true).'/css/pager.css';
		parent::__construct($owner);
	}
}
