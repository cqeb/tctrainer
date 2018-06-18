<?php
/* SVN FILE: $Id: core.php,v 1.9 2010-10-08 19:23:52 clemens Exp $ */
/**
 * This is core configuration file.
 *
 * Use it to configure core behavior of Cake.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 1.9 $
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date: 2010-10-08 19:23:52 $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * CakePHP Debug Level:
 *
 * Production Mode:
 * 	0: No error messages, errors, or warnings shown. Flash messages redirect.
 *
 * Development Mode:
 * 	1: Errors and warnings shown, model caches refreshed, flash messages halted.
 * 	2: As in 1, but also with full debug messages and SQL output.
 * 	3: As in 2, but also with full controller dump.
 *
 * In production mode, flash messages redirect after a time interval.
 * In development mode, you need to click the flash message to continue.
 */

define('LOCALHOST', 'local2.tricoretraining.com');
define('TESTHOST', 'test.tricoretraining.com');
define('TESTHOST2', 'thetriplans.com');

define('LANGCOOKIE', 'tct_language');
define('BLOGCOOKIE', 'tct_auth_blog');

$DEBUGLOG = '';

if ( $_SERVER['HTTP_HOST'] == LOCALHOST )
{ 
	/**
	 * Defines the default error type when using the log() function. Used for
	 * differentiating error logging and debugging. Currently PHP supports LOG_DEBUG.
	 */
	define('DEBUG', true);
	define('LOG_ERROR', 3);
	Configure::write('debug', 3);
	define('MYIP', '127.0.0.1');

	Configure::write('App.mailHost', 'relay-hosting.secureserver.net');
	Configure::write('App.hostUrl', 'http://' . LOCALHOST);

	$_SERVER['DOCUMENT_ROOT'] = '/Applications/XAMPP/xamppfiles/htdocs/tricoretraining.com/';

} elseif ( $_SERVER['HTTP_HOST'] == TESTHOST ) {
	define('DEBUG', false);
	define('LOG_ERROR', 0);	
	Configure::write('debug', 0);
	define('MYIP', '89.144.214.43');

	Configure::write('App.mailHost', 'business36.web-hosting.com');
	Configure::write('App.hostUrl', 'https://' . TESTHOST);	

	$_SERVER['DOCUMENT_ROOT'] = '/home/schrlnek/' . TESTHOST . '/';

} elseif ( $_SERVER['HTTP_HOST'] == TESTHOST2 ) {
	define('DEBUG', false);
	define('LOG_ERROR', 0);	
	Configure::write('debug', 0);
	define('MYIP', '89.144.214.220');

	Configure::write('App.mailHost', 'business36.web-hosting.com');
	Configure::write('App.hostUrl', 'https://' . TESTHOST);	

	$_SERVER['DOCUMENT_ROOT'] = '/home/schrlnek/' . TESTHOST . '/';

} else {
	define('DEBUG', false);
	define('LOG_ERROR', 0);	
	Configure::write('debug', 0);

	define('MYIP', '89.144.214.220');

	Configure::write('App.mailHost', 'business36.web-hosting.com');
	Configure::write('App.hostUrl', 'https://tricoretraining.com');	
	
	$_SERVER['DOCUMENT_ROOT'] = '/home/schrlnek/tricoretraining.com/';
	
}

if ($_SERVER['REMOTE_ADDR'] == MYIP) {
	define('DEBUG', true);
	define('LOG_ERROR', 3);
	Configure::write('debug', 3);
	//echo "debug";
}

define('url', '/trainer');

/**
 * Application wide charset encoding
 */
Configure::write('App.encoding', 'UTF-8');

/**
 * To configure CakePHP *not* to use mod_rewrite and to
 * use CakePHP pretty URLs, remove these .htaccess
 * files:
 *
 * /.htaccess
 * /app/.htaccess
 * /app/webroot/.htaccess
 *
 * And uncomment the App.baseUrl below:
 */

// Upload Directory must be writeable for web-user
Configure::write('App.uploadDir', $_SERVER['DOCUMENT_ROOT'] . 'trainer/app/webroot/files/');
// Paypal payment email
Configure::write('App.paymentemail', 'payment@tricoretraining.com');

/**
 * mail sending options
 */
