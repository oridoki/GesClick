<?php
/***
* 
* Copyright 2011 Adrià Cidre Jugo
* 
* This program is free software; you can redistribute it and/or modify 
* it under the terms of the GNU General Public License as published by 
* the Free Software Foundation; either version 2 of the License, or (
* at your option) any later version. This program is distributed in the 
* hope that it will be useful, but WITHOUT ANY WARRANTY; without even 
* the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR 
* PURPOSE. See the GNU General Public License for more details. You 
* should have received a copy of the GNU General Public License along 
* with this program; if not, write to the Free Software Foundation, 
* Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA.
* 
* 
**/

/**
 * Auth Controller Class
 *
 * Security controller that provides functionality to handle logins and logout
 * requests.  It also can verify the logged in status of a user and permissions.
 *
 * The class requires the use of the NativeSession and Sentry libraries.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Security
 * @author      Jaapio
 * @copyright   Copyright (c) 2006, fphpcode.nl
 *
 */
class Auth extends Controller
{
    function Auth()
    {
        parent::Controller();
        $this->obj =& get_instance(); 
        $this->lang->load('sentry');
        $this->load->model('Usermodel');
        $this->load->library('validation');
		$this->validation->set_error_delimiters($this->config->item('auth_error_delimiter_open'), $this->config->item('auth_error_delimiter_close'));
		
		$fields[$this->config->item('auth_user_name_field')] = $this->lang->line('auth_user_name_label');
        $fields[$this->config->item('auth_user_password_field')] = $this->lang->line('auth_user_password_label');
        $fields[$this->config->item('auth_user_password_confirm_field')] = $this->lang->line('auth_user_password_confirm_label');
        $fields[$this->config->item('auth_user_email_field')] = $this->lang->line('auth_user_email_label');
        $fields[$this->config->item('auth_user_autologin_field')] = $this->lang->line('auth_user_autologin_label');
        $fields[$this->config->item('auth_user_security_code_field')] = $this->lang->line('auth_user_security_code_label');
        
        if ($this->config->item('auth_use_country'))
            $fields[$this->config->item('auth_user_country_field')] = $this->lang->line('auth_user_country_label');
        
        //additionalFields($fields);
        
        $this->validation->set_fields($fields);
    }

    //
    // Handles the user activation.
    //
    function activation()
    {
        if ($this->authlib->activation($this->uri->segment(3, 0), $this->uri->segment(4, ''))) {

			// Accedim automaticament amb el client
			$this->authlib->directLogin($this->uri->segment(3, 0));
			
			// Creamos los tipos de IVA por defecto
			$this->load->model("tax_model");
			$this->tax_model->defaults();

            $this->load->view($this->config->item('auth_register_activation_success_view'));
		} else {
            $this->load->view($this->config->item('auth_register_activation_failed_view'));
		}
    }
    
    //
    // Handles the post from the forgotten password form.
    //
    function forgotten_password()
    {
        $rules[$this->config->item('auth_user_email_field')] = "trim|required|valid_email|xss_clean";
        $this->validation->set_rules($rules);
        
        if ($this->validation->run() && $this->authlib->forgotten_password())
            $this->load->view($this->config->item('auth_forgotten_password_success_view'));
        else
        {
            $this->obj->db_session->flashdata_mark();
            $this->load->view($this->config->item('auth_forgotten_password_view'));
        }
    }
    
    //
    // Displays the forgotten password reset.
    //
    function forgotten_password_reset()
    {
        if ($this->authlib->forgotten_password_reset($this->uri->segment(3, 0), $this->uri->segment(4, '')))
            $this->load->view($this->config->item('auth_forgotten_password_reset_success_view'));
        else
            $this->load->view($this->config->item('auth_forgotten_password_reset_failed_view'));
    }

    //
    // Displays the login form.
    //
    function index()
    {
        $this->load->view($this->config->item('auth_login_view'));
    }
    
    //
    // Handles the post from the login form.
    //
    function login()
    {

		if($this->authlib->isValidUser()) {
            redirect('bills', 'location');
		}

	
        $rules[$this->config->item('auth_user_name_field')] = $this->config->item('auth_user_name_field_validation_login');
        $rules[$this->config->item('auth_user_password_field')] = $this->config->item('auth_user_password_field_validation_login');
        
        //additionalLoginRules($rules);
        
        $this->validation->set_rules($rules);
        
        if ($this->validation->run() && $this->authlib->login()) { 			// Ha pasado el login
			redirect($this->config->item('auth_login_success_action'), 'location'); //On success redirect user to	default page

		} else {															// Ha fallado el inicio de sesión

            $this->db_session->sess_gc();

			if(count($_POST) > 0) {
				$this->validation->kk = 'Los datos introducidos son incorrectos';
			}
			
            $this->index();

        }
    }

