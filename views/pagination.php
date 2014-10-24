<?php if($page > 1):?>
	<a href="/news/index/?p=<?php echo ($page-1);?>"><<</a>
<?php endif;?>

<?php for ($p = 1; $p <= $pages; $p++):?>
	<?php if($p == $page):?>
		<span><?php echo $p;?></span>
	<?php else: ?>
		<a href="/news/index/?p=<?php echo $p;?>"><?php echo $p;?></a>
	<?php endif;?>
<?php endfor;?>

<?php if($page < $pages):?>
	<a href="/news/index/?p=<?php echo ($page+1);?>">>></a>
<?php endif;?>