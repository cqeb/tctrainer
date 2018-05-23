<?php
/**
 * Framework debugging and PHP error-handling class
 *
 * Provides enhanced logging, stack traces, and rendering debug views
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs
 * @since         CakePHP(tm) v 1.2.4560
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Included libraries.
 *
 */
if (!class_exists('Object')) {
	require_once LIBS . 'object.php';
}
if (!class_exists('CakeLog')) {
	require_once LIBS . 'cake_log.php';
}
if (!class_exists('String')) {
	require_once LIBS . 'string.php';
}

/**
 * Provide custom logging and error handling.
 *
 * Debugger overrides PHP's default error handling to provide stack traces and enhanced logging
 *
 * @package       cake
 * @subpackage    cake.cake.libs
 * @link          http://book.cakephp.org/view/1191/Using-the-Debugger-Class
 */
class Debugger extends Object {

/**
 * A list of errors generated by the application.
 *
 * @var array
 * @access public
 */
	var $errors = array();

/**
 * Contains the base URL for error code documentation.
 *
 * @var string
 * @access public
 */
	var $helpPath = null;

/**
 * The current output format.
 *
 * @var string
 * @access protected
 */
	var $_outputFormat = 'js';

/**
 * Templates used when generating trace or error strings.  Can be global or indexed by the format
 * value used in $_outputFormat.
 *
 * @var string
 * @access protected
 */
	var $_templates = array(
		'log' => array(
			'trace' => '{:reference} - {:path}, line {:line}',
			'error' => "{:error} ({:code}): {:description} in [{:file}, line {:line}]"
		),
		'js' => array(
			'error' => '',
			'info' => '',
			'trace' => '<pre class="stack-trace">{:trace}</pre>',
			'code' => '',
			'context' => '',
			'links' => array()
		),
		'html' => array(
			'trace' => '<pre class="cake-debug trace"><b>Trace</b> <p>{:trace}</p></pre>',
			'context' => '<pre class="cake-debug context"><b>Context</b> <p>{:context}</p></pre>'
		),
		'txt' => array(
			'error' => "{:error}: {:code} :: {:description} on line {:line} of {:path}\n{:info}",
			'context' => "Context:\n{:context}\n",
			'trace' => "Trace:\n{:trace}\n",
			'code' => '',
			'info' => ''
		),
		'base' => array(
			'traceLine' => '{:reference} - {:path}, line {:line}'
		)
	);

/**
 * Holds current output data when outputFormat is false.
 *
 * @var string
 * @access private
 */
	var $_data = array();

/**
 * Constructor.
 *
 */
	function __construct() {
		$docRef = ini_get('docref_root');

		if (empty($docRef) && function_exists('ini_set')) {
			ini_set('docref_root', 'http://php.net/');
		}
		if (!defined('E_RECOVERABLE_ERROR')) {
			define('E_RECOVERABLE_ERROR', 4096);
		}
		if (!defined('E_DEPRECATED')) {
			define('E_DEPRECATED', 8192);
		}

		$e = '<pre class="cake-debug">';
		$e .= '<a href="javascript:void(0);" onclick="document.getElementById(\'{:id}-trace\')';
		$e .= '.style.display = (document.getElementById(\'{:id}-trace\').style.display == ';
		$e .= '\'none\' ? \'\' : \'none\');"><b>{:error}</b> ({:code})</a>: {:description} ';
		$e .= '[<b>{:path}</b>, line <b>{:line}</b>]';

		$e .= '<div id="{:id}-trace" class="cake-stack-trace" style="display: none;">';
		$e .= '{:links}{:info}</div>';
		$e .= '</pre>';
		$this->_templates['js']['error'] = $e;

		$t = '<div id="{:id}-trace" class="cake-stack-trace" style="display: none;">';
		$t .= '{:context}{:code}{:trace}</div>';
		$this->_templates['js']['info'] = $t;

		$links = array();
		$link = '<a href="javascript:void(0);" onclick="document.getElementById(\'{:id}-code\')';
		$link .= '.style.display = (document.getElementById(\'{:id}-code\').style.display == ';
		$link .= '\'none\' ? \'\' : \'none\')">Code</a>';
		$links['code'] = $link;

		$link = '<a href="javascript:void(0);" onclick="document.getElementById(\'{:id}-context\')';
		$link .= '.style.display = (document.getElementById(\'{:id}-context\').style.display == ';
		$link .= '\'none\' ? \'\' : \'none\')">Context</a>';
		$links['context'] = $link;

		$links['help'] = '<a href="{:helpPath}{:code}" target="_blank">Help</a>';
		$this->_templates['js']['links'] = $links;

		$this->_templates['js']['context'] = '<pre id="{:id}-context" class="cake-context" ';
		$this->_templates['js']['context'] .= 'style="display: none;">{:context}</pre>';

		$this->_templates['js']['code'] = '<div id="{:id}-code" class="cake-code-dump" ';
		$this->_templates['js']['code'] .= 'style="display: none;"><pre>{:code}</pre></div>';

		$e = '<pre class="cake-debug"><b>{:error}</b> ({:code}) : {:description} ';
		$e .= '[<b>{:path}</b>, line <b>{:line}]</b></pre>';
		$this->_templates['html']['error'] = $e;

		$this->_templates['html']['context'] = '<pre class="cake-debug context"><b>Context</b> ';
		$this->_templates['html']['context'] .= '<p>{:context}</p></pre>';
	}

/**
 * Returns a reference to the Debugger singleton object instance.
 *
 * @return object
 * @access public
 * @static
 */
	function &getInstance($class = null) {
		static $instance = array();
		if (!empty($class)) {
			if (!$instance || strtolower($class) != strtolower(get_class($instance[0]))) {
				$instance[0] = & new $class();
				if (Configure::read() > 0) {
					Configure::version(); // Make sure the core config is loaded
					$instance[0]->helpPath = Configure::read('Cake.Debugger.HelpPath');
				}
			}
		}

		if (!$instance) {
			$instance[0] =& new Debugger();
			if (Configure::read() > 0) {
				Configure::version(); // Make sure the core config is loaded
				$instance[0]->helpPath = Configure::read('Cake.Debugger.HelpPath');
			}
		}
		return $instance[0];
	}

/**
 * Formats and outputs the contents of the supplied variable.
 *
 * @param $var mixed the variable to dump
 * @return void
 * @see Debugger::exportVar()
 * @access public
 * @static
 * @link http://book.cakephp.org/view/1191/Using-the-Debugger-Class
*/
	function dump($var) {
		$_this =& Debugger::getInstance();
		pr($_this->exportVar($var));
	}

/**
 * Creates an entry in the log file.  The log entry will contain a stack trace from where it was called.
 * as well as export the variable using exportVar. By default the log is written to the debug log.
 *
 * @param $var mixed Variable or content to log
 * @param $level int type of log to use. Defaults to LOG_DEBUG
 * @return void
 * @static
 * @link http://book.cakephp.org/view/1191/Using-the-Debugger-Class
 */
	function log($var, $level = LOG_DEBUG) {
		$_this =& Debugger::getInstance();
		$source = $_this->trace(array('start' => 1)) . "\n";
		CakeLog::write($level, "\n" . $source . $_this->exportVar($var));
	}

/**
 * Overrides PHP's default error handling.
 *
 * @param integer $code Code of error
 * @param string $description Error description
 * @param string $file File on which error occurred
 * @param integer $line Line that triggered the error
 * @param array $context Context
 * @return boolean true if error was handled
 * @access public
 */
	function handleError($code, $description, $file = null, $line = null, $context = null) {
		if (error_reporting() == 0 || $code === 2048 || $code === 8192) {
			return;
		}

		$_this =& Debugger::getInstance();

		if (empty($file)) {
			$file = '[internal]';
		}
		if (empty($line)) {
			$line = '??';
		}
		$path = $_this->trimPath($file);

		$info = compact('code', 'description', 'file', 'line');
		if (!in_array($info, $_this->errors)) {
			$_this->errors[] = $info;
		} else {
			return;
		}

		switch ($code) {
			case E_PARSE:
			case E_ERROR:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
			case E_USER_ERROR:
				$error = 'Fatal Error';
				$level = LOG_ERROR;
			break;
			case E_WARNING:
			case E_USER_WARNING:
			case E_COMPILE_WARNING:
			case E_RECOVERABLE_ERROR:
				$error = 'Warning';
				$level = LOG_WARNING;
			break;
			case E_NOTICE:
			case E_USER_NOTICE:
				$error = 'Notice';
				$level = LOG_NOTICE;
			break;
			default:
				return;
			break;
		}

		$helpCode = null;
		if (!empty($_this->helpPath) && preg_match('/.*\[([0-9]+)\]$/', $description, $codes)) {
			if (isset($codes[1])) {
				$helpID = $codes[1];
				$description = trim(preg_replace('/\[[0-9]+\]$/', '', $description));
			}
		}

		$data = compact(
			'level', 'error', 'code', 'helpID', 'description', 'file', 'path', 'line', 'context'
		);
		echo $_this->_output($data);

		if (Configure::read('log')) {
			$tpl = $_this->_templates['log']['error'];
			$options = array('before' => '{:', 'after' => '}');
			CakeLog::write($level, String::insert($tpl, $data, $options));
		}

		if ($error == 'Fatal Error') {
			exit();
		}
		return true;
	}

/**
 * Outputs a stack trace based on the supplied options.
 *
 * ### Options
 *
 * - `depth` - The number of stack frames to return. Defaults to 999
 * - `format` - The format you want the return.  Defaults to the currently selected format.  If
 *    format is 'array' or 'points' the return will be an array.
 * - `args` - Should arguments for functions be shown?  If true, the arguments for each method call
 *   will be displayed.
 * - `start` - The stack frame to start generating a trace from.  Defaults to 0
 *
 * @param array $options Format for outputting stack trace
 * @return mixed Formatted stack trace
 * @access public
 * @static
 * @link http://book.cakephp.org/view/1191/Using-the-Debugger-Class
 */
	function trace($options = array()) {
		$_this =& Debugger::getInstance();
		$defaults = array(
			'depth'   => 999,
			'format'  => $_this->_outputFormat,
			'args'    => false,
			'start'   => 0,
			'scope'   => null,
			'exclude' => null
		);
		$options += $defaults;

		$backtrace = debug_backtrace();
		$count = count($backtrace);
		$back = array();

		$_trace = array(
			'line'     => '??',
			'file'     => '[internal]',
			'class'    => null,
			'function' => '[main]'
		);

		for ($i = $options['start']; $i < $count && $i < $options['depth']; $i++) {
			$trace = array_merge(array('file' => '[internal]', 'line' => '??'), $backtrace[$i]);

			if (isset($backtrace[$i + 1])) {
				$next = array_merge($_trace, $backtrace[$i + 1]);
				$reference = $next['function'];

				if (!empty($next['class'])) {
					$reference = $next['class'] . '::' . $reference . '(';
					if ($options['args'] && isset($next['args'])) {
						$args = array();
						foreach ($next['args'] as $arg) {
							$args[] = Debugger::exportVar($arg);
						}
						$reference .= join(', ', $args);
					}
					$reference .= ')';
				}
			} else {
				$reference = '[main]';
			}
			if (in_array($reference, array('call_user_func_array', 'trigger_error'))) {
				continue;
			}
			if ($options['format'] == 'points' && $trace['file'] != '[internal]') {
				$back[] = array('file' => $trace['file'], 'line' => $trace['line']);
			} elseif ($options['format'] == 'array') {
				$back[] = $trace;
			} else {
				if (isset($_this->_templates[$options['format']]['traceLine'])) {
					$tpl = $_this->_templates[$options['format']]['traceLine'];
				} else {
					$tpl = $_this->_templates['base']['traceLine'];
				}
				$trace['path'] = Debugger::trimPath($trace['file']);
				$trace['reference'] = $reference;
				unset($trace['object'], $trace['args']);
				$back[] = String::insert($tpl, $trace, array('before' => '{:', 'after' => '}'));
			}
		}

		if ($options['format'] == 'array' || $options['format'] == 'points') {
			return $back;
		}
		return implode("\n", $back);
	}

/**
 * Shortens file paths by replacing the application base path with 'APP', and the CakePHP core
 * path with 'CORE'.
 *
 * @param string $path Path to shorten
 * @return string Normalized path
 * @access public
 * @static
 */
	function trimPath($path) {
		if (!defined('CAKE_CORE_INCLUDE_PATH') || !defined('APP')) {
			return $path;
		}

		if (strpos($path, APP) === 0) {
			return str_replace(APP, 'APP' . DS, $path);
		} elseif (strpos($path, CAKE_CORE_INCLUDE_PATH) === 0) {
			return str_replace(CAKE_CORE_INCLUDE_PATH, 'CORE', $path);
		} elseif (strpos($path, ROOT) === 0) {
			return str_replace(ROOT, 'ROOT', $path);
		}
		$corePaths = App::core('cake');

		foreach ($corePaths as $corePath) {
			if (strpos($path, $corePath) === 0) {
				return str_replace($corePath, 'CORE' .DS . 'cake' .DS, $path);
			}
		}
		return $path;
	}

/**
 * Grabs an excerpt from a file and highlights a given line of code
 *
 * @param string $file Absolute path to a PHP file
 * @param integer $line Line number to highlight
 * @param integer $context Number of lines of context to extract above and below $line
 * @return array Set of lines highlighted
 * @access public
 * @static
 * @link http://book.cakephp.org/view/1191/Using-the-Debugger-Class
 */
	function excerpt($file, $line, $context = 2) {
		$data = $lines = array();
		if (!file_exists($file)) {
			return array();
		}
		$data = @explode("\n", file_get_contents($file));

		if (empty($data) || !isset($data[$line])) {
			return;
		}
		for ($i = $line - ($context + 1); $i < $line + $context; $i++) {
			if (!isset($data[$i])) {
				continue;
			}
			$string = str_replace(array("\r\n", "\n"), "", highlight_string($data[$i], true));
			if ($i == $line) {
				$lines[] = '<span class="code-highlight">' . $string . '</span>';
			} else {
				$lines[] = $string;
			}
		}
		return $lines;
	}

/**
 * Converts a variable to a string for debug output.
 *
 * @param string $var Variable to convert
 * @return string Variable as a formatted string
 * @access public
 * @static
 * @link http://book.cakephp.org/view/1191/Using-the-Debugger-Class
 */
	function exportVar($var, $recursion = 0) {
		$_this =& Debugger::getInstance();
		switch (strtolower(gettype($var))) {
			case 'boolean':
				return ($var) ? 'true' : 'false';
			break;
			case 'integer':
			case 'double':
				return $var;
			break;
			case 'string':
				if (trim($var) == "") {
					return '""';
				}
				return '"' . h($var) . '"';
			break;
			case 'object':
				return get_class($var) . "\n" . $_this->__object($var);
			case 'array':
				$var = array_merge($var,  array_intersect_key(array(
					'password' => '*****',
					'login'  => '*****',
					'host' => '*****',
					'database' => '*****',
					'port' => '*****',
					'prefix' => '*****',
					'schema' => '*****'
				), $var));

				$out = "array(";
				$vars = array();
				foreach ($var as $key => $val) {
					if ($recursion >= 0) {
						if (is_numeric($key)) {
							$vars[] = "\n\t" . $_this->exportVar($val, $recursion - 1);
						} else {
							$vars[] = "\n\t" .$_this->exportVar($key, $recursion - 1)
										. ' => ' . $_this->exportVar($val, $recursion - 1);
						}
					}
				}
				$n = null;
				if (!empty($vars)) {
					$n = "\n";
				}
				return $out . implode(",", $vars) . "{$n})";
			break;
			case 'resource':
				return strtolower(gettype($var));
			break;
			case 'null':
				return 'null';
			break;
		}
	}

/**
 * Handles object to string conversion.
 *
 * @param string $var Object to convert
 * @return string
 * @access private
 * @see Debugger::exportVar()
 */
	function __object($var) {
		$out = array();

		if (is_object($var)) {
			$className = get_class($var);
			$objectVars = get_object_vars($var);

			foreach ($objectVars as $key => $value) {
				if (is_object($value)) {
					$value = get_class($value) . ' object';
				} elseif (is_array($value)) {
					$value = 'array';
				} elseif ($value === null) {
					$value = 'NULL';
				} elseif (in_array(gettype($value), array('boolean', 'integer', 'double', 'string', 'array', 'resource'))) {
					$value = Debugger::exportVar($value);
				}
				$out[] = "$className::$$key = " . $value;
			}
		}
		return implode("\n", $out);
	}

/**
 * Switches output format, updates format strings
 *
 * @param string $format Format to use, including 'js' for JavaScript-enhanced HTML, 'html' for
 *    straight HTML output, or 'txt' for unformatted text.
 * @param array $strings Template strings to be used for the output format.
 * @access protected
 */
	function output($format = null, $strings = array()) {
		$_this =& Debugger::getInstance();
		$data = null;

		if (is_null($format)) {
			return $_this->_outputFormat;
		}

		if (!empty($strings)) {
			if (isset($_this->_templates[$format])) {
				if (isset($strings['links'])) {
					$_this->_templates[$format]['links'] = array_merge(
						$_this->_templates[$format]['links'],
						$strings['links']
					);
					unset($strings['links']);
				}
				$_this->_templates[$format] = array_merge($_this->_templates[$format], $strings);
			} else {
				$_this->_templates[$format] = $strings;
			}
			return $_this->_templates[$format];
		}

		if ($format === true && !empty($_this->_data)) {
			$data = $_this->_data;
			$_this->_data = array();
			$format = false;
		}
		$_this->_outputFormat = $format;

		return $data;
	}

/**
 * Renders error messages
 *
 * @param array $data Data about the current error
 * @access private
 */
	function _output($data = array()) {
		$defaults = array(
			'level' => 0,
			'error' => 0,
			'code' => 0,
			'helpID' => null,
			'description' => '',
			'file' => '',
			'line' => 0,
			'context' => array()
		);
		$data += $defaults;

		$files = $this->trace(array('start' => 2, 'format' => 'points'));
        if(!isset($files[0]['file'])) return;
		$code = $this->excerpt($files[0]['file'], $files[0]['line'] - 1, 1);
		$trace = $this->trace(array('start' => 2, 'depth' => '20'));
		$insertOpts = array('before' => '{:', 'after' => '}');
		$context = array();
		$links = array();
		$info = '';

		foreach ((array)$data['context'] as $var => $value) {
			$context[] = "\${$var}\t=\t" . $this->exportVar($value, 1);
		}

		switch ($this->_outputFormat) {
			case false:
				$this->_data[] = compact('context', 'trace') + $data;
				return;
			case 'log':
				$this->log(compact('context', 'trace') + $data);
				return;
		}

		if (empty($this->_outputFormat) || !isset($this->_templates[$this->_outputFormat])) {
			$this->_outputFormat = 'js';
		}

		$data['id'] = 'cakeErr' . count($this->errors);
		$tpl = array_merge($this->_templates['base'], $this->_templates[$this->_outputFormat]);
		$insert = array('context' => join("\n", $context), 'helpPath' => $this->helpPath) + $data;

		$detect = array('help' => 'helpID', 'context' => 'context');

		if (isset($tpl['links'])) {
			foreach ($tpl['links'] as $key => $val) {
				if (isset($detect[$key]) && empty($insert[$detect[$key]])) {
					continue;
				}
				$links[$key] = String::insert($val, $insert, $insertOpts);
			}
		}

		foreach (array('code', 'context', 'trace') as $key) {
			if (empty($$key) || !isset($tpl[$key])) {
				continue;
			}
			if (is_array($$key)) {
				$$key = join("\n", $$key);
			}
			$info .= String::insert($tpl[$key], compact($key) + $insert, $insertOpts);
		}
		$links = join(' | ', $links);
		unset($data['context']);

		echo String::insert($tpl['error'], compact('links', 'info') + $data, $insertOpts);
	}

/**
 * Verifies that the application's salt and cipher seed value has been changed from the default value.
 *
 * @access public
 * @static
 */
	function checkSecurityKeys() {
		if (Configure::read('Security.salt') == 'DYhG93b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi') {
			trigger_error(__('Please change the value of \'Security.salt\' in app/config/core.php to a salt value specific to your application', true), E_USER_NOTICE);
		}

		if (Configure::read('Security.cipherSeed') === '76859309657453542496749683645') {
			trigger_error(__('Please change the value of \'Security.cipherSeed\' in app/config/core.php to a numeric (digits only) seed value specific to your application', true), E_USER_NOTICE);
		}
	}

/**
 * Invokes the given debugger object as the current error handler, taking over control from the
 * previous handler in a stack-like hierarchy.
 *
 * @param object $debugger A reference to the Debugger object
 * @access public
 * @static
 * @link http://book.cakephp.org/view/1191/Using-the-Debugger-Class
 */
	function invoke(&$debugger) {
		set_error_handler(array(&$debugger, 'handleError'));
	}
}

if (!defined('DISABLE_DEFAULT_ERROR_HANDLING')) {
	Debugger::invoke(Debugger::getInstance());
}
