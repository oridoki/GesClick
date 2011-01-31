<?php $sw=0 ?>
<div class='config'>
	<div class='cuadrets'>
		<div class='cuadre tax_square'>
			<div class='cuadreTitle'>Tipos de IVA</div>
			<div class='tax_list'>
				<table class='llistat' id='tax_list'>
					<tbody>
						<?php foreach($taxes as $tax): ?>
							<tr id='tax_tr_<?= $tax['id'] ?>' <?php if($sw == 1): ?>class='grey'<?php $sw=0; else: $sw=1; endif ?>>
								<td id='tax_<?= $tax['id'] ?>_name'><?= $tax['name'] ?></td>
								<td id='tax_<?= $tax['id'] ?>_value'><?= $tax['value'] ?></td>
								<td class='options'>
									<div class='linked' onClick='deleteTax(<?= $tax['id'] ?>)'><img src='<?= base_url() ?>system/includes/img/icons/delete.jpg' title='<?= _("Borrar Empresa") ?>' alt='<?= _("Borrar Empresa") ?>' width=15 /></div>
									<div class='linked' onClick='editTax(<?= $tax['id'] ?>)'><img src='<?= base_url() ?>system/includes/img/icons/edit.jpg' title='<?= _("Editar Empresa") ?>' alt='<?= _("Editar Empresa") ?>' width=15 /></div>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<div class='tax_add' onClick='editTax(0)'>
				<div><img src='<?= base_url() ?>system/includes/img/icons/add.jpg' title='<?= _("Nuevo Impuesto") ?>' alt='<?= _("Nuevo Impuesto") ?>' width=15 /></div>
				<div class='txt linked'>Añadir nuevo impuesto</div>
			</div>
		</div>
		<div class='cuadreEsquerra news'>
			<div class='cuadreTitle'>Noticias GesClick</div>
	
		</div>
		<div class='cuadre'>
			<div class='cuadreTitle'>Mis Empresas</div>
			<div class='company_list'>
				<table>
					<tbody>
						<?php foreach($companies as $company): ?>
							<tr <?php if($sw == 1): ?>class='grey'<?php endif ?>>
								<?php $sw = (($sw * (-1)) + 1); ?>
								<td width=45>
									<?php if($company['company_logo'] != ''): ?>
									<div class='iimg47'>
										<img src='<?= $company['company_logo'] ?>' height=28 />
									</div>
									<?php endif ?>
								</td>
								<td>
									<?= $company['name'] ?>
								</td>
								<td class='options'>
									<a href='<?= site_url("company/view/".$company['id']) ?>'><img src='<?= base_url() ?>system/includes/img/icons/view.jpg' title='<?= _("Ver Empresa") ?>' alt='<?= _("Ver Empresa") ?>' width=25 /></a>
									<a href='<?= site_url("company/add/".$company['id']) ?>'><img src='<?= base_url() ?>system/includes/img/icons/edit.jpg' title='<?= _("Editar Empresa") ?>' alt='<?= _("Editar Empresa") ?>' width=25 /></a>
									<a href='<?= site_url("company/delete/".$company['id']) ?>'><img src='<?= base_url() ?>system/includes/img/icons/delete.jpg' title='<?= _("Borrar Empresa") ?>' alt='<?= _("Borrar Empresa") ?>' width=25 /></a>
								</td>

							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<div class='company_add'>
				<a href='<?= site_url("company/add/") ?>'>
					<div><img src='<?= base_url() ?>system/includes/img/icons/add.jpg' title='<?= _("Nueva Empresa") ?>' alt='<?= _("Nueva Empresa") ?>' width=25 /></div>
					<div class='txt'>Añadir nueva empresa</div>
				</a>
			</div>
		</div>
	</div>
</div>


<div id="dialog-confirm" title="<?= _("Eliminar Impuesto") ?>" style='display:none;'>
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?= _("Ten en cuenta que si eliminas este impuesto todas las facturas que estaban relacionadas con él continuarán teniendo el valor asignado hasta que las modifiques") ?></p>
</div>

<div id="dialog-form" title="<?= _("Nuevo Impuesto") ?>" style='display:none'>
	<p class="validateTips"><?= _("Todos los campos son obligatorios.") ?></p>

	<form>
	<fieldset>
		<dl>
			<dt><label for="tax_name"><?= _("Nombre") ?></label></dt>
			<dd><input type="text" name="tax_name" id="tax_name" class="single" /></dd>
		</dl>
		<dl>
			<dt><label for="tax_val"><?= _("Valor") ?></label></dt>
			<dd><input type="text" name="tax_val" id="tax_val" class="single" /></dd>
		</dl>
	</fieldset>
	</form>
</div>


<script language='javascript'>

	function editTax(s_id) {

		if(s_id == 0) { //................ ADDING
			$("#dialog-form").attr('title', '<?= _("Nuevo Impuesto") ?>');
		} else { //....................... EDITING
			$("#dialog-form").attr('title', '<?= _("Editar Impuesto") ?>');
		}
			
		$("#dialog-form").dialog("destroy");
		
		// Cargamos los datos
		$('#tax_name').val($('#tax_'+s_id+'_name').html());
		$('#tax_val').val($('#tax_'+s_id+'_value').html());

		$("#dialog-form").dialog({
			autoOpen: true,
			height: 330,
			width: 500,
			modal: true,
			buttons: {
				'Guardar': function() {
					if(s_id == 0) { //................ ADDING

						$.ajax({
							url			: "<?= site_url('tax/edit/0') ?>",
							data		: "name="+$("#tax_name").val()+"&value="+$("#tax_val").val(),
							type		: "POST",
							cache		: false,
							success		: function(html){
								$("#tax_list").append(html);
								$("#dialog-form").dialog('close');
							}
						});

					} else { //....................... EDITING

						$.ajax({
							url			: "<?= site_url('tax/edit/') ?>/"+s_id,
							data		: "name="+$("#tax_name").val()+"&value="+$("#tax_val").val(),
							type		: "POST",
							cache		: false,
							success		: function(html){
								$('#tax_'+s_id+'_name').html($('#tax_name').val());
								$('#tax_'+s_id+'_value').html($('#tax_val').val());
								
								$("#dialog-form").dialog('close');
								$("#tax_tr_"+s_id).effect("highlight");
							}
						});
						
					}
				},
				'Cancelar': function() {
					$(this).dialog('close');
				}
			},
			close: function() {
				$("#dialog-form .single").val('').removeClass('ui-state-error');
			}
		});
		
	}

	function deleteTax(s_id) {

		$("#dialog-confirm").dialog("destroy");

		$("#dialog-confirm").dialog({
			resizable: false,
			autoOpen: true,
			height:200,
			modal: true,
			buttons: {
				'Eliminar datos': function() {
					//We r to delete t serie
					$.ajax({
						url			: "<?= site_url('tax/delete/') ?>/"+s_id,
						data		: "",
						type		: "POST",
						cache		: false,
						success		: function(html){
							$("#tax_tr_"+s_id).remove();
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



