<?php

class XmlhandlerComponent extends Object {
	
   var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Ofc', 'Unitcalc', 'Xls');
   var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Unitcalc');

   function readrss($xmlurl, $output = 'array', $amount = 2, $utm_medium = 'newsletter' )
   {
	  if ( isset( $xmlurl ) )
	  {	
		  $doc = new DOMDocument();
		  @	$doc->load($xmlurl);
		  $arrFeeds = array();
		  $htmlFeeds = $textFeeds = '';
		  $i = 0;
		  
		  if ( isset( $utm_medium ) ) $utm_medium = '?utm_source=tricoretraining.com&utm_medium='. $utm_medium;
		  
		  foreach ($doc->getElementsByTagName('item') as $node) 
		  {
		    $itemRSS = array ( 
		      'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
		      'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
		      'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
		      'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
		      );
			$htmlFeeds .= '<li><a href="' . $itemRSS['link'] . $utm_medium . '" target="_blank">' . 
				$itemRSS['title'] . '</a></li>';
			$textFeeds .= '* ' . $itemRSS['title'] . "\n" .
				$itemRSS['link'] . "\n\n";
				  
		    array_push($arrFeeds, $itemRSS);
		    if ( $i == $amount ) break;
		    $i++;
		  }
		  
		  $RSSFeeds['html'] = $htmlFeeds;
		  $RSSFeeds['text'] = $textFeeds;
	  }

	  if ( isset( $arrFeeds ) && is_array( $arrFeeds ) )
	  {
			if ( $output == 'html' )
				return $RSSFeeds;
			else
	  			return $arrFeeds;
	  } else 
	  		return false;
	
   }

}

?>