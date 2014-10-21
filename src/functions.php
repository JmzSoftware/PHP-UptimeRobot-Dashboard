<?php
ini_set('display_errors', '1');

/*

@Author: Adam Matthews
@Date: 20/10/14

Uptime Robot API Scripts

API forked from ckdarby/PHP-UptimeRobot

*/
require_once('UptimeRobot/config.php');
use UptimeRobot\API;

try {

    //Initalizes API with config options
    $api = new API($config);
    //Define parameters for our getMethod request
    $args = [
        'showTimezone' => 1,
        'customUptimeRatio' => '1-7-30'
    ];

    //Makes request to the getMonitor Method
    $results = $api->request('/getMonitors', $args);

    //Output json_decoded contents
    //var_dump($results);

} catch (Exception $e) {
    echo $e->getMessage();
    //Output various debug information
    var_dump($api->debug);
}

// Get Overall all time Uptime Stats. 
function getOverall($results){
	$day = 0;
    $week = 0;
    $month = 0;

    foreach($results as $x){
 		if (is_array($x)){	
	        foreach($x['monitor'] as $y){
	        	$ratios = explode("-",$y['customuptimeratio']);
	        	$day += $ratios[0];
	        	$week += $ratios[1];
	        	$month += $ratios[2];
	        }
	    }
    }

   	$day = round($day / $results["total"],2);
   	$week = round($week / $results["total"],2);
   	$month = round($month / $results["total"],2);

   	$output = compact("day", "week", "month");

    return $output;
}

?>