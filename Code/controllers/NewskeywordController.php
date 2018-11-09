<?php

require_once('../helpers/ParseXMLHelper.php');

class NewskeywordController {

	public function getNewsForkeyword($keyword){
		return ParseXMLHelper::getAndParseXML(0, 0, $keyword);

	}
}