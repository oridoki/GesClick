<div class='title rounded'>
	<?= _("Detalles ").$bill['bill_name'] ?>
</div>
<div class='description'>
	<p>.</p>
</div>


<div class='bills'>

	<?= $this->load->view("pieces/lateral", array('options' => array(
		array('href'=>'/bills/add/'.$bill['id'],'name' =>_('Editar ').$bill['bill_name']),
		array(
			'href'			=> '/bills/delete/'.$bill['id'],
			'name' 			=> _('Borrar ').$bill['bill_name'], 
			'confirm'	 	=> '<b>¿Estás seguro que quieres eliminar esta '.$bill['bill_name'].'?</b><br /><br /> Se perderán todos sus datos.', 
			'action'		=> 'deleteBill()'
		),
		array('href'=>'/bills/prnt/'.$bill['id']."/html/",'name' =>_('Imprimir ').$bill['bill_name'],"options" => array(
			'target' => '_blank'
		)),
		array('href'=>'/bills/prnt/'.$bill['id']."/pdf/",'name' =>_('Guardar como PDF')),
		array(
			'href'			=> '',
			'name' 			=> _('Enviar por Email'),
			'action' 		=> '$("#dialog-form").dialog("open");'
		),
		array('href'=>'/bills/index/', 'name' =>_('Volver')),
		array('href'=>'/customer/view/'.$bill['customer_id'], 'name' =>_('Ver Cliente')),
	))) ?>	

	<div class='central'>
		<fieldset>
			<legend><?= $bill['bill_name']." ".$bill['number'] ?></legend>
			<div class='bills_view'>
		
				<div class='bills_superior'>
					<div class='billlogo'><img src='<?= $company['company_logo'] ?>' /></div>

					<div class='number'><?= strtoupper($bill['bill_name'])._(" nº ").$bill['serie'].$bill['number'] ?></div>
					<div class='date'><?= _("FECHA: ").$bill['date'] ?></div>

					<div class='biller'>
					    <p><strong><?= $company['name'] ?></strong></p><br />
					    <p><?= $company['vat_number'] ?></p>
					    <p><?= $company['address'] ?> </p>
					    <p><?= $company['postal_code']." ".$company['city'] ?> </p>
					    <p><?= $company['region']." - ".$company['country'] ?> </p>
					    <p><?= $company['phone1']." - ".$company['email'] ?> </p>
					</div>

					<div class='customerData'>
					    <p style='text-transform:uppercase'><?= $customer['first_name']." ".$customer['last_name'] ?></p>
					    <p><?= $customer['vat_number'] ?></p>
					    <p><?= $customer['address'] ?> </p>
					    <p><?= $customer['postal_code']." ".$customer['city'] ?> </p>
					    <p><?= $customer['region']." - ".$customer['country'] ?> </p>
					</div>
				</div>
		
				<div class='budgets'>
					<table class="estilo" border=0> 
						<thead> 
							<tr> 
								<th scope="col" id="description"><?= _("Descripción") ?></th> 
								<th scope="col" id="qty" width=30><acronym title="<?= _("Cantidad") ?>">Q.</acronym></th>			
								<th scope="col" id="amount" width=50><?= _("Precio") ?></th> 
								<?php if($descuento > 0): ?>
								<th scope="col" id="discount" width=30><acronym title="<?= _("Descuento") ?>"><?= _("Dto.") ?></acronym>(%)</th> 
								<?php endif ?>
								<th scope="col" id="item_total" width=60 class="right"><?= _("Subtotal") ?></th> 
							</tr> 
						</thead> 
						<tfoot> 
							<tr><td colspan=<?php if($descuento > 0): ?>5<?php else: ?>4<?php endif ?> class='separator'>&nbsp;</td></tr>
							<tr> 
								<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
								<td scope="row" class="right"><p><?= _("SUBTOTAL") ?></p></td> 
								<td scope="row" class="right"><p id="subtotal"><?= number_format($subtotal, 2, ",", ".") ?></p></td> 
							</tr> 
							<?php if($descuento > 0): ?>
							<tr> 
								<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
								<td scope="row" class="right"><p><?= _("DTO%") ?></p></td> 
								<td scope="row" class="right"><p id="total_discount"><?= number_format($descuento, 2, ",", ".") ?></p></td> 
							</tr> 
							<?php endif ?>
							<tr> 
								<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
								<td scope="row" class="right"><p><?= _("IMPUESTOS") ?></p></td> 
								<td scope="row" class="right"><p id="total_taxes"><?= number_format($impuesto1, 2, ",", ".") ?></p></td> 
							</tr> 
							<?php if($impuesto2 != 0): ?>
							<tr> 
								<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
								<td scope="row" class="right"><p><?= _("IMPUESTOS") ?></p></td> 
								<td scope="row" class="right"><p id="total_taxes"><?= number_format($impuesto2, 2, ",", ".") ?></p></td> 
							</tr> 
							<?php endif ?>
							<tr id="total_foot"> 
								<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
								<td scope="row" class="right btop arrowed"><strong><?= _("TOTAL") ?></strong></td> 
								<td scope="row" class="right btop"><p id="total"><strong><?= number_format($total, 2, ",", ".") ?></strong></p></td> 
							</tr> 
							<?php if($bill['advance'] >0): ?>
							<tr id="total_advance"> 
								<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
								<td scope="row" class="right btop arrowed"><strong><?= _("ANTICIPO") ?></strong></td> 
								<td scope="row" class="right btop"><p id="total"><strong><?= number_format($bill['advance'], 2, ",", ".") ?></strong></p></td> 
							</tr>
							<tr id="total_w_advance"> 
								<td colspan="<?php if($descuento > 0): ?>3<?php else: ?>2<?php endif ?>">&nbsp;</td> 
								<td scope="row" class="right btop arrowed"><strong><?= _("TOTAL SIN ANTICIPO") ?></strong></td> 
								<td scope="row" class="right btop"><p id="total"><strong><?= number_format($total - $bill['advance'], 2, ",", ".") ?></strong></p></td> 
							</tr>
							<?php endif ?>

						</tfoot> 
						<tbody id="items_list"> 
							<?php $grey = 'grey' ?>
							<?php for($i=0;$i<count($items);$i++): ?>
								<tr id="item_<?= $i ?>" index="0" class='<?= $grey ?>'> 
									<td> 
										<?= $items[$i]['description'] ?>
									</td> 
									<td> 
										<?= $items[$i]['quantity'] ?>
									</td> 
									<td class='right'> 
										<?= $items[$i]['price'] ?>
									</td> 
									<?php if($descuento > 0): ?>
									<td class='right'> 
										<?= $items[$i]['discount_rate']  ?> %
									</td> 
									<?php endif ?>
									<td class="right"><?= number_format(($items[$i]['quantity'] * $items[$i]['price']), 2, ",", ".") ?></td> 
								</tr>
							<?php endfor ?>
						</tbody> 
					</table>
				</div>

				<div class='bills_inferior'>
					<?php if($bill['due_date'] != ' 00 / 00 / 0000'): ?>
					<div class='date'><?= _("FECHA DE VENCIMIENTO ")."<BR />".$bill['due_date'] ?></div>
					<?php endif ?>
					<?php if(trim($bill['payment_method']) != ''): ?>
					<div class='payment'><?= _("FORMA DE PAGO ")."<BR />".$bill['payment_method'] ?></div>
					<?php endif ?>
					<?php if(trim($bill['notes']) != ''): ?>
					<div class='ovservacions'><?= _("OBSERVACIONES ")."<BR />".$bill['notes'] ?></div>
					<?php endif ?>
				</div>

			</div>
		</fieldset>
		
		<?php if($bill['type_id'] == 1): ?>
		<div class='paymentList' style='margin-top: 50px'>
			<div class='customer_list'>
				<div class='bar'>
					<div class='text'>PAGOS REALIZADOS</div>
				</div>
				<?= $this->load->view("payment/p_list.php", array('payments' => $payments, 'bill_id' => $bill['id'])) ?>
				<div class='percentDue percentage'>
					<div class='innPercentage' style='width:<?= (($payed*100)/$total) ?>%'></div>
					<div class='textpercentage'><strong><?= _("Pagado el ") ?><span id='payed'><?= number_format((($payed*100)/$total), 2)."%" ?></span></strong><?= " ("._("Pendiente: ") ?><span id='pendiente'><?= number_format(($total-$payed), 2) ?></span>€)</div>
				</div>
				<div class='bar barbottom'>
					<div class='option add' onClick='editPayment(0)'><?= _("Ingresar Cobro") ?></div>
					<div class='option add' onClick='window.location="<?= site_url("payment/resume") ?>"'><?= _("Resumen de Cobros") ?></div>
				</div>
			</div>
		</div>
		<?php endif ?>
		
		
		<div class='shippingList' style='margin-top: 50px'>
			<div class='customer_list'>
				<div class='bar'>
					<div class='text'><?= _("HISTORIAL DE ENVIOS") ?></div>
				</div>
				<?= $this->load->view("shipping/p_list.php", array('shipping' => $shipping, 'bill_id' => $bill['id'])) ?>
				</div>
				<div class='bar barbottom'>
					<div class='option add' onClick='$("#dialog-form").dialog("open");'><?= _("Enviar por E-Mail") ?></div>
				</div>
			</div>
		</div>
		
		
	</div>
	

	
	<div class='floatfix'></div>

