<?php

class Validatekeyword {


	public static function validate($keyword = ''){
		if(empty($keyword) || !array_key_exists("keyword", $keyword) || ctype_digit($keyword['keyword']))
			return false;
		return filter_var ($keyword['keyword'], FILTER_SANITIZE_STRING); 
	}
}