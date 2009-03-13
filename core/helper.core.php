<?php

/* helper.core.php
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


	function slashes_to_directory_separator_($path)
	{
		return preg_replace('/[\/\\\]/', DIRECTORY_SEPARATOR, $path);
	}


	function str_contains_($needle, $haystack)
	{
		return (strpos($haystack, $needle) !== false);
	}


	function str_underscorize_($str)
	{
		return preg_replace('/[^a-zA-Z0-9]/', '_', $str);
	}


	function str_sanitize_($str)
	{
		return htmlspecialchars($str, ENT_QUOTES);
	}


	function is_equal_($var1, $var2)
	{
		return ($var1 == $var2);
	}


	function server_var_($key)
	{
		if (isset($_SERVER[$key]))
		{
			return $_SERVER[$key];
		}
		elseif (isset($_ENV[$key]))
		{
			return $_ENV[$key];
		}
		elseif ($val = getenv($key))
		{
			return $val;
		}

		return NULL;
	}


	function file_exists_($file_path)
	{
		return file_exists($file_path) ? $file_path : false;
	}


	function function_exists_($func_name)
	{
		return function_exists($func_name) ? $func_name : false;
	}


	function array_keys_exists_($keys, $search_array)
	{
		foreach ($keys as $key)
		{
			if (!array_key_exists($key, $search_array))
			{
				return false;
			}
		}

		return true;
	}

 ?>