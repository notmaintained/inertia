<?php

	function test_retest_count_of_untested_lines()
	{
		should_return(8, when_passed(array('file1'=>array(1, 2), 'file2'=>array(1, 2, 3), 'file3'=>array(1, 2, 3))));
	}

?>