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
        $handler = 'testhandler'.rand();
$html=<<<HTML
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
<head>
<title>Inertia Test Page</title>
</head>
<body>
<h1>Inertia Test Page</h1>
<p>If you can see this page, it means that the installation of <a href="http://inertia.sourceforge.net/">Inertia</a> on this system was successful.</p>
</body>
</html>
HTML;
		should_return(response_(STATUS_OK, array('content-type'=>'text/html'), $html), when_passed('/', ''));

$html=<<<HTML
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
<head>
<title>404 Not Found</title>
</head>
<body>
<h1>Not Found</h1>\n<p>The requested URL /foo was not found on this server.</p>
</body>
</html>
HTML;
        should_return(response_(STATUS_NOT_FOUND, array('content-type'=>'text/html'), $html), when_passed('/foo', '/foo'));
        }


        function test_inertia_test_page_()
        {
$html=<<<HTML
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
<head>
<title>Inertia Test Page</title>
</head>
<body>
<h1>Inertia Test Page</h1>
<p>If you can see this page, it means that the installation of <a href="http://inertia.sourceforge.net/">Inertia</a> on this system was successful.</p>
</body>
</html>
HTML;
            should_return($html);
        }
        
        function test_inertia_404_not_found_()
        {
            $uri = '/foo';
$html=<<<HTML
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
<head>
<title>404 Not Found</title>
</head>
<body>
<h1>Not Found</h1>\n<p>The requested URL $uri was not found on this server.</p>
</body>
</html>
HTML;
            should_return($html, when_passed($uri));
        }
        
        function test_minimal_html_()
        {
            $title = 'Hello';
            $content = 'Hello World';
            $html = "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n"
                    ."<html>\r\n<head>\r\n<title>Hello</title>\r\n</head>\r\n<body>\r\nHello World\r\n</body>\r\n</html>";
            should_return($html, when_passed($title, $content));
        }

?>