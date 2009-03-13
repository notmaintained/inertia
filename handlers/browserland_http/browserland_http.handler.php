<?php

	function browserland_http_handler($method, $path, $query, $headers, $body)
	{
        print_r(get_defined_vars());
        //TODO
		//check for put hack mode
        //check for delete hack mode
        //change $method for both the hacks
        //change $path to the identifier_ for put hack
        //remove hacks from $_POST
        //remove body hacks
        
        //remove all the above from inertia core!
	}

?>