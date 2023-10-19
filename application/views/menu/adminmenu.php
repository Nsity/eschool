<?php 
	$menu = array(
		'admin/teachers' => array(
			'icon' => 'fa-user',
			'title' => 'Учителя',
		),
		'admin/classes' => array(
			'icon' => 'fa-users',
			'title' => 'Классы',
		),
		'admin/subjects' => array(
			'icon' => 'fa-book',
			'title' => 'Общие предметы',
		),
		'admin/rooms' => array(
			'icon' => 'fa-building',
			'title' => 'Кабинеты',
		),
		'admin/types' => array(
			'icon' => 'fa-paperclip',
			'title' => 'Типы оценок',
		),
		'admin/years' => array(
			'icon' => 'fa-calendar',
			'title' => 'Учебные годы',
		),
	);
?>
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Списки <span class="caret"></span></a>
	<ul class="dropdown-menu" role="menu">
		<?php foreach($menu as $slug => $menuItem): ?>
			<li><a href="<?php echo base_url() . $slug;?>"><i class="fa <?php echo $menuItem['icon']; ?>"></i> <?php echo $menuItem['title']; ?></a></li>
		<?php endforeach; ?>
	</ul>
</li>
<li><a href="<?php echo base_url();?>admin/news">Новости</a></li>
<li><a href="<?php echo base_url();?>admin/statistics">Анализ</a></li>;