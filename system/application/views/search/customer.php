<div class='title rounded'>
	<?= _("Búsqueda de Clientes") ?>
</div>
<div class='description'>
	<p><?= _("Listado de clientes que coinciden con su búsqueda.") ?></p>
</div>

<div class='customer'>

	<?= $this->load->view("pieces/lateral", array('options' => array(
		array('href' =>'/customer/add/','name' =>_('Nuevo Cliente')),
	))) ?>
	
	<div class='central'>
		<div class='customer_list'>
		
			<div class='bar'>
				<div class='text'><?= _("Resultados de la búsqueda <i>'".$this->uri->segment(3, 0)."'</i> en clientes") ?></div>
			</div>

			<?= $this->load->view("customer/p_list.php", array('customers' => $customers)) ?>

			<div class='bar barbottom'>
			</div>

		</div>
	</div>
	
	<div class='floatfix'></div>	

</div>