<div class='title rounded'>
	<?php if(isset($this->validation->id)): ?>
		<?= _("Editar factura ").$this->validation->number ?>
	<?php else: ?>
		<?= _("Crear una factura") ?> <?= (isset($this->validation->customer) ? 'para '.$this->validation->customer : '') ?>
	<?php endif ?>
</div>
<div class='description'>
	<p>Cumplimente el siguiente formulario para crear una nueva factura. Los campos marcados con asterisco (*) son necesarios.</p>
</div>

<h1><?php echo $this->validation->error_string; ?></h1>



<div class='bills'>

	<?= $this->load->view("pieces/lateral", array('options' => array(
		array('href'=>'/bills/index/', 'name' =>_('Listado de facturas')),
	))) ?>
	
	<div class='central'>
		<?= form_open("bills/add") ?>


		<?php if(isset($this->validation->id)): ?>
			<?= form_hidden('id', $this->validation->id) ?>
		<?php endif ?>
	
			<fieldset>
				<legend><?= _("Tipo de documento") ?></legend>
				<dl>
					<dt><label for="type_id"><span>(*) <?= _("Tipo de documento") ?></span></label></dt>
					<dd>
						<select name='type_id' onChange='validationType(this.value)'>
							<option value='1' <?php if(isset($this->validation->type_id) && $this->validation->type_id == 1) : echo "selected" ; endif ?>><?= _("Factura") ?></option>
							<option value='2' <?php if(isset($this->validation->type_id) && $this->validation->type_id == 2) : echo "selected" ; endif ?>><?= _("Presupuesto") ?></option>
							<option value='3' <?php if(isset($this->validation->type_id) && $this->validation->type_id == 3) : echo "selected" ; endif ?>><?= _("Factura Pro-Forma") ?></option>
							<option value='4' <?php if(isset($this->validation->type_id) && $this->validation->type_id == 4) : echo "selected" ; endif ?>><?= _("Albarán") ?></option>
						</select>
					</dd>
				</dl>
			</fieldset>
	
			<fieldset>
				<legend><?= _("Datos Generales") ?></legend>
		
				<div class='dg_fra'>
					<?php if(count($companies)>1): ?>
						<dl>
							<dt><label for="number"><span>(*) <?= _("Empresa") ?></span></label></dt>
							<dd>
								<select name='company_id' onChange='getSeries(this.value)'>
									<?php foreach($companies as $company): ?>
									<option value='<?= $company['id'] ?>'><?= $company['name'] ?></option>
									<?php endforeach ?>
								</select>
							</dd>
						</dl>
					<?php else: ?>
						<input type='hidden' name='company_id' id='company_id' value='<?= $companies[0]['id'] ?>' />
					<?php endif; ?>

					<dl>
						<dt><label for="number"><span>(*) <?= _("Número") ?></span></label></dt>
						<dd>
							<?php if(count($series) > 0): ?>
							<select name='serie' id='serie' class='presupuesto albaran proforma'  <?php if(isset($this->validation->type_id) && $this->validation->type_id > 1): echo "style='display:none'"; endif; ?>>
								<!--<option value=''></option>-->
								<?php foreach($series as $serie): ?>
								<option value='<?= $serie['prefix'] ?>' <?php if(isset($this->validation->serie)): if($serie['prefix'] == $this->validation->serie): ?>selected<?php endif; endif; ?>><?= $serie['prefix'] ?> - (<?= $serie['number'] ?>)</option>
								<?php endforeach ?>
							</select>
							<?php else: ?>
							<input type='hidden' name='serie' id='serie' value='' />
							<?php endif ?>
					
							<?=form_input(array(
								'name' 		=> 'number',
								'id'		=> 'number',
								'maxlength'	=> '25',
								'class'		=> 'single :required',
								'value'		=> (isset($this->validation->number) ? $this->validation->number : '')
							)) ?><?= $this->validation->number_error ?>
						
						</dd>
						<dd>
							<?= _("En cada una de las series puedes ver el número de factura más alto") ?>
						</dd>
					</dl>
					<dl>
						<dt><label for="date"><span>(*) <?= _("Fecha") ?></span></label></dt>
						<dd><?=form_input(array(
							'name' 		=> 'date',
							'id'		=> 'date',
							'maxlength'	=> '25',
							'class'		=> 'single :required',
							'value'		=> ((isset($this->validation->date) && trim(trim($this->validation->date))!='') ? trim($this->validation->date) : date("d / m / Y"))
							)) ?><?= $this->validation->date_error ?>
						</dd>
					</dl>
				</div>
				<div class='dg_cus'>
					<dl>
						<dt><label for="customer"><span>(*) <?= _("Cliente") ?></span></label></dt>
						<dd>
							<select name='customer_id' id='customer_id' onChange='changeCC(this.value)'>
							<?php foreach($customers as $item): ?>
								<option value='<?= $item['id'] ?>' <?= (isset($this->validation->customer_id) ? (($this->validation->customer_id == $item['id']) ? 'selected' : '') : '') ?>><?= $item['first_name']." ".$item['last_name'] ?></option>
							<?php endforeach ?>
							</select>
