<div class='title rounded'>
	<?= _("Resumen de facturación") ?>
</div>
<div class='description'>
	<p><?= _("Resumen de facturas, presupuestos, albaranes y proformas.") ?></p>
</div>

<div class='customer'>
	
	<?= $this->load->view("pieces/lateral", array('options' => array(
		array('href'=>'/bills/add/', 'name' =>_('Nueva Factura')),
		array('href'=>'/bills/add/0/type_id/2/', 'name' =>_('Nuevo Presupuesto')),
		array('href'=>'/bills/add/0/type_id/2/', 'name' =>_('Nueva Pro-Forma')),
		array('href'=>'/bills/add/0/type_id/2/', 'name' =>_('Nuevo Albarán')),
		array('href'=>'/payment/resume/', 'name' =>_('Resumen de Cobros'))
	))) ?>
	
	<div class='central'>

		<!-- BILL -->
		<div class='customer_list'>

			<?= $this->load->view("publi/addwordsH") ?>
		
			<div class='bar'>
				<div class='text'><?= _("FACTURAS") ?></div>
			</div>

			<?= $this->load->view("bills/p_list.php", array('bills' => $bills)) ?>

			<div class='bar barbottom'>
				<div class='option add' onClick='window.location="<?= site_url("bills/add") ?>"'><?= _("Nueva Factura") ?></div>
				<div class='pagination'>
					<?= $this->pagination->create_links() ?>
					<div class='totals'>
						<?php $total = 0 ?>
						<?php foreach($bills as $bill): ?>
							<?php $total += $bill['total'] ?>
						<?php endforeach ?>
						TOTAL: <?= number_format($total, 2, ",", ".") ?> €
					</div>
				</div>

			</div>

		</div>
		<!-- !BILL -->

	</div>
	
	<div class='floatfix'></div>	
	
</div>