Configure::write('App.mailFrom', 'Klaus-M. from TriCoreTraining <support@tricoretraining.com>');
Configure::write('App.mailAdmin', 'support@tricoretraining.com');
Configure::write('App.mailPort', '25');
Configure::write('App.mailUser', '');
Configure::write('App.mailPassword', '');
Configure::write('App.mailDelivery', 'mail');

// rename this variable
Configure::write('App.serverUrl', '/trainer');
// Domain with protocol and NO trailing slash

Configure::write('App.Dirbackslash', false);
	
Configure::write('price_eur', '"5.90","15.90","30.90","59.90"');
Configure::write('price_eur_month', '"5.90","5.30","5.15","4.99"');

Configure::write('price_usd', '"5.90","15.90","30.90","59.90"');
Configure::write('price_usd_month', '"5.90","5.30","5.15","4.99"');

Configure::write('tct_price_eur', '"0.10","0.30","0.60","1.20"');
Configure::write('tct_price_eur_month', '"0.10","0.10","0.10","0.10"');

Configure::write('company_price_eur', '"4.13","12.39","24.78","49.56"');
Configure::write('company_price_eur_month', '"4.13","4.13","4.13","4.13"');

Configure::write('company_price_usd', '"4.13","12.39","24.78","49.56"');
Configure::write('company_price_usd_month', '"4.13","4.13","4.13","4.13"');

Configure::write('company_emails', '"@growtf.com","@schremser.com"');

/**
 * Uncomment the define below to use CakePHP admin routes.
 *
 * The value of the define determines the name of the route
 * and its associated controller actions:
 *
 * 'admin' 		-> admin_index() and /admin/controller/index
 * 'superuser' -> superuser_index() and /superuser/controller/index
 */
//Configure::write('Routing.admin', 'admin');

/**
 * The preferred session handling method. Valid values:
 *
 * 'php'	 		Uses settings defined in your php.ini.
 * 'cake'		Saves session files in CakePHP's /tmp directory.
 * 'database'	Uses CakePHP's database sessions.
 *
 * To define a custom session handler, save it at /app/config/<name>.php.
 * Set the value of 'Session.save' to <name> to utilize it in CakePHP.
 *
 * To use database sessions, execute the SQL file found at /app/config/sql/sessions.sql.
 *
 */
Configure::write('Session.save', 'php');
/**
 * The name of the table used to store CakePHP database sessions.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 *
 * The table name set here should *not* include any table prefix defined elsewhere.
 */
//Configure::write('Session.table', 'cake_sessions');
/**
 * The DATABASE_CONFIG::$var to use for database session handling.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 */
//Configure::write('Session.database', 'default');


/**
 * The name of CakePHP's session cookie.
 */
// cookie topic with domain.com, .domain.com 
// https://stackoverflow.com/questions/18492576/share-cookie-between-subdomain-and-domain

Configure::write('Session.cookie', 'TCTCookie');

Configure::write('Session.path', '/');

if ($_SERVER['HTTP_HOST'] == LOCALHOST) {
	
	Configure::write('Session.domain', LOCALHOST);

} elseif ($_SERVER['HTTP_HOST'] == TESTHOST) {

	Configure::write('Session.domain', TESTHOST);

} elseif ($_SERVER['HTTP_HOST'] == TESTHOST2) {

	Configure::write('Session.domain', TESTHOST2);

} else {

	Configure::write('Session.domain', 'tricoretraining.com');

}

/**
 * Session time out time (in seconds).
 * Actual value depends on 'Security.level' setting.
 */
$session_timeout = Configure::read('Session_longterm');

if (  $session_timeout == "true" )
	Configure::write('Session.timeout', '300');
else
	Configure::write('Session.timeout', '20');

/**
 * If set to false, sessions are not automatically started.
 */
Configure::write('Session.start', true);
/**
 * When set to false, HTTP_USER_AGENT will not be checked
 * in the session
 */
Configure::write('Session.checkAgent', true);

/**
 * The level of CakePHP security. The session timeout time defined
 * in 'Session.timeout' is multiplied according to the settings here.
 * Valid values:
 *
 * 'high'	Session timeout in 'Session.timeout' x 10
 * 'medium'	Session timeout in 'Session.timeout' x 100
 * 'low'	Session timeout in 'Session.timeout' x 300
 *
 * CakePHP session IDs are also regenerated between requests if
 * 'Security.level' is set to 'high'.
 */