    //
    // Handles the logout action.
    //
    function logout()
    {
        $this->authlib->logout();
    }
    
    //
    // Handles the post from the registration form.
    //
    function register()
    {
        $rules[$this->config->item('auth_user_name_field')] = $this->config->item('auth_user_name_field_validation_register');
        $rules[$this->config->item('auth_user_password_confirm_field')] = $this->config->item('auth_password_required_confirm_validation')."|matches[".$this->config->item('auth_user_password_field')."]";
        $rules[$this->config->item('auth_user_password_field')] = $this->config->item('auth_user_password_field_validation_register');

        $rules[$this->config->item('auth_user_email_field')] = $this->config->item('auth_user_email_field_validation_register');
        
        if ($this->config->item('auth_use_country'))
            $rules[$this->config->item('auth_user_country_field')] = $this->config->item('auth_user_country_field_validation_register');
        
		$this->validation->set_message('email_check', 'El Email introducido ya existe en el sistema');
		$this->validation->set_message('password_check', 'La contraseña es incorrecta');
		$this->validation->set_message('username_check', 'El nombre de usuario no es válido');
		$this->validation->set_message('username_duplicate_check', 'El nombre de usuario no es válido');
		
        //additionalRegistrationRules($rules);
         
        $this->validation->set_rules($rules);
        
        if ($this->validation->run() && $this->authlib->register())
        {
            $this->load->view($this->config->item('auth_register_success_view'));
        }
        else
        {
            $this->db_session->flashdata_mark();
            $this->register_index();
        }
    }
    
    //
    // Displays the registration form.
    //
    function register_index()
    {
        $countries = null;            
        if ($this->config->item('auth_use_country'))
            $countries = $this->Usermodel->getCountries();
        
        if ($this->config->item('auth_use_security_code'))
            $this->authlib->register_init();
                    $data['countries'] = $this->Usermodel->getCountries();
        $this->load->view($this->config->item('auth_register_view'), $data);
    }
    
    //
	// RULES HELPER FUNCTION
	//
	// Password validation callback
	//
	function password_check($value)
	{
	    return $this->_is_valid_text('password_check', $value, $this->obj->config->item('auth_user_password_min'), $this->obj->config->item('auth_user_password_max'));
	}
	
	//
	// RULES HELPER FUNCTION
	//
	// Security code validation callback.
    //
    function securitycode_check($value)
	{
	    if ($this->obj->config->item('auth_use_security_code'))
	    {
    	    $securityCode = $this->obj->session->userdata('auth_security_code');
    	    if (strcmp($value, $securityCode) != 0)
    	    {
    	        $this->validation->set_message('securitycode_check', $this->obj->lang->line('auth_in_use_validation_message'));
    		    return false;
    		}
    	}
		
		return true;
	}
	
	//
	// RULES HELPER FUNCTION
	//
	// User name validation callback.
    //
    function username_check($value)
	{
	    return $this->_is_valid_text('username_check', $value, $this->obj->config->item('auth_user_name_min'), $this->obj->config->item('auth_user_name_max'));
	}


	//
	// RULES HELPER FUNCTION
	//
	// E-Mail validation callback.
    //
    function email_check($value)
	{
		$this->load->model("usermodel");
		return $this->usermodel->getUserByEmail($value);
	}

	
	//
	// RULES HELPER FUNCTION
	//
	// User name duplicate validation callback.
    //
    function username_duplicate_check($value)
	{
	    //Use the input username and password and check against 'users' table
        $this->obj->db->where($this->obj->config->item('auth_user_name_field'), $value);
        $query = $this->obj->db->get($this->obj->config->item('auth_user_table_name'));

        if (($query != null) && ($query->num_rows() > 0))
	    {
	        $this->validation->set_message('username_check', $this->obj->lang->line('auth_in_use_validation_message'));
		    return false;
		}
		
		return true;
	}
	
	//
	// RULES HELPER FUNCTION
	//
	// Determines if a input text has valid characters and meets min/max length requirements.
    //
    function _is_valid_text($callback, $value, $min = 4, $max = 16, $invalid_message = null, $expression = '/^([a-z0-9])([a-z0-9_\-])*$/ix')
	{
	    $message = '';
	    if ((strlen($value) < $min) ||
	        (strlen($value) > $max))
	        $message .= sprintf($this->obj->lang->line('auth_allowed_characters_validation_message'), $min, $max);
	        
	    if (!preg_match($expression, $value))
	        $message .= $this->obj->lang->line('auth_allowed_characters_validation_message');
		
		if ($message != '')
		{
		    if (!isset($invalid_message))
		        $invalid_message = $this->obj->lang->line('auth_invalid_validation_message');
		    $this->validation->set_message($callback, $invalid_message.$message);
	        return false;
		}
		
		return true;
	}
}
?>