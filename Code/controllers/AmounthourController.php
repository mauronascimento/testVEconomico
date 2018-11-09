<?php

require_once('../helpers/ParseXMLHelper.php');

class AmounthourController {

	public function getCountLatsHour(){
		return ParseXMLHelper::getAndParseXML(0, 0, '', '', true);

	}
}