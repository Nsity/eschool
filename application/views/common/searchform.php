<?php 
	$placeholder = isset($placeholder) ? $placeholder : "Поиск по наименованию";
	$search = isset($search) ? $search : "";
?>
<form method="get">
	<div class="input-group">
		<input type="search" class="form-control" placeholder="<?php echo $placeholder; ?>" id="search" name="search" value="<?php echo $search; ?>">
		<span class="input-group-btn">
		<button class="btn btn-default" type="submit" name="submit" id="searchButton" title="Поиск"><i class="fa fa-search"></i></button>
		</span>
	</div><!-- /input-group -->
</form>