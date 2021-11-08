#!/usr/bin/php
<?php

require_once('event_logger.php');

function getcsgo($platform, $id){
/*
$platform = "steam";
$id = "76561198069180684";
*/
$url = "https://public-api.tracker.gg/v2/csgo/standard/profile/".$platform."/".$id."?TRN-Api-Key=09b1df56-5bb1-4d79-8b7e-da2eb3ffcabe";

$data = file_get_contents($url);

if($data === FALSE){
 		$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DMZ --- " . "error: this profile cannot be shown for legal reasons. The user does not play this game or have their profile private. ". "\n";
      		log_event($event);
      		
            echo "error: this profile cannot be shown for legal reasons. The user does not play this game or have their profile private.";
            return 0;
            
	}
	else{
		$result = json_decode($data);
		
		$kd = floatval($result->data->segments["0"]->stats->kd->value);
		$k = strval(round($kd, 2));
		
		$stats = array();
		
		$stats["kills"] = $result->data->segments["0"]->stats->kills->value;
		$stats["deaths"] = $result->data->segments["0"]->stats->deaths->value;
		$stats["k/d"] = $k;
		$stats["headshots"] = $result->data->segments["0"]->stats->headshots->value;
		$stats["wins"] = $result->data->segments["0"]->stats->wins->value;
		
		return $stats;
	}
}

function getapex($platform, $id){
/*
$platform = "origin";
$id = "FunX10";
*/

$url = "https://public-api.tracker.gg/v2/apex/standard/profile/".$platform."/".$id."?TRN-Api-Key=09b1df56-5bb1-4d79-8b7e-da2eb3ffcabe";

$data = file_get_contents($url);

if($data === FALSE){

		$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DMZ --- " . "error: this profile cannot be shown for legal reasons. The user does not play this game or have their profile private. ". "\n";
      		log_event($event);

            echo "error: this profile cannot be shown for legal reasons. The user does not play this game or have their profile private.";
            return 0;
            
	}
	else{
		$result = json_decode($data);
		
		$stats = array();
		
		$stats["level"] = $result->data->segments["0"]->stats->level->value;
		$stats["kills"] = $result->data->segments["0"]->stats->kills->value;
		$stats["finishers"] = $result->data->segments["0"]->stats->finishers->value;
		$stats["headshots"] = $result->data->segments["0"]->stats->headshots->value;
		$stats["damage"] = $result->data->segments["0"]->stats->damage->value;
		

		return $stats;
		}
}
function getsplitgate($platform, $id){
/*
$platform = "psn";
$id = "ZyoEU";
*/
$url = "https://public-api.tracker.gg/v2/splitgate/standard/profile/".$platform."/".$id."?TRN-Api-Key=09b1df56-5bb1-4d79-8b7e-da2eb3ffcabe";

$data = file_get_contents($url);

if($data === FALSE){

		$event = date("Y-m-d") . "  " . date("h:i:sa") . " --- DMZ --- " . "error: this profile cannot be shown for legal reasons. The user does not play this game or have their profile private. ". "\n";
      		log_event($event);

            echo "error: this profile cannot be shown for legal reasons. The user does not play this game or have their profile private.";
            return 0;
            
	}
	else{
		$result = json_decode($data);

		$kd = floatval($result->data->segments["0"]->stats->kd->value);
		$k = strval(round($kd, 2));
		
		$stats = array();
		
		$stats["kills"] = $result->data->segments["0"]->stats->kills->value;
		$stats["deaths"] = $result->data->segments["0"]->stats->deaths->value;
		$stats["k/d"] = $k;
		$stats["wins"] = $result->data->segments["0"]->stats->wins->value;
		$stats["losses"] = $result->data->segments["0"]->stats->losses->value;
		
		return $stats;
		}
}
?>
