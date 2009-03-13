<?php

/* identifier.core.php
 *
 *
 *
 * function email($str){return preg_replace('/^(.*)\/(.*)/', '$2@$1', $str);}
 * Authors: Sandeep Shetty email('gmail.com/sandeep.shetty')
 *
 * Copyright (C) 2005 - date('Y') Collaboration Science,
 * http://collaborationscience.com/
 *
 * This file is part of Inertia.
 *
 * Inertia is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option)
 * any later version.
 *
 * Inertia is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * To read the license please visit http://www.gnu.org/copyleft/gpl.html
 *
 *
 *----------------------------------------------------------------------------
 */


	function sub_segments_($path, $start, $length=NULL)
	{
		$segments = explode('/', $path);
		if (is_equal_(substr($path, 0, 1), '/')) array_shift($segments);
		$sub_segments = (is_null($length)) ? array_slice($segments, $start) : array_slice($segments, $start, $length);
		if (empty($sub_segments)) return false;
		return $sub_segments;
	}


	function sub_segment_($path, $index=0)
	{
		if ($sub_segments = sub_segments_($path, $index, 1)) return $sub_segments[0];
		return false;
	}


	function segment_count_($path)
	{
		return ($sub_segments = sub_segments_($path, 0)) ? count($sub_segments) : 0;
	}


	function sub_path_($path, $start, $length=NULL)
	{
		$slash = (is_equal_(substr($path, 0, 1), '/')) ? '/' : '';
		return ($sub_segments = sub_segments_($path, $start, $length)) ? $slash.implode("/", $sub_segments) : false;
	}

?>