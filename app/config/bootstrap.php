<?php
/* SVN FILE: $Id: bootstrap.php,v 1.6 2010-09-23 08:38:05 clemens Exp $ */
/**
 * Short description for file.
 *
 * Long description for file
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
 * @since         CakePHP(tm) v 0.10.8.2117
 * @version       $Revision: 1.6 $
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date: 2010-09-23 08:38:05 $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 *
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php is loaded
 * This is an application wide file to load any function that is not used within a class define.
 * You can also use this to include or require any files in your application.
 *
 */
/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * $modelPaths = array('full path to models', 'second full path to models', 'etc...');
 * $viewPaths = array('this path to views', 'second full path to views', 'etc...');
 * $controllerPaths = array('this path to controllers', 'second full path to controllers', 'etc...');
 *
 */

if ( $_SERVER['HTTP_HOST'] == 'localhost' ) 
	define( 'DEBUG', true );

/**
 * default ratios
 * 
 * order is always derived from triathlon, so for tri its swim bike run
 * while for duathlon its bike run
 */
define('RATIO_TRIATHLON', '20,40,40'); // swim bike run
define('RATIO_DUATHLON', '40,60'); // bike run

/**
 * this will define our trainers version to be appended to css files and so forth
 * to prevent browser caching
 */
define('VERSION', '1.0.2');
?>