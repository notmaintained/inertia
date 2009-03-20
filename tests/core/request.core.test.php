<?php


	function test_wrapper_files_()
	{
		$expected_wrapper_basenames = array('default', 'http', 'https');
		$expected_wrapper_files = array_map(create_function('$value', 'return realpath("../").DIRECTORY_SEPARATOR."core".DIRECTORY_SEPARATOR."wrappers".DIRECTORY_SEPARATOR."$value.wrapper.php";'),
		                                $expected_wrapper_basenames);

		should_return($expected_wrapper_files);
	}

	function test_calling_handler_()
	{
		should_return('bar', when_passed(array(array('function'=>'foo'),
		                                       array('function'=>'bar_handler'))));
		should_return('foo_bar', when_passed(array(array('function'=>'foo'),
		                                           array('function'=>'foo_bar_handler'))));
		should_return(false, when_passed(array(array('function'=>'foo'),
		                                       array('function'=>'bar'))));
	}


	function test_get_conf_()
	{
        $conf_file = handler_basedir_().'testconf'.rand().'.conf.php';
        $conf_var = 'testconf'; 
        
        should_return(array(), when_passed($conf_var));
		should_return(array(), when_passed($conf_var, $conf_file));
        
        testhelper_create_conf_file_($conf_file, $conf_var);
		should_return(array(array('handler'=>'example', 'from'=>'', 'to'=>'application')), when_passed($conf_var, $conf_file));
        should_return(array(array('handler'=>'example', 'from'=>'', 'to'=>'application')), when_passed($conf_var));
        
        testhelper_remove_conf_file_($conf_file);
        
        testhelper_create_empty_conf_file_($conf_file);
        should_return(array(), when_passed($conf_var, $conf_file));
        should_return(array(), when_passed($conf_var));
        
        testhelper_remove_conf_file_($conf_file);
        
	}

        function testhelper_create_conf_file_($conf_file, $conf_var)
        {
            $var_str = var_export(array('handler'=>'example', 'from'=>'', 'to'=>'application'), true);
            $proxies = "<?php\n\n\$".$conf_var."[] = $var_str;\n\n?>";
            return file_put_contents($conf_file, $proxies);
        }
        
        function testhelper_create_empty_conf_file_($conf_file)
        {
            touch($conf_file);
        }
        
        function testhelper_remove_conf_file_($conf_file)
        {
            return unlink($conf_file);
        }


    function test_proxies_conf_file_()
    {
        should_return('/foo/bar/proxies.conf.php', when_passed('/foo/bar/'));
    }


    function test_aliases_conf_file_()
    {
        should_return('/foo/bar/aliases.conf.php', when_passed('/foo/bar/'));
    }


	function test_resolve_alias_()
	{
		should_return('foo', when_passed('foo', array()));
        should_return('bar', when_passed('foo', array(array('name'=>'foo', 'handler'=>'bar'))));
	}


	function test_x_inertia_headers_()
	{
		should_return(array('content-type'=>'application/x-www-form-urlencoded',
                            'x-referer-handler'=>'foo',
                            'x-form-vars'=>array('foo'=>'bar')),
                      when_passed('foo', METHOD_PUT, array('content-type'=>'application/x-www-form-urlencoded'), 'foo=bar'));
                      
        should_return(array('content-type'=>'application/x-www-form-urlencoded',
                            'x-referer-handler'=>'foo',
                            'x-form-vars'=>array('foo'=>'bar')),
                      when_passed('foo', METHOD_POST, array('content-type'=>'application/x-www-form-urlencoded'), 'foo=bar'));
                      
        should_return(array('x-referer-handler'=>'foo'),
                      when_passed('foo', METHOD_POST, array(), 'foo=bar'));
                      
        should_return(array('x-referer-handler'=>'foo'),
                      when_passed('foo', METHOD_GET, array(), ''));
                      
        should_return(array('cookie'=>'foo=bar;baz=qux',
                            'x-referer-handler'=>'foo',
                            'x-cookie-vars'=>array('foo'=>'bar', 'baz'=>'qux')),
                      when_passed('foo', METHOD_GET, array('cookie'=>'foo=bar;baz=qux'), ''));
	}

        function test_payload_exists_()
        {
            should_return(true, when_passed(METHOD_POST, 'Hello world'));
            should_return(true, when_passed(METHOD_PUT, 'Hello world'));
            should_return(false, when_passed(METHOD_POST, ''));
            should_return(false, when_passed(METHOD_GET, 'Hello world'));
        }


        function test_is_form_urlencoded_()
        {
            should_return(true, when_passed('application/x-www-form-urlencoded'));
            should_return(false, when_passed('text/plain'));
        }


        function test_parse_parameters_()
        {
            should_return(array(), when_passed(''));
            should_return(array('foo'=>'bar', 'baz'=>'qux'), when_passed('foo=bar;baz=qux'));
            should_return(array(0=>'quux', 1=>'garply', 2=>'waldo'), when_passed('quux;garply;waldo'));		
            should_return(array('foo'=>'bar', 'baz'=>'qux', 0=>'quux', 'corge'=>'grault', 1=>'garply', 2=>'waldo'),
                          when_passed('foo=bar;baz=qux;quux;corge=grault;garply;waldo'));
        }


        function test_is_proxy_request_()
        {
            should_return(true, when_passed(array('handler', '/')));
            should_return(false, when_passed(array('/')));
            should_return(false, when_passed('/'));
        }
        
        function test_detect_proxy_()
        {
            should_return(array('application', '/'),
                          when_passed('', 'application', '/', array()));
                          
            should_return(array('example', array('application', '/')), 
                          when_passed('', 'application', '/', array(array('handler'=>'example', 'from'=>'', 'to'=>'application'))));
                          
            should_return(array('example', array('application', '/')), 
                          when_passed('', 'application', '/', array(array('handler'=>'example', 'from'=>'*', 'to'=>'application'))));
                          
            should_return(array('example', array('application', '/')), 
                          when_passed('', 'application', '/', array(array('handler'=>'example', 'from'=>'', 'to'=>'*'))));
                          
            should_return(array('example', array('application', '/')), 
                          when_passed('', 'application', '/', array(array('handler'=>'example', 'from'=>'*', 'to'=>'*'))));
                          
            should_return(array('bar', '/'), 
                          when_passed('foo', 'bar', '/', array(array('handler'=>'example', 'from'=>'', 'to'=>'application'))));

            should_return(array('example', array('bar', array('baz', '/'))), 
                          when_passed('foo', 'bar', array('baz', '/'), array(array('handler'=>'example', 'from'=>'foo', 'to'=>'bar'))));
        }
        
        function test_dispatch_request_()
        {
            $handler = 'testhandler'.rand();
            should_return(response_(STATUS_NOT_FOUND),
                          when_passed($handler, METHOD_GET, '/', array(), array(), ''));
                          
            testhelper_create_handler_($handler);
            testhelper_write_handler_function_($handler);
            should_return(valid_response_(response_(STATUS_OK)),
                          when_passed($handler, METHOD_GET, '/', array(), array(), ''));
            testhelper_remove_handler_($handler);
        }
        
            function testhelper_write_handler_function_($handler)
            {
                file_put_contents(handler_basedir_().$handler.DIRECTORY_SEPARATOR."$handler.handler.php", '<?php function '.$handler.'_handler($method, $path, $query, $headers, $body) {} ?>');
            }
        
        function test_prepend_path_with_slash_()
        {
            should_return('/foo', when_passed('/foo'));
            should_return('/foo', when_passed('/foo'));
            should_return(array('foo', '/bar'), when_passed(array('foo', 'bar')));
            should_return(array('foo', array('bar', '/baz')), when_passed(array('foo', array('bar', 'baz'))));
        }

?>