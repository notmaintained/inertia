<?php

	function test_uri_scheme_()
	{
		should_return('http', when_passed(NULL));
		should_return('https', when_passed('on'));
	}


	function test_uri_host_()
	{
		should_return('127.0.0.1', when_passed('127.0.0.1'));
		should_return('127.0.0.1', when_passed('127.0.0.1:80'));
	}


	function test_uri_port_()
	{
		should_return('', when_passed('127.0.0.1'));
		should_return('80', when_passed('127.0.0.1:80'));
	}


	function test_uri_path_()
	{
		should_return('/inertia', when_passed('/inertia/index.php'));
		should_return('', when_passed('/index.php'));
	}


	function test_uri_absolute_base_()
	{
		should_return('http://example.com/inertia/', when_passed('http', 'example.com', '', '/inertia'));
		should_return('http://example.com:80/inertia/', when_passed('http', 'example.com', '80', '/inertia'));
		should_return('http://example.com/', when_passed('http', 'example.com', '', ''));
	}

	function test_uri_relative_base_()
	{
		should_return('/', when_passed(''));
		should_return('/inertia/', when_passed('/inertia'));
	}

?>