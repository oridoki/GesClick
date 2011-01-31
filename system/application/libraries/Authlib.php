<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * AuthLib Class
 *
 * Security handler that provides functionality to handle logins and logout
 * requests.  It also can verify the logged in status of a user and permissions.
 *
 * The class requires the use of the Database and Encrypt CI libraries and the
 * URL CI helper.  It also requires the use of the 3rd party DB_Session
 * library.  The Auth library should be auto loaded in the core classes section
 * of the autoloader.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Security
 * @author      Jaapio
 * @copyright   Copyright (c) 2006, fphpcode.nl
 *
 */

// ------------------------------------------------------------------------
require_once(APPPATH.'controllers/auth'.EXT);

class AuthLib
{
    function AuthLib()
    {
        $this->obj =& get_instance();

        log_message('debug', "AuthLib Class Initialized");

        //$this->obj->load->library('database');
        $this->obj->load->library('encrypt');
        $this->obj->load->library('Db_session');
        $this->obj->load->helper('form');
        $this->obj->load->helper('url');
        $this->obj->load->helper('auth');
        $this->obj->load->model('Usermodel', 'usermodel'); 

        $this->_init();
    }

    //
    // Handles the user activation requests.
    // Returns true if successful activation, false if unsucessful.
    //
    function activation($id, $activation_code)
    {
        if (($id > 0) && ($activation_code != ''))
        {
            $query = $this->obj->usermodel->getUserForActivation($id, $activation_code);

            if ($query->num_rows() > 0)
            {
                $row = $query->row();

                $this->obj->usermodel->updateUserForActivation($id);

                return true;
            }
        }

        return false;
    }

    //
    // Determines if a user is logged on and if not redirects them to the login page.
    //
    function check($class = null, $method = null)
    {
        if (!$this->obj->config->item('auth'))
            return true;

        if (!$this->isValidUser())
            redirect('auth/index', 'location');
            
        return true;
    }

    //
    // Handles the user forgotten password requests.
    //
    function forgotten_password()
    {
        if ($this->obj->db_session)
        {
            $email = $this->obj->input->post($this->obj->config->item('auth_user_email_field'));

            if (($email != false))
            {
                $query = $this->obj->usermodel->getUserForForgottenPassword($email);

                if (($query != null) && ($query->num_rows() > 0))
                {
                    $row = $query->row();
                    $user_id = $row->{$this->obj->config->item('auth_user_id_field')};
                    $user = $row->{$this->obj->config->item('auth_user_name_field')};

                    $activation_code = $this->_generateRandomString(50, 50);

                    $this->obj->usermodel->updateUserForForgottenPassword($user_id, $activation_code);

                    $this->_sendForgottenPasswordEmail($user_id, $user, $email, $activation_code);
                    
                    return true;
                }
            }
            
            //On error send user back to forgotten password page, and add error message
            $this->obj->db_session->set_flashdata(AUTH_STATUS, $this->obj->lang->line('auth_forgotten_password_user_not_found_message'), 1);
            
            return false;
        }
    }

    //
    // Handles the user forgotten password reset requests.
    //
    function forgotten_password_reset($id, $activation_code)
    {
        if (($id > 0) && ($activation_code != ''))
        {
            $query = $this->obj->usermodel->getUserForForgottenPasswordReset($id, $activation_code);

            if ($query->num_rows() > 0)
            {
                $row = $query->row();
                $user_id = $row->{$this->obj->config->item('auth_user_id_field')};
                $user = $row->{$this->obj->config->item('auth_user_name_field')};
                $email = $row->{$this->obj->config->item('auth_user_email_field')};

                $password = $this->_generateRandomString($this->obj->config->item('auth_user_password_min'), $this->obj->config->item('auth_user_password_max'));
                $encrypted_password = $this->obj->encrypt->hash($password, 'md5');

                $this->_sendForgottenPasswordResetEmail($user_id, $user, $email, $password);

                $this->obj->usermodel->updateUserForForgottenPasswordReset($user_id, $encrypted_password);

                return true;
            }
        }

        return false;
    }
    
    //
    // Returns the currently logged on user's name.
    // Returns an empty string if no user is logged in.
    //
    function getUserName()
    {
        if ($this->obj->config->item('auth') && $this->obj->db_session && $this->isValidUser())
            return $this->obj->db_session->userdata(AUTH_SECURITY_USER_NAME);
        
        return '';
    }
    
