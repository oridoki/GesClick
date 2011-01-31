<div class='title rounded'>
	<?= _("Listado de Facturas") ?>
</div>
<div class='description'>
	<p><?= _("A continuación puedes encontrar el listado de facturas realizadas, puedes aplicar filtros sobre el listado desde la barra de la derecha.") ?></p>
</div>

<div class='customer'>
	
	<?= $this->load->view("pieces/lateral", array('options' => array(
		array('href' =>'/customer/add/','name' =>_('Nuevo Cliente')),
	))) ?>
	
	<div class='central'>
		
		<!--  facturas -->
		<div class='assistant rounded'>
			<h1>¡Crea tu primer cliente!</h1>
			<p>Todavía no has creado ningún cliente.</p> 
			<p>Para hacerlo haz clic sobre el botón <?= anchor("/customer/add", "'NUEVO CLIENTE'") ?>, en la barra de la izquierda.</p>
			<p>Añade nuevos clientes, gestiona sus datos, facturas, pagos y contactos.</p>
		</div>
		<!--  !facturas -->
		
		
	</div>
</div>