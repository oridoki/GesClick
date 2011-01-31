<div class='title rounded'>
	<?= _("Nueva Empresa") ?>
</div>
<div class='description'>
	<p><?= _("Cumplimente el siguiente formulario para crear una nueva empresa.") ?></p>
	<p><?= _("Los campos marcados con asterisco (*) son necesarios.") ?></p>
</div>

<div class='company'>

	<?= form_open_multipart("/company/add/") ?>

	<?php if(isset($this->validation->id)): ?>
	
	<?= form_hidden('id', $this->validation->id) ?>
	<?php endif ?>
	<fieldset class='personal'> 
		<legend>Información personal</legend> 
		<div class='dg_fra'>
			<dl> 
				<dt><label for="name">(*) <?= _("Nombre/Razón social") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'name',
					'id'		=> 'name',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->name) ? $this->validation->name : '')
				)) ?><?= $this->validation->name_error ?>
				</dd>
			</dl> 
			<dl> 
				<dt><label for="vat_number"><acronym title="<?= _("Código de Identificación Fiscal") ?>"><?= _("CIF") ?></acronym> / <acronym title="<?= _("Número de Identificación Fiscal") ?>"><?= _("NIF") ?></acronym></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'vat_number',
					'id'		=> 'vat_number',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->vat_number) ? $this->validation->vat_number : '')
				)) ?></dd>
			</dl> 
		</div>
		<div class='dg_cus'>
			<dl> 
				<dt><label for="company_logo"><?= _("Logotipo") ?></label></dt> 
				<dd>
					<?php if(isset($this->validation->company_logo)): ?>
						<?php if($this->validation->company_logo != ''): ?>
						<img src='<?= $this->validation->company_logo ?>' />
						<?php endif ?>
					<?php endif ?>
					<input type="file" name="company_logo" id='company_logo' size="20" />
				</dd>
			</dl>
		</div>
	</fieldset> 

	<fieldset> 
		<legend><?= _("Datos de contacto") ?></legend> 
		<div class='dg_fra'>
			<dl> 
				<dt><label for="address">Dirección</label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'address',
					'id'		=> 'address',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->address) ? $this->validation->address : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="postal_code">Código postal</label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'postal_code',
					'id'		=> 'postal_code',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->postal_code) ? $this->validation->postal_code : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="city">Ciudad</label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'city',
					'id'		=> 'city',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->city) ? $this->validation->city : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="country_id">País</label></dt> 
				<dd>
					<select id="country_id" name="country_id">
						<?php foreach($countries as $country): ?>
							<option value='<?= $country['id'] ?>' <?php if($country['id']==28): ?>SELECTED<?php endif ?>><?= $country['nombre'] ?></option>
						<?php endforeach ?>
					</select>
				</dd>
			</dl> 
			<dl> 
				<dt><label for="region_id"><?= _("Región") ?></label></dt> 
				<span id='regions_div'> 
					<dd><select id="region_id" name="region_id">
						<?php foreach($regions as $region): ?>
							<option value='<?= $region['id'] ?>' <?= 
							(isset($this->validation->region_id) ? (($region['id'] == $this->validation->region_id) ? 'selected' : '') :'') ?>><?= $region['nombre'] ?></option>
							
						<?php endforeach ?>
					</select></dd> 
				</span> 
			</dl> 
		</div>
		<div class='dg_cus'>
			<dl> 
				<dt><label for="phone1"><?= _("Teléfono 1") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'phone1',
					'id'		=> 'phone1',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->phone1) ? $this->validation->phone1 : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="phone2"><?= _("Teléfono 2") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'phone2',
					'id'		=> 'phone2',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->phone2) ? $this->validation->phone2 : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="fax"><?= _("Fax") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'fax',
					'id'		=> 'fax',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->fax) ? $this->validation->fax : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="email"><?= _("Correo electrónico") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'email',
					'id'		=> 'email',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->email) ? $this->validation->email : '')
					)) ?><?= $this->validation->email_error ?>
				</dd>
				<dd class="info"><?= _("Para introducir más de una dirección de correo electrónico debe separarlas por coma (p.ej. usuario@dominio.uno, usuario@dominio.dos)") ?></dd> 
			</dl> 
			<dl> 
				<dt><label for="web"><?= _("Web") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'web',
					'id'		=> 'web',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->web) ? $this->validation->web : '')
				)) ?></dd>
			</dl> 
		</div>
	</fieldset> 

	<fieldset>
		<legend><?= _("Otros datos") ?></legend> 
		<table width=100%>
			<tr>
				<td>
					<dl> 
						<dt><label for="language_id"><?= _("Idioma") ?></label></dt> 
						<dd><select id="language_id" name="language_id">
							<?php foreach($countries as $country): ?>
								<option value='<?= $country['id'] ?>' <?php if($country['id']==28): ?>SELECTED<?php endif ?>><?= $country['nombre'] ?></option>
							<?php endforeach ?>
						</select></dd> 
					</dl> 
				</td>
				<td>
					<dl> 
						<dt><label for="color"><?= _("Color identificativo") ?></label></dt> 
						<dd>
							<div id="colorpicker"></div>
							<?=form_input(array(
							'name' 		=> 'color',
							'id'		=> 'color',
							'size'		=> '30',
							'class'		=> 'single',
							'value'		=> (isset($this->validation->color) ? $this->validation->color : '')
						)) ?></dd>
					</dl>
				</td>
			</tr>
		</table>
	</fieldset>
	
	<?php if(isset($series)): ?>
	<fieldset>
		<legend><?= _("Series de Facturas") ?></legend>
		<div onClick='editSerie(0)' class='linked'>Nueva Serie</div>
		<table class='llistat' id='series_list'>
			<tbody>
				<?php foreach($series as $serie): ?>
				<tr id='serie_tr_<?= $serie['id'] ?>'>
					<td id='serie_<?= $serie['id'] ?>_title'><?= $serie['prefix'] ?></td>
					<td id='serie_<?= $serie['id'] ?>_body'><?= $serie['description'] ?></td>
					<td class='options'>
						<span class='linked' onClick='editSerie(<?= $serie['id'] ?>)'><img src='<?= base_url() ?>system/includes/img/icons/edit.jpg' title='<?= _("Editar Serie") ?>' alt='<?= _("Editar Serie") ?>' width=25 /></span>
						<span class='linked' onClick='deleteSerie(<?= $serie['id'] ?>)'><img src='<?= base_url() ?>system/includes/img/icons/delete.jpg' title='<?= _("Borrar Serie") ?>' alt='<?= _("Borrar Serie") ?>' width=25 /></span>
					</td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		
	</fieldset>
	<?php endif ?>
	
	<div class='botons'>
		<input type="button" class='cancel' value="Volver" onClick='history.back()' />
		<input type="submit" class='submit' value="Guardar" />
	</div>

	</form>
