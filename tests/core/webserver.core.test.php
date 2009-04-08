<?php


	function test_webserver_adapter_()
	{
		should_return(realpath('../core/adapters/').DIRECTORY_SEPARATOR.'apache.adapter.php', when_passed('apache'));
	}


	function test_webserver_()
	{
		should_return('apache', when_passed('Apache/2.2.4 (Win32) PHP/5.2.3'));
		should_return('unknown', when_passed('non_existant_web_server'));
	}
	
	function test_select_function_()
	{
		should_return('default_function_to_call', when_passed('test_webserver', 'function_to_call'));

		function test_webserver_function_to_call()
		{
			return;
		}
		
		should_return('test_webserver_function_to_call', when_passed('test_webserver', 'function_to_call'));
	}

?>