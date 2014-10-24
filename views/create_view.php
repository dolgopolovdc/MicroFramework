<h2>Новая новость</h2> 
</form>
<form action="/news/create/" method="post">
    <p>
    	<label for="title">Название</label>
		<input id="title" type="text" name="title" value="<?php echo $title;?>"/>
	</p>
    <p>
    	<label for="text">Текст</label>
    	<textarea rows="10" cols="45" id="text" name="text"><?php echo $text;?></textarea>
    </p>
    <p><input type="submit" value="Отправить"></p>
</form>
