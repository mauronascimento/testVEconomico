<?php

class ParseXMLHelper {



	public static function getAndParseXML($limit = 0, $offset = 0, $keyword = '', $date = '', $last = false){
		//preciso melhorar muito esse metodo
		$return = array() ;
		$rss = simplexml_load_file(URL_RSS);
		$i = 0;
		foreach ($rss->channel->item as $key => $value) {
			$return['owner'] = (string)$rss->channel->link;
			$count = count($rss->channel->item);
			if($count != 0 && empty($keyword) && empty($date) && empty($last)){
				$return['qtd'] = $count; 
				$return['itens'][$i]['title'] = (string)$value->title;
				$return['itens'][$i]['link'] = (string)$value->link;  
				$return['itens'][$i]['description'] = (string)$value->description;  
				$return['itens'][$i]['data'] = (string)$value->pubDate;
			}
			if(!empty($keyword)){
				$title = (string)$value->title;
				if(stripos($title, $keyword) !== false){
					$return['itens'][$i]['title'] = $title;
					$return['itens'][$i]['link'] = (string)$value->link;  
					$return['itens'][$i]['description'] = (string)$value->description;  
					$return['itens'][$i]['data'] = (string)$value->pubDate;
				}else{
					$return['itens'] = 'no occurrences found';
				}
			}
			
			if($date && !empty($date)){
				$dateorigin = new DateTime($value->pubDate);
				if($dateorigin->format('Y-m-d') >= $date['initialDate'] ||
					(isset($date['initialDate']) ? $dateorigin->format('Y-m-d') <= $date['endDate'] : false)){
					$return['itens'][$i]['title'] = (string)$value->title;
					$return['itens'][$i]['link'] = (string)$value->link;  
					$return['itens'][$i]['description'] = (string)$value->description;  
					$return['itens'][$i]['data'] = (string)$value->pubDate;
				}else{
					$return['itens'] = 'no occurrences found';
				}

			}

			if($last){
				if(!array_key_exists('amountLatHour', $return))
					$return['amountLatHour'] = 0;

				$dateTime1 = new DateTime();
				$dateTime1->format('d M Y H:i:s');
				$dateTime2 = new DateTime($value->pubDate);
				$intervalo = $dateTime1->diff($dateTime2);
				if($intervalo->h == 1)
					$return['amountLatHour']++;
				
			}
			$i++;
		}

		return $return;
	}
}