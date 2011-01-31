<link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/jquery.clockpick.css" />
<script type="text/javascript" src="<?= base_url() ?>system/includes/js/jquery.clockpick.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>system/includes/js/colorpicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/colorpicker.css" />


<table id='tasks_list' class='list2click' >
	<tbody>
		<?php foreach($tasks as $task): ?>
			<?= $this->load->view('task/p_line', array('task' => $task)) ?>
		<?php endforeach ?>
	</tbody>
</table>

<div id="deleteTask-confirm" title="<?= _("Eliminar Tarea") ?>" style='display:none;'>
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?= _("Estás seguro que quieres eliminar esta tarea") ?></p>
</div>


<div id="editTask-form" title="<?= _("Añadir Tarea") ?>" style='display:none'>
	<p class="validateTips"><?= _("Los campos marcados con (*) son obligatorios.") ?></p>

	<form>
		<fieldset>
			<dl>
				<table width=100%>
					<tr>
						<td width=48%>
							<dt><label for="task_title"><?= _("Titulo") ?> (*)</label></dt>
							<dd><input type="text" name="task_title" id="task_title" class="single :required" style='width:100%' /></dd>
						</td>
						<td width=4%>&nbsp;</td>
						<td width=48%>
							<dt><label for="company_id"><?= _("Empresa") ?></label></dt>
							<dd>
								<select name='company_id' id='company_id' >
									<?php foreach($companies as $company): ?>
									<option value='<?= $company['id'] ?>'><?= $company['name'] ?></option>
									<?php endforeach ?>
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
							<dt><label for="task_date"><?= _("Fecha de vencimiento") ?> (*)</label></dt>
							<dd><input type="text" name="task_date" id="task_date" class="single :required" style='width:100%' /></dd>
						</td>
						<td width=4%>&nbsp;</td>
						<td width=48%>
							<dt><label for="task_time"><?= _("Hora de vencimiento") ?> (*)</label></dt>
							<dd><input type="text" name="task_time" id="task_time" class="single :required" style='width:100%' /></dd>
						</td>
					</tr>
				</table>		
			</dl>
			<dl>
				<dt><label for="task_text"><?= _("Notas") ?></label></dt>
				<dd>
					<?=form_textarea(array(
						'name' 		=> 'task_text',
						'id'		=> 'task_text',
						'class' 	=> 'mceEditor single',
						'rows' 		=> '7',
						'cols' 		=> '61',
						'value'		=> ''
					)) ?>

				</dd>
			</dl>
			<dl>
				<dt><label for="task_color"><?= _("Color") ?></label></dt>
				<dd>
					<div id="colorpicker" style='width:200px'></div>
					<?=form_input(array(
					'name' 		=> 'task_color',
					'id'		=> 'task_color',
					'class'		=> 'single',
					'value'		=> ''
				)) ?></dd>
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
		
		$("#task_date").datepicker(i18n);

		$("#task_time").clockpick({
			starthour: 0,
			endhour: 24,
			military: true,
			showminutes: true
		});	
	
	});



		function editTask(task_id) {

			if(task_id == 0) { //................ ADDING

				$("#editTask-form").attr('title', '<?= _("Nueva Tarea") ?>');

				// Cargamos los datos
				$('#task_date').val("");
				$('#task_time').val("");
				$('#task_title').val("");
				$('#task_text').val("");
				$('#task_color').val("#FFFFFF");
				$('#company_id').val("");

			} else { //....................... EDITING

				$("#editTask-form").attr('title', '<?= _("Editar Tarea") ?>');

				// Cargamos los datos
				$('#task_date').val($('#task_tr_'+task_id+' .task_date').html());
				$('#task_time').val($('#task_tr_'+task_id+' .task_time').html());
				$('#task_title').val($('#task_tr_'+task_id+' .task_title').html());
				$('#task_text').val($('#task_tr_'+task_id+' .task_text').val());
				$('#task_color').val($('#task_tr_'+task_id+' .color').val());
				$('#company_id').val($('#task_tr_'+task_id+' .company_id').val());

			}

			$('#colorpicker').colorPicker({
				click			: function(color){$('#task_color').val(color);},
				color			: ['#FFFFFF', '#444444', '#4444FF', '#44FF44', '#FF4444', '#FF44FF', '#44FFFF', '#FFFF44'], 
				defaultColor	: $('#task_color').val()
			});

			$("#editTask-form").dialog("destroy");

			$("#editTask-form").dialog({
				autoOpen: true,
				height: 535,
				width: 500,
				modal: true,
				buttons: {
					'Guardar': function() {
						// Validating
						Vanadium.validateAndDecorate();

						if(!$(".vanadium-invalid").length) {

							if(task_id == 0) { //................ ADDING
								$.ajax({
									url			: "<?= site_url('task/update/0') ?>",
									data		: 'task_id=0&company_id='+$('#company_id').val()+'&title='+$('#task_title').val()+'&date='+$('#task_date').val()+'&time='+$('#task_time').val()+'&text='+$('#task_text').val()+'&color='+$('#task_color').val(),
									type		: "POST",
									cache		: false,
									success		: function(html) {
										$("#tasks_list").append(html);
										$("#editTask-form").dialog('close');
									}
								});
							} else { //....................... EDITING

								$.ajax({
									url			: "<?= site_url('task/update/') ?>/"+task_id,
									data		: 'task_id='+task_id+'&company_id='+$('#company_id').val()+'&title='+$('#task_title').val()+'&date='+$('#task_date').val()+'&time='+$('#task_time').val()+'&text='+$('#task_text').val()+'&color='+$('#task_color').val(),
									type		: "POST",
									cache		: false,
									success		: function(html) {
										
										$('#task_tr_'+task_id+' .task_color').css({'background-color': $('#task_color').val()});

										$('#task_tr_'+task_id+' .task_date').html($('#task_date').val());
										$('#task_tr_'+task_id+' .task_time').html($('#task_time').val());
										$('#task_tr_'+task_id+' .task_title').html($('#task_title').val());
										$('#task_tr_'+task_id+' .task_text').val($('#task_text').val());
										$('#task_tr_'+task_id+' .color').val($('#task_color').val());
										$('#task_tr_'+task_id+' .company_id').val($('#company_id').val());
										$("#editTask-form").dialog('close');

									}
								});

							}

						}

					},
					'Cancelar': function() {
						$(this).dialog('close');
					},
					'Eliminar Tarea': function() {
						if(task_id) {
							deleteTask(task_id);
							$(this).dialog('close');
						}
					}

				},
				close: function() {
	//				$("#payment_note").wysiwyg('destroy');
					$("#editTask-form .single").val('').removeClass('ui-state-error');
				}
			});

			if(!task_id) {
				var b = $(".ui-dialog-buttonpane:visible .ui-state-default");
				$(b[2]).hide();
			}

		}



	
	function deleteTask(id) {

		$("#deleteTask-confirm").dialog("destroy");

		$("#deleteTask-confirm").dialog({
			resizable: false,
			autoOpen: true,
			height:200,
			modal: true,
			buttons: {
				'Eliminar datos': function() {
					//We r to delete t serie
					$.ajax({
						url			: "<?= site_url('task/delete/') ?>/"+id,
						data		: "",
						type		: "POST",
						cache		: false,
						success		: function(html){
							$("#task_tr_"+id).remove();
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