<?php /* 
							<input type='hidden' name='customer_id' id='customer_id' value='<?= (isset($this->validation->customer_id) ? $this->validation->customer_id : '') ?>' />
						</dd>
<!--
						<dd><?=form_input(array(
							'name' 		=> 'customer',
							'id'		=> 'customer',
							'maxlength'	=> '25',
							'class'		=> 'single :required',
							'value'		=> (isset($this->validation->customer) ? $this->validation->customer : '')
							)) ?><?= $this->validation->customer_id_error ?>
						</dd>
-->
*/ ?>
						<dd><?= anchor('customer/add', 'Nuevo Cliente') ?></dd>
					</dl>
					<dl>
						<dt><label for="currency"><span><?= _("Moneda") ?></span></label></dt>
						<dt>
							<?= form_dropdown('currency_id', $currency, (isset($this->validation->currency_id) ? $this->validation->currency_id : ''), 'id="currency"') ?>
						</dt>
					</dl>
				</div>
			</fieldset>

			<fieldset>
				<legend><?= _("Facturas Recurrentes") ?></legend>
				<span>Una factura recurrente es una factura que genera periódicamente otras facturas de similares características.</span>
				<div class='dg_fra'>
					<dl>
						<dt><label for="periodicity"><span> <?= _("Periodicidad") ?></span></label></dt>
						<dd>
							<?php $periodicidad = array(
								'0' => 'No es factura periódica',
								//'1' => 'Diaria',
								//'2' => 'Semanal',
								//'3' => 'Quincenal',
								'4' => 'Mensual',
								//'5' => 'Bimensual',
								//'6' => 'Trimestral',
								//'7' => 'Semestral',
								'8' => 'Anual'
							) ?>
							<select name='periodicity'>
								<?php while (list($clau, $valor) = each($periodicidad)): ?>
									<option value='<?= $clau ?>' <?php if(isset($this->validation->periodicity) && $this->validation->periodicity == $clau) : echo "selected" ; endif ?>><?= $valor ?></option>
							    <?php endwhile ?>
							</select>
						</dd>
					</dl>					
				</div>
				<div class='dg_cus'>
					<dl>
						<dt><label for="recurrences"><span>(*) <?= _("Número de repeticiones") ?></span></label></dt>
						<dd>
							<?=form_input(array(
								'name' 		=> 'recurrences',
								'id'		=> 'recurrences',
								'maxlength'	=> '25',
								'class'		=> 'single',
								'value'		=> (isset($this->validation->recurrences) ? $this->validation->recurrences : '')
							)) ?>
						</dd>
					</dl>
				</div>
			</fieldset>



			<fieldset> 
				<legend><?= _("Conceptos") ?></legend> 
				<table class="estilo" border=0> 
					<thead> 
						<tr> 
							<th scope="col" id="del" width=20>&nbsp;</th> 
							<th scope="col" id="description"><?= _("Descripción") ?></th> 
							<th scope="col" id="qty" width=30><acronym title="<?= _("Cantidad") ?>">Q</acronym></th>			
							<th scope="col" id="amount" width=50><?= _("Precio") ?></th> 
							<th scope="col" id="discount" width=30><acronym title="<?= _("Descuento") ?>"><?= _("Dto.") ?></acronym>(%)</th> 
							<th scope="col" id="item_total" width=60 class="right"><?= _("Subtotal") ?></th> 
						</tr> 
					</thead> 
					<tfoot> 
						<tr> 
							<td colspan="6" scope="row"> 
								<p class="left">
									<span onclick='newConcept()' class='lnk add_link'>Añadir un nuevo concepto</spn>
								</p> 
							</td> 
						</tr> 
						<tr> 
							<td colspan="5" scope="row" class="right"><p><?= _("Subtotal") ?>:</p></td> 
							<td scope="row" class="right"><p id="subtotal"><strong>0,00</strong></p></td> 
						</tr> 
						<tr> 
							<td colspan="5" scope="row" class="right"><p><?= _("Descuento") ?>:</p></td> 
							<td scope="row" class="right"><p id="total_discount">0,00</p></td> 
						</tr> 
						<tr> 
							<td colspan="5" scope="row" class="right"><p><?= form_dropdown('tax1', $tax, $this->validation->tax1, 'class="button localidad" id="tax1" onchange="recalcula()"') ?>:</p></td> 
							<td scope="row" class="right"><p id="val_tax1">0,00</p></td> 
						</tr> 
						<tr> 
							<td colspan="5" scope="row" class="right"><p><?= form_dropdown('tax2', $tax, $this->validation->tax2, 'class="button localidad" id="tax2" onchange="recalcula()"') ?>:</p></td> 
							<td scope="row" class="right"><p id="val_tax2">0,00</p></td> 
						</tr> 

						<tr id="total_foot"> 
							<td colspan="5" scope="row" class="right"><p><?= _("Total") ?>:</p></td> 
							<td scope="row" class="right"><p id="total"><strong>0,00</strong></p></td> 
						</tr> 
						<!-- ADELANTOS -->
						<tr>
							<td colspan="5" scope="row" class="right"><p><?= _("Anticipos") ?>:</p></td> 
							<td scope="row" class="right">
								<?=form_input(array(
									'name' 		=> 'advance',
									'id'		=> 'advance',
									'maxlength'	=> '25',
									'class'		=> 'single right',
									'value'		=> (isset($this->validation->advance) ? $this->validation->advance : '')
								)) ?>
							</td> 
						</tr> 
						<tr id="total_advance"> 
							<td colspan="5" scope="row" class="right"><p><strong><?= _("Total sin Anticipo") ?>:</strong></p></td> 
							<td scope="row" class="right"><p id="total_ant"><strong>0,00</strong></p></td> 
						</tr> 
						<!-- !ADELANTOS -->
					</tfoot> 
					<tbody id="items_list"> 
						<?php for($i=0;$i<count($items);$i++): ?>
							<tr id="item_<?= $i ?>" index="0"> 
								<td> 
									<div class='delBudget' onClick='delBudget("item_<?= $i ?>")' ><img alt="Del" height="16" src="<?= base_url() ?>system/includes/img/icons/delete.jpg" width="16" /></div> 
								</td>
								<td> 
										<?=form_input(array(
											'name' 		=> 'items['.$i.'][description]',
											'id'		=> 'items_'.$i.'_description',
											'title'		=> _("Introduzca el concepto a facturar"),
											'class' 	=> 'single',
											'autocomplete'	=> 'off',
											'style' 	=> 'width:100%',
											'value' 	=> $items[$i]['description']
										)) ?>
								</td> 
								<td> 
										<?=form_input(array(
											'name' 		=> 'items['.$i.'][quantity]',
											'id'		=> 'items_'.$i.'_quantity',
											'title'		=> _("Introduzca el número de conceptos a facturar"),
											'class'		=> 'single',
											'value' 	=> '1',
											'size' 		=> '5',
											'onchange' 	=> 'recalcula()',
											'value' 	=> $items[$i]['quantity']
										)) ?>
								</td> 
								<td> 
										<?=form_input(array(
											'name' 		=> 'items['.$i.'][price]',
											'id'		=> 'items_'.$i.'_price',
											'title'		=> _("Introduzca el importe unitario por concepto"),
											'class'		=> 'single',
											'value' 	=> '',
											'size' 		=> '10',
											'onchange' 	=> 'recalcula()',
											'value' 	=> $items[$i]['price']
										)) ?>
								</td> 
								<td> 
										<?=form_input(array(
											'name' 		=> 'items['.$i.'][discount_rate]',
											'id'		=> 'items_'.$i.'_discount_rate',
											'title'		=> _("Introduzca el descuento para este concepto"),
											'class'		=> 'single',
											'value' 	=> '',
											'size' 		=> '5',
											'onchange' 	=> 'recalcula()',
											'value' 	=> $items[$i]['discount_rate']
										)) ?>
										<input id="total_<?= $i ?>" name="total_<?= $i ?>" type="hidden" /> 
										<input id="items[<?= $i ?>][id]" name="items[<?= $i ?>][id]" value='<?= $items[$i]['id'] ?>' type="hidden" />

								</td> 
								<td class="total_<?= $i ?> right">0,00</td> 
							</tr>
						<?php endfor ?>
					</tbody> 
				</table> 
			</fieldset> 

			<fieldset> 
				<legend><?= _("Datos adicionales") ?></legend> 

					<div class='dg_fra'>
						<dl> 
							<dt><label for="due_date"><?= _("Fecha de vencimiento") ?></label></dt> 
							<dd>
								<?=form_input(array(
									'name' 		=> 'due_date',
									'id'		=> 'due_date',
									'title'		=> _("Seleccione la fecha de vencimiento de la factura"),
									'class'		=> 'single',
									'size'	 	=> '30',
									'value'		=> (isset($this->validation->due_date) ? $this->validation->due_date : '')
								)) ?>
							</dd> 
						</dl> 

					</div> 
					<div class='dg_cus'>
						<dl> 
							<dt><label for="sale_late_fees_rate"><?= _("Intereses de demora") ?> (%)</label></dt> 
							<dd>
								<?=form_input(array(
									'name' 		=> 'late_fees_rate',
									'id'		=> 'late_fees_rate',
									'title'		=> _("Indique tasa de intereses de demora"),
									'class'		=> 'single',
									'size'	 	=> '30',
									'value'		=> (isset($this->validation->late_fees_rate) ? $this->validation->late_fees_rate : '')
									)) ?>
							</dd> 
							<dd><?= _("Se aplican mensualmente.") ?></dd> 
						</dl> 
					</div> 
					<div class="spacer" style='clear:both'></div> 

				<div style='padding: 0 25px'>
					<dl class='presupuesto'> 
						<dt><label for="payment_method"><?= _("Forma de pago") ?></label></dt> 
						<dd><?= _("Indique como desea que paguen esta factura, 'domiciliación', 'transferencia a la cuenta XYZ...'") ?></dd> 
						<dd>
							<?=form_input(array(
								'name' 		=> 'payment_method',
								'id'		=> 'payment_method',
								'title'		=> _("Especifique la forma de pago"),
								'class'		=> 'single',
								'size'	 	=> '90',
								'value'		=> (isset($this->validation->payment_method) ? $this->validation->payment_method : '')
							)) ?>
						</dd> 
						<dd id='cc' class='reddy'>
							La cuenta corriente de este cliente es: 
						</dd>
					</dl> 

				    <dl> 
				        <dt><label for="tags"><?= _("Etiquetas") ?></label></dt> 
				        <dd><?= _("Separe las etiquetas por comas, p.e. taller mecánico, coche. Las etiquetas le ayudarán a buscar y clasificar sus facturas.") ?></dd> 
						<dd><?=form_input(array(
								'name' 		=> 'tags',
								'id'		=> 'tags',
								'title'		=> _("Etiquete esta factura"),
								'class'		=> 'single',
								'size'	 	=> '90',
								"autocomplete" => "off",
								'value'		=> (isset($this->validation->tags) ? $this->validation->tags : '')
							)) ?>
					  	</dd> 
				      </dl> 
					<dl> 
						<dt><label for="notes"><?= _("Observaciones") ?></label></dt> 
						<dd>
							<?=form_textarea(array(
								'name' 		=> 'notes',
								'id'		=> 'notes',
								'class' 	=> 'mceEditor single',
								'rows' 		=> '10',
								'cols' 		=> '76',
								'value'		=> (isset($this->validation->notes) ? $this->validation->notes : '')
							)) ?>

						</dd> 
					</dl> 
				</div>
			</fieldset>
			<div class='botons'>
				<input type="button" class='cancel' value="Volver" onClick='history.back()' />
				<input type="submit" class='submit' value="Guardar" />
			</div>
		</form>
	</div>
