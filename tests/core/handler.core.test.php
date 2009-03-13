<?php

	function test_handler_basedir_()
	{
		$basedir = handler_basedir_();

        should_return(realpath('../handlers').DIRECTORY_SEPARATOR);
        
		$path = DIRECTORY_SEPARATOR.'foo'.DIRECTORY_SEPARATOR.'bar';        
		should_return($path.DIRECTORY_SEPARATOR, when_passed($path));
		should_return($path.DIRECTORY_SEPARATOR, when_passed($path.DIRECTORY_SEPARATOR));
        should_return($path.DIRECTORY_SEPARATOR);
		
		handler_basedir_($basedir);
	}


	function test_handler_info_()
	{
		should_return(array('dir'=>handler_basedir_().'foo'.DIRECTORY_SEPARATOR.'bar'.DIRECTORY_SEPARATOR, 'basename'=>'bar'),
		              when_passed('foo/bar'));
		should_return(array('dir'=>handler_basedir_().'foo'.DIRECTORY_SEPARATOR, 'basename'=>'foo'),
		              when_passed('foo'));
	}


	function test_handler_file_()
	{
		should_return(handler_basedir_().'foo'.DIRECTORY_SEPARATOR.'foo.handler.php', when_passed('foo'));
		should_return(handler_basedir_().'foo'.DIRECTORY_SEPARATOR.'bar'.DIRECTORY_SEPARATOR.'bar.handler.php', when_passed('foo/bar'));
        should_return(handler_basedir_().'foo-bar'.DIRECTORY_SEPARATOR.'foo-bar.handler.php', when_passed('foo-bar'));
	}


	function test_handler_function_()
	{
		should_return('foo_handler', when_passed('foo'));
		should_return('foo_bar_handler', when_passed('foo/bar'));
		should_return('foo_bar_baz_handler', when_passed('foo/bar/baz'));
        should_return('foo_bar_baz_handler', when_passed('foo-bar/baz'));
	}


	function test_handler_exists_()
	{
		$handler = 'testhandler'.rand();
		should_return(false, when_passed($handler));

		testhelper_create_handler_($handler);
		should_return(handler_basedir_().$handler.DIRECTORY_SEPARATOR."$handler.handler.php", when_passed($handler));
		
        testhelper_remove_handler_($handler);
	}
		function testhelper_create_handler_($handler)
		{
			mkdir(handler_basedir_().$handler.DIRECTORY_SEPARATOR);
			touch(handler_basedir_().$handler.DIRECTORY_SEPARATOR."$handler.handler.php");
		}
		
		function testhelper_remove_handler_($handler)
		{
			unlink(handler_basedir_().$handler.DIRECTORY_SEPARATOR."$handler.handler.php");
			rmdir(handler_basedir_().$handler.DIRECTORY_SEPARATOR);
		}


	function test_load_handler_()
	{
		$handler = 'testhandler'.rand();
		testhelper_create_handler_($handler);
		should_return(1, when_passed($handler));
        
		testhelper_remove_handler_($handler);
	}


?>