<?php

require_once('../helpers/ParseXMLHelper.php');

class NewskeywordController {

	public function getNewsForkeyword($keyword){
		return ParseXMLHelper::getAndParseXML(false, false, $keyword);

	}


}