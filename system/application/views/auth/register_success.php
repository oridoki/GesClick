<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta content="text/html;" http-equiv="content-type" charset="utf-8">
    <title> GesClick: Software de facturación online</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/login.css" />
</head>
<body>
	<div id="login_cont" class='centered'>

		<h2><?=$this->lang->line('sentry_register_sucess_message');?></h2>
		<BR/>
		<?=anchor($this->config->item('sentry_home_action'), $this->lang->line('sentry_continue_label'))?>
	
	</div>
</body>
</html>