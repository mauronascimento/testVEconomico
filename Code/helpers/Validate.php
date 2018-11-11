<?php

class Validate {


	public static function validateKeyword($keyword = ''){
		if(empty($keyword) || !array_key_exists("keyword", $keyword) || ctype_digit($keyword['keyword']))
			return false;
		return filter_var($keyword['keyword'], FILTER_SANITIZE_STRING); 
	}

	public static function validateDate($forDate = '', $format = 'Y-m-d'){

		if(empty($forDate) || !array_key_exists("initialDate", $forDate))
			return false;
		
		$di = DateTime::createFromFormat($format, $forDate['initialDate']);

		if(array_key_exists("endDate", $forDate) && !empty($forDate['endDate']) && $forDate['endDate'] != '{endDate}'){
			$de = DateTime::createFromFormat($format, $forDate['endDate']);
			$vde = $de && ($de->format($format) == $forDate['endDate']) 
					&& ($forDate['endDate'] >= $forDate['initialDate']);
			return $di && ($di->format($format) == $forDate['initialDate']) && $vde;
		}

		return $di && ($di->format($format) == $forDate['initialDate']);
	}
}