<?php

class View
{
	function generate($content_view, $template_view, $data = null)
	{
		if(is_array($data)) {
			extract($data);
		}
		include 'views/'.$template_view;
	}
	
    static function pagination($page, $pages)
	{
		include 'views/pagination.php';
	}
}