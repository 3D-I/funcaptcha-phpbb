<?php
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'FUNCAPTCHA_LANGUAGE'		=> 'en',
	'FUNCAPTCHA_MESSAGE_NA'		=> 'In order to use FUNCAPTCHA, you must create an account on <a href="https://www.FUNCAPTCHA.com">www.FUNCAPTCHA.com</a>',
	'FUNCAPTCHA_MESSAGE_A'		=> 'Please logout from the admin control panel and check all forms protected by FUNCAPTCHA',
	'CAPTCHA_FUNCAPTCHA'		=> 'FUNCAPTCHA',
	'FUNCAPTCHA_MESSAGE_INCORRECT'	=> 'The solution of task you submitted was incorrect. Please read the instruction and try again.',
	'FUNCAPTCHA_CODE_FIELD_CAPTION'	=> 'FUNCAPTCHA code',
	'FUNCAPTCHA_CODE_FIELD_CAPTION_EXPLAIN'			=> 'You can find this code in "My sites" section at <a href="https://www.FUNCAPTCHA.com">www.FUNCAPTCHA.com</a><br />(Please note that "My sites" section is available only for users who are logged in)',
	'FUNCAPTCHA_SITE_PRIVATE_KEY_FIELD_CAPTION'		=> 'Private key',
	'FUNCAPTCHA_SITE_PRIVATE_KEY_FIELD_CAPTION_EXPLAIN'	=> 'You can generate this key in "My sites" section at <a href="https://www.FUNCAPTCHA.com" target="_blank">www.FUNCAPTCHA.com</a><br />(Please note that "My sites" section is available only for users who are logged in)',
	'FUNCAPTCHA_MESSAGE_NOSCRIPT'	=> '<b>You should turn on JavaScript on your browser. After that please reload the page.<br />Otherwise you won&#039;t be able to post any information on this site</b>.',
	'FUNCAPTCHA_TASK_HEADER'	=> 'Anti-spam',
	'FUNCAPTCHA_TASK_EXPLAIN'	=> 'Complete the task',
        'FUNCAPTCHA_FIELD_THEME_CAPTION'	=> 'FunCaptcha Theme',
        'FUNCAPTCHA_FIELD_THEME_EXPLAIN'	=> 'This will change the appearance of FunCaptcha (see here for what they look like)',
        'FUNCAPTCHA_FIELD_SECURITY_CAPTION'	=> 'FunCaptcha Security Level',
        'FUNCAPTCHA_FIELD_SECURITY_EXPLAIN'	=> 'If you choose Automatic, security starts at the lowest level, and rises and falls automatically, adjusted by FunCaptcha\'s monitoring system. The Enhanced level has more challenges to solve, but is very hard for spammer programs to get past',
        'FUNCAPTCHA_FIELD_MODE_CAPTION'	=> 'FunCaptcha Lightbox Mode',
        'FUNCAPTCHA_FIELD_MODE_EXPLAIN'	=> 'Lightbox mode will show FunCaptcha once the user submits your form, rather than on the page. Inline mode will show FunCaptcha on your page as the user completes your form. We recommend Lightbox for the best user experience',
        'FUNCAPTCHA_FIELD_FALLBACK_CAPTION'	=> 'Javascript Fallback',
        'FUNCAPTCHA_FIELD_FALLBACK_EXPLAIN'	=> 'If the user does not have Javascript enabled, display a fallback CAPTCHA? (Most bots have Javascript disabled, we recommend you leave this disabled):',
        'FUNCAPTCHA_FIELD_PUBLIC_CAPTION'	=> 'FunCaptcha Public Key',
        'FUNCAPTCHA_FIELD_PUBLIC_EXPLAIN'	=> 'Public Key (Register for this below)',
        'FUNCAPTCHA_FIELD_PRIVATE_CAPTION'	=> 'FunCaptcha Private Key',
        'FUNCAPTCHA_FIELD_PRIVATE_EXPLAIN'	=> 'Private Key (Register for this below)',
        'FUNCAPTCHA_FIELD_PROXY_CAPTION'	=> 'Optional - Proxy Server ',
        'FUNCAPTCHA_FIELD_PROXY_EXPLAIN'	=> 'This field is optional - Proxy server (including port, eg: 111.11.11.111:8080)',
        'FUNCAPTCHA_FIELD_POSTS_CAPTION'	=> 'Number of posts',
        'FUNCAPTCHA_FIELD_POSTS_EXPLAIN'	=> 'Enter the number of posts until you want to show human verification to new user. Enter 0 if you want to disable this option',
        'FUNCAPTCHA_WEBSITE'	=> 'FUNCAPTCHA KEYS',
        'FUNCAPTCHA_SECURITY_AUTOMATIC'	=> 'Automatic',
        'FUNCAPTCHA_SECURITY_ENHANCED'	=> 'Always Enhanced',
        'FUNCAPTCHA_LIGHTBOX_INLINE'	=> 'Inline',
        'FUNCAPTCHA_LIGHTBOX_ON'	=> 'Lightbox',
        'FUNCAPTCHA_FALLBACK_DISABLE'	=> 'Disable',
        'FUNCAPTCHA_FALLBACK_ENABLE'	=> 'Enable',
    ));
?>