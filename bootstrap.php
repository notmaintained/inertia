<?php

/* bootstrap.php
 * 
 * Curiouser and curiouser!
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


	define('INERTIA_INSTALL_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);
	define('INERTIA_BOOTSTRAP_HANDLER', 'application');

	fix_magic_quotes_gpc_();
	require_core_files_();

		function fix_magic_quotes_gpc_()
		{
			$funcname = 'array_stripslashes_';

			if (get_magic_quotes_gpc())
			{
				array_walk($_GET, $funcname);
				array_walk($_POST, $funcname);
				array_walk($_COOKIE, $funcname);
				array_walk($_REQUEST, $funcname);
			}
		}

			function array_stripslashes_(&$value)
			{
				$value = is_array($value) ? array_walk($value, __FUNCTION__) : stripslashes($value);
			}


		function require_core_files_()
		{
			foreach (core_files_() as $file) require $file;
		}
			function core_files_()
			{
				return glob(INERTIA_INSTALL_DIR.'core'.DIRECTORY_SEPARATOR.'*.core.php');
			}




	function request_method_($method)
	{
        return strtoupper($method);
	}


	function request_path_($path)
	{
		return str_sanitize_(rawurldecode('/'.ltrim($path, '/')));
	}


	function request_body_($body)
	{
        return empty($body) ? NULL : $body;
	}




	function bootstrap_inertia_($method, $path, $query, $headers, $body)
	{
		$query = remove_path_hacks_($query);

		if (handler_exists_(INERTIA_BOOTSTRAP_HANDLER))
		{
			return request_(INERTIA_BOOTSTRAP_HANDLER, $method, $path, $query, $headers, $body);
		}
        else
        {
            return inertia_default_response_($path, inertia_relative_uri_($path));
        }
	}
		function remove_path_hacks_($query)
		{
			if (isset($query['path_']))
			{
				unset($query['path_']);
			}
			
			return $query;
		}

		function inertia_default_response_($path, $relative_uri)
		{
			if (is_equal_('/', $path))
			{
				return response_(STATUS_OK, array('content-type'=>'text/html'), inertia_test_page_());
			}
			else
			{
				return response_(STATUS_NOT_FOUND, array('content-type'=>'text/html'), inertia_404_not_found_($relative_uri));
			}
		}

		function inertia_test_page_()
		{
			$title = 'Inertia Test Page';
			$content = "<h1>$title</h1>\n"
			           ."<p><a href=\"http://sandeepshetty.github.com/inertia/\">Inertia</a> has been successfully installed on this system!</p>"
			           ."<p><a href=\"tests/retest.php\">Run all tests</a> and confirm everything passes before you proceed.</p>";
			return minimal_html_($title, $content);
		}
		
		function inertia_404_not_found_($relative_uri)
		{
			$title = '404 Not Found';
			$content = "<h1>Not Found</h1>\n<p>The requested URL $relative_uri"
					   ." was not found on this server.</p>";
			return minimal_html_($title, $content);
		}
			function minimal_html_($title, $content)
			{
				return "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n"
					   ."<html>\n<head>\n<title>$title</title>\n</head>\n<body>\n$content\n</body>\n</html>";
			}

?>