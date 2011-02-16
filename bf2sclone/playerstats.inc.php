<?php
/* file based queries */
include_once('./queries/getRankByID.php');
include_once('./queries/getArmyByID.php');
include_once('./queries/getUnlockByID.php');
include_once('./queries/getVehicleByID.php');
include_once('./queries/getKitByID.php');
include_once('./queries/getCountryByCode.php');
include_once('./queries/getMapByID.php');
include_once('./queries/getUnlockID.php');


function getPIDFromNick($NICK)
{
	include('./queries/getPID.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());	
	$PID = array();
	while ($row = mysql_fetch_assoc($result)) {
		$PID = $row;
	}	 	
	mysql_free_result($result);
	return $PID['id'];
}

function getRankFromPID($PID)
{
	include('./queries/getRankFromPID.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());	
	$Rank = array();
	$Rank['rank'] = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$Rank = $row;
	}	 	
	mysql_free_result($result);
	return $Rank['rank'];
}

function getNickFromPID($PID)
{
	// Performing SQL query
	include('./queries/getNameFromPID.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
	$player = array();
	$player['name'] = 'N/A'; # if player is not found
	while ($row = mysql_fetch_assoc($result)) {
		$player = $row;
		if ($player['name'] == '')
			$player['name'] = 'N/A'; # if player is not found
	}	 

	// Free resultset
	mysql_free_result($result);
	return $player['name'];
}

function getPlayerDataFromPID($PID)
{
	// Performing SQL query
	include('./queries/getPlayerData.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
	$player = array();
	while($row = mysql_fetch_assoc($result)) 
	{
		$player = $row;
	}	 

	// Free resultset
	mysql_free_result($result);
	return $player;
}

function getFavouriteVictims($PID)
{
	include('./queries/getVictimsByPID.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
	$players = '';
	$idx = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$players[$idx] = $row;
		$idx++;
	}
	// Free resultset
	mysql_free_result($result);
	return $players;
}

function getFavouriteEnemies($PID)
{
	include('./queries/getEnemiesByPID.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
	$players = '';
	$idx = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$players[$idx] = $row;
		$idx++;
	}
	// Free resultset
	mysql_free_result($result);
	return $players;
}

function getArmyData($PID)
{
	include('./queries/getArmiesByPID.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
	$armies = '';
	$idx = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$armies[$idx] = $row;
		$idx++;
	}
	// Free resultset
	mysql_free_result($result);
	return $armies;
}

function getArmySummaries($armies)
{
	$armyCount = getArmyCount();
	
	$summary['total']['time'] = 0;
	$summary['total']['win'] = 0;
	$summary['total']['loss'] = 0;
	$summary['total']['score'] = 0;
	$summary['total']['best'] = 0;
	$summary['total']['worst'] = 0;
	$summary['total']['brnd'] = 0;
	
	for ($i=0; $i<$armyCount; $i++)
	{
		$summary['total']['time'] += $armies[0]['time'.$i];
		$summary['total']['win'] += $armies[0]['win'.$i];
		$summary['total']['loss'] += $armies[0]['loss'.$i];
		$summary['total']['score'] += $armies[0]['score'.$i];
		$summary['total']['best'] += $armies[0]['best'.$i];
		$summary['total']['worst'] += $armies[0]['worst'.$i];
		$summary['total']['brnd'] += $armies[0]['brnd'.$i];
	}
	
	$summary['average']['time'] = round($summary['total']['time']/$armyCount, 2);
	$summary['average']['win'] = round($summary['total']['win']/$armyCount, 2);
	$summary['average']['loss'] = round($summary['total']['loss']/$armyCount, 2);
	$summary['average']['score'] = round($summary['total']['score']/$armyCount, 2);
	$summary['average']['best'] = round($summary['total']['best']/$armyCount, 2);
	$summary['average']['worst'] = round($summary['total']['worst']/$armyCount, 2);
	$summary['average']['brnd'] = round($summary['total']['brnd']/$armyCount, 2);
	
	return $summary;
}

function getUnlocksByPID($PID)
{
	include('./queries/getUnlocksByPID.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
	$unlocks = '';
	$idx = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$unlocks[$row['kit']] = $row['state'];
		$idx++;
	}

	// transform y,n to 0 and 1
	//foreach ($unlocks as $value) {
    //if ($value['state'] == 'y') $value['state'] = 1;
		//else $value['state'] = 0;
	//}
	// Free resultset
	mysql_free_result($result);
	return $unlocks;
}

function getVehicleData($PID)
{
	include('./queries/getVehicleDataByID.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
	$vehicles = '';
	$idx = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$vehicles[$idx] = $row;
		$idx++;
	}
	// Free resultset
	mysql_free_result($result);
	return $vehicles;
}

function getVehicleSummaries($vehicles)
{
	$vehicleCount = getVehicleCount();
	
	$summary['total']['time'] = 0;
	$summary['total']['kills'] = 0;
	$summary['total']['deaths'] = 0;
	$summary['total']['ratio'] = 0;
	$summary['total']['rk'] = 0;
	
	for ($i=0; $i<$vehicleCount; $i++)
	{
		$summary['total']['time'] += $vehicles[0]['time'.$i];
		$summary['total']['kills'] += $vehicles[0]['kills'.$i];
		$summary['total']['deaths'] += $vehicles[0]['deaths'.$i];
		$summary['total']['rk'] += $vehicles[0]['rk'.$i];
	}
	
	$summary['average']['time'] = round($summary['total']['time']/$vehicleCount, 2);
	$summary['average']['kills'] = round($summary['total']['kills']/$vehicleCount, 2);
	$summary['average']['deaths'] = round($summary['total']['deaths']/$vehicleCount, 2);
	if ($summary['total']['kills'])
		$summary['average']['ratio'] = round(($summary['total']['kills']/$summary['total']['kills'])/$vehicleCount, 2);
	else
		$summary['average']['ratio'] = $summary['total']['kills']/$vehicleCount;
	$summary['average']['rk'] = round($summary['total']['rk']/$vehicleCount, 2);

	return $summary;
}

function getWeaponData($PID, $player)
{
	include('./queries/getWeaponDataByID.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
	$SQLweapons = '';
	$weapons = array();
	$idx = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$SQLweapons[$idx] = $row;
		$idx++;
	}
	
	/**
	 init more than enough space ;)
	* * /
	for ($i=0; $i<=17; $i++)
	{
		$weapons[$i]['name'] = '';
		$weapons[$i]['time'] = 0;
		$weapons[$i]['kills'] = 0;
		$weapons[$i]['totalkills'] = 0;
		$weapons[$i]['deaths'] = 0;
		$weapons[$i]['fired'] = 0;
		$weapons[$i]['shot'] = 0;
		$weapons[$i]['hit'] = 0;
		$weapons[$i]['deployed'] = 0;
	}
	*/
	
	$weapons[0]['name'] = 'Assault Rifles';
	$weapons[1]['name'] = 'Grenade Launcher Attachment';
	$weapons[2]['name'] = 'Carbines';
	$weapons[3]['name'] = 'Light Machine Guns';
	$weapons[4]['name'] = 'Sniper Rifles';
	$weapons[5]['name'] = 'Pistols';
	$weapons[6]['name'] = 'AT/AA';
	$weapons[7]['name'] = 'Submachine Guns';
	$weapons[8]['name'] = 'Shotguns';

	for ($i=0; $i<=8; $i++)	
	{
		$weapons[$i]['time'] = $SQLweapons[0]['time'.$i];
		$weapons[$i]['kills'] = $SQLweapons[0]['kills'.$i];
		if ($SQLweapons[0]['kills'.$i])
			$weapons[$i]['totalkills'] = 100*$SQLweapons[0]['kills'.$i]/$player['kills'];
		else
			$weapons[$i]['totalkills'] = 0;
		$weapons[$i]['deaths'] = $SQLweapons[0]['deaths'.$i];
		$weapons[$i]['fired'] = $SQLweapons[0]['fired'.$i];
		$weapons[$i]['hit'] = $SQLweapons[0]['hit'.$i];
	}
	
	$weapons[9]['name'] = 'Knife';
	$weapons[9]['time'] = $SQLweapons[0]['knifetime'];
	$weapons[9]['kills'] = $SQLweapons[0]['knifekills'];
	if ($SQLweapons[0]['knifekills'])
		$weapons[9]['totalkills'] = 100*$SQLweapons[0]['knifekills']/$player['kills'];
	else
		$weapons[9]['totalkills'] = 0;	
	$weapons[9]['deaths'] = $SQLweapons[0]['knifedeaths'];
	$weapons[9]['fired'] = $SQLweapons[0]['knifefired'];
	$weapons[9]['hit'] = $SQLweapons[0]['knifehit'];			
	#$weapons[9]['deployed'] = 0;
	
	$weapons[10]['name'] = 'Defibrillator';
	$weapons[10]['time'] = $SQLweapons[0]['shockpadtime'];
	$weapons[10]['kills'] = $SQLweapons[0]['shockpadkills'];
	if ($SQLweapons[0]['shockpadkills'])
		$weapons[10]['totalkills'] = 100*$SQLweapons[0]['shockpadkills']/$player['kills'];
	else
		$weapons[10]['totalkills'] = 0;	
	$weapons[10]['deaths'] = $SQLweapons[0]['shockpaddeaths'];
	$weapons[10]['fired'] = $SQLweapons[0]['shockpadfired'];
	$weapons[10]['hit'] = $SQLweapons[0]['shockpadhit'];		
	#$weapons[10]['deployed'] = 0;
	
	$weapons[11]['name'] = 'Claymore';
	$weapons[11]['time'] = $SQLweapons[0]['claymoretime'];
	$weapons[11]['kills'] = $SQLweapons[0]['claymorekills'];
	if ($SQLweapons[0]['claymorekills'])
		$weapons[11]['totalkills'] = 100*$SQLweapons[0]['claymorekills']/$player['kills'];
	else
		$weapons[11]['totalkills'] = 0;		
	$weapons[11]['deaths'] = $SQLweapons[0]['claymoredeaths'];
	$weapons[11]['fired'] = $SQLweapons[0]['claymorefired'];
	$weapons[11]['hit'] = $SQLweapons[0]['claymorehit'];	
	#$weapons[11]['deployed'] = 0;
		
	$weapons[12]['name'] = 'Hand Grenade';
	$weapons[12]['time'] = $SQLweapons[0]['handgrenadetime'];
	$weapons[12]['kills'] = $SQLweapons[0]['handgrenadekills'];
	if ($SQLweapons[0]['handgrenadekills'])
		$weapons[12]['totalkills'] = 100*$SQLweapons[0]['handgrenadekills']/$player['kills'];
	else
		$weapons[12]['totalkills'] = 0;		
	$weapons[12]['deaths'] = $SQLweapons[0]['handgrenadedeaths'];
	$weapons[12]['fired'] = $SQLweapons[0]['handgrenadefired'];
	$weapons[12]['hit'] = $SQLweapons[0]['handgrenadehit'];	
	#$weapons[12]['deployed'] = 0;
	
	$weapons[13]['name'] = 'AT Mine';
	$weapons[13]['time'] = $SQLweapons[0]['atminetime'];
	$weapons[13]['kills'] = $SQLweapons[0]['atminekills'];
	if ($SQLweapons[0]['atminekills'])
		$weapons[13]['totalkills'] = 100*$SQLweapons[0]['atminekills']/$player['kills'];
	else
		$weapons[13]['totalkills'] = 0;		
	$weapons[13]['deaths'] = $SQLweapons[0]['atminedeaths'];
	$weapons[13]['fired'] = $SQLweapons[0]['atminefired'];
	$weapons[13]['hit'] = $SQLweapons[0]['atminehit'];		
	#$weapons[13]['deployed'] = 0;

	$weapons[14]['name'] = 'C4';
	$weapons[14]['time'] = $SQLweapons[0]['c4time'];
	$weapons[14]['kills'] = $SQLweapons[0]['c4kills'];
	if ($SQLweapons[0]['c4kills'])
		$weapons[14]['totalkills'] = 100*$SQLweapons[0]['c4kills']/$player['kills'];
	else
		$weapons[14]['totalkills'] = 0;		
	$weapons[14]['deaths'] = $SQLweapons[0]['c4deaths'];
	$weapons[14]['fired'] = $SQLweapons[0]['c4fired'];
	$weapons[14]['hit'] = $SQLweapons[0]['c4hit'];	
	$weapons[14]['fired'] = 0;
	
	$weapons[15]['name'] = 'Tactical (Flash, Smoke)';
	$weapons[15]['time'] = $SQLweapons[0]['tacticaltime'];
	$weapons[15]['kills'] = 0;
	$weapons[15]['deaths'] = 0;
	$weapons[15]['fired'] = $SQLweapons[0]['tacticaldeployed'];
	$weapons[15]['totalkills'] = 0;	

	$weapons[16]['name'] = 'Grappling Hook';
	$weapons[16]['time'] = $SQLweapons[0]['grapplinghooktime'];
	$weapons[16]['kills'] = 0;
	$weapons[16]['deaths'] = $SQLweapons[0]['grapplinghookdeaths'];
	$weapons[16]['fired'] = $SQLweapons[0]['grapplinghookdeployed'];
	$weapons[16]['totalkills'] = 0;	

	$weapons[17]['name'] = 'Zipline';
	$weapons[17]['time'] = $SQLweapons[0]['ziplinetime'];
	$weapons[17]['kills'] = 0;
	$weapons[17]['deaths'] = $SQLweapons[0]['ziplinedeaths'];
	$weapons[17]['fired'] = $SQLweapons[0]['ziplinedeployed'];
	$weapons[17]['totalkills'] = 0;	
	
	
	// Free resultset
	mysql_free_result($result);

	return $weapons;
}

function getWeaponSummary($weapons, $player)
{
	$summary = array();
	$summary['total'] = array();
	$summary['average'] = array();
	$summary['total']['time'] = 0;
	$summary['total']['kills'] = 0;
	$summary['total']['totalkills'] = 0;
	$summary['total']['deaths'] = 0;
	$summary['total']['ratio'] = 0; 
	$summary['total']['acc'] = 0; 
	$summary['total']['fired'] = 0;
	$summary['total']['hit'] = 0;
	
	for ($i=0; $i<=12; $i++)	
	{
		$summary['total']['time'] += $weapons[$i]['time'];
		$summary['total']['kills'] += $weapons[$i]['kills'];
		if ($weapons[$i]['kills'])
			$summary['total']['totalkills'] += $weapons[$i]['kills'];
		
		$summary['total']['deaths'] += $weapons[$i]['deaths'];
		$summary['total']['fired'] += $weapons[$i]['fired'];
		$summary['total']['hit'] += $weapons[$i]['hit'];
		if ($weapons[$i]['deaths'])
			$summary['total']['ratio'] += $weapons[$i]['kills']/$weapons[$i]['deaths'];
		else
			$summary['total']['ratio'] += $weapons[$i]['kills'];
			
		if ($weapons[$i]['hit'])
			$summary['total']['acc'] += $weapons[$i]['fired']/$weapons[$i]['hit'];			
	}
	if ($summary['total']['totalkills']>0)
		$summary['total']['totalkills'] = (100*$player['kills'])/$summary['total']['totalkills'];
	else
		$summary['total']['totalkills'] = ($player['kills']);
	$summary['average']['time'] = $summary['total']['time']/13;
	$summary['average']['kills'] = $summary['total']['kills']/13;
	$summary['average']['deaths'] = $summary['total']['deaths']/13;
	$summary['average']['ratio'] = $summary['total']['ratio']/13;
	$summary['average']['acc'] = $summary['total']['acc']/13;
	$summary['average']['fired'] = $summary['total']['fired']/13;
	$summary['average']['hit'] = $summary['total']['hit']/13;
	
	return $summary;
}

function getEquipmentSummary($weapons, $player)
{
	$summary = array();
	$summary['total'] = array();
	$summary['average'] = array();
	$summary['total']['time'] = 0;
	$summary['total']['kills'] = 0;
	$summary['total']['totalkills'] = 0;
	$summary['total']['deaths'] = 0;
	$summary['total']['ratio'] = 0; 
	$summary['total']['fired'] = 0; 
	
	for ($i=9; $i<=16; $i++)	// equipment = 9-16
	{
		$summary['total']['time'] += $weapons[$i]['time'];
		$summary['total']['kills'] += $weapons[$i]['kills'];
		if ($weapons[$i]['kills'])
			$summary['total']['totalkills'] += $player['kills']/$weapons[$i]['kills'];
		if ($summary['total']['deaths'])
			$summary['total']['ratio'] = $summary['total']['kills']/$summary['total']['deaths'];
		$summary['total']['deaths'] += $weapons[$i]['deaths'];
		$summary['total']['fired'] += $weapons[$i]['fired'];
	}
	$summary['average']['time'] = $summary['total']['time']/13;
	$summary['average']['kills'] = $summary['total']['kills']/13;
	$summary['average']['deaths'] = $summary['total']['deaths']/13;
	$summary['average']['ratio'] = $summary['total']['ratio']/13;
	$summary['average']['fired'] = $summary['total']['fired']/13;
	
	return $summary;
}

function getWeaponID($weapons, $weaponname)
{
	foreach ($weapons as $key => $value)
	{
		if (strcasecmp($value, $weaponname) == 0) return $key; // same but not case sensitive!
	}
}

function getKitData($PID)
{
	include('./queries/getKitDataByPID.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
	$kits = '';
	$idx = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$kits[$idx] = $row;
		$idx++;
	}
	// Free resultset
	mysql_free_result($result);
	return $kits;
}

function getKitSummary($kits, $player)
{
	$summary['total']['time'] = 0;
	$summary['total']['kills'] = 0;
	$summary['total']['deaths'] = 0;
	$summary['total']['totalkills'] = 0; 
		
	for ($i=0; $i<=getKitCount()-1; $i++)
	{
		$summary['total']['time'] += $kits[0]['time'.$i];
		$summary['total']['kills'] += $kits[0]['kills'.$i];
		$summary['total']['totalkills'] += $kits[0]['kills'.$i];
		$summary['total']['deaths'] += $kits[0]['deaths'.$i];
	}
	if ($summary['total']['totalkills'])
		$summary['total']['totalkills'] = $player['kills']/$summary['total']['totalkills'];
	else
		$summary['total']['totalkills'] = $player['kills'];
	
	$summary['average']['time'] = $summary['total']['time']/getKitCount();
  #$summary['average']['totalkills'] = $summary['total']['kills']/getKitCount();
	$summary['average']['kills'] = $summary['total']['kills']/getKitCount();
	$summary['average']['deaths'] = $summary['total']['deaths']/getKitCount();
	if ($summary['total']['deaths'])
		$summary['average']['ratio'] = $summary['total']['kills']/$summary['total']['deaths'];
	else
		$summary['average']['ratio'] = $summary['total']['kills']/13;
	return $summary;	
}

function getPlayerSummary($player, $weapons, $vehicles, $kits, $armies, $maps)
{
	# mensch mach was!
	$summary['weapon'] = 0;
	$summary['vehicle'] = 0;
	$summary['kit'] = 0;
	$summary['army'] = 0;
	$summary['map'] = 0;

	$max = -1;
	#0..12 ()
	for ($i=0; $i<=10; $i++)
	{
		if ($weapons[$i]['time'] > $max)
		{
			$summary['weapon'] = $i;
			$max=$weapons[$i]['time'];
		}
	}
	if (($weapons[11]['time']+$weapons[13]['time']+$weapons[14]['time']) > $max)
	{
		$summary['weapon'] = 11;
		$max = ($weapons[11]['time']+$weapons[13]['time']+$weapons[14]['time']);
	}
	if ($weapons[12]['time'] > $max)
	{
		$summary['weapon'] = 12;
	}
			
	$max = -1;
	for ($i=0; $i<=getKitCount()-1; $i++)
	{
		if ($kits[0]['time'.$i] > $max)
		{
			$summary['kit'] = $i;
			$max=$kits[0]['time'.$i];
		}
	}

	$max = -1;
	for ($i=0; $i<=getVehicleCount()-1; $i++)
	{
		if ($vehicles[0]['time'.$i] > $max)
		{
			$summary['vehicle'] = $i;
			$max=$vehicles[0]['time'.$i];
		}
	}
	
	$max = -1;
	for ($i=0; $i<=getArmyCount(); $i++)
	{
		if ($armies[0]['time'.$i] > $max)
		{
			$summary['army'] = $i;
			$max=$armies[0]['time'.$i];
		}
	}	
	
	return $summary;
}

/**
 * NOTE: you will only see the maps the player has already played -> good for booster packs etc...
 */
function getMapData($PID)
{
	include('./queries/getMapDataByPID.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
	$maps = '';
	$idx = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$maps[$idx] = $row;
		$idx++;
	}
	// Free resultset
	mysql_free_result($result);
	return $maps;
}

function getMapSummary($maps)
{
	$summary = array();
	$summary['total']['time'] = 0;
	$summary['total']['win'] = 0;
	$summary['total']['loss'] = 0;
	$summary['total']['ratio'] = 0;
	$summary['average']['time'] = 0;
	$summary['average']['win'] = 0;
	$summary['average']['loss'] = 0;
	$summary['average']['br'] = 0;		
	for ($i=0; $i<count($maps); $i++)
	{
		$summary['total']['time'] += $maps[$i]['time'];
		$summary['total']['win'] += $maps[$i]['win'];
		$summary['total']['loss'] += $maps[$i]['loss'];
		if ($maps[$i]['loss'])
		{
			$summary['total']['ratio'] += $maps[$i]['win']/$maps[$i]['loss'];
		}
		else
			$summary['total']['ratio'] += $maps[$i]['win'];
		$summary['average']['br'] += $maps[$i]['best'];	
	}
	$summary['average']['time'] =$summary['total']['time']/count($maps);
	$summary['average']['loss'] = round($summary['total']['loss']/count($maps),2);
	$summary['average']['br'] = round($summary['average']['br']/count($maps),0);
	$summary['average']['ratio'] = round($summary['total']['ratio']/count($maps),0);
	return $summary;
}

function getFavouriteMap($PID)
{
	include('./queries/getFavMap.php'); // imports the correct sql statement
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	
	$favmap = '';
	$idx = 0;
	while ($row = mysql_fetch_assoc($result)) {
		$favmap[$idx] = $row;
		$idx++;
	}
	// Free resultset
	mysql_free_result($result);
	return $favmap[0]['mapid'];
}

// === WILSONS ADDED === //

function getNextRankInfo($PID)
{
	// Get player data
	$player = getPlayerDataFromPID($PID);
	
	// Read the lines from the ranks list,a dn assign a key to each rank
	$lines  = file(getcwd()."/queries/ranks.list");
	foreach($lines as $key => $value)
	{
		$rank[$key] = $value;
	}
	unset($lines);
	
	// Read the lines from the ranks points list to assign needed points for each rank
	$lines  = file(getcwd()."/queries/rank_points.list");
	foreach($lines as $key => $value)
	{
		$points[$key] = $value;
	}
	unset($lines);
	
	// Lets get our SPM, very important
	$SPM = round(($player['score'] / intToMins($player['time'])), 1);
	
	// Init a return array
	$return = array();
	
	// Initiate next 3 ranks before checking 1SG, SGM checks
	$NEXT_RANK = array();
	$NEXT_RANK[0] = $player['rank'] + 1;
	$NEXT_RANK[1] = $player['rank'] + 2;
	$NEXT_RANK[2] = $player['rank'] + 3;
	
	// Include the requirements for special ranks, and get the next 3
	include(getcwd()."/queries/nextRankReqs.php");
	$RANK = getNext3($PID, $NEXT_RANK[0], $NEXT_RANK[1], $NEXT_RANK[2]);
	
	// Next rank
	$return[0] = array(
		'rank' => $RANK[0],
		'title' => $rank[$RANK[0]], 
		'rank_points' => $points[$RANK[0]],
		'points_needed' => $points[$RANK[0]] - $player['score'],
		'percent' => getPercent($player['score'], $points[$RANK[0]]),
		'days' => getNextRankDayCount($player['joined'], $player['lastonline'], $player['score'], $points[$RANK[0]]),
		'time_straight' => getNextRankTime($player['score'], $points[$RANK[0]], $SPM)
	);
	
	// 2 ranks away
	$return[1] = array(
		'rank' => $RANK[1],
		'title' => $rank[$RANK[1]], 
		'rank_points' => $points[$RANK[1]],
		'points_needed' => $points[$RANK[1]] - $player['score'],
		'percent' => getPercent($player['score'], $points[$RANK[1]]),
		'days' => getNextRankDayCount($player['joined'], $player['lastonline'], $player['score'], $points[$RANK[1]]),
		'time_straight' => getNextRankTime($player['score'], $points[$RANK[1]], $SPM)
	);
	
	// 3 ranks away
	$return[2] = array(
		'rank' => $RANK[2],
		'title' => $rank[$RANK[2]], 
		'rank_points' => $points[$RANK[2]],
		'points_needed' => $points[$RANK[2]] - $player['score'],
		'percent' => getPercent($player['score'], $points[$RANK[2]]),
		'days' => getNextRankDayCount($player['joined'], $player['lastonline'], $player['score'], $points[$RANK[2]]),
		'time_straight' => getNextRankTime($player['score'], $points[$RANK[2]], $SPM)
	);
	return $return;
}

function getNextRankTime($score, $points_needed, $spm)
{
	
	$temp = ($points_needed - $score) / ($spm / 60);
	$temp = intToTime($temp);
	return $temp;
}

function getNextRankDayCount($joined, $last_seen, $score, $points_needed)
{
	$temp = $last_seen - $joined;
	$days = round(($temp / 86400), 1);
	
	// Score Per Day
	$spd = round(($score / $days), 2);
	
	// Get how many points you need
	$needs = $points_needed - $score;
	
	return round(($needs / $spd), 0);	
}
?>