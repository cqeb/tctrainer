<?php
/* SVN FILE: $Id: view.group.php,v 1.1 2010-07-12 19:51:54 klaus Exp $ */
/**
 * ViewsGroupTest file
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
 * @subpackage    cake.tests.groups
 * @since         CakePHP(tm) v 1.2.0.4206
 * @version       $Revision: 1.1 $
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date: 2010-07-12 19:51:54 $
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
/**
 * ViewsGroupTest class
 *
 * This test group will run view class tests (view, theme)
 *
 * @package       cake
 * @subpackage    cake.tests.groups
 */
class ViewsGroupTest extends GroupTest {
/**
 * label property
 *
 * @var string 'All core views'
 * @access public
 */
	var $label = 'View and ThemeView';
/**
 * ViewsGroupTest method
 *
 * @access public
 * @return void
 */
	function ViewsGroupTest() {
		TestManager::addTestFile($this, CORE_TEST_CASES . DS . 'libs' . DS . 'view' . DS . 'view');
		TestManager::addTestFile($this, CORE_TEST_CASES . DS . 'libs' . DS . 'view' . DS . 'theme');
	}
}
?>