<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>GesClick - Herramienta de gestión online</title>

	<meta name='title' content='GesClick - Herramienta de gestión online' /> 
	<meta name='DC.Title' content='GesClick - Herramienta de gestión online' /> 
	<meta http-equiv='title' content='GesClick - Herramienta de gestión online' /> 

	<meta http-equiv='DC.Title' content='GesClick - Herramienta de gestión online' /> 
	<meta name='Keywords' content='Facturación, Contabilidad, Gestión de Pagos' /> 
	<meta name='DC.Keywords' content='Facturación, Contabilidad, Gestión de Pagos' /> 
	<meta http-equiv='Keywords' content='Facturación, Contabilidad, Gestión de Pagos' /> 
	<meta http-equiv='DC.Keywords' content='Facturación, Contabilidad, Gestión de Pagos' /> 
	<meta name='abstract' content='Facturación, Contabilidad, Gestión de Pagos' /> 

	<meta name='Description' content='Facturación, Contabilidad, Gestión de Pagos' /> 
	<meta name='DC.Description' content='Facturación, Contabilidad, Gestión de Pagos' /> 
	<meta http-equiv='Description' content='Facturación, Contabilidad, Gestión de Pagos' /> 
	<meta http-equiv='DC.Description' content='Facturación, Contabilidad, Gestión de Pagos' />  <meta name="Distribution" content="Global" /> 
	  <meta name="DC.Distribution" content="Global" /> 

	  <meta name="Language" content="es-ES" /> 
	  <meta http-equiv="content_Language" content="es-ES" /> 
	  <meta http-equiv="Pragma" content="cache" /> 
	  <meta name="revisit" content="7 days" /> 
	  <meta name="revisit-after" content="1 weeks" /> 


	

	<?php /*
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
	*/ ?>
	<script type="text/javascript" src="<?= base_url() ?>system/includes/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>system/includes/js/jquery-ui.min.js"></script>

	<script type="text/javascript" src="<?= base_url() ?>system/includes/js/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>system/includes/js/vanadium.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/jquery.wysiwyg.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/ui.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/base.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/admin.css" />
</head>
<body>
	<div id="contassistant">
		<div class='header rounded'>
			<div class='logo rounded'></div>
			<div class='navigation'>
				<ul>
					<li><?= anchor("auth/logout", _("Salir")) ?></li>
				</ul>
			</div>
		</div>
		
		<div class='content'>
			<?= $content ?>
		</div>
		
		<div class='footer rounded'>
			
		</div>
	</div>
</body>
</html>