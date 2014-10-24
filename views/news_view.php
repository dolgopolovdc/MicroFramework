<h2>Лента новостей</h2>
<a href="/news/create/">добавить новость</a>
<table border="1">
<?php foreach ($news as $item):?>
    <tr><td>
    	  <?php echo $item->id;?>
    	</td>
    	<td>
    		<a href="/news/post/?id=<?php echo $item->id;?>">
    		  <?php echo $item->title;?>
    		</a>
    	</td>
    	<td>
    	  <?php echo $item->date;?>
    	</td>
    	<td>
    		<a href="/news/update/?id=<?php echo $item->id;?>">
    		  редактировать
    		</a>
    	</td>
    	<td>
    		<a href="/news/delete/?id=<?php echo $item->id;?>">
    		  удалить
    		</a>
    	</td>
    <tr>   
<?php endforeach;?>
</table>

<?php View::pagination($page, $pages); ?>