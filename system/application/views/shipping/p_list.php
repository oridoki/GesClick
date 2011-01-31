<table id='shipping_list' class='customers_list list2click'>
	<tbody>
		<?php foreach($shipping as $ship): ?>

			<?= $this->load->view("shipping/p_line.php", array('ship' => $ship)) ?>

		<?php endforeach ?>
	</tbody>
</table>

<script language='javascript'>

	function viewShipping(id) {

		alert("OK");

	}

</script>