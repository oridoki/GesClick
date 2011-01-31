<table class='customers_list list2click' id='customers_list'>
	<tbody>
		<?php foreach($customers as $customer): ?>
			<?= $this->load->view('customer/p_line', array('customer' => $customer)) ?>
		<?php endforeach ?>
	</tbody>
</table>

<script language='javascript'>

	function viewCustomer(id) {
		
		window.location = "<?= site_url("customer/view/") ?>/"+id;
		
	}

</script>