<?php

require_once('../helpers/ParseXMLHelper.php');

class FordateController {

	public function getNewsForDate($args){
		return ParseXMLHelper::getAndParseXML(0, 0, '', $args, false);

	}
}