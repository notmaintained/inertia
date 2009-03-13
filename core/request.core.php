<?php

/* request.core.php
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


	define('METHOD_GET', 'GET');
	define('METHOD_POST', 'POST');
	define('METHOD_PUT', 'PUT');
	define('METHOD_DELETE', 'DELETE');
	define('METHOD_HEAD', 'HEAD');

	require_wrappers_();

		function require_wrappers_()
		{
			foreach (wrapper_files_() as $file) require $file;
		}
			function wrapper_files_()
			{
				return glob(INERTIA_INSTALL_DIR.'core'.DIRECTORY_SEPARATOR.'wrappers'.DIRECTORY_SEPARATOR.'*.wrapper.php');
			}


	function calling_handler_($backtrace)
	{
		foreach ($backtrace as $function_call)
		{
			if (preg_match('/^(\w+)_handler$/', $function_call['function'])/* and handler_exists_($matches[1])*/)
			{
				return preg_replace('/^(\w+)_handler$/', '\1', $function_call['function']);
			}
		}

		return false;
	}


	function get_conf_($conf_var, $conf_file=false)
	{
        static $conf_vars;
        
        if (!$conf_file) return isset($conf_vars[$conf_var]) ? $conf_vars[$conf_var] : array();
        
		if (file_exists($conf_file))
		{
			require $conf_file;
            if (isset($$conf_var))
            {
                return $conf_vars[$conf_var] = $$conf_var;
            }
            else
            {
                $conf_vars[$conf_var] = array();
            }
		}

		return array();
	}
    
    function proxies_conf_file_($handler_basedir)
    {
        return "{$handler_basedir}proxies.conf.php";
    }


    function aliases_conf_file_($handler_basedir)
    {
        return "{$handler_basedir}aliases.conf.php";
    }


	function resolve_alias_($handler, $aliases)
	{
        foreach ($aliases as $alias)
        {
            if (is_equal_($handler, $alias['name']))
            {
                return $alias['handler'];
            }
        }

		return $handler;
	}

//TODO: Maybe this shud be broken up into smaller functions
	function x_inertia_headers_($referer, $method, $headers, $body)
	{
		$headers['x-referer-handler'] = $referer;

		if (array_key_exists('cookie', $headers))
		{
			$headers['x-cookie-vars'] = parse_parameters_($headers['cookie']);
		}

		if (payload_exists_($method, $body))
		{
			if (array_key_exists('content-type', $headers))
			{
				if (is_form_urlencoded_($headers['content-type']))
				{
					parse_str($body, $headers['x-form-vars']);
				}
			}
		}

		return $headers;
	}

        function payload_exists_($method, $body)
        {
            return (is_equal_(METHOD_POST, $method) or is_equal_(METHOD_PUT, $method)) and !empty($body);
        }


        function is_form_urlencoded_($content_type)
        {
            return is_equal_('application/x-www-form-urlencoded', $content_type);
        }


        function parse_parameters_($parameters)
        {
            $params = array();
            if (!empty($parameters))
            {
                $pieces = explode(';', $parameters);
                foreach ($pieces as $piece)
                {
                    if (str_contains_('=', $piece))
                    {
                        list($key, $value) = explode('=', $piece);
                        $params[trim(rawurldecode($key))] = trim(rawurldecode($value));
                    }
                    else
                    {
                        $params[] = trim(rawurldecode($piece));
                    }
                }
            }

            return $params;
        }


	function request_($handler, $method, $path, $query, $headers, $body=NULL)
	{
		$referer = calling_handler_(debug_backtrace());
        $path = prepend_path_with_slash($path);

		$headers = array_change_key_case($headers, CASE_LOWER);
		$headers = x_inertia_headers_($referer, $method, $headers, $body);
        
        $proxies = get_conf_('proxies', proxies_conf_file_(handler_basedir_()));
        list($handler, $path) = detect_proxy_($referer, $handler, $path, $proxies);

        $aliases = get_conf_('aliases', aliases_conf_file_(handler_basedir_()));
		$handler = resolve_alias_($handler, $aliases);
        
        return dispatch_request_($handler, $method, $path, $query, $headers, $body);
	}

        function is_proxy_request_($path)
        {
            return (is_array($path) and is_equal_(count($path), 2)); 
        }
        
        function detect_proxy_($referer, $handler, $path, $proxies)
        {
			foreach ($proxies as $proxy)
			{
				if (isset($proxy['from']) and isset($proxy['to']))
				{
					$from_matches = (is_equal_($proxy['from'], $referer) or is_equal_('*', $proxy['from']));
					$to_matches = (is_equal_($proxy['to'], $handler) or is_equal_('*', $proxy['to']));
					$is_self = is_equal_($proxy['handler'], $referer);
					if ($from_matches and $to_matches and !$is_self)
					{
						//$path = is_proxy_request_($path) ? $path : array($handler, $path);
                        $path = array($handler, $path);
                        $handler = $proxy['handler'];
                        break;
					}
				}
			}
            
            return array($handler, $path);
        }
        
        function dispatch_request_($handler, $method, $path, $query, $headers, $body)
        {
			$params = get_defined_vars();
			$wrapper = 'default';

			if (str_contains_('://', $handler))
			{
				list($wrapper, ) = explode($handler);
			}

			return wrapper_request_($wrapper, $params);
        }
			function wrapper_request_($wrapper, $params)
			{
				return call_user_func_array("{$wrapper}_request_", $params);
			}

        function prepend_path_with_slash($path)
        {
            if (is_array($path))
            {
                $path[1] = prepend_path_with_slash($path[1]);
                return $path;
            }
            else return '/'.ltrim($path, '/');
        }


?>