    //
    // Returns the currently logged on user's role.
    // Returns an empty string if no user is logged in.
    //
    function getSecurityRole()
    {
        if ($this->obj->config->item('auth') && $this->obj->config->item('auth_security_roles') && $this->obj->db_session && $this->isValidUser())
        {
            $security = $this->obj->db_session->userdata(AUTH_SECURITY_SECURITY);
            if (($security != null) &&
                isset($security[AUTH_SECURITY_ROLE]) &&
                isset($security[AUTH_SECURITY_ROLE][AUTH_SECURITY_ROLE_NAME]))
                return $security[AUTH_SECURITY_ROLE][AUTH_SECURITY_ROLE_NAME];
        }
        
        return '';
    }
    
    //
    // Returns the currently logged on user's role id.
    // Returns an -1 if no user is logged in.
    //
    function getSecurityRoleId()
    {
        if ($this->obj->config->item('auth') && $this->obj->config->item('auth_security_roles') && $this->obj->db_session && $this->isValidUser())
        {
            $security = $this->obj->db_session->userdata(AUTH_SECURITY_SECURITY);
            if (($security != null) &&
                isset($security[AUTH_SECURITY_ROLE]) &&
                isset($security[AUTH_SECURITY_ROLE][AUTH_SECURITY_ROLE_ID]))
                return $security[AUTH_SECURITY_ROLE][AUTH_SECURITY_ROLE_ID];
        }
        
        return -1;
    }

    //
    // Checks to see if a user has an explicit permission.
    // Returns true if auth system is not activated.
    // Returns the true if the permission is granted, otherwise false.
    //
    function hasPermission($permission_id)
    {
        if ($this->obj->config->item('auth') && $this->obj->config->item('auth_security_roles') && $this->obj->db_session && $this->isValidUser())
        {
            $security = $this->obj->db_session->userdata(AUTH_SECURITY_SECURITY);
            if (($security != null) &&
                isset($security[AUTH_SECURITY_ROLE]) &&
                isset($security[AUTH_SECURITY_ROLE][AUTH_SECURITY_ROLE_ID]) &&
                isset($security[AUTH_SECURITY_PERMISSIONS]))
                return hasPermission($permission_id, $this->isValidUser(), $security[AUTH_SECURITY_ROLE][AUTH_SECURITY_ROLE_ID], $security[AUTH_SECURITY_PERMISSIONS]);
        }

        return true;
    }

    //
    // Checks to see if a user is an administrator.
    // Returns true if auth system is not activated.
    // Returns true if admin, otherwise false.
    //
    function isAdmin()
    {
        if ($this->obj->config->item('auth') && $this->obj->config->item('auth_security_roles') && $this->isValidUser())
        {
            $security = $this->obj->db_session->userdata(AUTH_SECURITY_SECURITY);
            if (($security != null) &&
                isset($security[AUTH_SECURITY_ROLE]) &&
                isset($security[AUTH_SECURITY_ROLE][AUTH_SECURITY_ROLE_ID]) &&
                isset($security[AUTH_SECURITY_PERMISSIONS]))
                return true;
        }
        
        return false;
    }

    //
    // Checks to see if a user is logged in.
    // Returns true if auth system is not activated.
    // Returns the user_id if valid, otherwise false.
    //
    function isValidUser()
    {
        if (!$this->obj->config->item('auth'))
            return true;

        if ($this->obj->db_session)
        {
            $user_id = $this->obj->db_session->userdata(AUTH_SECURITY_USER_ID);
            if ($user_id != false)
                return $user_id;
        }

        return false;
    }

    //
    // Performs the login procedure.
    //
    function login()
    {
        if (!$this->obj->config->item('auth'))
            return;

        $message = $this->obj->lang->line('auth_invalid_user_message');

        if ($this->obj->db_session)
        {
            $values = $this->getLoginForm();
            $username = (isset($values[$this->obj->config->item('auth_user_name_field')]) ? $values[$this->obj->config->item('auth_user_name_field')] : false);
            $password = (isset($values[$this->obj->config->item('auth_user_password_field')]) ? $values[$this->obj->config->item('auth_user_password_field')] : false);
            $autoLogin = (isset($values[$this->obj->config->item('auth_user_autologin_field')]) ? $values[$this->obj->config->item('auth_user_autologin_field')] : 0);

            if (($username != false) && ($password != false))
            {
                $password = $this->obj->encrypt->hash($password, 'md5');

                //Use the input username and password and check against 'users' table
                $query = $this->obj->usermodel->getUserForLogin($username, $password);

                if ($query->num_rows() > 0)
                {
                    $row = $query->row();
                    $user_id = $row->{$this->obj->config->item('auth_user_id_field')};
                    $username = $row->{$this->obj->config->item('auth_user_name_field')};

                    $activated = $row->{$this->obj->config->item('auth_user_activated_field')};
                    if ($activated == 1)
                    {
                        $this->_set_logindata($user_id, $username);
                        $this->_set_security($user_id);

                        if ($autoLogin)
                            $this->_set_login_cookie($user_id);

                        $this->obj->db_session->set_flashdata(AUTH_STATUS, $this->obj->lang->line('auth_login_message'), 2);

                        return true;
                    }
                    else
                        $message = $this->obj->lang->line('auth_not_activated_user_message');
                }
            }
        }

        //On error send user back to login page, and add error message
        $this->obj->db_session->set_flashdata(AUTH_STATUS, $message, 1);

        return false;
    }

