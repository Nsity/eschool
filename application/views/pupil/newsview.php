<?php
	function crop_str($string, $limit){
		if (strlen($string) >= $limit ) {
			$substring_limited = substr($string,0, $limit);
			return substr($substring_limited, 0, strrpos($substring_limited, ' ' ));
		} else {
			//Если количество символов строки меньше чем задано, то просто возращаем оригинал
			return $string;
		}
	}

?>
		<div class="col-md-8">
			<?php
				if(is_array($news) && count($news) ) {
					foreach($news as $row){ ?>
			<div class="blog_grid">
				<h2 class="post_title"><a href="<?php echo base_url(); ?>pupil/post/<?php echo $row['NEWS_ID']; ?>"><?php echo $row['NEWS_THEME'] ?></a></h2>
				<ul class="links">
					<li><i class="fa fa-calendar"></i> <?php echo showDate($row['NEWS_TIME']); ?></li>
					<li><i class="fa fa-user"></i> <?php echo $row['TEACHER_NAME']; ?></li>
			    </ul>
			    <p><?php $str = crop_str($row['NEWS_TEXT'], 1000);
				    if($str != $row['NEWS_TEXT'])  {
					    echo $str." ...";
				    }
				    else echo $str;
			    ?></p>
			   <?php if($str != $row['NEWS_TEXT']) { ?> <button onclick="location.href='<?php echo base_url();?>pupil/post/<?php echo $row['NEWS_ID']; ?>';" class="btn btn-sample" title="Подробнее">Подробнее</button><?php } ?>
			</div>
			<?php }} ?>
			<?php echo $this->pagination->create_links(); ?>
	    </div>
    </div>
</div>




