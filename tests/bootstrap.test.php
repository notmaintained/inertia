<?php


	function test_core_files_()
	{
		$expected_core_basenames = array('handler', 'helper', 'path', 'request', 'response', 'uri', 'webserver');
		$expected_core_files = array_map(create_function('$value', 'return realpath("../").DIRECTORY_SEPARATOR."core".DIRECTORY_SEPARATOR."$value.core.php";'),
		                                $expected_core_basenames);

		should_return($expected_core_files);
	}


	function test_request_method_()
	{
		should_return('PUT', when_passed('put'));
	}

	function test_request_path_()
	{
		should_return('/foo', when_passed('foo'));
		should_return('/foo', when_passed('/foo'));
		should_return('/foo bar', when_passed('/foo bar'));
	}


	function test_request_body_()
	{
        $data = 'hello world';
        should_return($data, when_passed($data));
        should_return(NULL, when_passed(''));
	}


		function test_remove_path_hacks_()
		{
			should_return(array(), when_passed(array('path_'=>'/foo')));
		}

        function test_inertia_default_response_()
        {
			$html = "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n"
			        ."<html>\n<head>\n<title>Inertia Test Page</title>\n</head>\n<body>\n<h1>Inertia Test Page</h1>\n"
			        ."<p><a href=\"http://sandeepshetty.github.com/inertia/\">Inertia</a> has been successfully installed on this system!</p>"
			        ."<p><a href=\"tests/retest.php\">Run all tests</a> and confirm everything passes before you proceed.</p>\n</body>\n</html>";
			should_return(response_(STATUS_OK, array('content-type'=>'text/html'), $html), when_passed('/', ''));


            $html = "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n"
                    ."<html>\n<head>\n<title>404 Not Found</title>\n</head>\n<body>\n<h1>Not Found</h1>\n<p>The requested URL /foo was not found on this server.</p>\n</body>\n</html>";
			should_return(response_(STATUS_NOT_FOUND, array('content-type'=>'text/html'), $html), when_passed('/foo', '/foo'));
        }


		function test_inertia_test_page_()
		{
			$html = "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n"
			        ."<html>\n<head>\n<title>Inertia Test Page</title>\n</head>\n<body>\n<h1>Inertia Test Page</h1>\n"
			        ."<p><a href=\"http://sandeepshetty.github.com/inertia/\">Inertia</a> has been successfully installed on this system!</p>"
			        ."<p><a href=\"tests/retest.php\">Run all tests</a> and confirm everything passes before you proceed.</p>\n</body>\n</html>";
			should_return($html);
		}

        function test_inertia_404_not_found_()
        {
            $html = "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n"
                    ."<html>\n<head>\n<title>404 Not Found</title>\n</head>\n<body>\n<h1>Not Found</h1>\n<p>The requested URL /foo was not found on this server.</p>\n</body>\n</html>";

            should_return($html, when_passed('/foo'));
        }
        
        function test_minimal_html_()
        {
            $html = "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n"
                    ."<html>\n<head>\n<title>Hello</title>\n</head>\n<body>\nHello World\n</body>\n</html>";
            should_return($html, when_passed('Hello', 'Hello World'));
        }

?>