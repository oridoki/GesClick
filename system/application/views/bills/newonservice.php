<div class='title rounded'>
	<?= _("Listado de Facturas") ?>
</div>
<div class='description'>
	<p><?= _("A continuación puedes encontrar el listado de facturas realizadas, puedes aplicar filtros sobre el listado desde la barra de la derecha.") ?></p>
</div>

<div class='customer'>
	
	<?= $this->load->view("pieces/lateral", array('options' => array(
		array('href'=>'/bills/add/', 'name' =>_('Nueva Factura')),
		array('href'=>'/payment/resume/', 'name' =>_('Resumen de Pagos'))
	))) ?>
	
	<div class='central'>
		
		<!--  facturas -->
		<div class='assistant rounded'>
			<h1>¡Crea tu primera factura!</h1>
			<p>Todavía no has creado ninguna factura.</p> 
			<p>Para hacerlo haz clic sobre el botón <?= anchor("/bills/add", "'NUEVA FACTURA'") ?>, en la barra de la izquierda.</p>
			<p>Crea nuevas facturas, genera listados de facturas trimestrales, anuales, por cliente, etc.</p>
		</div>
		<!--  !facturas -->
		
		
	</div>
</div>