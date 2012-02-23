<?php
/*
Plugin Name: knolleary functions
Description: Some useful functions that I couldn't find elsewhere
Author: Nick O'Leary	
Version: 1.0
Author URI: http://knolleary.net
*/


function wp_knolleary_time_since($date) {
 $second = 1; 
 $minute = 60;
 $hour   = 3600;
 $day    = 86400; 
 $week   = 604800; 
 $month  = 2419200;
 $year   = 883008000;
echo time();
 $delta = time() - $date;
 if ($delta < $minute) {
  return "seconds ago";
 } else if ($delta < $hour) {
  $minutes = round($delta/$minute);
  if ($minutes == 1) {
   return "1 minute ago";
  } else {
   return "$minutes minutes ago";
  }
 } else if ($delta < $day) {
  $hours = round($delta/$hour);
  if ($hours == 1) {
   return "1 hour ago";
  } else {
   return "$hours hours ago";
  }
 } else if ($delta < $week) {
  $days = round($delta/$day);
  if ($days == 1) {
   return "1 day ago";
  } else {
   return "$days days ago";
  }
 } else if ($delta < $month) {
  $weeks = round($delta/$week);
  if ($weeks == 1) {
   return "1 week ago";
  } else {
   return "$weeks weeks ago";
  }
 } else if ($delta < 2*$year) {
  $months = round($delta/$month);
  if ($months == 1) {
   return "1 month ago";
  } else {
   return "$months months ago";
  }
 } else { 
  $years = round($delta/$year);
  if ($years == 1) {
   return "1 year ago";
  } else {
   return "$years years ago";
  }
 }
}

function wp_knolleary_get_expensive_country_code($lat,$long) {
   $curl = curl_init();
   curl_setopt ($curl, CURLOPT_URL, "http://ws.geonames.org/countryCode?lat=$lat&lng=$long");
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   $result = curl_exec ($curl);
   curl_close ($curl);
   return $result;
}


$wp_knolleary_is_mobile = false;

function wp_knolleary_init() {
   
   global $wp_knolleary_is_mobile;
   $useragents = array("iPhone","iPod","Android","blackberry",
      "webOS","Googlebot-Mobile"
      );
   
   foreach ( $useragents as $ua ) {
      if (preg_match('/$ua/i',$_SERVER['HTTP_USER_AGENT'])) {
         $wp_knolleary_is_mobile = true;
         break;
      }
      
   }
}

function wp_knolleary_is_mobile() {
   global $wp_knolleary_is_mobile;
   return $wp_knolleary_is_mobile;
}

function wp_knolleary_shrink_flickr_images($content) {
   if (wp_knolleary_is_mobile()) {
      return preg_replace('/(static\.?flickr.com\/.*?\/[^_]*?_[^_]*?)(\.jpg)/',"$1_m$2",$content);
   } else {
      return $content;
   }
}

add_filter( 'init', 'wp_knolleary_init');
add_filter( 'the_content', 'wp_knolleary_shrink_flickr_images');




?>
