<?php

/**
 *
 * @package phpBB Extension - Funcaptcha
 * @copyright (c) 2013 phpBB Group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace swipeads\funcaptcha\migrations;

class release_1_0_0 extends \phpbb\db\migration\migration {

    public function effectively_installed() {
        return isset($this->config['funcaptcha_public_key']);
    }

    static public function depends_on() {
        return array('\phpbb\db\migration\data\v310\alpha2');
    }

    public function update_data() {
        return array(
            array('config.add', array('funcaptcha_theme', 0)),
            array('config.add', array('funcaptcha_security', 0)),
            array('config.add', array('funcaptcha_lightbox', 1)),
            array('config.add', array('funcaptcha_javascript', 0)),
            array('config.add', array('funcaptcha_public_key', '')),
            array('config.add', array('funcaptcha_private_key', '')),
            array('config.add', array('funcaptcha_proxy', '')),
            array('config.add', array('funcaptcha_number_posts', 0)),
            array('module.add', array(
                    'acp',
                    'ACP_CAT_DOT_MODS',
                    'CAPTCHA_FUNCAPTCHA'
                )),
            array('module.add', array(
                    'acp',
                    'CAPTCHA_FUNCAPTCHA',
                    array(
                        'module_basename' => '\swipeads\funcaptcha\acp\main_module',
                        'modes' => array('settings', 'features'),
                    ),
                )),
        );
    }

}
