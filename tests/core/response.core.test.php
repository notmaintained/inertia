<?php

	function test_response_reason_phrase_()
	{
		should_return('Not Found', when_passed('404'));
		should_return('', when_passed('5000'));
	}


	function test_response_()
	{
		should_return(array('status_code' => 200,
		                    'headers' => array(),
		                    'body' => ''), when_passed(200, ''));
		should_return(array('status_code' => 200,
		                    'headers' => array('x-foo' => 'bar'),
		                    'body' => ''), when_passed(200, array('X-FOO'=>'bar')));
		should_return(array('status_code' => 200,
		                    'headers' => array('content-type' => 'text/plain'),
		                    'body' => ''), when_passed(200, array('content-type' => 'text/plain')));
	}


	function test_valid_response_()
	{
		should_return(array('status_code' => 200,
		                    'headers' => array('content-type' => 'application/x-php-value'),
		                    'body' => ''), when_passed(''));
		should_return(array('status_code' => 200,
		                    'headers' => array('content-type' => 'application/x-php-value'),
		                    'body' => ''), when_passed(array('status_code' => 200, 'headers' => array(), 'body' => '')));
		should_return(array('status_code' => 200,
		                    'headers' => array('content-type' => 'application/x-php-value'),
		                    'body' => array('foo')),
		              when_passed(array('status_code' => 200,
		                                'headers' => array('content-type' => 'application/x-serialized-php'),
		                                'body' => serialize(array('foo')))));
	}


	function test_prepare_external_response_()
	{
		should_return(array('status_code'=>200,
		                    'headers'=>array('content-type'=>'text/plain'),
		                    'body'=>''),
		              when_passed(testhelper_response_returned_by_request_(STATUS_OK, array())));
					  
		should_return(array('status_code'=>200,
		                    'headers'=>array('content-type'=>'text/plain'),
		                    'body'=>'foo'),
		              when_passed(testhelper_response_returned_by_request_(STATUS_OK, array(), 'foo')));
					  
		should_return(array('status_code'=>200,
		                    'headers'=>array('content-type'=>'application/x-serialized-php'),
		                    'body'=>'a:1:{i:0;s:3:"foo";}'),
		              when_passed(testhelper_response_returned_by_request_(STATUS_OK, array(), array('foo'))));
					  
		should_return(array('status_code'=>200,
		                    'headers'=>array('content-type'=>'text/plain'),
		                    'body'=>'foo'),
		              when_passed(testhelper_response_returned_by_request_(STATUS_OK, array('content-type'=>'text/plain'), 'foo')));
					  
		should_return(array('status_code'=>200,
		                    'headers'=>array('content-type'=>'application/x-serialized-php'),
		                    'body'=>'a:1:{i:0;s:3:"foo";}'),
		              when_passed(testhelper_response_returned_by_request_(STATUS_OK,
                                                            array('content-type'=>'application/x-serialized-php'),
                                                            'a:1:{i:0;s:3:"foo";}')));
	}
    
        function testhelper_response_returned_by_request_($status_code, $headers=array(), $body='')
        {
            return valid_response_(response_($status_code, $headers, $body));
        }


	function test_response_is_valid_()
	{
		should_return(false, when_passed(''));
		should_return(false, when_passed(array('status_code' => 200, 'headers' => '', 'body' => '')));
		should_return(true, when_passed(array('status_code' => 200, 'headers' => array(), 'body' => '')));
		should_return(false, when_passed(array('headers' => array(), 'body' => '')));
		should_return(false, when_passed(array('status_code' => 200, 'body' => '')));
		should_return(false, when_passed(array('status_code' => 200, 'headers' => array())));
		should_return(true, when_passed(array('status_code' => 200, 'headers' => array(), 'body' => '', 'foo'=>'bar')));
	}


?>