</div>
<div class='floatfix'></div>

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?= base_url() ?>system/includes/js/jquery.autocomplete.min.js"></script>

<script language='javascript'>

	var cc = {
		<?php foreach($customers as $item): ?>
			"<?= $item['id'] ?>" : "<?= $item['bank_account_number'] ?>",
		<?php endforeach ?>
		
	};

	var customers = "Core<!--1--> Selectors<!--2--> Attributes<!--3--> Traversing<!--4--> Manipulation<!--5--> CSS<!--6--> Events<!--6--> Effects<!--7--> Ajax<!--8--> Utilities<!--9-->".split(" ");

	function changeCC(val) {

		$('#cc').html("La cuenta corriente de este cliente es: " + cc[val]);

	}


	function newConcept() {

		var cuants = $("#items_list tr").length;
		var items = $("#items_list tr");
		var html = "<tr id='item_"+cuants+"' index= class='even'>"+$(items[0]).html().replace(/_0_/g, "_"+cuants+"_").replace(/\[0\]/g, "["+cuants+"]").replace(/_0/g, "_"+cuants)+"</tr>";
		
		$("#items_list").append(html);
		
		$(".total_"+cuants).html("0");
		$("#total_"+cuants).val(0);

		$("#item_"+cuants+" input").val("0");
		$("#item_"+cuants+" select").val("0");
		$("#items_"+cuants+"_description").val("");

		recalcula();
	}
	
	function IsNumeric(input) {
	   return (input - 0) == input && input.length > 0;
	}
	
	function delBudget(id) {
		$("#"+id).remove();
		recalcula();
	}
	
	function recalcula() {
		var price = 0;
		var discount = 0;
		var taxes = 0;
		var items = $("#items_list tr");

		for(var i=0;i<items.length;i++) {
			
			var id = $(items[i]).attr("id").replace("item_", "");

			if(IsNumeric($('#items_'+id+'_quantity').val()) && IsNumeric($('#items_'+id+'_price').val())) {
				var parcial = $('#items_'+id+'_quantity').val() * $('#items_'+id+'_price').val();
				$('#total_'+id).val(parcial);
				$('.total_'+id).html(number_format(parcial, "2", ",", "."));
				price += parcial;
				if(IsNumeric($('#items_'+id+'_discount_rate').val())) {
					discount += parcial*($('#items_'+id+'_discount_rate').val()/100);
				}
			}

		}


		$("#subtotal strong").html(number_format(price, "2", ",", "."));
		if(discount > 0) {
			$("#total_discount").html("-"+number_format(discount, "2", ",", "."));
		}

		if($('#tax1').val() != '0') {
			taxes += price*($('#tax1').val()/100);
			$('#val_tax1').html(number_format(price*($('#tax1').val()/100), 2, ",", "."));
		}

		if($('#tax2').val() != '0') {
			taxes += price*($('#tax2').val()/100);
			$('#val_tax2').html(number_format(price*($('#tax2').val()/100), 2, ",", "."));
		}

		$("#total strong").html(number_format((price - discount + taxes), "2", ",", "."));

		if($("#advance").val()!=0) {
			$("#total_ant").html(
				number_format(
					((price - discount + taxes) - parseFloat($("#advance").val()))
				, "2", ",", ".")
			);
		}
		
	}


	function number_format(number, decimals, dec_point, thousands_sep) {
	    var n = !isFinite(+number) ? 0 : +number, 
	        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	        s = '',
	        toFixedFix = function (n, prec) {
	            var k = Math.pow(10, prec);
	            return '' + Math.round(n * k) / k;
	        };
	    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	    if (s[0].length > 3) {
	        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	    }
	    if ((s[1] || '').length < prec) {
	        s[1] = s[1] || '';
	        s[1] += new Array(prec - s[1].length + 1).join('0');
	    }
	    return s.join(dec);
	}

	function getSeries(val) {
		
		$.getJSON("<?= site_url('serie/jsonlist/') ?>/"+val, function(data) {
			var newOptions = '';
			for(var i=0;i<data.length;i++) {
				newOptions += '<option value="'+data[i]['prefix']+'">'+data[i]['prefix']+'- ('+data[i]['number']+')</option>';
			}
			$('#serie')
			    .find('option')
			    .remove()
			    .end()
			    .append(newOptions)
			    .val('whatever')
			;
			
		});		
		
	}

	function validationType(type) {
	
		switch(type) {
			case "1": 	// Factura
				$(".presupuesto").show();
				$(".albaran").show();
				$(".proforma").show();
			break;
			case "2": 	// Presupuesto
				$(".presupuesto").hide();
			break;
			case "3": 	// Pro-Forma
				$(".proforma").hide();
			break;
			case "4": 	// Albarán
				$(".albaran").hide();
			break;
		}
		
	}
	


	$(function() {
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
		
		$("#date").datepicker(i18n);
		$("#due_date").datepicker(i18n);
		
		$.datepicker.setDefaults($.datepicker.regional['es']);

		$("#notes").wysiwyg();

		$("#customer").keypress(function() {
			if($(this).val().length == 1) {			// AJAX QUERY
				$.ajax({ 
					url		: "<?= site_url('customer/ajaxlist/') ?>", 
					data 	: "str="+$("#customer").val(),
					type 	: 'POST',
					success	: function(data, textStatus, XMLHttpRequest){

						$("#customer").autocomplete(eval(data), {
						  formatItem: function(item) {
						    return item.text;
						  }
						}).result(function(event, item) {
							$("#customer_id").val(item.id);
						});



		      		},
					error 	: function(data, textStatus, XMLHttpRequest) {
						console.log("Vaya Mierda");
					}
				});
			}
		});
		
		recalcula();

		changeCC($("#customer_id").val());

	});

</script>