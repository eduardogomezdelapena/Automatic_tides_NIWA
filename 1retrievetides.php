<?php

/*  Step 1/4

This is a modification of the "super simple" script to fetch the tide data from NIWA's API (https://developer.niwa.co.nz/docs/tide-api)
 *   
 *   It cycles through the specified years and months, and retrieves the tide for Tairua beach, NZ.

 *   You can specify other coordinates.

 *	 You must register for an API key at https://developer.niwa.co.nz

 *   Notice that each free API key has a daily limit download.

 *   If you have a valid php environment (with an installed php version 7.4, php7.4-curl)  all you need to do is put your apikey into the script, cd to an empty directory and run in bash terminal
 *
 *   php 1retrievetides.php
 *	 
 */

 //We set the filename as a variable so it changes with years

$years = ["2010","2011"];//,"2012","2013","2014","2015"];


$months = ["01","02","03","04","05","06","07","08","09","10","11","12"];


//Cycle over years

foreach($years as $year){

	// Function that checks wether a year is a leap year or not
if (!function_exists('year_check')){	
	function year_check($my_year)
	{
	
	   if ($my_year % 4 == 0){
	  	  return true;
	  	}
	   else{
	  	  return false;
	  	}
	}
}	
	if (year_check($year)){
		print($year." Is a leap year"."\n");
	} 
	
	
	//Cycle over months
	
	 foreach($months as $month){
	
	 //Match months with number of days;
	
	 	if ($month == "01" || $month == "03" || $month == "05" || $month == "07" || $month == "08" || $month == "10" || $month == "12" ) {
	
	 		$numberOfDays = "31";
	
	 	} elseif ($month == "04" || $month == "06" || $month == "08" || $month == "11"){
	 		$numberOfDays = "30";
	
	 	} elseif ($month == "02" && year_check($year)) {
	 		$numberOfDays = "29";
	
	 	} elseif ($month == "02" &&  year_check($year)==false ) {
	 		$numberOfDays = "28";
	 	}
	
		 $startDate = $year."-".$month."-01";
		
		 echo $startDate."\n";
		 echo "Number of days: ".$numberOfDays."\n";

		 if (!is_dir($year)) {
    		mkdir($year, 0777, true);
			}
	
		 $fp = fopen($year."/".$startDate."_tide_NIWA.csv", 'w');
		 $curl = curl_init();

		 	// These are the coordinates for Tairua beach
		
			$lat = -36.992459298976264;
			$long =	175.8597843457126;

			// Get data every 60 minutes
			$interval= 60;

			$apikey = "";
			
			if ($apikey == "") {
				echo "No API key specified. Register for an API key at https://developer.niwa.co.nz\n";
				die;
			}
	
		    curl_setopt($curl, CURLOPT_URL, "https://api.niwa.co.nz/tides/data?lat=".$lat."&long=".$long."&startDate=".$startDate."&interval=".$interval."&datum=MSL&numberOfDays=".$numberOfDays."&apikey=".$apikey);
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_TIMEOUT, 50);
			// write curl urlesponse to file
			curl_setopt($curl, CURLOPT_FILE, $fp); 
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		
		
		
		    $result = curl_exec($curl);
		
		    curl_close($curl);
			fclose($fp);
	
	}
}
