<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta content="text/html;" http-equiv="content-type" charset="utf-8">
    <title> GesClick: Software de facturación online</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/login.css" />
</head>
<body>
	<div id="login_cont">

		<h2>¿Olvidó su contraseña?</h2><br />
		<p class='descripcio'>Introduzca su dirección de correo electrónico y nosotros le enviaremos su nueva clave de acceso.</p><br />
		<br />
		
		<?=form_open('auth/forgotten_password')?>
			<table>
				<tr>
					<td>
						<?=form_input(array('name'=>$this->config->item('auth_user_email_field'), 
						                       'id'=>$this->config->item('auth_user_email_field'),
						                       'maxlength'=>'100', 
						                       'size'=>'60',
												'class'=>'forgot',
						                       'value'=>(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_email_field')} : '')))?>
					</td>
					<td>
						<?=form_submit(array('name'=>'forgotten_password', 
						                     'id'=>'forgotten_password', 
						                     'value'=>$this->lang->line('sentry_submit_label')))?>
						
					</td>
				</tr>
				<tr>
					<td colspan=2>
						<?=(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_email_field').'_error'} : '')?></span></p>
					</td>
				</tr>
			</table>
		<?=form_close()?>

	</div>
</body>
</html>