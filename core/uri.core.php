<?php

/* uri.core.php
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


	define('INERTIA_SCHEME', uri_scheme_(server_var_('HTTPS')));
	define('INERTIA_HOST', uri_host_(server_var_('HTTP_HOST')));
	define('INERTIA_PORT', uri_port_(server_var_('HTTP_HOST')));
	define('INERTIA_PATH', uri_path_(server_var_('PHP_SELF')));
	define('INERTIA_ABSOLUTE_BASE_URI', uri_absolute_base_(INERTIA_SCHEME, INERTIA_HOST, INERTIA_PORT, INERTIA_PATH));
	define('INERTIA_RELATIVE_BASE_URI', uri_relative_base_(INERTIA_PATH));


		function uri_scheme_($https)
		{
			$ssl = !is_null($https) and is_equal_('on', $https);
			$scheme = $ssl ? 'https' : 'http';
			return $scheme;
		}


		function uri_host_($http_host)
		{
			if (str_contains_(':', $http_host)) $host = array_shift(explode(':', $http_host));
			else $host = $http_host;
			return str_sanitize_($host);
		}


		function uri_port_($http_host)
		{
			if (!str_contains_(':', $http_host)) return '';
			else $port = array_pop(explode(':', $http_host));
			return str_sanitize_($port);
		}


		function uri_path_($index_dot_php_path)
		{
			$base_path = dirname($index_dot_php_path);
			$base_path_equals_directory_separator = (is_equal_(strlen($base_path), 1) and is_equal_(DIRECTORY_SEPARATOR, $base_path));

			return $base_path_equals_directory_separator ? '' : str_sanitize_($base_path);
		}


		function uri_absolute_base_($inertia_scheme, $inertia_host, $inertia_port, $inertia_path)
		{
			$port = empty($inertia_port) ? '' : ":$inertia_port";
			$base_uri = "$inertia_scheme://$inertia_host$port$inertia_path/";
			return str_sanitize_($base_uri);
		}

		
		function uri_relative_base_($inertia_path)
		{
			return "$inertia_path/";
		}



	//TODO: shud take $query, $fragment - for all *uri_ functions below
	function inertia_absolute_uri_($path=NULL)
	{
		$base_uri = uri_absolute_base_(INERTIA_SCHEME, INERTIA_HOST, INERTIA_PORT, INERTIA_PATH);
		return webserver_specific_('uri_', $base_uri, $path);
	}

	function inertia_relative_uri_($path=NULL)
	{
		$base_uri = uri_relative_base_(INERTIA_PATH);
		return webserver_specific_('uri_', $base_uri, $path);
	}

?>