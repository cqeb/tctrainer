<?php
/* SVN FILE: $Id: counter_cache_post_fixture.php,v 1.1 2010-07-12 19:51:32 klaus Exp $ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <https://trac.cakephp.org/wiki/Developement/TestSuite>
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 *  Licensed under The Open Group Test Suite License
 *  Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          https://trac.cakephp.org/wiki/Developement/TestSuite CakePHP(tm) Tests
 * @package       cake
 * @subpackage    cake.tests.fixtures
 * @since         CakePHP(tm) v 1.2.0.4667
 * @version       $Revision: 1.1 $
 * @modifiedby    $LastChangedBy: renan.saddam $
 * @lastmodified  $Date: 2010-07-12 19:51:32 $
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
/**
 * Short description for class.
 *
 * @package       cake
 * @subpackage    cake.tests.fixtures
 */
class CounterCachePostFixture extends CakeTestFixture {

	var $name = 'CounterCachePost';
    
	var $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'title' => array('type' => 'string', 'length' => 255, 'null' => false),
		'user_id' => array('type' => 'integer', 'null' => true),
	);

    var $records = array(
		array('id' => 1, 'title' => 'Rock and Roll',  'user_id' => 66),
		array('id' => 2, 'title' => 'Music',   'user_id' => 66),
		array('id' => 3, 'title' => 'Food',   'user_id' => 301),
    );
}

?>