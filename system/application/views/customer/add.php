<div class='title rounded'>
	<?php if(isset($this->validation->contact_id)): ?>
		<?= _("Editar Cliente") ?>
	<?php else: ?>
		<?= _("Alta Cliente") ?>
	<?php endif ?>
</div>
<div class='description'>
	<?php if(isset($this->validation->contact_id)): ?>
	<p><?= _("Cumplimente el siguiente formulario para editar cliente existente.") ?></p>
	<?php else: ?>
		<p><?= _("Cumplimente el siguiente formulario para crear un nuevo cliente.") ?></p>
	<?php endif; ?>
	<p><?= _("Los campos marcados con asterisco (*) son necesarios.") ?></p>
</div>

<div class='customer'>
	<?= form_open("/customer/add/") ?>
	<?php if(isset($this->validation->contact_id)): ?>
	
	<?= form_hidden('id', $this->validation->contact_id) ?>
	<?php endif ?>
	
	<?php if(count($companies) > 1): ?>
	<fieldset class='personal'> 
		<legend>Pertenencia</legend> 
		<dl>
			<dt><label for="contact_company_id">(*) <?= _("Este contacto pertenece a:") ?></label></dt> 
			<dd>
				<select name='contact_company_id' id='contact_company_id'>
				<?php foreach($companies as $company): ?>
					<option value='<?= $company['id'] ?>' <?php if(isset($this->validation->contact_company_id)):if($company['id'] == $this->validation->contact_company_id): ?>selected<?php endif; endif;  ?>><?= $company['name'] ?></option>
				<?php endforeach; ?>
				</select>
			</dd>
		</dl>
	</fieldset>
	<?php else: ?>
		<?php if(count($companies) == 1): ?>
			<?= form_hidden('contact_company_id', $companies[0]['id']) ?>
		<?php else: ?>
			<?= _("Para poder empezar debes crear una empresa con la que trabajar....") ?><br />
			<h2><?= _("Hazlo desde") ?> <?= anchor("company/add", _("AQUÍ")) ?></h2>
			<?php die() ?>
		<?php endif ?>
	<?php endif ?>
	
	<fieldset class='personal'> 
		<legend>Información personal</legend> 
		<dl> 
			<dt><label for="contact_first_name">(*) <?= _("Nombre/Razón social") ?></label></dt> 
			<dd><?=form_input(array(
				'name' 		=> 'contact_first_name',
				'id'		=> 'contact_first_name',
				'size'		=> '30',
				'class'		=> 'single :required',
				'value'		=> (isset($this->validation->contact_first_name) ? $this->validation->contact_first_name : '')
			)) ?><?= $this->validation->contact_first_name_error ?>
			</dd>
		</dl> 
		<dl> 
			<dt><label for="contact_last_name"><?= _("Apellidos") ?></label></dt> 
			<dd><?=form_input(array(
				'name' 		=> 'contact_last_name',
				'id'		=> 'contact_last_name',
				'size'		=> '30',
				'class'		=> 'single',
				'value'		=> (isset($this->validation->contact_last_name) ? $this->validation->contact_last_name : '')
			)) ?></dd>
		</dl>
		<dl> 
			<dt><label for="contact_vat_number"><acronym title="<?= _("Código de Identificación Fiscal") ?>"><?= _("CIF") ?> (*)</acronym> / <acronym title="<?= _("Número de Identificación Fiscal") ?>"><?= _("NIF") ?></acronym></label></dt> 
			<dd><?=form_input(array(
				'name' 		=> 'contact_vat_number',
				'id'		=> 'contact_vat_number',
				'size'		=> '30',
				'class'		=> 'single :required',
				'value'		=> (isset($this->validation->contact_vat_number) ? $this->validation->contact_vat_number : '')
			)) ?></dd>
		</dl> 
	</fieldset> 

	<fieldset> 
		<legend><?= _("Datos de contacto") ?></legend> 
		<div class='dg_fra'>
			<dl> 
				<dt><label for="contact_person"><?= _("Persona de contacto") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_person',
					'id'		=> 'contact_person',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->contact_person) ? $this->validation->contact_person : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="contact_address">Dirección</label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_address',
					'id'		=> 'contact_address',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->contact_address) ? $this->validation->contact_address : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="contact_postal_code">Código postal</label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_postal_code',
					'id'		=> 'contact_postal_code',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->contact_postal_code) ? $this->validation->contact_postal_code : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="contact_city">Ciudad</label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_city',
					'id'		=> 'contact_city',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->contact_city) ? $this->validation->contact_city : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="contact_country_id">País</label></dt> 
				<dd>
					<select id="contact_country_id" name="contact_country_id">
						<?php foreach($countries as $country): ?>
							<option value='<?= $country['id'] ?>' <?php if($country['id']==28): ?>SELECTED<?php endif ?>><?= $country['nombre'] ?></option>
						<?php endforeach ?>
					</select>
				</dd>
			</dl> 
			<dl> 
				<dt><label for="contact_region_id"><?= _("Región") ?></label></dt> 
				<span id='regions_div'> 
					<dd><select id="contact_region_id" name="contact_region_id">
						<?php foreach($regions as $region): ?>
							<option value='<?= $region['id'] ?>' <?= 
							(isset($this->validation->contact_region_id) ? (($region['id'] == $this->validation->contact_region_id) ? 'selected' : '') :'') ?>><?= $region['nombre'] ?></option>
						<?php endforeach ?>
					</select></dd> 
				</span> 
			</dl> 
		</div>
		<div class='dg_cus'>
			<dl> 
				<dt><label for="contact_phone1"><?= _("Teléfono 1") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_phone1',
					'id'		=> 'contact_phone1',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->contact_phone1) ? $this->validation->contact_phone1 : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="contact_phone2"><?= _("Teléfono 2") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_phone2',
					'id'		=> 'contact_phone2',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->contact_phone2) ? $this->validation->contact_phone2 : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="contact_fax"><?= _("Fax") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_fax',
					'id'		=> 'contact_fax',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->contact_fax) ? $this->validation->contact_fax : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="contact_email"><?= _("Correo electrónico") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_email',
					'id'		=> 'contact_email',
					'size'		=> '30',
					'class'		=> 'single :email',
					'value'		=> (isset($this->validation->contact_email) ? $this->validation->contact_email : '')
					)) ?><?= $this->validation->contact_email_error ?>
				</dd>
				<dd class="info"><?= _("Para introducir más de una dirección de correo electrónico debe separarlas por coma (p.ej. usuario@dominio.uno, usuario@dominio.dos)") ?></dd> 
			</dl> 
			<dl> 
				<dt><label for="contact_web"><?= _("Web") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_web',
					'id'		=> 'contact_web',
					'size'		=> '30',
					'class'		=> 'single :url',
					'value'		=> (isset($this->validation->contact_web) ? $this->validation->contact_web : '')
				)) ?></dd>
			</dl> 
		</div>
	</fieldset> 

	<fieldset> 
		<legend><?= _("Datos de envío") ?></legend> 
		<dl class="checkbox"> 
			<?= form_checkbox(array(
				'name' => 'copy_contact_data',
                'id'=>'copy_contact_data',
				'onclick' => 'copyData(this.checked)'
			), "1", FALSE) ?>
			<label for="copy_contact_data"><?= _("Copiar los datos de contacto") ?></label> 
		</dl> 
		<div class='dg_fra'>
			<dl> 
				<dt><label for="contact_delivery_address"><?= _("Dirección") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_delivery_address',
					'id'		=> 'contact_delivery_address',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->contact_delivery_address) ? $this->validation->contact_delivery_address : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="contact_delivery_postal_code"><?= _("Código postal") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_delivery_postal_code',
					'id'		=> 'contact_delivery_postal_code',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->contact_delivery_postal_code) ? $this->validation->contact_delivery_postal_code : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="contact_delivery_city"><?= _("Ciudad") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_delivery_city',
					'id'		=> 'contact_delivery_city',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->contact_delivery_city) ? $this->validation->contact_delivery_city : '')
				)) ?></dd>
			</dl> 
			<dl> 
				<dt><label for="contact_delivery_country_id"><?= _("País") ?></label></dt> 
				<dd>
					<select id="contact_delivery_country_id" name="contact_delivery_country_id">
						<?php foreach($countries as $country): ?>
							<option value='<?= $country['id'] ?>' <?php if($country['id']==28): ?>SELECTED<?php endif ?>><?= $country['nombre'] ?></option>
						<?php endforeach ?>

					</select>
				</dd> 
			</dl> 
			<dl> 
				<dt><label for="contact_delivery_region_id"><?= _("Región") ?></label></dt> 
				<span id='delivery_regions_div'> 
					<dd>
						<select id="contact_delivery_region_id" name="contact_delivery_region_id">
							<?php foreach($regions as $region): ?>
								<option value='<?= $region['id'] ?>'><?= $region['nombre'] ?></option>
							<?php endforeach ?>

						</select>
					</dd> 
				</span> 
			</dl> 
		</div>
		<div class='dg_cus'>
			<dl> 
				<dt><label for="contact_delivery_phone1"><?= _("Teléfono 1") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_delivery_phone1',
					'id'		=> 'contact_delivery_phone1',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->contact_delivery_phone1) ? $this->validation->contact_delivery_phone1 : '')
				)) ?></dd>
			</dl> 

			<dl> 
				<dt><label for="contact_delivery_phone2"><?= _("Teléfono 2") ?></label></dt> 
				<dd><?=form_input(array(
					'name' 		=> 'contact_delivery_phone2',
					'id'		=> 'contact_delivery_phone2',
					'size'		=> '30',
					'class'		=> 'single',
					'value'		=> (isset($this->validation->contact_delivery_phone2) ? $this->validation->contact_delivery_phone2 : '')
				)) ?></dd>
			</dl> 
		</div>
	</fieldset> 

	<fieldset> 
		<legend><?= _("Otros datos") ?></legend> 
		<dl> 
			<dt><label for="contact_language_id"><?= _("Idioma") ?></label></dt> 
			<dd><select id="contact_language_id" name="contact_language_id">
				<?php foreach($countries as $country): ?>
					<option value='<?= $country['id'] ?>' <?php if($country['id']==28): ?>SELECTED<?php endif ?>><?= $country['nombre'] ?></option>
				<?php endforeach ?>
			</select></dd> 
		</dl> 
		<dl> 
			<dt><label for="contact_discount_rate"><?= _("Descuento (%)") ?></label></dt> 
			<dd><?=form_input(array(
				'name' 		=> 'contact_discount_rate',
				'id'		=> 'contact_discount_rate',
				'size'		=> '30',
				'class'		=> 'single',
				'value'		=> (isset($this->validation->contact_discount_rate) ? $this->validation->contact_discount_rate : '')
			)) ?></dd>
		</dl> 
		<dl> 
			<dt><label for="contact_bank_account_number"><?= _("Número de cuenta bancaria") ?></label></dt> 
			<dd><?=form_input(array(
				'name' 		=> 'contact_bank_account_number',
				'id'		=> 'contact_bank_account_number',
				'size'		=> '20',
				'class'		=> 'single',
				'value'		=> (isset($this->validation->contact_bank_account_number) ? $this->validation->contact_bank_account_number : '')
			)) ?></dd>
		</dl> 
		<dl> 
			<dt><label for="contact_notes"><?= _("Observaciones") ?></label></dt> 
			<?=form_textarea(array(
				'name' 		=> 'contact_notes',
				'id'		=> 'contact_notes',
				'class' 	=> 'mceEditor single',
				'cols' 		=> '70',
				'rows' 		=> '20',
				'value'		=> (isset($this->validation->contact_notes) ? $this->validation->contact_notes : '')
			)) ?>

		</dl> 
	</fieldset>

	<div class='botons'>
		<input type="button" class='cancel' value="Volver" onClick='history.back()' />
		<input type="submit" class='submit' value="Guardar" />
	</div>

	</form>
</div>


<script language='javascript'>

	$(function() {

		$("#contact_notes").wysiwyg();

	});
	
	function copyData(val) {

		if(val) {

			$("#contact_delivery_address").val($("#contact_address").val());
			$("#contact_delivery_postal_code").val($("#contact_postal_code").val());
			$("#contact_delivery_city").val($("#contact_city").val());
			$("#contact_delivery_country_id").val($("#contact_country_id").val());
			$("#contact_delivery_region_id").val($("#contact_region_id").val());
			$("#contact_delivery_phone1").val($("#contact_phone1").val());
			$("#contact_delivery_phone2").val($("#contact_phone2").val());		
			
		} else {

			$("#contact_delivery_address").val("");
			$("#contact_delivery_postal_code").val("");
			$("#contact_delivery_city").val("");
//			$("#contact_delivery_country_id").val("");
			$("#contact_delivery_region_id").val("");
			$("#contact_delivery_phone1").val("");
			$("#contact_delivery_phone2").val("");
			
		}
		
	}

</script>