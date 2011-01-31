<div class='customer'>

	<?= $this->load->view("pieces/lateral", array('options' => array(
		array('href'=>'/customer/add/'.$customer['id'],'name' =>_('Editar Cliente')),
		array(
			'href'			=> '/customer/delete/'.$customer['id'],
			'name' 			=> _('Borrar Cliente'), 
			'confirm'	 	=> '<b>¿Estás seguro que quieres eliminar este cliente?</b><br /><br /> Se perderán todos sus datos.', 
			'action'		=> 'borrarCliente()'
		),
		array('href'=>'/customer/index/', 'name' =>_('Listado de Clientes')),
		array('href'=>'/bills/add/', 'name' =>_('Nueva Factura')),
		array('href'=>'/customer/add/'.$customer['id'],'name' =>_('Nuevo Presupuesto')),
		array(
			'href'			=> '/contact/add/0/'.$customer['id'],
			'name' 			=> _('Añadir Contacto'),
			'action' 		=> 'editContact(0)'
		)
	))) ?>
	
	<div class='central'>
		<div class='title rounded'>
			<?= $customer['first_name'] ?> <?= $customer['last_name'] ?>
		</div>
		<div class='description'>
			<p></p>
		</div>
		
		<fieldset class='personal_view'> 
			<legend><?= _("Información principal") ?></legend> 
			<div class='personal_data'>
				<dl>
					<dt><?= _('CIF / NIF') ?> :</dt>
					<dd><?= $customer['vat_number'] ?></dd>
				</dl>
				<dl>
					<dt><?= _('Persona de contacto') ?> :</dt>
					<dd><?= $customer['person'] ?></dd>
				</dl>
				<dl>
					<dt><?= _('Dirección') ?> :</dt>
					<dd><?= $customer['address'] ?></dd>
				</dl>
				<dl>
					<dt><?= _('Teléfono 1') ?> :</dt>
					<dd><?= $customer['phone1'] ?></dd>
				</dl>
				<dl>
					<dt><?= _('Teléfono 2') ?> :</dt>
					<dd><?= $customer['phone2'] ?></dd>
				</dl>
				<dl>
					<dt><?= _('Fax') ?> :</dt>
					<dd><?= $customer['fax'] ?></dd>
				</dl>
				<dl>
					<dt><?= _('E-Mail') ?> :</dt>
					<dd><?= mailto($customer['email']) ?></dd>
				</dl>
				<dl>
					<dt><?= _('Web') ?> :</dt>
					<dd><?= anchor($customer['web']) ?></dd>
				</dl>
			</div>

		</fieldset>
		
		<fieldset class='due_view'>
			<legend><?= _("Información Económica") ?></legend> 
			<div class='due_data'>
				<dl>
					<dt>Total Facturado: </dt>
					<dd class='right'><?= $total_facturat ?></dd>
				</dl>
				<dl>
					<dt>Deuda acumulada: </dt>
					<dd class='right'><?= number_format($total_1, 2, ",", ".") ?></dd>
				</dl>
				<dl>
					<dt><strong>Deuda vencida:</strong> </dt>
					<dd class='right'><strong><?= number_format($total_2, 2, ",", ".") ?></strong></dd>
				</dl>
				<dl>
					<dt>Deuda por vencer: </dt>
					<dd class='right'><?= number_format($total_3, 2, ",", ".") ?></dd>
				</dl>
			</div>
		</fieldset>
		
		<div class='billsList' style='margin-top: 50px'>
			<div class='customer_list'>
				<div class='bar'>
					<div class='text'>FACTURAS EMITIDAS</div>
				</div>
				<?= $this->load->view("bills/p_list.php", array('bills' => $bills)) ?>
				<div class='bar barbottom'>
					<div class='option add' onClick='window.location="<?= site_url("bills/add/0/customer_id/".$customer['id']) ?>"'><?= _("Nueva Factura") ?></div>
				</div>
			</div>
		</div>

		<div class='billsList' style='margin-top: 50px'>
			<div class='customer_list'>
				<div class='bar'>
					<div class='text'>CONTACTOS</div>
				</div>
				<?= $this->load->view("contact/p_list.php", array('contacts' => $contacts, 'customer_id' => $customer['id'])) ?>
				<div class='bar barbottom'>
					<div class='option add' onClick='editContact(0)'>Nuevo Contacto</div>
				</div>
			</div>
		</div>


		<div class='billsList' style='margin-top: 50px'>
			<div class='customer_list'>
				<div class='bar'>
					<div class='text'><?= _("PAGOS PENDIENTES") ?></div>
				</div>
				<?= $this->load->view("payment/p_list.php", array('payments' => $payments)) ?>
				<div class='bar barbottom'>
					<div class='option add' onClick='window.location="<?= site_url("payment/resume") ?>"'><?= _("Resumen de Pagos") ?></div>
				</div>
			</div>
		</div>
		
		<div class='floatfix'></div>
	</div>
</div>