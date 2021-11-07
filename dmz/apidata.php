#!/usr/bin/php
<?php

require_once('event_logger.php');

function getcsgo($platform, $id){

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

		return $result;

		//print_r($result->data->segments["0"]->stats->kills->value);
	}
}

function getapex($platform, $id){

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

		return $result;
		
		//print_r($result->data->segments["0"]->stats->kills->value);
		
		}
}
	

function getsplitgate($platform, $id){


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

		return $result;
		
		//print_r($result->data->segments["0"]->stats->kills->value);
		
		}
}

?>
