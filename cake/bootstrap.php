<?php
/* SVN FILE: $Id: bootstrap.php,v 1.1 2010-07-12 19:52:12 klaus Exp $ */
/**
 * Basic Cake functionality.
 *
 * Core functions for including other source files, loading models and so forth.
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
 * @subpackage    cake.cake
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 1.1 $
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date: 2010-07-12 19:52:12 $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
if (!defined('PHP5')) {
	define('PHP5', (PHP_VERSION >= 5));
}
if (!defined('E_DEPRECATED')) {
	define('E_DEPRECATED', 8192);
}
error_reporting(E_ALL & ~E_DEPRECATED);
/**
 * Configuration, directory layout and standard libraries
 */
	if (!isset($bootstrap)) {
		require CORE_PATH . 'cake' . DS . 'basics.php';
		$TIME_START = getMicrotime();
		require CORE_PATH . 'cake' . DS . 'config' . DS . 'paths.php';
		require LIBS . 'object.php';
		require LIBS . 'inflector.php';
		require LIBS . 'configure.php';
	}
	require LIBS . 'cache.php';

	Configure::getInstance();

	$url = null;

	App::import('Core', array('Dispatcher'));
?>