<?php
require_once('../helpers/ParseXMLHelper.php');

class AllnewsController {

	public function getAllNews(){
		return ParseXMLHelper::getAndParseXML();

	}


}