<h2>Новая новость</h2> 
</form>
<form action="/news/update/?id=<?php echo $post->id;?>" method="post">
    <p>
    	<input id="id" type="text" name="id" value="<?php echo $post->id;?>" hidden/>
    	<label for="title">Название</label>
		<input id="title" type="text" name="title" value="<?php echo $post->title;?>"/>
	</p>
	<p>
    	<label for="date">Дата</label>
		<input id="date" type="text" name="date" value="<?php echo $post->date;?>"/>
	</p>
    <p>
    	<label for="text">Текст</label>
    	<textarea rows="10" cols="45" id="text" name="text"><?php echo $post->text;?></textarea>
    </p>
    <p><input type="submit" value="Отправить"></p>
</form>
