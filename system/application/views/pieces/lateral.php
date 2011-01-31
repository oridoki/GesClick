<div class='lateral'>
	<div class='searchBox'>
		<div class='searchbox'><input id='searchbox' type='text' name='searchbox' class='single' value='<?php if($this->uri->segment(1, 0) == 'search'): echo $this->uri->segment(3, 0); endif; ?>' /></div>
		<div class='searchtype'>
			<select id='searchtype'>
				<option value='bills' <?php if($this->uri->segment(1, 0) == 'search' && $this->uri->segment(2, 0) == 'bills'): echo "selected"; endif; ?>>Facturas</option>
				<option value='customer' <?php if($this->uri->segment(1, 0) == 'search' && $this->uri->segment(2, 0) == 'customer'): echo "selected"; endif; ?>>Clientes</option>
			</select>
			<input type='button' value='Buscar' class='submit' onClick='search()' />
		</div>
	</div>
	<div class='optionsBox'>
		<ul>
			<?php foreach($options as $option): ?>
			<li>
				<?php if(isset($option['confirm'])): ?>
					<span class='linked' onClick='confirma("<?= $option['name'] ?>", "<?= $option['confirm'] ?>", "<?= $option['action'] ?>")'><?= $option['name'] ?></span>
				<?php else: ?>
					<?php if(isset($option['action'])): ?>
						<span class='linked' onClick='<?= $option['action'] ?>'><?= $option['name'] ?></span>
					<?php else: ?>
						<?= anchor($option['href'], $option['name'], ((isset($option['options'])) ? $option['options'] : '' )) ?>
					<?php endif ?>
				<?php endif ?>
				<img src='<?= base_url() ?>system/includes/img/arrowgrey.jpg' />
			</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>

<div id="lateral-confirm" title="<?= _("¿Estás seguro?") ?>" style='display:none;'>
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?= _("Estás seguro que quieres realizar esta acción") ?></p>
</div>


<script language='javascript'>
	
	function confirma(title, text, action) {

		$("#lateral-confirm").attr('title', title);
		$("#lateral-confirm p").html(text);
		$("#lateral-confirm").dialog("destroy");

		$("#lateral-confirm").dialog({
			resizable: false,
			autoOpen: true,
			height:200,
			modal: true,
			buttons: {
				'Aceptar': function() {
					setTimeout(action, 0);
					$(this).dialog('close');
				},
				'Cancelar': function() {
					$(this).dialog('close');
				}
			}
		});

	}
	
	
	function search() {
		
		if($("#searchbox").val().length >2) {

			window.location = "<?= base_url() ?>index.php/search/"+$("#searchtype").val()+"/"+$("#searchbox").val();
			
		}
		
	}
	
</script>