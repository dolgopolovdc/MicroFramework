<?php

class Controller_News extends Controller
{

    function __construct()
	{
		$this->model = new Model_News();
		$this->view = new View();
	}
	
	// главная страница новостей
	function action_index()
	{
	    $page = isset($_REQUEST['p']) ? (int)$_REQUEST['p'] : 1;
		$news = $this->model->getAll($page);
		$count = $this->model->getCount();
		$pages =  ceil($count/PAGER); // колличество страниц
		
		$this->view->generate('news_view.php', 'template_view.php', array('news'=>$news, 'page'=>$page, 'pages'=>$pages));
	}
	
	// страница новости
    function action_post()
	{
		$post = $this->model->getById($_REQUEST['id']);
		
		if(isset($post))
		{
		  $this->view->generate('post_view.php', 'template_view.php', array('post'=>$post));
		}
		else
		{
		  header( 'Refresh: 0; url=/404' );
		}
	}
	
	// создание новости
    function action_create()
	{
	    $title = isset($_POST['title']) ? $_POST['title'] : "";
	    $text = isset($_POST['text']) ? $_POST['text'] : "";
	    
	    if(!empty($_POST["title"])&&!empty($_POST["text"]))
	    {
	      $post = $this->model->create($title, $text);
	      if($post)
	        echo "Новость создана";
	    }
	    
		$this->view->generate('create_view.php', 'template_view.php', array('title'=>$title, 'text'=>$text));
	}
	
	// редактирование новости
    function action_update()
	{
	    $id = isset($_POST['id']) ? $_POST['id'] : "";
	    $date = isset($_POST['date']) ? $_POST['date'] : "";
	    $title = isset($_POST['title']) ? $_POST['title'] : "";
	    $text = isset($_POST['text']) ? $_POST['text'] : "";
	    
	    if(!empty($_POST["id"])&&!empty($_POST["title"])&&!empty($_POST["date"])&&!empty($_POST["text"]))
	    {
	      $post = $this->model->update($id, $title, $date, $text);
	      if($post)
	        echo "Новость обнавлена";
	    } 
	    
	    $post = $this->model->getById($_REQUEST['id']);
		$this->view->generate('update_view.php', 'template_view.php', array('post'=>$post));
	}
	
	// удаление новости
    function action_delete()
	{
	    $post = $this->model->delete($_REQUEST['id']);
		if(isset($post))
		{
		  header( 'Refresh: 0; url=/' );
		}
		else
		{
		  header( 'Refresh: 0; url=/404' );
		}
	}
}