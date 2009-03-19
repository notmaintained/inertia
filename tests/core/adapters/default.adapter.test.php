<?php

	function test_default_is_rewrite_engine_on_()
	{
		should_return(false);
	}


	function test_default_request_path_helper_()
	{
		should_return('/', when_passed(array()));
		should_return('/foo', when_passed(array('path_'=>'/foo')));
	}


	function test_extract_request_headers_()
	{
		should_return(array('content-type'=>'text/plain', 'content-length'=>0),
		              when_passed(array('HTTP_CONTENT_TYPE'=>'text/plain', 'HTTP_CONTENT_LENGTH'=>0)));
		should_return(array(), when_passed(array('CONTENT-TYPE'=>'text/plain')));
	}


	function test_default_uri_()
	{
		should_return('http://example.com/index.php?path_=/foo', when_passed('http://example.com/', '/foo'));
		should_return('http://example.com/index.php?path_=/foo&bar=baz', when_passed('http://example.com/', '/foo?bar=baz'));
	}

?>