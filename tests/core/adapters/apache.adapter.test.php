<?php


	function test_apache_is_rewrite_engine_on_helper_()
	{
		should_return(true, when_passed('on'));
		should_return(true, when_passed('ON'));
		should_return(false, when_passed('foo'));
		should_return(false, when_passed(NULL));
	}

	function test_apache_request_path_helper_()
	{
		should_return('/foo', when_passed('/foo', ''));
		should_return('/foo', when_passed('/inertia/foo', '/inertia'));
		should_return('/foo', when_passed('/inertia/foo?bar=baz', '/inertia'));
	}


	function test_apache_uri_helper_()
	{
		should_return('http://example.com/foo', when_passed('http://example.com/', '/foo'));
		should_return('http://example.com/foo', when_passed('http://example.com/', 'foo'));
	}

?>
