<?php

class vod_controller extends controller
{
	public function index()
	{
		$content = $this->getView(DOCVIEW.'vod/index.php', array());
		$p = array(
			'content' => $content
		);
		$view = $this->getView(DOCVIEW.'template/template.php', $p);
		echo $view;
	}	
	
	public function add()
	{
		echo 'test 2';
	}
}