</div>

<div id="dialog-confirm" title="<?= _("Eliminar factura") ?>" style='display:none'>
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?= _("Mediante esta acción se va a eliminar la factura y todos los datos relacionados con la misma. ¿Está seguro?") ?></p>
</div>

<div id="dialog-form" title="<?= _("Enviar por Email") ?>" style='display:none'>
	<p class="validateTips"><?= _("Todos los campos son obligatorios.") ?></p>

	<form>
	<fieldset>
		<dl>
			<dt><label for="email"><?= _("Email") ?></label></dt>
			<dd><input type="text" name="email" id="email" value="" class="single" /></dd>
		</dl>
		<dl>
			<dt><label for="message_subject"><?= _("Asunto") ?></label></dt>
			<dd><input type="text" name="message_subject" id="message_subject" class="single" /></dd>
		</dl>
		<dl>
			<dt><label for="message_body"><?= _("Cuerpo del mensaje") ?></label></dt>
			<dd><textarea name='message_body' id='message_body' class='single'></textarea></dd>
		</dl>
	</fieldset>
	</form>
</div>

<div id="dialog-sended" title="<?= _("Mensaje Enviado") ?>" style='display:none'>
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?= _("Se ha enviado la factura por email. ¿Quieres guardar este contacto para futuros envios?") ?></p>
</div>


