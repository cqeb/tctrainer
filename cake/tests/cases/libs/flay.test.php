<?php
/* SVN FILE: $Id: flay.test.php,v 1.1 2010-07-12 19:52:09 klaus Exp $ */
/**
 * TestFlay file
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
 * @subpackage    cake.tests.cases.libs
 * @since         CakePHP(tm) v 1.2.0.5432
 * @version       $Revision: 1.1 $
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date: 2010-07-12 19:52:09 $
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
uses('flay');
/**
 * FlayTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs
 */
class FlayTest extends CakeTestCase {
/**
 * skip method
 *
 * @access public
 * @return void
 */
	function skip() {
		$this->skipIf(true, '%s FlayTest not implemented');
	}
}
?>