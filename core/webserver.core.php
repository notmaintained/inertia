<?php

/* webserver.core.php
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


	define('INERTIA_WEB_SERVER', webserver_(server_var_('SERVER_SOFTWARE')));

	require_webserver_adapter_(webserver_adapter_('default'));
	require_webserver_adapter_(webserver_adapter_(INERTIA_WEB_SERVER));

	function require_webserver_adapter_($webserver_adapter)
	{
		if (file_exists($webserver_adapter)) require_once $webserver_adapter;
	}

		function webserver_adapter_($webserver)
		{//TODO: delete port line
			return INERTIA_INSTALL_DIR.'core'.DIRECTORY_SEPARATOR.'adapters'.DIRECTORY_SEPARATOR.$webserver.'.adapter.php';
		}


	function webserver_($server_software)
	{
		/* Sandeep: PHP Platforms

		   An entry must be made in $server_softwares to support a
		   particular web server platform. Below you will find some of
		   the platform I could find on the web.

		   From php.net:
		   Apache, Caudium, fhttpd, IIS/PWS, Netscape, iPlanet, SunONE,
		   OmniHTTPd, Oreilly Website Pro, Sambar, Xitami, Monkey,
		   Abyss, Robin hood, LiteServe, fnord, Stronghold.

		   Platforms from a conference slide by Rasmus:
		   Apache module (UNIX,Win32), CGI/FastCGI, thttpd, fhttpd,
		   phttpd, ISAPI (IIS, Zeus), NSAPI (Netscape iPlanet), Java
		   servlet, AOLServer, Roxen/Caudium module,
		   Script Running Machine.

		   These servers might be non-PHP related:
		   Enterprise, Cougar, WebObjects, Oracle_Web_listener, Zope. */

		$server_softwares = array('Apache'        => 'apache',
		                          'Microsoft-IIS' => 'iis',
		                          'Microsoft-PWS' => 'pws',
		                          'Xitami'        => 'xitami',
		                          'Zeus'          => 'zeus',
		                          'OmniHTTPd'     => 'omnihttpd');

		foreach ($server_softwares as $key=>$value)
		{
			if (str_contains_($key, $server_software))
			{
				return $value;
			}
		}

		return 'unknown';
	}


	function webserver_specific_()
	{
		$params = func_get_args();
		$func = array_shift($params);
		return call_user_func_array(select_function_($func, INERTIA_WEB_SERVER), $params);
	}
		function select_function_($func, $webserver)
		{
			if (($selected_func = function_exists_("{$webserver}_{$func}")) or
				 ($selected_func = "default_{$func}"))
			{
				return $selected_func;
			}
		}

?>