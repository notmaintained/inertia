<?php

	function test_handler_info_()
	{
		should_return(array('dir'=>INERTIA_HANDLERS_DIR.'foo'.DIRECTORY_SEPARATOR.'bar'.DIRECTORY_SEPARATOR, 'basename'=>'bar'),
		              when_passed('foo/bar'));
		should_return(array('dir'=>INERTIA_HANDLERS_DIR.'foo'.DIRECTORY_SEPARATOR, 'basename'=>'foo'),
		              when_passed('foo'));
	}


	function test_handler_file_()
	{
		should_return(INERTIA_HANDLERS_DIR.'foo'.DIRECTORY_SEPARATOR.'foo.handler.php', when_passed('foo'));
		should_return(INERTIA_HANDLERS_DIR.'foo'.DIRECTORY_SEPARATOR.'bar'.DIRECTORY_SEPARATOR.'bar.handler.php', when_passed('foo/bar'));
        should_return(INERTIA_HANDLERS_DIR.'foo-bar'.DIRECTORY_SEPARATOR.'foo-bar.handler.php', when_passed('foo-bar'));
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
		should_return(INERTIA_HANDLERS_DIR.$handler.DIRECTORY_SEPARATOR."$handler.handler.php", when_passed($handler));
		
        testhelper_remove_handler_($handler);
	}
		function testhelper_create_handler_($handler)
		{
			mkdir(INERTIA_HANDLERS_DIR.$handler.DIRECTORY_SEPARATOR);
			touch(INERTIA_HANDLERS_DIR.$handler.DIRECTORY_SEPARATOR."$handler.handler.php");
		}
		
		function testhelper_remove_handler_($handler)
		{
			unlink(INERTIA_HANDLERS_DIR.$handler.DIRECTORY_SEPARATOR."$handler.handler.php");
			rmdir(INERTIA_HANDLERS_DIR.$handler.DIRECTORY_SEPARATOR);
		}


	function test_load_handler_()
	{
		$handler = 'testhandler'.rand();
		testhelper_create_handler_($handler);
		should_return(1, when_passed($handler));
        
		testhelper_remove_handler_($handler);
	}


?>