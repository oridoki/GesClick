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
	
		<?= (isset($this->validation->kk)) ? '<div class="error">'.$this->validation->kk.'</div>' : '' ?>

		<p class='descripcion'>Gestiona tu facturación desde donde tu quieras de forma fácil, simple y rápida.</p>
		
		<?=form_open('auth/login')?>
			<p><label><span><?=$this->lang->line('sentry_user_name_label')?>: </span><br />
			<?=form_input(array('name'=>$this->config->item('auth_user_name_field'), 
			                       'id'=>$this->config->item('auth_user_name_field'),
			                       'maxlength'=>'30', 
			                       'size'=>'30',
			                       'value'=>(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_name_field')} : '')))?>
		    </label><span><?=(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_name_field').'_error'} : '')?></span></p>

			<p><label><span><?=$this->lang->line('sentry_user_password_label')?>: </span><br />
			<?=form_password(array('name'=>$this->config->item('auth_user_password_field'), 
			                       'id'=>$this->config->item('auth_user_password_field'),
			                       'maxlength'=>'30', 
			                       'size'=>'30',
			                       'value'=>(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_password_field')} : '')))?>
		    </label><span><?=(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_password_field').'_error'} : '')?></span></p>

		    <p class='label_checkbox_pair'><?=form_checkbox(array('name'=>$this->config->item('auth_user_autologin_field'), 
			                       'id'=>$this->config->item('auth_user_autologin_field'),
			                       'checked'=>false))?>
		    </p>
			<div class='rememberme'><?=$this->lang->line('sentry_user_autologin_label')?></div>

			<div class='access_button'><label>
			<?=form_submit(array('name'=>'login', 
			                     'id'=>'login', 
			                     'value'=>$this->lang->line('sentry_login_label')))?>
		    </label></div>

			<p class='centrat'>¿No tienes una cuenta? <?=anchor('auth/register_index', $this->lang->line('sentry_register_label'))?>!  |  <?=anchor('auth/forgotten_password', $this->lang->line('sentry_forgotten_password_label'))?></p>
		<?=form_close()?>
		
	</div>
</body>
</html>