<?php

/* handler.core.php
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




	function handler_basedir_($dir=NULL)
	{
		static $handlers_dir;

		if (is_null($dir))
		{
			if (isset($handlers_dir))
			{
				return $handlers_dir;
			}
			else
			{
				return INERTIA_INSTALL_DIR.'handlers'.DIRECTORY_SEPARATOR;
			}
		}
		else
		{
			$dir = rtrim($dir, DIRECTORY_SEPARATOR);
			$handlers_dir = $dir.DIRECTORY_SEPARATOR;
			return $handlers_dir;
		}
	}


	function handler_info_($handler)
	{
		$handler = slashes_to_directory_separator_($handler);
		$parts = explode(DIRECTORY_SEPARATOR, $handler);
		$handler_basename = array_pop($parts);
		$handler_path = empty($parts) ? '' : implode(DIRECTORY_SEPARATOR, $parts).DIRECTORY_SEPARATOR;
		$handler_dir = handler_basedir_().$handler_path.$handler_basename.DIRECTORY_SEPARATOR;
		return array('dir'=>$handler_dir, 'basename'=>$handler_basename);
	}


	function handler_file_($handler)
	{
		$handler = handler_info_($handler);
		return $handler['dir']."{$handler['basename']}.handler.php";
	}


	function handler_function_($handler)
	{
		$handler = str_underscorize_($handler);
		return "{$handler}_handler";
	}


	function handler_exists_($handler)
	{
		return file_exists_(handler_file_($handler));
	}


	function load_handler_($handler)
	{
		return require_once handler_file_($handler);
	}

?>