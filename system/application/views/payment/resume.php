<div class='title rounded'>
	<?= _("Resumen de Cobros") ?>
</div>
<div class='description'>
	<p><?= _("Resumen de cobros pendientes") ?>.</p>
</div>


<div class='bills'>

	<?= $this->load->view("pieces/lateral", array('options' => array(
		array('href'=>'/bills/index/', 'name' =>_('Listado de facturas')),
		array('href'=>'/customer/index/', 'name' =>_('Listado Clientes')),
	))) ?>

	<div class='central'>
		
		<center><img src='http://chart.apis.google.com/chart?cht=p3&chs=650x200&chd=t:<?= implode(",", $percent['value']) ?>&chl=<?= implode("|", $percent['label']) ?>&chtt=Total%20deuda%20por%20cliente' /></center>
<br /><br />

		<div class='paymentList'>
			<div class='customer_list'>
				<div class='bar'>
					<div class='text'>COBROS PENDIENTES</div>
				</div>
				<?= $this->load->view("payment/p_list.php", array('payments' => $payments)) ?>
				<div class='bar barbottom'>
				</div>
			</div>
		</div>

		<div class='paymentResume'>
			<div class='totals total0'>
				<h1><?= number_format($totals['0'], 2, ",", ".") ?> &euro;</h1>
				<div><?= _("Deuda por Vencer") ?></div>
			</div>
			<div class='totals total1'>
				<h1><?= number_format($totals['1'], 2, ",", ".") ?> &euro;</h1>
				<div><?= _("Deuda Vencida") ?></div>
			</div>
			<div class='totals total2'>
				<h1><?= number_format($totals['global'], 2, ",", ".") ?> &euro;</h1>
				<div><?= _("Deuda Acumulada") ?></div>
			</div>
		</div>

<?php /*

<img src='http://chart.apis.google.com/chart?chxr=0,0,<?= $grafica['max'] ?>|1,1,<?= $grafica['numdays'] ?>&chxt=y,x&chbh=a&chs=600x300&cht=bvg&chco=A2C180&chds=0,<?= $grafica['max'] ?>&chd=t:<?= $grafica['value'] ?>&chtt=Vencimientos&chdl=Vencimientos' />

* * */?>		

	</div>

	
	<div class='floatfix'></div>

</div>