<h2>Antes de empezar</h2>
<p>GesClick es un software muy sencillo, para empezar solo necesitas seguir estos dos pasos.</p>
<br />

<?php if($assist['companies']): ?>
<div class='step' onClick='window.location="<?= site_url('/company/add') ?>"'>
<?php else: ?>
<div class='step green'>
<?php endif ?>
	<h2>1.- Da de alta tu empresa</h2>
	<p>Para comenzar es necesario que crees una empresa. GesClick te permite crear y trabajar con varias empresas, pero para empezar vamos a crear solo una</p>
	<p>Pulsa encima de este recuadro para darla de alta</p>
</div>

<?php if($assist['customers']): ?>
<div class='step' onClick='window.location="<?= site_url('/customer/add') ?>"'>
<?php else: ?>
<div class='step green'>
<?php endif ?>
	<h2>2.- Crea tus clientes</h2>
	<p>Para poder empezar a crear facturas, antes necesitas como mínimo un cliente al que facturarle.</p>
	<p>Pulsa encima de este recuadro para crearlo</p>
</div>

