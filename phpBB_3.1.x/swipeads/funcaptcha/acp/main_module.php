<?php
/**
*
* @package phpBB Extension - Funcaptcha
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace swipeads\funcaptcha\acp;

class main_module
{
	var $u_action;

	function main($id, $mode, $tpl_name = 'setting_page')
	{
		global $db, $user, $auth, $template, $cache, $request;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		$user->add_lang_ext('swipeads/funcaptcha', 'captcha_funcaptcha');
		$this->tpl_name = $tpl_name;
		$this->page_title = $user->lang('CAPTCHA_FUNCAPTCHA');
		add_form_key('swipeads/funcaptcha');
                
                $captcha_vars=array(
			'funcaptcha_theme'		=> 'FUNCAPTCHA_THEME',
			'funcaptcha_security'	=> 'FUNCAPTCHA_SECURITY',
                        'funcaptcha_lightbox'	=> 'FUNCAPTCHA_LIGHTBOX',
                        'funcaptcha_javascript'	=> 'FUNCAPTCHA_JAVASCRIPT',
                        'funcaptcha_public_key'	=> 'FUNCAPTCHA_PUBLIC_KEY',
                        'funcaptcha_private_key'	=> 'FUNCAPTCHA_PRIVATE_KEY',
                        'funcaptcha_proxy'	=> 'FUNCAPTCHA_PROXY',
                        'funcaptcha_number_posts'	=> 'FUNCAPTCHA_NUMBER_POSTS',
		);
                
		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('swipeads/funcaptcha'))
			{
				trigger_error('FORM_INVALID');
			}
                        
                        $captcha_vars=array_keys( $captcha_vars );
			foreach($captcha_vars as $captcha_var)
			{                                
                            $config->set($captcha_var, $request->variable($captcha_var, ''));
			}
                        
                        $sid = $request->variable('return_url', '');
                        if(!empty($sid)) {
                            $return_url = $sid;
                        } else {
                            $return_url = $this->u_action;
                        }
			trigger_error($user->lang('FUNCAPTCHA_SAVED') . adm_back_link($return_url));
		}
                
                $template_vars['U_ACTION'] = $this->u_action;
                
                foreach($captcha_vars as $configkey => $tempval) {
                    $template_vars[$tempval] = $config[$configkey];
                }

		$template->assign_vars($template_vars);
	}
}
