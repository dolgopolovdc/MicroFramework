<?php

require_once './moduls/parserxml/handler_xml.php';

class Controller_Ads extends Controller
{

    function __construct()
	{
		$this->model = new Model_Ads();
		$this->view = new View();
	}
	
	// главная страница новостей
	function action_index()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$file = $_FILES['xmlfile'];
			
			if (!$file['error'] && $file['type'] == 'text/xml')
			{
				$parser = new Handler_Xml();
				$parser->start($file['tmp_name']);
			}
		}
		
		$this->view->generate('ads_view.php', 'template_view.php', array());
	}
}