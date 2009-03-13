<?php


	function default_request_($handler, $method, $path, $query, $headers, $body)
	{
		if (handler_exists_($handler))
		{
			load_handler_($handler);
			if ($handler_function = function_exists_(handler_function_($handler)))
			{
				$params = array($method, $path, $query, $headers, $body);
				$response = call_user_func_array($handler_function, $params);
				return valid_response_($response);
			}
		}

		return response_(STATUS_NOT_FOUND);
	}

?>