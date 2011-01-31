<table id='payments_list' class='list2click' >
	<tbody>
		<?php foreach($payments as $payment): ?>
			<?= $this->load->view('payment/p_line', array('payment' => $payment)) ?>
		<?php endforeach ?>
	</tbody>
</table>

<div id="deletePayment-confirm" title="<?= _("Eliminar Cobro") ?>" style='display:none;'>
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?= _("Estás seguro que quieres eliminar este cobro") ?></p>
</div>


<div id="editPayment-form" title="<?= _("Realizar Cobro") ?>" style='display:none'>
	<p class="validateTips"><?= _("Los campos marcados con (*) son obligatorios.") ?></p>

	<form>
		<fieldset>
			<dl>
				<table width=100%>
					<tr>
						<td width=48%>
							<dt><label for="payment_alias"><?= _("Alias") ?> (*)</label></dt>
							<dd><input type="text" name="payment_alias" id="payment_alias" class="single :required" style='width:100%' /></dd>
						</td>
						<td width=4%>&nbsp;</td>
						<td width=48%>
							<dt><label for="payment_state"><?= _("Estado") ?></label></dt>
							<dd>
								<select name='payment_state' id='payment_state' >
									<option value='0'><?= _("Programado") ?></option>
									<option value='1'><?= _("Vencido") ?></option>
									<option value='2'><?= _("Pagado") ?></option>
									<option value='3'><?= _("Descartado") ?></option>
								</select>
							</dd>
						</td>
					</tr>
				</table>
			</dl>
			<dl>
				<table width=100%>
					<tr>
						<td width=48%>
							<dt><label for="payment_date"><?= _("Fecha del Cobro") ?> (*)</label></dt>
							<dd><input type="text" name="payment_date" id="payment_date" class="single :required" style='width:100%' /></dd>
						</td>
						<td width=4%>&nbsp;</td>
						<td width=48%>
							<dt><label for="payment_amount"><?= _("Cantidad") ?> (*)</label></dt>
							<dd><input type="text" name="payment_amount" id="payment_amount" class="single :required :float" style='width:100%' /></dd>
						</td>
					</tr>
				</table>
						
			</dl>
			<dl>
				<dt><label for="payment_note"><?= _("Notes") ?></label></dt>
				<dd>
					<?=form_textarea(array(
						'name' 		=> 'payment_note',
						'id'		=> 'payment_note',
						'class' 	=> 'mceEditor single',
						'rows' 		=> '7',
						'cols' 		=> '61',
						'value'		=> ''
					)) ?>

				</dd>
			</dl>
		</fieldset>
	</form>
</div>

