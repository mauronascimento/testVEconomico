<?php

class ParseXMLHelper {



	public static function getAndParseXML($limit = 0, $offset = 0, $keyword = ''){
		//preciso melhorar muito esse metodo
		$return = array() ;
		$rss = simplexml_load_file(URL_RSS);
		$i = 0;
		foreach ($rss->channel->item as $key => $value) {
			$return['owner'] = (string)$rss->channel->link;
			$return['qtd'] = count($rss->channel->item);
			if($return['qtd'] != 0){
				$return['itens'][$i]['title'] = (string)$value->title;
				$return['itens'][$i]['link'] = (string)$value->link;  
				$return['itens'][$i]['description'] = (string)$value->description;  
				$return['itens'][$i]['data'] = (string)$value->pubDate;
			}
			$i++;
		}

		return $return;
	}
}