<script type="text/javascript">
	$(function() {
		
		function updateTips(t) {
			tips
				.text(t)
				.addClass('ui-state-highlight');
			setTimeout(function() {
				tips.removeClass('ui-state-highlight', 1500);
			}, 500);
		}

		function checkLength(o,n,min,max) {

			if ( o.val().length > max || o.val().length < min ) {
				o.addClass('ui-state-error');
				updateTips("La logitud de " + n + " debe estar entre "+min+" y "+max+".");
				return false;
			} else {
				return true;
			}

		}

		function checkRegexp(o,regexp,n) {

			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass('ui-state-error');
				updateTips(n);
				return false;
			} else {
				return true;
			}

		}		
		
		
		$("#dialog").dialog("destroy");

		var email = $("#email"),
			message_subject = $("#message_subject"),
			message_body = $("#message_body"),
		 	tips = $(".validateTips");
		
		$("#dialog-form").dialog({
			autoOpen: false,
			height: 430,
			width: 500,
			modal: true,
			buttons: {
				'Enviar por email': function() {
					// Validem els camps
					var bValid = true;
					$(".single").removeClass('ui-state-error');

					bValid = bValid && checkLength(email,"Email",6,80);
					bValid = bValid && checkLength(message_subject,"Asunto",3,255);
					bValid = bValid && checkLength(message_body,"Cuerpo del mensaje",5,255);

					// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
					bValid = bValid && checkRegexp(email,/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,"eg. ui@jquery.com");

					if (bValid) {
						
						$.ajax({
							url			: "<?= site_url('bills/bymail/'.$bill['id']) ?>",
							data		: "email="+email.val()+"&subject="+message_subject.val()+"&body="+message_body.val()+"&bill_id=<?= $bill['id'] ?>",
							type		:	"POST",
							cache		: false,
							success		: function(html){
								if(html) {
									
									// Insertamos los datos en la lista
									$("#shipping_list").append(html);
									
									// Cerramos dialogo
									$("#dialog-form").dialog('close');

									// Abrimos dialogo enviado
									$("#dialog-sended").dialog({
										resizable: false,
										height:140,
										modal: true,
										buttons: {
											'Guardar Contacto': function() {

												alert("Falta guardar");
												
												$(this).dialog('close');
											},
											'Cancelar': function() {
												$(this).dialog('close');
											}
										}
									});		
									

								} else {

									updateTips(html);
									
								}
							}
						});
						
					} else {
						alert("KO");
					}		
					
				},
				'Cancelar': function() {
					$(this).dialog('close');
				}
			},
			close: function() {
				$(".single").val('').removeClass('ui-state-error');
			}
		});

	});

	function deleteBill() {

		window.location = "<?= site_url("bills/delete/".$bill['id']) ?>";

	}




</script>