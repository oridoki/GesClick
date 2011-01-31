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
				<div class='option add' onClick='window.location="<?= site_url("bills/justbills") ?>"'><?= _("Todas las Facturas") ?></div>
				<?php /*
				<div class='pagination'>
					$this->pagination->create_links()
				</div>
				*/ ?>
				<div class='totals'>
					<?php $total = 0 ?>
					<?php foreach($bills as $bill): ?>
						<?php $total += $bill['total'] ?>
					<?php endforeach ?>
					TOTAL: <?= number_format($total, 2, ",", ".") ?> €
				</div>
			</div>

		</div>
		<!-- !BILL -->

		<!-- BUDGET -->
		<div class='customer_list' style='margin-top: 30px'>

			<?= $this->load->view("publi/addwordsH") ?>
		
			<div class='bar'>
				<div class='text'><?= _("PRESUPUESTOS") ?></div>
			</div>

			<?= $this->load->view("bills/p_list.php", array('bills' => $ppto)) ?>

			<div class='bar barbottom'>
				<div class='option add' onClick='window.location="<?= site_url("bills/add/0/type_id/2") ?>"'><?= _("Nuevo Presupuesto") ?></div>
				<div class='totals'>
					<?php $total = 0 ?>
					<?php foreach($ppto as $bill): ?>
						<?php $total += $bill['total'] ?>
					<?php endforeach ?>
					TOTAL: <?= number_format($total, 2, ",", ".") ?> €
				</div>
			</div>

		</div>
		<!-- !BUDGET -->

		<!-- PROFORMA -->
		<div class='customer_list' style='margin-top: 30px'>

			<?= $this->load->view("publi/addwordsH") ?>
		
			<div class='bar'>
				<div class='text'><?= _("FACTURAS PRO-FORMA") ?></div>
			</div>

			<?= $this->load->view("bills/p_list.php", array('bills' => $proforma)) ?>

			<div class='bar barbottom'>
				<div class='option add' onClick='window.location="<?= site_url("bills/add/0/type_id/3") ?>"'><?= _("Nueva Factura Pro-Forma") ?></div>
				<div class='totals'>
					<?php $total = 0 ?>
					<?php foreach($proforma as $bill): ?>
						<?php $total += $bill['total'] ?>
					<?php endforeach ?>
					TOTAL: <?= number_format($total, 2, ",", ".") ?> €
				</div>
			</div>

		</div>
		<!-- !PROFORMA -->		
		

		<!-- ALBARAN -->
		<div class='customer_list' style='margin-top: 30px'>

			<?= $this->load->view("publi/addwordsH") ?>
		
			<div class='bar'>
				<div class='text'><?= _("ALBARANES") ?></div>
			</div>

			<?= $this->load->view("bills/p_list.php", array('bills' => $albaran)) ?>

			<div class='bar barbottom'>
				<div class='option add' onClick='window.location="<?= site_url("bills/add/0/type_id/4") ?>"'><?= _("Nuevo Albarán") ?></div>
				<div class='totals'>
					<?php $total = 0 ?>
					<?php foreach($albaran as $bill): ?>
						<?php $total += $bill['total'] ?>
					<?php endforeach ?>
					TOTAL: <?= number_format($total, 2, ",", ".") ?> €
				</div>
			</div>

		</div>
		<!-- !ALBARAN -->

	</div>
	
	<div class='floatfix'></div>	
	
</div>