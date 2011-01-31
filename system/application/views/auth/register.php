<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta content="text/html;" http-equiv="content-type" charset="utf-8">
    <title> GesClick: Software de facturación online</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>system/includes/css/login.css" />
</head>
<body>
	<div id="register_cont">

		<p class='descripcion'>Gestiona tu facturación desde donde tu quieras de forma fácil, simple y rápida.</p>

		<?=form_open('auth/register')?>
			<p><label><span><?=$this->lang->line('sentry_user_name_label')?>: </span>
			<?=form_input(array('name'=>$this->config->item('auth_user_name_field'), 
			                       'id'=>$this->config->item('auth_user_name_field'),
			                       'maxlength'=>'45', 
			                       'size'=>'45',
			                       'value'=>(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_name_field')} : '')))?>
		    </label><span><?=(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_name_field').'_error'} : '')?></span></p>
			<p><label><span><?=$this->lang->line('sentry_user_password_label')?>: </span>
			<?=form_password(array('name'=>$this->config->item('auth_user_password_field'), 
			                       'id'=>$this->config->item('auth_user_password_field'),
			                       'maxlength'=>'16', 
			                       'size'=>'16',
			                       'value'=>(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_password_field')} : '')))?>
		    </label><span><?=(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_password_field').'_error'} : '')?></span></p>
		    <p><label><span><?=$this->lang->line('sentry_user_password_confirm_label')?>: </span>
			<?=form_password(array('name'=>$this->config->item('auth_user_password_confirm_field'), 
			                       'id'=>$this->config->item('auth_user_password_confirm_field'),
			                       'maxlength'=>'16', 
			                       'size'=>'16',
			                       'value'=>(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_password_confirm_field')} : '')))?>
		    </label><span><?=(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_password_confirm_field').'_error'} : '')?></span></p>
		    <p><label><span><?=$this->lang->line('sentry_user_email_label')?>: </span>
			<?=form_input(array('name'=>$this->config->item('auth_user_email_field'), 
			                       'id'=>$this->config->item('auth_user_email_field'),
			                       'maxlength'=>'120', 
			                       'size'=>'60',
			                       'value'=>(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_email_field')} : '')))?>
		    </label><span><?=(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_email_field').'_error'} : '')?></span></p>
		<?php
		if ($this->config->item('auth_use_country'))
		{?>    
		    <p><label><span><?=$this->lang->line('sentry_user_country_label')?>: </span>
			<?=form_dropdown($this->config->item('auth_user_country_field'),
			                 $countries,
			                 (isset($this->validation) ? (($this->validation->{$this->config->item('auth_user_email_field')}) ? $this->validation->{$this->config->item('auth_user_email_field')} : 198) : 198))?>
		    </label><span><?=(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_email_field').'_error'} : '')?></span></p>
		<?php
		}
		$buttonSubmit = $this->lang->line('sentry_register_label');
		$buttonCancel = $this->lang->line('sentry_cancel_label');
		$callConfirm = '';
		if ($this->lang->line('sentry_terms_of_service_message') != '')
		{
		    $buttonSubmit = $this->lang->line('sentry_agree_label');
		    $buttonCancel = $this->lang->line('sentry_donotagree_label');
		    $callConfirm = 'confirmDecline();';
		?>
		<p><label>Acuerdo de licencia
		<textarea name='rules' class='textarea' rows='8' cols='50' readonly><?=$this->lang->line('sentry_terms_of_service_message')?></textarea>
		</label></p>
		<?php    
		}?>
		    <p>
			<?=form_submit(array('name'=>'register', 
			                     'id'=>'register', 
			                     'value'=>$buttonSubmit))?>
			<?=form_submit(array('type'=>'button',
			                     'name'=>'cancel', 
			                     'id'=>'cancel', 
			                     'value'=>$buttonCancel,
			                     'onclick'=>$callConfirm))?>
		    </p>
		<?=form_close()?>


	</div>
	
</body>
</html>

		<script language="JavaScript" type="text/javascript">
		<!--
		function confirmDecline() 
		{
		    if (confirm('<?=$this->lang->line('sentry_register_cancel_confirm')?>')) 
				location = '<?=site_url('auth/login')?>';
		} 
		//-->
		</script>
