<div class='title rounded'>
	<?= _("Listado de Clientes") ?>
</div>
<div class='description'>
	<p><?= _("Los campos marcados con asterisco (*) son necesarios.") ?></p>
</div>

<div class='customer'>

	<?= $this->load->view("pieces/lateral", array('options' => array(
		array('href' =>'/customer/add/','name' =>_('Nuevo Cliente')),
	))) ?>
	
	<div class='central'>
		<div class='customer_list'>
		
			<div class='bar'>
			</div>

			<?= $this->load->view("customer/p_list.php", array('customers' => $customers)) ?>

			<div class='bar barbottom'>
				<div class='pagination'>
					<?= $this->pagination->create_links() ?>
				</div>
			</div>

		</div>
	</div>
	
	<div class='floatfix'></div>	

</div>