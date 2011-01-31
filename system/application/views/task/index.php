<div class='title rounded'>
	<?= _("Gestión de Tascas") ?>
</div>
<div class='description'>
	<p><?= _("Gestión de Tascas") ?>.</p>
</div>


<div class='bills'>

	<?= $this->load->view("pieces/lateral", array('options' => array(
		array(
			'name' 			=> _('Nueva Tarea'),
			'action' 		=> 'editTask(0)'
		)
	))) ?>

	<div class='central'>

		<div class='taskList'>
			<div class='customer_list'>
				<div class='bar'>
					<div class='text'>GESTIÓN DE TASCAS</div>
				</div>
				<?= $this->load->view("task/p_list.php", array('tasks' => $tasks, 'companies' => $companies)) ?>
				<div class='bar barbottom'>
					<div class='option add' onClick='editTask(0)'><?= _("Nueva Tarea") ?></div>
				</div>
			</div>
		</div>

	</div>

	
	<div class='floatfix'></div>

</div>