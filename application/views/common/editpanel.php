<div class="panel panel-default panel-table">
	<div class="panel-body">
		<button type="button" class="btn btn-menu" id="createButton" title="Добавить элемент">
			<i class="fa fa-plus fa-2x"></i>
			</br><span class="menu-item">Создать</span>
		</button>
		<button href="#" type="button" class="btn btn-menu disabled" id="editButton" title="Редактировать элемент">
			<i class="fa fa-pencil fa-2x"></i>
			</br><span class="menu-item">Редактировать</span>
		</button>
		<button type="button" class="btn btn-menu disabled" id="deleteButton" data-toggle="modal" data-target="#myModal" title="Удалить элемент">
			<i class="fa fa-trash-o fa-2x"></i>
			</br><span class="menu-item">Удалить</span>
		</button>
	</div>
</div>

<?php $this->load->view('common/deletemodal');  ?>