<script language='javascript'>

	$(document).ready(function(){

		var i18n = {   
			dateFormat: 'dd / mm / yy',
			maxDate: '+1Y',
			changeMonth: true,
			changeYear: true,
			numberOfMonths: 2,
			dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
			   'Junio', 'Julio', 'Agosto', 'Septiembre',
			   'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr',
			   'May', 'Jun', 'Jul', 'Ago',
			   'Sep', 'Oct', 'Nov', 'Dic'] 
		 };
		
		$("#payment_date").datepicker(i18n);
		
	});


	function editPayment(pay_id) {

		if(pay_id == 0) { //................ ADDING

			$("#editPayment-form").attr('title', '<?= _("Nuevo Cobro") ?>');

			// Cargamos los datos
			$('#payment_date').val("");
			$('#payment_amount').val("");
			$('#payment_alias').val("");
			$('#payment_note').val("");

		} else { //....................... EDITING

			$("#editPayment-form").attr('title', '<?= _("Editar Cobro") ?>');

			// Cargamos los datos
			$('#payment_date').val($('#payment_tr_'+pay_id+' .payment_date').html());
			$('#payment_amount').val($('#payment_tr_'+pay_id+' .payment_amount').html().replace(/\./g, '').replace(",", "."));
			$('#payment_alias').val($('#payment_tr_'+pay_id+' .payment_alias').html());
			$('#payment_note').val($('#payment_tr_'+pay_id+' .payment_notes').val());
			$('#payment_state').val($('#payment_tr_'+pay_id+' input.payment_state').val());

		}
			
		$("#editPayment-form").dialog("destroy");

		$("#editPayment-form").dialog({
			autoOpen: true,
			height: 470,
			width: 500,
			modal: true,
			buttons: {
				'Guardar': function() {
					// Validating
					Vanadium.validateAndDecorate();

					if(!$(".vanadium-invalid").length) {
						
						if(pay_id == 0) { //................ ADDING
							<?php if(isset($bill_id)): ?>
							$.ajax({
								url			: "<?= site_url('payment/update/0') ?>",
								data		: 'bill_id=<?= (isset($bill_id)) ? $bill_id : ''; ?>&alias='+$('#payment_alias').val()+'&notes='+$('#payment_note').val()+'&amount='+$('#payment_amount').val()+'&date='+$('#payment_date').val()+'&state='+$("#payment_state").val(),
								type		: "POST",
								cache		: false,
								success		: function(html) {
									$("#payments_list").append(html);
									$("#editPayment-form").dialog('close');
									getDue();
								}
							});
							<?php endif ?>
						} else { //....................... EDITING

							$.ajax({
								url			: "<?= site_url('payment/update/') ?>/"+pay_id,
								data		: 'bill_id=<?= (isset($bill_id)) ? $bill_id : "'+$('#payment_tr_'+pay_id+' .payment_bill_id').val()+'"; ?>&alias='+$('#payment_alias').val()+'&notes='+$('#payment_note').val()+'&amount='+$('#payment_amount').val()+'&date='+$('#payment_date').val()+'&state='+$("#payment_state").val(),
								type		: "POST",
								cache		: false,
								success		: function(html) {
									$('#payment_tr_'+pay_id+' .payment_alias').html($('#payment_alias').val());
									$('#payment_tr_'+pay_id+' .payment_notes').val($('#payment_note').val());
									$('#payment_tr_'+pay_id+' input.payment_state').val($('#payment_state').val());
									$('#payment_tr_'+pay_id+' td.payment_state').removeClass('state0').removeClass('state1').removeClass('state2').removeClass('state3');
									$('#payment_tr_'+pay_id+' td.payment_state').addClass('state'+$('#payment_state').val());
									$('#payment_tr_'+pay_id+' td.payment_state').html($('#payment_state :selected').text());
									$('#payment_tr_'+pay_id+' .payment_amount').html($('#payment_amount').val().replace(".", ","));

									$('#payment_tr_'+pay_id+' .payment_date').html($('#payment_date').val());

									$("#editPayment-form").dialog('close');
									$("#contact_tr_"+pay_id).effect("highlight");
									getDue();
								}
							});
						
						}

					}

				},
				'Cancelar': function() {
					$(this).dialog('close');
				},
				'Eliminar Cobro': function() {
					if(pay_id) {
						deletePayment(pay_id);
						$(this).dialog('close');
					}
				}<?php if($this->router->method == 'resume'): ?>,
				'Ver Factura': function() {
					var url = '<?= site_url("bills/view/") ?>' + '/' + $('#payment_tr_'+pay_id+' .payment_bill_id').val();
					window.location = url;
				}<?php endif ?>

			},
			close: function() {
//				$("#payment_note").wysiwyg('destroy');
				$("#editPayment-form .single").val('').removeClass('ui-state-error');
			}
		});

		if(!pay_id) {
			var b = $(".ui-dialog-buttonpane:visible .ui-state-default");
			$(b[2]).hide();
		}

	}

	
	function getDue() {
		
		if($(".percentDue").length > 0) {
			var s = $("input.payment_state");
			var p = $(".payment_amount");
			var payed = 0;
			for(var i=0;i<p.length; i++) {
				if($(s[i]).val() == 2) {
					payed += parseFloat($(p[i]).html().replace(/\./g, '').replace(",", "."));
				}
			}
			var total = parseFloat($("#total strong").html().replace(/\./g, '').replace(",", "."));
			$("#payed").html(((payed*100)/total).toFixed(2) + "%");
			$(".innPercentage").css({"width" : (((payed*100)/total) + "%")});
			$("#pendiente").html(parseFloat(total - payed).toFixed(2));
		}
		
	}


	function deletePayment(id) {

		$("#deletePayment-confirm").dialog("destroy");

		$("#deletePayment-confirm").dialog({
			resizable: false,
			autoOpen: true,
			height:200,
			modal: true,
			buttons: {
				'Eliminar datos': function() {
					//We r to delete t serie
					$.ajax({
						url			: "<?= site_url('payment/delete/') ?>/"+id,
						data		: "",
						type		: "POST",
						cache		: false,
						success		: function(html){
							$("#payment_tr_"+id).remove();
							getDue();
						}
					});

					$(this).dialog('close');
				},
				'Cancelar': function() {
					$(this).dialog('close');
				}
			}
		});		

	}

</script>