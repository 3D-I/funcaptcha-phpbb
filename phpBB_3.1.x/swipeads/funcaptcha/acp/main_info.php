<?php
/**
*
* @package phpBB Extension - Funcaptcha
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace swipeads\funcaptcha\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\swipeads\funcaptcha\acp\main_module',
			'title'		=> 'CAPTCHA_FUNCAPTCHA',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'settings'	=> array('title' => 'CAPTCHA_FUNCAPTCHA', 'auth' => 'ext_swipeads/funcaptcha && acl_a_board', 'cat' => array('CAPTCHA_FUNCAPTCHA')),
			),
		);
	}
}