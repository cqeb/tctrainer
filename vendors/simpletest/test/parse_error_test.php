<?php
// $Id: parse_error_test.php,v 1.1 2010-07-12 19:51:36 klaus Exp $
require_once('../unit_tester.php');
require_once('../reporter.php');

$test = &new TestSuite('This should fail');
$test->addFile('test_with_parse_error.php');
$test->run(new HtmlReporter());
?>