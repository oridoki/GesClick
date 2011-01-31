<div class='title rounded'>
	<?= _("Búsqueda de facturas") ?>
</div>
<div class='description'>
	<p><?= _("Resultados de su búsqueda en el apartado de facturas.") ?></p>
</div>

<div class='customer'>
	
	<?= $this->load->view("pieces/lateral", array('options' => array(
		array('href'=>'/bills/add/', 'name' =>_('Nueva Factura')),
			array('href'=>'/bills/add/0/type_id/2/', 'name' =>_('Nuevo Presupuesto')),
		array('href'=>'/payment/resume/', 'name' =>_('Resumen de Pagos'))
	))) ?>
	
	<div class='central'>

		<!-- BILL -->
		<div class='customer_list'>

			<?= $this->load->view("publi/addwordsH") ?>
		
			<div class='bar'>
				<div class='text'><?= _("Resultados de la búsqueda <i>'".$this->uri->segment(3, 0)."'</i> en facturas") ?></div>
			</div>

			<?= $this->load->view("bills/p_list.php", array('bills' => $bills)) ?>

			<div class='bar barbottom'>
				<div class='option add' onClick='window.location="<?= site_url("bills/add") ?>"'><?= _("Nueva Factura") ?></div>
				<div class='pagination'>
					<?php /*$this->pagination->create_links()*/ ?>
				</div>
			</div>

		</div>
		<!-- !BILL -->


	</div>
	
	<div class='floatfix'></div>	
	
</div>