    //
    // Performs the logout procedure.
    //
    function logout()
    {
        if (!$this->obj->config->item('auth'))
            return;

        if ($this->obj->db_session)
        {
            $user_id = $this->obj->db_session->userdata(AUTH_SECURITY_USER_ID);
            if ($user_id != false)
                $this->_unset_user($user_id);
        }

        $this->obj->db_session->set_flashdata(AUTH_STATUS, $this->obj->lang->line('auth_logout_message'));
        redirect($this->obj->config->item('auth_logout_success_action'), 'location');
    }

    //
    // Performs the registration procedure.
    // Returns true if successful activation, false if unsucessful.
    //
    function register()
    {
        if (!$this->obj->config->item('auth'))
            return;

        if ($this->obj->db_session)
        {
            $values = $this->getRegistrationForm();
            $username = (isset($values[$this->obj->config->item('auth_user_name_field')]) ? $values[$this->obj->config->item('auth_user_name_field')] : false);
            $password = (isset($values[$this->obj->config->item('auth_user_password_field')]) ? $values[$this->obj->config->item('auth_user_password_field')] : false);
            $email = (isset($values[$this->obj->config->item('auth_user_email_field')]) ? $values[$this->obj->config->item('auth_user_email_field')] : false);

            if (($username != false) && ($password != false) && ($email != false))
            {
                $password = $this->obj->encrypt->hash($password, 'md5');
                $activation_code = $this->_generateRandomString(50, 50);

                $values[$this->obj->config->item('auth_user_password_field')] = $password;
                $values[$this->obj->config->item('auth_user_activation_code_field')] = $activation_code;

                $query = $this->obj->usermodel->insertUserForRegistration($values);

                //Use the input username and password and check against 'users' table
                $query = $this->obj->usermodel->getUserForLogin($username, $password);

                $user_id = 0;
                if (($query != null) && ($query->num_rows() > 0))
                {
                    $row = $query->row();
                    $user_id = $row->id;

                    $this->_sendActivationEmail($user_id, $username, $email, $activation_code);

                    return true;
                }
            }
        }

        $this->obj->db_session->set_flashdata(AUTH_STATUS, $this->obj->lang->line('auth_invalid_register_message'), 1);
        return false;
    }

    function register_init()
    {
        if (!$this->obj->config->item('auth_use_security_code'))
            return;
                
        $this->obj->db_session->unset_userdata('auth_security_code');
        $this->generateRandomSecurityCodeImage();
    }

    //
    // Creates a random security code image.
    //
    function generateRandomSecurityCodeImage()
    {
        if ($this->obj->config->item('auth_use_security_code'))
        {
            $securityCode = $this->_generateRandomString($this->obj->config->item('auth_security_code_min'), $this->obj->config->item('auth_security_code_max'));
            $image = 'security-'.$this->_generateRandomString(16, 32).'.jpg';
            $this->obj->config->set_item('auth_security_code_image', $image);
            
            $config['image_library'] = 'GD';
            $config['source_image'] = $this->obj->config->item('auth_security_code_image_base_image');
            $config['new_image'] = $image;
            $config['wm_text'] = $securityCode;
            $config['wm_type'] = 'text';
            $config['wm_font_path'] = $this->obj->config->item('auth_security_code_image_font');
            $config['wm_font_size'] = $this->obj->config->item('auth_security_code_image_font_size');
            $config['wm_font_color'] = $this->obj->config->item('auth_security_code_image_font_color');
            $config['wm_hor_alignment'] = 'center';

            $image =& get_instance();
            $image->load->library('image_lib');
            $image->image_lib->initialize($config);
            $image->image_lib->watermark();

            $this->obj->db_session->set_userdata('auth_security_code', $securityCode);
        }

        return false;
    }

