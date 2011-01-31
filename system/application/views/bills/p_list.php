<table id='bills_list' class='customers_list list2click'>
	<tbody>
		<?php foreach($bills as $bill): ?>

			<?= $this->load->view("bills/p_line.php", array('bill' => $bill)) ?>

		<?php endforeach ?>
	</tbody>
</table>

<script language='javascript'>

	function viewBill(id) {

		window.location = "<?= site_url("bills/view/") ?>/"+id;

	}

</script>		