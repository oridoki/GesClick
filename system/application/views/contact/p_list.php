<table class='contacts_list list2click' id='contacts_list'>
	<tbody>
		<?php foreach($contacts as $contact): ?>
			<?= $this->load->view('contact/p_line', array('contact' => $contact, 'customer_id' => $customer_id)) ?>
		<?php endforeach ?>
	</tbody>
</table>


<div id="deleteContact-confirm" title="<?= _("Eliminar Contacto") ?>" style='display:none;'>
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?= _("Estás seguro que quieres eliminar este contacto") ?></p>
</div>

<div id="editContact-form" title="<?= _("Nuevo Contact") ?>" style='display:none'>
	<p class="validateTips"><?= _("Los campos marcados con (*) son obligatorios.") ?></p>

	<form>
	<fieldset>
		<dl>
			<dt><label for="contact_name"><?= _("Nombre") ?></label></dt>
			<dd><input type="text" name="contact_name" id="contact_name" class="single" /></dd>
		</dl>
		<dl>
			<dt><label for="contact_surname"><?= _("Apellidos") ?></label></dt>
			<dd><input type="text" name="contact_surname" id="contact_surname" class="single" /></dd>
		</dl>
		<dl>
			<table width=100%>
				<tr>
					<td width=48%>
						<dt><label for="contact_phone"><?= _("Teléfono") ?></label></dt>
						<dd><input type="text" name="contact_phone1" id="contact_phone1" class="single" /></dd>
					</td>
					<td width=4%>&nbsp;</td>
					<td width=48%>
						<dt><label for="contact_phone2"><?= _("Móvil") ?></label></dt>
						<dd><input type="text" name="contact_phone2" id="contact_phone2" class="single" /></dd>
					</td>
				</tr>
			</table>
						
		</dl>
		<dl>
			<dt><label for="contact_email"><?= _("E-Mail") ?></label></dt>
			<dd><input type="text" name="contact_email" id="contact_email" class="single" /></dd>
		</dl>
	</fieldset>
	</form>
</div>


<script langyuage='javascript'>

	function borrarCliente(id) {

		$("#deleteContact-confirm").dialog("destroy");

		$("#deleteContact-confirm").dialog({
			resizable: false,
			autoOpen: true,
			height:200,
			modal: true,
			buttons: {
				'Eliminar datos': function() {
					//We r to delete t serie
					$.ajax({
						url			: "<?= site_url('contact/delete/') ?>/"+id,
						data		: "",
						type		: "POST",
						cache		: false,
						success		: function(html){
							$("#contact_tr_"+id).remove();
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

	function editContact(cto_id) {

		if(cto_id == 0) { //................ ADDING
			$("#editContact-form").attr('title', '<?= _("Nuevo Contacto") ?>');
		} else { //....................... EDITING
			$("#editContact-form").attr('title', '<?= _("Editar Contacto") ?>');
		}
			
		$("#editContact-form").dialog("destroy");
		
		// Cargamos los datos
		$('#contact_name').val($('#contact_td_name_'+cto_id).html());
		$('#contact_surname').val($('#contact_td_surname_'+cto_id).html());
		$('#contact_phone1').val($('#contact_td_phone1_'+cto_id).html());
		$('#contact_phone2').val($('#contact_td_phone2_'+cto_id).html());
		$('#contact_email').val($('#contact_td_email_'+cto_id+' a').html());

		$("#editContact-form").dialog({
			autoOpen: true,
			height: 410,
			width: 500,
			modal: true,
			buttons: {
				'Guardar': function() {
					if(cto_id == 0) { //................ ADDING

						$.ajax({
							url			: "<?= site_url('contact/edit/0') ?>",
							data		: 'customer_id=<?= $customer_id ?>&name='+$('#contact_name').val()+'&surname='+$('#contact_surname').val()+'&phone1='+$('#contact_phone1').val()+'&phone2='+$('#contact_phone2').val()+'&email='+$('#contact_email').val(),
							type		: "POST",
							cache		: false,
							success		: function(html) {
								$("#contacts_list").append(html);
								$("#editContact-form").dialog('close');
							}
						});

					} else { //....................... EDITING

						$.ajax({
							url			: "<?= site_url('contact/edit/') ?>/"+cto_id,
							data		: 'customer_id=<?= $customer_id ?>&name='+$('#contact_name').val()+'&surname='+$('#contact_surname').val()+'&phone1='+$('#contact_phone1').val()+'&phone2='+$('#contact_phone2').val()+'&email='+$('#contact_email').val(),
							type		: "POST",
							cache		: false,
							success		: function(html) {
								$('#contact_td_name_'+cto_id).html($('#contact_name').val());
								$('#contact_td_surname_'+cto_id).html($('#contact_surname').val());
								$('#contact_td_phone1_'+cto_id).html($('#contact_phone1').val());
								$('#contact_td_phone2_'+cto_id).html($('#contact_phone2').val());
								$('#contact_td_email_'+cto_id).html($('#contact_email').val());
								
								$("#editContact-form").dialog('close');
								$("#contact_tr_"+cto_id).effect("highlight");
							}
						});
						
					}
				},
				'Cancelar': function() {
					$(this).dialog('close');
				},
				'Borrar Contacto': function() {
					borrarCliente(cto_id);
					$(this).dialog('close');
				}

			},
			close: function() {
				$("#editContact-form .single").val('').removeClass('ui-state-error');
			}
		});
				
	}

</script>