Configure::write('Security.level', 'medium');
/**
 * A random string used in security hashing methods.
 */
Configure::write('Security.salt', 'LKLKJsfasafwerwer972498349724923479234DYhG93b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi');

// app/config/my_session.php
//
// Revert value and get rid of the referrer check even when,
// Security.level is medium
// ini_restore('session.referer_check');

// ini_set('session.use_trans_sid', 0);
// ini_set('session.name', Configure::read('Session.cookie'));

// Cookie is now destroyed when browser is closed, doesn't
// persist for days as it does by default for security
// low and medium
// ini_set('session.cookie_lifetime', 0);

// Cookie path is now '/' even if you app is within a sub
// directory on the domain
// $this->path = '/';
// ini_set('session.cookie_path', $this->path);

// Session cookie now persists across all subdomains
// ini_set('session.cookie_domain', env('HTTP_BASE'));



/**
 * Compress CSS output by removing comments, whitespace, repeating tags, etc.
 * This requires a/var/cache directory to be writable by the web server for caching.
 * and /vendors/csspp/csspp.php
 *
 * To use, prefix the CSS link URL with '/ccss/' instead of '/css/' or use HtmlHelper::css().
 */
//Configure::write('Asset.filter.css', 'css.php');
/**
 * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
 * output, and setting the config below to the name of the script.
 *
 * To use, prefix your JavaScript link URLs with '/cjs/' instead of '/js/' or use JavaScriptHelper::link().
 */
//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');
/**
 * The classname and database used in CakePHP's
 * access control lists.
 */
Configure::write('Acl.classname', 'DbAcl');
Configure::write('Acl.database', 'default');
/**
 * If you are on PHP 5.3 uncomment this line and correct your server timezone
 * to fix the date & time related errors.
 */

//date_default_timezone_set('UTC');
/**
 *
 * Cache Engine Configuration
 * Default settings provided below
 *
 * File storage engine.
 *
 */
 /**
 * Enable cache checking.
 *
 * If set to true, for view caching you must still use the controller
 * var $cacheAction inside your controllers to define caching settings.
 * You can either set it controller-wide by setting var $cacheAction = true,
 * or in each action using $this->cacheAction = true.
 *
 */

Configure::write('Cache.check', true);

/**
 * Turn off all caching application-wide.
 *
 */
if ( $_SERVER['HTTP_HOST'] == LOCALHOST ) {
	Configure::write('Cache.disable', true);
} else {
	Configure::write('Cache.disable', true);
}

 /*
 Cache::config('default', array(
 		'engine' => 'File', //[required]
 		'duration'=> 10, //[optional]
 		'probability'=> 100, //[optional]
  		'path' => '/Applications/XAMPP/htdocs/tricoretraining.com/tmp', //[optional] use system tmp directory - remember to use absolute path
  		'prefix' => 'cake_', //[optional]  prefix every cache file with this string
  		'lock' => false, //[optional]  use file locking
  		'serialize' => true //[optional]
));
*/

 /*
 *
 * APC (http://pecl.php.net/package/APC)
 *
 *
 *	Cache::config('default', array(
 * 		'engine' => 'Apc', //[required]
 * 		'duration'=> 3600, //[optional]
 * 		'probability'=> 100, //[optional]
 *  		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 * 	));
 
 * 
 *  Xcache (http://xcache.lighttpd.net/)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Xcache', //[required]
 *		'duration'=> 3600, //[optional]
 *		'probability'=> 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional] prefix every cache file with this string
 *		'user' => 'user', //user from xcache.admin.user settings
 *      'password' => 'password', //plaintext password (xcache.admin.pass)
 *	));
 *
 *
 * Memcache (http://www.danga.com/memcached/)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Memcache', //[required]
 *		'duration'=> 3600, //[optional]
 *		'probability'=> 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 * 		'servers' => array(
 * 			'127.0.0.1:11211' // localhost, default port 11211
 * 		), //[optional]
 * 		'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
 *	));
 *
 */

//// Cache::config('default', array('engine' => 'File'));

?>
