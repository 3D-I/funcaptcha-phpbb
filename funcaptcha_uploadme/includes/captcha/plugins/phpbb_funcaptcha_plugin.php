<?php

if(!defined( 'IN_PHPBB' ))
{
	exit;
}

if(!class_exists( 'phpbb_default_captcha' ))
{
	include( $phpbb_root_path . 'includes/captcha/plugins/captcha_abstract.' . $phpEx );
}

include( $phpbb_root_path . 'includes/funcaptcha.' . $phpEx );

class phpbb_funcaptcha extends phpbb_default_captcha
{
	function init( $type )
	{
		global $config, $db, $user;

		$user->add_lang( 'mods/captcha_funcaptcha' );
		parent::init( $type );
	}

	function get_instance()
	{
		$instance = new phpbb_funcaptcha();
		return $instance;
	}

	function is_available()
	{
		global $config, $user;
		$user->add_lang( 'mods/captcha_funcaptcha' );
//		return( ( (isset( $config['funcaptcha_public_key'] ))&&(!empty( $config['funcaptcha_public_key'] ))) && ((isset( $config['funcaptcha_private_key'] ))&&(!empty( $config['funcaptcha_private_key']) )));
                return true;
                
        }

	function has_config()
	{
		return true;
	}

	function get_name()
	{
		return 'CAPTCHA_FUNCAPTCHA';
	}

	function get_class_name()
	{
		return 'phpbb_funcaptcha';
	}

	function acp_page( $id, $module )
	{
		global $config, $db, $template, $user;

		$captcha_vars=array(
			'funcaptcha_theme'		=> 'FUNCAPTCHA_THEME',
			'funcaptcha_security'	=> 'FUNCAPTCHA_SECURITY',
            'funcaptcha_javascript'	=> 'FUNCAPTCHA_JAVASCRIPT',
            'funcaptcha_public_key'	=> 'FUNCAPTCHA_PUBLIC_KEY',
            'funcaptcha_private_key'	=> 'FUNCAPTCHA_PRIVATE_KEY',
            'funcaptcha_proxy'	=> 'FUNCAPTCHA_PROXY',
            'funcaptcha_number_posts'	=> 'FUNCAPTCHA_NUMBER_POSTS',
		);
		
		$max_len_str_with_code=1530;
		$code_substr_len=255;
		$module->tpl_name='captcha_funcaptcha_acp';
		$module->page_title='ACP_VC_SETTINGS';
		$form_key='acp_captcha';
		add_form_key( $form_key );

		$submit=request_var( 'submit', '' );

		if ( ($submit)&&(check_form_key( $form_key )) )
		{
			$captcha_vars=array_keys( $captcha_vars );
			foreach($captcha_vars as $captcha_var)
			{
				$value=request_var( $captcha_var, '' );
	            set_config( $captcha_var, $value );
			}

			add_log( 'admin', 'LOG_CONFIG_VISUAL' );
			trigger_error( $user->lang['CONFIG_UPDATED'].adm_back_link( $module->u_action ) );
		}
		else if( $submit )
		{
			trigger_error( $user->lang['FORM_INVALID'].adm_back_link( $module->u_action ) );
		}
		else
		{
			foreach($captcha_vars as $captcha_var => $template_var)
			{
				$var=(isset( $_REQUEST[$captcha_var] ))?request_var( $captcha_var, '' ):((isset( $config[$captcha_var] ))?$config[$captcha_var]:'');
				$template->assign_var($template_var, $var);
			}

			$template->assign_vars(array(
				'CAPTCHA_PREVIEW'	=> $this->get_demo_template($id),
				'CAPTCHA_NAME'		=> $this->get_class_name(),
				'U_ACTION'		=> $module->u_action,));
		}
	}

	function execute_demo()
	{
	}

	function execute()
	{
	}

