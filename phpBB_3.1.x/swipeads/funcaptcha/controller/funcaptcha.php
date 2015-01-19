<?php

namespace swipeads\funcaptcha\controller;

class funcaptcha extends \phpbb\captcha\plugins\captcha_abstract
{
    /* @var \phpbb\config\config */

    protected $config;
    /* @var \phpbb\controller\helper */
    protected $helper;
    /* @var \phpbb\template\template */
    protected $template;
    /* @var \phpbb\user */
    protected $user;
    
    protected $request;

    /**
     * Constructor
     *
     * @param \phpbb\config\config $config
     * @param \phpbb\controller\helper $helper
     * @param \phpbb\template\template $template
     * @param \phpbb\user $user
     */
    public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\request\request $request) {
        $this->config = $config;
        $this->helper = $helper;
        $this->template = $template;
        $this->user = $user;
        $this->request = $request;
    }

        
	function init( $type )
	{
		global $config, $db, $user;

		$this->user->add_lang_ext('swipeads/funcaptcha', 'captcha_funcaptcha' );
//                $this->user->add_lang('captcha_recaptcha');
		parent::init( $type );
	}
        

	function get_instance()
	{
//		$instance = new phpbb_funcaptcha();
//		return $instance;
	}

	function is_available()
	{
		global $config, $user;

		$this->user->add_lang_ext('swipeads/funcaptcha', 'captcha_funcaptcha' );
//		return( ( (isset( $this->config['funcaptcha_public_key'] ))&&(!empty( $this->config['funcaptcha_public_key'] ))) && ((isset( $this->config['funcaptcha_private_key'] ))&&(!empty( $this->config['funcaptcha_private_key']) )));
		return !empty($this->config['funcaptcha_public_key']) && !empty( $this->config['funcaptcha_private_key']);
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
		global $config, $db, $template, $user, $request;
                
		$captcha_vars=array(
			'funcaptcha_theme'		=> 'FUNCAPTCHA_THEME',
			'funcaptcha_security'	=> 'FUNCAPTCHA_SECURITY',
            'funcaptcha_lightbox'	=> 'FUNCAPTCHA_LIGHTBOX',
            'funcaptcha_javascript'	=> 'FUNCAPTCHA_JAVASCRIPT',
            'funcaptcha_public_key'	=> 'FUNCAPTCHA_PUBLIC_KEY',
            'funcaptcha_private_key'	=> 'FUNCAPTCHA_PRIVATE_KEY',
            'funcaptcha_proxy'	    => 'FUNCAPTCHA_PROXY',
            'funcaptcha_number_posts'	=> 'FUNCAPTCHA_NUMBER_POSTS',
		);
                
		
		$max_len_str_with_code      = 1530;
		$code_substr_len            = 255;
		$module->tpl_name           = '@swipeads_funcaptcha/captcha_funcaptcha_acp';
		$module->page_title         = 'ACP_VC_SETTINGS';
		$form_key                   = 'swipeads/funcaptcha';

		add_form_key( $form_key );
		$submit = request_var( 'submit', '' );

		if (!empty($submit))
		{
            echo 'here';
            exit;
            if (!check_form_key($form_key))
			{
				trigger_error('FORM_INVALID');
			}
			$captcha_vars = array_keys( $captcha_vars );
            var_dump($captcha_vars);
			foreach($captcha_vars as $captcha_var)
			{
				$value = $request->variable( $captcha_var, '' );
//              echo 'here';
                $config->set( $captcha_var, $value );
			}

			add_log( 'admin', 'LOG_CONFIG_VISUAL' );
			trigger_error( $this->user->lang['CONFIG_UPDATED'].adm_back_link( $module->u_action ) );
		}
		else if( $submit )
		{
			trigger_error( $this->user->lang['FORM_INVALID'].adm_back_link( $module->u_action ) );
		}
		else
		{
			foreach($captcha_vars as $captcha_var => $template_var)
			{
				$var=(isset( $_REQUEST[$captcha_var] ))?request_var( $captcha_var, '' ):((isset( $config[$captcha_var] ))?$config[$captcha_var]:'');
				$this->template->assign_var($template_var, $var);
			}
            $sid = $request->variable('sid', '');

            $u_action = './../adm/index.php?i=-swipeads-funcaptcha-acp-main_module&sid=' . $sid . '&mode=settings';

			$this->template->assign_vars(array(
				'CAPTCHA_PREVIEW'	=> $this->get_demo_template($id),
				'CAPTCHA_NAME'		=> $this->get_class_name(),
				'U_ACTION'		    => $u_action,
                'RETURN_URL'        => $module->u_action
            ));
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
            if ($this->is_available())
			{
				$funcaptcha =  new \swipeads\funcaptcha\includes\funcaptcha;
				$funcaptcha->setSecurityLevel($this->config['funcaptcha_security']);
				$funcaptcha->setLightboxMode($this->config['funcaptcha_lightbox']);
				$funcaptcha->setTheme($this->config['funcaptcha_theme']);
				$funcaptcha->setNoJSFallback($this->config['funcaptcha_javascript']);

				//only show HTML/label if not lightbox mode.
				if ($this->config['funcaptcha_lightbox']) {
						$output = $funcaptcha->getFunCaptcha($this->config['funcaptcha_public_key']);
				} else {
						$output = "<div class=\"blockrow\"><input type=hidden value='1' id='humanverify' name='humanverify' /><div class=\"group\"><li style='list-style-type:none;'>";
						$output = $output . "<label>Verification:</label>";
						$output = $output . $funcaptcha->getFunCaptcha($this->config['funcaptcha_public_key']);
						$output = $output . "</li></div></div>";
				}

                // update local config vars:
                $this->updateLocal($funcaptcha->remote_options);
            }
                
            // End custom
                
			$this->template->assign_vars( array(
				'S_FUNCAPTCHA_AVAILABLE'	=> $this->is_available(),
				'S_CONFIRM_CODE'			=> true,
				'S_TYPE'					=> $this->type,
				'FUNCAPTCHA_CODE'			=> $output,
				) );
			$this->template->assign_vars(
				array(
				'CONFIRM_IMAGE'				=> $output,		
				
				
				'CONFIRM_IMG'				=> $output,
				'L_CONFIRM_CODE'			=> $this->user->lang['FUNCAPTCHA_TASK_HEADER']."<br />".$this->user->lang['FUNCAPTCHA_TASK_EXPLAIN'],
				'L_CONFIRM_EXPLAIN'			=> "",
				'L_VC_REFRESH_EXPLAIN'		=> "",
				'L_CONFIRM_CODE_EXPLAIN'	=> "",
				'L_VC_REFRESH'				=> "fc_check_button"
				)
			);

            return '@swipeads_funcaptcha/captcha_funcaptcha.html';
		}
	}

	function get_demo_template( $id )
	{
		return $this->get_template();
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
			$funcaptcha =  new \swipeads\funcaptcha\includes\funcaptcha;
			$funcaptcha->setSecurityLevel($this->config['funcaptcha_security']);
			$funcaptcha->setLightboxMode($this->config['funcaptcha_lightbox']);
			$funcaptcha->setTheme($this->config['funcaptcha_theme']);
			$funcaptcha->setNoJSFallback($this->config['funcaptcha_javascript']);
			$score =  $funcaptcha->checkResult($this->config['funcaptcha_private_key']);
			
			if($score)
			{
				$this->solved=true;
				return false;
			}
			else
			{
				return $this->user->lang['FUNCAPTCHA_MESSAGE_INCORRECT'];
			}
		}
	}

    public function get_generator_class() {
        
    }

    function updateLocal($remote_options)
    {
        if (!isset($remote_options))
            return;

        $arOptMap = array(
            'proxy' => 'funcaptcha_proxy',
            'security_level' => 'funcaptcha_security',
            'theme' => 'funcaptcha_theme',
            'noscript_support' => 'funcaptcha_jsfallback',
        );

        foreach(array_keys($remote_options) as $key)
        {
            try{
                if (isset($arOptMap[$key]))
                {
                    // set config:
                    set_config( $arOptMap[$key], $remote_options[$key] );
                }
            } catch (\Exception $e) {}
        }
    }

}
