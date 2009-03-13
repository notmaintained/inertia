<?php

/* index.php
 * 
 * Down the Rabbit-Hole...
 *
 * function email($str){return preg_replace('/^(.*)\/(.*)/', '$2@$1', $str);}
 * Authors: Sandeep Shetty email('gmail.com/sandeep.shetty')
 *
 * Copyright (C) 2005 - date('Y') Collaboration Science,
 * http://collaborationscience.com/
 *
 * This file is part of Inertia.
 *
 * Inertia is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option)
 * any later version.
 *
 * Inertia is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * To read the license please visit http://www.gnu.org/copyleft/gpl.html
 *
 *
 *----------------------------------------------------------------------------
 */


	define('INERTIA_VERSION', '0.3.0');

	php_min_version_guard_('4.3.0');

		function php_min_version_guard_($min_php_version)
		{
			$is_min_php_version = (function_exists('version_compare') and
								   version_compare(PHP_VERSION,  $min_php_version, '>='));

			if (!$is_min_php_version)
			{
				echo "ERROR: Older version of PHP. Current version of PHP is ".PHP_VERSION.". Please upgrade to PHP $min_php_version.";
				exit;
			}
		}

	require './bootstrap.php';

	$response = bootstrap_inertia_(request_method_(server_var_('REQUEST_METHOD')),
	                               request_path_(webserver_specific_('request_path_')),
	                               $_GET,
	                               webserver_specific_('request_headers_'),
	                               request_body_(file_get_contents('php://input')));
	flush_response_($response);

?>