	function get_template()
	{
		global $config, $user, $template;

		if($this->is_solved())
		{
			return false;
		}
		else
		{
            $funcaptcha =  new FUNCAPTCHA();
            $funcaptcha->setSecurityLevel($config['funcaptcha_security']);
            $funcaptcha->setLightboxMode($config['funcaptcha_lightbox']);
            $funcaptcha->setTheme($config['funcaptcha_theme']);
            $funcaptcha->setNoJSFallback($config['funcaptcha_javascript']);

            //only show HTML/label if not lightbox mode.
            if ($config['funcaptcha_lightbox']) {
                    $output = $funcaptcha->getFunCaptcha($config['funcaptcha_public_key']);
            } else {
                    $output = "<div class=\"blockrow\"><input type=hidden value='1' id='humanverify' name='humanverify' /><div class=\"group\">";
                    $output = $output . $funcaptcha->getFunCaptcha($config['funcaptcha_public_key']);
                    $output = $output . "</div></div>";
            }

            
            // End custom
                
			$template->assign_vars( array(
				'S_FUNCAPTCHA_AVAILABLE'	=> $this->is_available(),
				'S_CONFIRM_CODE'			=> true,
				'S_TYPE'					=> $this->type,
				'FUNCAPTCHA_CODE'			=> $output,
				) );
			$template->assign_vars(
				array(
				'CONFIRM_IMAGE'				=> $output,		
				
				
				'CONFIRM_IMG'				=> $output,
				'L_CONFIRM_CODE'			=> $user->lang['FUNCAPTCHA_TASK_HEADER']."<br />".$user->lang['FUNCAPTCHA_TASK_EXPLAIN'],
				'L_CONFIRM_EXPLAIN'			=> "",
				'L_VC_REFRESH_EXPLAIN'		=> "",
				'L_CONFIRM_CODE_EXPLAIN'	=> "",
				'L_VC_REFRESH'				=> "fc_check_button"
				)
			);
			
			if(file_exists( $template->root.'/captcha_funcaptcha.html' ))
			{
				return 'captcha_funcaptcha.html';
			}
			else if(file_exists( $template->root.'/../../prosilver/template/captcha_funcaptcha_default.html' ))
			{
				return '../../prosilver/template/captcha_funcaptcha_default.html';
			}
		}
	}

	function get_demo_template( $id )
	{
		global $config, $template;
			$template->assign_vars( array(
				'S_FUNCAPTCHA_AVAILABLE'	=> $this->is_available(),
				'FUNCAPTCHA_SITE_PRIVATE_KEY'	=> (FALSE )));
			if(file_exists( $template->root.'/captcha_funcaptcha.html' ))
			{
				return 'captcha_funcaptcha.html';
			}

	}

	function get_hidden_fields()
	{
		$hidden_fields=array();

		// this is required for posting.php - otherwise we would forget about the captcha being already solved
		if($this->solved)
		{
			$hidden_fields['confirm_code']=$this->code;
		}
		$hidden_fields['confirm_id']=$this->confirm_id;
		return $hidden_fields;
	}

	function uninstall()
	{
		$this->garbage_collect( 0 );
	}

	function install()
	{
		return;
	}

	function validate()
	{
		global $config, $user;
		if(!parent::validate())
		{
			return false;
		}
		else
		{
            $funcaptcha =  new FUNCAPTCHA();
            $funcaptcha->setSecurityLevel($config['funcaptcha_security']);
            $funcaptcha->setLightboxMode($config['funcaptcha_lightbox']);
            $funcaptcha->setTheme($config['funcaptcha_theme']);
            $funcaptcha->setNoJSFallback($config['funcaptcha_javascript']);
            $score =  $funcaptcha->checkResult($config['funcaptcha_private_key']);
			if($score)
			{
				$this->solved=true;
				return false;
			}
			else
			{
				return $user->lang['FUNCAPTCHA_MESSAGE_INCORRECT'];
			}
		}
	}
}
?>
