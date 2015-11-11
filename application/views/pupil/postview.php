		<div class="col-md-8">
			<div class="blog_grid">
				<h2 class="post_title"><?php if(isset($theme)) echo $theme; ?></h2>
				<ul class="links">
					<li><i class="fa fa-calendar"></i> <?php echo showDate($time); ?></li>
					<li><i class="fa fa-user"></i> <?php echo $teacher; ?></li>
			    </ul>
			    <p><?php echo $text; ?></p>
			</div>
	    </div>
    </div>
</div>