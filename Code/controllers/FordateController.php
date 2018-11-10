<?php

require_once('../helpers/ParseXMLHelper.php');

class FordateController {

	public function getNewsForDate(){
		return ParseXMLHelper::getAndParseXML(0, 0, '', '', true);

	}
}