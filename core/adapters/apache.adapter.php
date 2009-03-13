<?php

/* apache.adapter.php
 *
 * function email($str){return preg_replace('/^(.*)\/(.*)/', '$2@$1', $str);}
 * Authors: Sandeep Shetty email('gmail.com/sandeep.shetty')
 *
 * Copyright (C) 2005 - date('Y') Collaboration Science,
 * http://collaborationscience.com/
 *
 * This file is part of Inertia.
 *
 * Inertia is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * Inertia is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 * 
 * To read the license please visit http://www.gnu.org/copyleft/gpl.html
 *
 *
 *-------10--------20--------30--------40--------50--------60---------72
 */


	function apache_is_rewrite_engine_on_()
	{
		return apache_is_rewrite_engine_on_helper_(server_var_('REWRITE_ENGINE'));
	}
		function apache_is_rewrite_engine_on_helper_($rewrite_engine)
		{
			return is_equal_('on', strtolower($rewrite_engine));
		}


	function apache_request_path_()
	{
		if (!apache_is_rewrite_engine_on_()) return default_request_path_();
		return apache_request_path_helper_(server_var_('REQUEST_URI'), uri_path_(server_var_('PHP_SELF')));
	}
		function apache_request_path_helper_($request_uri, $path_to_index_dot_php)
		{
			$path = substr($request_uri, strlen($path_to_index_dot_php));
			list($path, ) = (str_contains_('?', $path)) ? explode('?', $path, 2) : array($path, '');
			return $path;
		}


	function apache_request_headers_()
	{
		if (!function_exists('apache_request_headers')) return default_request_headers_();
		return apache_request_headers();
	}


	function apache_uri_($base_uri, $path)
	{
		if (!apache_is_rewrite_engine_on_()) return default_uri_($base_uri, $path);
		return apache_uri_helper_($base_uri, $path);

	}
		function apache_uri_helper_($base_uri, $path)
		{
			assert(substr($base_uri, -1) == '/');
			return $base_uri.ltrim($path, '/');
		}

?>