</div>

<div id="dialog-confirm" title="<?= _("Eliminar Serie de Facturas") ?>" style='display:none;'>
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?= _("Con esta acción eliminarás la serie de facturas seleccionada<br /><br /> Sin embargo las facturas pertenecientes a esta serie continuarán existiendo en el sistema") ?></p>
</div>

<div id="dialog-form" title="<?= _("Nueva Serie") ?>" style='display:none'>
	<p class="validateTips"><?= _("Todos los campos son obligatorios.") ?></p>

	<form>
	<fieldset>
		<dl>
			<dt><label for="serie_title"><?= _("Identificador") ?></label></dt>
			<dd><input type="text" name="serie_title" id="serie_title" class="single" /></dd>
		</dl>
		<dl>
			<dt><label for="serie_body"><?= _("Descripción de la Serie") ?></label></dt>
			<dd><textarea name='serie_body' id='serie_body' class='single'></textarea></dd>
		</dl>
	</fieldset>
	</form>
</div>

<script type="text/javascript" src="<?= base_url() ?>system/includes/js/colorpicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/colorpicker.css" />

<script language='javascript'>

	function editSerie(s_id) {

		if(s_id == 0) { //................ ADDING
			$("#dialog-form").attr('title', '<?= _("Nueva Serie") ?>');
		} else { //....................... EDITING
			$("#dialog-form").attr('title', '<?= _("Editar Serie") ?>');
		}
			
		$("#dialog-form").dialog("destroy");
		
		// Cargamos los datos
		$('#serie_title').val($('#serie_'+s_id+'_title').html());
		$('#serie_body').val($('#serie_'+s_id+'_body').html());

		$("#dialog-form").dialog({
			autoOpen: true,
			height: 430,
			width: 500,
			modal: true,
			buttons: {
				'Guardar': function() {
					if(s_id == 0) { //................ ADDING

						$.ajax({
							url			: "<?= site_url('serie/edit/0') ?>",
							data		: "title="+$("#serie_title").val()+"&body="+$("#serie_body").val()+"&c_id=<?= $company_id ?>",
							type		: "POST",
							cache		: false,
							success		: function(html){
								$("#series_list").append(html);
								$("#dialog-form").dialog('close');
							}
						});

					} else { //....................... EDITING

						$.ajax({
							url			: "<?= site_url('serie/edit/') ?>/"+s_id,
							data		: "title="+$("#serie_title").val()+"&body="+$("#serie_body").val()+"&c_id=<?= $company_id ?>",
							type		: "POST",
							cache		: false,
							success		: function(html){
								$('#serie_'+s_id+'_title').html($('#serie_title').val());
								$('#serie_'+s_id+'_body').html($('#serie_body').val());
								$("#dialog-form").dialog('close');
								$("#serie_tr_"+s_id).effect("highlight");
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

	function deleteSerie(s_id) {

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
						url			: "<?= site_url('serie/delete/') ?>/"+s_id,
						data		: "c_id=<?= $company_id ?>",
						type		: "POST",
						cache		: false,
						success		: function(html){
							$("#serie_tr_"+s_id).remove();
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
	
	$(function() {

		$('#colorpicker').colorPicker({			
			click			: function(color){$('#color').val(color);},
			color			: ['#FFFFFF', '#EEEEEE', '#EEEEFF', '#EEFFEE', '#FFEEEE', '#FFEEFF', '#EEFFFF', '#FFFFEE'], 
			defaultColor	: "<?php echo (isset($this->validation->color) ? $this->validation->color : '#FFFFFF') ?>"
		});
		
	});

</script>