    //
    // Generates a random string.
    //
    function _generateRandomString($minLength = 5, $maxLength = 5, $useUpper = true, $useNumbers = true, $useSpecial = false)
    {
        $charset = "abcdefghijklmnopqrstuvwxyz";
        if ($useUpper)
            $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        if ($useNumbers)
            $charset .= "0123456789";
        if ($useSpecial)
            $charset .= "~@#$%^*()_+-={}|][";

        $length = mt_rand($minLength, $maxLength);
        if ($minLength > $maxLength)
            $length = mt_rand($maxLength, $minLength);

        $key = '';
        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset)-1)))];

        return $key;
    }

    //
    // Initializes the security settings and checks for autologin.
    //
    function _init()
    {
        if (!$this->obj->config->item('auth'))
            return true;

        $this->_loadModel();
        
        $isValid = false;
        $user_id = 0;
        if ($this->obj->db_session && $this->isValidUser())
        {
            $isValid = true;
            $user_id = $this->isValidUser();
            $this->_set_users($user_id, null);
        }
        else
        {
            // check for auto login
            $user_id = $this->obj->input->cookie(AUTH_COOKIE_AUTOLOGIN);
            if ($user_id != null)
            {
                $this->_set_logindata($user_id, null);
                $isValid = true;
            }
        }

        if ($isValid)
            $this->_set_security($user_id);

        return false;
    }

    //
    // Wrapper method to load the auth model.
    //
    function _loadModel()
    {
        if (!isset($this->obj->usermodel))
            $this->obj->load->model($this->obj->config->item('usermodel'), 'usermodel');
    }

    //
    // Sends an email from the system to a given email address.
    //
    function _sendEmail($email, $subject, $message)
    {
        $tobj =& get_instance(); 
        $tobj->load->library('email');
        $tobj->email->clear();
        $tobj->email->from($this->obj->config->item('user_support'), $this->obj->lang->line('auth_email_from_name'));
        $tobj->email->to($email);
        $tobj->email->subject($subject);
        $tobj->email->message($message);
        $tobj->email->send();
    }

    function _sendActivationEmail($id, $user, $email, $activation_code)
    {
        $activation_url = site_url('auth/activation/'.$id.'/'.$activation_code);
        $data = array('activation_url' => $activation_url,
                      'user_name' => $user);

        $message = $this->obj->load->view($this->obj->config->item('view').$this->obj->config->item('auth_activation_email').EXT, $data, true);

        $this->_sendEmail($email, $this->obj->lang->line('auth_activation_email_subject'), $message);
    }

    function _sendForgottenPasswordEmail($id, $user, $email, $activation_code)
    {
        $activation_url = site_url('auth/forgotten_password_reset/'.$id.'/'.$activation_code);
        $data = array('activation_url' => $activation_url,
                      'user_name' => $user);

        $message = $this->obj->load->view($this->obj->config->item('view').$this->obj->config->item('auth_forgotten_password_email').EXT, $data, true);

        $this->_sendEmail($email, $this->obj->lang->line('auth_forgotten_password_email_subject'), $message);
    }

    function _sendForgottenPasswordResetEmail($id, $user, $email, $password)
    {
        $data = array('password' => $password,
                      'user_name' => $user);

        $message = $this->obj->load->view($this->obj->config->item('view').$this->obj->config->item('auth_forgotten_password_reset_email').EXT, $data, true);

        $this->_sendEmail($email, $this->obj->lang->line('auth_forgotten_password_email_reset_subject'), $message);
    }

    function _set_logindata($user_id, $username = null)
    {
        $query = $this->obj->usermodel->getUserById($user_id);
        if (($query != null) && ($query->num_rows() > 0))
        {
            $row = $query->row();
            $username = $row->{$this->obj->config->item('auth_user_display_name_field')};
                
            $this->obj->db_session->set_userdata(array(AUTH_SECURITY_USER_ID => $user_id));
            $this->obj->db_session->set_userdata(array(AUTH_SECURITY_USER_NAME => $username));
            
            $this->obj->usermodel->updateUserForLogin($user_id);
    
            $this->_set_users($user_id, $username);
        }
        else
            $this->_unset_user($user_id);
    }

    function _set_security($user_id)
    {
        if (!$this->obj->config->item('auth') || !$this->obj->config->item('auth_security_roles'))
            return true;

        $query = $this->obj->usermodel->getSecurityRoleByUserId($user_id);
        if (($query != null) && ($query->num_rows() > 0))
        {
            $row = $query->row();
            $role_id = $row->{$this->obj->config->item('auth_security_role_id_field')};
            $role = $row->{$this->obj->config->item('auth_security_role_name_field')};
            
            $security[AUTH_SECURITY_ROLE] = array(AUTH_SECURITY_ROLE_ID => $role_id, AUTH_SECURITY_ROLE_NAME => $role);

            $query = $this->obj->usermodel->getSecurityPermissionsBySecurityRoleId($role_id);
            if (($query != null) && ($query->num_rows() > 0))
            {
                foreach ($query->result() as $row)
                    $permissions[$row->{AUTH_SECURITY_PERMISSION_ID}] = $row->{AUTH_SECURITY_PERMISSION_NAME};

                $security[AUTH_SECURITY_PERMISSIONS] = $permissions;
            }
               
            $this->obj->db_session->set_userdata(array(AUTH_SECURITY_SECURITY => $security));
        }
        else
            $this->_unset_user($user_id);
    }

    function _set_users($user_id, $username = null)
    {
        if ($username == null)
        {
            $query = $this->obj->usermodel->getUserById($user_id);
            if (($query != null) && ($query->num_rows() > 0))
            {
                $row = $query->row();
                $username = $row->{$this->obj->config->item('auth_user_name_field')};
            }
            else
                $username = 'unknown';
        }

        $users = $this->obj->db_session->userdata(AUTH_SECURITY_USERS);
        $users[$user_id] = $username;
        $this->obj->db_session->set_userdata(array(AUTH_SECURITY_USERS => $users));
    }

    function _unset_user($user_id)
    {
        $users = $this->obj->db_session->userdata(AUTH_SECURITY_USERS);
        if (isset($users[$user_id]))
        {
            unset($users[$user_id]);
            //$this->obj->db_session->set_userdata(array(AUTH_SECURITY_USERS => $users));
            $this->obj->db_session->unset_userdata(AUTH_SECURITY_USER_ID);
            $this->obj->db_session->unset_userdata(AUTH_SECURITY_SECURITY);
            $this->obj->db_session->unset_userdata(AUTH_SECURITY_USER_ID);
            $this->obj->db_session->unset_userdata(AUTH_SECURITY_USER_NAME);
            $this->obj->db_session->unset_userdata(AUTH_SECURITY_USERS);
        }
        
        $this->_unset_login_cookie();
    }

    //
    // Sets the login cookie
    //
    function _set_login_cookie($user_id)
    {
        $this->obj->load->helper('cookie');

        $cookie = array('name' => AUTH_COOKIE_AUTOLOGIN,
                        'value' => $user_id,
                        'expire' => $this->obj->config->item('auth_auto_login_period'),
                        'path' => '/');
        set_cookie($cookie);
    }

    //
    // Deletes the login cookie
    //
    function _unset_login_cookie()
    {
        $this->obj->load->helper('cookie');

        $cookie = array('name' => AUTH_COOKIE_AUTOLOGIN,
                        'value' => '',
                        'expire' => '',
                        'path' => '/');
        set_cookie($cookie);
    }
    
        //
    // Gets login form input values.
    //
    function getLoginForm()
    {
        $values[$this->obj->config->item('auth_user_name_field')] = $this->obj->input->post($this->obj->config->item('auth_user_name_field'));
        $values[$this->obj->config->item('auth_user_password_field')] = $this->obj->input->post($this->obj->config->item('auth_user_password_field'));
        $values[$this->obj->config->item('auth_user_autologin_field')] = isset($_POST[$this->obj->config->item('auth_user_autologin_field')]);
        
        //$values[$this->obj->config->item('auth_<your field>_field')] = $this->obj->input->post($this->obj->config->item('auth_<your field>_field'));
        
        return $values;
    }
        //
    // Gets registration form input values.
    //
    function getRegistrationForm()
    {
        $values[$this->obj->config->item('auth_user_name_field')] = $this->obj->input->post($this->obj->config->item('auth_user_name_field'), TRUE);
        $values[$this->obj->config->item('auth_user_password_field')] = $this->obj->input->post($this->obj->config->item('auth_user_password_field'));
        $values[$this->obj->config->item('auth_user_email_field')] = $this->obj->input->post($this->obj->config->item('auth_user_email_field'));
        if ($this->obj->config->item('auth_use_country'))
            $values[$this->obj->config->item('auth_user_country_field')] = $this->obj->input->post($this->obj->config->item('auth_user_country_field'));
            
        //$values[$this->obj->config->item('auth_<your field>_field')] = $this->obj->input->post($this->obj->config->item('auth_<your field>_field'));
        
        return $values;
    }
  
}

?>