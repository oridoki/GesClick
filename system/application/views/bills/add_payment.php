<div class='title rounded'>
	<?= _("Añadir Plazos de Pago") ?>
</div>
<div class='description'>
	<p>Para hacer un seguimiento correcto de los pagos de esta factura debes introducir la previsión de cobro de la misma, de esta manera el sistema te avisará cuando venza un pago.</p>
	<br />
	<p>El total de la factura es de <strong><?= $bill['total'] ?> €</strong> debes introducir los pagos en el sistema de manera que sumen este total</p>
</div>


<div class='bills'>
	<div>

		<div class='paymentList'>
			<div class='customer_list'>
				<div class='bar'>
					<div class='text'>PAGOS REALIZADOS</div>
				</div>
				<?= $this->load->view("payment/p_list.php", array('payments' => $payments, 'bill_id' => $bill['id'])) ?>
				<div class='bar barbottom'>
					<div class='option add' onClick='editPayment(0)'><?= _("Ingresar Pago") ?></div>
				</div>
			</div>
		</div>
		
		<div class='botons'>
			<input type="button" class='submit' value="Finalizar" onClick='window.location="<?= site_url("/bills/view/".$bill['id']) ?>"' />
		</div>
		
	</div>
	

	
	<div class='floatfix'></div>

</div>