<?php
// News Lister, http://www.netartmedia.net/newslister
// A software product of NetArt Media, All Rights Reserved
// Find out more about our products and services on:
// http://www.netartmedia.net
// Released under the MIT license
?><?php
define("IN_SCRIPT","1");
//error_reporting(0);
session_start();

require("include/SiteManager.class.php");

/// Connect to the website database

$website = new SiteManager();
$website->SetDataFile("data/listings.xml");
$website->LoadSettings();

function current_url() 
{
	$pageURL = 'http://';
	
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	
	return str_replace("/rss.php","",$pageURL);
}

function filter_text($str_text)
{
	$str_text = str_replace("&nbsp;"," ",$str_text);
	return  preg_replace('~[^a-z\d \-\':/.]~i', '', stripslashes($str_text) );
}
	
echo "<?xml version=\"1.0\" ?>";
echo "<rss version=\"2.0\">";
echo "<channel>\n";
			
echo "<title>".ucwords(str_replace("www.","",$_SERVER["SERVER_NAME"]))." News</title>\n";
echo "<link>".current_url()."</link>\n";
echo "<description> </description>\n";

$listings = simplexml_load_file($website->data_file);

//reversing the array with the news to show the latest first
$xml_results = array();
foreach ($listings->listing as $xml_element) $xml_results[] = $xml_element;
$xml_results = array_reverse($xml_results); 
//end reversing the order of the array
 
 	$iTotResults = 0;
	$listing_counter=sizeof($xml_results); 
	
	foreach ($xml_results as $listing)
	{
		$listing_counter--; 
		
		if($website->settings["website"]["seo_urls"]==1)
		{
			$strLink = current_url()."/"."news-".$website->format_str(strip_tags(stripslashes($listing->title)))."-".$listing_counter.".html";
		}
		else
		{
			$strLink = current_url()."/"."index.php?page=details&id=".$listing_counter;
		}
		
		echo "<item>\n";
		echo "<title>".filter_text(strip_tags(stripslashes($listing->title)))."</title>\n";
		echo "<description>".filter_text($website->text_words(strip_tags(html_entity_decode($listing->description)),80))."</description>\n";
		echo "<link>".$strLink."</link>\n";
		echo "<guid>".$strLink."</guid>\n";
		echo "</item>\n";
	}
	
echo "</channel>\n";	
echo "</rss>\n";
?>